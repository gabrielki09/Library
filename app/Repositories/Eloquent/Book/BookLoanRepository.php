<?php

namespace App\Repositories\Eloquent\Book;

use App\Models\Book\BookLoan;
use App\Repositories\Eloquent\AbstractRepository;
use App\Repositories\Interfaces\Book\BookLoanInterfaceRepository;
use Illuminate\Database\Eloquent\Model;

class BookLoanRepository extends AbstractRepository implements BookLoanInterfaceRepository
{
    public function __construct(BookLoan $model)
    {
        parent::__construct($model);
    }

    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    public function findById(int $id, ?bool $forLock): ?Model
    {
        $loan = $this->model->query()->where('id', $id);

        if ( $forLock )
        {
            $loan->lockForUpdate();
        }

        return $loan->first();
    }
}
