<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMembers extends Model
{
    use HasFactory;

    protected $table = 'chat_members';

    protected $fillable = ['id', 'chat_id', 'user_id', 'role_id','joined_at', 'updated_at', 'created_at'];

    protected $hidden = [];
}
