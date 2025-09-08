<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lamaran;

class LamaranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_pelamar' => 'Andi',
                'email' => 'andi@example.com',
                'no_hp' => '081234567890',
                'lowongan' => 'Software Engineer',
                'perusahaan' => 'PT Maju Jaya',
                'cv' => 'cv_andi.pdf',
                'status' => 'Tidak Aktif',
                'created_at'   => now(),
                'updated_at'   => now(),

            ],
            [
                'nama_pelamar' => 'Budi',
                'email' => 'budi@example.com',
                'no_hp' => '089876543210',
                'lowongan' => 'UI/UX Designer',
                'perusahaan' => 'PT Sukses Abadi',
                'cv' => 'cv_budi.pdf',
                'status' => 'Aktif',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ];

        Lamaran::insert($data);
    }
}
