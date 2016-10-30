@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Listado de formatos de reactivos')

@section('contenido')
    <?php
    $usetable = 1;
    $dataurl = route('reagent.formats.data');
    $newurl = route('reagent.formats.create');
    $columnas = array("nombre", "descripcion", "estado");
    ?>

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
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