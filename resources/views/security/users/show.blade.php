@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Detalle de usuario: '.$user->nombres.' '.$user->apellidos)

@section('contenido')

    <form class="form-horizontal" role="form">

        <div class="form-group">
            <div class="btn btn-white btn-primary btn-bold">
                <a class="green" href="{{ route('security.users.edit', $user->id) }}">
                    <i class='ace-icon fa fa-pencil bigger-110 green'></i>
                </a>
            </div>
            <div class="btn btn-white btn-primary btn-bold">
                <a class="red" href="{{ route('security.users.index') }}">
                    <i class='ace-icon fa fa-close bigger-110 red'></i>
                </a>
            </div>
        </div>

        <table class="table table-hover">
            <tr>
                <td><strong>Código:</strong></td>
                <td colspan="3">{{ $user->id }}</td>
            </tr>
            <tr>
                <td><strong>Usuario:</strong></td>
                <td colspan="3">{{ $user->username }}</td>
            </tr>
            <tr>
                <td><strong>Password:</strong></td>
                <td colspan="3">********</td>
            </tr>
            <tr>
                <td><strong>Nombres y Apellidos:</strong></td>
                <td colspan="3">{{ $user->nombres.' '.$user->apellidos }}</td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td colspan="3">{{ $user->email }}</td>
            </tr>
            <tr>
                <td><strong>Tipo:</strong></td>
                <td>{{ $user->tipo == 'D' ? 'Docente' : 'Estado' }}</td>
            </tr>
            <tr>
                <td><strong>Estado:</strong></td>
                <td>{{ $user->estado == 'A' ? 'Activo' : 'Inactivo' }}</td>
            </tr>
            <tr>
                <td><strong>Creado por:</strong></td>
                <td>{{ $user->creado_por }}</td>
                <td><strong>Fecha de creación:</strong></td>
                <td>{{ $user->fecha_creacion }}</td>
            </tr>
            <tr>
                <td><strong>Modificado por:</strong></td>
                <td>{{ $user->modificado_por }}</td>
                <td><strong>Fecha de modificación:</strong></td>
                <td>{{ $user->fecha_modificacion }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
        </table>

    </form>

@endsection
