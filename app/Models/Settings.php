<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = ['id', 'chat_id', 'sender_id', 'enctypted_content', 'message_type_id', 'created_at', 'status_id'];

    protected $hidden = [];
}
