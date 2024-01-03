@extends('layouts.admin')
@section('content')
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="container"></div>
                    </div>
                </div>
            </div>
        </main>

        {{-- End Content --}}
    </div>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        var Tahun = {{ $Tahun }};
        var MasukJanuari = {{ json_encode($MasukJanuari) }};
        var MasukFebruari = {{ json_encode($MasukFebruari) }};
        var MasukMaret = {{ json_encode($MasukMaret) }};
        var MasukApril = {{ json_encode($MasukApril) }};
        var MasukMei = {{ json_encode($MasukMei) }};
        var MasukJuni = {{ json_encode($MasukJuni) }};
        var MasukJuli = {{ json_encode($MasukJuli) }};
        var MasukAgustus = {{ json_encode($MasukAgustus) }};
        var MasukSeptember = {{ json_encode($MasukSeptember) }};
        var MasukOktober = {{ json_encode($MasukOktober) }};
        var MasukNovember = {{ json_encode($MasukNovember) }};
        var MasukDesember = {{ json_encode($MasukDesember) }};
        var KeluarJanuari = {{ json_encode($KeluarJanuari) }};
        var KeluarFebruari = {{ json_encode($KeluarFebruari) }};
        var KeluarMaret = {{ json_encode($KeluarMaret) }};
        var KeluarApril = {{ json_encode($KeluarApril) }};
        var KeluarMei = {{ json_encode($KeluarMei) }};
        var KeluarJuni = {{ json_encode($KeluarJuni) }};
        var KeluarJuli = {{ json_encode($KeluarJuli) }};
        var KeluarAgustus = {{ json_encode($KeluarAgustus) }};
        var KeluarSeptember = {{ json_encode($KeluarSeptember) }};
        var KeluarOktober = {{ json_encode($KeluarOktober) }};
        var KeluarNovember = {{ json_encode($KeluarNovember) }};
        var KeluarDesember = {{ json_encode($KeluarDesember) }};

        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'DATA TURNOVER KARYAWAN TAHUN ' + Tahun,
                align: 'left'
            },
            subtitle: {
                text: '',
                align: 'left'
            },
            xAxis: {
                categories: ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER',
                    'OKTOBER', 'NOVEMBER', 'DESEMBER'
                ],
                crosshair: true,
                accessibility: {
                    description: 'Countries'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Turnover Karyawan'
                }
            },
            tooltip: {
                valueSuffix: ' Man Power'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                    name: 'Masuk',
                    data: [MasukJanuari, MasukFebruari, MasukMaret, MasukApril, MasukMei, MasukJuni, MasukJuli,
                        MasukAgustus, MasukSeptember, MasukOktober,
                        MasukNovember,
                        MasukDesember
                    ]
                },
                {
                    name: 'Keluar',
                    data: [KeluarJanuari, KeluarFebruari, KeluarMaret, KeluarApril, KeluarMei, KeluarJuni,
                        KeluarJuli, KeluarAgustus, KeluarSeptember, KeluarOktober, KeluarNovember,
                        KeluarDesember
                    ]
                }
            ]
        });
    </script>
@endsection
