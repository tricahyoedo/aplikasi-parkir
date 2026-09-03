<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('tb_tarif')->updateOrInsert(
            ['jenis_kendaraan' => 'motor'],
            ['tarif_per_jam' => 2000, 'created_at' => now(), 'updated_at' => now()]
        );

        DB::table('tb_tarif')->updateOrInsert(
            ['jenis_kendaraan' => 'mobil'],
            ['tarif_per_jam' => 5000, 'created_at' => now(), 'updated_at' => now()]
        );
    }

    public function down(): void
    {
        DB::table('tb_tarif')->whereIn('jenis_kendaraan', ['motor', 'mobil'])->delete();
    }
};
