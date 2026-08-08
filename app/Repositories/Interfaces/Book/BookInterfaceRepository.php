<?php

namespace App\Repositories\Interfaces\Book;

use App\Models\Book\Book;

interface BookInterfaceRepository
{
    public function getAll();
    public function store(array $data): Book;
    public function update(Book $book, array $data): Book;
    public function findById(int $id, ?bool $forLock = false): ?Book;
    public function findByAuthorId(int $id): ?Book;
    public function delete(int $id): void;
    public function restore(int $id): void;
}
