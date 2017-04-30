@extends('shared.templates.index')

@section('titulo', 'Reactivos')
@section('subtitulo', 'Examen')

@section('contenido')

    <form class="form-horizontal" role="form">

        <?php
        //if( in_array($reagent->id_estado, array(1, 4)) )
            $btnedit = route('exam.exams.edit', $exam->id);
        $btnhistory = route('exam.exams.history', $exam->id);
        $btnprint =  route('exam.exams.report', $exam->id);
        $btnclose = route('exam.exams.index');
        ?>
        @include('shared.templates._formbuttons')

        <div id="accordion" class="accordion-style1 panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse0">
                            <i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                            &nbsp;Informaci&oacute;n General
                        </a>
                    </h4>
                </div>

                <div class="panel-collapse collapse in" id="collapse0">
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

                @if($mentionsList->count() > 1 and $mattersCareers->count() > 0)
                    <h3 class="header smaller lighter blue">Mencion: {{ $mention }}</h3>
                @endif

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
                                            <div class="row" style="min-height: 40px; margin-bottom: 10px;">
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
                                <div class="modal-dialog">
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

            @endforeach
        </div>

    </form>

@endsection

@push('specific-script')
    <script type="text/javascript" src="{{ asset('scripts/exam/exams/common.js') }}"></script>
@endpush