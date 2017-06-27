@extends('shared.templates.index')

@section('titulo', 'Administraci&oacute;n')
@section('subtitulo', 'Par&aacute;metros')

@section('contenido')

    {!! Form::open(['id'=>'formdata', 'class' => 'form-horizontal', 'role' => 'form','route' => 'exam.parameters.index','method' => 'GET']) !!}
    <?php
    $btnnew = route('exam.parameters.create');
    ?>
    @include('shared.templates._formbuttons')

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

    <div id="accordion" class="accordion-style1 panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                        &nbsp;Informaci&oacute;n General
                    </a>
                </h4>
            </div>

            <div class="panel-collapse collapse in" id="collapseOne">
                <div class="panel-body">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name">Campus</div>
                            <div class="profile-info-value"><span>{{ $parameter->careerCampus->campus->descripcion }}</span></div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">Carrera</div>
                            <div class="profile-info-value"><span>{{ $parameter->careerCampus->career->descripcion }}</span></div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">Duraci&oacute;n de Examen</div>
                            <div class="profile-info-value"><span>{{ $parameter->duracion_examen }}</span></div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">C&oacute;digo de Examen </div>
                            <div class="profile-info-value"><span>{{ $parameter->id_examen_test }}</span></div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">¿Editar Respuestas?</div>
                            <div class="profile-info-value"><span>{{ ($parameter->editar_respuestas == 'S' ? 'Si' : 'No') }}</span></div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">Estado</div>
                            <div class="profile-info-value"><span>{{ ($parameter->estado == 'A' ? 'Activo' : 'Inactivo') }}</span></div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">Creado por</div>
                            <div class="profile-info-value"><span>{{ $parameter->creado_por }}</span></div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">Fecha de Creaci&oacute;n</div>
                            <div class="profile-info-value"><span>{{ $parameter->fecha_creacion }}</span></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                        &nbsp;Historial
                    </a>
                </h4>
            </div>

            <div class="panel-collapse collapse" id="collapseTwo">
                <div class="panel-body">
                    <div class="form-group">
                        <table id="table-show" class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Campus</td>
                                    <td>Carrera</td>
                                    <td>Duraci&oacute;n de Examen</td>
                                    <td>C&oacute;digo de Examen</td>
                                    <td>¿Editar Respuestas?</td>
                                    <td>Creado por</td>
                                    <td>Fecha Creaci&oacute;n</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history->sortByDesc('id') as $param)
                                <tr>
                                    <td>{{ $param->careerCampus->campus->descripcion }}</td>
                                    <td>{{ $param->careerCampus->career->descripcion }}</td>
                                    <td align="center">{{ $param->duracion_examen }}</td>
                                    <td align="center">{{ $param->id_examen_test }}</td>
                                    <td align="center">{{ ($param->editar_respuestas == 'S') ? 'Si' : 'No' }}</td>
                                    <td>{{ $param->user->FullName }}</td>
                                    <td>{{ $param->fecha_creacion }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('specific-script')
@include('shared.optionlists.functions')
<script type="text/javascript">
    $( window ).load(function() {
        getCareersByCampus();
    });
</script>
@endpush