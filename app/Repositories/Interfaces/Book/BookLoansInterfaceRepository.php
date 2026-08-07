<?php

namespace App\Repositories\Interfaces\Book;

use App\Models\Book\BookLoans;
use App\Repositories\Interfaces\BaseInterfaceRepository;

interface BookLoansInterfaceRepository extends BaseInterfaceRepository
{
    public function findByBookId(int $bookId): ?BookLoans;
    public function findByBookAndReaderId(int $bookId, int $readerId): ?BookLoans;
}
