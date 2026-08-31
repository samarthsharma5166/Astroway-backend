<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Jobs\GenerateDailyHoroscopeJob;
use App\Jobs\GenerateWeeklyHoroscopeJob;
use App\Jobs\GenerateYearlyHoroscopeJob;

echo "Generating Daily Horoscopes..." . PHP_EOL;
try {
    GenerateDailyHoroscopeJob::dispatchSync();
    echo "Daily Horoscopes Generated Successfully!" . PHP_EOL;
} catch (\Exception $e) {
    echo "Error generating daily: " . $e->getMessage() . PHP_EOL;
}

echo "Generating Weekly Horoscopes..." . PHP_EOL;
try {
    GenerateWeeklyHoroscopeJob::dispatchSync();
    echo "Weekly Horoscopes Generated Successfully!" . PHP_EOL;
} catch (\Exception $e) {
    echo "Error generating weekly: " . $e->getMessage() . PHP_EOL;
}

echo "Generating Yearly Horoscopes..." . PHP_EOL;
try {
    GenerateYearlyHoroscopeJob::dispatchSync();
    echo "Yearly Horoscopes Generated Successfully!" . PHP_EOL;
} catch (\Exception $e) {
    echo "Error generating yearly: " . $e->getMessage() . PHP_EOL;
}
