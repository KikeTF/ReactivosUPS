@extends('shared.template.index')

@section('titulo', 'Examen')
@section('subtitulo', 'Historial de cambios')

@section('contenido')
    <?php
    $usetable = 0;
    $columnas = array("id", "nro_preguntas", "duracion_examen", "id_examen_act", "editar_respuestas", "estado", "creado_por", "fecha_creacion");
    ?>


    <input hidden type="text" id="dataurl" value="{{ route('exam.parameters.data') }}">
    <input hidden type="text" id="closeurl" value="{{ route('exam.parameters.index') }}">

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>No. Preguntas</th>
                <th>Duraci&oacute;n</th>
                <th>Examen</th>
                <th>Editar Respuestas</th>
                <th>Reactivos x Examen</th>
                <th>Actualizado por</th>
                <th>Fecha Actualizaci&oacute;n</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection
