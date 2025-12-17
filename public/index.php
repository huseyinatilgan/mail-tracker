<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// PHP 8.5 deprecated uyarılarını bastır (Laravel vendor dosyalarından gelen PDO uyarıları)
// Bu uyarılar Laravel framework'ün gelecek güncellemelerinde düzelecek
if (PHP_VERSION_ID >= 80500) {
    // Sadece PDO deprecated uyarılarını bastır, diğer hataları göster
    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        // PDO::MYSQL_ATTR_SSL_CA deprecated uyarılarını görmezden gel
        if ($errno === E_DEPRECATED && strpos($errstr, 'PDO::MYSQL_ATTR_SSL_CA') !== false) {
            return true; // Uyarıyı bastır
        }
        return false; // Diğer hataları normal şekilde işle
    }, E_DEPRECATED);
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
