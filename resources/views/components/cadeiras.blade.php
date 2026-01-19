<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currículo CIC</title>

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