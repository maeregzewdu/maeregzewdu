<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Detect the base path depending on environment
$basePath = __DIR__.'/..';
if (file_exists(__DIR__.'/../repositories/maeregzewdu/vendor/autoload.php')) {
    $basePath = __DIR__.'/../repositories/maeregzewdu';
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $basePath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $basePath.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $basePath.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
