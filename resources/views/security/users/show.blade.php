@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Detalle de usuario: '.$user->FullName)

@section('contenido')

    <form class="form-horizontal" role="form">

        <?php
        $btnedit = route('security.users.edit', $user->id);
        $btnclose = route('security.users.index');
        ?>
        @include('shared.templates._formbuttons')

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
                <td><strong>Sede:</strong></td>
                <td>{{ $user->location->descripcion }}</td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td colspan="3">{{ $user->email }}</td>
            </tr>
            <tr>
                <td><strong>Tipo:</strong></td>
                <td>{{ $user->tipo == 'D' ? 'Docente' : 'Estudiante' }}</td>
            </tr>

            <tr>
                <td><strong>Perfiles de Acceso:</strong></td>
                <td colspan="3">
                    @foreach($user->profilesUsers->pluck('profile') as $profile)
                        {{ $profile->nombre }}<span>; </span>
                    @endforeach
                </td>
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
