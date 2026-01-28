<?php

namespace App\Models;

use App\Models\Traits\BelongsToClinica;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use BelongsToClinica;
    use HasFactory;

    protected $table = 'servicos';

    protected $fillable = [
        'clinica_id',
        'nome',
        'descricao',
        'valor_base',
        'tempo_medio_minutos',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'tempo_medio_minutos' => 'integer',
        'valor_base' => 'decimal:2',
    ];


    /**
     * Clínica à qual o serviço pertence
     */
    public function clinica()
    {
        return $this->belongsTo(Clinicas::class, 'clinica_id');
    }
}
