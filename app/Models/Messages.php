<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class Messages extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = ['id', 'chat_id', 'sender_id', 'enctypted_content', 'message_type_id', 'created_at', 'status_id'];

    protected $hidden = [];

    protected $primaryKey = 'id';  
    public $incrementing = false;
    protected $keyType = 'string';



    public static function sendMessage($chatId, $senderId, $messageContent, $recipientId)
    {
        
        // Получаем публичный ключ получателя
        $publicKey = DB::table('devices')
            ->where('devices.user_id', $recipientId)
            ->value('devices.public_key');

        // Шифруем сообщение с использованием публичного ключа
        openssl_public_encrypt($messageContent, $encryptedMessage, $publicKey);
   
        $messageId = (string) Str::uuid();
        // Сохраняем зашифрованное сообщение в таблицу messages
        DB::table('messages')->insertGetId([
            'id' => $messageId,
            'chat_id' => $chatId,
            'sender_id' => $senderId,
            'message_type_id' => 1,
            'encrypted_content' => base64_encode($encryptedMessage),
            'created_at' => now(),
            'status_id' => 2
        ]);

        // Шифруем ключ для каждого получателя
        openssl_public_encrypt($messageContent, $encryptedKey, $publicKey);

        // Сохраняем зашифрованный ключ в таблицу message_keys
        DB::table('message_keys')->insert([
            'message_id' => $messageId,
            'recipient_id' => $recipientId,
            'encrypted_key' => base64_encode($encryptedKey),
            'created_at' => now(),
        ]);

        return $messageId;
    }

    public static function receiveMessage($messageId, $userId)
    {
        // Получаем зашифрованное сообщение и ключ для пользователя
        $encryptedMessage = DB::table('messages')
            ->where('id', $messageId)
            ->value('encrypted_content');
             
        $encryptedKey = DB::table('message_keys')
            ->where('message_id', $messageId)
            ->where('recipient_id', $userId)
            ->value('encrypted_key');
           
        // Получаем зашифрованный приватный ключ пользователя
        $encryptedPrivateKey = DB::table('device_keys')
            ->join('devices', 'device_keys.device_id', '=', 'devices.id')
            ->where('devices.user_id', $userId)
            ->value('device_keys.private_key_encrypted');
          
        // Расшифровываем приватный ключ
        $privateKey = Crypt::decrypt($encryptedPrivateKey);
    
        // Расшифровываем ключ сообщения
        openssl_private_decrypt(base64_decode($encryptedKey), $decryptedKey, $privateKey);
    
        // Расшифровываем само сообщение
        openssl_private_decrypt(base64_decode($encryptedMessage), $decryptedMessage, $privateKey);
    
        return $decryptedMessage;
    }
}
