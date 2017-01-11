@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Editar campo de conocimiento: '.$field->nombre)

@section('contenido')

    {!! Form::open(['id' => 'formulario','class' => 'form-horizontal', 'role' => 'form','route' => ['reagent.fields.update', $field->id],'method' => 'PUT']) !!}
    <?php
    $btnsave = 1;
    $btnrefresh = route('reagent.fields.edit',$field->id);
    $btndelete = route('reagent.fields.destroy', $field->id);
    $btnclose = route('reagent.fields.index');
    ?>
    @include('shared.templates._formbuttons')

    <div class="form-group">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="clearfix">
                {!! Form::text('nombre', $field->nombre, ['class' => 'form-control', 'placeholder' => 'Campo de conocimiento','required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('descripcion', 'Descripci&oacute;n:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('descripcion', $field->descripcion, ['class' => 'form-control', 'placeholder' => 'Descripción']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('estado', $field->estado, ($field->estado == 'A') ? true : false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection