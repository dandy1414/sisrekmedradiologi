$(function () {
    $(document).ready(function () {
        $('#tahun-kunjungan').change(function () {
            const thn_kunjungan = $(this).val();
            $('#bulan-kunjungan').change(function () {
                const bln_kunjungan = $(this).val();
                if (thn_kunjungan != '' && bln_kunjungan != 'all') {
                    load_kunjungan_bulanan(thn_kunjungan, bln_kunjungan);
                }
                if(thn_kunjungan != '' && bln_kunjungan == 'all') {
                    load_kunjungan_tahunan(thn_kunjungan);
                }
            })
        })
    });

    function load_kunjungan_tahunan(thn_kunjungan) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'dashboard/kunjungan-tahunan',
            method: 'POST',
            data: {
                thn_kunjungan: thn_kunjungan
            },
            dataType: "JSON",
            success: function (data) {
                grafikKunjungan(data);
            }
        });
    }

    function load_kunjungan_bulanan(thn_kunjungan, bln_kunjungan) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'dashboard/kunjungan-bulanan',
            method: 'POST',
            data: {
                thn_kunjungan: thn_kunjungan,
                bln_kunjungan: bln_kunjungan
            },
            dataType: "JSON",
            success: function (data) {
                grafikKunjungan(data);
            }
        });
    }

    function grafikKunjungan(data){
        'use strict';

        var areaChartCanvas = $('#kunjunganPasien').get(0).getContext('2d')
        var areaChart = new Chart(areaChartCanvas)

        //Grafik Kunjungan
        var areaChartData = {
            labels: data['labels'],
            datasets: [{
                label: 'Kunjungan Pasien',
                fillColor: 'rgba(60,141,188,0.9)',
                strokeColor: 'rgba(60,141,188,0.8)',
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: data['total']
            }]
        }

        var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: 'rgba(0,0,0,.05)',
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        }

        areaChart.Line(areaChartData, areaChartOptions)

        var lineChartCanvas = $('#kunjunganPasien').get(0).getContext('2d')
        var lineChart = new Chart(lineChartCanvas)
        var lineChartOptions = areaChartOptions
        lineChartOptions.datasetFill = false
        lineChart.Line(areaChartData, lineChartOptions)
        //End grafik kunjungan
    }
})
