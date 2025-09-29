<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndustrySeeder extends Seeder
{
    public function run(): void
    {
        $industries = [
            ['name' => 'Technology', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Healthcare', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Education', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manufacturing', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Retail', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Construction', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hospitality', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Transportation', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Agriculture', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('industries')->insert($industries);
    }
}
