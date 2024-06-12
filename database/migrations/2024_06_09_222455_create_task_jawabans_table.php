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
        Schema::create('t_task_jawaban', function (Blueprint $table) {
            $table->id('id_task_jawaban');
            $table->string('task_pertanyaan_id', 50);
            $table->text('jawaban');
            $table->string('created_jawaban', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_task_jawaban');
    }
};
