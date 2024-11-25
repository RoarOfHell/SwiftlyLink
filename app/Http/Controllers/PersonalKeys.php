<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonalKeys extends Controller
{
    public function get(Request $request){
        $token = $request->bearerToken();
       
        $user_person_token = DB::table('personal_access_tokens')->where('personal_access_tokens.token', '=', $token)->first();
       
        $keys = DB::connection('swiftlylink_vpn')->table('vpn_keys')
        ->leftJoin('users4vpn_keys', 'users4vpn_keys.vpn_key_id', '=' , 'vpn_keys.id')
        ->where("users4vpn_keys.user_id", '=', "$user_person_token->tokenable_id")->get();


        return response()->json(['keys' => $keys]);
    }
}
