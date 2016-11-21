@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Listado de reactivos')

@section('contenido')
    <?php
    $usetable = 1;
    $newurl = route('reagent.reagents.create');
    $columnas = array("id",  "planteamiento", "estado"); // "capitulo", "tema",
    ?>

    {!! Form::open(['id'=>'formdata', 'class' => 'form-horizontal', 'role' => 'form','route' => 'reagent.reagents.index','method' => 'GET']) !!}

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
                <div class="row">
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
                            {!! Form::label('id_materia', 'Seleccione Materia:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) !!}
                            {!! Form::select('id_materia', $matters, $filters[3], ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-sm-1" align="right">
                        <div class="btn btn-white btn-primary btn-bold">
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
                <th>C&oacute;digo</th>
                {{--<th>Cap&iacute;tulo</th>
                <th>Tema</th>--}}
                <th>Planteamiento</th>
                <th>Estado</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach($reagents as $reagent)
                    <tr>
                        <td>{{ $reagent->id }}</td>
                        <td>{{ $reagent->planteamiento }}</td>
                        <td>{{ $reagent->estado == 'A' ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a class="blue" href="{{ route('reagent.reagents.show', $reagent->id) }}">
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                </a>
                                <a class="green" href="{{ route('reagent.reagents.edit', $reagent->id) }}">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                <a class="red" href="{{ route('reagent.reagents.destroy', $reagent->id) }}">
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
                                            <a href="{{ route('reagent.reagents.show', $reagent->id) }}" class="tooltip-info" data-rel="tooltip" title="View">
                                                <span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('reagent.reagents.edit', $reagent->id) }}" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                <span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('reagent.reagents.destroy', $reagent->id) }}" class="tooltip-error" data-rel="tooltip" title="Delete">
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