<?php

namespace App\Services\Reader;

use App\Enums\Book\BookLoansStatus;
use App\Models\Reader\Reader;
use App\Repositories\Interfaces\Reader\ReaderInterfaceRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReaderService
{
    public function __construct(
        protected ReaderInterfaceRepository $readerRepository
    ){}

    public function getAll()
    {
        return $this->readerRepository->getAll();
    }

    public function store(array $data): Reader
    {
        return $this->readerRepository->store($data);

    }

    public function update(int $id, array $data): Reader
    {
        $reader = $this->readerRepository->update($this->findById($id), $data);

        return $reader;
    }

    public function findById(int $id): Reader
    {
        $reader = $this->readerRepository->findById($id);

        if ( ! $reader ) throw new ModelNotFoundException('Leitor não localizado.');

        return $reader;
    }

    public function delete(int $id): void
    {
        $reader = $this->findById($id);

        if ( $this->hasOpenBookLoans($reader) ) throw new Exception('Leitor com empréstimo em aberto não pode ser excluído.');

        $this->readerRepository->delete($id);
    }

    public function restore(int $id): void
    {
        $this->readerRepository->restore($id);
    }

    public function hasOpenBookLoans(Reader $reader)
    {
        return $reader->bookLoans()
            ->whereIn('status', [
                BookLoansStatus::ACTIVE->value,
                BookLoansStatus::LATE->value
            ])
            ->exists();
    }
}
