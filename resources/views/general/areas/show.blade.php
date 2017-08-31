@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Detalle de &aacute;rea: '.$area->descripcion)

@section('contenido')

    <form class="form-horizontal" role="form">
        <?php
        $btnedit = route('general.areas.edit', $area->id);
        $btnclose = route('general.areas.index');
        ?>
        @include('shared.templates._formbuttons')

        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">C&oacute;digo</div>
                <div class="profile-info-value"><span>{{ $area->cod_area }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Descripci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $area->descripcion }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Responsable</div>
                <div class="profile-info-value"><span>{{ ($area->id_usuario_resp > 0) ? $area->user->FullName : 'NO DEFINIDO' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Estado</div>
                <div class="profile-info-value"><span>{{ $area->estado == 'A' ? 'Activo' : 'Inactivo' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Creado por</div>
                <div class="profile-info-value"><span>{{ $area->creado_por }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Fecha de creaci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $area->fecha_creacion }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Modificado por</div>
                <div class="profile-info-value"><span>{{ $area->modificado_por }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Fecha de modificaci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $area->fecha_modificacion }}</span></div>
            </div>
        </div>
    </form>

@endsection
