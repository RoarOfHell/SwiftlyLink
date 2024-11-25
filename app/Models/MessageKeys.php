<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageKeys extends Model
{
    use HasFactory;

    protected $table = 'message_keys';

    protected $fillable = ['id', 'message_id', 'recipiet_id', 'encrypted_key', 'created_at'];

    protected $hidden = [];
}
