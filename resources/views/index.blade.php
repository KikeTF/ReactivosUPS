@extends('shared.template.index')

@section('titulo', 'Reactivos UPS')
@section('subtitulo', 'Home')

@section('contenido')
    <?php
    $usetable = 0;
    ?>
    <div>
        <img src="{{ asset('image/logo-ups.png') }}" alt="Universidad Polit&eacute;cnica Salesiana" style="width: 90%; display: block; margin: auto;" >
    </div>
@endsection