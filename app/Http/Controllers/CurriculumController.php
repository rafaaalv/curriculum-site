<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Disciplina;
use App\Enums\CaraterDisciplina;
use App\Models\GrafoPreRequisito;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class CurriculumController extends Controller
{
    public function index()
    {
        //passei as informações assim para no futuro poder fazer um site que funcione para qualquer curso
        return view('curriculum.index', 
        [
        "nome" => "Ciência da Computação", 
        "credObrigatorio" => 166, 
        "credEletivo" => 16, 
        "credComplementar" => 6, 
        "credConvertido" => 16, 
        "horasObrigatoria" => 2730, 
        "horasEletiva" => 240, 
        "horasExt" => 340, 
        "totalHoras" => 3400
        ]);
    }
    public function obrigatorias()
    {
        $disciplinas = Disciplina::where('etapa', '>', 0)->orderBy('etapa', 'desc')->get(); //pega somente as obrigatórias
        $max = $disciplinas->first()->etapa;    //pega o número da maior etapa para saber quantas etapas tem o curso e organizar as cadeiras
        $index = count($disciplinas) - 1;       //pega o número de cadeiras para utilizar como limitante na iteração


        session(['rotaAnterior' => Route::currentRouteName()]); //guarda o nome da url atual para utilizar na hora de voltar da visualização da cadeira
        return view('curriculum.obrigatorias', 
        [
        "disciplinas" => $disciplinas, 
        "max" => $max, 
        "index" => $index
        ]);
    }
    public function eletivas()
    {
        $disciplinas = Disciplina::where('etapa', 0)->get();    //pega somente as eletivas
        $max = count($disciplinas);     //pega o número de cadeiras para utilizar como limitante na iteração
        session(['rotaAnterior' => Route::currentRouteName()]); //guarda o nome da url atual para utilizar na hora de voltar da visualização da cadeira
        return view('curriculum.eletivas', 
        [
        "disciplinas" => $disciplinas, 
        "max" => $max
        ]);
    }
    public function show(Disciplina $disciplina)
    {

        $dadosGrafo = GrafoPreRequisito::find($disciplina->id_grafo);//pega as informações do grafo do banco de dados
        $grafoInv = $this->inverteGrafo($dadosGrafo->grafo);//inverte o grafo

        
        $sucessores = $dadosGrafo->grafo[$disciplina->codigo] ?? [];//separa os sucessores diretos da cadeira alvo
        $ancestrais = [];
        $this->buscaAncestrais($disciplina->codigo, $grafoInv, $ancestrais);//separa todos os ancestrais da cadeira

        $codigosExibidos = array_unique(array_merge($ancestrais, [$disciplina->codigo], $sucessores));//junta todos os nodos que devem ser exibidos

        //filtra a ordem topologica para conter apenas os codigos das cadeiras a serem exibidas
        $novaOrdemTopo = array_values(array_filter($dadosGrafo->ordem_topologica, function($codigo) use ($codigosExibidos){
            return in_array($codigo, $codigosExibidos);
        }));

        //monta um subgrafo apenas com as cadeiras a serem exibidas
        $subGrafo = [];
        foreach($codigosExibidos as $codigo){
            $filhosFiltrados = array_intersect($dadosGrafo->grafo[$codigo] ?? [], $codigosExibidos);
            $subGrafo[$codigo] = array_values($filhosFiltrados);
        }

        //pega no banco de dados apenas as informações das cadeiras que serão exibidas
        $disciplinasGrafo = Disciplina::whereIn('codigo', $codigosExibidos)->get()->keyBy('codigo');

        $rota = session('rotaAnterior');    //pega o valor armazenado do nome da rota anterior para pode voltar posteriormente
        return view('curriculum.show', 
        [
            "disciplina" => $disciplina, 
            "nome" => "Ciência da Computação", 
            "rota" => $rota,
            "grafo" => $subGrafo,
            "ordemTopo" => $novaOrdemTopo,
            "disciplinas" => $disciplinasGrafo
        ]);
    }
    //funções auxiliares para filtrar o grafo
    //Objetivo: encontra todos os ancestrais de um nodo
    private function buscaAncestrais($codigo, $grafoInv, &$visitados ){
        if(isset($grafoInv[$codigo])){
            foreach($grafoInv[$codigo] as $pai){
                if(!in_array($pai, $visitados)){
                    $visitados[] = $pai;
                    $this->buscaAncestrais($pai, $grafoInv, $visitados);
                }
            }
        }
    }
    //Objetivo: inverte um grafo direcionado
    private function inverteGrafo($grafo){
        $grafoInv = [];
        foreach($grafo as $pai => $filhos){
            foreach($filhos as $filho){
                $grafoInv[$filho][] = $pai;
            }
        }
        return $grafoInv;
    }
}
