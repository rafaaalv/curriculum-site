<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\CaraterDisciplina;

class Disciplina extends Model
{
    protected $fillable = [
        'codigo',
        'nome',
        'etapa',
        'carater',
        'responsavel',
        'creditos',
        'descricao',
        'ead',
        'extensionista',
        'extracurricular',
        'id_grafo'
    ];

    protected $cast = [
        'carater' => CaraterDisciplina::class,
        'ead' => 'boolean',
        'extensionista' => 'boolean',
        'extracurricular' => 'boolean'
    ];

    //função para pegar o grafo ao qual a disciplina pertence
    public function grafoPreReq()
    {
        return $this->belongsTo(GrafoPreRequisito::class, 'id_grafo');
    }
}
