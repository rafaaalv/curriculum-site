<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CaraterDisciplina;

class Disciplina extends Model
{
    protected $fillable = [
        'codigo',
        'nome',
        'etapa',
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
            'disciplina_id',
            'disciplina_prerequisito',
            'prerequisito_id'
        );
    
    }

    public function liberadoras(): BelongsToMany
    {
        return $this->belongsToMany(
            Disciplina::class,
            'disciplina_prerequisito',
            'prerequisito_id', // Invertemos a ordem aqui
            'disciplina_id'
        );
    }

    public function competencias(): BelongsToMany
    {
        return $this->belongsToMany(Competencia::class, 'competencia_disciplina');
    }
}
