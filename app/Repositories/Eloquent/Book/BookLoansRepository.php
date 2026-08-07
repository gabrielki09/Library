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

    public function findByBookId(int $bookId): ?BookLoans
    {
        return BookLoans::query()
                ->where('book_id', $bookId)
                ->first();
    }

    public function findByBookAndReaderId(int $bookId, int $readerId): ?BookLoans
    {
        return BookLoans::query()
                ->where('book_id', $bookId)
                ->where('reader_id', $readerId)
                ->first();
    }

}
