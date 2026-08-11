<?php

use App\Http\Controllers\Author\AuthorController;

use App\Http\Controllers\Book\{
    BookController,
    BookLoanController
};

use App\Http\Controllers\Reader\ReadersController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('authors', AuthorController::class);
    Route::patch('authors/restore/{id}', [AuthorController::class, 'restore']);

    Route::apiResource('books', BookController::class);
    Route::patch('books/restore/{id}', [BookController::class, 'restore']);


    Route::prefix('book-loans')
        ->controller(BookLoanController::class)
        ->group(function () {
            Route::post('/', 'store');
            Route::patch('{loanId}/return', 'returnBook');
            Route::patch('{loanId}/cancel', 'cancelLoans');
        });

    Route::apiResource('readers', ReadersController::class);
    Route::patch('readers/restore/{id}', [ReadersController::class, 'restore']);
});
