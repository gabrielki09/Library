<?php

namespace App\Http\Requests\Author;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Date;

class AuthorCreateRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:120'],
            'nationality' => ['sometimes', 'max:80'],
            'birth_date' => [
                Date::new()
                    ->format('Y-m-d')
                    ->before('today')
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.min' => 'O nome deve conter no mínimo :min caracteres.',
            'name.max' => 'O nome deve conter no máximo :max caracteres.',

            'nationality.max' => 'A nacionalidade deve conter no máximo :max caracteres.',
            'birth_date.today' => 'A data de nascimento não pode ser depois do dia atual',
        ];
    }
}
