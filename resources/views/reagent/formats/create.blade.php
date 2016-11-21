@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Nuevo formato de reactivo')

@section('contenido')

    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => 'reagent.formats.store','method' => 'POST']) !!}

    <div class="form-group">
        <div class="btn btn-white btn-primary btn-bold">
            <a class="blue" href="#" onclick="document.forms[0].submit();">
                <i class='ace-icon fa fa-save bigger-110 blue'></i>
            </a>
        </div>
        <div class="btn btn-white btn-primary btn-bold">
            <a class="green" href="{{ route('reagent.formats.create') }}">
                <i class='ace-icon fa fa-repeat bigger-110 green'></i>
            </a>
        </div>
        <div class="btn btn-white btn-primary btn-bold">
            <a class="red" href="{{ route('reagent.formats.index') }}">
                <i class='ace-icon fa fa-close bigger-110 red'></i>
            </a>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Formato de reactivo','required']) !!}
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
        <div class="col-sm-10">
            {!! Form::input('number','opciones_resp_min', null, ['class' => 'form-control', 'placeholder' => 'Ingrese n&uacute;mero de respuestas m&iacute;nimo','required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_resp_max', 'No. de respuesta m&aacute;ximo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::input('number','opciones_resp_max', null, ['class' => 'form-control', 'placeholder' => 'Ingrese n&uacute;mero de respuestas m&aacute;ximo','required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_pregunta', '¿Opciones de Pregunta?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('opciones_pregunta', 'S', true) !!}
                </label>
            </div>

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('concepto_propiedad', '¿Opciones Concepto/Propiedad?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('concepto_propiedad', 'S', true) !!}
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_preg_min', 'No. de preguntas m&iacute;nimo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::input('number','opciones_preg_min', null, ['class' => 'form-control', 'placeholder' => 'Ingrese n&uacute;mero de preguntas m&iacute;nimo','required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_preg_max', 'No. de preguntas m&aacute;ximo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::input('number','opciones_preg_max', null, ['class' => 'form-control', 'placeholder' => 'Ingrese n&uacute;mero de respuestas m&aacute;ximo','required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('imagenes', '¿Im&aacute;genes?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('imagenes', 'S', true) !!}
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('estado', 'A', true) !!}
                </label>
            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection