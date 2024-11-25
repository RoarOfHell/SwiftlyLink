<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\PersonalAccessTocken;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'users'; // Укажите имя вашей таблицы

    protected $fillable = ['id', 'username', 'email', 'password', 'status', 'updated_at', 'last_login_at', 'created_at'];

    protected $hidden = ['password'];

    protected $primaryKey = 'id';  
    public $incrementing = false;
    protected $keyType = 'string';

    public function isOnline($user_id)
    {
        $user = self::find($user_id);

        if($user && $user->status == 'online'){
            return true;
        }

        return false;
    }

    protected function id(){
        if(Session::has('user')){
            $user = Session::get('user');
            return $user->id;
        }
        else{
            return null;
        }
    }

    protected function get(){
        if(Auth::user()){
            return Auth::user();
        }
        else{
            return "null";
        }
        
    }
    

    protected function has(){
        if(Session::has('user')){
            return true;
        }
        else{
            return false;
        }
    }

    protected function has_access_chat($chat_id){
        if(User::has()){
            $user_id = User::id();
            $hasAccess = DB::table('chat_members')
            ->where('chat_id', '=', $chat_id)
            ->where('user_id', '=', $user_id)
            ->exists();
            return $hasAccess;
        }
        else{
            false;
        }        
    }

    protected function get_token(){
        if(Auth::user()){
            $user = Auth::user();
            $token = PersonalAccessTocken::where('tokenable_id', $user->id)->get()->first();
            if(!$token) return '';
            return $token->token;
        }
        else{
            return null;
        }
    }
}
