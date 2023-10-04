<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/// Auth Routes
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::get('/me', [AuthController::class,'me'])->middleware('auth:api');
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:api');
Route::post('/update-profile', [AuthController::class,'updateProfile'])->middleware('auth:api');

// post routes
Route::get('/posts', [PostController::class,'index'])->middleware('auth:api');
Route::get('/posts/{id}', [PostController::class,'show']);
Route::post('/posts', [PostController::class,'store'])->middleware('auth:api');
Route::post('/posts/{id}', [PostController::class,'update'])->middleware('auth:api');
Route::delete('/posts/{id}', [PostController::class,'destroy'])->middleware('auth:api');

// comment routes
Route::get('/posts/{postId}/comments', [CommentController::class,'show'])->middleware('auth:api');
Route::post('/posts/{postId}/comments', [CommentController::class,'store'])->middleware('auth:api');
Route::post('/posts/comments/{id}', [CommentController::class,'update'])->middleware('auth:api');
Route::delete('/posts/comments/{id}', [CommentController::class,'destroy'])->middleware('auth:api');

// like routes
Route::get('/posts/{postId}/likes', [LikeController::class,'show'])->middleware('auth:api');
Route::post('/posts/{postId}/likes', [LikeController::class,'toggleLike'])->middleware('auth:api');

/// follow routes
Route::post('/follow', [FollowController::class,'follow'])->middleware('auth:api');
Route::post('/unfollow', [FollowController::class,'unFollow'])->middleware('auth:api');
