<?php

namespace App\Repositories\Eloquent\Author;

use App\Models\Author\Author;
use App\Repositories\Eloquent\AbstractRepository;
use App\Repositories\Interfaces\Author\AuthorInterfaceRepository;

class AuthorRepository implements AuthorInterfaceRepository
{
    public function getAll()
    {
        return Author::query()
            ->with('books')
            ->get();
    }

    public function store(array $data): Author
    {
        return Author::query()->create([
            'name' => $data['name'],
            'nationality' => $data['nationality'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
        ]);
    }

    public function update(Author $author, array $data): Author
    {
        $author->update([
            'name' => $data['name'],
            'nationality' => $data['nationality'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
        ]);

        return $author->fresh();

    }

    public function findById(int $id): ?Author
    {
        return Author::query()->find($id);
    }

    public function delete(int $id): void
    {
        Author::query()->find($id)?->delete();
    }

    public function restore(int $id): void
    {
        $author = Author::withTrashed()->find($id);
        $author->restore();
    }
}
