@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Editar perfil: '.$profile->descripcion)

@section('contenido')

    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => ['security.profiles.update',$profile->id],'method' => 'PUT']) !!}

    <div class="form-group">
        <div class="btn btn-white btn-primary btn-bold">
            <a class="blue" href="#" onclick="document.forms[0].submit();">
                <i class='ace-icon fa fa-save bigger-110 blue'></i>
            </a>
        </div>
        <div class="btn btn-white btn-primary btn-bold">
            <a class="red" href="{{ route('security.profiles.index') }}">
                <i class='ace-icon fa fa-close bigger-110 red'></i>
            </a>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('nombre', $profile->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('descripcion', 'Descripci&oacute;n:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            {!! Form::text('descripcion', $profile->descripcion, ['class' => 'form-control', 'placeholder' => 'Descripción']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('optionsprofile', 'Opciones de Perfil:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <select multiple="" name="optionsprofile[]" class="chosen-select form-control tag-input-style" data-placeholder="Seleccione Perfiles..." style="display: none;">
                <option value=""></option>
                @foreach($optionsList as $option)
                    <option value="{{ $option->id }}" {!! ($optionsProfiles->where('id_opcion', $option->id)->count() > 0) ? "selected" : "" !!}>{{ $option->descripcion }}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="form-group">
        {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('estado', $profile->estado, ($profile->estado == 'A') ? true : false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection