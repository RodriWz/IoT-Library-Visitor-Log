<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Cek mode maintenance
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Load autoloader Composer
require __DIR__.'/../vendor/autoload.php';

// Buat instance aplikasi
$app = require_once __DIR__.'/../bootstrap/app.php';

// Buat HTTP Kernel
$kernel = $app->make(Kernel::class);

// Tangani request dan kirim response
$response = $kernel->handle(
    $request = Request::capture()
)->send();

// Terminate aplikasi
$kernel->terminate($request, $response);