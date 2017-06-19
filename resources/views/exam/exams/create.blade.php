@extends('shared.templates.index')

@section('titulo', 'Examen Complexivo')
@section('subtitulo', 'Generaci&oacute;n de Examen')

@section('contenido')

    {!! Form::open(['id' => 'formulario',
            'class' => 'form-horizontal',
            'role' => 'form',
            'route' => 'exam.exams.store',
            'method' => 'POST']) !!}

    <?php
    $btnsave = 1;
    $btnrefresh = route('exam.exams.create');
    $btnclose = route('exam.exams.index');
    ?>
    @include('shared.templates._formbuttons')

    <div class="form-group">
        {!! Form::label('id_campus', 'Campus:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div id="listaCampus" class="col-sm-7">
            <div class="clearfix">
                @include("shared.optionlists._campuslist", ['requerido' => '1'])
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('id_carrera', 'Carrera:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div id="listaCarreras" class="col-sm-7">
            <div class="clearfix">
                @include("shared.optionlists._careerslist", ['requerido' => '1'])
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('id_periodo_sede', 'Periodo:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-7">
            <div class="clearfix">
                {!! Form::select('id_periodo_sede', $locationPeriodsList, null, ['id' => 'id_periodo_sede', 'class' => 'form-control', 'placeholder' => '-- Seleccione Periodo --', 'required'] ) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('fecha_activacion', 'Fecha Activacion:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-7">
            <div class="clearfix">
                {!! Form::date('fecha_activacion', null, ['class' => 'form-control', 'required']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('periodosSede[]', 'Periodos Reactivos:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-7">
            {!! Form::select('periodosSede[]', $locationPeriodsList, null, ['multiple' => '', 'id' => 'periodosSede', 'class' => 'chosen-select form-control tag-input-style', 'data-placeholder' => '-- Seleccione Periodos --', 'style' => 'display: none;', 'required'] ) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('descripcion', 'Descripcion:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-7">
            {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Opcional']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('es_prueba', '¿Es de prueba?', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-7">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('es_prueba', 'S', false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('es_automatico', '¿Generaci&oacute;n Autom&aacute;tica?', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-7">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('es_automatico', 'S', false, ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-10">
            <div id="actions-bottons" class="pull-right">
                <button class="btn btn-success btn-next">
                    Siguiente
                    <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                </button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection

@push('specific-script')
{!! HTML::script('scripts/exam/exams/common.js') !!}
@include("shared.optionlists.functions")
<script type="text/javascript">
    $( window ).load(function() {
        getCareersByCampus();
    });
</script>
@endpush