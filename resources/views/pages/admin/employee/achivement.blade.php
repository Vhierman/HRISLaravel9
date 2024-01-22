@extends('layouts.admin')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="container"></div>
                    </div>
                </div>
            </div>
        </main>

    </div>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        var nilai_pendidikan = {{ json_encode($nilai_pendidikan) }};
        var nilai_masa_kerja = {{ json_encode($nilai_masa_kerja) }};
        var nilai_jabatan = {{ json_encode($nilai_jabatan) }};
        var nilai_absensi = {{ json_encode($nilai_absensi) }};
        var nilai_training_internal = {{ json_encode($nilai_training_internal) }};
        var nilai_training_eksternal = {{ json_encode($nilai_training_eksternal) }};
        var nilai_sertifikasi_bnsp = {{ json_encode($nilai_sertifikasi_bnsp) }};
        var nilai_sertifikasi_kementrian = {{ json_encode($nilai_sertifikasi_kementrian) }};
        var nilai_sertifikasi_lainnya = {{ json_encode($nilai_sertifikasi_lainnya) }};
        var nilai_qcc_internal = {{ json_encode($nilai_qcc_internal) }};
        var nilai_qcc_eksternal = {{ json_encode($nilai_qcc_eksternal) }};
        var nilai_ss_internal = {{ json_encode($nilai_ss_internal) }};
        var nilai_ss_eksternal = {{ json_encode($nilai_ss_eksternal) }};

        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Achivement Employees This Year'
            },
            subtitle: {
                align: 'left',
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total Average Achivement Employees'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.0f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}%</b> of average<br/>'
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Nilai',
                colorByPoint: true,
                data: [{
                        name: 'Absensi',
                        y: nilai_absensi,
                        drilldown: null
                    },
                    {
                        name: 'Pendidikan',
                        y: nilai_pendidikan,
                        drilldown: null
                    },
                    {
                        name: 'Jabatan',
                        y: nilai_jabatan,
                        drilldown: null
                    },
                    {
                        name: 'Masa Kerja',
                        y: nilai_masa_kerja,
                        drilldown: null
                    },
                    {
                        name: 'Sertifikasi BNSP',
                        y: nilai_sertifikasi_bnsp,
                        drilldown: null
                    },
                    {
                        name: 'Sertifikasi Kementrian',
                        y: nilai_sertifikasi_kementrian,
                        drilldown: null
                    },
                    {
                        name: 'Sertifikasi Lainnya',
                        y: nilai_sertifikasi_lainnya,
                        drilldown: null
                    },
                    {
                        name: 'Training Internal',
                        y: nilai_training_internal,
                        drilldown: null
                    },
                    {
                        name: 'Training Eksternal',
                        y: nilai_training_eksternal,
                        drilldown: null
                    },
                    {
                        name: 'QCC Internal',
                        y: nilai_qcc_internal,
                        drilldown: null
                    },
                    {
                        name: 'SS Internal',
                        y: nilai_ss_internal,
                        drilldown: null
                    },
                    {
                        name: 'QCC Eksternal',
                        y: nilai_qcc_eksternal,
                        drilldown: null
                    },
                    {
                        name: 'SS Eksternal',
                        y: nilai_ss_eksternal,
                        drilldown: null
                    }
                ]
            }],

        });
    </script>
@endsection
