<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

 Route::group([
        'as' => 'admin.',
        'prefix' => 'admin',
        'middleware'=>'auth'
    ], function () {
        Route::resource('roles',RoleController::class)->middleware('type:super-admin');
        Route::resource('users', UserController::class)->only(['index', 'edit', 'update'])->middleware('type:super-admin');
    });
