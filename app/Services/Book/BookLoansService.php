<?php

namespace App\Services\Book;

use App\Book\BookLoansStatus;
use App\Repositories\Interfaces\Book\BookLoansInterfaceRepository;
use App\Services\Reader\ReaderService;
use Illuminate\Support\Facades\DB;
use Exception;

class BookLoansService
{
    private const MAX_ACTIVE_LOANS = 3;

    public function __construct(
        protected BookService $bookService,
        protected ReaderService $readerService,
        protected BookLoansInterfaceRepository $bookLoansRepository
    ){}

    public function store(array $data)
    {
        return DB::transaction(function() use ($data) {
            $book = $this->bookService->findById($data['book_id'], true);

            if ( ! $book->is_active )
            {
                throw new Exception('Esse livro está inativo e não pode ser emprestado.');
            }

            if ( $book->available_copies < 1 )
            {
                throw new Exception('Esse livro não possui cópias disponíveis.');
            }

            $reader = $this->readerService->findById($data['reader_id']);

            if ( $reader->bookLoans()->where('status', BookLoansStatus::LATE->value)->exists() )
            {
                throw new Exception('Esse leitor possui um empréstimo atrasado.');
            }

            if ( $reader->bookLoans()->where('status', BookLoansStatus::ACTIVE->value)->count() >= self::MAX_ACTIVE_LOANS )
            {
                throw new Exception('Esse leitor possui mais de 3 empréstimos ativos.');
            }

            $loan = $this->bookLoansRepository->store([
                'book_id' => $data['book_id'],
                'reader_id' => $data['reader_id'],
                'status' => BookLoansStatus::ACTIVE->value,
                'loan_date' => now(),
                'due_date' => $data['due_date'],
                'returned_at' => null,
                'fine_amount' => 0,
            ]);

            $book->decrement('available_copies', 1);

            return $loan;
        });
    }
}
