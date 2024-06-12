<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 't_task';
    protected $primaryKey = 'id_task';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_task',
        'nama_task',
        'tanggal_task',
        'user_id',
        'kelurahan_id',
        'kegiatan_task',
        'wakaf_id',
        'finish_task',
        'publish_task',
        'created_task',
        'created_at',
        'updated_at',
    ];
}
