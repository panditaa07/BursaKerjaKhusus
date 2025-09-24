<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$role = App\Models\Role::where('name', 'company')->first();

if ($role) {
    echo "Company role ID: " . $role->id . "\n";

    $user = App\Models\User::where('email', 'company@bkk.com')->first();

    if ($user) {
        $user->role_id = $role->id;
        $user->save();
        echo "User role updated successfully.\n";
    } else {
        echo "User not found.\n";
    }
} else {
    echo "Role not found.\n";
}
