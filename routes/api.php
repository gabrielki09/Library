<?php

use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Reader\ReadersController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::resource('author', AuthorController::class);
    Route::patch('author/restore/{id}', [AuthorController::class, 'restore']);

    Route::resource('book', BookController::class);
    Route::patch('book/restore/{id}', [BookController::class, 'restore']);
    Route::post('book/reserve', [BookController::class, 'reserveBook']);

    Route::resource('reader', ReadersController::class);
    Route::patch('reader/restore/{id}', [ReadersController::class, 'restore']);
});
