@extends('layout')

@section('header')
{{$disciplina->nome}}
@endsection

@section('content')
<ul>
<li>{{$disciplina->nome}}</li>    
<li>{{$disciplina->creditos}}</li>
<li>{{$disciplina->carater}}</li>
<li>{{$disciplina->responsavel}}</li>         
<ul>   
@endsection