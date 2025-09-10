<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CompanySeeder::class,
            LokerSeeder::class,
            LamaranSeeder::class,
            LowonganSeeder::class,
            TotalPelamarSeeder::class,
            PelamarBulanIniSeeder::class,
            LowonganAktifSeeder::class,
            LowonganDitutupSeeder::class,
            // BeritaSeeder::class, dll
        ]);
    }
}
