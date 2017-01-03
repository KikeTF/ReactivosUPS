@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Detalle de perfil: '.$profile->nombre)

@section('contenido')

    <form class="form-horizontal" role="form">

        <div class="form-group">
            <div class="btn btn-white btn-primary btn-bold">
                <a class="green" href="{{ route('security.profiles.edit', $profile->id) }}">
                    <i class='ace-icon fa fa-pencil bigger-110 green'></i>
                </a>
            </div>
            <div class="btn btn-white btn-primary btn-bold">
                <a class="red" href="{{ route('security.profiles.index') }}">
                    <i class='ace-icon fa fa-close bigger-110 red'></i>
                </a>
            </div>
        </div>

        <table class="table table-hover">
            <tr>
                <td><strong>Código:</strong></td>
                <td colspan="3">{{ $profile->id }}</td>
            </tr>
            <tr>
                <td><strong>Nombre:</strong></td>
                <td colspan="3">{{ $profile->nombre }}</td>
            </tr>
            <tr>
                <td><strong>Descripción:</strong></td>
                <td colspan="3">{{ $profile->descripcion }}</td>
            </tr>
            <tr>
                <td><strong>Accesos:</strong></td>
                <td colspan="3">
                    @foreach($optionsProfiles as $option)
                        {{$option->descripcion}}<span>; </span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td><strong>Estado:</strong></td>
                <td>{{ $profile->estado == 'A' ? 'Activo' : 'Inactivo' }}</td>
            </tr>
            <tr>
                <td><strong>Creado por:</strong></td>
                <td>{{ $profile->creado_por }}</td>
                <td><strong>Fecha de creación:</strong></td>
                <td>{{ $profile->fecha_creacion }}</td>
            </tr>
            <tr>
                <td><strong>Modificado por:</strong></td>
                <td>{{ $profile->modificado_por }}</td>
                <td><strong>Fecha de modificación:</strong></td>
                <td>{{ $profile->fecha_modificacion }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
        </table>

    </form>

@endsection
