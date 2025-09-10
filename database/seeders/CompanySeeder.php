<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run()
    {
        DB::table('companies')->insert([
            [
                'user_id' => 1, // Assuming user with ID 1 exists
                'name' => 'PT Maju Jaya',
                'address' => 'Jl. Merdeka No. 1',
                'phone' => '08123456789',
                'website' => 'https://majujaya.com',
                'description' => 'Perusahaan yang bergerak di bidang teknologi dan inovasi.',
            ],
            [
                'user_id' => 2, // Assuming user with ID 2 exists
                'name' => 'CV Sukses Selalu',
                'address' => 'Jl. Sudirman No. 5',
                'phone' => '08198765432',
                'website' => 'https://suksesselalu.com',
                'description' => 'CV yang fokus pada pengembangan sumber daya manusia.',
            ],
        ]);
    }
}
