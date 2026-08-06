<?php

namespace App\Repositories\Interfaces\Author;

use App\Models\Author\Author;

interface AuthorInterfaceRepository
{
    public function getAll();
    public function store(array $data): Author;
    public function update(Author $author, array $data): Author;
    public function findById(int $id): ?Author;
    public function delete(int $id): void;
    public function restore(int $id): void;
}
