@extends('shared.templates.index')

@section('titulo', 'Reactivos UPS')
@section('subtitulo', 'Inicio')

@push('specific-styles')
    <link rel="stylesheet" href="{{ asset('highcharts/css/highcharts.css') }}" />
@endpush

@section('contenido')
    <div id="chart-container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
@endsection

@push('specific-script')
    <script type="text/javascript" src="{{ asset('highcharts/js/highcharts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('highcharts/js/modules/exporting.js') }}"></script>
    <script type="text/javascript">
        Highcharts.chart('chart-container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Efficiency Optimization by Branch'
            },
            xAxis: {
                categories: [
                    'Materia 1',
                    'Materia 2'
                ]
            },
            yAxis: [{
                min: 0,
                title: {
                    text: 'Reactivos'
                }
            }, {
                title: {
                    text: 'Profit (millions)'
                },
                opposite: true
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
                data: [150, 73],
                pointPadding: 0.3,
                pointPlacement: -0.2
            }, {
                name: 'Reactivos',
                color: 'rgba(126,86,134,.9)',
                data: [140, 90],
                pointPadding: 0.4,
                pointPlacement: -0.2
            }]
        });
    </script>
@endpush