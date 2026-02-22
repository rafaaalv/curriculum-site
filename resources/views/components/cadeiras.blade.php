<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&family=Press+Start+2P&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Curriculo Ciência da Computação</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="wrapper">
        <a href="{{ route('curriculum.obrigatorias') }}">
            <div id="obrigatoria" class="{{ Request::routeIs('curriculum.obrigatorias') ? 'optionAtiva' : 'option' }}">Obrigatórias</div>
        </a>

        <a href="{{ route('curriculum.eletivas') }}">
            <div id="eletiva" class="{{ Request::routeIs('curriculum.eletivas') ? 'optionAtiva' : 'option' }}">Eletivas</div>
        </a>
        <div id="mapa">
            {{ $slot }}
        </div>
    </div>
</body>
</html>