<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanGroup extends Model
{
    use HasFactory;
    protected $table = 't_pertanyaan_group';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'id_pertanyaan_group',
        'kode_group',
        'keterangan',
        'status_group',
        'created_at',
        'updated_at',
    ];
}
