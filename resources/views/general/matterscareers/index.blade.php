@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Listado de Materias')

@section('contenido')
    <?php
    $usetable = 0;
    $columnas = array("id_materia", "nivel", "tipo", "nro_reactivos_mat", "aplica_examen", "nro_reactivos_exam", "estado");
    ?>

    {!! Form::open(['class' => 'form-horizontal', 'role' => 'form','route' => 'general.matterscareers.filter','method' => 'POST']) !!}

    <input hidden type="text" id="dataurl" value="{{ route('general.matterscareers.data') }}">
    <input hidden type="text" id="newurl" value="{{ route('general.matterscareers.create') }}">

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
                            <label for="id_campus" style="font-size: 12px">Seleccione Campus</label>
                            <select id="id_campus" name="id_campus" class="form-control">
                                @foreach($campuses as $camp)
                                    <option value="{{ $camp->id }}" {{ $camp->id == $filters[0] ? 'selected="selected"' : '' }}>{{ $camp->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <label for="id_carrera" style="font-size: 12px">Seleccione Carrera</label>
                            <select id="id_carrera" name="id_carrera" class="form-control">
                                @foreach($careers as $career)
                                    <option value="{{ $career->id }}" {{ $career->id == $filters[1] ? 'selected="selected"' : '' }}>{{ $career->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <label for="id_mencion" style="font-size: 12px">Seleccione Menci&oacute;n</label>
                            <select id="id_mencion" name="id_mencion" class="form-control">
                                @foreach($mentions as $mention)
                                    <option value="{{ $mention->id }}" {{ $mention->id == $filters[2] ? 'selected="selected"' : '' }}>{{ $mention->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <label for="id_mencion" style="font-size: 12px">Seleccione Area</label>
                            <select id="id_area" name="id_area" class="form-control">
                                <option value="0">-- Todas las Areas --</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ $area->id == $filters[3] ? 'selected="selected"' : '' }}>{{ $area->descripcion }}</option>
                                @endforeach
                            </select>
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

    <div class="table-responsive" style="padding: 1px 1px 1px 1px;">
        <table id="_dataTable" class="table table-striped table-bordered table-hover responsive no-wrap" width="100%">
            <thead>
            <tr>
                <th>Materia</th>
                <th>Nivel</th>
                <th>Tipo</th>
                <th>Reactivos x Materia</th>
                <th>Aplica Examen</th>
                <th>Reactivos x Examen</th>
                <th>Estado</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>

    {!! Form::close() !!}

@endsection
