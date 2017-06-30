@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Nueva parametrizaci&oacute;n para ex&aacute;menes')

@section('contenido')

    {!! Form::open(['id' => 'formulario', 'class' => 'form-horizontal', 'role' => 'form','route' => 'exam.parameters.store', 'method' => 'POST']) !!}

    <?php
    $btnsave = 1;
    $btnclose = route('exam.parameters.index');
    ?>
    @include('shared.templates._formbuttons')

    <div class="form-group">
        {!! Form::label('id_campus', 'Campus:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div id="listaCampus" class="col-sm-10">
            <div class="clearfix">
                @include("shared.optionlists._campuslist", ['requerido' => '1'])
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('id_carrera', 'Carrera:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div id="listaCarreras" class="col-sm-10">
            <div class="clearfix">
                @include("shared.optionlists._careerslist", ['requerido' => '1'])
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('duracion_examen', 'Duraci&oacute;n de examen:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-2">
            {!! Form::input('number','duracion_examen', null, ['class' => 'form-control', 'placeholder' => 'Minutos']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('id_examen_test', 'C&oacute;digo de examen prueba:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-2">
            {!! Form::input('number','id_examen_test', null, ['class' => 'form-control', 'placeholder' => 'Ingrese c&oacute;digo de examen actual']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('editar_respuestas', '¿Editar respuestas?', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('editar_respuestas', 'S', false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('instrucciones', 'Instrucciones:', ['class' => 'col-sm-2 control-label no-padding-right']) !!}
        <div class="col-sm-10">
            <div class="clearfix">
                {!! Form::textarea('instrucciones', null, ['id' => 'instrucciones', 'class' => 'form-control', 'size' => '100%x5', 'style' => 'resize: vertical;', 'required'])!!}
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection

@push('specific-script')
@include('shared.optionlists.functions')
<script type="text/javascript">
    $( window ).load(function() {
        getCareersByCampus();
    });
</script>
@endpush