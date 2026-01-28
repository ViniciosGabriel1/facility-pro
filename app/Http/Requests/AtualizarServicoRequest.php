<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtualizarServicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'descricao' => [
                'sometimes',
                'nullable',
                'string',
                'max:500',
            ],

            'valor_base' => [
                'sometimes',
                'numeric',
                'min:0.01',
                'max:99999.99',
            ],

            'tempo_medio_minutos' => [
                'sometimes',
                'nullable',
                'integer',
                'min:5',
                'max:480',
            ],

            'ativo' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.max' => 'O nome do serviço pode ter no máximo 255 caracteres.',

            'descricao.max' => 'A descrição pode ter no máximo 500 caracteres.',

            'valor_base.numeric' => 'O valor do serviço deve ser numérico.',
            'valor_base.min' => 'O valor do serviço deve ser maior que zero.',
            'valor_base.max' => 'O valor do serviço ultrapassa o limite permitido.',

            'tempo_medio_minutos.integer' => 'O tempo médio deve ser informado em minutos.',
            'tempo_medio_minutos.min' => 'O tempo médio mínimo é de 5 minutos.',
            'tempo_medio_minutos.max' => 'O tempo médio máximo é de 8 horas.',

            'ativo.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',
        ];
    }
}
