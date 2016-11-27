@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Listado de formatos de reactivos')

@section('contenido')
    <?php
    $usetable = 1;
    $newurl = route('reagent.formats.create');
    $columnas = array("nombre", "opciones_resp_min", "opciones_resp_max", "opciones_pregunta", "concepto_propiedad", "opciones_preg_min", "opciones_preg_max",  "imagenes", "estado");
    ?>

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>No. respuestas m&iacute;nimo</th>
                    <th>No. respuestas m&aacute;ximo</th>
                    <th>Opci&oacuten pregunta</th>
                    <th>Concepto propiedad</th>
                    <th>No. preguntas m&iacute;nimo</th>
                    <th>No. preguntas m&aacute;ximo</th>
                    <th>Im&aacute;genes</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($formats as $format)
                <?php
                $showurl = route('reagent.formats.show', $format->id);
                $editurl = route('reagent.formats.edit', $format->id);
                $destroyurl = route('reagent.formats.destroy', $format->id);
                ?>
                <tr>
                    <td>{{ $format->nombre }}</td>
                    <td>{{ $format->opciones_resp_min }}</td>
                    <td>{{ $format->opciones_resp_max }}</td>
                    <td>{{ $format->opciones_pregunta == 'S' ? 'Si' : 'No'  }}</td>
                    <td>{{ $format->concepto_propiedad == 'S' ? 'Si' : 'No'  }}</td>
                    <td>{{ $format->opciones_preg_min }}</td>
                    <td>{{ $format->opciones_preg_max }}</td>
                    <td>{{ $format->imagenes == 'S' ? 'Si' : 'No' }}</td>
                    <td>{{ $format->estado == 'A' ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        @include('shared.templates._tablebuttons')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection