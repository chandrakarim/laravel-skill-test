<?php

use App\Http\Controllers\PostController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// cek user
Route::middleware('auth')->get('/user', function () {
    return Auth::user();
});
// cek all data user testing
Route::get('/all-users', function () {
    return User::all();
});

// Routes publik
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Routes untuk user login
Route::middleware(['auth'])->group(function () {
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Optional
    Route::get('/posts/create', fn () => 'posts.create')->name('posts.create');
    Route::get('/posts/{post}/edit', fn () => 'posts.edit')->name('posts.edit');
});
