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

        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">C&oacute;digo</div>
                <div class="profile-info-value"><span>{{ $user->id }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Usuario</div>
                <div class="profile-info-value"><span>{{ $user->username }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Contrase&ntilde;a</div>
                <div class="profile-info-value"><span>******</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Sede</div>
                <div class="profile-info-value"><span>{{ $user->location->descripcion }}</span></div>
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
                            {{ $profile->nombre }}<br/>
                        @endforeach
                    </span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Estado</div>
                <div class="profile-info-value"><span>{{ $user->estado == 'A' ? 'Activo' : 'Inactivo' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Creado por</div>
                <div class="profile-info-value"><span>{{ $user->creado_por }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Fecha de creaci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $user->fecha_creacion }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Modificado por</div>
                <div class="profile-info-value"><span>{{ $user->modificado_por }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Fecha de modificaci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $user->fecha_modificacion }}</span></div>
            </div>

        </div>

    </form>

@endsection
