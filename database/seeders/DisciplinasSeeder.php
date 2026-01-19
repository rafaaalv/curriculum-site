<?php

namespace Database\Seeders;

use App\Models\Disciplina;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;


class DisciplinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $json = File::get('database/data/dataset.json');
        $data = json_decode($json);

        foreach ($data as $disciplina)
            {
                Disciplina::create(array(
                    'codigo' => $disciplina->codigo,
                    'nome' => $disciplina->nome,
                    'etapa' => $disciplina->etapa,
                    'carater' => $disciplina->carater,
                    'responsavel' => $disciplina->responsavel,
                    'creditos' => $disciplina->creditos,
                    'descricao' => $disciplina->descricao,
                    'ead' => $disciplina->ead,
                    'extensionista' => $disciplina->extensionista,
                    'extracurricular' => $disciplina->extracurricular
                ));
            }
             //faz aqui a montagem do grafo para evitar de ler o JSON mais de uma vez
    }
}