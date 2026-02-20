<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Disciplina;
use App\Enums\CaraterDisciplina;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class CurriculumController extends Controller
{
    public function index()
    {
        //passei as informações assim para no futuro poder fazer um site que funcione para qualquer curso
        return view('curriculum.index', [ "nome" => "Ciência da Computação", "credObrigatorio" => 166, "credEletivo" => 16, "credComplementar" => 6, "credConvertido" => 16, "horasObrigatoria" => 2730, "horasEletiva" => 240, "horasExt" => 340, "totalHoras" => 3400]);
    }
    public function obrigatorias()
    {
        $path = database_path('data/dataset.json');
        $dados = json_decode(File::get($path), true);

        $disciplinas = Disciplina::where('etapa', '>', 0)->orderBy('etapa', 'desc')->get(); //pega somente as obrigatórias
        $max = $disciplinas->first()->etapa;    //pega o número da maior etapa para saber quantas etapas tem o curso e organizar as cadeiras
        $index = count($disciplinas) - 1;       //pega o número de cadeiras para utilizar como limitante na iteração
        
        $grafo = [];

        for($i = 1; $i < $max; $i++){
            foreach($dados as $item)
            {
                if($item['etapa'] == $i){
                    $codigo = trim($item['codigo']);
                    $grafo[$codigo] = [];
                    foreach($item['prerequisistos'] as $pre)
                    {
                        if($pre[0] != '#'){
                            array_push($grafo[$pre], $codigo);
                        } 
                    }
                }            
            }
        }
        
        session(['rotaAnterior' => Route::currentRouteName()]); //guarda o nome da url atual para utilizar na hora de voltar da visualização da cadeira
        return view('curriculum.obrigatorias', [ "grafo" => $grafo, "disciplinas" => $disciplinas, "max" => $max, "index" => $index]);
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
        $caminhoDataset = database_path('data/dataset.json');

        $dados = json_decode(File::get($caminhoDataset), true);

        $adjacencia = [];
        $grauEntrada = [];
        $disciplinasDict = [];

        foreach ($dados as $d) {
            $cod = $d['codigo'];
            $adjacencia[$cod] = [];
            $grauEntrada[$cod] = 0;
            
            $disciplinasDict[$cod] = [
                'codigo'   => $cod,
                'nome'     => $d['nome'],
                'etapa'    => $d['etapa'],
                'creditos' => $d['creditos'],
                'carater'  => $d['carater']
            ];
        }

        foreach ($dados as $d) {
            $cod = $d['codigo'];
            $prereqs = $d['prerequisistos'] ?? []; 

            foreach ($prereqs as $pre) {
                if (str_starts_with($pre, '#')) continue;

                if (isset($adjacencia[$pre])) {
                    $adjacencia[$pre][] = $cod;
                    
                    $grauEntrada[$cod]++;
                }
            }
        }

        $ordemTopologica = [];
        $fila = [];

        foreach ($grauEntrada as $cod => $grau) {
            if ($grau === 0) {
                $fila[] = $cod;
            }
        }

        while (!empty($fila)) {
            $atual = array_shift($fila);
            $ordemTopologica[] = $atual;

            foreach ($adjacencia[$atual] as $vizinho) {
                $grauEntrada[$vizinho]--;
                if ($grauEntrada[$vizinho] === 0) {
                    $fila[] = $vizinho;
                }
            }
        }

        $inicial = request()->get('inicial');

        if (!$inicial) {
            foreach ($dados as $d) {
                if ($d['etapa'] === 1) {
                    $inicial = $d['codigo'];
                    break;
                }
            }
            if (!$inicial && count($ordemTopologica) > 0) {
                $inicial = $ordemTopologica[0];
            }
        }
        $dadosGrafo = [
            'Grafo'           => (object) $adjacencia,
            'OrdemTopologica' => $ordemTopologica,
            'Disciplinas'     => (object) $disciplinasDict,
            'Inicial'     => $inicial
        ];

        $caminhoGrafo = database_path('data/grafo.json');
        File::put(
            $caminhoGrafo, 
            json_encode($dadosGrafo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        //var_dump($grafo);
        //var_dump($disciplinasDict);
        //var_dump($ordemTopologica);
    }
    public function show(Disciplina $codigo)
    {
        $disciplina = Disciplina::find($codigo);

        $rota = session('rotaAnterior');    //pega o valor armazenado do nome da rota anterior para pode voltar posteriormente
        return view('curriculum.show', ["disciplina" => $disciplina, "nome" => "Ciência da Computação", "rota" => $rota]);
    }
}
?>