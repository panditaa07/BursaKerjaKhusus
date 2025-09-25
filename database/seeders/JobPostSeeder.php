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

        // Ambil semua companies yang terkait dengan user role company
        $companies = Company::whereHas('user', function ($q) {
            $q->whereHas('role', function ($r) {
                $r->where('name', 'company');
            });
        })->get();

        if ($companies->isEmpty()) {
            $this->command->warn('Tidak ada company terkait user role company. Seeder JobPost dilewati.');
            return;
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

        // Create job posts for all companies
        $totalPosts = 0;
        $shuffledTitles = $jobTitles; // Copy the array
        shuffle($shuffledTitles); // Shuffle to randomize order
        $titleIndex = 0; // Index to pick titles sequentially from shuffled array

        foreach ($companies as $company) {
            $industry = $faker->randomElement([$industry1, $industry2, $industry3]);
            $numPosts = rand(2, 4); // Each company gets 2-4 job posts
            for ($i = 0; $i < $numPosts; $i++) {
                // Use shuffled titles sequentially, wrap around if needed
                $title = $shuffledTitles[$titleIndex % count($shuffledTitles)];
                $titleIndex++;

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
