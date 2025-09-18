<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\User;
use App\Models\JobPost;
use Carbon\Carbon;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user dengan role 'user'
        $allUsers = User::whereHas('role', fn($q) => $q->where('name', 'user'))
            ->orderBy('id')
            ->pluck('id')
            ->toArray();

        // Ambil semua job post
        $jobPosts = JobPost::pluck('id')->toArray();

        if (empty($allUsers) || empty($jobPosts)) {
            $this->command->warn('Seeder Application dilewati: tidak ada user/job post.');
            return;
        }

        // Status lamaran yang mungkin
        $statuses = ['submitted', 'reviewed', 'accepted', 'rejected'];

        $applications = [];
        $usedCombinations = [];

        // Create applications for a subset of users (e.g., first 5 users)
        $usersWithApplications = array_slice($allUsers, 0, 5);

        // Create applications for each user-job combination (up to 15 total)
        $maxApplications = min(15, count($usersWithApplications) * count($jobPosts));

        for ($i = 0; $i < $maxApplications; $i++) {
            do {
                $userId = $usersWithApplications[array_rand($usersWithApplications)];
                $jobPostId = $jobPosts[array_rand($jobPosts)];
                $combination = $userId . '-' . $jobPostId;
            } while (in_array($combination, $usedCombinations));

            $usedCombinations[] = $combination;

            $applications[] = [
                'user_id' => $userId,
                'job_post_id' => $jobPostId,
                'cv_path' => "cv_{$userId}_{$jobPostId}.pdf",
                'cover_letter' => 'Saya tertarik dengan posisi ini dan memiliki kualifikasi yang sesuai.',
                'status' => $statuses[array_rand($statuses)],
                'created_at' => Carbon::now()->subDays(rand(1, 60)),
                'updated_at' => Carbon::now(),
            ];
        }

        foreach ($applications as $application) {
            Application::updateOrCreate(
                [
                    'user_id' => $application['user_id'],
                    'job_post_id' => $application['job_post_id']
                ],
                $application
            );
        }
    }
}
