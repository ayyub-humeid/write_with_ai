<?php

use App\Http\Controllers\Post\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/',[PostController::class,'index'])->name('posts.index');
Route::get('/posts/{post}',[PostController::class,'show'])->name('posts.show');
// --- Dashboard ---
@include_once('dashboard.php');
// --- Dashboard ---