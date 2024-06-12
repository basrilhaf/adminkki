<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;
    protected $table = 't_pertanyaan';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'id_pertanyaan',
        'pertanyaan',
        'created_pertanyaan',
        'created_at',
        'updated_at',
    ];
}
