<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$flags = DB::table('system_flag')->where('name', 'LIKE', '%logo%')->orWhere('name', 'LIKE', '%image%')->orWhere('name', 'LIKE', '%icon%')->get();
echo "--- System flags related to logo/image/icon ---" . PHP_EOL;
foreach ($flags as $f) {
    echo "Name: {$f->name} | Value: {$f->value}" . PHP_EOL;
}
