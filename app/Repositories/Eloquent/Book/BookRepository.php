<?php

namespace App\Repositories\Eloquent\Book;

use App\Models\Book\Book;
use App\Repositories\Interfaces\Book\BookInterfaceRepository;

class BookRepository implements BookInterfaceRepository
{
    public function getAll()
    {
        return Book::query()
            ->with('author')
            ->get();
    }

    public function store(array $data): Book
    {
        return Book::query()->create($data);
    }

    /**
     * $data['available_copies'] é recebido pelo service para o update por validar livros já emprestados
     */
    public function update(Book $book, array $data): Book
    {
        $book->update($data);

        return $book->fresh();
    }

    public function findById(int $id, ?bool $forLock = false): ?Book
    {
        $book = Book::query()
            ->with(['author', 'bookLoans'])
            ->where('id', $id);

        if ($forLock) {
            $book->lockForUpdate();
        }

        return $book->first();
    }

    public function delete(int $id): void
    {
        Book::query()->find($id)->update(['is_active' => false]);
    }

    public function restore(int $id): void
    {
        Book::query()->findOrFail($id)->update(['is_active' => true]);
    }
}
