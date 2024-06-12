<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'apps_menu';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'id_menu',
        'nama_menu',
        'is_master',
        'master_menu',
        'status_menu',
        'icon',
        'keterangan',
        'created_at',
        'updated_at',
    ];
}
