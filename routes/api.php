<?php

use App\Http\Controllers\Author\AuthorController;

use App\Http\Controllers\Book\{
    BookController,
    BookLoansController
};

use App\Http\Controllers\Reader\ReadersController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::apiResource('authors', AuthorController::class);
    Route::patch('authors/restore/{id}', [AuthorController::class, 'restore']);

    Route::apiResource('books', BookController::class);
    Route::patch('books/restore/{id}', [BookController::class, 'restore']);

    Route::controller(BookLoansController::class)->prefix('books')->group(function() {
        Route::post('reserve', 'reserveBook');
        Route::patch('return-book/{loans_id}', 'returnBook');
        Route::patch('cancel/{loans_id}', 'cancelLoans');
    });

    Route::apiResource('readers', ReadersController::class);
    Route::patch('readers/restore/{id}', [ReadersController::class, 'restore']);
});
