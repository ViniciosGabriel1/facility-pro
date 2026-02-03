<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

trait BelongsToClinica
{
    protected static function bootBelongsToClinica(): void
    {
        static::addGlobalScope('clinica', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where(
                    $builder->getModel()->getTable() . '.clinica_id',
                    auth()->user()->clinica_id
                );
            }
        });

        // Auto-preencher clinica_id ao criar
        static::creating(function (Model $model) {
            if (auth()->check() && empty($model->clinica_id)) {
                $model->clinica_id = auth()->user()->clinica_id;
            }
        });

        
    }
}
