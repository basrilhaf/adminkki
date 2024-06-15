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
        Schema::create('t_pertanyaan_group', function (Blueprint $table) {
            $table->id('id_pertanyaan_group');
            $table->string('kode_group', 200);
            $table->text('keterangan');
            $table->string('status_group', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_pertanyaan_group');
    }
};
