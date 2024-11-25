<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatTypes extends Model
{
    use HasFactory;

    protected $table = 'chat_types';

    protected $fillable = ['id', 'type'];

    protected $hidden = [];
}
