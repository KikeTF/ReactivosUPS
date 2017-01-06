@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Editar perfil: '.$profile->nombre)

@section('contenido')

    {!! Form::open(['id' => 'formulario', 'class' => 'form-horizontal', 'role' => 'form','route' => ['security.profiles.update',$profile->id],'method' => 'PUT']) !!}
    <?php
    $btnsave = 1;
    $btnrefresh = route('security.profiles.edit',$profile->id);
    $btnclose = route('security.profiles.index');
    ?>
    @include('shared.templates._formbuttons')

    <div class="form-group">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="clearfix">
                {!! Form::text('nombre', $profile->nombre, ['id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Nombre', 'required']) !!}
            </div>
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
            <select multiple="" name="optionsprofile[]" id="optionsprofile" class="chosen-select form-control tag-input-style" data-placeholder="Seleccione Perfiles..." style="display: none;" required>
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

@push('specific-script')
<script type="text/javascript">

</script>
@endpush