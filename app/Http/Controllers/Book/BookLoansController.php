<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\ReserveBookRequest;
use App\Services\Book\BookLoansService;

class BookLoansController extends Controller
{
    public function __construct(
        protected BookLoansService $bookLoansService
    ){}

    public function reserveBook(ReserveBookRequest $req)
    {
        $bookLoans = $this->bookLoansService->store($req->validated());

        return apiSuccess(
            'Livro reservado com sucesso!',
            [
                'loans' => $bookLoans
            ]
        );
    }

    public function returnBook(int $loansId)
    {
        $returnedBook = $this->bookLoansService->returnBook($loansId);

        return apiSuccess(
            'Livro devolvido com sucesso!',
            [
                'loans' => $returnedBook
            ]
        );
    }

    public function cancelLoans(int $loansId)
    {
        $canceledLoans = $this->bookLoansService->cancelLoans($loansId);

        return apiSuccess(
            'Empréstimo cancelado com sucesso!',
            [
                'loans' => $canceledLoans
            ]
        );
    }
}
