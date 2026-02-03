<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriarConsultaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paciente_id' => ['required', 'integer', 'exists:pacientes,id'],

            'dentista_id' => ['required', 'integer', 'exists:dentistas,id'],

            'data_hora' => ['required', 'date', 'after_or_equal:now'],

            'observacoes' => ['nullable', 'string', 'max:1000'],

            /**
             * Serviços vinculados na consulta
             */
            'servicos' => ['required', 'array', 'min:1'],

            'servicos.*.servico_id' => [
                'required',
                'integer',
                'exists:servicos,id'
            ],

            'servicos.*.quantidade' => [
                'nullable',
                'integer',
                'min:1'
            ],
        ];
    }

    public function messages(): array
{
    return [

        /*
        |--------------------------------------------------------------------------
        | Paciente
        |--------------------------------------------------------------------------
        */
        'paciente_id.required' => 'O paciente é obrigatório.',
        'paciente_id.integer'  => 'O paciente informado é inválido.',
        'paciente_id.exists'   => 'O paciente selecionado não existe ou foi removido.',

        /*
        |--------------------------------------------------------------------------
        | Dentista
        |--------------------------------------------------------------------------
        */
        'dentista_id.required' => 'O dentista é obrigatório.',
        'dentista_id.integer'  => 'O dentista informado é inválido.',
        'dentista_id.exists'   => 'O dentista selecionado não existe ou foi removido.',

        /*
        |--------------------------------------------------------------------------
        | Data e hora
        |--------------------------------------------------------------------------
        */
        'data_hora.required'        => 'A data e hora da consulta são obrigatórias.',
        'data_hora.date'            => 'Informe uma data e hora válidas.',
        'data_hora.after_or_equal'  => 'A consulta não pode ser marcada no passado.',

        /*
        |--------------------------------------------------------------------------
        | Observações
        |--------------------------------------------------------------------------
        */
        'observacoes.string' => 'As observações devem ser um texto.',
        'observacoes.max'    => 'As observações podem ter no máximo 1000 caracteres.',

        /*
        |--------------------------------------------------------------------------
        | Serviços (array)
        |--------------------------------------------------------------------------
        */
        'servicos.required' => 'A consulta precisa ter pelo menos um serviço.',
        'servicos.array'    => 'Os serviços devem ser enviados em formato de lista.',
        'servicos.min'      => 'Informe ao menos um serviço para a consulta.',

        /*
        |--------------------------------------------------------------------------
        | Serviço ID
        |--------------------------------------------------------------------------
        */
        'servicos.*.servico_id.required' =>
            'Cada item de serviço precisa ter um identificador.',

        'servicos.*.servico_id.integer' =>
            'O serviço informado é inválido.',

        'servicos.*.servico_id.exists' =>
            'Um dos serviços selecionados não existe ou foi removido.',

        /*
        |--------------------------------------------------------------------------
        | Quantidade
        |--------------------------------------------------------------------------
        */
        'servicos.*.quantidade.integer' =>
            'A quantidade deve ser um número inteiro.',

        'servicos.*.quantidade.min' =>
            'A quantidade mínima para um serviço é 1.',
    ];
}

}
