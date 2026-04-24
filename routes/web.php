<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController; // Lo avevamo creato noi
use App\Models\Post; // Serve per leggere i post dal DB
use Illuminate\Support\Facades\Route;

// 1. La Home: deve recuperare i post come facevamo prima
Route::get('/', function () {
    $posts = Post::latest()->get(); 
    return view('home', ['posts' => $posts]);
});

// 2. La rotta per salvare i post
Route::post('/post', [PostController::class, 'store']);

// 3. Le rotte di Breeze (Dashboard e Profilo)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';