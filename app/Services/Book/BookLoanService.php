<?php

namespace App\Services\Book;

use App\Enums\Book\BookLoanStatus;
use App\Exceptions\BusinessRuleException;
use App\Models\Book\BookLoan;
use App\Reader\ReadersStatus;
use App\Repositories\Interfaces\Book\BookLoanInterfaceRepository;
use App\Services\Reader\ReaderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookLoanService
{
    private const MAX_ACTIVE_LOANS = 3;
    private const DEFAULT_DELAY_VALUE = 2;

    private function calculateFine(BookLoan $loan): float
    {
        $now = now()->startOfDay();
        $dueDate = $loan->due_date->startOfDay();

        if ($dueDate->gte($now)) {
            return 0;
        }

        return $dueDate->diffInDays($now) * self::DEFAULT_DELAY_VALUE;
    }

    public function __construct(
        protected BookService $bookService,
        protected ReaderService $readerService,
        protected BookLoanInterfaceRepository $bookLoanRepository
    ) {}

    public function findById(int $id, ?bool $forLock = false): BookLoan
    {
        $bookLoans = $this->bookLoanRepository->findById($id, $forLock);

        if (! $bookLoans) throw new ModelNotFoundException('Empréstimo não localizado.');

        return $bookLoans;
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $reader = $this->readerService->findById($data['reader_id'], true);

            if ( $reader->status === ReadersStatus::BLOCKED->value ) throw new BusinessRuleException('Esse leitor está bloqueado para empréstimo de livros.');
            if ( $reader->status === ReadersStatus::INACTIVE->value ) throw new BusinessRuleException('Esse leitor está inativo.');

            $book = $this->bookService->findById($data['book_id'], true);

            if (! $book->is_active) throw new BusinessRuleException('Esse livro está inativo e não pode ser emprestado.');

            if ($book->available_copies < 1) throw new BusinessRuleException('Esse livro não possui cópias disponíveis.');

            $hasLoan = $reader->bookLoans()
                ->where('book_id', $book->id)
                ->whereIn('status', [
                    BookLoanStatus::ACTIVE->value,
                    BookLoanStatus::LATE->value,
                ])
                ->exists();

            if ( $hasLoan ) throw new BusinessRuleException('Esse leitor já possui um empréstimo desse livro.');

            $hasLateLoan = $reader->bookLoans()
                ->whereIn('status', [
                    BookLoanStatus::ACTIVE->value,
                    BookLoanStatus::LATE->value
                ])
                ->where('due_date', '<', now()->toDateString())
                ->exists();

            if ( $hasLateLoan ) throw new BusinessRuleException('Esse leitor possui um empréstimo atrasado.');

            if ($reader->bookLoans()->where('status', BookLoanStatus::ACTIVE->value)->count() >= self::MAX_ACTIVE_LOANS) throw new BusinessRuleException('Esse leitor já atingiu o limite de 3 empréstimos ativos.');

            $loan = $this->bookLoanRepository->store([
                'book_id' => $data['book_id'],
                'reader_id' => $data['reader_id'],
                'status' => BookLoanStatus::ACTIVE->value,
                'loan_date' => now(),
                'due_date' => $data['due_date'],
                'returned_at' => null,
                'fine_amount' => 0,
            ]);

            $book->decrement('available_copies', 1);

            return $loan;
        });
    }

    public function returnBook(int $loanId)
    {
        return DB::transaction(function () use ($loanId) {
            $loan = $this->findById($loanId, true);

            if ($loan->status === BookLoanStatus::RETURNED->value) throw new BusinessRuleException('Esse empréstimo já foi devolvido.');

            if ($loan->status === BookLoanStatus::CANCELED->value) throw new BusinessRuleException('Esse empréstimo está cancelado.');

            $fineAmount = $this->calculateFine($loan);

            $bookLoansReturned = $this->bookLoanRepository->update($loan, [
                'status' => BookLoanStatus::RETURNED->value,
                'returned_at' => now(),
                'fine_amount' => $fineAmount,
            ]);

            $loan->book->increment('available_copies', 1);

            return $bookLoansReturned;
        });
    }

    public function cancelLoans(int $loanId)
    {
        return DB::transaction(function () use ($loanId) {
            $loan = $this->findById($loanId, true);

            if ($loan->status === BookLoanStatus::CANCELED->value) throw new BusinessRuleException('Esse empréstimo já está cancelado.');

            if ($loan->status === BookLoanStatus::RETURNED->value) throw new BusinessRuleException('Empréstimos devolvidos não podem ser cancelados.');

            if (
                $loan->status === BookLoanStatus::LATE->value ||
                $loan->due_date->lt(now()->startOfDay())
            ) throw new BusinessRuleException('Empréstimos em atraso não podem ser cancelados.');

            $this->bookLoanRepository->update($loan, [
                'status' => BookLoanStatus::CANCELED->value
            ]);

            $loan->book->increment('available_copies', 1);

            return $loan;
        });
    }
}
