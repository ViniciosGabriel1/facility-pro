<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AtualizarDentistaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['sometimes', 'string', 'max:255'],

            'cro' => [
                'sometimes',
                'string',
                'max:20',
                Rule::unique('dentistas', 'cro')
                    ->ignore($this->route('dentista')),
            ],

            'especialidade' => ['sometimes', 'string', 'max:100'],

            'ativo' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.max' => 'O nome do dentista pode ter no máximo 255 caracteres.',

            'cro.unique' => 'Este CRO já está cadastrado para outro dentista.',
            'cro.max'    => 'O CRO informado é inválido.',

            'especialidade.max' => 'A especialidade é muito longa.',

            'ativo.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',
        ];
    }
}
