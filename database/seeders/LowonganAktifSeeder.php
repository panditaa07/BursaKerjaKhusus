<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LowonganAktifSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lowongan_aktifs')->truncate();

        for ($i = 1; $i <= 8; $i++) {
            DB::table('lowongan_aktifs')->insert([
                'perusahaan' => "Perusahaan Aktif $i",
                'no_hrd' => "HRD" . rand(1000, 9999),
                'alamat' => "Jl. Aktif No $i",
                'status' => 'Aktif',
            ]);
        }
    }
}
