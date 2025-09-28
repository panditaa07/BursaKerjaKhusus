<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;
use App\Models\Industry;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPost>
 */
class JobPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = Company::inRandomOrder()->first();
        $industry = Industry::inRandomOrder()->first();

        $minSalary = rand(3000000, 8000000);
        $maxSalary = $minSalary + rand(1000000, 5000000);

        return [
            'industry_id' => $industry ? $industry->id : 1,
            'company_id' => $company ? $company->id : 1,
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'requirements' => $this->faker->paragraph,
            'location' => $this->faker->city,
            'employment_type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Contract']),
            'vacancies' => rand(1, 5),
            'min_salary' => number_format($minSalary, 0, ',', '.'),
            'max_salary' => number_format($maxSalary, 0, ',', '.'),
            'deadline' => Carbon::now()->addDays(rand(10, 60)),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'created_at' => Carbon::now()->subDays(rand(0, 10)),
        ];
    }
}
