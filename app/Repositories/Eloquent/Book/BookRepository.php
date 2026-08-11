<?php

namespace App\Repositories\Eloquent\Book;

use App\Models\Book\Book;
use App\Repositories\Interfaces\Book\BookInterfaceRepository;
use App\Repositories\Interfaces\Reader\ReaderInterfaceRepository;

class BookRepository implements BookInterfaceRepository
{
    public function __construct(
        protected ReaderInterfaceRepository $readerRepository
    ){}

    public function getAll()
    {
        return Book::query()
            ->with('author')
            ->get();
    }

    public function store(array $data): Book
    {
        $totalCopies = $data['total_copies'] ?? 1;
        return Book::query()->create([
            'author_id' => $data['author_id'],
            'title' => $data['title'],
            'isbn' => $data['isbn'],
            'description' => $data['description'] ?? null,
            'publication_year' => $data['publication_year'],
            'total_copies' => $totalCopies,
            'available_copies' => $totalCopies,
        ]);
    }

    public function update(Book $book, array $data): Book
    {
        $book->update([
            'author_id' => $data['author_id'],
            'title' => $data['title'],
            'isbn' => $data['isbn'],
            'description' => $data['description'],
            'publication_year' => $data['publication_year'],
            'total_copies' => $data['total_copies'] ?? $book->total_copies,
            'available_copies' => $data['available_copies'] ?? $book->available_copies,
        ]);

        return $book->fresh();
    }

    public function findById(int $id, ?bool $forLock = false): ?Book
    {
        $book = Book::query()
            ->with(['author', 'bookLoans'])
            ->where('id', $id);

        if ($forLock)
        {
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
        Book::query()->find($id)->update(['is_active' => true]);
    }

    public function findByAuthorId(int $id): ?Book
    {
        $book = Book::query()->where('author_id', $id);

        return $book ? $book->first() : null;
    }
}
