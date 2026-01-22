<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinicas extends Model
{
    //

    protected $fillable = ['nome', 'cnpj', 'telefone'];


    // protected $casts =['ativo' => 1]

    public function scopeAtivas($query)
    {
        return $query->where('ativo', 1);
    }

    public function dentistas()
    {
        return $this->hasMany(Dentista::class);
    }
}
