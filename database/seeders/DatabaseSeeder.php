<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,       // tambah seeder roles
            UserSeeder::class,
            CompanySeeder::class,
            JurusanSeeder::class,
            BeritaSeeder::class,
            RoleUserSeeder::class,   // pivot user ↔ role
        ]);
    }
}
