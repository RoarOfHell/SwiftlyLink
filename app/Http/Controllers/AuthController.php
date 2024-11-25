<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\PersonalAccessTocken;

class AuthController extends Controller
{
    public function index(){
        
        return view('auth/login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $userId = $user->id;
            $token = PersonalAccessTocken::getUserToken($userId);

            return response()->json(['token' => $token]);
        }
        return response()->json(["error" => 'Неправильный логин или пароль']);
    }

    public function postSignin(Request $request)
    {
	    if (! Auth::attempt($request->only('email', 'password'), $request->has('remember')))
		{
			return view('auth.login', ["error" => 'Неправильный логин или пароль']);
		}
		else {
		    $user = Auth::user();
            $user->update([
                'status' => 'online',
                'last_login_at' => now(),
            ]);

            $userId = $user->id;
            $token = PersonalAccessTocken::getUserToken($userId);

            Session::put('user', $user);
            return redirect()->route('chat');
        }
    }

	public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $user->update(['status' => 'offline']);
        }

        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}
