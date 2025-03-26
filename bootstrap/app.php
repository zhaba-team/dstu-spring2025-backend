<?php

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckUserOwnership;
use Illuminate\Foundation\Application;
use App\Http\Middleware\Role;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web:      __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health:   '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => Role::class,
            'checkUserOwnership' => CheckUserOwnership::class
        ]);
        $middleware->validateCsrfTokens(['api/*']);
        $middleware->trustProxies(at: ['127.0.0.1', '192.168.65.1/16', '92.63.102.181']);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
