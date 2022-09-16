@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="containerabsensiquality"></div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    {{-- Quality --}}
    <script>
        var ItemQualitySakitJanuari = {{ json_encode($ItemQualitySakitJanuari) }};
        var ItemQualityIjinJanuari = {{ json_encode($ItemQualityIjinJanuari) }};
        var ItemQualityAlpaJanuari = {{ json_encode($ItemQualityAlpaJanuari) }};
        var ItemQualityCutiJanuari = {{ json_encode($ItemQualityCutiJanuari) }};
        var ItemQualitySakitFebruari = {{ json_encode($ItemQualitySakitFebruari) }};
        var ItemQualityIjinFebruari = {{ json_encode($ItemQualityIjinFebruari) }};
        var ItemQualityAlpaFebruari = {{ json_encode($ItemQualityAlpaFebruari) }};
        var ItemQualityCutiFebruari = {{ json_encode($ItemQualityCutiFebruari) }};
        var ItemQualitySakitMaret = {{ json_encode($ItemQualitySakitMaret) }};
        var ItemQualityIjinMaret = {{ json_encode($ItemQualityIjinMaret) }};
        var ItemQualityAlpaMaret = {{ json_encode($ItemQualityAlpaMaret) }};
        var ItemQualityCutiMaret = {{ json_encode($ItemQualityCutiMaret) }};
        var ItemQualitySakitApril = {{ json_encode($ItemQualitySakitApril) }};
        var ItemQualityIjinApril = {{ json_encode($ItemQualityIjinApril) }};
        var ItemQualityAlpaApril = {{ json_encode($ItemQualityAlpaApril) }};
        var ItemQualityCutiApril = {{ json_encode($ItemQualityCutiApril) }};
        var ItemQualitySakitMei = {{ json_encode($ItemQualitySakitMei) }};
        var ItemQualityIjinMei = {{ json_encode($ItemQualityIjinMei) }};
        var ItemQualityAlpaMei = {{ json_encode($ItemQualityAlpaMei) }};
        var ItemQualityCutiMei = {{ json_encode($ItemQualityCutiMei) }};
        var ItemQualitySakitJuni = {{ json_encode($ItemQualitySakitJuni) }};
        var ItemQualityIjinJuni = {{ json_encode($ItemQualityIjinJuni) }};
        var ItemQualityAlpaJuni = {{ json_encode($ItemQualityAlpaJuni) }};
        var ItemQualityCutiJuni = {{ json_encode($ItemQualityCutiJuni) }};
        var ItemQualitySakitJuli = {{ json_encode($ItemQualitySakitJuli) }};
        var ItemQualityIjinJuli = {{ json_encode($ItemQualityIjinJuli) }};
        var ItemQualityAlpaJuli = {{ json_encode($ItemQualityAlpaJuli) }};
        var ItemQualityCutiJuli = {{ json_encode($ItemQualityCutiJuli) }};
        var ItemQualitySakitAgustus = {{ json_encode($ItemQualitySakitAgustus) }};
        var ItemQualityIjinAgustus = {{ json_encode($ItemQualityIjinAgustus) }};
        var ItemQualityAlpaAgustus = {{ json_encode($ItemQualityAlpaAgustus) }};
        var ItemQualityCutiAgustus = {{ json_encode($ItemQualityCutiAgustus) }};
        var ItemQualitySakitSeptember = {{ json_encode($ItemQualitySakitSeptember) }};
        var ItemQualityIjinSeptember = {{ json_encode($ItemQualityIjinSeptember) }};
        var ItemQualityAlpaSeptember = {{ json_encode($ItemQualityAlpaSeptember) }};
        var ItemQualityCutiSeptember = {{ json_encode($ItemQualityCutiSeptember) }};
        var ItemQualitySakitOktober = {{ json_encode($ItemQualitySakitOktober) }};
        var ItemQualityIjinOktober = {{ json_encode($ItemQualityIjinOktober) }};
        var ItemQualityAlpaOktober = {{ json_encode($ItemQualityAlpaOktober) }};
        var ItemQualityCutiOktober = {{ json_encode($ItemQualityCutiOktober) }};
        var ItemQualitySakitNovember = {{ json_encode($ItemQualitySakitNovember) }};
        var ItemQualityIjinNovember = {{ json_encode($ItemQualityIjinNovember) }};
        var ItemQualityAlpaNovember = {{ json_encode($ItemQualityAlpaNovember) }};
        var ItemQualityCutiNovember = {{ json_encode($ItemQualityCutiNovember) }};
        var ItemQualitySakitDesember = {{ json_encode($ItemQualitySakitDesember) }};
        var ItemQualityIjinDesember = {{ json_encode($ItemQualityIjinDesember) }};
        var ItemQualityAlpaDesember = {{ json_encode($ItemQualityAlpaDesember) }};
        var ItemQualityCutiDesember = {{ json_encode($ItemQualityCutiDesember) }};

        Highcharts.chart('containerabsensiquality', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'LAPORAN ABSENSI QUALITY TAHUN 2022'
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
                    '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
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
                data: [ItemQualityCutiJanuari, ItemQualityCutiFebruari,
                    ItemQualityCutiMaret, ItemQualityCutiApril,
                    ItemQualityCutiMei, ItemQualityCutiJuni,
                    ItemQualityCutiJuli, ItemQualityCutiAgustus,
                    ItemQualityCutiSeptember, ItemQualityCutiOktober,
                    ItemQualityCutiNovember, ItemQualityCutiDesember
                ]

            }, {
                name: 'Sakit',
                data: [ItemQualitySakitJanuari, ItemQualitySakitFebruari,
                    ItemQualitySakitMaret, ItemQualitySakitApril,
                    ItemQualitySakitMei, ItemQualitySakitJuni,
                    ItemQualitySakitJuli, ItemQualitySakitAgustus,
                    ItemQualitySakitSeptember, ItemQualitySakitOktober,
                    ItemQualitySakitNovember, ItemQualitySakitDesember
                ]

            }, {
                name: 'Ijin',
                data: [ItemQualityIjinJanuari, ItemQualityIjinFebruari,
                    ItemQualityIjinMaret, ItemQualityIjinApril,
                    ItemQualityIjinMei, ItemQualityIjinJuni,
                    ItemQualityIjinJuli, ItemQualityIjinAgustus,
                    ItemQualityIjinSeptember, ItemQualityIjinOktober,
                    ItemQualityIjinNovember, ItemQualityIjinDesember
                ]

            }, {
                name: 'Alpa',
                data: [ItemQualityAlpaJanuari, ItemQualityAlpaFebruari,
                    ItemQualityAlpaMaret, ItemQualityAlpaApril,
                    ItemQualityAlpaMei, ItemQualityAlpaJuni,
                    ItemQualityAlpaJuli, ItemQualityAlpaAgustus,
                    ItemQualityAlpaSeptember, ItemQualityAlpaOktober,
                    ItemQualityAlpaNovember, ItemQualityAlpaDesember
                ]

            }]
        });
    </script>
    {{-- Quality --}}
@endsection
