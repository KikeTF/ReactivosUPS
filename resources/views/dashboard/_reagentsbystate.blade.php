<div id="reagents-by-state-chart" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0; padding: 0;"></div>

<script type="text/javascript">
    $(document).ready(function() {
        Highcharts.getOptions().plotOptions.pie.colors = (function () {
            var colors = decodeString('{{ '"'.implode('","', $data['colors']).'"' }}');
            return colors;
        }());

        Highcharts.chart('reagents-by-state-chart', {
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
                pointFormat: '{series.name}: <b>{point.y} ( {point.percentage:.1f} % )</b>'
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
                name: 'Reactivos',
                //colorByPoint: true,
                data: [
                        @foreach($data['series'] as $i => $state)
                    {
                        name: '{{ $state['state'] }}',
                        y: eval('{{ $state['value'] }}'),
                        /*drilldown: eval('{{-- $state['id'] --}}')*/
                    },
                    @endforeach
                ]
            }],
            /*
             drilldown: {
             series: [
            {{--
                @foreach($data['series'] as $i => $state)
                    {
                        name: '{{ $state['state'] }}', id: eval('{{ $state['id'] }}'),
                        data: [
                            ['v11.0', 24.13],
                            ['v8.0', 17.2],
                            ['v9.0', 8.11],
                            ['v10.0', 5.33],
                            ['v6.0', 1.06],
                            ['v7.0', 0.5]
                        ]
                },
                @endforeach
            --}}
            ]
             }
             */
        });
    });
</script>
