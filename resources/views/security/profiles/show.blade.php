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
                <div class="profile-info-value"><span>{{ $profile->cod_perfil }}</span></div>
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
                <div class="profile-info-name">Carreras</div>
                <div class="profile-info-value">
                    <span>
                        @foreach($profile->careersProfiles as $career)
                            {{$career->career->descripcion}}<br/>
                        @endforeach
                    </span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Accesos</div>
                <div class="profile-info-value">
                    <span>
                        @foreach($profile->optionsProfiles as $option)
                            {{$option->option->descripcion}}<br/>
                        @endforeach
                    </span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Permisos</div>
                <div class="profile-info-value">
                    <span>
                        @if($profile->aprueba_reactivo == 'S')
                            Aprueba Reactivos<br/>
                        @endif
                        @if($profile->aprueba_reactivos_masivo == 'S')
                            Aprobaci&oacute;n Masiva de Reactivos<br/>
                        @endif
                        @if($profile->desbloquea_reactivos == 'S')
                            Desbloquea Reactivos Aprobados<br/>
                        @endif
                        @if($profile->aprueba_examen == 'S')
                            Aprueba Examen<br/>
                        @endif
                        @if($profile->restablece_password == 'S')
                            Restablece Contrase&ntilde;a<br/>
                        @endif
                        @if($profile->aprueba_examen == 'S')
                            Dashboard
                        @endif
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
