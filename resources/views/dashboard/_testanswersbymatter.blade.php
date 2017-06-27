<div id="answers-by-matter-chart" style="min-width: 400px; height: 400px; margin: 0; padding: 0;"></div>

<script type="text/javascript">
    $(document).ready(function() {
        Highcharts.chart('answers-by-matter-chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Aciertos por Materia'
            },
            xAxis: {
                categories: decodeString('{{ '"'.implode('","', $data['categories']).'"' }}')
            },
            yAxis: [{
                min: 0,
                tickInterval: 2,
                title: {
                    text: 'Respuestas'
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
                    borderWidth: 1
                }
            },
            series: [{
                name: 'Respuestas',
                color: '#DDDDDD',
                data: [{{ implode(',', $data['target_series']) }}],
                pointPadding: 0.2
            }, {
                name: 'Aciertos',
                color: '#32769F',
                data: [{{ implode(',', $data['real_series']) }}],
                pointPadding: 0.25
            }]
        });
    });
</script>
