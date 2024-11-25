<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceKeys extends Model
{
    use HasFactory;

    protected $table = 'device_keys';

    protected $fillable = ['id', 'device_id','private_key_enncrypted', 'created_at'];

    protected $hidden = [];
}
