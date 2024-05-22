<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::get('/posts', [PostController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts', [PostController::class, 'store'])->middleware('role:admin,user');
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('role:admin,user');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('role:admin');

    Route::get('/comments', [CommentController::class, 'index']);
    Route::post('/comments', [CommentController::class, 'store'])->middleware('role:admin,user');
    Route::get('/comments/{comment}', [CommentController::class, 'show']);
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->middleware('role:admin,user');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->middleware('role:admin');
});
