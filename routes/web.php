<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController; // Lo avevamo creato noi
use App\Http\Controllers\ProfileController;
use App\Models\Post; // Serve per leggere i post dal DB
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ChatController;

// 1. La Home: deve recuperare i post come facevamo prima
Route::get('/', [PostController::class, 'index'])->name('home');

// 2. La rotta per salvare i post (AGGIUNTO IL NOME)
Route::post('/post', [PostController::class, 'store'])->name('post.store');

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

Route::delete('/post/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('post.destroy');

Route::post('/post/{post}/like', [LikeController::class, 'store'])->middleware('auth')->name('post.like');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Pagina con il form per modificare il profilo
Route::get('/profilo/{user:username}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');

// Azione che salva i dati nel database
Route::put('/profilo/{user:username}', [UserController::class, 'update'])->name('users.update')->middleware('auth');

// La rotta usa {user:username} per cercare l'utente tramite il suo username invece che l'ID
Route::get('/profilo/{user:username}', [UserController::class, 'show'])->name('users.show');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::post('/user/{user}/follow', [UserController::class, 'toggleFollow'])->name('user.follow')->middleware('auth');

Route::get('/chat/{user:username}', [ChatController::class, 'show'])->name('chat.show');

Route::post('/chat/{user:username}', [ChatController::class, 'store'])->name('chat.store');

Route::get('/messaggi', [ChatController::class, 'index'])->name('chat.index');

Route::get('/esplora', [UserController::class, 'index'])->name('explore')->middleware('auth');