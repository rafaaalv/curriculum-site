<x-layout>
    <ul>
    @foreach($disciplinas as $disciplina)
        <a href="{{ route('curriculum.show', $disciplina->codigo) }}", class="show">
            <div class="disciplina">
                <h4 class="codigo">{{ $disciplina->codigo }}</h4>
                <h3 class="nome">{{ $disciplina->nome }}</h3>
                <h4 class="creditos">{{ $disciplina->creditos }}</h4>
            </div>
        </a>
    @endforeach
    </ul>

</x-layout>