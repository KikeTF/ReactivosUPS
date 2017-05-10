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
                        <div class="form-group">
                            <div class="col-sm-2"><strong>C&oacute;digo:</strong></div>
                            <div class="col-sm-8">{{ $exam->id }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Campus:</strong></div>
                            <div class="col-sm-8">{{ $exam->careerCampus->campus->descripcion }}</div>
                        </div>

                        <?php
                        $periodos = '';
                        foreach ($exam->examPeriods as $period)
                        {
                            $periodos = $periodos.'('.$period->periodLocation->period->cod_periodo.') '.$period->periodLocation->period->descripcion.'; ';
                        }
                        ?>
                        <div class="form-group">
                            <div class="col-sm-2"><strong>Descripcion:</strong></div>
                            <div class="col-sm-8">{{ $exam->descripcion }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Periodos Reactivos:</strong></div>
                            <div class="col-sm-8">{{ $periodos }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Fecha Activacion:</strong></div>
                            <div class="col-sm-8">{{ $exam->fecha_activacion }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>¿Es de prueba?</strong></div>
                            <div class="col-sm-8">{{ ($exam->es_prueba == 'S' ? 'Si' : 'No') }}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"><strong>Estado:</strong></div>
                            <div class="col-sm-8">{{ $exam->state->descripcion }}</div>
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
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <td><strong>Fecha</strong></td>
                                    <td><strong>Creado por</strong></td>
                                    <td><strong>Comentario</strong></td>
                                    <td><strong>Estado Nuevo</strong></td>
                                    <td><strong>Estado Anterior</strong></td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($exam->comments->sortByDesc('id') as $comment)
                                    <tr>
                                        <td>{{ $comment->fecha_creacion }}</td>
                                        <td>{{ $comment->user->FullName }}</td>
                                        <td>{{ $comment->comentario }}</td>
                                        <td>{{ $states[$comment->id_estado_nuevo] }}</td>
                                        <td>{{ $states[$comment->id_estado_anterior] }}</td>
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