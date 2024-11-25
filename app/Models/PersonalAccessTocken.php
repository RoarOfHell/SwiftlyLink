<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class PersonalAccessTocken extends Model
{
    use HasFactory;

    protected $table = 'personal_access_tokens';

    protected $fillable = ['id', 'tokenable_type ', 'tokenable_id', 'name', 'token', 'abilities', 'last_used_at', 'expires_at', 'created_at', 'updated_at'];

    protected $hidden = [];

    protected function getUserToken($userId){
        $existingToken = DB::table('personal_access_tokens')
                ->where('tokenable_id', $userId)
                ->where('expires_at', '>', Carbon::now())
                ->first();
                    
            if ($existingToken) {
                // Если токен уже существует и не истек, возвращаем его
               return $existingToken->token;

            } else {
                // Создаем новый токен, если его нет или он истек
                $token = Str::random(64);
                $expiration = Carbon::now()->addYear(5);
                $crated_at = Carbon::now();
                DB::table('personal_access_tokens')->insert([
                    'tokenable_type' => 'App\Models\User',
                    'tokenable_id' => $userId,
                    'name' => 'swiftlylink',
                    'token' => hash('sha256', $token),
                    'abilities' => '["*"]',
                    'expires_at' => $expiration,
                    'created_at' => $crated_at,
                    'updated_at' => $crated_at
                ]);
               return $token;
               
            }
    }
}
