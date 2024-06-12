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
        Schema::create('t_pertanyaan_pilihan', function (Blueprint $table) {
            $table->id('id_pertanyaan_pilihan');
            $table->integer('pertanyaan_id');
            $table->text('pilihan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_pertanyaan_pilihan');
    }
};
