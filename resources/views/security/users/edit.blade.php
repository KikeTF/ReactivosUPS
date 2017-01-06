@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Editar usuario: '.$user->nombres.' '.$user->apellidos)

@section('contenido')

    {!! Form::open(['id' => 'formulario', 'class' => 'form-horizontal', 'role' => 'form','route' => ['security.users.update',$user->id],'method' => 'PUT']) !!}
    <?php
    $btnsave = 1;
    $btnrefresh = route('security.users.edit',$user->id);
    $btnclose = route('security.users.index');
    ?>
    @include('shared.templates._formbuttons')

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
            <div class="clearfix">
                {!! Form::text('username', $user->username, ['class' => 'form-control', 'placeholder' => 'Usuario', 'required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Contrase&ntilde;a:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="clearfix">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Ingrese la nueva contrase&ntilde;a', 'required']) !!}
            </div>
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
            <select multiple="" name="perfiles[]" class="chosen-select form-control tag-input-style" data-placeholder="Seleccione Perfiles..." style="display: none;" required>
                <option value=""></option>
                @foreach($profilesList as $profile)
                    <option value="{{ $profile->id }}" {!! ($userProfiles->where('id_perfil', $profile->id)->count() > 0) ? "selected" : "" !!}>{{ $profile->nombre }}</option>
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