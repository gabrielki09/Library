<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Date;

class BookCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'author_id' => ['required', 'exists:\\App\\Models\\Author\\Author,id'],
            'title' => ['required', 'min:3', 'max:150'],
            'isbn' => ['required', 'unique:\\App\\Models\\Book\\Book,isbn', 'max:20'],
            'description' => ['sometimes', 'max:100'],
            'publication_year' => ['nullable', 'integer', 'min:1000', 'max:' . now()->year],
            'total_copies' => ['sometimes', 'min:1', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'author_id.required' => 'O identificador do autor é obrigatório.',
            'author_id.exists' => 'O identificador do autor deve ser um identificador válido.',
            'title.required' => 'O título é obrigatório.',
            'title.min' => 'O título deve conter no mínimo :min caracteres.',
            'title.max' => 'O título deve conter no máximo :max caracteres.',
            'isbn.required' => 'O ISBN é obrigatório.',
            'isbn.unique' => 'O ISBN deve ser único.',
            'isbn.max' => 'O ISB deve conter no máximo :max caracteres.',
            'description.max' => 'A descrição deve conter no máximo :max caracteres.',
            'publication_year.integer' => 'A data de publicação precisa ser um número inteiro.',
            'publication_year.min' => 'O ano de publicação deve ser no mínimo 1000.',
            'publication_year.max' => 'O ano de publicação deve ser no máximo o ano atual.',
            'total_copies.min' => 'O total de cópias deve ser no mínimo :min.',
            'total_copies.integer' => 'O total de cópias deve ser um número inteiro',
        ];
    }
}
