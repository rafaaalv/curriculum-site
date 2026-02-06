<x-layout>

    <div class="title-container">
        <h1>Currículo {{ $nome }}</h1>
    </div>
    <div class="body-container">
    <div class="course-data">
        <h3>Créditos obrigatórios: {{ $credObrigatorio }} - {{ $horasObrigatoria }} horas</h3>
        <h3>Créditos eletivos: {{ $credEletivo }} - {{ $horasEletiva }} horas</h3>
        <h3>Créditos complementares: {{ $credComplementar }}</h3>
        <h3>Créditos convertidos: {{ $credConvertido }}</h3>
        <h3>Horas de Extensão: {{ $horasExt }}</h3>
        <?php $totalCred = $credObrigatorio + $credEletivo + $credComplementar + $credConvertido; ?>
        <h3>Total: {{ $totalCred }} créditos - {{ $totalHoras }} horas</h3>
    </div>

    <a href="{{ route("curriculum.obrigatorias") }}">
        <div id="visualizar">
            <h3>Visualizar Currículo</h3>
        </div>
    </a>
    </div>

</x-layout>