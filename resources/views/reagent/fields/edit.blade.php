@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Editar campo de conocimiento: '.$field->NOMBRE)

@section('contenido')
    <?php
    $usetable = 0;
    ?>
    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => ['reagent.fields.update',$field->COD_CAMPO],'method' => 'PUT']) !!}

    <div class="form-group">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('nombre', $field->NOMBRE, ['class' => 'form-control', 'placeholder' => 'Campo de conocimiento','required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('descripcion', 'Descripcion:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('descripcion', $field->DESCRIPCION, ['class' => 'form-control', 'placeholder' => 'Descripción']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('activo', '¿Activo?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    @if($field->ACTIVO == 1)
                        {!! Form::checkbox('activo', $field->ACTIVO, true) !!}
                    @else
                        {!! Form::checkbox('activo', $field->ACTIVO) !!}
                    @endif
                </label>
            </div>

        </div>
    </div>

    <div class="form-group" align="center">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        {!! Form::button('Cancelar', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

@endsection