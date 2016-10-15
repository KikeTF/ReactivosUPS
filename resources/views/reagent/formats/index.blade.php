@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Listado de formatos de reactivos')

@section('contenido')
    <?php
    $usetable = 1;
    $columnas = array("nombre", "descripcion", "estado");
    ?>
    <input hidden type="text" id="url" value="{{ route('reagent.formats.data') }}">

    <div class="table-responsive" style="padding-top: 1px;">

        <div class="btn btn-white btn-primary btn-bold">
            <a class="blue" href="{{ route('reagent.formats.create') }}">
                <i class='ace-icon fa fa-plus bigger-110 blue'></i>
            </a>
        </div>
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
@endsection