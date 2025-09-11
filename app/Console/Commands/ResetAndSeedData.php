<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class ResetAndSeedData extends Command
{
    protected $signature = 'data:reset-seed';
    protected $description = 'Reset roles, users, companies data and reseed them';

    public function handle()
    {
        $this->info('Truncating roles, users, companies tables...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('companies')->truncate();
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('Seeding roles...');
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        $this->info('Seeding users...');
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);
        $this->info('Seeding companies...');
        Artisan::call('db:seed', ['--class' => 'CompanySeeder']);

        $this->info('Data reset and seeding completed successfully.');
        return 0;
    }
}
