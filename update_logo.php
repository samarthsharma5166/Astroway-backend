<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

echo "=== Updating Rudra Gram Logo on Server ===" . PHP_EOL;

$sourceLogo = __DIR__ . '/public/images/rudragram-logo.png';
if (!file_exists($sourceLogo)) {
    echo "ERROR: {$sourceLogo} does not exist!" . PHP_EOL;
    exit(1);
}

$logoContent = file_get_contents($sourceLogo);

// 1. Ensure target directories exist
$dirs = [
    __DIR__ . '/public/storage/images',
    __DIR__ . '/storage/app/public/images',
    __DIR__ . '/public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images',
    __DIR__ . '/public/assets-pg/imgs',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}

// 2. Overwrite known static/cached files
$filesToOverwrite = [
    __DIR__ . '/public/storage/images/AdminLogo1732085016.png',
    __DIR__ . '/public/storage/images/PartnerLogo1759135328.png',
    __DIR__ . '/storage/app/public/images/AdminLogo1732085016.png',
    __DIR__ . '/storage/app/public/images/PartnerLogo1759135328.png',
    __DIR__ . '/public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/astroway-logo.png',
];

foreach ($filesToOverwrite as $f) {
    file_put_contents($f, $logoContent);
    echo "Overwritten file: {$f}" . PHP_EOL;
}

// Overwrite all AdminLogo* and PartnerLogo* files in storage
foreach (glob(__DIR__ . '/public/storage/images/AdminLogo*') as $f) {
    file_put_contents($f, $logoContent);
    echo "Overwritten: {$f}" . PHP_EOL;
}
foreach (glob(__DIR__ . '/public/storage/images/PartnerLogo*') as $f) {
    file_put_contents($f, $logoContent);
    echo "Overwritten: {$f}" . PHP_EOL;
}
foreach (glob(__DIR__ . '/storage/app/public/images/AdminLogo*') as $f) {
    file_put_contents($f, $logoContent);
    echo "Overwritten: {$f}" . PHP_EOL;
}
foreach (glob(__DIR__ . '/storage/app/public/images/PartnerLogo*') as $f) {
    file_put_contents($f, $logoContent);
    echo "Overwritten: {$f}" . PHP_EOL;
}

// 3. Check systemflag database values and update files referenced in DB
try {
    $adminLogoFlag = DB::table('systemflag')->where('name', 'AdminLogo')->first();
    if ($adminLogoFlag && !empty($adminLogoFlag->value)) {
        echo "Current AdminLogo DB flag: {$adminLogoFlag->value}" . PHP_EOL;
        $dbPath1 = __DIR__ . '/public/' . ltrim($adminLogoFlag->value, '/');
        $dbPath2 = __DIR__ . '/' . ltrim($adminLogoFlag->value, '/');
        @file_put_contents($dbPath1, $logoContent);
        @file_put_contents($dbPath2, $logoContent);
    }

    $partnerLogoFlag = DB::table('systemflag')->where('name', 'PartnerLogo')->first();
    if ($partnerLogoFlag && !empty($partnerLogoFlag->value)) {
        echo "Current PartnerLogo DB flag: {$partnerLogoFlag->value}" . PHP_EOL;
        $dbPath1 = __DIR__ . '/public/' . ltrim($partnerLogoFlag->value, '/');
        $dbPath2 = __DIR__ . '/' . ltrim($partnerLogoFlag->value, '/');
        @file_put_contents($dbPath1, $logoContent);
        @file_put_contents($dbPath2, $logoContent);
    }
} catch (\Exception $e) {
    echo "DB notice: " . $e->getMessage() . PHP_EOL;
}

// 4. Clear all caches
Artisan::call('optimize:clear');
echo "Caches cleared successfully!" . PHP_EOL;
echo "=== Rudra Gram Logo update complete! ===" . PHP_EOL;
