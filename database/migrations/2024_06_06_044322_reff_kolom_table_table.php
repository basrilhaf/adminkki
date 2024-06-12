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
        Schema::create('reff_kolom_table', function (Blueprint $table) {
            $table->id('id_reff');
            $table->string('table', 200);
            $table->string('kolom', 200);
            $table->string('isi_kolom', 200);
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reff_kolom_table');
    }
};
