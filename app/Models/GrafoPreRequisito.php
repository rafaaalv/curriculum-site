<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;


class GrafoPreRequisito extends Model
{
    protected $table = 'grafo_prerequisitos';

    protected $fillable = [
        'grafo',
        'ordem_topologica'
    ];

    protected $casts = [
        'grafo' => 'array',
        'ordem_topologica' => 'array'
    ];

    //função para pegar todas as disciplinas que pertencem ao grafo
    public function disciplinas() : HasMany
    {
        return $this->hasMany(Disciplina::class, 'id_grafo');
    }
}
