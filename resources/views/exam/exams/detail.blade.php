@extends('shared.templates.index')

@section('titulo', 'Examen Complexivo')

@if($selectedMatter->id_materia > 0)
    @section('titulo2')
        Detalle de Examen <i class="ace-icon fa fa-angle-double-right"></i>
    @endsection
    @section('subtitulo', $selectedMatter->matter->descripcion.' ('.$selectedMatter->cantidad_reactivos.'/'.$selectedMatter->nro_reactivos_exam.')')
@else
    @section('subtitulo', 'Detalle de Examen')
@endif

@push('specific-styles')
    {!! HTML::style('ace/css/colorbox.min.css') !!}
@endpush

@section('contenido')

    {!! Form::open(['id' => 'formulario',
            'class' => 'form-horizontal',
            'role' => 'form',
            'route' => ['exam.exams.updateDetail', $exam->id],
            'method' => 'PUT']) !!}

    <?php
    if($selectedMatter->id_materia > 0)
    {
        $btnsave = 1;
        $btnlist = route('exam.exams.detail', ['id_exam' => $exam->id, 'id_matter' => 0] );
    }
    $btnrefresh = route('exam.exams.detail', ['id_exam' => $exam->id, 'id_matter' => (($selectedMatter->id_materia > 0) ? (int)$selectedMatter->id_materia : 0)] );
    $btnclose = route('exam.exams.edit', $exam->id);
    ?>
    @include('shared.templates._formbuttons')

    @if($selectedMatter->id_materia == 0)
        <?php $col = 3 ?>
        <div style="margin-top: -25px">
        @include('exam.exams._matters')
        </div>
    @else
        <?php $col = 1 ?>
        <div id="right-menu" class="modal aside" data-body-scroll="false" data-offset="true" data-placement="right" data-fixed="true" data-backdrop="false" tabindex="-1">
            <div class="modal-dialog" style="width: 300px">
                <div class="modal-content">
                    <div class="modal-header no-padding">
                        <div class="table-header">
                            <a href="{{ route('exam.exams.detail', ['id_exam' => $exam->id, 'id_matter' => 0] ) }}" style="color: #FFF;">
                                <i class="fa fa-list" aria-hidden="true"></i>
                                Materias
                            </a>
                        </div>
                    </div>

                    <div class="modal-body">
                        @include('exam.exams._matters')
                    </div>
                </div><!-- /.modal-content -->

                <button class="aside-trigger btn btn-info btn-app btn-xs ace-settings-btn" data-target="#right-menu" data-toggle="modal" type="button">
                    <i data-icon1="fa-plus" data-icon2="fa-minus" class="ace-icon fa fa-plus bigger-110 icon-only"></i>
                </button>
            </div><!-- /.modal-dialog -->
        </div>

        {!! Form::hidden('id_materia', $selectedMatter->id_materia) !!}

        @foreach($reagents as $reagent)
            <div class="well" style="padding-bottom: 0;">
                <div class="form-group" style="margin-right: 15px;">
                    <div class="col-sm-1 col-xs-2">
                        <div class="checkbox" style="padding: 0;">
                            <label class="block">
                                <?php $isChedked = 0; ?>
                                @foreach($exam->examsDetails as $det)
                                    @if($reagent->id == $det->id_reactivo && $det->estado == 'A')
                                        <?php $isChedked = 1; ?>
                                        {!! Form::checkbox('id_reactivo[]', $reagent->id, true, ['class' => 'ace input-lg']) !!}
                                    @endif
                                @endforeach
                                @if($isChedked == 0)
                                    {!! Form::checkbox('id_reactivo[]', $reagent->id, false, ['class' => 'ace input-lg']) !!}
                                @endif
                                <span class="lbl bigger-120"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-11 col-xs-10">
                        <div class="row">
                            <div class="pull-left">
                                <h5><strong><span class="blue smaller lighter">Cap&iacute;tulo {{ $reagent->contentDetail->capitulo . ": " . $reagent->contentDetail->tema }}</span></strong></h5>
                            </div>

                            @if(in_array('S', $reagent->examsDetails->pluck('examHeader')->where('id_estado', 4)->pluck('es_prueba')->toArray()))
                                <div class="pull-left">
                                    &nbsp;&nbsp;
                                    <span class="label label-warning label-white label-sm">
                                        En Examen de Prueba
                                    </span>
                                </div>
                            @endif

                            @if(in_array($idExamSimulador, $reagent->examsDetails->pluck('examHeader')->where('id_estado', 4)->pluck('id')->toArray()))
                                <div class="pull-left">
                                    &nbsp;&nbsp;
                                    <span class="label label-danger label-white label-sm">
                                        Activo en Simulador
                                    </span>
                                </div>
                            @endif

                            <div class="pull-right">
                                <a href="#my-modal-{{ $reagent->id }}" class="blue" data-toggle="modal">
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row" align="justify" style="min-height: 40px; margin-bottom: 10px;">
                            {!! nl2br(e($reagent->planteamiento)) !!}
                        </div>
                        <div class="row">
                            <div class="pull-left">
                                <strong>Creado por: <span class="grey smaller lighter">{{ $reagent->user->FullName }}</span></strong>
                            </div>
                            <div class="pull-right">
                                <strong>
                                    Dificultad:
                                    <span class="grey smaller lighter">
                                        {{ ( ( $reagent->dificultad == 'B' ) ? 'Baja' : ( ( $reagent->dificultad == 'M' ) ? 'Media' : 'Alta' ) ) }}
                                    </span>
                                </strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="pull-left">
                                <strong>Periodo: <span class="grey smaller lighter">{{ $reagent->period->descripcion }}</span></strong>
                            </div>
                            <div class="pull-right">
                                <strong>Formato: <span class="grey smaller lighter">{{ $reagent->format->nombre }}</span></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="my-modal-{{ $reagent->id }}" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="smaller lighter blue no-margin">
                                Cap&iacute;tulo {{ $reagent->contentDetail->capitulo . ": " . $reagent->contentDetail->tema }}
                                @if(\Session::get('DesbloqueaReactivo') == 'S')
                                    <small>
                                        <a class="green" href="{{ route('reagent.approvals.show', $reagent->id) }}">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                    </small>
                                @endif
                                <br/><small>{{ $selectedMatter->matter->descripcion }}</small>
                            </h3>
                        </div>
                        <div class="modal-body">
                            @include('exam.exams._reagent')
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        @endforeach
    @endif
    {!! Form::close() !!}

@endsection

@push('specific-script')
    {!! HTML::script('ace/js/jquery.colorbox.min.js') !!}
    {!! HTML::script('scripts/exam/exams/common.js') !!}
    <script type="text/javascript">
        $(window).load(function() {
            imagePropertiesLoad();
        });
    </script>
@endpush