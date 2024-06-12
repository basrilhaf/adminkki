<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'apps_user';

    protected $fillable = [
        'id_user',
        'username',
        'password',
        'email',
        'role_id',
        'jenis_kelamin',
        'no_telepon',
        'alamat',
        'created_at',
        'updated_at',
    ];
}
