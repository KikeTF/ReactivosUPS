@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Detalle de campo de conocimiento: '.$field->nombre)

@section('contenido')

    <form class="form-horizontal" role="form">
        <?php
        $btnedit = route('reagent.fields.edit', $field->id);
        $btnclose = route('reagent.fields.index');
        ?>
        @include('shared.templates._formbuttons')

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
                <td><strong>Descripci&oacute;n:</strong></td>
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
