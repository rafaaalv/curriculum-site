<?php

namespace Database\Seeders;

use App\Models\Disciplina;
use App\Models\GrafoPreRequisito;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use League\Flysystem\Visibility;
use Illuminate\Support\Facades\DB;

class DisciplinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //lê o arquivo JSON
        $json = File::get('database/data/dataset.json');
        $data = json_decode($json, true);
        $dataMap = []; //mapeamento dos dados para mais fácil acesso posteriormente

        $grafo = [];
        $nodos = [];

        //cria o grafo por lista de adjacência das disciplinas
        foreach ($data as $d) {
            $cod = $d['codigo'];
            $grafo[$cod] = [];
            $nodos[] = $cod;
            $dataMap[$cod] = $d;
        }

        foreach ($data as $d) {
            $cod = $d['codigo'];
            $prereqs = $d['prerequisitos'] ?? [];

            foreach ($prereqs as $pre) {
                if (str_starts_with($pre, '#')) continue;

                if (isset($grafo[$pre])) {
                    $grafo[$pre][] = $cod;
                }
            }
        }

        //separa o grafo em componentes conexo
        //cria um grafo não direcionado apenas com as chaves
        $grafoSimples = [];
        foreach($nodos as $cod) $grafoSimples[$cod] = [];

        foreach ($grafo as $pai => $filhos) {
            foreach ($filhos as $filho) {
                $grafoSimples[$pai][] = $filho;
                $grafoSimples[$filho][] = $pai;
            }
        }

        $numComponentes = 0;
        $componentes = [];
        $visitados = array_fill_keys($nodos, false);

        //realiza um bfs para cada nodo, separando os componentes
        foreach ($nodos as $nodo) {
            if ($visitados[$nodo]) continue;

            $numComponentes++;
            $fila = [$nodo];
            $componentes[$numComponentes] = [];
            $visitados[$nodo] = true;

            while (!empty($fila)) {
                $atual = array_shift($fila);

                $componentes[$numComponentes][] = $atual;

                foreach ($grafoSimples[$atual] as $vizinho) {
                    if (!$visitados[$vizinho]) {
                        $visitados[$vizinho] = true;
                        $fila[] = $vizinho;
                    }
                }
            }
        }


        //cria a ordem topológica de cada componente conexo
        $ordemTopo = [];

        for ($i = 1; $i <= $numComponentes; $i++) {
            $filaKahn = [];
            $grauEntrada = [];

            //inicializa o vetor do grau de entrada
            foreach($componentes[$i] as $cod){ 
                $grauEntrada[$cod] = 0;
            }

            foreach($componentes[$i] as $disciplina){
                foreach($grafo[$disciplina] as $cod){
                    if(isset($grauEntrada[$cod])){
                        $grauEntrada[$cod]++;
                    }
                }
            }

            //insere na fila todos os nodos com grau 0
            foreach($componentes[$i] as $cod){
                if($grauEntrada[$cod] === 0)
                    $filaKahn[] = $cod;
            }

            while(!empty($filaKahn)){
                $primeiro = array_shift($filaKahn);
                $ordemTopo[$i][] = $primeiro;

                foreach($grafo[$primeiro] as $liberado){

                    if(isset($grauEntrada[$liberado])){
                        $grauEntrada[$liberado]--;

                        if($grauEntrada[$liberado] === 0){
                            $filaKahn[] = $liberado;
                        }
                    }
                }
            }

            $subGrafo = array_intersect_key($grafo, array_flip($componentes[$i]));

            $novoGrafo = GrafoPreRequisito::create([
                'grafo' => $subGrafo,
                'ordem_topologica' => $ordemTopo[$i]
            ]);

            //insere dados no banco de dados
            foreach ($componentes[$i] as $cod)
            {
                $disciplina = $dataMap[$cod];

                Disciplina::create(array(
                    'codigo' => $disciplina['codigo'],
                    'nome' => $disciplina['nome'],
                    'etapa' => $disciplina['etapa'],
                    'carater' => $disciplina['carater'],
                    'responsavel' => $disciplina['responsavel'],
                    'creditos' => $disciplina['creditos'],
                    'descricao' => $disciplina['descricao'],
                    'ead' => $disciplina['ead'],
                    'extensionista' => $disciplina['extensionista'],
                    'extracurricular' => $disciplina['extracurricular'],
                    'id_grafo' => $novoGrafo->id,
                    'prerequisitos' => json_encode($disciplina['prerequisitos'])
                ));
            }
        }
    }
}