@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Detalle de campo de conocimiento: '.$field->nombre)

@section('contenido')

    <form class="form-horizontal" role="form">
        <?php
        $btnedit = route('reagent.fields.edit', $field->id);
        $btnclose = route('reagent.fields.index');
        ?>
        @include('shared.templates._formbuttons')

        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name">C&oacute;digo</div>
                <div class="profile-info-value"><span>{{ $field->id }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Nombre</div>
                <div class="profile-info-value"><span>{{ $field->nombre }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Descripci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $field->descripcion }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Estado</div>
                <div class="profile-info-value"><span>{{ $field->estado == 'A' ? 'Activo' : 'Inactivo' }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Creado por</div>
                <div class="profile-info-value"><span>{{ $field->creado_por }}</span></div>
                <div class="profile-info-name">Fecha de creaci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $field->fecha_creacion }}</span></div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name">Modificado por</div>
                <div class="profile-info-value"><span>{{ $field->modificado_por }}</span></div>
                <div class="profile-info-name">Fecha de modificaci&oacute;n</div>
                <div class="profile-info-value"><span>{{ $field->fecha_modificacion }}</span></div>
            </div>
        </div>
    </form>

@endsection
