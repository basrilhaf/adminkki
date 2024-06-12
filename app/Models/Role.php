<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'apps_role';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'id_role',
        'nama_role',
        'kode_role',
        'keterangan_role',
        'created_at',
        'updated_at',
    ];
}
