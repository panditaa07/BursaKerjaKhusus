<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'description' => 'Administrator'],
            ['name' => 'alumni', 'description' => 'Lulusan sekolah'],
            ['name' => 'perusahaan', 'description' => 'Akun perusahaan'],
            ['name' => 'siswa', 'description' => 'Siswa aktif'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
