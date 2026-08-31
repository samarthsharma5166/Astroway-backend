<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Horoscope;

$key = DB::table('systemflag')->where('name', 'vedicAstroAPI')->value('value');
echo 'API Key: ' . ($key ? $key : 'EMPTY') . PHP_EOL;
echo 'DB Row Count: ' . Horoscope::count() . PHP_EOL;

if ($key) {
    $url = 'https://api.vedicastroapi.com/v3-json/prediction/daily-moon?zodiac=1&date=' . date('d/m/Y') . '&show_same=true&lang=en&api_key=' . $key;
    echo "Calling URL: $url" . PHP_EOL;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($ch);
    echo 'API Response: ' . $res . PHP_EOL;
    curl_close($ch);
}
