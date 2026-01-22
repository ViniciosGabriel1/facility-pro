<?php

namespace App\Exceptions;

class DentistaNaoEncontradoException extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct("Dentista {$id} não encontrada.");
    }

    public function status(): int
    {
        return 404;
    }

    public function keyCode(): string
    {
        return 'DENTISTA_NAO_ENCONTRADO';
    }
}
