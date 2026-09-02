<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

echo "=== Updating Rudra Gram Logo on Server ===" . PHP_EOL;

$sourceLogo = __DIR__ . '/public/images/rudragram-logo.png';
if (!file_exists($sourceLogo)) {
    echo "ERROR: {$sourceLogo} does not exist!" . PHP_EOL;
    exit(1);
}

$logoContent = file_get_contents($sourceLogo);

// 1. Ensure target storage and frontend directories exist
$dirs = [
    public_path('storage/images'),
    storage_path('app/public/images'),
    public_path('frontend/astrowaycdn/dashaspeaks/web/content/astroway/images'),
    public_path('assets-pg/imgs'),
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }
}

// 2. Overwrite known static/cached files
$knownFiles = [
    public_path('frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/astroway-logo.png'),
    public_path('assets-pg/imgs/logo-for-site.png'),
];
foreach ($knownFiles as $f) {
    @file_put_contents($f, $logoContent);
    echo "Overwritten static file: {$f}" . PHP_EOL;
}

// Overwrite all existing AdminLogo* and PartnerLogo* files in public/storage and storage/app/public
$patterns = [
    public_path('storage/images/AdminLogo*'),
    public_path('storage/images/PartnerLogo*'),
    storage_path('app/public/images/AdminLogo*'),
    storage_path('app/public/images/PartnerLogo*'),
];
foreach ($patterns as $pat) {
    foreach (glob($pat) as $f) {
        @file_put_contents($f, $logoContent);
        echo "Overwritten existing logo file: " . basename($f) . PHP_EOL;
    }
}

// 3. Create fresh timestamped filenames to completely bust browser cache
$timestamp = time();
$newAdminLogoName = 'AdminLogo' . $timestamp . '.png';
$newPartnerLogoName = 'PartnerLogo' . $timestamp . '.png';

$newAdminPathPublic = public_path('storage/images/' . $newAdminLogoName);
$newAdminPathStorage = storage_path('app/public/images/' . $newAdminLogoName);
@file_put_contents($newAdminPathPublic, $logoContent);
@file_put_contents($newAdminPathStorage, $logoContent);

$newPartnerPathPublic = public_path('storage/images/' . $newPartnerLogoName);
$newPartnerPathStorage = storage_path('app/public/images/' . $newPartnerLogoName);
@file_put_contents($newPartnerPathPublic, $logoContent);
@file_put_contents($newPartnerPathStorage, $logoContent);

echo "Created new cache-busted logo files: {$newAdminLogoName} and {$newPartnerLogoName}" . PHP_EOL;

// 4. Update the systemflag database records with the new files
try {
    // Update AdminLogo
    $affectedAdmin = DB::table('systemflag')
        ->where('name', 'AdminLogo')
        ->update(['value' => 'public/storage/images/' . $newAdminLogoName]);
    echo "Updated AdminLogo in systemflag table (rows affected: {$affectedAdmin})" . PHP_EOL;

    // Update PartnerLogo
    $affectedPartner = DB::table('systemflag')
        ->where('name', 'PartnerLogo')
        ->update(['value' => 'public/storage/images/' . $newPartnerLogoName]);
    echo "Updated PartnerLogo in systemflag table (rows affected: {$affectedPartner})" . PHP_EOL;
} catch (\Exception $e) {
    echo "Database error: " . $e->getMessage() . PHP_EOL;
}

// 5. Clear all Laravel caches
Artisan::call('optimize:clear');
echo "Laravel caches cleared (optimize:clear)!" . PHP_EOL;
echo "=== Rudra Gram Logo successfully deployed! ===" . PHP_EOL;
