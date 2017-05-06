<div id="pie-chart-container" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0; padding: 0;"></div>

@push('pie-chart-script')
    <script type="text/javascript">
        Highcharts.getOptions().plotOptions.pie.colors = (function () {
            var colors = decodeString('{{ '"'.implode('","', $data['colors']).'"' }}');
            return colors;
        }());

        Highcharts.chart('pie-chart-container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Reactivos por Estado'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    //allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.percentage:.1f} %</b>',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Porcentaje',
                //colorByPoint: true,
                data: [
                    @foreach($data['series'] as $i => $state)
                        { name: '{{ $state['state'] }}', y: eval('{{ $state['value'] }}') },
                    @endforeach
                ]
            }]
        });
    </script>
@endpush