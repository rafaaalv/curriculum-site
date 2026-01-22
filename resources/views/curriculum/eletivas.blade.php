<x-cadeiras>
    <?php $i = 0?>
    @while($i < $max)
        <div class="colEletiva">
        @for($j=0; $j < 8; $j++)

            <a href="{{ route('curriculum.show', $disciplinas[$i]->codigo) }}">
                <div class="disciplina">
                    <h4 class="codigo">{{ $disciplinas[$i]->codigo }}</h4>
                    <h3 class="nome">{{ $disciplinas[$i]->nome }}</h3>
                    <h4 class="creditos">{{ $disciplinas[$i]->creditos }} créditos</h4>
                </div>
            </a>
            <?php $i++; 
                if($i == $max){break;}?>

        @endfor
        </div>
    @endwhile

</x-cadeiras>