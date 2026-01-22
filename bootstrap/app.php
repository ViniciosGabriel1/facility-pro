<?php

use App\Exceptions\DomainException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })

    ->withExceptions(function ($exceptions) {
        $exceptions->renderable(function (
            DomainException $e,
            Request $request
        ) {
            return response()->json([
                'message' => $e->getMessage(),
                'keyCode' => $e->keyCode(),
                'errors'  => $e->payload(),
            ], $e->status());
        });
    })->create();
