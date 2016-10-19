@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Listado de campos de conocimiento')

@section('contenido')
    <?php
        $usetable = 1;
        $columnas = array("nombre", "descripcion", "estado");
    ?>
    <input hidden type="text" id="dataurl" value="{{ route('reagent.fields.data') }}">
    <input hidden type="text" id="newurl" value="{{ route('reagent.fields.create') }}">

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
