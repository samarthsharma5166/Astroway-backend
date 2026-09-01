<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "--- Altering ai_messages table ---" . PHP_EOL;
try {
    DB::statement("ALTER TABLE ai_messages MODIFY COLUMN image LONGTEXT NULL");
    DB::statement("ALTER TABLE ai_messages MODIFY COLUMN content LONGTEXT NOT NULL");
    echo "SUCCESS: Column types updated to LONGTEXT!" . PHP_EOL;
} catch (\Exception $e) {
    echo "Error updating columns: " . $e->getMessage() . PHP_EOL;
}

echo "--- Updated Schema for ai_messages ---" . PHP_EOL;
$columns = DB::select("DESCRIBE ai_messages");
foreach ($columns as $col) {
    echo "Field: {$col->Field} | Type: {$col->Type} | Null: {$col->Null}" . PHP_EOL;
}
