<?php

namespace App\Services\Author;

use App\Models\Author\Author;
use App\Repositories\Interfaces\Author\AuthorInterfaceRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorService
{
    public function __construct(
        protected AuthorInterfaceRepository $authorRepository
    ){}

    public function getAll()
    {
        return $this->authorRepository->getAll();
    }

    public function store(array $data): Author
    {
        return $this->authorRepository->store($data);
    }

    public function update(int $id, array $data): Author
    {
        $author = $this->findById($id);

        return $this->authorRepository->update($author, $data);
    }

    public function findById(int $id): ?Author
    {
        $author = $this->authorRepository->findById($id);

        if ( ! $author ) throw new ModelNotFoundException('Autor não localizado');

        return $author;
    }

    public function delete(int $id): void
    {
        $this->authorRepository->delete($id);
    }

    public function restore(int $id): void
    {
        $this->authorRepository->restore($id);
    }
}
