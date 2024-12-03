<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskPertanyaanSkor extends Model
{
    use HasFactory;
    protected $table = 't_task_pertanyaan_skor';
    protected $primaryKey = 'id_task_pertanyaan_skor';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_task_pertanyaan_skor',
        'task_pertanyaan_id',
        'pertanyaan_id',
        'pertanyaan_pilihan_id',
        'skor',
        'created_at',
        'updated_at',
    ];
}
