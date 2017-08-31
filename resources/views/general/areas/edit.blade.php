@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Editar &aacute;rea: '.$area->descripcion)

@section('contenido')

    {!! Form::open(['id' => 'formulario','class' => 'form-horizontal', 'role' => 'form','route' => ['general.areas.update', $area->id],'method' => 'PUT']) !!}
    <?php
    $btnsave = 1;
    $btnrefresh = route('general.areas.edit',$area->id);
    $btndelete = route('general.areas.destroy', $area->id);
    $btnclose = route('general.areas.index');
    ?>
    @include('shared.templates._formbuttons')

    <div class="form-group">
        {!! Form::label('cod_area', 'C&oacute;digo:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::text('cod_area', $area->cod_area, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('descripcion', 'Descripci&oacute;n:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            {!! Form::text('descripcion', $area->descripcion, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('id_usuario_resp', 'Responsable:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            <select name="id_usuario_resp" id="id_usuario_resp" class="chosen-select form-control" data-placeholder="-- NO DEFINIDO --" required>
                <option value="0"></option>
                @foreach($usersList as $user)
                    <option value="{{ $user->id }}" {{ ($user->id  == $area->id_usuario_resp) ? 'selected' : ''}}>{{ $user->FullName }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('estado', '¿Activo?', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-8">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('estado', $area->estado, ($area->estado == 'A') ? true : false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
    </div>


    {!! Form::close() !!}

@endsection
