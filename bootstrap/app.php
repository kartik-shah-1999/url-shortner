<?php

use App\Http\Middleware\InviteMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Middleware\UrlshortnerMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'invitemiddleware' => InviteMiddleware::class,
            'superadminmiddleware' => SuperAdminMiddleware::class,
            'urlshortnermiddleware' => UrlshortnerMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
