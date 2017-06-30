@extends('shared.templates.index')

@section('titulo', 'Examen Complexivo')
@section('subtitulo', 'Examen')

@push('specific-styles')
    {!! HTML::style('ace/css/colorbox.min.css') !!}
@endpush

@section('contenido')

    <form class="form-horizontal" role="form">

        <?php
        if($exam->id_estado == 2)
        {
            $btnaprove = 1;
            $btnreject = 1;
            $btncomment = 1;
        }
        elseif (in_array($exam->id_estado, array(1, 3)) )
        {
            $btnreply = 1;
            $btnedit = route('exam.exams.edit', $exam->id);
            $btndelete2 = 1;
        }
        elseif ($exam->id_estado == 4 && $exam->es_prueba == 'S')
        {
            if ($parameter->id_examen_test == $exam->id)
                $btnexamactive = 1;
            else
                $btnexamactivate = route('exam.exams.activate', $exam->id);
        }

        $btnhistory = route('exam.exams.history', $exam->id);

        if($mentionsList->count() > 1)
            $btnprint2 =  1;
        else
            $btnprint =  route("exam.exams.report", $exam->id);

        $btnclose = route('exam.exams.index');
        foreach($mentionsList as $indexKey => $mention)
        {
            $firstMentionKey = $indexKey;
            break;
        }
        ?>
        @include('shared.templates._formbuttons')

        <div id="accordion-info" class="accordion-style1 panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-info" href="#collapse0">
                            <i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                            &nbsp;Informaci&oacute;n General
                        </a>
                    </h4>
                </div>

                <div class="panel-collapse collapse in" id="collapse0">
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
                                <div class="profile-info-name">Descripci&oacute;n</div>
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
        </div>

        <div id="accordion" class="accordion-style1 panel-group">
            <div class="tabbable">
                @if($mentionsList->count() > 1)
                    <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab">
                    @foreach($mentionsList as $indexKey => $mention)
                        <li class="{{ ($firstMentionKey == $indexKey) ? 'active' : '' }}">
                            <a data-toggle="tab" href="#{{ 'reactivos-'.$indexKey }}">
                                {{ ($mentionsList->count() > 1) ? $mention : 'Reactivos' }}
                            </a>
                        </li>
                    @endforeach
                    </ul>
                @endif

                <div class="tab-content">
                    @foreach($mentionsList as $indexKey => $mention)
                        <?php
                        $mattersIds = $exam->examsDetails->pluck('reagent')->pluck('id_materia');
                        foreach($mattersIds as $id)
                            $ids[] = $id;
                        $mattersCareers = \ReactivosUPS\MatterCareer::query()
                                ->whereIn('id_materia', array_unique($ids))
                                ->where('id_mencion', $indexKey)
                                ->get();
                        ?>
                        <div id="{{ 'reactivos-'.$indexKey }}" class="tab-pane{{ ($firstMentionKey == $indexKey) ? ' in active' : '' }}">
                            @foreach($mattersCareers as $matCar)
                                <?php $matter = $matCar->matter; ?>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $matter->id }}">
                                                <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                                &nbsp;Reactivos: {{ $matter->descripcion }}
                                            </a>
                                        </h4>
                                    </div>

                                    <div class="panel-collapse collapse" id="collapse{{ $matter->id }}">
                                        <div class="panel-body">
                                            @foreach($exam->examsDetails as $detail)
                                                @if($detail->reagent->id_materia == $matter->id)
                                                    <div class="well" style="padding-bottom: 0;">
                                                        <div class="form-group" style="margin-right: 15px;">
                                                            <div class="col-sm-12">
                                                                <div class="row">
                                                                    <div class="pull-left">
                                                                        <h5><strong><span class="blue smaller lighter">Cap&iacute;tulo {{ $detail->reagent->contentDetail->capitulo . ": " . $detail->reagent->contentDetail->tema }}</span></strong></h5>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <a href="#my-modal-{{ $detail->id }}" class="blue" data-toggle="modal">
                                                                            <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="min-height: 40px; margin-bottom: 10px; text-align: justify;">
                                                                    {{ $detail->reagent->planteamiento }}
                                                                </div>
                                                                <div class="row">
                                                                    <div class="pull-left">
                                                                        <strong>Creado por: <span class="grey smaller lighter">{{ $detail->reagent->user->FullName }}</span></strong>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <strong>
                                                                            Dificultad:
                                                            <span class="grey smaller lighter">
                                                                {{ ( ( $detail->reagent->dificultad == 'B' ) ? 'Baja' : ( ( $detail->reagent->dificultad == 'M' ) ? 'Media' : 'Alta' ) ) }}
                                                            </span>
                                                                        </strong>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="pull-left">
                                                                        <strong>Periodo: <span class="grey smaller lighter">{{ $detail->reagent->period->descripcion }}</span></strong>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <strong>Formato: <span class="grey smaller lighter">{{ $detail->reagent->format->nombre }}</span></strong>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="my-modal-{{ $detail->id }}" class="modal fade" tabindex="-1">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h3 class="smaller lighter blue no-margin">
                                                                        Cap&iacute;tulo {{ $detail->reagent->contentDetail->capitulo . ": " . $detail->reagent->contentDetail->tema }}
                                                                        <br/><small>{{ $detail->reagent->distributive->matterCareer->matter->descripcion }}</small>
                                                                    </h3>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @include('exam.exams._reagent', ['reagent' => $detail->reagent])
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </form>

@endsection

@push('specific-script')
    {!! HTML::script('ace/js/jquery.colorbox.min.js') !!}
    {!! HTML::script('scripts/exam/exams/common.js') !!}
    <script type="text/javascript">
        $("#btn-aprobado").on('click', function() {
            bootbox.prompt({
                title: "Ingrese No. Resoluci&oacute;n...",
                inputType: 'text',
                buttons: {
                    'confirm': {
                        label: 'Aprobar',
                        className: 'btn-info'
                    },
                    'cancel': {
                        label: 'Cancelar',
                        className: 'btn-default'
                    }
                },
                callback: function (result) {
                    if (result === null) {
                        console.log("Ok");
                    } else {
                        $.ajax({
                            type: 'GET',
                            url: "{{ Route("exam.exams.comment", $exam->id) }}",
                            data: {'comentario':result, 'id_estado':4},
                            dataType: "json",
                            async: true,
                            cache: false,
                            error: function (e) {
                                console.log(e);
                            },
                            success: function (result) {
                                if (result.valid) {
                                    window.location.replace("{{ Route("exam.exams.index") }}");
                                }
                                else {
                                    alert('Error');
                                }
                            }
                        });
                    }
                }
            });
        });

        $("#btn-rechazado").on('click', function() {
            bootbox.prompt({
                title: "Ingrese sus comentarios...",
                inputType: 'textarea',
                buttons: {
                    'confirm': {
                        label: 'Rechazar',
                        className: 'btn-danger'
                    },
                    'cancel': {
                        label: 'Cancelar',
                        className: 'btn-default'
                    }
                },
                callback: function (result) {
                    if (result === null) {
                        console.log("Ok");
                    } else {
                        $.ajax({
                            type: 'GET',
                            url: "{{ Route("exam.exams.comment", $exam->id) }}",
                            data: {'comentario':result, 'id_estado':5},
                            dataType: "json",
                            async: true,
                            cache: false,
                            error: function (e) {
                                console.log(e);
                            },
                            success: function (result) {
                                if (result.valid) {
                                    window.location.replace("{{ Route("exam.exams.index") }}");
                                }
                                else {
                                    alert('Error');
                                }
                            }
                        });
                    }
                }
            });
        });

        $("#btn-comentario").on('click', function() {
            bootbox.prompt({
                title: "Ingrese sus comentarios...",
                inputType: 'textarea',
                buttons: {
                    'confirm': {
                        label: 'Enviar',
                        className: 'btn-info'
                    },
                    'cancel': {
                        label: 'Cancelar',
                        className: 'btn-default'
                    }
                },
                callback: function (result) {
                    if (result === null) {
                        console.log("Ok");
                    } else {
                        $.ajax({
                            type: 'GET',
                            url: "{{ Route("exam.exams.comment", $exam->id) }}",
                            data: {'comentario':result, 'id_estado':3},
                            dataType: "json",
                            async: true,
                            cache: false,
                            error: function (e) {
                                console.log(e);
                            },
                            success: function (result) {
                                if (result.valid) {
                                    window.location.replace("{{ Route("exam.exams.index") }}");
                                }
                                else {
                                    window.location.replace("{{ Route("exam.exams.show", $exam->id) }}");

                                }
                            }
                        });
                    }
                }
            });
        });

        $("#btn-reenviar").on('click', function() {
            bootbox.prompt({
                title: "Ingrese sus comentarios...",
                inputType: 'textarea',
                buttons: {
                    'confirm': {
                        label: 'Enviar',
                        className: 'btn-info'
                    },
                    'cancel': {
                        label: 'Cancelar',
                        className: 'btn-default'
                    }
                },
                callback: function (result) {
                    if (result === null) {
                        console.log("Ok");
                    } else {
                        $.ajax({
                            type: 'GET',
                            url: "{{ Route("exam.exams.comment", $exam->id) }}",
                            data: {'comentario':result, 'id_estado':2},
                            dataType: "json",
                            async: true,
                            cache: false,
                            error: function (e) {
                                console.log(e);
                            },
                            success: function (result) {
                                if (result.valid) {
                                    window.location.replace("{{ Route("exam.exams.index") }}");
                                }
                                else {
                                    alert('Error');
                                }
                            }
                        });
                    }
                }
            });
        });

        $("#btn-eliminar").on('click', function() {
            bootbox.prompt({
                title: "Ingrese sus comentarios...",
                inputType: 'textarea',
                buttons: {
                    'confirm': {
                        label: 'Eliminar',
                        className: 'btn-danger'
                    },
                    'cancel': {
                        label: 'Cancelar',
                        className: 'btn-default'
                    }
                },
                callback: function (result) {
                    if (result === null) {
                        console.log("Ok");
                    } else {
                        $.ajax({
                            type: 'GET',
                            url: "{{ Route("exam.exams.comment", $exam->id) }}",
                            data: {'comentario':result, 'id_estado':6},
                            dataType: "json",
                            async: true,
                            cache: false,
                            error: function (e) {
                                console.log(e);
                            },
                            success: function (result) {
                                if (result.valid) {
                                    window.location.replace("{{ Route("exam.exams.index") }}");
                                }
                                else {
                                    alert('Error');
                                }
                            }
                        });
                    }
                }
            });
        });

        function printReport()
        {
            var element = '<select id="reportMencionID" class="form-control">';
            @foreach($mentionsList as $indexKey => $mention)
                @if($indexKey > 1)
                    element += '<option value="{{ $indexKey }}">{{ $mention }}</option>';
                @endif
            @endforeach
            element += '</select>';

            var dialog = bootbox.dialog({
                title: "Seleccione una Menci&oacute;n:",
                message: element,
                buttons: {
                    'confirm': {
                        label: 'Imprimir',
                        className: 'btn-info',
                        callback: function (result) {
                            var data = 'mencion='+$('#reportMencionID').val();
                            window.open('{{ route("exam.exams.report", $exam->id) }}?'+data,'_blank');
                        }
                    },
                    'cancel': {
                        label: 'Cancelar',
                        className: 'btn-default'
                    }
                }
            });
            //alert(data);
            //


        }

        $(window).load(function() {
            imagePropertiesLoad();
        });
    </script>
@endpush