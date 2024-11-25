<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTypes extends Model
{
    use HasFactory;

    protected $table = 'message_type';

    protected $fillable = ['id', 'type'];

    protected $hidden = [];
}
