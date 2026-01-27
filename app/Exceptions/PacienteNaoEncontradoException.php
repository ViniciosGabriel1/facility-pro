<?php

namespace App\Exceptions;

class PacienteNaoEncontradoException extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct("Paciente {$id} não encontrado.");
    }

    public function status(): int
    {
        return 404;
    }

    public function keyCode(): string
    {
        return 'PACIENTE_NAO_PACIENTE';
    }
}
