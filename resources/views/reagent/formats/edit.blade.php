@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Editar campo de conocimiento: '.$format->nombre)

@section('contenido')

    {!! Form::open(['id' => 'formulario','class' => 'form-horizontal', 'role' => 'form','route' => ['reagent.formats.update',$format->id],'method' => 'PUT']) !!}
    <?php
    $btnsave = 1;
    $btnrefresh = route('reagent.formats.edit',$format->id);
    $btndelete = route('reagent.formats.destroy', $format->id);
    $btnclose = route('reagent.formats.index');
    ?>
    @include('shared.templates._formbuttons')

    <div class="form-group">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="clearfix">
                {!! Form::text('nombre', $format->nombre, ['class' => 'form-control', 'placeholder' => 'Formato de reactivo','required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('descripcion', 'Descripci&oacute;n:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('descripcion', $format->descripcion, ['class' => 'form-control', 'placeholder' => 'Descripción']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_resp_min', 'No. de respuesta m&iacute;nimo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-xs-6 col-sm-2">
            <div class="clearfix">
                {!! Form::input('number','opciones_resp_min', $format->opciones_resp_min,
                    ['min'=>'2', 'max'=>'10','class' => 'form-control', 'placeholder' => 'M&iacute;nimo 2; M&aacute;ximo 10','required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_resp_max', 'No. de respuesta m&aacute;ximo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-xs-6 col-sm-2">
            <div class="clearfix">
                {!! Form::input('number','opciones_resp_max', $format->opciones_resp_max,
                    ['min'=>'2', 'max'=>'10','class' => 'form-control', 'placeholder' => 'M&iacute;nimo 2; M&aacute;ximo 10','required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_pregunta', '¿Opciones de Pregunta?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('opciones_pregunta', $format->opciones_pregunta, ($format->opciones_pregunta == 'S') ? true : false, ['class' => 'ace']) !!}
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
                    {!! Form::checkbox('concepto_propiedad', $format->concepto_propiedad, ($format->concepto_propiedad == 'S') ? true : false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_preg_min', 'No. de preguntas m&iacute;nimo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-xs-6 col-sm-2">
            <div class="clearfix">
                {!! Form::input('number','opciones_preg_min', $format->opciones_preg_min,
                    ['min'=>'0', 'max'=>'10','class' => 'form-control', 'placeholder' => 'M&iacute;nimo 0; M&aacute;ximo 10','required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_preg_max', 'No. de preguntas m&aacute;ximo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-xs-6 col-sm-2">
            <div class="clearfix">
                {!! Form::input('number','opciones_preg_max', $format->opciones_preg_max,
                    ['min'=>'0', 'max'=>'10','class' => 'form-control', 'placeholder' => 'M&iacute;nimo 0; M&aacute;ximo 10','required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('imagenes', '¿Im&aacute;genes?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('imagenes', $format->imagenes, ($format->imagenes == 'S') ? true : false, ['class' => 'ace']) !!}
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
                    {!! Form::checkbox('estado', $format->estado, ($format->estado == 'A') ? true : false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection