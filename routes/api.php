<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CardCollectionController;
use App\Http\Controllers\api\CardController;
use App\Http\Controllers\api\CardEndCoefficientController;
use App\Http\Controllers\api\CardResultController;
use App\Http\Controllers\api\DailyTestController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\signedConsume;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'user']);

    Route::apiResource('users', UserController::class);
    Route::post('/user/update', [UserController::class, 'update']);
    Route::apiResource('card_collections', CardCollectionController::class);
    Route::get('card_collection/shared', [CardCollectionController::class, 'getSharedCollections']);
    Route::apiResource('cards', CardController::class);
    Route::apiResource('card_results', CardResultController::class);
    Route::post('/card_result/daily', [CardResultController::class, 'storeDaily']);
    Route::get('/collection_statistics/{id}', [CardEndCoefficientController::class, 'returnStatistics']);
    Route::get('/daily_test/{id}', [DailyTestController::class, 'show']);
    Route::post('/daily_test/{id}', [DailyTestController::class, 'store']);
    Route::get('/daily_test/info/{id}', [DailyTestController::class, 'testInfo']);
    Route::get('/checkOwner/{id}', [CardCollectionController::class, 'checkIfNotOwner']);
    Route::get('/card_collections/generateURL/{id}', [CardCollectionController::class, 'generateCollectionShareLink']);
    Route::post('/card_collections/shared/{id}', [CardCollectionController::class, 'receiveSharedCollection'])
        ->name('CollectionShareLink')
        ->middleware(signedConsume::class);
    Route::get('/t', [CardEndCoefficientController::class, 'updateEndCoefficient']);
    Route::get('/tt', [DailyTestController::class, 'generateDailyTest']);
});
