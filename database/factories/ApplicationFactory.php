<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\JobPost;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::whereHas('role', fn($q) => $q->where('name', 'user'))->inRandomOrder()->first();
        $jobPost = JobPost::inRandomOrder()->first();

        return [
            'user_id' => $user ? $user->id : 1,
            'job_post_id' => $jobPost ? $jobPost->id : 1,
            'cv_path' => "cv_{$this->faker->randomNumber()}.pdf",
            'cover_letter' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['submitted', 'reviewed', 'accepted', 'rejected']),
            'created_at' => Carbon::now()->subDays(rand(1, 60)),
            'updated_at' => Carbon::now(),
        ];
    }
}
