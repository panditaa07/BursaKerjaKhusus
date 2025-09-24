<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🔹 Menjalankan RoleSeeder...');
        $this->call(RoleSeeder::class);

        $this->command->info('🔹 Menjalankan UserSeeder...');
        $this->call(UserSeeder::class);

        $this->command->info('🔹 Menjalankan CompanySeeder...');
        $this->call(CompanySeeder::class);

        $this->command->info('🔹 Menjalankan JobPostSeeder...');
        $this->call(JobPostSeeder::class);

        $this->command->info('🔹 Menjalankan ApplicationSeeder...');
        $this->call(ApplicationSeeder::class);

        $this->command->info('🔹 Menjalankan CompanyApplicationSeeder...');
        $this->call(CompanyApplicationSeeder::class);

        $this->command->info('✅ Semua seeder selesai dijalankan!');
    }
}