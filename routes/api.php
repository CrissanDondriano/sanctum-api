<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('comments', CommentController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('comments', CommentController::class)->except(['create', 'edit']);
});


