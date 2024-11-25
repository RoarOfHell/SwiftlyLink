<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
       
        $storedToken = DB::table('personal_access_tokens')->where('token', $token)->first();
        
        if (!$storedToken || Carbon::now()->greaterThan($storedToken->expires_at)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        Auth::loginUsingId($storedToken->tokenable_id);
        
        return $next($request);
    }
}
