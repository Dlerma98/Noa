<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', [PostController::class, 'index'])->name('posts.index');

// CRUD de Posts (usando 'noa' como slug pero asignando el parámetro como 'post')
Route::resource('noa', PostController::class)
    ->names('posts')
    ->parameters(['noa' => 'post']);
Route::get("posts/myposts", [PostController::class, 'myPosts'])->name('posts.myposts');


// Rutas para Análisis
Route::resource('analyses', AnalysisController::class)
    ->names('analyses')
    ->parameters(['analyses' => 'analysis']);

// Grupo de rutas protegidas para usuarios autenticados
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUD completo de análisis, pero protegido para usuarios autenticados
    Route::resource('analyses', AnalysisController::class)->except(['index', 'show']);

    Route::get("post/myposts", [PostController::class, 'myPosts'])
        ->middleware('auth')
        ->name('post.myposts');

    // Rutas del perfil de usuario (solución a Route [profile.edit] not defined)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Logout (ya incluido en Jetstream, pero si necesitas llamarlo explícitamente)
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

