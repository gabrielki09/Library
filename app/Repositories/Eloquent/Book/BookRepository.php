<?php

namespace App\Repositories\Eloquent\Book;

use App\Models\Book\Book;
use App\Repositories\Interfaces\Book\BookInterfaceRepository;

class BookRepository implements BookInterfaceRepository
{
    public function getAll()
    {
        return Book::all();
    }

    public function store(array $data): Book
    {
        return Book::query()->create([
            'author_id' => $data['author_id'],
            'title' => $data['title'],
            'isbn' => $data['isbn'],
            'description' => $data['description'],
            'publication_year' => $data['publication_year'],
            'total_copies' => $data['total_copies'],
            'available_copies' => $data['available_copies'],
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
            'total_copies' => $data['total_copies'],
            'available_copies' => $data['available_copies'],
        ]);
        $book->fresh();

        return $book;
    }

    public function findById(int $id): ?Book
    {
        return Book::query()->find($id);
    }

    public function delete(int $id): void
    {
        Book::query()->find($id)?->delete();
    }

    public function restore(int $id): void
    {
        $book = Book::withTrashed()->find($id);
        $book->restore();
    }
}
