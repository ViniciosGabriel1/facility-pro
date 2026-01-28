<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriarServicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => [
                'required',
                'string',
                'max:255',
            ],

            'descricao' => [
                'nullable',
                'string',
                'max:500',
            ],

            'valor_base' => [
                'required',
                'numeric',
                'min:0.01',
                'max:99999.99',
            ],

            'tempo_medio_minutos' => [
                'nullable',
                'integer',
                'min:5',
                'max:480',
            ],

            'ativo' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do serviço é obrigatório.',
            'nome.max' => 'O nome do serviço pode ter no máximo 255 caracteres.',

            'descricao.max' => 'A descrição pode ter no máximo 500 caracteres.',

            'valor_base.required' => 'Informe o valor do serviço.',
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
