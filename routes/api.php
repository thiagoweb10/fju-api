<?php

use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ChampionshipApiController;
use App\Http\Controllers\Api\RoundApiController;
use Illuminate\Support\Facades\Route;

Route::get('/version', function () {
    return response()->json([
        'laravel_version' => app()->version(),
    ]);
});

Route::apiResource('categories', CategoryApiController::class);
Route::apiResource('championships', ChampionshipApiController::class);
Route::apiResource('rounds', RoundApiController::class);
