@extends('shared.templates.index')

@section('titulo', 'General')
@section('subtitulo', 'Listado de Materias')

@section('contenido')
    <?php
    $usetable = 1;
    //$dataurl = route('general.matterscareers.data');
    //$newurl = route('general.matterscareers.create');
    $columnas = array("id_materia", "nivel", "tipo", "nro_reactivos_mat", "aplica_examen", "nro_reactivos_exam", "estado");
    ?>

    {!! Form::open(['id'=>'formdata', 'class' => 'form-horizontal', 'role' => 'form','route' => 'general.matterscareers.index','method' => 'GET']) !!}

    <div class="widget-box">
        <div class="widget-header">
            <h5 class="widget-title">Filtros</h5>

            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>

                {{--<a href="#" data-action="close">
                    <i class="ace-icon fa fa-times"></i>
                </a>--}}
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main">
                <div class="row" style="position: relative">
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
                            {!! Form::label('id_mencion', 'Seleccione Menci&oacute;n:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) !!}
                            {!! Form::select('id_mencion', $mentions, $filters[2], ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-sm-3">
                            {!! Form::label('id_area', 'Seleccione &Aacute;rea:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) !!}
                            {!! Form::select('id_area', $areas, $filters[3], ['class' => 'form-control', 'placeholder' => '-- Todas las Areas --']) !!}
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

    {!! Form::close() !!}

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
                <tr>
                    <th style="text-align: center">Materia</th>
                    <th style="text-align: center">Nivel</th>
                    <th style="text-align: center">Tipo</th>
                    <th style="text-align: center">No. Reactivos Entregables</th>
                    <th style="text-align: center">Aplica Examen</th>
                    <th style="text-align: center">No. Reactivos en Examen</th>
                    <th style="text-align: center">Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @if($filters[0] > 0)
                @foreach($mattersCareers as $matterCareer)
                    <?php
                    $urls = array(
                            'showurl' => route('general.matterscareers.show', $matterCareer->id),
                            'editurl' => route('general.matterscareers.edit', $matterCareer->id),
                            'destroyurl' => route('general.matterscareers.destroy', $matterCareer->id)
                    );
                    ?>
                    <tr>
                        <td>{{ \ReactivosUPS\Matter::find($matterCareer->id_materia)->descripcion }}</td>
                        <td align="center">{{ $matterCareer->nivel }}</td>
                        <td align="center">{{ $matterCareer->tipo }}</td>
                        <td align="center">{{ $matterCareer->nro_reactivos_mat }}</td>
                        <td align="center">
                            @if($matterCareer->aplica_examen == 'S')
                                <a class="btn btn-xs btn-success" style="padding: 0px 3px 0px 3px">
                                    <i class="ace-icon fa fa-check bigger-110" style="margin: 0"></i>
                                </a>
                            @else
                                <a class="btn btn-xs btn-danger"  style="padding: 0px 4px 0px 4px">
                                    <i class="ace-icon fa fa-times  bigger-110" style="margin: 0"></i>
                                </a>
                            @endif
                        </td>
                        <td align="center">{{ $matterCareer->nro_reactivos_exam }}</td>
                        <td align="center">{{ $matterCareer->estado == 'A' ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            @include('shared.templates._tablebuttons', $urls)
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>



@endsection
