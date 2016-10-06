@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Nuevo campo de conocimiento')

@section('contenido')
    <?php
    $usetable = 0;
    ?>
    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => 'reagent.fields.store','method' => 'POST']) !!}

            <div class="form-group">
                {!! Form::label('nombre', 'Nombre:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                <div class="col-sm-10">
                    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Campo de conocimiento','required']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('descripcion', 'Descripcion:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                <div class="col-sm-10">
                    {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('activo', '¿Activo?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                <div class="col-sm-10">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('activo', 1, true) !!}
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