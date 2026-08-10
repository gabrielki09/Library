<?php

namespace App\Http\Requests\Reader;

use App\Reader\ReadersStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReaderUpdateRequest extends FormRequest
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
        $reader = $this->route('reader');

        return [
            'name' => ['required', 'min:3', 'max:120'],
            'email' => ['required', 'email', Rule::unique('readers', 'email')->ignore($reader)],
            'document' => ['required', Rule::unique('readers', 'document')->ignore($reader)],
            'phone' => ['required', 'max:20', 'celular'],
            'status' => ['required', Rule::enum(ReadersStatus::class)]
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
            'document.cpf' => 'O documento deve ser um formato válido: ###.###.###-##',

            'phone.required' => 'O celular do leitor é obrigatório.',
            'phone.max' => 'O celular deve conter no máximo :max caracteres.',
            'phone.celular' => 'O celular deve ser um formato válido: (##) ####-####.',
        ];
    }
}
