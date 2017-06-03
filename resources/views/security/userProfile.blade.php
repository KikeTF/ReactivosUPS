@extends('shared.templates.index')

@section('titulo', 'Usuario')
@section('subtitulo', 'Perfil de Usuario')

@section('contenido')

    <form class="form-horizontal" role="form">

        <?php
        $btnclose = route('index');
        ?>
        @include('shared.templates._formbuttons')

        <table class="table table-hover">
            <tr>
                <td><strong>Usuario:</strong></td>
                <td colspan="3">{{ $user->username }}</td>
            </tr>

            <tr>
                <td><strong>Nombre Completo:</strong></td>
                <td colspan="3">{{ $user->nombres.' '.$user->apellidos }}</td>
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
                <td><strong>Perfiles:</strong></td>
                <td colspan="3">
                    @foreach($user->profilesUsers->pluck('profile') as $profile)
                        {{ $profile->nombre }}<span>; </span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
        </table>

    </form>

@endsection
