<?php

namespace App\Exceptions;

use Exception;

abstract class DomainException extends Exception
{
    protected int $status = 400;

    protected string $keyCode = 'DOMAIN_ERROR';

    public function status(): int
    {
        return $this->status;
    }

    public function keyCode(): string
    {
        return $this->keyCode;
    }

    public function payload(): ?array
    {
        return [];
    }

    
}
