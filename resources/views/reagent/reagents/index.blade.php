@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Listado de reactivos')

@section('contenido')
    <?php
    $usetable = 1;
    $isReagent = 1;
    $indexPrint = 1;
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
            </div>
        </div>

        <div class="widget-body" style="display: block;">
            <div class="widget-main">
                <div class="row" style="position: relative;">
                    <div class="col-sm-11">
                        <div class="col-sm-3">
                            {!! Form::label('id_campus', 'Seleccione Campus:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) !!}
                            <div id="listaCampus">
                                @include('shared.optionlists._campuslist')
                            </div>
                        </div>

                        <div class="col-sm-3">
                            {!! Form::label('id_carrera', 'Seleccione Carrera:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) !!}
                            <div id="listaCarreras">
                                @include('shared.optionlists._careerslist')
                            </div>
                        </div>

                        <div class="col-sm-3">
                            {!! Form::label('id_materia', 'Materia:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) !!}
                            <div id="listaMaterias">
                                @include('shared.optionlists._matterslist')
                            </div>
                        </div>

                        <div class="col-sm-3">
                            {!! Form::label('id_estado', 'Seleccione Estado:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) !!}
                            {!! Form::select('id_estado', $states, $filters[3], ['class' => 'form-control', 'placeholder' => 'Todos los Estados']) !!}
                        </div>
                    </div>
                    <div class="col-sm-1" style="float:right; position:absolute; bottom:0; right:0;">
                        <button onclick="document.forms[0].submit();" title="Filtrar" class="btn btn-white btn-primary btn-bold" style="float:right;">
                            <i class='ace-icon fa fa-filter bigger-110 blue' style="margin: 0"></i>
                        </button>
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
                <th></th>
                <th style="text-align: center">C&oacute;digo</th>
                <th style="text-align: center">Planteamiento</th>
                <th style="text-align: center">Estado</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if($reagents->count() > 0)
                @foreach($reagents as $reagent)
                    <?php
                    //$showurl = route('reagent.reagents.show', $reagent->id);
                    //$editurl = route('reagent.reagents.edit', $reagent->id);
                    //$destroyurl = route('reagent.reagents.destroy', $reagent->id);
                    if( in_array($reagent->id_estado, array(1, 4)) )
                        $urls = array(
                            'showurl' => route('reagent.reagents.show', $reagent->id),
                            'editurl' => route('reagent.reagents.edit', $reagent->id),
                            'destroyurl' => route('reagent.reagents.destroy', $reagent->id)
                        );
                    else
                        $urls = array(
                            'showurl' => route('reagent.reagents.show', $reagent->id)
                        );

                    ?>
                    <tr>
                        <td align="center" width="40px">
                            <div class="checkbox" style="margin-top: 0; margin-bottom: 0;">
                                <label>
                                    {!! Form::checkbox('id', $reagent->id, false, ['class' => 'ace']) !!}
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </td>
                        <td align="center">{{ $reagent->id }}</td>
                        <td align="justify">{{ $reagent->planteamiento }}</td>
                        <td align="center"><span class="label label-{{ $reagent->state->etiqueta }}">{{ $reagent->state->descripcion }}</span></td>
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

@push('specific-script')
    @include('shared.optionlists.functions')
    <script type="text/javascript">
        $( window ).load(function() {
            getCareersByCampus();
            getMattersByCareer();
        });
    </script>
@endpush