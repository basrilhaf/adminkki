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
        Schema::create('apps_menu', function (Blueprint $table) {
            $table->id('id_menu');
            $table->string('nama_menu', 200);
            $table->string('is_master', 1);
            $table->integer('master_menu');
            $table->string('status_menu', 1);
            $table->text('icon');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps_menu');
    }
};
