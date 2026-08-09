<?php

use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Reader\ReadersController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::apiResource('author', AuthorController::class);
    Route::patch('author/restore/{id}', [AuthorController::class, 'restore']);

    Route::apiResource('book', BookController::class);
    Route::controller(BookController::class)->prefix('book')->group(function() {
        Route::post('reserve', 'reserveBook');
        Route::patch('restore/{id}','restore');
        Route::patch('return-book/{loans_id}', 'returnBook');
        Route::patch('cancel/{loans_id}', 'cancelLoans');
    });

    Route::apiResource('reader', ReadersController::class);
    Route::patch('reader/restore/{id}', [ReadersController::class, 'restore']);
});
