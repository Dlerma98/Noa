<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentReactionController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ProfileController;



//  Rutas protegidas para usuarios autenticados



    //  Rutas solo para Redactores y administradores
    Route::middleware(['role:admin|redactor'])->group(function () {
        Route::resource('posts', PostController::class)->except(['index', 'show']);

        Route::resource('analyses', AnalysisController::class)->except(['index', 'show']);

        Route::get('myposts', [PostController::class, 'myPosts'])->name('posts.myposts');
        Route::get('myanalyses', [AnalysisController::class, 'myAnalyses'])->name('analysis.myanalyses');
    });

//  Rutas solo para Administradores
Route::middleware(['role:admin'])->group(function () {
    Route::resource('genres', GenreController::class);
    Route::resource('users', ProfileController::class);
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::patch('/admin/make-redactor/{user}', [AdminController::class, 'makeRedactor'])->name('admin.makeRedactor');
    Route::patch('/admin/make-lector/{user}', [AdminController::class, 'makeLector'])->name('admin.makeLector');

});

    //  Rutas del Perfil del Usuario (para cualquier autenticado)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'logout'])->name('profile.logout');



//  Rutas que cualquier usuario puede ver (incluso invitados)
Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('analyses', [AnalysisController::class, 'index'])->name('analyses.index');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('posts/pdf/{post}', [PostController::class, 'generatePdf'])->name('posts.pdf');
Route::get('analyses/{analysis}', [AnalysisController::class, 'show'])->name('analyses.show');



//  Ruta de logout
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/reactions', [CommentReactionController::class, 'store'])->name('comments.reactions.store');

});

