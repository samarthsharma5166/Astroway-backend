<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$req = new \Illuminate\Http\Request();
$req->replace(['horoscopeSignId' => 1, 'langcode' => 'en']);
$controller = new \App\Http\Controllers\API\User\DailyHoroscopeController();
$response = $controller->getDailyHoroscope($req);

echo "Controller Response:" . PHP_EOL;
echo json_encode(json_decode($response->getContent()), JSON_PRETTY_PRINT) . PHP_EOL;
