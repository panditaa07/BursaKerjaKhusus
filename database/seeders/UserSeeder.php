<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // Use Indonesian locale for names

        // Get roles
        $adminRole = Role::where('name', 'admin')->first();
        $companyRole = Role::where('name', 'company')->first();
        $userRole = Role::where('name', 'user')->first();

        // Create fixed admin account to ensure login works
        User::updateOrCreate(
            ['email' => 'admin@bkk.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'phone' => '081234567890',
                'address' => 'Jl. Admin No.1',
                'birth_date' => '1990-01-01',
                'short_profile' => 'Default admin account',
            ]
        );

        // Create fixed company account for login
        User::updateOrCreate(
            ['email' => 'company@bkk.com'],
            [
                'name' => 'Contoh Company',
                'password' => Hash::make('password'),
                'role_id' => $companyRole->id,
                'company_name' => 'PT Contoh Company',
                'phone' => '081234567891',
                'address' => 'Jl. Company No.1',
                'birth_date' => '1985-01-01',
                'short_profile' => 'Default company account',
            ]
        );

        // Create fixed user/pelamar account for login
        User::updateOrCreate(
            ['email' => 'user@bkk.com'],
            [
                'name' => 'Pelamar Contoh',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
                'phone' => '081234567892',
                'address' => 'Jl. User No.1',
                'birth_date' => '1995-01-01',
                'short_profile' => 'Default user account',
                'cv_path' => 'cv_user1.pdf',
            ]
        );

        // Create Admins (3 unique admins) - Note: Admin role users are excluded from admin user management
        for ($i = 1; $i <= 3; $i++) {
            User::updateOrCreate(
                ['email' => "admin{$i}@bkk.com"],
                [
                    'name' => $faker->unique()->name,
                    'password' => Hash::make('password'),
                    'role_id' => $adminRole->id,
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'birth_date' => $faker->date('Y-m-d', '-30 years'),
                    'short_profile' => $faker->sentence,
                ]
            );
        }

        // Companies with job posts (3 companies)
        for ($i = 1; $i <= 3; $i++) {
            User::updateOrCreate(
                ['email' => "company{$i}@bkk.com"],
                [
                    'name' => $faker->unique()->name,
                    'password' => Hash::make('password'),
                    'role_id' => $companyRole->id,
                    'company_name' => 'PT ' . $faker->unique()->company,
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'birth_date' => $faker->date('Y-m-d', '-30 years'),
                    'short_profile' => $faker->sentence,
                ]
            );
        }

        // Companies without job posts (2 companies)
        for ($i = 4; $i <= 5; $i++) {
            User::updateOrCreate(
                ['email' => "company{$i}@bkk.com"],
                [
                    'name' => $faker->unique()->name,
                    'password' => Hash::make('password'),
                    'role_id' => $companyRole->id,
                    'company_name' => 'PT ' . $faker->unique()->company,
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'birth_date' => $faker->date('Y-m-d', '-30 years'),
                    'short_profile' => $faker->sentence,
                ]
            );
        }

        // Users with applications (5 users)
        for ($i = 1; $i <= 5; $i++) {
            User::updateOrCreate(
                ['email' => "user{$i}@bkk.com"],
                [
                    'name' => $faker->unique()->name,
                    'password' => Hash::make('password'),
                    'role_id' => $userRole->id,
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'nisn' => $faker->unique()->numerify('##########'),
                    'birth_date' => $faker->date('Y-m-d', '-20 years'),
                    'short_profile' => $faker->sentence,
                    'cv_path' => "cv_user{$i}.pdf",
                ]
            );
        }

        // Users without applications (5 users)
        for ($i = 6; $i <= 10; $i++) {
            User::updateOrCreate(
                ['email' => "user{$i}@bkk.com"],
                [
                    'name' => $faker->unique()->name,
                    'password' => Hash::make('password'),
                    'role_id' => $userRole->id,
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'nisn' => $faker->unique()->numerify('##########'),
                    'birth_date' => $faker->date('Y-m-d', '-20 years'),
                    'short_profile' => $faker->sentence,
                    'cv_path' => "cv_user{$i}.pdf",
                ]
            );
        }
    }
}
