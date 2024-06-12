<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesMenu extends Model
{
    use HasFactory;
    protected $table = 'apps_akses_menu';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'id_akses_menu',
        'role_id',
        'menu_id',
        'created_at',
        'updated_at',
    ];
}
