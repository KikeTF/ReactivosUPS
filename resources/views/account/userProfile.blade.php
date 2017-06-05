@extends('shared.templates.index')

@section('titulo')
    <i class="ace-icon fa fa-user"></i><span> Perfil de Usuario</span>
@endsection
@section('subtitulo', \Auth::user()->FullName)

@section('contenido')

    <form class="form-horizontal" role="form">

        <?php
        $btnclose = route('index');
        ?>
        @include('shared.templates._formbuttons')

        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">Usuario</div>
                <div class="profile-info-value"><span>{{ \Auth::user()->username }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Sede</div>
                <div class="profile-info-value"><span>{{ \Auth::user()->location->descripcion }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Correo</div>
                <div class="profile-info-value"><span>{{ \Auth::user()->email }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Tipo</div>
                <div class="profile-info-value"><span>{{ \Auth::user()->tipo == 'D' ? 'Docente' : 'Estudiante' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Perfiles de Acceso</div>
                <div class="profile-info-value">
                    <span>
                        @foreach(\Auth::user()->profilesUsers->pluck('profile') as $profile)
                            {{ $profile->nombre }}<br/>
                        @endforeach
                    </span>
                </div>
            </div>
        </div>
    </form>

@endsection
