<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Buat Admin
        $adminRole = Role::where('name', 'admin')->first();
        User::updateOrCreate(
            ['email' => 'admin@bkk.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        // Buat Company
        $companyRole = Role::where('name', 'company')->first();
        User::updateOrCreate(
            ['email' => 'company@bkk.com'],
            [
                'name' => 'PT Contoh Company',
                'password' => Hash::make('password'),
                'role_id' => $companyRole->id,
            ]
        );

        // Buat User / Pelamar
        $userRole = Role::where('name', 'user')->first();
        User::updateOrCreate(
            ['email' => 'user@bkk.com'],
            [
                'name' => 'Pelamar Contoh',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
            ]
        );
    }
}