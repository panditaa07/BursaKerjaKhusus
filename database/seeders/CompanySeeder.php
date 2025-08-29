<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'perusahaan@bkk.com')->first();

        if ($user) {
            Company::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => 'PT Maju Jaya',
                    'address' => 'Jl. Merdeka No. 45, Bandung',
                    'website' => 'https://www.majujaya.com',
                    'description' => 'Perusahaan teknologi informasi',
                    'logo' => 'logos/majujaya.png'
                ]
            );
        }
    }
}