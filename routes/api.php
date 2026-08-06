<?php

use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Book\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::resource('author', AuthorController::class);
    Route::patch('author/restore/{id}', [AuthorController::class, 'restore']);

    Route::resource('book', BookController::class);
    Route::patch('book/restore/{id}', [BookController::class, 'restore']);
});
