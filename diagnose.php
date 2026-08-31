<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Horoscope;
use Carbon\Carbon;

echo 'Server Date: ' . Carbon::now()->format('Y-m-d') . PHP_EOL;

$records = DB::table('horoscopes')
    ->select('type', 'langcode', 'zodiac', 'date', 'start_date', 'end_date')
    ->orderBy('created_at', 'DESC')
    ->limit(10)
    ->get();

echo "--- Last 10 Horoscope Entries ---" . PHP_EOL;
foreach ($records as $r) {
    echo "Type: {$r->type} | Lang: {$r->langcode} | Zodiac: {$r->zodiac} | Date: {$r->date} | Start: {$r->start_date} | End: {$r->end_date}" . PHP_EOL;
}

echo "--- Unique dates in DB ---" . PHP_EOL;
$dates = DB::table('horoscopes')->select('date')->distinct()->orderBy('date', 'DESC')->limit(5)->pluck('date');
foreach ($dates as $d) {
    echo "Date: $d" . PHP_EOL;
}

echo "--- Unique types in DB ---" . PHP_EOL;
$types = DB::table('horoscopes')->select('type')->distinct()->pluck('type');
foreach ($types as $t) {
    echo "Type: $t" . PHP_EOL;
}
