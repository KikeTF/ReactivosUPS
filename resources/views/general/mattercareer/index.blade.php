@extends('shared.template.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Listado de Materias')

@section('contenido')
    <?php
    //$usetable = 1;
    //$columnas = array("nombre", "descripcion", "estado");
    ?>
    {{--<input hidden type="text" id="dataurl" value="{{ route('reagent.fields.data') }}">--}}
    {{--<input hidden type="text" id="newurl" value="{{ route('reagent.fields.create') }}">--}}

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
                    <div class="col-sm-3">
                        <select id="id_campus" class="form-control">
                            <option value="0">-- Selecione Campus --</option>
                            @foreach($campus as $camp)
                                <option value="{{ $camp->id }}">{{ $camp->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <select id="id_carrera" class="form-control">
                            <option value="0">-- Selecione Carrera --</option>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <select id="id_mencion" class="form-control">
                            <option value="0">-- Selecione Mencion --</option>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <select id="id_area" class="form-control">
                            <option value="0">-- Todas las Areas --</option>
                        </select>
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
@endsection
