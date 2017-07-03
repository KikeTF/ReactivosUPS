@extends('shared.templates.index')

@section('titulo', 'Seguridad')
@section('subtitulo', 'Editar perfil: '.$profile->nombre)

@section('contenido')

    {!! Form::open(['id' => 'formulario', 'class' => 'form-horizontal', 'role' => 'form','route' => ['security.profiles.update',$profile->id],'method' => 'PUT']) !!}
    <?php
    $btnsave = 1;
    $btnrefresh = route('security.profiles.edit',$profile->id);
    $btndelete = route('security.profiles.destroy', $profile->id);
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
        {!! Form::label('careersprofile', 'Carrera:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <select multiple="" name="careersprofile[]" id="careersprofile" class="chosen-select form-control tag-input-style" data-placeholder="-- Seleccione Carreras --" style="display: none;">
                <option value=""></option>
                @foreach($careersList as $career)
                    <option value="{{ $career->id }}" {!! ($profile->careersProfiles->where('id_carrera', $career->id)->count() > 0) ? "selected" : "" !!}>{{ $career->descripcion }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('optionsprofile', 'Accesos:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <select multiple="" name="optionsprofile[]" id="optionsprofile" class="chosen-select form-control tag-input-style" data-placeholder="-- Seleccione Accesos --" style="display: none;">
                <option value=""></option>
                @foreach($optionsList as $option)
                    <option value="{{ $option->id }}" {!! ($profile->optionsProfiles->where('id_opcion', $option->id)->count() > 0) ? "selected" : "" !!}>{{ $option->descripcion }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('', 'Permisos:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="well well-sm" style="margin: 0">
                <div class="form-group">
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('aprueba_reactivo', $profile->aprueba_reactivo, ($profile->aprueba_reactivo == 'S') ? true : false, ['class' => 'ace']) !!}
                                <span class="lbl">&nbsp;Aprueba Reactivo</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('aprueba_reactivos_masivo', $profile->aprueba_reactivos_masivo, ($profile->aprueba_reactivos_masivo == 'S') ? true : false, ['class' => 'ace']) !!}
                                <span class="lbl">&nbsp;Aprobaci&oacute;n Masiva de Reactivos</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('aprueba_examen', $profile->aprueba_examen, ($profile->aprueba_examen == 'S') ? true : false, ['class' => 'ace']) !!}
                                <span class="lbl">&nbsp;Aprueba Examen</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('restablece_password', $profile->restablece_password, ($profile->restablece_password == 'S') ? true : false, ['class' => 'ace']) !!}
                                <span class="lbl">&nbsp;Restablece Contrase&ntilde;a</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('dashboard', $profile->dashboard, ($profile->dashboard == 'S') ? true : false, ['class' => 'ace']) !!}
                                <span class="lbl">&nbsp;Dashboard</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
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