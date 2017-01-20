@extends('shared.templates.index')

@section('titulo', 'Examen')
@section('subtitulo', 'Generaci&oacute;n de Examen')

@section('contenido')

    <form class="form-horizontal" role="form">

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
                                    <a href="#" style="padding: 0px;">{{ $matter->descripcion }}</a>
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
                <div class="well">
                    <div class="form-group">
                        <div class="col-sm-1">
                            <div class="checkbox">
                                <label class="block">
                                    {!! Form::checkbox('estado', 'A', true, ['class' => 'ace input-lg']) !!}
                                    <span class="lbl bigger-120"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-11">
                            {{ $reagent->planteamiento }}
                            <div class="space-6"></div>
                            <div class="pull-left">
                                Formato: <span class="green smaller lighter">{{ $reagent->format->nombre }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </form>

@endsection

@push('specific-script')
    <script type="text/javascript" src="{{ asset('scripts/exam/exams/common.js') }}"></script>
@endpush