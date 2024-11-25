<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class Devices extends Model
{
    use HasFactory;

    protected $table = 'devices';

    protected $fillable = ['id', 'user_id','public_key', 'device_name', 'device_type','created_at'];

    protected $hidden = [];

    protected function generateUserKeys($user_id)
    {
        // Генерация пары ключей
        $privateKey = openssl_pkey_new();
        openssl_pkey_export($privateKey, $privateKeyString);
        $publicKey = openssl_pkey_get_details($privateKey)['key'];

        $deviceId = (string) Str::uuid();

        DB::table('devices')->insertGetId([
            'id' => $deviceId,
            'user_id' => $user_id,
            'public_key' =>$publicKey,
            'device_name' => 'test',
            'device_type' => 'test',
            'created_at' => now()
        ]);

        // Шифрование приватного ключа перед сохранением
        $encryptedPrivateKey = Crypt::encrypt($privateKeyString);

        // Сохранение ключей
        DB::table('device_keys')->insert([
            'device_id' => $deviceId,
            'private_key_encrypted' => $encryptedPrivateKey,
            'created_at' => now(),
        ]);
    }
}
