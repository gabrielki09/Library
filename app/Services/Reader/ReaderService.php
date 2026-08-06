<?php

namespace App\Services\Reader;

use App\Repositories\Interfaces\Reader\ReaderInterfaceRepository;

class ReaderService
{
    public function __construct(
        protected ReaderInterfaceRepository $readerRepository
    ){}


}
