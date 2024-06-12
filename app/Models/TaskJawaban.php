<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskJawaban extends Model
{
    use HasFactory;
    protected $table = 't_task_jawaban';
    protected $primaryKey = 'id_task_jawaban';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_task_jawaban',
        'task_pertanyaan_id',
        'jawaban',
        'created_jawaban',
        'created_at',
        'updated_at',
    ];
}
