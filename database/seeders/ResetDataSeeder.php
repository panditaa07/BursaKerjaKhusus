<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\JobPost;
use App\Models\Application;
use App\Models\UserNotification;
use App\Models\PelamarBulanIni;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Nonaktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Hapus data pelamar (Applications)
        Application::truncate();

        // 3. Hapus data lowongan kerja (JobPosts)
        JobPost::truncate();

        // 4. Hapus data perusahaan (Companies)
        Company::truncate();

        // 5. Hapus data User selain Admin
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            // Delete users who are not admin
            User::where('role_id', '!=', $adminRole->id)->forceDelete();
            
            // Clear company_id for remaining admins
            User::where('role_id', $adminRole->id)->update(['company_id' => null]);
        }

        // 6. Hapus data Notifications
        UserNotification::truncate();

        // 7. Hapus data Pelamar Bulan Ini (Operational tracking)
        if (Schema::hasTable('pelamar_bulan_inis')) {
            PelamarBulanIni::truncate();
        }

        // 8. Bersihkan sessions dan tokens
        if (Schema::hasTable('sessions')) {
            DB::table('sessions')->truncate();
        }
        if (Schema::hasTable('password_reset_tokens')) {
            DB::table('password_reset_tokens')->truncate();
        }

        // 9. Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
