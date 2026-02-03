<?php

namespace App\Services;

use App\Exceptions\ServicoNaoEncontradoException;
use App\Models\Consulta;
use App\Models\Servico;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ConsultaService
{
    public function __construct(
        private readonly Consulta $model
    ) {}

    public function index(): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->paginate(5);
    }

    // public function store(array $dados): Consulta
    // {
    //     $dados['clinica_id'] = auth()->user()->clinica_id;
    //     return $this->model->create($dados);
    // }

    public function store(array $dados): array
    {
        return DB::transaction(function () use ($dados) {

            $dados['clinica_id'] = auth()->user()->clinica_id;

            $servicos = $dados['servicos'];
            unset($dados['servicos']);

            // 1. cria consulta
            $consulta = $this->model->create($dados);

            // 2. pivot
            $pivotData = [];

            foreach ($servicos as $item) {

                $servico = Servico::find($item['servico_id']);

                if (!$servico) {
                    throw new ServicoNaoEncontradoException($item['servico_id']);
                }

                $quantidade = $item['quantidade'] ?? 1;
                $valor = $servico->valor_base;

                $pivotData[$servico->id] = [
                    'quantidade'     => $quantidade,
                    'valor_unitario' => $valor,
                    'subtotal'       => $valor * $quantidade,
                ];
            }

            // 3. attach
            $consulta->servicos()->attach($pivotData);

            // ✅ carrega a relação
            $consulta->load('servicos');

            // 4. retorno filtrado
            return [
                'id'          => $consulta->id,
                'paciente_id' => $consulta->paciente_id,
                'dentista_id' => $consulta->dentista_id,
                'data_hora'   => $consulta->data_hora,
                'observacoes' => $consulta->observacoes,

                'servicos' => $consulta->servicos->map(function ($servico) {
                    return [
                        'id'         => $servico->id,
                        'nome'       => $servico->nome,
                        'quantidade' => $servico->pivot->quantidade,
                        'subtotal'   => $servico->pivot->subtotal,
                    ];
                })->toArray(),
            ];
        });
    }



    public function update(string $id, array $dados): Consulta
    {
        $item = $this->model->find($id);

        if (!$item) {
            throw new \RuntimeException('Consulta não encontrado.');
        }

        $item->update($dados);

        return $item->refresh();
    }

    public function delete(string $id): void
    {
        $item = $this->model->findOrFail($id);

        $item->delete();
    }
}
