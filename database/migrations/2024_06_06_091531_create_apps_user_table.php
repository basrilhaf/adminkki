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
        Schema::create('apps_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama', 200);
            $table->string('username', 200);
            $table->string('password', 200);
            $table->string('email', 200);
            $table->integer('role_id');
            $table->string('jenis_kelamin', 1);
            $table->string('no_telepon', 20);
            $table->text('alamat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps_user');
    }
};
