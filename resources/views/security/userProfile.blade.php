@extends('shared.templates.index')

@section('titulo', 'Perfil de Usuario')
@section('subtitulo', $user->FullName)

@push('specific-styles')
    <style>
        .profile-info-name{
            width: 130px !important;
        }
    </style>
@endpush

@section('contenido')

    <form class="form-horizontal" role="form">

        <?php
        $btnclose = route('index');
        ?>
        @include('shared.templates._formbuttons')

        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">Usuario</div>
                <div class="profile-info-value"><span>{{ $user->username }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Correo</div>
                <div class="profile-info-value"><span>{{ $user->email }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Tipo</div>
                <div class="profile-info-value"><span>{{ $user->tipo == 'D' ? 'Docente' : 'Estudiante' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Perfiles de Acceso</div>
                <div class="profile-info-value">
                    <span>
                        @foreach($user->profilesUsers->pluck('profile') as $profile)
                            {{ $profile->nombre }}<span>; </span>
                        @endforeach
                    </span>
                </div>
            </div>
        </div>
    </form>

@endsection
