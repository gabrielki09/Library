<?php

namespace App\Repositories\Eloquent\Author;

use App\Models\Author\Author;
use App\Repositories\Interfaces\Author\AuthorInterfaceRepository;

class AuthorRepository implements AuthorInterfaceRepository
{
    public function getAll()
    {
        return Author::all();
    }

    public function store(array $data): Author
    {
        return Author::query()->create([
            'name' => $data['name'],
            'nationality' => $data['nationality'],
            'birth_date' => $data['birth_date']
        ]);
    }

    public function update(Author $author, array $data): Author
    {
        $author->update([
            'name' => $data['name'],
            'nationality' => $data['nationality'],
            'birth_date' => $data['birth_date']
        ]);
        $author->fresh();

        return $author;
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
