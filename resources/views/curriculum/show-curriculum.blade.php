@extends('layout')

@section('header')
Novo Currículo Ciência da Computação UFRGS
@endsection

@section('content')
<ul>
    <?php foreach($disciplinas as $disciplina):?>
        <li>{{ $disciplina->nome }}</li>
    <?php endforeach; ?>
</uk>   
@endsection