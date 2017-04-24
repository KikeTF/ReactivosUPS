@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Aprobaci&oacute;n de reactivos')

@section('contenido')
    <?php
    $usetable = 1;
    $isApproval = 1;
    //$newurl = route('reagent.approvals.create');
    $columnas = array("id",  "planteamiento", "estado","creado_por", "modificado_por"); // "capitulo", "tema",
    ?>

    {!! Form::open(['id'=>'formdata', 'class' => 'form-horizontal', 'role' => 'form','route' => 'reagent.approvals.index','method' => 'GET']) !!}

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
                @if(isset($isApproval))
                <th></th>
                @endif
                <th style="text-align: center">C&oacute;digo</th>
                <th style="text-align: center">Planteamiento</th>
                <th style="text-align: center">Estado</th>
                <th style="text-align: center">Creado Por</th>
                <th style="text-align: center">Revisado Por</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(isset($reagents) and $reagents->count() > 0)
                @foreach($reagents as $reagent)
                    <?php $urls = array('showurl' => route('reagent.approvals.show', $reagent->id)); ?>
                    <tr>
                        @if(isset($isApproval))
                        <td align="center" width="40px">
                            <div class="checkbox" style="margin-top: 0; margin-bottom: 0;">
                                <label>
                                    {!! Form::checkbox('id', $reagent->id, false, ['class' => 'ace']) !!}
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </td>
                        @endif
                        <td align="center">{{ $reagent->id }}</td>
                        <td>{{ $reagent->planteamiento }}</td>
                        <td align="center"><span class="label label-{{ $statesLabels[$reagent->id_estado] }}">{{ $states[$reagent->id_estado] }}</span></td>
                        <td align="center">{{ \ReactivosUPS\User::find($reagent->creado_por)->FullName }}</td>
                        <td align="center">{{ ( ($reagent->modificado_por == "") ? "": \ReactivosUPS\User::find($reagent->modificado_por)->FullName ) }}</td>
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