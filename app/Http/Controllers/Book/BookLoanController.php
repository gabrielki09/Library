<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookLoanCreateRequest;
use App\Services\Book\BookLoanService;

class BookLoanController extends Controller
{
    public function __construct(
        protected BookLoanService $bookLoanService
    ){}

    public function store(BookLoanCreateRequest $req)
    {
        $bookLoans = $this->bookLoanService->store($req->validated());

        return apiSuccess(
            'Empréstimo realizado com sucesso!',
            [
                'loan' => $bookLoans
            ]
        );
    }

    public function returnBook(int $loanId)
    {
        $returnedBook = $this->bookLoanService->returnBook($loanId);

        return apiSuccess(
            'Livro devolvido com sucesso!',
            [
                'loan' => $returnedBook
            ]
        );
    }

    public function cancelLoans(int $loanId)
    {
        $canceledLoan = $this->bookLoanService->cancelLoans($loanId);

        return apiSuccess(
            'Empréstimo cancelado com sucesso!',
            [
                'loan' => $canceledLoan
            ]
        );
    }
}
