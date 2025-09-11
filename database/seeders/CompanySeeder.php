<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user dengan role company
        $companyUsers = User::whereHas('role', function ($q) {
            $q->where('name', 'company');
        })->get();

        foreach ($companyUsers as $user) {
            $company = Company::updateOrCreate(
                ['user_id' => $user->id], // pastikan unik per user
                [
                    'name' => $user->company_name ?? 'Perusahaan ' . $user->name,
                    'address' => $user->address ?? 'Alamat default',
                    'phone' => $user->phone ?? '0800000000',
                    'website' => 'https://example.com/' . strtolower(str_replace(' ', '', $user->name)),
                    'description' => 'Perusahaan milik ' . $user->name,
                    'is_verified' => true,
                ]
            );

            // Update user's company_id to link to the company
            $user->company_id = $company->id;
            $user->save();
        }
    }
}
