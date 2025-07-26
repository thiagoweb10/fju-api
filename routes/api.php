<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryApiController;


Route::get('/version', function () {
    return response()->json([
        'laravel_version' => app()->version()
    ]);
});

Route::apiResource('categories', CategoryApiController::class);