<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LowonganDitutupSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lowongan_tidak_aktifs')->truncate();

        for ($i = 1; $i <= 12; $i++) {
            DB::table('lowongan_tidak_aktifs')->insert([
                'perusahaan' => "Perusahaan Ditutup $i",
                'no_hrd' => "HRD" . rand(1000, 9999),
                'alamat' => "Jl. Ditutup No $i",
                'status' => 'Tidak Aktif',
            ]);
        }
    }
}
