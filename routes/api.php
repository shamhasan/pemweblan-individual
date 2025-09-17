<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', fn() => User::with('posts.comments')->get());
Route::get('/posts', fn() => Post::with('user', 'comments')->get());
Route::get('/comments', fn() => Comment::with('post.user')->get());

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::post('/posts', [PostController::class, 'store']);
// semua post
Route::get('/posts', [PostController::class, 'index']);
// detail 1 post
Route::get('/posts/{post}', [PostController::class, 'show']);

Route::put('/posts/{post}', [PostController::class, 'update']);
Route::patch('/posts/{post}', [PostController::class, 'update']);

Route::delete('/posts/{post}', [PostController::class, 'destroy']);


// Create Comment
Route::post('/posts/{post}/comments', [CommentController::class,
'store']);
Route::post('/posts/comments', [CommentController::class, 'store']);
// Read Comment
Route::get('/posts/{post}/comments', [CommentController::class,
'index']);
Route::get('/comments/{id}', [CommentController::class, 'showById']);
// Update
Route::put('/comments/{id}', [CommentController::class, 'update']);
// Delete
Route::delete('/comments/{id}', [CommentController::class,
'destroy']);
