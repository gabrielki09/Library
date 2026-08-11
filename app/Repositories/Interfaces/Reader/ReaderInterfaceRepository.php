<?php

namespace App\Repositories\Interfaces\Reader;

use App\Models\Reader\Reader;

interface ReaderInterfaceRepository
{
    public function getAll();
    public function store(array $data): Reader;
    public function update(Reader $reader, array $data): Reader;
    public function findById(int $id, ?bool $forLock = false): ?Reader;
    public function delete(int $id): void;
    public function restore(int $id): void;
}
