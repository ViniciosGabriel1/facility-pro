<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AtualizarClinicaRequest extends FormRequest
{
    public function authorize(): bool
    {
        // dd($this->route()->parameters());

        return true;
    }
    
    public function rules(): array
    {
        return [
            'nome'     => ['required', 'string', 'max:255'],
            'cnpj'     => [
                'nullable',
                'string',
                'max:18',
                Rule::unique('clinicas', 'cnpj')->ignore($this->route('clinica')),
            ],
            'email'    => ['nullable', 'email', 'max:255'],
            'ativo'    => ['nullable'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'cidade'   => ['nullable', 'string', 'max:100'],
            'estado'   => ['nullable', 'string', 'size:2'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da clínica é obrigatório.',
            'nome.max'      => 'O nome da clínica pode ter no máximo 255 caracteres.',

            'cnpj.unique'   => 'Este CNPJ já está cadastrado para outra clínica.',
            'cnpj.max'      => 'O CNPJ informado é inválido.',

            'email.email'   => 'Informe um e-mail válido.',
            'email.max'     => 'O e-mail pode ter no máximo 255 caracteres.',

            'telefone.max'  => 'O telefone informado é muito longo.',

            'endereco.max'  => 'O endereço pode ter no máximo 255 caracteres.',

            'cidade.max'    => 'O nome da cidade é muito longo.',

            'estado.size'   => 'O estado deve conter exatamente 2 letras (ex: SP, RJ).',
        ];
    }
}
