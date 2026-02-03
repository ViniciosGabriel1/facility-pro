<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Consulta extends Model
{
    protected $fillable = [
        'clinica_id',
        'paciente_id',
        'dentista_id',
        'data_hora',
        'status',
        'observacoes',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos
    |--------------------------------------------------------------------------
    */

    public function clinica(): BelongsTo
    {
        return $this->belongsTo(Clinicas::class);
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function dentista(): BelongsTo
    {
        return $this->belongsTo(Dentista::class);
    }

    /**
     * Serviços realizados na consulta (pivot)
     */
    public function servicos()
    {
        return $this->belongsToMany(
            Servico::class,
            'consulta_servico'
        )
            ->withPivot([
                'quantidade',
                'valor_unitario',
                'subtotal'
            ]);
            // ->withTimestamps();
    }
}
