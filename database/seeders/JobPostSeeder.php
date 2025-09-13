<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobPost;
use App\Models\Company;
use App\Models\Industry;
use App\Models\User;
use Faker\Factory as Faker;
use Carbon\Carbon;

class JobPostSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

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

        // Ambil semua user dengan role company
        $companyUsers = User::whereHas('role', fn($q) => $q->where('name', 'company'))->get();

        if ($companyUsers->isEmpty()) {
            $this->command->warn('Tidak ada user dengan role company. Seeder JobPost dilewati.');
            return;
        }

        // Create companies for each company user if not exists
        $companies = [];
        foreach ($companyUsers as $index => $user) {
            $companyName = 'PT ' . $faker->company . ' ' . ($index + 1);
            $company = Company::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $companyName,
                    'description' => $faker->sentence,
                    'address' => $faker->address,
                    'phone' => $faker->phoneNumber,
                    'is_verified' => true,
                ]
            );
            $companies[] = $company;
        }

        // Create job posts for each company
        $jobTitles = [
            'Software Engineer',
            'Backend Developer',
            'UI/UX Designer',
            'Driver Ekspedisi',
            'Staff Gudang',
            'Manager Operasional',
            'HR Specialist',
            'Marketing Manager',
            'Sales Executive',
            'Customer Support',
        ];

        $statuses = ['active', 'inactive'];

        foreach ($companies as $companyIndex => $company) {
            $industry = $faker->randomElement([$industry1, $industry2, $industry3]);
            $numPosts = rand(2, 4);
            for ($i = 0; $i < $numPosts; $i++) {
                $title = $jobTitles[array_rand($jobTitles)] . " " . ($i + 1);
                JobPost::create([
                    'industry_id' => $industry->id,
                    'company_id' => $company->id,
                    'title' => $title,
                    'description' => $faker->paragraph,
                    'location' => $faker->city,
                    'employment_type' => $faker->randomElement(['Full-time', 'Part-time', 'Contract']),
                    'vacancies' => rand(1, 5),
                    'deadline' => Carbon::now()->addDays(rand(10, 60)),
                    'status' => $statuses[array_rand($statuses)],
                    'created_at' => Carbon::now()->subDays(rand(0, 10)),
                ]);
            }
        }
    }
}
