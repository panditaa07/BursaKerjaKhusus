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
            $companyName = 'PT ' . $faker->unique()->company . ' ' . ($index + 1);
            $company = Company::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $companyName,
                    'description' => $faker->sentence,
                    'address' => $faker->address,
                    'phone' => $faker->phoneNumber,
                    'email' => $faker->unique()->companyEmail,
                    'logo' => 'company_logos/logo_' . ($index + 1) . '.png',
                    'is_verified' => true,
                ]
            );
            $companies[] = $company;
        }

        // Create unique job titles
        $jobTitles = [
            'Software Engineer Senior',
            'Backend Developer Junior',
            'UI/UX Designer Specialist',
            'Driver Ekspedisi Profesional',
            'Staff Gudang Berpengalaman',
            'Manager Operasional Senior',
            'HR Specialist Recruitment',
            'Marketing Manager Digital',
            'Sales Executive B2B',
            'Customer Support Specialist',
            'Data Analyst Business Intelligence',
            'Project Manager IT',
            'Graphic Designer Creative',
            'Accountant Senior',
            'Receptionist Professional',
            'Web Developer Full Stack',
            'Mobile App Developer',
            'DevOps Engineer',
            'Quality Assurance Tester',
            'Business Analyst',
        ];

        $statuses = ['active', 'inactive'];

        // Create job posts for first 3 companies only (companies with job posts)
        $companiesWithPosts = array_slice($companies, 0, 3);

        $totalPosts = 0;
        foreach ($companiesWithPosts as $companyIndex => $company) {
            $industry = $faker->randomElement([$industry1, $industry2, $industry3]);
            $numPosts = rand(2, 4); // Each company gets 2-4 job posts
            for ($i = 0; $i < $numPosts && $totalPosts < 15; $i++) {
                $title = $faker->unique()->randomElement($jobTitles);
                // Check if job post with same title and company already exists
                $existingJob = JobPost::where('title', $title)->where('company_id', $company->id)->first();
                if (!$existingJob) {
                    $minSalary = rand(3000000, 8000000);
                    $maxSalary = $minSalary + rand(1000000, 5000000);
                    JobPost::create([
                        'industry_id' => $industry->id,
                        'company_id' => $company->id,
                        'title' => $title,
                        'description' => $faker->paragraph,
                        'requirements' => $faker->paragraph,
                        'location' => $faker->city,
                        'employment_type' => $faker->randomElement(['Full-time', 'Part-time', 'Contract']),
                        'vacancies' => rand(1, 5),
                        'min_salary' => number_format($minSalary, 0, ',', '.'),
                        'max_salary' => number_format($maxSalary, 0, ',', '.'),
                        'deadline' => Carbon::now()->addDays(rand(10, 60)),
                        'status' => $statuses[array_rand($statuses)],
                        'created_at' => Carbon::now()->subDays(rand(0, 10)),
                    ]);
                    $totalPosts++;
                }
            }
        }
    }
}
