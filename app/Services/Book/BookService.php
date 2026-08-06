<?php

namespace App\Services\Book;

use App\Models\Book\Book;
use App\Repositories\Interfaces\Book\BookInterfaceRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookService
{
    public function __construct(
        protected BookInterfaceRepository $bookRepository
    ){}

    public function getAll()
    {
        return $this->bookRepository->getAll();
    }

    public function store(array $data): Book
    {
        return $this->bookRepository->store($data);
    }

    public function update(int $id, array $data): Book
    {
        $book = $this->findById($id);

        return $this->bookRepository->update($book, $data);
    }

    public function findById(int $id): ?Book
    {
        $book = $this->bookRepository->findById($id);

        if ( ! $book ) throw new ModelNotFoundException('Livro não localizado');

        return $book;
    }

    public function delete(int $id): void
    {
        $this->bookRepository->delete($id);
    }

    public function restore(int $id): void
    {
        $this->bookRepository->restore($id);
    }
}
