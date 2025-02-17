<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

// ✅ Rutas que cualquier usuario puede ver (incluso invitados)
Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('analyses', [AnalysisController::class, 'index'])->name('analyses.index');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('analyses/{analysis}', [AnalysisController::class, 'show'])->name('analyses.show');

// ✅ Rutas protegidas para usuarios autenticados
Route::middleware(['auth'])->group(function () {

    // 🔹 Rutas solo para Administradores
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('genres', GenreController::class);
        Route::resource('users', ProfileController::class);
    });

    // 🔹 Rutas solo para Redactores
    Route::middleware(['role:redactor'])->group(function () {
        Route::resource('posts', PostController::class)->except(['index', 'show']);
        Route::get('myposts', [PostController::class, 'myPosts'])->name('posts.myposts');

        Route::resource('analyses', AnalysisController::class)->except(['index', 'show']);
        Route::get('myanalyses', [AnalysisController::class, 'myAnalyses'])->name('analysis.myanalyses');
    });

    // 🔹 Rutas del Perfil del Usuario (para cualquier autenticado)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'logout'])->name('profile.logout');
});

// ✅ Ruta de logout
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


