<?php

use App\Http\Controllers\Post\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/',[PostController::class,'index'])->name('posts.index');
Route::get('/posts/{post}',[PostController::class,'show'])->name('posts.show');
Route::get('/posts/{post}/comments', [PostController::class, 'getComments'])->name('posts.comments');
// --- Dashboard ---
@include_once('dashboard.php');
// --- Dashboard ---
