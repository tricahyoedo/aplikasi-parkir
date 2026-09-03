<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_user', function (Blueprint $table) {
            $table->integer('id_user')->autoIncrement();
            $table->string('nama_lengkap', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 100);
            $table->enum('role', ['admin', 'petugas', 'owner']);
            $table->boolean('status_aktif')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
};
