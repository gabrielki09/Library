<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Date;

class BookRequest extends FormRequest
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
            'author_id' => ['required', 'unique:\\App\\Models\\Author,id'],
            'title' => ['required', 'min:3', 'max:150'],
            'isbn' => ['required', 'unique:\\App\\Models\\Book,isbn', 'max:20'],
            'description' => ['sometimes', 'max:1000'],
            'publication_year' => ['sometimes', 'date_before:today'],
            'total_copies' => ['sometimes', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'author_id.required' => 'O identificador do autor é obrigatório.',
            'author_id.unique' => 'O identificador do autor deve ser único.',

            'title.required' => 'O título é obrigatório.',
            'title.min' => 'O título deve conter no mínimo :min caracteres.',
            'title.max' => 'O título deve conter no máximo :max caracteres.',

            'isbn.required' => 'O ISBN é obrigatório.',
            'isbn.unique' => 'O ISBN deve ser único.',
            'isbn.max' => 'O ISB deve conter no máximo :max caracteres.',

            'description.max' => 'A descrição deve conter no máximo :max caracteres.',

            'publication_year.date_before' => 'A data de publicação não pode ser maior que a data atual.',

            'total_copies.min' => 'O total de cópias deve ser no mínimo :min.',
        ];
    }
}
