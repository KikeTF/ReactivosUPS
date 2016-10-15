@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Nuevo formato de reactivo')

@section('contenido')
    <?php
    $usetable = 0;
    ?>
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
        {!! Form::label('descripcion', 'Descripcion:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción']) !!}
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