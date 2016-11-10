@extends('shared.template.index')

@section('titulo', 'Examen')
@section('subtitulo', 'Parametros')

@section('contenido')

    <form class="form-horizontal" role="form">

        <div class="form-group">
            <div class="btn btn-white btn-primary btn-bold">
                <a class="green" href="{{ route('exam.parameters.edit', $parameter->id) }}">
                    <i class='ace-icon fa fa-pencil bigger-110 green'></i>
                </a>
            </div>
            <div class="btn btn-white btn-primary btn-bold">
                <a class="blue" href="{{ route('exam.parameters.index') }}">
                    <i class='ace-icon fa fa-history bigger-110 blue'></i>
                </a>
            </div>
        </div>

        <table class="table table-hover">
            <tr>
                <td><strong>Código:</strong></td>
                <td colspan="3">{{ $parameter->id }}</td>
            </tr>
            <tr>
                <td><strong>N&uacute;mero de preguntas:</strong></td>
                <td colspan="3">{{ $parameter->nro_preguntas }}</td>
            </tr>
            <tr>
                <td><strong>Duraci&oacute;n de examen:</strong></td>
                <td colspan="3">{{ $parameter->duracion_examen }}</td>
            </tr>
            <tr>
                <td><strong>C&oacute;digo de examen actual:</strong></td>
                <td colspan="3">{{ $parameter->id_examen_act }}</td>
            </tr>
            <tr>
                <td><strong>Editar respuesta:</strong></td>
                <td colspan="3">
                    @if($parameter->editar_respuestas == 'S')
                        Si
                    @elseif($parameter->editar_respuestas == 'N')
                        No
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Estado:</strong></td>
                <td colspan="3">
                    @if($parameter->estado == 'A')
                        Activo
                    @elseif($parameter->estado == 'I')
                        Inactivo
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Creado por:</strong></td>
                <td>{{ $parameter->creado_por }}</td>
                <td><strong>Fecha de creación:</strong></td>
                <td>{{ $parameter->fecha_creacion }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
        </table>

    </form>

@endsection
