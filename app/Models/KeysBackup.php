<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeysBackup extends Model
{
    use HasFactory;

    protected $table = 'keys_backup';

    protected $fillable = ['id', 'user_id', 'backup_data', 'created_at', 'last_restored_at'];

    protected $hidden = [];
}
