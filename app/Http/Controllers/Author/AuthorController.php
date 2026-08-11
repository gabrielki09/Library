<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\{
    AuthorCreateRequest,
    AuthorUpdateRequest
};
use App\Services\Author\AuthorService;

class AuthorController extends Controller
{
    public function __construct(
        protected AuthorService $authorService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return apiSuccess(
            'Todos os autores',
            [
                'authors' => $this->authorService->getAll()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorCreateRequest $req)
    {
        return apiSuccess(
            'Autor cadastrado com sucesso!',
            [
                'author' => $this->authorService->store($req->validated())
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return apiSuccess(
            'Autor localizado com sucesso!',
            [
                'author' => $this->authorService->findById($id)
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorUpdateRequest $req, int $id)
    {
        return apiSuccess(
            'Autor alterado com sucesso!',
            [
                'author' => $this->authorService->update($id, $req->validated())
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorService->delete($id);
        return apiSuccess(
            'Autor desativado com sucesso!'
        );
    }

    public function restore(string $id)
    {
        $this->authorService->restore($id);
        return apiSuccess(
            'Autor reativado com sucesso!',
        );
    }
}
