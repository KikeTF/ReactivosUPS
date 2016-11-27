@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Usuarios')

@section('contenido')

    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => 'security.users.store','method' => 'POST']) !!}

        <div class="row">
            <div class="form-group">
                {!! Form::label('nombres', 'Nombres:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                <div class="col-sm-10">
                    {!! Form::text('nombres', null, ['class' => 'form-control', 'placeholder' => 'Nombres del usuario','required']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('apellidos', 'Apellidos:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                <div class="col-sm-10">
                    {!! Form::text('apellidos', null, ['class' => 'form-control', 'placeholder' => 'Apellidos del usuario', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('correo', 'Correo Electr&oacute;nico:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
                <div class="col-sm-10">
                    {!! Form::text('correo', null, ['class' => 'form-control', 'placeholder' => 'ejemplo@ups.edu.ec', 'required']) !!}
                </div>
            </div>
        </div>

    {!! Form::close() !!}

@endsection