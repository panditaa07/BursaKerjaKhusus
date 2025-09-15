<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\JobPost;

$duplicates = JobPost::select('title', 'company_id', \DB::raw('COUNT(*) as count'))
    ->groupBy('title', 'company_id')
    ->having('count', '>', 1)
    ->get();

echo "Duplicates found:\n";
foreach ($duplicates as $d) {
    echo "Title: {$d->title}, Company: {$d->company_id}, Count: {$d->count}\n";
}

if ($duplicates->isEmpty()) {
    echo "No duplicates found.\n";
}
