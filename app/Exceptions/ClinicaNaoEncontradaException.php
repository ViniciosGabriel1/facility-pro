<?php

namespace App\Exceptions;

class ClinicaNaoEncontradaException extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct("Clínica {$id} não encontrada.");
    }

    public function status(): int
    {
        return 404;
    }

    public function keyCode(): string
    {
        return 'CLINICA_NAO_ENCONTRADA';
    }
}
