<?php

namespace App\Repositories\Eloquent\Reader;

use App\Models\Reader\Reader;
use App\Repositories\Interfaces\Reader\ReaderInterfaceRepository;

class ReaderRepository implements ReaderInterfaceRepository
{
    public function getAll()
    {
        return;
    }

    public function store(array $data): Reader
    {
        return Reader::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'document' => $data['document'],
            'phone' => $data['phone'],
            'status' => $data['status'],
        ]);
    }

    public function update(Reader $reader, array $data): Reader
    {
        $reader->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'document' => $data['document'],
            'phone' => $data['phone'],
            'status' => $data['status'],
        ]);
        $reader->fresh();

        return $reader;

    }

    public function findById(int $id): ?Reader
    {
        return Reader::query()->find($id);
    }

    public function delete(int $id): void
    {
        Reader::query()->find($id)?->delete();
    }

    public function restore(int $id): void
    {
        $reader = Reader::withTrashed()->find($id);
        $reader->restore();
    }
}
