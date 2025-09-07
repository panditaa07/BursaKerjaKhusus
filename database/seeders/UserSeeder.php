<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@bkk.com'], // kunci unik
            [
                'name' => 'Admin BKK',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Perusahaan
        User::firstOrCreate(
            ['email' => 'company@bkk.com'],
            [
                'name' => 'Company',
                'password' => Hash::make('password'),
                'role' => 'company',
            ]
        );

        // Alumni
        User::firstOrCreate(
            ['email' => 'user@bkk.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}