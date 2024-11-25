<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ChatMembers;

class Chats extends Model
{
    use HasFactory;

    protected $table = 'chats';

    protected $fillable = ['id', 'chat_type_id','updated_at', 'created_at'];

    protected $hidden = [];

    protected $primaryKey = 'id';  
    public $incrementing = false;
    protected $keyType = 'string';

    public function newUniqueId(): string
{
    return (string) Uuid::uuid4();
}

public function uniqueIds(): array
{
    return ['id', 'discount_code'];
}

    protected function get(){
        if(User::has()){
            $user = User::get();

            $authUserId = $user->id;

            $chats = DB::table('chats')
    ->join('chat_members', 'chats.id', '=', 'chat_members.chat_id')
    ->join('users', 'chat_members.user_id', '=', 'users.id')
    ->leftJoin('messages', function ($join) {
        $join->on('chats.id', '=', 'messages.chat_id')
             ->whereRaw('messages.created_at = (
                 SELECT MAX(created_at)
                 FROM messages
                 WHERE messages.chat_id = chats.id
             )');
    })
    ->leftJoin('chat_members as cm', 'chats.id', '=', 'cm.chat_id')
    ->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')
    ->whereIn('chats.id', function ($query) use ($authUserId) {
        $query->select('chat_id')
              ->from('chat_members')
              ->where('user_id', $authUserId);
    })
    ->where(function ($query) {
        $query->where('cm.user_id', '!=', DB::raw('messages.sender_id'))
              ->orWhereNull('messages.sender_id');
    })
    ->where('users.id', '!=', $authUserId)
    ->select(
        'chats.id as chat_id',
        'users.id as user_id',
        'user_details.nickname as nickname',
        'messages.id as message_id',
        'cm.user_id as recipient_id',
        'messages.encrypted_content as last_message',
        'messages.created_at as message_time',
        'user_details.avatar_path as avatar_path',
        DB::raw('(SELECT COUNT(*) 
                  FROM messages 
                  WHERE messages.sender_id = users.id 
                    AND messages.chat_id = chats.id 
                    AND messages.status_id = 2) as unread_message_count')
    )
    ->orderBy('messages.created_at', 'DESC')
    ->get();
    $chats = $chats->unique('chat_id');
            return $chats;
        }
        else{
            return null;
        }
    }

    protected function get_new_id(): string{
        $id = "";
        $isPassed = false;

        while(!$isPassed){
            $id = (string) Str::uuid();

            $chat = DB::table('chats')->select('chats.id')->where('chats.id', '=' , $id)->first();

            if(!$chat) $isPassed = true; 
        }

        return $id;
    }

    protected function details($chat_id){
        if(User::has()){
            $user_id = User::id();

            if (!User::has_access_chat($chat_id)) {
                return null;
            }

            // Получаем детали чата
            $chatDetails = DB::table('chats')
                ->join('chat_members as cm1', 'chats.id', '=', 'cm1.chat_id')  // Соединяем таблицу chat_members для текущего пользователя
                ->join('chat_members as cm2', 'chats.id', '=', 'cm2.chat_id')  // Соединяем таблицу chat_members для собеседника
                ->join('users as u', 'cm2.user_id', '=', 'u.id')  // Получаем данные собеседника
                ->leftJoin('user_details', 'user_details.user_id', '=', 'u.id')
                ->select('u.id as user_id' ,'user_details.nickname as username', 'chats.id as chat_id', 'cm2.user_id as recipient_id')
                ->where('cm1.user_id', '=', $user_id)  // Условие: текущий пользователь является членом чата
                ->where('cm2.user_id', '!=', $user_id)  // Условие: другой пользователь (собеседник) в этом чате
                ->where('chats.id', '=', $chat_id)
                ->first();  // Получаем данные одного чата

            // Получаем список сообщений
            $messages = DB::table('messages')
                ->join('users as sender', 'messages.sender_id', '=', 'sender.id')  // Присоединяем данные отправителя
                ->join('chat_members as cm', 'messages.chat_id', '=', 'cm.chat_id')  // Соединяем chat_members для получения получателя
                ->leftJoin('user_details', 'user_details.user_id', '=', 'sender.id')
                ->select('messages.id', 'messages.encrypted_content', 'messages.created_at', 'user_details.nickname as sender', 'messages.sender_id', 'cm.user_id as recipient_id', 'user_details.avatar_path as avatar_path')
                ->where('messages.chat_id', '=', $chat_id)
                ->where('cm.user_id', '!=', DB::raw('messages.sender_id'))  // Получатель не является отправителем
                ->orderBy('messages.created_at', 'asc')
                ->get();  // Получаем все сообщения в чате

            // Возвращаем данные чата и сообщения
            return (object)[
                'details' => (object)$chatDetails,
                'messages' => (object)$messages
            ];

        }
        else{
            return null;
        }
    }

    protected function ids(){
        if(User::has()){
            $user = User::get();

            $authUserId = $user->id;

            $chat_ids = DB::table('chats')
                ->join('chat_members', 'chats.id', '=', 'chat_members.chat_id')
                ->join('users', 'chat_members.user_id', '=', 'users.id')
                ->where('users.id', '=', $authUserId)
                ->select('chats.id as chat_id')
                ->get();
               
            return $chat_ids;
        }
        else{
            return null;
        }
    }

    protected function recipient_id($chat_id){
        if(User::has()){
            $user_id = User::id();

            if (!User::has_access_chat($chat_id)) {
                return null;
            }

            // Получаем детали чата
            $chatDetails = DB::table('chats')
                ->join('chat_members as cm1', 'chats.id', '=', 'cm1.chat_id')  // Соединяем таблицу chat_members для текущего пользователя
                ->join('chat_members as cm2', 'chats.id', '=', 'cm2.chat_id')  // Соединяем таблицу chat_members для собеседника
                ->join('users as u', 'cm2.user_id', '=', 'u.id')  // Получаем данные собеседника
                ->select('u.id as user_id' ,'u.username', 'chats.id as chat_id', 'cm2.user_id as recipient_id')
                ->where('cm1.user_id', '=', $user_id)  // Условие: текущий пользователь является членом чата
                ->where('cm2.user_id', '!=', $user_id)  // Условие: другой пользователь (собеседник) в этом чате
                ->where('chats.id', '=', $chat_id)
                ->first();  // Получаем данные одного чата

            // Возвращаем данные чата и сообщения
            return $chatDetails->recipient_id;

        }
        else{
            return null;
        }
    }

    protected function has_access($chat_id, $user_id){
        $chat_test = ChatMembers::where('chat_members.user_id', '=', $user_id)
                                ->where('chat_members.chat_id', '=', $chat_id)
                                ->first();

        if($chat_test == null){
            return false;
        }
        return true;
    }

    protected function create_new_chat($user_id, $chat_id){
        $self_user = Auth::user();

        // Проверяем, существует ли личный чат между двумя пользователями
        $chat = DB::table('chats')
            ->join('chat_members as cm1', 'chats.id', '=', 'cm1.chat_id')
            ->join('chat_members as cm2', 'chats.id', '=', 'cm2.chat_id')
            ->where('cm1.user_id', $self_user->id)
            ->where('cm2.user_id', $user_id)
            ->where('chats.chat_type_id', 1) // Тип "личный"
            ->groupBy('chats.id') // Группировка по идентификатору чата
            ->havingRaw('COUNT(chats.id) = 2') // Проверка, что в чате два участника
            ->select('chats.id') // Только выбираем чат ID
            ->first();

        if(!$chat){
            $new_chat = Chats::create([
                'id' => $chat_id,
                'chat_type_id' => 1,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ]);

            ChatMembers::create([
                'chat_id' => $chat_id,
                'user_id' => $user_id,
                'joined_at' => Carbon::now()
            ]);

            ChatMembers::create([
                'chat_id' => $chat_id,
                'user_id' => $self_user->id,
                'joined_at' => Carbon::now()
            ]);

            return $new_chat;
        }

        return null;
    }
}
