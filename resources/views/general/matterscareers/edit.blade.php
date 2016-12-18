@extends('shared.templates.index')

@section('titulo', 'General')
@section('subtitulo', 'Editar parametros de materia')

@section('contenido')

    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => ['general.matterscareers.update',$mattercareer->id],'method' => 'PUT']) !!}

    <div class="form-group">
        <div class="btn btn-white btn-primary btn-bold">
            <a class="blue" href="#" onclick="document.forms[0].submit();">
                <i class='ace-icon fa fa-save bigger-110 blue'></i>
            </a>
        </div>
        <div class="btn btn-white btn-primary btn-bold">
            <a class="red" href="{{ route('general.matterscareers.index') }}">
                <i class='ace-icon fa fa-close bigger-110 red'></i>
            </a>
        </div>
    </div>


    <div class="form-group">
        {!! Form::label('desc_campus', 'Campus:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::text('desc_campus', $mattercareer->desc_campus, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('desc_carrera', 'Carrera:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::text('desc_carrera', $mattercareer->desc_carrera, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('desc_mencion', 'Menci&oacute;n:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::text('desc_mencion', $mattercareer->desc_mencion, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('desc_area', '&Aacute;rea:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::text('desc_area', $mattercareer->desc_area, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('nivel', 'Nivel:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::text('nivel', $mattercareer->nivel, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('tipo', 'Tipo:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::text('tipo', $mattercareer->tipo, ['class' => 'form-control', 'placeholder' => 'Tipo', 'readonly']) !!}
        </div>
    </div>


    <div class="form-group">
        {!! Form::label('nro_reactivos_mat', 'No. de Reactivos Entregables:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::input('number','nro_reactivos_mat', $mattercareer->nro_reactivos_mat,
                ['class' => 'form-control', 'placeholder' => 'Ingrese cantidad de reactivos', 'required']
            ) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('nro_reactivos_exam', 'No. de Reactivos en Examen:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::input('number','nro_reactivos_exam', $mattercareer->nro_reactivos_exam, ['class' => 'form-control', 'placeholder' => 'Ingrese cantidad de reactivos','required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('aplica_examen', '¿Aplica Examen?', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('aplica_examen', $mattercareer->aplica_examen, ($mattercareer->aplica_examen == 'S') ? true : false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('estado', $mattercareer->estado, ($mattercareer->estado == 'A') ? true : false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection