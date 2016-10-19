@extends('shared.template.index')

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
        {!! Form::label('descripcion', 'Descripcion:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('descripcion', $format->descripcion, ['class' => 'form-control', 'placeholder' => 'Descripción']) !!}
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