<x-cadeiras>

    @for($i=1; $i <= $max; $i++)
        <div class="etapa">
            <h2 class="numEtapa">Etapa {{ $i }}</h2>
            <?php $disciplina = $disciplinas[$index];?>
            <?php while($disciplina->etapa === $i && $index >= 0): ?>
            
                <a href="{{ route('curriculum.show', $disciplina->codigo) }}">
                <div class="disciplina">
                    <h4 class="codigo">{{ $disciplina->codigo }}</h4>
                    <h3 class="nome">{{ $disciplina->nome }}</h3>
                    <h4 class="creditos">{{ $disciplina->creditos }} créditos</h4>
                </div>
                </a>

                <?php if($index === 0){break;}?>
                <?php $index--;?>
                <?php $disciplina = $disciplinas[$index];?>
            <?php endwhile; ?>
        </div>
    @endfor

</x-cadeiras>