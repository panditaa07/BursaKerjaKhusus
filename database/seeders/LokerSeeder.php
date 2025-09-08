<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loker;
use App\Models\Company;
use Carbon\Carbon;

class LokerSeeder extends Seeder
{
    public function run()
    {
        // === Data untuk Loker Terbaru (aktif) ===
        $company1 = Company::create([
            'user_id' => 1,
            'name' => 'PT Digital Kreatif',
            'description' => 'Software house dan startup',
            'address' => 'Jl Gatot Subroto No 1',
            'phone' => '0219998887',
            'is_verified' => true,
        ]);

        Loker::create([
            'company_id' => $company1->id,
            'judul'      => 'Software Engineer',
            'deskripsi'  => 'Membangun aplikasi web modern',
            'no_hrd'     => '081212345678',
            'alamat'     => 'Jl Gatot Subroto No 1',
            'status'     => 'aktif',
            'created_at' => Carbon::now(),
        ]);

        Loker::create([
            'company_id' => $company1->id,
            'judul'      => 'Backend Developer',
            'deskripsi'  => 'Mengembangkan API dan sistem backend',
            'no_hrd'     => '081234567890',
            'alamat'     => 'Jl Asia Afrika No 22',
            'status'     => 'aktif',
            'created_at' => Carbon::now()->subDays(1),
        ]);

        // === Data untuk Loker Tidak Aktif ===
        $company2 = Company::create([
            'user_id' => 2,
            'name' => 'PT Logistik Nusantara',
            'description' => 'Perusahaan logistik & distribusi',
            'address' => 'Jl Merdeka No 10',
            'phone' => '0211112233',
            'is_verified' => true,
        ]);

        Loker::create([
            'company_id' => $company2->id,
            'judul'      => 'Driver Ekspedisi',
            'deskripsi'  => 'Mengantar barang ke seluruh Indonesia',
            'no_hrd'     => '089912345678',
            'alamat'     => 'Jl Merdeka No 10',
            'status'     => 'tidak_aktif',
            'created_at' => Carbon::now()->subDays(3),
        ]);

        Loker::create([
            'company_id' => $company2->id,
            'judul'      => 'Staff Gudang',
            'deskripsi'  => 'Mengelola stok dan inventori',
            'no_hrd'     => '088812345678',
            'alamat'     => 'Jl Diponegoro No 7',
            'status'     => 'tidak_aktif',
            'created_at' => Carbon::now()->subDays(5),
        ]);
    }
}
