@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Listado de reactivos')

@section('contenido')
    <?php
    $usetable = 1;
    //$isReagent = 1;
    $newurl = route('exam.exams.create');
    $columnas = array("id", "descripcion", "fecha_activacion", "es_prueba", "estado"); // "capitulo", "tema",
    ?>

    {!! Form::open(['id'=>'formdata', 'class' => 'form-horizontal', 'role' => 'form','route' => 'exam.exams.index','method' => 'GET']) !!}
{{--

    <div class="widget-box">
        <div class="widget-header">
            <h5 class="widget-title">Filtros</h5>

            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
        </div>

        <div class="widget-body" style="display: block;">
            <div class="widget-main">
                <div class="row" style="position: relative;">
                    <div class="col-sm-11">
                        <div class="col-sm-3">
                            {!! Form::label('id_campus', 'Seleccione Campus:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) !!}
                            {!! Form::select('id_campus', $campuses, $filters[0], ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-sm-3">
                            {!! Form::label('id_carrera', 'Seleccione Carrera:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) !!}
                            {!! Form::select('id_carrera', $careers, $filters[1], ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-sm-3">
                            {!! Form::label('id_materia', 'Seleccione Materia:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) !!}
                            {!! Form::select('id_materia', $matters, $filters[2], ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-sm-3">
                            {!! Form::label('id_estado', 'Seleccione Estado:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) !!}
                            {!! Form::select('id_estado', $states, $filters[3], ['class' => 'form-control', 'placeholder' => 'Todos los Estados']) !!}
                        </div>
                    </div>
                    <div class="col-sm-1" style="float:right; position:absolute; bottom:0; right:0;">
                        <div class="btn btn-white btn-primary btn-bold" style="float:right;">
                            <a class="blue" href="#" onclick="document.forms[0].submit();">
                                <i class='ace-icon fa fa-filter bigger-110 blue'></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
--}}

    {!! Form::close() !!}

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
            <tr>
                <th style="text-align: center">C&oacute;digo</th>
                <th style="text-align: center">Descripci&oacute;n</th>
                <th style="text-align: center">Fecha Activaci&oacute;n</th>
                <th style="text-align: center">¿Es de Prueba?</th>
                <th style="text-align: center">Estado</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            {{--@if($filters[0] > 0)--}}
                @foreach($exams as $exam)
                    <?php
                    $urls = array(
                        'showurl' => route('exam.exams.detail', [$exam->id, 0]),
                        'editurl' => route('exam.exams.edit', $exam->id),
                        'destroyurl' => route('exam.exams.destroy', $exam->id)
                    );
                    ?>
                    <tr>
                        <td align="center">{{ $exam->id }}</td>
                        <td>{{ $exam->descripcion }}</td>
                        <td>{{ $exam->fecha_activacion }}</td>
                        <td>{{ $exam->es_prueba }}</td>
                        <td>{{ $exam->estado }}</td>
                        <td>
                            @include('shared.templates._tablebuttons', $urls)
                        </td>
                    </tr>
                @endforeach
            {{--@endif--}}
            </tbody>
        </table>
    </div>
@endsection