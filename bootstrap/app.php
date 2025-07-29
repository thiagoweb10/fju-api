<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($e instanceof NotFoundHttpException) {
                $previous = $e->getPrevious();

                if ($previous instanceof ModelNotFoundException) {
                    $model = class_basename($previous->getModel());
                    $ids = $previous->getIds();

                    return response()->json([
                        'success' => false,
                        'message' => "Registro do tipo {$model} com ID {$ids[0]} não foi encontrado.",
                    ], 404);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Recurso não encontrado.',
                ], 404);
            }
        });
    })
    ->withProviders([
        App\Providers\AppServiceProvider::class,
    ])
    ->create();
