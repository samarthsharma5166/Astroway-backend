<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$signs = DB::table('hororscope_signs')->select('id', 'name')->get();
echo "--- hororscope_signs Table ---" . PHP_EOL;
foreach ($signs as $s) {
    echo "ID: {$s->id} | Name: '{$s->name}'" . PHP_EOL;
}
