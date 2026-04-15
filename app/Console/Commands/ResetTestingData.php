<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\JobPost;
use App\Models\Application;
use App\Models\UserNotification;
use App\Models\PelamarBulanIni;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetTestingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reset-testing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset operational data (applications, job posts, users except admin) for testing purposes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->confirm('Are you sure you want to reset all operational data? This will keep only admin accounts.')) {
            $this->info('Operation cancelled.');
            return;
        }

        $this->info('Starting data reset...');

        try {
            DB::beginTransaction();

            // 1. Nonaktifkan foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // 2. Hapus data pelamar (Applications)
            $this->comment('Deleting all applications...');
            Application::truncate();

            // 3. Hapus data lowongan kerja (JobPosts)
            $this->comment('Deleting all job posts...');
            JobPost::truncate();

            // 4. Hapus data perusahaan (Companies)
            $this->comment('Deleting all companies...');
            Company::truncate();

            // 5. Hapus data User selain Admin
            $this->comment('Deleting users (except admin)...');
            $adminRole = Role::where('name', 'admin')->first();
            
            if ($adminRole) {
                // Delete users who are not admin
                User::where('role_id', '!=', $adminRole->id)->forceDelete();
                
                // Clear company_id for remaining admins
                User::where('role_id', $adminRole->id)->update(['company_id' => null]);
            } else {
                $this->error('Admin role not found! Skipping user deletion to prevent data loss.');
            }

            // 6. Hapus data Notifications
            $this->comment('Deleting all user notifications...');
            UserNotification::truncate();

            // 7. Hapus data Pelamar Bulan Ini (Operational tracking)
            if (Schema::hasTable('pelamar_bulan_inis')) {
                $this->comment('Deleting pelamar bulan ini tracking...');
                PelamarBulanIni::truncate();
            }

            // 8. Bersihkan data session dan reset tokens
            $this->comment('Clearing sessions and password reset tokens...');
            if (Schema::hasTable('sessions')) {
                DB::table('sessions')->truncate();
            }
            if (Schema::hasTable('password_reset_tokens')) {
                DB::table('password_reset_tokens')->truncate();
            }

            // 9. Aktifkan kembali foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            DB::commit();
            $this->info('Data reset successfully! Only admin accounts remain.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->error('An error occurred during reset: ' . $e->getMessage());
        }
    }
}
