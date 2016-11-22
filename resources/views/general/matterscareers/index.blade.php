@extends('shared.template.index')

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
                            {!! Form::select('id_area', $areas, $filters[3], ['class' => 'form-control', 'placeholder' => 'Todas las Areas']) !!}
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
                    <th>Materia</th>
                    <th>Nivel</th>
                    <th>Tipo</th>
                    <th>No. Reactivos Entregables</th>
                    <th>Aplica Examen</th>
                    <th>No. Reactivos en Examen</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($mattersCareers as $matterCareer)
                    <tr>
                        <td>{{ \ReactivosUPS\Matter::find($matterCareer->id_materia)->descripcion }}</td>
                        <td>{{ $matterCareer->nivel }}</td>
                        <td>{{ $matterCareer->tipo }}</td>
                        <td>{{ $matterCareer->nro_reactivos_mat }}</td>
                        <td>
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
                        <td>{{ $matterCareer->nro_reactivos_exam }}</td>
                        <td>{{ $matterCareer->estado == 'A' ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a class="blue" href="{{ route('general.matterscareers.show', $matterCareer->id) }}">
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                </a>
                                <a class="green" href="{{ route('general.matterscareers.edit', $matterCareer->id)  }}">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                <a class="red" href="{{ route('general.matterscareers.destroy', $matterCareer->id) }}">
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </a>
                            </div>
                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                        <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                        <li>
                                            <a href="{{ route('general.matterscareers.show', $matterCareer->id) }}" class="tooltip-info" data-rel="tooltip" title="View">
                                                <span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('general.matterscareers.edit', $matterCareer->id) }}" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                <span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('general.matterscareers.destroy', $matterCareer->id) }}" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                <span class="red"><i class="ace-icon fa fa-trash-o bigger-120"></i></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



@endsection
