<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;

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
            $companyName = $user->company_name ?? 'PT ' . $faker->unique()->company . ' ' . ($index + 1);
            $company = Company::updateOrCreate(
                ['user_id' => $user->id], // pastikan unik per user
                [
                    'name' => $companyName,
                    'address' => $user->address ?? $faker->address,
                    'phone' => $user->phone ?? $faker->phoneNumber,
                    //'email' => $faker->unique()->companyEmail, // Remove email field as it does not exist in companies table
                    'website' => 'https://' . strtolower(str_replace([' ', 'PT'], ['', 'pt'], $companyName)) . '.com',
                    'description' => 'Perusahaan milik ' . $user->name . '. ' . $faker->sentence,
                    'logo' => 'company_logos/logo_' . ($index + 1) . '.png', // Placeholder logo path
                    'is_verified' => true,
                ]
            );

            // Update user's company_id to link to the company
            $user->company_id = $company->id;
            $user->save();
        }
    }
}
