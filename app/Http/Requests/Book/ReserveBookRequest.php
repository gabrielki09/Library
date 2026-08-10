<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReserveBookRequest extends FormRequest
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
            'book_id' => ['required', 'exists:\\App\\Models\\Book\\Book,id'],
            'reader_id' => ['required', 'exists:\\App\\Models\\Reader\\Reader,id'],
            'due_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        ];
    }

    public function messages()
    {
        return [
            'book_id.required' => 'O identificador do livro é obrigatório.',
            'book_id.exists' => 'O identificador do livro precisa ser um identificador válido.',
            'reader_id.required' => 'O identificador do leitor é obrigatório.',
            'reader_id.exists' => 'O identificador do leitor precisa ser um identificador válido.',
            'due_date.required' => 'A data de vencimento é obrigatória',
            'due_date.date_format' => 'A data de vencimento deve estar no formato Y-m-d.',
            'due_date.after_or_equal' => 'A data de vencimento não pode ser inferir ao dia atual.',
        ];
    }
}
