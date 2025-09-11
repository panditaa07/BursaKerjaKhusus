<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobPost;
use App\Models\Company;
use App\Models\Industry;
use App\Models\User;
use Carbon\Carbon;

class JobPostSeeder extends Seeder
{
    public function run()
    {
        // Create industries
        $industry1 = Industry::firstOrCreate(
            ['name' => 'Technology'],
            ['description' => 'Industri teknologi dan inovasi.']
        );

        $industry2 = Industry::firstOrCreate(
            ['name' => 'Human Resources'],
            ['description' => 'Industri pengembangan sumber daya manusia.']
        );

        $industry3 = Industry::firstOrCreate(
            ['name' => 'Logistics'],
            ['description' => 'Industri logistik dan distribusi.']
        );

        // Ambil user role company pertama
        $companyUser = User::whereHas('role', fn($q) => $q->where('name', 'company'))->first();

        if (!$companyUser) {
            $this->command->warn('Tidak ada user dengan role company. Seeder JobPost dilewati.');
            return;
        }

        // Buat company untuk user tersebut
        $company1 = Company::firstOrCreate(
            ['user_id' => $companyUser->id],
            [
                'name' => 'PT Digital Kreatif',
                'description' => 'Software house dan startup',
                'address' => 'Jl Gatot Subroto No 1, Jakarta',
                'phone' => '0219998887',
                'is_verified' => true,
            ]
        );

        $company2 = Company::firstOrCreate(
            ['user_id' => $companyUser->id],
            [
                'name' => 'PT Logistik Nusantara',
                'description' => 'Perusahaan logistik & distribusi',
                'address' => 'Jl Merdeka No 10, Bandung',
                'phone' => '0211112233',
                'is_verified' => true,
            ]
        );

        // Create job posts
        JobPost::create([
            'industry_id' => $industry1->id,
            'company_id' => $company1->id,
            'title' => 'Software Engineer',
            'description' => 'Membangun aplikasi web modern dengan teknologi terkini.',
            'location' => 'Jakarta',
            'employment_type' => 'Full-time',
            'vacancies' => 2,
            'deadline' => Carbon::now()->addDays(30),
            'status' => 'active',
            'created_at' => Carbon::now(),
        ]);

        JobPost::create([
            'industry_id' => $industry1->id,
            'company_id' => $company1->id,
            'title' => 'Backend Developer',
            'description' => 'Mengembangkan API dan sistem backend.',
            'location' => 'Jakarta',
            'employment_type' => 'Full-time',
            'vacancies' => 1,
            'deadline' => Carbon::now()->addDays(25),
            'status' => 'active',
            'created_at' => Carbon::now()->subDays(1),
        ]);

        JobPost::create([
            'industry_id' => $industry1->id,
            'company_id' => $company1->id,
            'title' => 'UI/UX Designer',
            'description' => 'Merancang interface pengguna yang menarik.',
            'location' => 'Jakarta',
            'employment_type' => 'Full-time',
            'vacancies' => 1,
            'deadline' => Carbon::now()->addDays(20),
            'status' => 'active',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        JobPost::create([
            'industry_id' => $industry3->id,
            'company_id' => $company2->id,
            'title' => 'Driver Ekspedisi',
            'description' => 'Mengantar barang ke seluruh Indonesia.',
            'location' => 'Jakarta',
            'employment_type' => 'Full-time',
            'vacancies' => 3,
            'deadline' => Carbon::now()->addDays(15),
            'status' => 'inactive',
            'created_at' => Carbon::now()->subDays(3),
        ]);

        JobPost::create([
            'industry_id' => $industry3->id,
            'company_id' => $company2->id,
            'title' => 'Staff Gudang',
            'description' => 'Mengelola stok dan inventori.',
            'location' => 'Jakarta',
            'employment_type' => 'Full-time',
            'vacancies' => 2,
            'deadline' => Carbon::now()->addDays(10),
            'status' => 'inactive',
            'created_at' => Carbon::now()->subDays(5),
        ]);

        JobPost::create([
            'industry_id' => $industry3->id,
            'company_id' => $company2->id,
            'title' => 'Manager Operasional',
            'description' => 'Mengawasi operasi harian perusahaan.',
            'location' => 'Jakarta',
            'employment_type' => 'Full-time',
            'vacancies' => 1,
            'deadline' => Carbon::now()->addDays(5),
            'status' => 'inactive',
            'created_at' => Carbon::now()->subDays(7),
        ]);
    }
}