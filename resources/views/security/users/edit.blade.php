@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Editar usuario: '.$user->nombres.' '.$user->apellidos)

@section('contenido')

    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => ['security.users.update',$user->id],'method' => 'PUT']) !!}

    <div class="form-group">
        <div class="btn btn-white btn-primary btn-bold">
            <a class="blue" href="#" onclick="document.forms[0].submit();">
                <i class='ace-icon fa fa-save bigger-110 blue'></i>
            </a>
        </div>
        <div class="btn btn-white btn-primary btn-bold">
            <a class="red" href="{{ route('security.users.index') }}">
                <i class='ace-icon fa fa-close bigger-110 red'></i>
            </a>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('nombres', 'Nombres:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('nombres', $user->nombres, ['class' => 'form-control', 'placeholder' => 'Nombres', 'disabled']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('apellidos', 'Apellidos:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('apellidos', $user->apellidos, ['class' => 'form-control', 'placeholder' => 'Apellidos', 'disabled']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Correo Electr&oacute;nico', 'disabled']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('username', 'Usuario:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('username', $user->username, ['class' => 'form-control', 'placeholder' => 'Usuario']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Contrase&ntilde;a:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Ingrese la nueva contrase&ntilde;a']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('tipo', 'Tipo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <select id="tipo" name="tipo" class="form-control">
                <option value="D">Docente</option>
                <option value="E">Estudiante</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('perfiles', 'Perfiles:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <select multiple="" name="perfiles" id="perfiles" class="chosen-select form-control tag-input-style" data-placeholder="Seleccione Perfiles..." style="display: none;">
                <option value=""></option>
                @foreach($profiles as $profile)
                    <option value="{{ $profile->id }}">{{ $profile->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('estado', $user->estado, ($user->estado == 'A') ? true : false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection