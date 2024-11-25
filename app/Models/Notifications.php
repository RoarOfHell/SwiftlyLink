<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = ['id', 'user_id', 'type_id', 'content', 'is_read', 'created_at'];

    protected $hidden = [];
}
