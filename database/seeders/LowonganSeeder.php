<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LowonganSeeder extends Seeder
{
    public function run()
    {
        DB::table('lowongans')->insert([
            [
                'judul' => 'Lowongan Programmer',
                'deskripsi' => 'Membuat aplikasi berbasis web dan mobile.',
                'lokasi' => 'Bandung',
                'gaji' => 6000000,
                'batas_akhir' => now()->addMonth(),
                'company_id' => 1, // Pastikan sudah ada company dengan ID 1
            ],
            [
                'judul' => 'Lowongan Designer',
                'deskripsi' => 'Membuat desain UI/UX menarik.',
                'lokasi' => 'Jakarta',
                'gaji' => 5000000,
                'batas_akhir' => now()->addMonth(),
                'company_id' => 2, // Pastikan sudah ada company dengan ID 2
            ],
        ]);
    }
}
