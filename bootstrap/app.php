<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Güvenlik header'ları ekle
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Production'da detaylı hata mesajlarını gizle
        if (app()->environment('production')) {
            $exceptions->shouldRenderJsonWhen(function ($request, Throwable $e) {
                return $request->expectsJson();
            });
        }
    })->create();
