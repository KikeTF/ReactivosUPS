@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Editar usuario: '.$user->FullName)

@section('contenido')

    {!! Form::open(['id' => 'formulario', 'class' => 'form-horizontal', 'role' => 'form','route' => ['security.users.update',$user->id],'method' => 'PUT']) !!}
    <?php
    $btnsave = 1;
    $btnrefresh = route('security.users.edit',$user->id);
    $btndelete = route('security.users.destroy', $user->id);
    $btnclose = route('security.users.index');
    ?>
    @include('shared.templates._formbuttons')

    <div class="form-group">
        {!! Form::label('username', 'Usuario:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="clearfix">
                {!! Form::text('username', $user->username, ['class' => 'form-control', 'placeholder' => 'Usuario', 'readonly']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Contrase&ntilde;a:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="clearfix">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Nueva contrase&ntilde;a']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('password_confirm', 'Verificar Contrase&ntilde;a:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="clearfix">
                {!! Form::password('password_confirm', ['class' => 'form-control', 'placeholder' => 'Verificar contrase&ntilde;a']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('cambiar_password', '¿Requiere Cambio de Contrase&ntilde;a?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('cambiar_password', $user->cambiar_password, ($user->cambiar_password == 'S') ? true : false, ['class' => 'ace', 'disabled']) !!}
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('tipo', 'Sede:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('tipo', $user->location->descripcion, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Correo Electr&oacute;nico', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('tipo', 'Tipo:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('tipo', ($user->tipo == 'D' ? 'Docente' : 'Estudiante'), ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('perfiles', 'Perfiles de Acceso:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <select multiple="" name="perfiles[]" class="chosen-select form-control tag-input-style" data-placeholder="-- Seleccione Perfiles --" style="display: none;" required>
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