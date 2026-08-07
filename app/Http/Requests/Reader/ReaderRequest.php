<?php

namespace App\Http\Requests\Reader;

use App\Reader\ReadersStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReaderRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:\\App\\Models\\Reader,email'],
            'document' => ['required', 'unique:\\App\\Models\\Reader,document'],
            'phone' => ['sometimes', 'max:20'],
            'status' => ['sometimes', Rule::enum(ReadersStatus::class)],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.min' => 'O nome deve conter no mínimo :min caracteres.',
            'name.max' => 'O nome deve conter no máximo :max caracteres.',

            'email.required' => 'O e-mail',
            'email.email' => 'O e-mail deve estar em um formato válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',

            'document.required' => 'O documento é obrigatório',
            'document.unique' => 'O documento já está cadastrado.',

            'phone' => 'O telefone deve conter no máximo :max caracteres.',

            'status.enum' => 'O status deve ser entre: Ativo, Bloqueado ou Inativo',
        ];
    }
}
