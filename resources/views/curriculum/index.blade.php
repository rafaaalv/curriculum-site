<x-layout>

    <h1>Currículo {{ $nome }}</h1>
    <div>
        <h3>
            <span class="tooltip">
            Créditos obrigatórios
                <span class="tooltip-box">
                     Disciplinas previstas na grade curricular do curso, que todos os alunos
                     devem cursar e concluir para a integralização do currículo.
                 </span>
            </span>
            : {{ $credObrigatorio }} - {{ $horasObrigatoria }} horas
        </h3>
        <h3>
            <span class="tooltip">
            Créditos eletivos
                <span class="tooltip-box">
                     Disciplinas escolhidas pelo aluno dentro de um conjunto de opções oferecidas pelo curso, 
                     permitindo aprofundamento ou diversificação da formação acadêmica.
                 </span>
            </span>
            : {{ $credEletivo }} - {{ $horasEletiva }} horas
        <h3>
            <span class="tooltip">
            Créditos complementares
                <span class="tooltip-box">
                    Atividades acadêmicas como cursos, eventos, projetos, monitorias e ações
                    extracurriculares que complementam a formação do aluno.
                </span>
            </span>
            : {{ $credComplementar }}
        </h3>
        <h3>
            <span class="tooltip">
            Créditos convertidos
                <span class="tooltip-box">
                    Trabalho de Conclusão de Curso.
                </span>
            </span>
            : {{ $credConvertido }}
        </h3>
        <h3>
            <span class="tooltip">
            Horas de Extensão
                <span class="tooltip-box">
                    Atividades de extensão universitária voltadas à interação entre a universidade 
                    e a sociedade, como projetos sociais, cursos, oficinas e ações comunitárias.
                </span>
            </span>
            : {{ $horasExt }}
        </h3>
        <?php $totalCred = $credObrigatorio + $credEletivo + $credComplementar + $credConvertido; ?>
        <h3>Total: {{ $totalCred }} créditos - {{ $totalHoras }} horas</h3>
    </div>

    <a href="{{ route("curriculum.obrigatorias") }}">
        <div id="visualizar">
            <h3>Visualizar Currículo</h3>
        </div>
    </a>

</x-layout>