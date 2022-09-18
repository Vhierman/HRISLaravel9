@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="containerabsensiaccicit"></div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    {{-- AccICIT --}}
    <script>
        var ItemAccICITSakitJanuari = {{ json_encode($ItemAccICITSakitJanuari) }};
        var ItemAccICITIjinJanuari = {{ json_encode($ItemAccICITIjinJanuari) }};
        var ItemAccICITAlpaJanuari = {{ json_encode($ItemAccICITAlpaJanuari) }};
        var ItemAccICITCutiJanuari = {{ json_encode($ItemAccICITCutiJanuari) }};
        var ItemAccICITSakitFebruari = {{ json_encode($ItemAccICITSakitFebruari) }};
        var ItemAccICITIjinFebruari = {{ json_encode($ItemAccICITIjinFebruari) }};
        var ItemAccICITAlpaFebruari = {{ json_encode($ItemAccICITAlpaFebruari) }};
        var ItemAccICITCutiFebruari = {{ json_encode($ItemAccICITCutiFebruari) }};
        var ItemAccICITSakitMaret = {{ json_encode($ItemAccICITSakitMaret) }};
        var ItemAccICITIjinMaret = {{ json_encode($ItemAccICITIjinMaret) }};
        var ItemAccICITAlpaMaret = {{ json_encode($ItemAccICITAlpaMaret) }};
        var ItemAccICITCutiMaret = {{ json_encode($ItemAccICITCutiMaret) }};
        var ItemAccICITSakitApril = {{ json_encode($ItemAccICITSakitApril) }};
        var ItemAccICITIjinApril = {{ json_encode($ItemAccICITIjinApril) }};
        var ItemAccICITAlpaApril = {{ json_encode($ItemAccICITAlpaApril) }};
        var ItemAccICITCutiApril = {{ json_encode($ItemAccICITCutiApril) }};
        var ItemAccICITSakitMei = {{ json_encode($ItemAccICITSakitMei) }};
        var ItemAccICITIjinMei = {{ json_encode($ItemAccICITIjinMei) }};
        var ItemAccICITAlpaMei = {{ json_encode($ItemAccICITAlpaMei) }};
        var ItemAccICITCutiMei = {{ json_encode($ItemAccICITCutiMei) }};
        var ItemAccICITSakitJuni = {{ json_encode($ItemAccICITSakitJuni) }};
        var ItemAccICITIjinJuni = {{ json_encode($ItemAccICITIjinJuni) }};
        var ItemAccICITAlpaJuni = {{ json_encode($ItemAccICITAlpaJuni) }};
        var ItemAccICITCutiJuni = {{ json_encode($ItemAccICITCutiJuni) }};
        var ItemAccICITSakitJuli = {{ json_encode($ItemAccICITSakitJuli) }};
        var ItemAccICITIjinJuli = {{ json_encode($ItemAccICITIjinJuli) }};
        var ItemAccICITAlpaJuli = {{ json_encode($ItemAccICITAlpaJuli) }};
        var ItemAccICITCutiJuli = {{ json_encode($ItemAccICITCutiJuli) }};
        var ItemAccICITSakitAgustus = {{ json_encode($ItemAccICITSakitAgustus) }};
        var ItemAccICITIjinAgustus = {{ json_encode($ItemAccICITIjinAgustus) }};
        var ItemAccICITAlpaAgustus = {{ json_encode($ItemAccICITAlpaAgustus) }};
        var ItemAccICITCutiAgustus = {{ json_encode($ItemAccICITCutiAgustus) }};
        var ItemAccICITSakitSeptember = {{ json_encode($ItemAccICITSakitSeptember) }};
        var ItemAccICITIjinSeptember = {{ json_encode($ItemAccICITIjinSeptember) }};
        var ItemAccICITAlpaSeptember = {{ json_encode($ItemAccICITAlpaSeptember) }};
        var ItemAccICITCutiSeptember = {{ json_encode($ItemAccICITCutiSeptember) }};
        var ItemAccICITSakitOktober = {{ json_encode($ItemAccICITSakitOktober) }};
        var ItemAccICITIjinOktober = {{ json_encode($ItemAccICITIjinOktober) }};
        var ItemAccICITAlpaOktober = {{ json_encode($ItemAccICITAlpaOktober) }};
        var ItemAccICITCutiOktober = {{ json_encode($ItemAccICITCutiOktober) }};
        var ItemAccICITSakitNovember = {{ json_encode($ItemAccICITSakitNovember) }};
        var ItemAccICITIjinNovember = {{ json_encode($ItemAccICITIjinNovember) }};
        var ItemAccICITAlpaNovember = {{ json_encode($ItemAccICITAlpaNovember) }};
        var ItemAccICITCutiNovember = {{ json_encode($ItemAccICITCutiNovember) }};
        var ItemAccICITSakitDesember = {{ json_encode($ItemAccICITSakitDesember) }};
        var ItemAccICITIjinDesember = {{ json_encode($ItemAccICITIjinDesember) }};
        var ItemAccICITAlpaDesember = {{ json_encode($ItemAccICITAlpaDesember) }};
        var ItemAccICITCutiDesember = {{ json_encode($ItemAccICITCutiDesember) }};

        Highcharts.chart('containerabsensiaccicit', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'LAPORAN ABSENSI ACCOUNTING, IC, IT TAHUN 2022'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:1f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
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
                name: 'Cuti',
                data: [ItemAccICITCutiJanuari, ItemAccICITCutiFebruari,
                    ItemAccICITCutiMaret, ItemAccICITCutiApril,
                    ItemAccICITCutiMei, ItemAccICITCutiJuni,
                    ItemAccICITCutiJuli, ItemAccICITCutiAgustus,
                    ItemAccICITCutiSeptember, ItemAccICITCutiOktober,
                    ItemAccICITCutiNovember, ItemAccICITCutiDesember
                ]

            }, {
                name: 'Sakit',
                data: [ItemAccICITSakitJanuari, ItemAccICITSakitFebruari,
                    ItemAccICITSakitMaret, ItemAccICITSakitApril,
                    ItemAccICITSakitMei, ItemAccICITSakitJuni,
                    ItemAccICITSakitJuli, ItemAccICITSakitAgustus,
                    ItemAccICITSakitSeptember, ItemAccICITSakitOktober,
                    ItemAccICITSakitNovember, ItemAccICITSakitDesember
                ]

            }, {
                name: 'Ijin',
                data: [ItemAccICITIjinJanuari, ItemAccICITIjinFebruari,
                    ItemAccICITIjinMaret, ItemAccICITIjinApril,
                    ItemAccICITIjinMei, ItemAccICITIjinJuni,
                    ItemAccICITIjinJuli, ItemAccICITIjinAgustus,
                    ItemAccICITIjinSeptember, ItemAccICITIjinOktober,
                    ItemAccICITIjinNovember, ItemAccICITIjinDesember
                ]

            }, {
                name: 'Alpa',
                data: [ItemAccICITAlpaJanuari, ItemAccICITAlpaFebruari,
                    ItemAccICITAlpaMaret, ItemAccICITAlpaApril,
                    ItemAccICITAlpaMei, ItemAccICITAlpaJuni,
                    ItemAccICITAlpaJuli, ItemAccICITAlpaAgustus,
                    ItemAccICITAlpaSeptember, ItemAccICITAlpaOktober,
                    ItemAccICITAlpaNovember, ItemAccICITAlpaDesember
                ]

            }]
        });
    </script>
    {{-- AccICIT --}}
@endsection
