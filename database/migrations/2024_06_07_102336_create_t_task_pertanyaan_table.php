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
        Schema::create('t_task_pertanyaan', function (Blueprint $table) {
            $table->id('id_task_pertanyaan');
            $table->string('task_id', 50);
            $table->string('pertanyaan_id', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_task_pertanyaan');
    }
};
