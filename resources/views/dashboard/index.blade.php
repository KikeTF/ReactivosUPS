@extends('shared.templates.index')

@section('titulo', 'Reactivos UPS')
@section('subtitulo', 'Inicio')

@push('specific-styles')
    <link rel="stylesheet" href="{{ asset('highcharts/css/highcharts.css') }}" />
@endpush

@section('contenido')
    <div id="chart-container" style="min-width: 400px; height: 400px; margin: 0; padding: 0;"></div>
@endsection

@push('specific-script')
    <script type="text/javascript" src="{{ asset('highcharts/js/highcharts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('highcharts/js/modules/exporting.js') }}"></script>
    <script type="text/javascript">
        function decodeString (){
            var encodedStr = '{{ '"'.implode('","', $data['categories']).'"' }}';
            var parser = new DOMParser;
            var dom = parser.parseFromString('<!doctype html><body>' + encodedStr, 'text/html');
            var decodedString = dom.body.textContent;
            var jsArray = JSON.parse("[" + decodedString + "]");

            return jsArray;
        }
    </script>
    <script type="text/javascript">
        Highcharts.chart('chart-container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Reactivos por Materia'
            },
            xAxis: {
                categories: decodeString()
            },
            yAxis: [{
                min: 0,
                tickInterval: 2,
                title: {
                    text: 'Reactivos'
                }
            }],
            legend: {
                shadow: false
            },
            tooltip: {
                shared: true
            },
            plotOptions: {
                column: {
                    grouping: false,
                    shadow: false,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Reactivos Requeridos',
                color: 'rgba(165,170,217,1)',
                data: [{{ implode(',', $data['target_series']) }}],
                pointPadding: 0.35
            }, {
                name: 'Reactivos Aprobados',
                color: 'rgba(126,86,134,.9)',
                data: [{{ implode(',', $data['real_series']) }}],
                pointPadding: 0.4
            }]
        });
    </script>
@endpush