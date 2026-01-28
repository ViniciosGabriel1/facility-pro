<?php

namespace App\Services;

use App\Exceptions\ServicoNaoEncontradoException;
use App\Models\Servico;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ServicoService
{
    public function __construct(
        private readonly Servico $model
    ) {}

   public function index(): LengthAwarePaginator
{
    return $this->model->paginate(5);
}


    public function store(array $dados): Servico
    {
        // dd($dados);
        //   $user_logado = auth()->user()->id;
        $dados['clinica_id'] = auth()->user()->clinica_id;
        return $this->model->create($dados);
    }

    public function update(string $id, array $dados): Servico
    {
        $item = $this->model
            ->where('id', $id)
            // ->where('clinica_id', auth()->user()->clinica_id)
            ->first();

        if (!$item) {
            throw new ServicoNaoEncontradoException($id);
        }

        $item->update($dados);

        return $item->refresh();
    }

    public function delete(string $id): void
    {
        $item = $this->model->find($id);

        if (!$item) {
            throw new ServicoNaoEncontradoException($id);
        }
        $item->delete();
    }
}
