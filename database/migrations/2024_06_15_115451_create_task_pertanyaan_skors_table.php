<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_task_pertanyaan_skor', function (Blueprint $table) {
            $table->id('id_task_pertanyaan_skor');
            $table->integer('task_pertanyaan_id');
            $table->integer('pertanyaan_id');
            $table->integer('pertanyaan_pilihan_id');
            $table->integer('skor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_task_pertanyaan_skor');
    }
};
