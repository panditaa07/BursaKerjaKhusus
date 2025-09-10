<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelamarBulanIniSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pelamar_bulan_inis')->truncate();

        for ($i = 1; $i <= 14; $i++) {
            DB::table('pelamar_bulan_inis')->insert([
                'nama_pelamar' => "Pelamar Bulan Ini $i",
                'email' => "bulan_ini_pelamar_$i@example.com",
                'no_hp' => "08234".rand(100000,999999),
                'perusahaan' => "Perusahaan Bulan Ini ".rand(1,3),
                'status' => collect(['Proses', 'Wawancara', 'Diterima', 'Ditolak'])->random(),
            ]);
        }
    }
}
