<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Disciplina;
use App\Enums\CaraterDisciplina;

class CurriculumController extends Controller
{
    public function obrigatorias()
    {
        $disciplinas = Disciplina::where('etapa', '>', 0)->orderBy('etapa', 'desc')->get();
        $max = $disciplinas->first()->etapa;
        $index = count($disciplinas) - 1;
        return view('curriculum.obrigatorias', [ "disciplinas" => $disciplinas, "max" => $max, "index" => $index]);
    }
    public function eletivas()
    {
        $disciplinas = Disciplina::where('etapa', 0)->get();
        return view('curriculum.eletivas', [ "disciplinas" => $disciplinas]);
    }
    public function data(): void
    {
        $path = database_path('data/dataset.json');
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
    public function show(Disciplina $disciplina)
    {
        return view('curriculum.show', ["disciplina" => $disciplina]);
    }
}
?>