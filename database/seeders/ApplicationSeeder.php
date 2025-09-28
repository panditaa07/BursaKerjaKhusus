<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\User;
use App\Models\JobPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user dengan role 'user'
        $allUsers = User::whereHas('role', fn($q) => $q->where('name', 'user'))->pluck('id')->toArray();

        // Ambil semua job post
        $jobPosts = JobPost::pluck('id')->toArray();

        if (empty($allUsers) || empty($jobPosts)) {
            $this->command->warn('Seeder Application dilewati: tidak ada user/job post.');
            return;
        }

        // Generate unique combinations
        $combinations = [];
        $attempts = 0;
        $maxAttempts = 1000; // Prevent infinite loop

        while (count($combinations) < 500 && $attempts < $maxAttempts) {
            $userId = $allUsers[array_rand($allUsers)];
            $jobPostId = $jobPosts[array_rand($jobPosts)];
            $key = $userId . '-' . $jobPostId;

            if (!isset($combinations[$key])) {
                $combinations[$key] = ['user_id' => $userId, 'job_post_id' => $jobPostId];
            }
            $attempts++;
        }

        $uniqueCombinations = array_values($combinations);
        $this->command->info("Membuat " . count($uniqueCombinations) . " aplikasi unik.");

        foreach ($uniqueCombinations as $combo) {
            Application::factory()->create($combo);
        }
    }
}
