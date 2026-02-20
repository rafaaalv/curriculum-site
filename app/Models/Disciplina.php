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
        'extracurricular'
    ];

    protected $cast = [
        'carater' => CaraterDisciplina::class,
        'ead' => 'boolean',
        'extensionista' => 'boolean',
        'extracurricular' => 'boolean'
    ];

    public function preRequisitos(): BelongsToMany
    {
        return $this->belongsToMany(
            Disciplina::class,
            'disciplina_prerequisito',
            'disciplina_id',
            'prerequisito_id'
        );
    
    }

    public function liberadoras(): BelongsToMany
    {
        return $this->belongsToMany(
            Disciplina::class,
            'disciplina_prerequisito',
            'prerequisito_id',
            'disciplina_id'
        );
    }
}
