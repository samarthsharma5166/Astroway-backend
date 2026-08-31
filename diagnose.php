<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

// Calculate current week range exactly like DailyHoroscopeController
$currentDate = new DateTime();
$currentDate->setISODate((int)$currentDate->format('o'), (int)$currentDate->format('W'), 1);
$startOfWeekFormatted = $currentDate->format('Y-m-d');
$currentDate->modify('+6 days');
$endOfWeekFormatted = $currentDate->format('Y-m-d');

echo "Controller Expected Start of Week: $startOfWeekFormatted" . PHP_EOL;
echo "Controller Expected End of Week: $endOfWeekFormatted" . PHP_EOL;

// Fetch any weekly horoscopes
$weeklyInDb = DB::table('horoscopes')
    ->where('type', 2) // WEEKLY_HORSCOPE
    ->orderBy('created_at', 'DESC')
    ->limit(5)
    ->get();

echo "--- Weekly Horoscopes in DB ---" . PHP_EOL;
if ($weeklyInDb->isEmpty()) {
    echo "No weekly horoscopes found in DB!" . PHP_EOL;
} else {
    foreach ($weeklyInDb as $w) {
        echo "Zodiac: {$w->zodiac} | Date: {$w->date} | Start Date: {$w->start_date} | End Date: {$w->end_date} | Lang: {$w->langcode}" . PHP_EOL;
    }
}
