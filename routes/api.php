<?php

use App\Http\Controllers\Api\AnalysisApiController;
use App\Http\Controllers\Api\PostApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/posts', [PostApiController::class, 'index'])->name('api.posts.index');
Route::get('/analyses', [AnalysisApiController::class, 'index'])->name('api.analyses.index');
