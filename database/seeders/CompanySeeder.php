<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 dummy companies using factory
        Company::factory(10)->create();
    }
}
