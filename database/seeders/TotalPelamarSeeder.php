<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TotalPelamarSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pelamars')->truncate();

        for ($i = 1; $i <= 120; $i++) {
            DB::table('pelamars')->insert([
                'nama_pelamar' => "Pelamar $i",
                'email' => "pelamar$i@example.com",
                'no_hp' => "08123".rand(100000,999999),
                'perusahaan' => "Perusahaan ".rand(1,5),
                'status' => collect(['Proses', 'Wawancara', 'Diterima', 'Ditolak'])->random(),
            ]);
        }
    }
}
