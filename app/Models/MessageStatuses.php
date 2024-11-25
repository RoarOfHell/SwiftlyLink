<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageStatuses extends Model
{
    use HasFactory;

    protected $table = 'message_statuses';

    protected $fillable = ['id', 'status'];

    protected $hidden = [];
}
