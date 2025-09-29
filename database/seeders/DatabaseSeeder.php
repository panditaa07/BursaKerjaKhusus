<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate tables in reverse order to handle foreign keys
        $this->command->info('🔹 Truncating tables for refresh...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('applications')->truncate();
        DB::table('job_posts')->truncate();
        DB::table('companies')->truncate();
        DB::table('industries')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('🔹 Menjalankan RoleSeeder...');
        $this->call(RoleSeeder::class);

        $this->command->info('🔹 Menjalankan UserSeeder...');
        $this->call(UserSeeder::class);

        $this->command->info('🔹 Menjalankan IndustrySeeder...');
        $this->call(IndustrySeeder::class);



        $this->command->info('🔹 Menjalankan JobPostSeeder...');
        $this->call(JobPostSeeder::class);

        $this->command->info('🔹 Menjalankan ApplicationSeeder...');
        $this->call(ApplicationSeeder::class);

        $this->command->info('🔹 Menjalankan CompanyApplicationSeeder...');
        $this->call(CompanyApplicationSeeder::class);

        $this->command->info('✅ Semua seeder selesai dijalankan!');
    }
}
