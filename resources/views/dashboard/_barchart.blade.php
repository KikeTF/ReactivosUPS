<div id="bar-chart-container" style="min-width: 400px; height: 400px; margin: 0; padding: 0;"></div>

@push('bar-chart-script')
    <script type="text/javascript">
        Highcharts.chart('bar-chart-container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Reactivos Aprobados por Materia'
            },
            xAxis: {
                categories: decodeString('{{ '"'.implode('","', $BarChartData['categories']).'"' }}')
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
                color: '#DDDDDD',
                data: [{{ implode(',', $data['target_series']) }}],
                pointPadding: 0.3
            }, {
                name: 'Reactivos Aprobados',
                color: '#32769F',
                data: [{{ implode(',', $data['real_series']) }}],
                pointPadding: 0.35
            }]
        });
    </script>
@endpush