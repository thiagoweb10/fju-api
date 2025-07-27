<?php

use App\Exceptions\CategoryNotFoundException;
use Illuminate\Foundation\Configuration\Exceptions;

return function (Exceptions $exceptions) {
    $exceptions->render(function (CategoryNotFoundException $e, $request) {
        return response()->json([
            'error' => $e->getMessage(),
        ], 422); // ou o código HTTP que você quiser
    });
};
