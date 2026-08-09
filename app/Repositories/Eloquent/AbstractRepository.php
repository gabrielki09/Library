<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\BaseInterfaceRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements BaseInterfaceRepository
{
    public function __construct(
        protected Model $model
    ){}

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->update($data);

        return $model->fresh();
    }

    public function findById(int $id, ?bool $forLock): ?Model
    {
        $model = $this->model->query()
                        ->where('id', $id);

        if ( $forLock )
        {
            $model->lockForUpdate();
        }

        return $model->first();
    }

    public function delete(int $id): void
    {
        $this->model->find($id)->delete();
    }

    public function restore(int $id): void
    {
        $model = $this->model->withTrashed()->find($id);
        $model->restore();
    }
}
