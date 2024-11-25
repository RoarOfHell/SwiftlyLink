<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $fillable = ['id', 'message_id','encrypted_file_path', 'file_type', 'created_at'];

    protected $hidden = [];
}
