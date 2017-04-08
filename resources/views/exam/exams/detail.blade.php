@extends('shared.templates.index')

@section('titulo', 'Examen')
@section('subtitulo', 'Generaci&oacute;n de Examen')

@section('contenido')

    {!! Form::open(['id' => 'formulario',
            'class' => 'form-horizontal',
            'role' => 'form',
            'route' => ['exam.exams.update', $exam->id],
            'method' => 'PUT']) !!}

    <?php
    if(sizeof($matterParameters) == 1)
    {
        $btnsave = 1;
        $btnlist = route('exam.exams.detail', ['id_exam' => $exam->id, 'id_matter' => 0] );
    }
    $btnrefresh = route('exam.exams.detail', ['id_exam' => $exam->id, 'id_matter' => ((sizeof($matterParameters) == 1) ? (int)$matterParameters->id_materia : 0)] );
    $btnclose = route('exam.exams.index');
    ?>

    <div class="pull-left" style="margin-right: 20px;">
        @include('shared.templates._formbuttons')
    </div>

    <div class="page-header">
        <h1>
            @if(sizeof($matterParameters) == 1)
                {{ $matterParameters->matter->descripcion.' ('.$matterParameters->cantidad_reactivos.'/'.$matterParameters->nro_reactivos_exam.')' }}
            @else
                Materia
            @endif
        </h1>
    </div>

    @if(sizeof($matterParameters) > 1)
        <div style="columns: 3;">
            @include('exam.exams._matters')
        </div>
    @elseif(sizeof($matterParameters) == 1)
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

        {!! Form::hidden('id_materia', ((sizeof($matterParameters) == 1) ? (int)$matterParameters->id_materia : 0)) !!}

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
                            <div class="pull-right">
                                <a href="#my-modal-{{ $reagent->id }}" class="blue" data-toggle="modal">
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row" style="min-height: 40px; margin-bottom: 10px;">
                            {{ $reagent->planteamiento }}
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
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="smaller lighter blue no-margin">Detalle de Reactivo</h3>
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
    <script type="text/javascript" src="{{ asset('scripts/exam/exams/common.js') }}"></script>
    <script type="text/javascript">
        jQuery(function($) {
            //$('.modal.aside').ace_aside();

            //$('#aside-inside-modal').addClass('aside').ace_aside({container: '#my-modal > .modal-dialog'});

            //$(document).one('ajaxloadstart.page', function(e) {
                //in ajax mode, remove before leaving page
            //    $('.modal.aside').remove();
            //    $(window).off('.aside')
            //});
        })
    </script>
@endpush