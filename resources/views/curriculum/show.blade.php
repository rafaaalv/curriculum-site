<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currículo {{ $nome }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="wrapper">
        <a href="{{ empty($rota) ? route(curriculum.obrigatorias) : route($rota) }}">  
            <div id="voltar">
                <p>&#10006;</p>
            </div>
        </a>
        <div id="hideInfo" class="infoAtiva">
            <p>&#10095;</p>
        </div>
        <div id="information">  
            <h3>{{ $disciplina->codigo }}</h3>
            <h3>{{ $disciplina->nome }}</h3>
            <h3>{{ $disciplina->creditos }}</h3>
            <h3>{{ $disciplina->etapa === 0 ? 'eletiva' : 'obrigatória' }}</h3>
            <h3>{{ $disciplina->responsavel }}</h3>
            <h3>{{ $disciplina->descricao }}</h3>
        </div>

        <div id="mapa">
            <div class="disciplina">
                <h4 class="codigo">{{ $disciplina->codigo }}</h4>
                <h3 class="nome">{{ $disciplina->nome }}</h3>
                <h4 class="creditos">{{ $disciplina->creditos }} créditos</h4>
            </div>
        </div>
    </div>
</body>
</html>