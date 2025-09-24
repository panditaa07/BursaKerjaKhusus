<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\User;
use App\Models\JobPost;
use App\Models\Company;
use Faker\Factory as Faker;
use Carbon\Carbon;

class CompanyApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Get all users with company role
        $companyUsers = User::whereHas('role', function ($q) {
            $q->where('name', 'company');
        })->get();

        if ($companyUsers->isEmpty()) {
            $this->command->warn('CompanyApplicationSeeder dilewati: tidak ada user dengan role company.');
            return;
        }

        // Get all job posts from companies
        $jobPosts = JobPost::whereHas('company.user', function ($q) {
            $q->whereHas('role', function ($query) {
                $query->where('name', 'company');
            });
        })->get();

        if ($jobPosts->isEmpty()) {
            $this->command->warn('CompanyApplicationSeeder dilewati: tidak ada job post dari perusahaan.');
            return;
        }

        // Dummy company names for testing
        $dummyCompanies = [
            'PT. Kotom Jaya Abadi',
            'PT. Abdul Glory Abadi',
            'PT. Maju Sejahtera',
            'PT. Sumber Rezeki',
            'PT. Berkah Teknologi',
            'PT. Inovasi Digital',
            'PT. Cemerlang Abadi',
            'PT. Harmoni Group',
            'PT. Nusantara Jaya',
            'PT. Global Mandiri'
        ];

        // Status variations as per requirements
        $statuses = [
            'accepted' => 'Terima',
            'rejected' => 'Tolak',
            'interview' => 'Wawancara',
            'test1' => 'Test',
            'submitted' => 'Menunggu'
        ];

        $applications = [];
        $applicationCount = 0;
        $maxApplications = 15; // Create up to 15 dummy applications

        // Create dummy users for testing if needed
        $this->createDummyUsers($faker, $dummyCompanies);

        // Get updated list of company users
        $companyUsers = User::whereHas('role', function ($q) {
            $q->where('name', 'company');
        })->get();

        foreach ($companyUsers as $companyUser) {
            if ($applicationCount >= $maxApplications) break;

            // Get job posts for this company
            $companyJobPosts = $jobPosts->where('company_id', $companyUser->company->id ?? null);

            if ($companyJobPosts->isEmpty()) continue;

            // Create 1-3 applications per company
            $applicationsPerCompany = rand(1, 3);

            for ($i = 0; $i < $applicationsPerCompany && $applicationCount < $maxApplications; $i++) {
                $jobPost = $companyJobPosts->random();

                // Generate dummy applicant data
                $dummyName = $faker->name;
                $dummyEmail = $faker->unique()->email;
                $dummyPhone = $faker->phoneNumber;

                // Create dummy user for this application
                $dummyUser = User::create([
                    'name' => $dummyName,
                    'email' => $dummyEmail,
                    'password' => bcrypt('password123'), // Default password for testing
                    'phone' => $dummyPhone,
                    'role_id' => 3, // Assuming 3 is user role ID
                    'email_verified_at' => now(),
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);

                // Random status
                $statusKey = array_rand($statuses);
                $statusValue = $statusKey;

                $applications[] = [
                    'user_id' => $dummyUser->id,
                    'job_post_id' => $jobPost->id,
                    'cv_path' => "dummy_cv_{$dummyUser->id}.pdf",
                    'cover_letter' => $this->generateCoverLetter($faker, $jobPost->title),
                    'status' => $statusValue,
                    'description' => "DUMMY DATA - {$statuses[$statusKey]} - Dibuat untuk testing company role",
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                    'updated_at' => Carbon::now(),
                ];

                $applicationCount++;
            }
        }

        // Insert all applications
        foreach ($applications as $applicationData) {
            Application::updateOrCreate(
                [
                    'user_id' => $applicationData['user_id'],
                    'job_post_id' => $applicationData['job_post_id']
                ],
                $applicationData
            );
        }

        $this->command->info("✅ CompanyApplicationSeeder selesai: {$applicationCount} dummy applications dibuat untuk testing company role.");
    }

    private function createDummyUsers($faker, $dummyCompanies)
    {
        foreach ($dummyCompanies as $companyName) {
            // Create dummy company user
            $companyUser = User::create([
                'name' => 'Admin ' . $companyName,
                'email' => $faker->unique()->companyEmail,
                'password' => bcrypt('password123'),
                'phone' => $faker->phoneNumber,
                'company_name' => $companyName,
                'role_id' => 2, // Assuming 2 is company role ID
                'email_verified_at' => now(),
                'created_at' => Carbon::now()->subDays(rand(30, 60)),
                'updated_at' => now(),
            ]);

            // Create company record
            Company::create([
                'user_id' => $companyUser->id,
                'name' => $companyName,
                'description' => "Perusahaan dummy untuk testing: {$companyName}",
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'is_verified' => true,
            ]);

            // Create a dummy job post for this company
            JobPost::create([
                'company_id' => $companyUser->company->id ?? $companyUser->id,
                'title' => 'Software Engineer',
                'description' => 'Mencari software engineer berpengalaman untuk bergabung dengan tim kami.',
                'requirements' => 'Sarjana Teknik Informatika, pengalaman minimal 2 tahun, menguasai PHP/Laravel.',
                'location' => 'Jakarta',
                'employment_type' => 'Full-time',
                'vacancies' => rand(1, 5), // Add random vacancies
                'status' => 'active',
                'deadline' => Carbon::now()->addDays(30),
                'industry_id' => 1, // Assuming 1 is IT industry
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateCoverLetter($faker, $jobTitle)
    {
        return "Saya tertarik dengan posisi {$jobTitle} di perusahaan ini. Saya memiliki pengalaman yang relevan dan keterampilan yang dibutuhkan. Saya yakin dapat memberikan kontribusi yang berharga bagi tim. Terima kasih atas kesempatan ini.";
    }
}
