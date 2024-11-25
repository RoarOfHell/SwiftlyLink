<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\Devices;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index(){
        return view('auth/registration');
    }

    public function submit(Request $request){
        // Создание пользователя
        if($request->password == $request->repeat_password){
            $new_user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $user = User::where('email', $new_user->email)->where('created_at', $new_user->created_at)->first();

            UserDetails::create([
                'user_id' => $user->id,
                'tag' => $request->username,
                'nickname' => $request->username,
                'avatar_path' => null,

            ]);

            Devices::generateUserKeys($user->id);
    
            return redirect()->route('login');
        }
        else{
            return view('auth.registration', ['error' => "Пароли не совпадают!"]);
        }
    }
}
