@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Nuevo campo de conocimiento')

@section('contenido')

    {!! Form::open(['id' => 'formulario','class' => 'form-horizontal', 'role' => 'form','route' => 'reagent.fields.store','method' => 'POST']) !!}
        <?php
        $btnsave = 1;
        $btnrefresh = route('reagent.fields.create');
        $btnclose = route('reagent.fields.index');
        ?>
        @include('shared.templates._formbuttons')

        <div class="form-group">
            {!! Form::label('nombre', 'Nombre:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
            <div class="col-sm-10">
                <div class="clearfix">
                    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Campo de conocimiento','required']) !!}
                </div>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('descripcion', 'Descripci&oacute;n:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
            <div class="col-sm-10">
                {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
            <div class="col-sm-10">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('estado', 'A', true, ['class' => 'ace']) !!}
                        <span class="lbl"></span>
                    </label>
                </div>

            </div>
        </div>

    {!! Form::close() !!}

@endsection