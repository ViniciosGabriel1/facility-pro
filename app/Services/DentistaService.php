<?php

namespace App\Services;

use App\Exceptions\DentistaNaoEncontradoException;
use App\Models\Dentista;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DentistaService
{
    public function __construct(
        private readonly Dentista $model
    ) {}

    public function index(): LengthAwarePaginator
    {
        return $this->model
            ->with(['user'])
            ->newQuery()
            ->paginate(5);
    }

    public function store(array $dados): Dentista
    {

        $user_logado = auth()->user()->id;
        $clinica_user_logado = auth()->user()->clinica_id;

        return $this->model->create([
            'nome'         => $dados['nome'],
            'cro'          => $dados['cro'],
            'especialidade' => $dados['especialidade'] ?? null,
            'ativo'        => $dados['ativo'] ?? true,
            'clinica_id'   => $clinica_user_logado,
            'user_id'   => $user_logado,
        ]);
    }

    public function update(string $id, array $dados): Dentista
    {
        $item = $this->model->find($id);

        if (!$item) {
            throw new DentistaNaoEncontradoException($id);
        }

        $item->update($dados);

        return $item->refresh();
    }

    public function delete(string $id): void
    {
        $item = $this->model->find($id);

        if (!$item) {
            throw new DentistaNaoEncontradoException($id);
        }

        $item->delete();
    }
}
