@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Detalle de par&aacute;metros por materia')

@section('contenido')

    <form class="form-horizontal" role="form">
        <?php
        $btnedit = route('general.matterscareers.edit', $mattercareer->id);
        $btnclose = route('general.matterscareers.index');
        ?>
        @include('shared.templates._formbuttons')

        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">C&oacute;digo</div>
                <div class="profile-info-value"><span>{{ $mattercareer->id }}</span></div>
                <div class="profile-info-value">
                    <span>
                    <button onclick="location.href='{{ route('general.matterscareers.download', $mattercareer->id) }}'; return false;"
                        class="btn btn-white btn-primary btn-sm" {{ $mattercareer->archivo_contenido == 'S' ? '' : 'disabled' }} >
                        <i class="ace-icon fa fa-download bigger-110" aria-hidden="true"></i> Descargar Archivo
                    </button>
                    </span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Campus</div>
                <div class="profile-info-value"><span>{{ $mattercareer->desc_campus }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Carrera</div>
                <div class="profile-info-value"><span>{{ $mattercareer->desc_carrera }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Menci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $mattercareer->desc_mencion }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">&Aacute;rea</div>
                <div class="profile-info-value"><span>{{ $mattercareer->desc_area }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Materia</div>
                <div class="profile-info-value"><span>{{ $mattercareer->desc_materia }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Nivel</div>
                <div class="profile-info-value"><span>{{ $mattercareer->nivel }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">No. Reactivos Entregables</div>
                <div class="profile-info-value"><span>{{ $mattercareer->nro_reactivos_mat }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">¿Aplica a Examen?</div>
                <div class="profile-info-value"><span>{{ $mattercareer->aplica_examen }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">No. Reactvos en Examen</div>
                <div class="profile-info-value"><span>{{ $mattercareer->nro_reactivos_exam }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Responsable</div>
                <div class="profile-info-value"><span>{{ $mattercareer->usr_responsable }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Estado</div>
                <div class="profile-info-value"><span>{{ $mattercareer->estado == 'A' ? 'Activo' : 'Inactivo' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Creado por</div>
                <div class="profile-info-value"><span>{{ $mattercareer->creado_por }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Fecha de creaci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $mattercareer->fecha_creacion }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Modificado por</div>
                <div class="profile-info-value"><span>{{ $mattercareer->modificado_por }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Fecha de modificaci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $mattercareer->fecha_modificacion }}</span></div>
            </div>

        </div>
    </form>

@endsection
