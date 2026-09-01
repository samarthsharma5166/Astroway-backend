<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "--- Schema for ai_messages ---" . PHP_EOL;
$columns = DB::select("DESCRIBE ai_messages");
foreach ($columns as $col) {
    echo "Field: {$col->Field} | Type: {$col->Type} | Null: {$col->Null}" . PHP_EOL;
}

// Check recent Laravel error logs
echo "--- Last 20 lines of Laravel Log ---" . PHP_EOL;
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $lines = file($logFile);
    echo implode("", array_slice($lines, -20));
} else {
    echo "No log file found." . PHP_EOL;
}
