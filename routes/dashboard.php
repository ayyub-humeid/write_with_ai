<?php

use App\Http\Controllers\Dashboard\AiWriteController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\PostController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    // Route::get('/',function(){
    //     return view('dashboard.index');
    // })->name('index');
    Route::resource('/posts', PostController::class)->middleware('auth');
    // Route::get('/posts/{post}/comments', [PostController::class, 'comments'])->middleware('auth')->name('posts.comments');
    Route::resource('/categories', CategoryController::class)->middleware('auth');
    
    Route::any('/ai-write',AiWriteController::class)->name('posts.ai');

    Route::group([
        'as' => 'notifications.',
        'prefix' => 'notifications',
        'controller' => NotificationController::class,
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::post('/mark-all-read', 'markAllRead')->name('markAllRead');
        Route::patch('/{id}/read', 'read')->name('read');
        Route::patch('/{id}/unread', 'unread')->name('unread');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
});
