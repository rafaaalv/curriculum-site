@extends('layout')

@section('header')
Novo Currículo Ciência da Computação UFRGS
@endsection

@section('content')
<?php for($i = 1; $i <= 10; $i++):
    foreach($disciplinas as $disciplina):
        if($disciplina->etapa == $i):?>
            <ul class="disciplinas">
                <li class="item-disciplina"><a href="/{{$disciplina->id}}">{{ $disciplina->codigo }}</a></li>
            </uk>
    <?php endif;
    endforeach; 
endfor; ?>   
@endsection