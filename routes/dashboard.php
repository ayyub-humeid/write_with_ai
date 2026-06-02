<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    // Route::get('/',function(){
    //     return view('dashboard.index');
    // })->name('index');
    Route::resource('/posts', PostController::class)->middleware('auth');
    Route::get('/posts/{post}/comments', [PostController::class, 'comments'])->middleware('auth')->name('posts.comments');
    Route::resource('/categories', CategoryController::class)->middleware('auth');
});
