<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\JobPost;

$statuses = JobPost::select('status', \DB::raw('COUNT(*) as count'))
    ->groupBy('status')
    ->get();

echo "Status distribution:\n";
foreach ($statuses as $s) {
    echo "Status: {$s->status}, Count: {$s->count}\n";
}
