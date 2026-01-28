<?php

namespace App\Exceptions;

class ServicoNaoEncontradoException extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct("Serviço {$id} não encontrado.");
    }

    public function status(): int
    {
        return 404;
    }

    public function keyCode(): string
    {
        return 'SERVICO_NAO_ENCONTRADO';
    }
}
