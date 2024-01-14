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
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        var nilai_pendidikan = {{ json_encode($nilai_pendidikan) }};
        var nilai_masa_kerja = {{ json_encode($nilai_masa_kerja) }};
        var nilai_jabatan = {{ json_encode($nilai_jabatan) }};
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Achivement Employees'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category',
                labels: {
                    autoRotation: [-45, -90],
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Achivement Employees'
                }
            },
            legend: {
                enabled: true
            },
            tooltip: {
                pointFormat: ''
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Achivement Employees',
                colors: [
                    '#06d6a0', '#118ab2', '#ffd166', '#ef476f', '#457b9d', '#118ab2',
                    '#8338ec', '#edafb8', '#d4a373', '#ff9f1c', '#a8dadc', '#415a77',
                    '#57cc99'
                ],
                colorByPoint: true,
                groupPadding: 0,
                data: [
                    ['Absensi', 0],
                    ['Pendidikan', nilai_pendidikan],
                    ['Jabatan', nilai_jabatan],
                    ['Masa Kerja', nilai_masa_kerja],
                    ['Sertifikasi BNSP', 0],
                    ['Sertifikasi KEMNAKER', 0],
                    ['Sertifikasi Lainnya', 0],
                    ['QCC Internal', 0],
                    ['SS Internal', 0],
                    ['QCC Eksternal', 0],
                    ['SS Eksternal', 0],
                    ['Training Internal', 0],
                    ['Training Eksternal', 0]
                ],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y:.0f}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });
    </script>
@endsection
