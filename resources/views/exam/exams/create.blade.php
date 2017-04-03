@extends('shared.templates.index')

@section('titulo', 'Examen')
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

        <div>
            <div class="form-group">
                {!! Form::label('id_campus', 'Campus:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                <div id="listaCampus" class="col-sm-7">
                    @include("shared.optionlists._campuslist")
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('id_carrera', 'Carrera:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                <div id="listaCarreras" class="col-sm-7">
                    @include("shared.optionlists._careerslist")
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('descripcion', 'Descripcion:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                <div class="col-sm-7">
                    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('fecha_activacion', 'Fecha Activacion:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                <div class="col-sm-7">
                    {!! Form::date('fecha_activacion', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('es_prueba', '¿Es de prueba?', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                <div class="col-sm-7">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('es_prueba', 'N', false, ['class' => 'ace']) !!}
                            <span class="lbl"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div id="actions-bottons" class="pull-right">
                <button class="btn btn-success btn-next">
                    Siguiente
                    <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                </button>
            </div>
        </div>

    {!! Form::close() !!}

@endsection

@push('specific-script')
<script type="text/javascript" src="{{ asset('scripts/exam/exams/common.js') }}"></script>
@include("shared.optionlists.functions")

@endpush