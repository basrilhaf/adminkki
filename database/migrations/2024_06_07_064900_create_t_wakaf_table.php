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
        Schema::create('t_wakaf', function (Blueprint $table) {
            $table->id('id_wakaf');
            $table->string('provinsi_id', 50);
            $table->string('kabupaten_id', 50);
            $table->string('kecamatan_id', 50);
            $table->string('luas', 50);
            $table->string('guna', 200);
            $table->string('status', 5);
            $table->string('potensi_id', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_wakaf');
    }
};
