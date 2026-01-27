<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';

    protected $fillable = [
        'clinica_id',
        'nome',
        'telefone',
        'cpf',
        'observacoes',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    /*
     * Relacionamentos
     */

    public function clinica()
    {
        return $this->belongsTo(Clinicas::class);
    }
}
