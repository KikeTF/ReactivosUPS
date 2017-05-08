@extends('shared.templates.index')

@section('titulo', 'Reactivos UPS')
@section('subtitulo', 'Inicio')

@push('specific-styles')
    <link rel="stylesheet" href="{{ asset('highcharts/css/highcharts.css') }}" />
@endpush

@section('contenido')

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

        <div class="widget-body" style="display: block;">
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
                        <div class="btn btn-white btn-primary btn-bold" style="float:right;">
                            <a class="blue" href="#" onclick="document.forms[0].submit();">
                                <i class='ace-icon fa fa-filter bigger-110 blue'></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    <div class="row">
        <div class="col-md-6" style="margin: 10px auto;" align="center">
            <div class="widget-box">
                <div class="widget-body">
                    <div class="widget-main">
                        @include('dashboard._barchart', ['data' => $BarChartData])
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6" style="margin: 10px auto;" align="center">
            <div class="widget-box">
                <div class="widget-body">
                    <div class="widget-main">
                        @include('dashboard._piechart', ['data' => $PieChartData])
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
            $('.chosen-container').attr("data-placeholder","choose a language...");

        });

    </script>
    <script type="text/javascript" src="{{ asset('highcharts/js/highcharts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('highcharts/js/modules/exporting.js') }}"></script>
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