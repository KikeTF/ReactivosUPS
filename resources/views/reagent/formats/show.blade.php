@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Detalle de formato: '.$format->nombre)

@section('contenido')

    <form class="form-horizontal" role="form">
        <?php
        $btnedit = route('reagent.formats.edit', $format->id);
        $btnclose = route('reagent.formats.index');
        ?>
        @include('shared.templates._formbuttons')

        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">C&oacute;digo</div>
                <div class="profile-info-value"><span>{{ $format->id }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Nombre</div>
                <div class="profile-info-value"><span>{{ $format->nombre }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Descripci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $format->descripcion }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">No. Respuesta M&iacute;nimo:</div>
                <div class="profile-info-value"><span>{{ $format->opciones_resp_min }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">No. Respuesta M&aacute;ximo</div>
                <div class="profile-info-value"><span>{{ $format->opciones_resp_max }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">¿Opciones de Pregunta?</div>
                <div class="profile-info-value"><span>{{ $format->opciones_pregunta == 'S' ? 'Si' : 'No' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">¿Opciones Concepto/Propiedad?</div>
                <div class="profile-info-value"><span>{{ $format->concepto_propiedad == 'S' ? 'Si' : 'No' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">No. Conceptos M&iacute;nimo</div>
                <div class="profile-info-value"><span>{{ $format->opciones_preg_min }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">No. Conceptos M&aacute;ximo</div>
                <div class="profile-info-value"><span>{{ $format->opciones_preg_max }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">No. Propiedades M&iacute;nimo</div>
                <div class="profile-info-value"><span>{{ $format->opciones_prop_min }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">No. Propiedades M&aacute;ximo</div>
                <div class="profile-info-value"><span>{{ $format->opciones_prop_max }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">¿Im&aacute;genes?</div>
                <div class="profile-info-value"><span>{{ $format->imagenes == 'S' ? 'Si' : 'No' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Estado</div>
                <div class="profile-info-value"><span>{{ $format->estado == 'A' ? 'Activo' : 'Inactivo' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Creado por</div>
                <div class="profile-info-value"><span>{{ $format->creado_por }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Fecha de creaci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $format->fecha_creacion }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Modificado por</div>
                <div class="profile-info-value"><span>{{ $format->modificado_por }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Fecha de modificaci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $format->fecha_modificacion }}</span></div>
            </div>
        </div>
    </form>

@endsection
