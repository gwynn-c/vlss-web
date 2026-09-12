<?php

use App\Http\Middleware\ApplyContentOverrides;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Unauthenticated admin visitors are sent to the admin login screen.
        $middleware->redirectGuestsTo(fn () => route('admin.login'));

        // Overlay admin-edited content on top of the config defaults, per request.
        $middleware->web(append: [ApplyContentOverrides::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
