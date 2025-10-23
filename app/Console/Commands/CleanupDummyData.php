<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupDummyData extends Command
{
    protected $signature = 'cleanup:dummy';
    protected $description = 'Menghapus semua data dummy untuk role company dan user, termasuk semua lowongan kerja, kecuali admin.';

    public function handle()
    {
        $this->info('🧹 Proses penghapusan data dummy dimulai...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::transaction(function () {
            // ambil id role untuk company dan user
            $roleIds = DB::table('roles')
                ->whereIn('name', ['company', 'user'])
                ->pluck('id');

            // ambil semua id user yang punya role company atau user
            $userIds = DB::table('users')
                ->whereIn('role_id', $roleIds)
                ->pluck('id');

            // hapus semua lowongan kerja yang dibuat user role company
            DB::table('job_posts')->whereIn('company_id', $userIds)->delete();

            // hapus data aplikasi lamaran
            DB::table('applications')->whereIn('user_id', $userIds)->delete();

            // hapus semua user non-admin
            DB::table('users')->whereIn('role_id', $roleIds)->delete();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info('✅ Semua data dummy (company & user), termasuk lowongan kerja, berhasil dihapus. Data admin tetap aman.');
    }
}
