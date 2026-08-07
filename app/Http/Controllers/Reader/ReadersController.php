<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reader\ReaderRequest;
use App\Services\Reader\ReaderService;

class ReadersController extends Controller
{
    public function __construct(
        protected ReaderService $readerService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return apiSuccess(
            'Todos os leitores',
            [
                'readers' => $this->readerService->getAll()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReaderRequest $req)
    {
        return apiSuccess(
            'Leitor cadastrado com sucesso!',
            [
                'reader' => $this->readerService->store($req->validated())
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return apiSuccess(
            'Leitor localizado com sucesso!',
            [
                'reader' => $this->readerService->findById($id)
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReaderRequest $req, string $id)
    {
        return apiSuccess(
            'Leitor alterado com sucesso!',
            [
                'reader' => $this->readerService->update($id, $req->validated())
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->readerService->delete($id);
        return apiSuccess(
            'Leitor desativado com sucesso!'
        );
    }

    public function restore(string $id)
    {
        $this->readerService->restore($id);
        return apiSuccess(
            'Leitor reativado com sucesso!',
        );
    }
}
