<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){
        $isAuth = false;
        if(User::has()){
            $isAuth = true;
        }

        return view('main.main', ['isAuth' => $isAuth]);
    }

    public function test(){
        return view('main.test');
    }
}
