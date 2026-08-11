<?php

namespace App\Services\Book;

use App\Enums\Book\BookLoanStatus;
use App\Exceptions\BusinessRuleException;
use App\Models\Book\Book;
use App\Repositories\Interfaces\Book\BookInterfaceRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class BookService
{
    public function __construct(
        protected BookInterfaceRepository $bookRepository
    ) {}

    public function getAll()
    {
        return $this->bookRepository->getAll();
    }

    public function store(array $data): Book
    {
        $totalCopies = $data['total_copies'] ?? 1;

        return $this->bookRepository->store([
            'author_id' => $data['author_id'],
            'title' => $data['title'],
            'isbn' => $data['isbn'],
            'description' => $data['description'] ?? null,
            'publication_year' => $data['publication_year'] ?? null,
            'total_copies' => $totalCopies,
            'available_copies' => $totalCopies,
        ]);
    }

    public function update(int $id, array $data): Book
    {
        return DB::transaction(function () use ($id, $data) {
            $book = $this->findById($id, true);

            if (isset($data['total_copies'])) {
                $openLoans = $book->bookLoans()
                    ->whereIn('status', [
                        BookLoanStatus::LATE->value,
                        BookLoanStatus::ACTIVE->value,
                    ])
                    ->count();

                if ($data['total_copies'] < $openLoans) throw new BusinessRuleException('A quantidade total de cópias não pode ser menor que a quantidade atualmente emprestada.');

                $data['available_copies'] = $data['total_copies'] - $openLoans;
            }

            return $this->bookRepository->update(
                $book,
                $data
            );
        });
    }

    public function findById(int $id, ?bool $forLock = false): Book
    {
        $book = $this->bookRepository->findById($id, $forLock);

        if (! $book) throw new ModelNotFoundException('Livro não localizado');

        return $book;
    }

    public function delete(int $id): void
    {
        DB::transaction(function() use ($id) {
            $book = $this->findById($id, true);

            $hasOpenLoans = $book->bookLoans()
                ->whereIn('status', [
                    BookLoanStatus::ACTIVE->value,
                    BookLoanStatus::LATE->value,
                ])
                ->exists();

            if ($hasOpenLoans) throw new BusinessRuleException('Livro com empréstimo em aberto não pode ser excluído.');

            $this->bookRepository->delete($id);

        });
    }

    public function restore(int $id): void
    {
        $this->bookRepository->restore($id);
    }
}
