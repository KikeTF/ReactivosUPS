@extends('shared.templateS.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Nuevo Perfil')

@section('contenido')

    {!! Form::open(['id' => 'formulario', 'class' => 'form-horizontal', 'role' => 'form','route' => 'security.profiles.store','method' => 'POST']) !!}
    <?php
    $btnsave = 1;
    $btnrefresh = route('security.profiles.create');
    $btnclose = route('security.profiles.index');
    ?>
    @include('shared.templates._formbuttons')

    <div class="form-group">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="clearfix">
                {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre', 'required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('descripcion', 'Descripci&oacute;n:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('careersprofile', 'Carrera:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <select multiple="" name="careersprofile[]" id="careersprofile" class="chosen-select form-control tag-input-style" data-placeholder="-- Seleccione Carreras --" style="display: none;">
                <option value=""></option>
                @foreach($careersList as $career)
                    <option value="{{ $career->id }}">{{ $career->descripcion }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('optionsprofile', 'Accesos:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <select multiple="" name="optionsprofile[]" class="chosen-select form-control tag-input-style" data-placeholder="-- Seleccione Accesos --" style="display: none;" required>
                <option value=""></option>
                @foreach($optionsList as $option)
                    <option value="{{ $option->id }}" >{{ $option->descripcion }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('', 'Permisos:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="well well-sm" style="margin: 0">
                <div class="form-group">
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('aprueba_reactivo', 'S', false, ['class' => 'ace']) !!}
                                <span class="lbl">&nbsp;Aprueba Reactivo</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('aprueba_reactivos_masivo', 'S', false, ['class' => 'ace']) !!}
                                <span class="lbl">&nbsp;Aprobaci&oacute;n Masiva de Reactivos</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('aprueba_examen', 'S', false, ['class' => 'ace']) !!}
                                <span class="lbl">&nbsp;Aprueba Examen</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('restablece_password', 'S', false, ['class' => 'ace']) !!}
                                <span class="lbl">&nbsp;Restablece Contrase&ntilde;a</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('dashboard', 'S', false, ['class' => 'ace']) !!}
                                <span class="lbl">&nbsp;Dashboard</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('estado', 'A', true, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection