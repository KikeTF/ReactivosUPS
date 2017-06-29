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

    <form id="formdata" class="form-horizontal" role="form">
        <div class="widget-box">
            <div class="widget-header">
                <h5 class="widget-title">Reactivos</h5>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body" style="display: block;">
                <div class="widget-main" style="padding: 5px 12px 10px 12px;">
                    <div class="row">
                        <div class="col-xs-10 col-sm-2" style="padding-top: 5px;">
                            <div id="listaCampus">
                                @include('shared.optionlists._campuslist')
                            </div>
                        </div>

                        <div class="col-xs-10 col-sm-3" style="padding-top: 5px;">
                            <div id="listaCarreras">
                                @include('shared.optionlists._careerslist')
                            </div>
                        </div>

                        <div class="col-xs-10 col-sm-6" style="padding-top: 5px;">
                            {!! Form::select('periodosSede[]', $locationPeriodsList, (isset($filters['periodosSede']) ? $filters['periodosSede'] : null ), ['multiple' => '', 'id' => 'periodosSede', 'class' => 'chosen-select form-control tag-input-style', 'data-placeholder' => '-- Seleccione Periodos --', 'style' => 'display: none;'] ) !!}
                        </div>

                        <div class="col-xs-2 col-sm-1" style="padding-top: 5px;">
                            <button onclick="filtrarData(1); return false;" title="Filtrar" class="btn btn-white btn-primary btn-bold" style="float:right;">
                                <i class='ace-icon fa fa-filter bigger-110 blue' style="margin: 0"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="space-4"></div>
                        </div>

                        <div style="padding-right: 7px; padding-left: 7px;">
                            <div class="col-md-8" align="center" style="padding-right: 5px; padding-left: 5px;">
                                <div class="widget-box">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            @include('dashboard._reagentsbymatter', ['data' => $MattersChartData])
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4" align="center" style="padding-right: 5px; padding-left: 5px;">
                                <div class="widget-box">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            @include('dashboard._reagentsbystate', ['data' => $StatesChartData])
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($aprReactivo == 'S')
                            <div class="col-xs-12">
                                <div class="space-4"></div>
                            </div>

                            <div class="col-xs-12" align="center" style="padding-right: 5px; padding-left: 5px;">
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
        </div>
    </form>

    @if($aprExamen == 'S')
    <div class="space-4"></div>

    <form id="formdata2" class="form-horizontal" role="form">
        <div class="widget-box">
            <div class="widget-header">
                <h5 class="widget-title">Simulador</h5>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body" style="display: block;">
                <div class="widget-main" style="padding: 5px 12px 10px 12px;">
                    <div class="row">
                        <div class="col-xs-10 col-sm-3" style="padding-top: 5px;">
                            <div id="listaCampus">
                                @include('shared.optionlists._campuslist', ['id_campus_test' => $filters_test[0]])
                            </div>
                        </div>

                        <div class="col-xs-10 col-sm-4" style="padding-top: 5px;">
                            <div id="listaCarreras">
                                @include('shared.optionlists._careerslist', ['id_carrera_test' => $filters_test[1]])
                            </div>
                        </div>

                        <div class="col-xs-10 col-sm-4" style="padding-top: 5px;">
                            <div id="listaMenciones">
                                @include('shared.optionlists._mentionslist', ['id_mencion_test' => $filters_test[2]])
                            </div>
                        </div>

                        <div class="col-xs-10 col-sm-7" style="padding-top: 5px;">
                            {!! Form::select('periodosSedeTest[]', $locationPeriodsList, (isset($filters_test['periodosSedeTest']) ? $filters_test['periodosSedeTest'] : null ), ['multiple' => '', 'id' => 'periodosSedeTest', 'class' => 'chosen-select form-control tag-input-style', 'data-placeholder' => '-- Seleccione Periodos --', 'style' => 'display: none;'] ) !!}
                        </div>

                        <div class="col-xs-2 col-sm-5" style="padding-top: 5px;">
                            <button onclick="filtrarData(2); return false;" title="Filtrar" class="btn btn-white btn-primary btn-bold" style="float:right;">
                                <i class='ace-icon fa fa-filter bigger-110 blue' style="margin: 0"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div style="padding-right: 7px; padding-left: 7px;">
                            <div class="col-xs-12">
                                <div class="space-4"></div>
                            </div>

                            <div class="col-md-4" align="center" style="padding-right: 5px; padding-left: 5px;">
                                <div class="widget-box">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            @include('dashboard._testsbystate', ['data' => $TestsChartData])
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8" align="center" style="padding-right: 5px; padding-left: 5px;">
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
        </div>
    </form>
    @endif

    {!! Form::open(['id'=>'formulario', 'class' => 'form-horizontal', 'role' => 'form', 'route' => 'dashboard.index', 'method' => 'GET']) !!}

    {!! Form::hidden('type', 0, ['id' => 'type']) !!}

    {!! Form::hidden('reaIdCampus', 0, ['id' => 'reaIdCampus']) !!}
    {!! Form::hidden('reaIdCarrera', 0, ['id' => 'reaIdCarrera']) !!}
    {!! Form::hidden('reaPeriodosSede[]', null, ['id' => 'reaPeriodosSede']) !!}

    {!! Form::hidden('testIdCampus', 0, ['id' => 'testIdCampus']) !!}
    {!! Form::hidden('testIdCarrera', 0, ['id' => 'testIdCarrera']) !!}
    {!! Form::hidden('testIdMencion', 0, ['id' => 'testIdMencion']) !!}
    {!! Form::hidden('testPeriodosSede[]', null, ['id' => 'testPeriodosSede']) !!}

    {!! Form::close() !!}

@endsection

@push('specific-script')
    @include('shared.optionlists.functions')
    <script type="text/javascript">
        $( window ).load(function() {
            getCareersByCampus('formdata');
            getCareersByCampus('formdata2', '{{ $filters_test[1] }}');
            getMentionsByCareer('formdata2', '{{ $filters_test[2] }}')
            $('.chosen-container').attr("data-placeholder","choose an item...");
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
        function filtrarData(type) {
            var aprExam = '{{ ($aprExamen == 'S') ? 'S' : 'N' }}';
            $('#type').val(type);

            $('#reaIdCampus').val($('#formdata select[id=id_campus]').val());
            $('#reaIdCarrera').val($('#formdata select[id=id_carrera]').val());
            $('#reaPeriodosSede').val($('#formdata select[id=periodosSede]').val());

            if(aprExam == 'S')
            {
                $('#testIdCampus').val($('#formdata2 select[id=id_campus]').val());
                $('#testIdCarrera').val($('#formdata2 select[id=id_carrera]').val());
                $('#testIdMencion').val($('#formdata2 select[id=id_mencion]').val());
                $('#testPeriodosSede').val($('#formdata2 select[id=periodosSedeTest]').val());
            }

            document.forms["formulario"].submit();
        }
    </script>
@endpush