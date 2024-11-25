<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    use HasFactory;

    protected $table = 'sessions';

    protected $fillable = ['id', 'user_id', 'device_id', 'token', 'created_at', 'expires_at'];

    protected $hidden = [];
}
