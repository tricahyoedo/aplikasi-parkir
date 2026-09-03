<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_log_aktivitas', function (Blueprint $table) {
            $table->integer('id_log')->autoIncrement();
            $table->integer('id_user');
            $table->string('aktivitas', 100);
            $table->dateTime('waktu_aktivitas');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_log_aktivitas');
    }
};
