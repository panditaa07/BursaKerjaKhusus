<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua user dengan role company
        $companyUsers = User::whereHas('role', function ($q) {
            $q->where('name', 'company');
        })->get();

        foreach ($companyUsers as $index => $user) {
            $companyName = $user->company_name ?? 'PT ' . $faker->company . ' ' . ($index + 1);
            $company = Company::updateOrCreate(
                ['user_id' => $user->id], // pastikan unik per user
                [
                    'name' => $companyName,
                    'address' => $user->address ?? $faker->address,
                    'phone' => $user->phone ?? $faker->phoneNumber,
                    'website' => 'https://' . strtolower(str_replace([' ', 'PT'], ['', 'pt'], $companyName)) . '.com',
                    'description' => 'Perusahaan milik ' . $user->name . '. ' . $faker->sentence,
                    'is_verified' => true,
                ]
            );

            // Update user's company_id to link to the company
            $user->company_id = $company->id;
            $user->save();
        }
    }
}
