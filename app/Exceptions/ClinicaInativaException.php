<?php

namespace App\Exceptions;

class ClinicaInativaException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Clínica inativa.');
    }

    public function status(): int
    {
        return 403;
    }

    public function payload(): array
    {
        return [
            'clinica_status' => 'INATIVA',
            'action' => 'REACTIVATE_REQUIRED',
        ];
    }

    public function keyCode(): string
    {
        return 'CLINICA_INATIVA';
    }
}
