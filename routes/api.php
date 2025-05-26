<?php

use App\Http\Controllers\api\ActivityController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CardCollectionController;
use App\Http\Controllers\api\CardController;
use App\Http\Controllers\api\CardResultController;
use App\Http\Controllers\api\DailyTestController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\CardEndCoefficientController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/t', [CardEndCoefficientController::class, 'updateEndCoefficient']);
Route::get('/tt', [DailyTestController::class, 'generateDailyTest']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'user']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('card_collections', CardCollectionController::class);
    Route::apiResource('cards', CardController::class);
    Route::apiResource('activities', ActivityController::class);
    Route::apiResource('card_results', CardResultController::class);
});
