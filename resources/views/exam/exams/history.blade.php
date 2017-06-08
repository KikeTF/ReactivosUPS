@extends('shared.templates.index')

@section('titulo', 'Examen Complexivo')
@section('subtitulo', 'Historial de Examen')

@section('contenido')

    <form class="form-horizontal" role="form">

        <?php
        if (in_array($exam->id_estado, array(1, 3)) )
            $btnedit = route('exam.exams.edit', $exam->id);

        $btnclose = route('exam.exams.show', $exam->id);
        ?>
        @include('shared.templates._formbuttons')

        <div id="accordion" class="accordion-style1 panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse0">
                            <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                            &nbsp;Informaci&oacute;n General
                        </a>
                    </h4>
                </div>

                <div class="panel-collapse collapse" id="collapse0">
                    <div class="panel-body">
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name">C&oacute;digo</div>
                                <div class="profile-info-value"><span>{{ $exam->id }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Campus</div>
                                <div class="profile-info-value"><span>{{ $exam->careerCampus->campus->descripcion }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Periodo</div>
                                <div class="profile-info-value"><span>{{ '('.$exam->periodLocation->period->cod_periodo.') '.$exam->periodLocation->period->descripcion }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Fecha Activaci&oacute;n</div>
                                <div class="profile-info-value"><span>{{ $exam->fecha_activacion }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Periodos Reactivos</div>
                                <div class="profile-info-value">
                                    <span>
                                        @foreach($exam->examPeriods as $period)
                                            {{ '('.$period->periodLocation->period->cod_periodo.') '.$period->periodLocation->period->descripcion }}<br/>
                                        @endforeach
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Descripcio&oacute;n</div>
                                <div class="profile-info-value"><span>{{ $exam->descripcion }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">¿Es de prueba?</div>
                                <div class="profile-info-value"><span>{{ ($exam->es_prueba == 'S' ? 'Si' : 'No') }}</span></div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">Estado</div>
                                <div class="profile-info-value"><span>{{ $exam->state->descripcion }}</span></div>
                            </div>

                            @if(trim($exam->resolucion) != "")
                                <div class="profile-info-row">
                                    <div class="profile-info-name">Resoluci&oacute;n</div>
                                    <div class="profile-info-value"><span>{{ $exam->resolucion }}</span></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            <i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                            &nbsp;Historial
                        </a>
                    </h4>
                </div>

                <div class="panel-collapse collapse in" id="collapseTwo">
                    <div class="panel-body">
                        <div class="form-group">
                            <table id="table-show" class="table table-hover">
                                <thead>
                                <tr>
                                    <td>Fecha</td>
                                    <td>Creado por</td>
                                    <td>Comentario</td>
                                    <td>Estado</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($exam->comments->sortByDesc('id') as $comment)
                                    <tr>
                                        <td>{{ $comment->fecha_creacion }}</td>
                                        <td>{{ $comment->user->FullName }}</td>
                                        <td>{{ $comment->comentario }}</td>
                                        <td>{{ $states[$comment->id_estado_nuevo] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection