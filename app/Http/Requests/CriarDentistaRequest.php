<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriarDentistaRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Regra futura: apenas secretaria ou admin
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],

            'cro' => [
                'required',
                'string',
                'max:20',
                'unique:dentistas,cro',
            ],

            'especialidade' => ['nullable', 'string', 'max:100'],

            // 'ativo' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do dentista é obrigatório.',

            'cro.required' => 'O CRO é obrigatório.',
            'cro.unique'   => 'Este CRO já está cadastrado.',
            'cro.max'      => 'O CRO informado é inválido.',

            'especialidade.max' => 'A especialidade é muito longa.',

            // 'ativo.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',
        ];
    }
}
