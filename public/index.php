<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Fix request path when app is in a subdirectory (e.g. XAMPP: /foodsystem/public)
$uri = $_SERVER['REQUEST_URI'] ?? '';
$base = '/foodsystem/public';
if (strpos($uri, $base) === 0) {
    $_SERVER['REQUEST_URI'] = substr($uri, strlen($base)) ?: '/';
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
