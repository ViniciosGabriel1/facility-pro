<?php

namespace App\Services;

use App\Exceptions\ClinicaInativaException;
use App\Exceptions\ClinicaNaoEncontradaException;
use App\Models\Clinicas;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClinicasService
{
    public function __construct(
        private readonly Clinicas $clinica
    ) {}

    public function index(): LengthAwarePaginator
    {
        // if (true) {
        //     throw new ClinicaInativaException();
        // }

        return $this->clinica
            ->newQuery()
            ->ativas()
            ->paginate(5);
    }

    public function store(array $dados): Clinicas
    {
        return $this->clinica->create($dados);
    }


    public function update(string $id, array $dados): Clinicas
    {
        $clinica = $this->clinica->find($id);

        if (!$clinica) {
            throw new ClinicaNaoEncontradaException($id);
        }

        $clinica->update($dados);

        return $clinica->refresh();
    }


    public function delete(string $id): void
    {
            $clinica = $this->clinica->find($id);

        if (!$clinica) {
            throw new ClinicaNaoEncontradaException($id);
        }


        // regra futura (exemplo)
        // if ($clinica->consultas()->exists()) {
        //     throw new ClinicaComConsultasException();
        // }

        $clinica->delete();
    }
}
