<?php

use App\Http\Controllers\Api\AccessTokenController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/access-tokens', [AccessTokenController::class, 'store'])
    ->middleware('guest:sanctum');

Route::delete('auth/access-tokens/{token?}', [AccessTokenController::class, 'destroy'])
    ->middleware('auth:sanctum');


    Route::group([
        'as'=>'api.',
       'middleware'=>'auth:sanctum',
    ], function () {
        Route::apiResource('posts', PostController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('users', UserController::class);

    });
