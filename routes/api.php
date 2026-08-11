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


    Route::prefix('books-loans')
        ->controller(BookLoanController::class)
        ->group(function () {
            Route::post('/', 'store');
            Route::patch('{loans_id}/return', 'returnBook');
            Route::patch('{loans_id}/cancel', 'cancelLoans');
        });

    Route::apiResource('readers', ReadersController::class);
    Route::patch('readers/restore/{id}', [ReadersController::class, 'restore']);
});
