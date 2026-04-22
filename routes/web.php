<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/', [ArticleController::class, 'indexWeb']);
Route::get('/articles', [ArticleController::class, 'indexWeb'])->name('articles.index');
Route::get('/articles/create', [ArticleController::class, 'createWeb'])->name('articles.create');
Route::post('/articles', [ArticleController::class, 'storeWeb'])->name('articles.store');
Route::get('/articles/{id}/edit', [ArticleController::class, 'editWeb'])->name('articles.edit');
Route::put('/articles/{id}', [ArticleController::class, 'updateWeb'])->name('articles.update');
Route::delete('/articles/{id}', [ArticleController::class, 'destroyWeb'])->name('articles.destroy');