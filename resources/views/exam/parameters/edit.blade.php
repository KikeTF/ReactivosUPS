@extends('shared.template.index')

@section('titulo', 'Examen')
@section('subtitulo', 'Editar parametros:')

@section('contenido')

    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => 'exam.parameters.store','method' => 'PUT']) !!}

    <div class="form-group">
        <div class="btn btn-white btn-primary btn-bold">
            <a class="blue" href="#" onclick="document.forms[0].submit();">
                <i class='ace-icon fa fa-save bigger-110 blue'></i>
            </a>
        </div>
        <div class="btn btn-white btn-primary btn-bold">
            <a class="red" href="{{ route('exam.parameters.index') }}">
                <i class='ace-icon fa fa-close bigger-110 red'></i>
            </a>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('nro_preguntas', 'Numero de reguntas:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('nro_preguntas', $parameter->nro_preguntas, ['class' => 'form-control', 'placeholder' => 'ingrese numero de preguntas para examen','required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('duracion_examen', 'Duracion de examen:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('duracion_examen', $parameter->duracion_examen, ['class' => 'form-control', 'placeholder' => 'Ingrese duracion del examen']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('id_examen_act', 'Codigo de examen actual:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('id_examen_act', $parameter->id_examen_act, ['class' => 'form-control', 'placeholder' => 'Ingrese codigo de examen actual']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('editar_respuestas', 'Editar respuestas:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::select('editar_respuestas', array('S' => 'Si', 'N' => 'No'), 'S') !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    @if($parameter->estado == 'A')
                        {!! Form::checkbox('estado', $parameter->estado, true) !!}
                    @else
                        {!! Form::checkbox('estado', $parameter->estado) !!}
                    @endif
                </label>
            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection