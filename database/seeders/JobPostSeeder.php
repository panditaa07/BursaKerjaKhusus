<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobPost;
use App\Models\Company;
use App\Models\Industry;
use App\Models\User;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JobPostSeeder extends Seeder
{
    public function run(): void
    {
        $companies = \App\Models\Company::all();
        foreach ($companies as $company) {
            \App\Models\JobPost::factory(4)->create([
                'company_id' => $company->id,
            ]);
        }
    }
}
