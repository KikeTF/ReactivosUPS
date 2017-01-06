@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Nuevo formato de reactivo')

@section('contenido')

    {!! Form::open(['id' => 'formulario','class' => 'form-horizontal', 'role' => 'form','route' => 'reagent.formats.store','method' => 'POST']) !!}
    <?php
    $btnsave = 1;
    $btnrefresh = route('reagent.formats.create');
    $btnclose = route('reagent.formats.index');
    ?>
    @include('shared.templates._formbuttons')

    <div class="form-group">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="clearfix">
                {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Formato de reactivo','required']) !!}
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
        {!! Form::label('opciones_resp_min', 'No. de respuesta m&iacute;nimo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-xs-6 col-sm-2">
            <div class="clearfix">
                {!! Form::input('number','opciones_resp_min', null,
                    ['min'=>'2', 'max'=>'10','class' => 'form-control', 'placeholder' => 'M&iacute;nimo 2; M&aacute;ximo 10','required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_resp_max', 'No. de respuesta m&aacute;ximo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-xs-6 col-sm-2">
            <div class="clearfix">
                {!! Form::input('number','opciones_resp_max', null,
                    ['min'=>'2', 'max'=>'10','class' => 'form-control', 'placeholder' => 'M&iacute;nimo 2; M&aacute;ximo 10','required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_pregunta', '¿Opciones de Pregunta?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('opciones_pregunta', 'S', true, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('concepto_propiedad', '¿Opciones Concepto/Propiedad?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('concepto_propiedad', 'S', true, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_preg_min', 'No. de preguntas m&iacute;nimo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-xs-6 col-sm-2">
            <div class="clearfix">
                {!! Form::input('number','opciones_preg_min', null,
                    ['min'=>'0', 'max'=>'10','class' => 'form-control', 'placeholder' => 'M&iacute;nimo 0; M&aacute;ximo 10','required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_preg_max', 'No. de preguntas m&aacute;ximo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-xs-6 col-sm-2">
            <div class="clearfix">
                {!! Form::input('number','opciones_preg_max', null,
                ['min'=>'0', 'max'=>'10','class' => 'form-control', 'placeholder' => 'M&iacute;nimo 0; M&aacute;ximo 10','required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('imagenes', '¿Im&aacute;genes?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('imagenes', 'S', true, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
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