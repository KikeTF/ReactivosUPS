@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Editar campo de conocimiento: '.$format->nombre)

@section('contenido')

    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => ['reagent.formats.update',$format->id],'method' => 'PUT']) !!}

    <div class="form-group">
        <div class="btn btn-white btn-primary btn-bold">
            <a class="blue" href="#" onclick="document.forms[0].submit();">
                <i class='ace-icon fa fa-save bigger-110 blue'></i>
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
            {!! Form::text('nombre', $format->nombre, ['class' => 'form-control', 'placeholder' => 'Formato de reactivo','required']) !!}
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
        <div class="col-sm-10">
            {!! Form::input('number','opciones_resp_min', $format->opciones_resp_min, ['class' => 'form-control', 'placeholder' => 'Ingrese n&uacute;mero de respuestas m&iacute;nimo','required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_resp_max', 'No. de respuesta m&aacute;ximo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::input('number','opciones_resp_max', $format->opciones_resp_max, ['class' => 'form-control', 'placeholder' => 'Ingrese n&uacute;mero de respuestas m&aacute;ximo','required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_pregunta', '¿Opciones de Pregunta?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    @if($format->opciones_pregunta == 'S')
                        {!! Form::checkbox('opciones_pregunta', 'S', true) !!}
                    @else
                        {!! Form::checkbox('opciones_pregunta', $format->opciones_pregunta) !!}
                    @endif
                </label>
            </div>

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('concepto_propiedad', '¿Opciones Concepto/Propiedad?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    @if($format->concepto_propiedad == 'S')
                        {!! Form::checkbox('concepto_propiedad', 'S', true) !!}
                    @else
                        {!! Form::checkbox('concepto_propiedad', $format->concepto_propiedad) !!}
                    @endif
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_preg_min', 'No. de preguntas m&iacute;nimo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::input('number','opciones_preg_min', $format->opciones_preg_min, ['class' => 'form-control', 'placeholder' => 'Ingrese n&uacute;mero de preguntas m&iacute;nimo','required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('opciones_preg_max', 'No. de preguntas m&aacute;ximo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::input('number','opciones_preg_max', $format->opciones_preg_max, ['class' => 'form-control', 'placeholder' => 'Ingrese n&uacute;mero de respuestas m&aacute;ximo','required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('imagenes', '¿Im&aacute;genes?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    @if($format->imagenes == 'S')
                        {!! Form::checkbox('imagenes', 'S', true) !!}
                    @else
                        {!! Form::checkbox('imagenes', $format->imagenes) !!}
                    @endif
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    @if($format->estado == 'A')
                        {!! Form::checkbox('estado', $format->estado, true) !!}
                    @else
                        {!! Form::checkbox('estado', $format->estado) !!}
                    @endif
                </label>
            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection