<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Chats;
use App\Models\User;
use App\Models\Messages;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Models\UserDetails;

class ChatsController extends Controller
{
    public function index(){
        $locale = session('locale', 'ru');
        App::setLocale($locale);
        $user = User::get();
        $user_details = UserDetails::where('user_id', '=', $user->id)->first();
        $token = User::get_token();
        $chats = Chats::get();
        $chat_ids = Chats::ids();

       // User::generateUserKeys();
        return view('chat.chat', ['user' => $user, 'user_details' => $user_details,'chats' => $chats, 'chat_ids' => $chat_ids, 'token' => $token, 'locale' => $locale]);
    }

    public function index_with_id($chat_id){
        $locale = session('locale', 'ru');
        App::setLocale($locale);


        $user = User::get();
        $user_details = UserDetails::where('user_id', '=', $user->id)->first();
        $token = User::get_token();
        
        $chats = Chats::get();
        $chat_ids = Chats::ids();
        $chat_selected = Chats::details($chat_id);
        \DB::table('messages')
        ->where('chat_id', $chat_id)
        ->where('sender_id', '!=', $user->id)
        ->where('status_id', '!=', 3)
        ->update(['status_id' => 3]);
        return view('chat.chat', ['user' => $user, 'user_details' => $user_details, 'chats' => $chats, 'chat_details' => $chat_selected, 'chat_selected' => $chat_id, 'chat_ids' => $chat_ids, 'token' => $token, 'locale' => $locale]);
    }

    public function send_message(Request $request)
    {
        // Получаем данные
        $message = $request->input('message');
        $chat_id = $request->input('chat_id');
        $is_new_chat = $request->input('is_new_chat');
        $new_chat_user_id = $request->input('new_chat_user_id');
        $new_chat_id = $request->input('new_chat_id');
        
        $sender_id = User::id();
        $recipient_id = Chats::recipient_id($chat_id);
        $created_at = now();

        if($is_new_chat){
            $chat = Chats::create_new_chat($new_chat_user_id, $new_chat_id);

            if($chat){
                $message_id = Messages::sendMessage($new_chat_id, $sender_id, $message, $new_chat_user_id);
            }
        }
        else{
            if (!$message || !$chat_id) {
                return response()->json(['error' => 'Нет данных'], 400);
            }
            
            try {
                $message_id = Messages::sendMessage($chat_id, $sender_id, $message, $recipient_id);
    
                broadcast(new MessageSent($chat_id, $sender_id, $message, $message_id, $created_at))->toOthers();
            } catch (\Throwable $th) {
                return response()->json(['message' => $th, 'data' => $message]);
            }
        }

        

        return response()->json(['message' => 'Сообщение отправлено', 'data' => $message]);
    }


    public function get_new_temp_chat_id(){


        try {
            $new_chat_id = Chats::get_new_id();

            return json_encode(['seccess' => true ,'new_chat_id' => $new_chat_id]);
        } catch (\Throwable $th) {
            return json_encode(['seccess' => false]);
        }
    }
}
