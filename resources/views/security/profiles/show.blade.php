@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Detalle de perfil: '.$profile->nombre)

@section('contenido')

    <form class="form-horizontal" role="form">
        <?php
        $btnedit = route('security.profiles.edit', $profile->id);
        $btnclose = route('security.profiles.index');
        ?>
        @include('shared.templates._formbuttons')

        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">C&oacute;digo</div>
                <div class="profile-info-value"><span>{{ $profile->id }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Nombre</div>
                <div class="profile-info-value"><span>{{ $profile->nombre }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Descripci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $profile->descripcion }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">¿Aprueba Reactivo?</div>
                <div class="profile-info-value"><span>{{ $profile->aprueba_reactivo == 'S' ? 'Si' : 'No' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">¿Aprueba Reactivos Masivamente?</div>
                <div class="profile-info-value"><span>{{ $profile->aprueba_reactivos_masivo == 'S' ? 'Si' : 'No' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">¿Aprueba Examen?</div>
                <div class="profile-info-value"><span>{{ $profile->aprueba_examen == 'S' ? 'Si' : 'No' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Accesos</div>
                <div class="profile-info-value">
                    <span>
                        @foreach($optionsProfiles as $option)
                            {{$option->descripcion}}<br/>
                        @endforeach
                    </span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Estado</div>
                <div class="profile-info-value"><span>{{ $profile->estado == 'A' ? 'Activo' : 'Inactivo' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Creado por</div>
                <div class="profile-info-value"><span>{{ $profile->creado_por }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Fecha de creaci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $profile->fecha_creacion }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Modificado por</div>
                <div class="profile-info-value"><span>{{ $profile->modificado_por }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Fecha de modificaci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $profile->fecha_modificacion }}</span></div>
            </div>
        </div>
    </form>

@endsection
