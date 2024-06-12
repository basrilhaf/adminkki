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
        Schema::create('t_task', function (Blueprint $table) {
            $table->id('id_task');
            $table->string('nama_task', 200);
            $table->string('kode_task', 200);
            $table->date('tanggal_task');
            $table->integer('user_id');
            $table->string('kelurahan_id', 50);
            $table->string('kegiatan_task', 50);
            $table->string('finish_task', 5);
            $table->dateTime('finish_task_at');
            $table->string('publish_task', 5);
            $table->string('created_task', 50);
            $table->string('wakaf_id', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_task');
    }
};
