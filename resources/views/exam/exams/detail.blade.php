@extends('shared.templates.index')

@section('titulo', 'Examen')
@section('subtitulo', 'Generaci&oacute;n de Examen')

@section('contenido')

    <form class="form-horizontal" role="form">
        <?php
        $btnsave = 1;
        $btnrefresh = route('exam.exams.create');
        $btnclose = route('exam.exams.index');
        ?>
        @include('shared.templates._formbuttons')

        <div class="page-header">
            <h1>
                @if(isset($exam->matter))
                    {{ $exam->matter }}
                @else
                    Materia
                @endif
            </h1>
        </div>

        <div id="right-menu" class="modal aside" data-body-scroll="false" data-offset="true" data-placement="right" data-fixed="true" data-backdrop="false" tabindex="-1">
            <div class="modal-dialog" style="width: 300px">
                <div class="modal-content">
                    <div class="modal-header no-padding">
                        <div class="table-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <span class="white">&times;</span>
                            </button>
                            Materias
                        </div>
                    </div>

                    <div class="modal-body">
                        <ul class="nav nav-pills nav-stacked" style="padding: 0px; margin: 0px;">
                            @foreach($matters as $matter)
                                <li>
                                    <a href="{{ route('exam.exams.detail', ['id_exam' => $exam->id, 'id_matter' => $matter->id] ) }}" style="padding: 0px;">{{ $matter->descripcion }}</a>
                                    <hr style="margin: 5px 0 5px 0" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div><!-- /.modal-content -->

                <button class="aside-trigger btn btn-info btn-app btn-xs ace-settings-btn" data-target="#right-menu" data-toggle="modal" type="button">
                    <i data-icon1="fa-plus" data-icon2="fa-minus" class="ace-icon fa fa-plus bigger-110 icon-only"></i>
                </button>
            </div><!-- /.modal-dialog -->
        </div>

        <div>
            @foreach($reagents as $reagent)
                <?php
                $mattercareer = \ReactivosUPS\MatterCareer::find($reagent->distributive->id_materia_carrera)
                ?>
                <div class="well">
                    <div class="form-group">
                        <div class="col-sm-1">
                            <div class="checkbox">
                                <label class="block">
                                    {!! Form::checkbox('estado', 'A', false, ['class' => 'ace input-lg']) !!}
                                    <span class="lbl bigger-120"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="pull-left">
                                    <strong><span class="green smaller lighter">{{ $mattercareer->matter->descripcion }}</span></strong>
                                </div>
                                <div class="pull-right">
                                    Formato: <strong><span class="green smaller lighter">{{ $reagent->format->nombre }}</span></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="pull-left">
                                    Contenido: <strong><span class="green smaller lighter">{{ $reagent->contentDetail->capitulo . " " . $reagent->contentDetail->tema }}</span></strong>
                                </div>
                            </div>
                            <div class="row">
                                {{ $reagent->planteamiento }}
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="pull-right">
                                <a href="#my-modal-{{ $reagent->id }}" class="blue" data-toggle="modal">
                                    <i class="ace-icon fa fa-eye bigger-130"></i>
                                </a>
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
        </div>


    </form>

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