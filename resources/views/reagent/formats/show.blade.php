@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Detalle de campo de conocimiento: '.$format->nombre)

@section('contenido')

    <form class="form-horizontal" role="form">

        <div class="form-group">
            <div class="btn btn-white btn-primary btn-bold">
                <a class="green" href="{{ route('reagent.formats.edit', $format->id) }}">
                    <i class='ace-icon fa fa-pencil bigger-110 green'></i>
                </a>
            </div>
            <div class="btn btn-white btn-primary btn-bold">
                <a class="red" href="{{ route('reagent.formats.index') }}">
                    <i class='ace-icon fa fa-close bigger-110 red'></i>
                </a>
            </div>
        </div>

        <table class="table table-hover">
            <tr>
                <td><strong>Código:</strong></td>
                <td colspan="3">{{ $format->id }}</td>
            </tr>
            <tr>
                <td><strong>Nombre:</strong></td>
                <td colspan="3">{{ $format->nombre }}</td>
            </tr>
            <tr>
                <td><strong>Descripción:</strong></td>
                <td colspan="3">{{ $format->descripcion }}</td>
            </tr>
            <tr>
                <td><strong>No. de respuesta m&iacute;nimo:</strong></td>
                <td colspan="3">{{ $format->opciones_resp_min }}</td>
            </tr>
            <tr>
                <td><strong>No. de respuesta m&aacute;ximo:</strong></td>
                <td colspan="3">{{ $format->opciones_resp_max }}</td>
            </tr>
            <tr>
                <td><strong>¿Opciones de Pregunta?:</strong></td>
                <td colspan="3">{{ $format->opciones_pregunta == 'S' ? 'Si' : 'No' }}</td>
            </tr>
            <tr>
                <td><strong>¿Opciones Concepto/Propiedad?:</strong></td>
                <td colspan="3">{{ $format->concepto_propiedad == 'S' ? 'Si' : 'No' }}</td>
            </tr>
            <tr>
                <td><strong>No. de preguntas m&iacute;nimo:</strong></td>
                <td colspan="3">{{ $format->opciones_preg_min }}</td>
            </tr>
            <tr>
                <td><strong>No. de preguntas m&aacute;ximo:</strong></td>
                <td colspan="3">{{ $format->opciones_preg_max }}</td>
            </tr>
            <tr>
                <td><strong>¿Im&aacute;genes?:</strong></td>
                <td colspan="3">{{ $format->imagenes == 'S' ? 'Si' : 'No' }}</td>
            </tr>

            <tr>
                <td><strong>Estado:</strong></td>
                <td>{{ $format->estado == 'A' ? 'Activo' : 'Inactivo' }}</td>
            </tr>

            <tr>
                <td><strong>Creado por:</strong></td>
                <td>{{ $format->creado_por }}</td>
                <td><strong>Fecha de creación:</strong></td>
                <td>{{ $format->fecha_creacion }}</td>
            </tr>
            <tr>
                <td><strong>Modificado por:</strong></td>
                <td>{{ $format->modificado_por }}</td>
                <td><strong>Fecha de modificación:</strong></td>
                <td>{{ $format->fecha_modificacion }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
        </table>

    </form>

@endsection
