@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Editar campo de conocimiento: '.$field->nombre)

@section('contenido')

    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => ['reagent.fields.update',$field->cod_campo],'method' => 'PUT']) !!}

    <div class="form-group">
        <div class="btn btn-white btn-primary btn-bold">
            <a class="blue" href="#" onclick="document.forms[0].submit();">
                <i class='ace-icon fa fa-save bigger-110 blue'></i>
            </a>
        </div>
        <div class="btn btn-white btn-primary btn-bold">
            <a class="red" href="{{ route('reagent.fields.index') }}">
                <i class='ace-icon fa fa-close bigger-110 red'></i>
            </a>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('nombre', $field->nombre, ['class' => 'form-control', 'placeholder' => 'Campo de conocimiento','required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('descripcion', 'Descripcion:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('descripcion', $field->descripcion, ['class' => 'form-control', 'placeholder' => 'Descripción']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    @if($field->estado == 'A')
                        {!! Form::checkbox('estado', $field->estado, true) !!}
                    @else
                        {!! Form::checkbox('estado', $field->estado) !!}
                    @endif
                </label>
            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection