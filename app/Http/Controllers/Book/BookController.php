<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookRequest;
use App\Services\Book\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService
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
}
