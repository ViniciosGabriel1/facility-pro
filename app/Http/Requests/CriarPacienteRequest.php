<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CriarPacienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Futuro: secretaria ou admin
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],

            'telefone' => ['nullable', 'string', 'max:20'],

            'cpf' => [
                'nullable',
                'string',
                'max:14',
                Rule::unique('pacientes', 'cpf')
                    ->where(fn ($q) =>
                        $q->where('clinica_id', $this->user()->clinica_id)
                    ),
            ],

            'observacoes' => ['nullable', 'string'],

            'ativo' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do paciente é obrigatório.',
            'nome.max'      => 'O nome do paciente pode ter no máximo 255 caracteres.',

            'telefone.max'  => 'O telefone informado é muito longo.',

            'cpf.unique'    => 'Este CPF já está cadastrado para outro paciente da clínica.',
            'cpf.max'       => 'O CPF informado é inválido.',

            'ativo.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',
        ];
    }
}
