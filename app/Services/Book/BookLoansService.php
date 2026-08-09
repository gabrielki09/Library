<?php

namespace App\Services\Book;

use App\Book\BookLoansStatus;
use App\Models\Book\BookLoans;
use App\Repositories\Interfaces\Book\BookLoansInterfaceRepository;
use App\Services\Reader\ReaderService;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class BookLoansService
{
    private const MAX_ACTIVE_LOANS = 3;
    private const DEFAULT_DELAY_VALUE = 2;

    private function calculateFine(BookLoans $loans): float
    {
        $now = now()->startOfDay();
        $dueDate = $loans->due_date->startOfDay();

        if ($dueDate->gte($now)) {
            return 0;
        }

        return $dueDate->diffInDays($now) * self::DEFAULT_DELAY_VALUE;
    }

    public function __construct(
        protected BookService $bookService,
        protected ReaderService $readerService,
        protected BookLoansInterfaceRepository $bookLoansRepository
    ) {}

    public function findById(int $id, ?bool $forLock = false): BookLoans
    {
        $bookLoans = $this->bookLoansRepository->findById($id, $forLock);

        if (! $bookLoans) throw new ModelNotFoundException('Empréstimo não localizado.');

        return $bookLoans;
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $book = $this->bookService->findById($data['book_id'], true);

            if (! $book->is_active) throw new Exception('Esse livro está inativo e não pode ser emprestado.');

            if ($book->available_copies < 1) throw new Exception('Esse livro não possui cópias disponíveis.');

            $reader = $this->readerService->findById($data['reader_id']);

            if (
                $reader->bookLoans()->where('book_id', $data['book_id'])
                ->whereIn('status', [
                    BookLoansStatus::ACTIVE->value,
                    BookLoansStatus::LATE->value
                ])
                ->exists()
            ) throw new Exception('Esse leitor já possui um empréstimo desse livro.');

            if ($reader->bookLoans()->where('status', BookLoansStatus::LATE->value)->exists()) throw new Exception('Esse leitor possui um empréstimo atrasado.');

            if ($reader->bookLoans()->where('status', BookLoansStatus::ACTIVE->value)->getResults()->count() >= self::MAX_ACTIVE_LOANS) throw new Exception('Esse leitor possui mais de 3 empréstimos ativos.');

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

    public function returnBook(int $loansId)
    {
        return DB::transaction(function () use ($loansId) {
            $loans = $this->findById($loansId, true);

            if ($loans->status === BookLoansStatus::RETURNED->value) throw new Exception('Esse empréstimo já foi devolvido.');

            if ($loans->status === BookLoansStatus::CANCELED->value) throw new Exception('Esse empréstimo está cancelado.');

            $fineAmount = $this->calculateFine($loans);

            $bookLoansReturned = $this->bookLoansRepository->update($loans, [
                'status' => BookLoansStatus::RETURNED->value,
                'returned_at' => now(),
                'fine_amount' => $fineAmount,
            ]);

            $loans->book->increment('available_copies', 1);

            return $bookLoansReturned;
        });
    }

    public function cancelLoans(int $loansId)
    {
        return DB::transaction(function () use ($loansId) {
            $loans = $this->findById($loansId, true);

            if ($loans->status === BookLoansStatus::CANCELED->value) throw new Exception('Esse empréstimo já está cancelado.');

            if ($loans->status === BookLoansStatus::RETURNED->value) throw new Exception('Empréstimos devolvidos não podem ser cancelados.');

            if ($loans->status === BookLoansStatus::LATE->value) throw new Exception('Empréstimos em atraso não podem ser cancelados.');

            $this->bookLoansRepository->update($loans, [
                'status' => BookLoansStatus::CANCELED->value
            ]);

            $loans->book->increment('available_copies', 1);

            return $loans;
        });
    }
}
