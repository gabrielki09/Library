<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseInterfaceRepository
{
    public function getAll();
    public function store(array $data): Model;
    public function update(Model $model, array $data): Model;
    public function findById(int $id): ?Model;
    public function delete(int $id): void;
    public function restore(int $id): void;
}
