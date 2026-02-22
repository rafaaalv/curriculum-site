<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currículo {{ $nome }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/grafo.js'])
    <script type="module">
        //chamada da função que constroi o grafo
        document.addEventListener('DOMContentLoaded', () => {
        const grafo = @json($grafo);
        const ordemTopo = @json($ordemTopo);
        const disciplinas = @json($disciplinas);
        const inicial = "{{ $disciplina->codigo }}"

        criaGrafo(grafo, ordemTopo, disciplinas, inicial);
    });

        
    </script>
</head>
<body>
    <div id="wrapper">

        <a href="{{ empty($rota) ? route('curriculum.obrigatorias') : route($rota) }}">  
            <div id="voltar">
                <p>&#10006;</p>
            </div>
        </a>
        <div id="hideInfo" class="infoAtiva">
            <p>&#10095;</p>
        </div>
        <div id="information">
            <!-- deixar vazio, pois são as informações da barra lateral e serão preenchidas na função em JS -->  
            <h3></h3>
            <h3></h3>
            <h3></h3>
            <h3></h3>
            <h3></h3>
            <h3></h3>
        </div>

        <div id="mapa">
            <!-- linhas do grafo -->
            <svg id="linhas" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;">
                <defs>
                    <marker id="seta" viewBox="0 0 10 10" refX="8" refY="5"
                    markerWidth="6" markerHeight="6"
                    orient="auto" fill="#2b2b2b">
                        <path d="M 0 0 L 10 5 L 0 10 z"/>
                    </marker>
                    <marker id="setaVermelha" viewBox="0 0 10 10" refX="8" refY="5"
                    markerWidth="6" markerHeight="6"
                    orient="auto" fill="#c71313">
                        <path d="M 0 0 L 10 5 L 0 10 z"/>
                    </marker>
                    <marker id="setaVerde" viewBox="0 0 10 10" refX="8" refY="5"
                    markerWidth="6" markerHeight="6"
                    orient="auto" fill="#45ec11">
                        <path d="M 0 0 L 10 5 L 0 10 z"/>
                    </marker>
                </defs>
            </svg>
        </div>
    </div>
</body>
</html>