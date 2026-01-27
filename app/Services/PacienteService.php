<?php

namespace App\Services;

use App\Exceptions\PacienteNaoEncontradoException;
use App\Models\Paciente;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PacienteService
{
    public function __construct(
        private readonly Paciente $model
    ) {}

    public function index(): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->paginate(5);
    }

    public function store(array $dados): Paciente
    {
        // dd(auth()->user());
        $dados['clinica_id'] = auth()->user()->clinica_id;
        return $this->model->create($dados);
    }

    public function update(string $id, array $dados): Paciente
    {
        $item = $this->model->find($id);
        
        if (!$item) {
            throw new PacienteNaoEncontradoException($id);
        }

        $item->update($dados);

        return $item->refresh();
    }

    public function delete(string $id): void
    {


        $item = $this->model->where('id', $id)->first();
        if (!$item) {
            throw new PacienteNaoEncontradoException($id);
        }
        $item->delete();
    }
}
