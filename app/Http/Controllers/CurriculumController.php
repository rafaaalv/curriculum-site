<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Disciplina;
use App\Enums\CaraterDisciplina;

class CurriculumController extends Controller
{
    public function show()
    {
        $disciplinas = Disciplina::query()->orderBy('etapa')->get();
        $grafo = [];
        return view('curriculum.show-curriculum', compact('disciplinas'));
    }
    public function data(): void
    {
        $path = database_path('dataset.json');
        $dados = json_decode(File::get($path), true);

        $preRequisitos = [];

        foreach($dados as $item)
        {
            $novaDisciplina = Disciplina::Create(
                [
                    'codigo' => $item['codigo'],
                    'nome' => $item['nome'],
                    'etapa' => $item['etapa'],
                    'carater'         => CaraterDisciplina::tryFrom($item['carater']) ?? CaraterDisciplina::OBRIGATORIO,
                    'responsavel'     => $item['responsavel'],
                    'creditos'        => $item['creditos'],
                    'descricao'       => $item['descricao'],
                    'ead'             => $item['ead'],
                    'extensionista'   => $item['extensionista'],
                    'extracurricular' => $item['extracurricular']
                ]

            );
            if (!empty($item['prerequisitos'])) {
                $preRequisitos[$novaDisciplina->id] = $item['prerequisitos'];
            }
        }
        foreach ($preRequisitos as $disciplinaId => $codigosRequisitos) {
            $disciplina = Disciplina::find($disciplinaId);

            $idsRequisitos = Disciplina::whereIn('codigo', $codigosRequisitos)->pluck('id');

            $disciplina->preRequisitos()->sync($idsRequisitos);
        }
    }
    public function subject(Request $request)
    {
        $disciplina = Disciplina::find($request->id);
        return view('curriculum.subject', compact('disciplina'));
    }
}
?>