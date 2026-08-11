<?php

namespace App\Repositories\Eloquent\Reader;

use App\Models\Reader\Reader;
use App\Reader\ReadersStatus;
use App\Repositories\Interfaces\Reader\ReaderInterfaceRepository;

class ReaderRepository implements ReaderInterfaceRepository
{
    public function getAll()
    {
        return Reader::query()->with('bookLoans')->get();
    }

    public function store(array $data): Reader
    {
        return Reader::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'document' => $data['document'],
            'phone' => $data['phone'],
            'status' => ReadersStatus::ACTIVE->value,
        ]);
    }

    public function update(Reader $reader, array $data): Reader
    {
        $reader->update($data);

        return $reader->fresh();
    }

    public function findById(int $id, ?bool $forLock = false): ?Reader
    {
        $reader = Reader::query()->whereKey($id);

        if ( $forLock )
        {
            $reader->lockForUpdate();
        }

        return $reader->first();
    }

    public function delete(int $id): void
    {
        Reader::query()->find($id)?->delete();
    }

    public function restore(int $id): void
    {
        $reader = Reader::withTrashed()->findOrFail($id);
        $reader->restore();
    }
}
