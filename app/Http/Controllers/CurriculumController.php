<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Disciplina;
use App\Enums\CaraterDisciplina;
use Illuminate\Support\Facades\Route;

class CurriculumController extends Controller
{
    public function index()
    {
        //passei as informações assim para no futuro poder fazer um site que funcione para qualquer curso
        return view('curriculum.index', [ "nome" => "Ciência da Computação", "credObrigatorio" => 166, "credEletivo" => 16, "credComplementar" => 6, "credConvertido" => 16, "horasObrigatoria" => 2730, "horasEletiva" => 240, "horasExt" => 340, "totalHoras" => 3400]);
    }
    public function obrigatorias()
    {
        $disciplinas = Disciplina::where('etapa', '>', 0)->orderBy('etapa', 'desc')->get(); //pega somente as obrigatórias
        $max = $disciplinas->first()->etapa;    //pega o número da maior etapa para saber quantas etapas tem o curso e organizar as cadeiras
        $index = count($disciplinas) - 1;       //pega o número de cadeiras para utilizar como limitante na iteração
        session(['rotaAnterior' => Route::currentRouteName()]); //guarda o nome da url atual para utilizar na hora de voltar da visualização da cadeira
        return view('curriculum.obrigatorias', [ "disciplinas" => $disciplinas, "max" => $max, "index" => $index]);
    }
    public function eletivas()
    {
        $disciplinas = Disciplina::where('etapa', 0)->get();    //pega somente as eletivas
        $max = count($disciplinas);     //pega o número de cadeiras para utilizar como limitante na iteração
        session(['rotaAnterior' => Route::currentRouteName()]); //guarda o nome da url atual para utilizar na hora de voltar da visualização da cadeira
        return view('curriculum.eletivas', [ "disciplinas" => $disciplinas, "max" => $max]);
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
        $rota = session('rotaAnterior');    //pega o valor armazenado do nome da rota anterior para pode voltar posteriormente
        return view('curriculum.show', ["disciplina" => $disciplina, "nome" => "Ciência da Computação", "rota" => $rota]);
    }
}
?>