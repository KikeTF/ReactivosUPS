@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Detalle de campo de conocimiento: '.$field->nombre)

@section('contenido')

    <form class="form-horizontal" role="form">

        <div class="form-group">
            <div class="btn btn-white btn-primary btn-bold">
                <a class="green" href="{{ route('reagent.fields.edit', $field->id) }}">
                    <i class='ace-icon fa fa-pencil bigger-110 green'></i>
                </a>
            </div>
            <div class="btn btn-white btn-primary btn-bold">
                <a class="red" href="{{ route('reagent.fields.index') }}">
                    <i class='ace-icon fa fa-close bigger-110 red'></i>
                </a>
            </div>
        </div>

        <table class="table table-hover">
            <tr>
                <td><strong>Código:</strong></td>
                <td colspan="3">{{ $field->id }}</td>
            </tr>
            <tr>
                <td><strong>Nombre:</strong></td>
                <td colspan="3">{{ $field->nombre }}</td>
            </tr>
            <tr>
                <td><strong>Descripción:</strong></td>
                <td colspan="3">{{ $field->descripcion }}</td>
            </tr>
            <tr>
                <td><strong>Estado:</strong></td>
                <td colspan="3">
                    @if($field->estado == 'A')
                        Activo
                    @elseif($field->estado == 'I')
                        Inactivo
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Creado por:</strong></td>
                <td>{{ $field->creado_por }}</td>
                <td><strong>Fecha de creación:</strong></td>
                <td>{{ $field->fecha_creacion }}</td>
            </tr>
            <tr>
                <td><strong>Modificado por:</strong></td>
                <td>{{ $field->modificado_por }}</td>
                <td><strong>Fecha de modificación:</strong></td>
                <td>{{ $field->fecha_modificacion }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
        </table>

    </form>

@endsection
