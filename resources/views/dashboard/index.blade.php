@extends('shared.templates.index')

@section('titulo', 'Reactivos UPS')
@section('subtitulo', 'Inicio')

@push('specific-styles')
    <link rel="stylesheet" href="{{ asset('highcharts/css/highcharts.css') }}" />
@endpush

@section('contenido')

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

@endsection

@push('specific-script')
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