<?php

use App\Http\Controllers\Dashboard\PostController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    // Route::get('/',function(){
    //     return view('dashboard.index');
    // })->name('index');
    Route::resource('/posts', PostController::class);
});
