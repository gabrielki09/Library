<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookRequest;
use App\Http\Requests\Book\ReserveBookRequest;
use App\Services\Book\BookLoansService;
use App\Services\Book\BookService;

class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService,
        protected BookLoansService $bookLoansService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return apiSuccess(
            'Todos os livros',
            [
                'books' => $this->bookService->getAll()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $req)
    {
        return apiSuccess(
            'Livro cadastrado com sucesso!',
            [
                'book' => $this->bookService->store($req->validated())
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return apiSuccess(
            'Livro localizado com sucesso!',
            [
                'book' => $this->bookService->findById($id)
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $req, int $id)
    {
        return apiSuccess(
            'Livro alterado com sucesso!',
            [
                'book' => $this->bookService->update($id, $req->validated())
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->bookService->delete($id);
        return apiSuccess(
            'Livro desativado com sucesso!'
        );
    }

    public function restore(string $id)
    {
        $this->bookService->restore($id);
        return apiSuccess(
            'Livro reativado com sucesso!',
        );
    }

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
            'Empréstimo cancelado com com sucesso!',
            [
                'loans' => $canceledLoans
            ]
        );
    }
}
