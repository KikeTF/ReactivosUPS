@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Listado de formatos de reactivos')

@section('contenido')
    <?php
    $usetable = 1;
    $columnas = array("nombre", "descripcion", "estado");
    ?>
    <input hidden type="text" id="dataurl" value="{{ route('reagent.formats.data') }}">
    <input hidden type="text" id="newurl" value="{{ route('reagent.formats.create') }}">

    <div class="table-responsive" style="padding-top: 1px;">
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