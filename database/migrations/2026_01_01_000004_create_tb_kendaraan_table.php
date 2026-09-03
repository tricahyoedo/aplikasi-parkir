<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_kendaraan', function (Blueprint $table) {
            $table->integer('id_kendaraan')->autoIncrement();
            $table->string('plat_nomor', 15);
            $table->string('jenis_kendaraan', 20);
            $table->string('merk', 50);
            $table->string('pemilik', 100);
            $table->integer('id_user');
            $table->integer('id_area')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
            $table->foreign('id_area')->references('id_area')->on('tb_area_parkir')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_kendaraan');
    }
};
