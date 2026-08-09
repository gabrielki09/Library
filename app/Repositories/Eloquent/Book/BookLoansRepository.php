<?php

namespace App\Repositories\Eloquent\Book;

use App\Models\Book\BookLoans;
use App\Repositories\Eloquent\AbstractRepository;
use App\Repositories\Interfaces\Book\BookLoansInterfaceRepository;
use Illuminate\Database\Eloquent\Model;
class BookLoansRepository extends AbstractRepository implements BookLoansInterfaceRepository
{
    public function __construct(BookLoans $model)
    {
        parent::__construct($model);
    }

    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    public function findById(int $id, ?bool $forLock): ?Model
    {
        return $this->model->find($id);
    }
}
