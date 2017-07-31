@extends('shared.templates.index')

@section('titulo', 'Examen Complexivo')
@section('subtitulo', 'Editar Examen')

@section('contenido')

    {!! Form::open(['id' => 'formulario','class' => 'form-horizontal', 'role' => 'form','route' => ['exam.exams.update', $exam->id],'method' => 'PUT']) !!}

    <?php
    $btnsave = 1;
    $btnlist = route('exam.exams.detail', ['id_exam' => $exam->id, 'id_matter' => 0] );
    $btnrefresh = route('exam.exams.edit', $exam->id);
    $btndelete = route('exam.exams.destroy', $exam->id);
    $btnclose = route('exam.exams.index');
    ?>
    @include('shared.templates._formbuttons')

    <div class="form-group">
        {!! Form::label('campus', 'Campus:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-7">
            {!! Form::text('campus', $exam->careerCampus->campus->descripcion, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('carrera', 'Carrera:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-7">
            {!! Form::text('carrera', $exam->careerCampus->career->descripcion, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('periodo', 'Periodo:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-7">
            {!! Form::text('periodo', '('.$exam->periodLocation->period->cod_periodo.') '.$exam->periodLocation->period->descripcion, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('fecha_activacion', 'Fecha Activacion:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-7">
            {!! Form::date('fecha_activacion', $exam->fecha_activacion, ['class' => 'form-control']) !!}
        </div>
    </div>

    <?php
    $periodos = '';
    foreach ($exam->examPeriods as $period)
    {
        $periodos = $periodos.'('.$period->periodLocation->period->cod_periodo.') '.$period->periodLocation->period->descripcion.'; ';
    }
    ?>
    <div class="form-group">
        {!! Form::label('periodos', 'Periodos Reactivos:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-7">
            {!! Form::text('periodos', $periodos, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('descripcion', 'Descripcion:', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-7">
            {!! Form::text('descripcion', $exam->descripcion, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('es_prueba', '¿Es de prueba?', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
        <div class="col-sm-7">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('es_prueba', 'S', (($exam->es_prueba == 'S') ? true : false), ['class' => 'ace']) !!}
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
    </div>
    

    {!! Form::close() !!}

@endsection