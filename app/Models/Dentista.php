<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dentista extends Model
{
    protected $fillable = [
        'user_id',
        'clinica_id',
        'cro',
        'especialidade',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinica()
    {
        return $this->belongsTo(Clinicas::class);
    }
}
