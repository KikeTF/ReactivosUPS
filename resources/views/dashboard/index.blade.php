@extends('shared.templates.index')

@section('titulo', 'Reactivos UPS')
@section('subtitulo', 'Inicio')

@push('specific-styles')
    {!! HTML::style('highcharts/css/highcharts.css') !!}
@endpush

@section('contenido')
    <?php
    $aprReactivo = \Session::get('ApruebaReactivo');
    $aprExamen = \Session::get('ApruebaExamen');
    ?>

    {!! Form::open(['id'=>'formdata', 'class' => 'form-horizontal', 'role' => 'form', 'route' => 'dashboard.index', 'method' => 'GET']) !!}

    <div class="widget-box">
        <div class="widget-header">
            <h5 class="widget-title">Filtros</h5>

            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
        </div>

        <div class="widget-body" style="display: block; padding-top: 5px;">
            <div class="widget-main">
                <div class="row" style="position: relative;">
                    <div class="col-sm-11">
                        <div class="col-sm-3">
                            {{-- Form::label('id_campus', 'Seleccione Campus:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) --}}
                            <div id="listaCampus">
                                @include('shared.optionlists._campuslist')
                            </div>
                        </div>

                        <div class="col-sm-3">
                            {{-- Form::label('id_carrera', 'Seleccione Carrera:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) --}}
                            <div id="listaCarreras">
                                @include('shared.optionlists._careerslist')
                            </div>
                        </div>

                        <div class="col-sm-6">
                            {{-- Form::label('id_periodo_sede', 'Seleccione Periodo:', ['class' => 'control-label no-padding-right', 'style' => 'font-size: 12px' ]) --}}
                            {!! Form::select('periodosSede[]', $locationPeriodsList, (isset($filters['periodosSede']) ? $filters['periodosSede'] : null ), ['multiple' => '', 'id' => 'periodosSede', 'class' => 'chosen-select form-control tag-input-style', 'data-placeholder' => '-- Seleccione Periodos --', 'style' => 'display: none;'] ) !!}
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

    <div class="space-4"></div>

    <div class="widget-box">
        <div class="widget-header">
            <h5 class="widget-title">Reactivos</h5>

            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
        </div>

        <div class="widget-body" style="display: block; padding-top: 5px;">
            <div class="widget-main" style="padding: 5px 12px 10px 12px;">
                <div class="row" style="position: relative;">
                    <div class="col-md-8" align="center">
                        <div class="form-group" align="center">
                        <div class="widget-box">
                            <div class="widget-body">
                                <div class="widget-main">
                                    @include('dashboard._reagentsbymatter', ['data' => $MattersChartData])
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4" align="center">
                        <div class="widget-box">
                            <div class="widget-body">
                                <div class="widget-main">
                                    @include('dashboard._reagentsbystate', ['data' => $StatesChartData])
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($aprReactivo == 'S')
                    <div class="col-xs-12" align="center">
                        <div class="widget-box">
                            <div class="widget-body">
                                <div class="widget-main">
                                    @include('dashboard._reagentsbyteacher', ['data' => $TeachersChartData])
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($aprExamen == 'S')
    <div class="space-4"></div>

    <div class="widget-box">
        <div class="widget-header">
            <h5 class="widget-title">Simulador</h5>

            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
        </div>

        <div class="widget-body" style="display: block; padding-top: 5px;">
            <div class="widget-main" style="padding: 5px 12px 10px 12px;">
                <div class="row" style="position: relative;">
                    <div class="col-md-4" align="center">
                        <div class="widget-box">
                            <div class="widget-body">
                                <div class="widget-main">
                                    @include('dashboard._testsbystate', ['data' => $TestsChartData])
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8" align="center">
                        <div class="widget-box">
                            <div class="widget-body">
                                <div class="widget-main">
                                    @include('dashboard._testanswersbymatter', ['data' => $TestAnswersChartData])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection

@push('specific-script')
    @include('shared.optionlists.functions')
    <script type="text/javascript">
        $( window ).load(function() {
            getCareersByCampus();
            $('.chosen-container').attr("data-placeholder","choose a language...");

        });

    </script>
    {!! HTML::script('highcharts/js/highcharts.js') !!}
    {!! HTML::script('highcharts/js/modules/exporting.js') !!}
    <script type="text/javascript">
        function decodeString (encodedStr){
            //var encodedStr = '';
            var parser = new DOMParser;
            var dom = parser.parseFromString('<!doctype html><body>' + encodedStr, 'text/html');
            var decodedString = dom.body.textContent;
            var jsArray = JSON.parse("[" + decodedString + "]");

            return jsArray;
        }
    </script>
@endpush