@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="containerabsensipdc"></div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    {{-- PDC DAIHATSU --}}
    <script>
        var ItemPDCDaihatsuSunterSakitJanuari = {{ json_encode($ItemPDCDaihatsuSunterSakitJanuari) }};
        var ItemPDCDaihatsuSunterIjinJanuari = {{ json_encode($ItemPDCDaihatsuSunterIjinJanuari) }};
        var ItemPDCDaihatsuSunterAlpaJanuari = {{ json_encode($ItemPDCDaihatsuSunterAlpaJanuari) }};
        var ItemPDCDaihatsuSunterCutiJanuari = {{ json_encode($ItemPDCDaihatsuSunterCutiJanuari) }};
        var ItemPDCDaihatsuSunterSakitFebruari = {{ json_encode($ItemPDCDaihatsuSunterSakitFebruari) }};
        var ItemPDCDaihatsuSunterIjinFebruari = {{ json_encode($ItemPDCDaihatsuSunterIjinFebruari) }};
        var ItemPDCDaihatsuSunterAlpaFebruari = {{ json_encode($ItemPDCDaihatsuSunterAlpaFebruari) }};
        var ItemPDCDaihatsuSunterCutiFebruari = {{ json_encode($ItemPDCDaihatsuSunterCutiFebruari) }};
        var ItemPDCDaihatsuSunterSakitMaret = {{ json_encode($ItemPDCDaihatsuSunterSakitMaret) }};
        var ItemPDCDaihatsuSunterIjinMaret = {{ json_encode($ItemPDCDaihatsuSunterIjinMaret) }};
        var ItemPDCDaihatsuSunterAlpaMaret = {{ json_encode($ItemPDCDaihatsuSunterAlpaMaret) }};
        var ItemPDCDaihatsuSunterCutiMaret = {{ json_encode($ItemPDCDaihatsuSunterCutiMaret) }};
        var ItemPDCDaihatsuSunterSakitApril = {{ json_encode($ItemPDCDaihatsuSunterSakitApril) }};
        var ItemPDCDaihatsuSunterIjinApril = {{ json_encode($ItemPDCDaihatsuSunterIjinApril) }};
        var ItemPDCDaihatsuSunterAlpaApril = {{ json_encode($ItemPDCDaihatsuSunterAlpaApril) }};
        var ItemPDCDaihatsuSunterCutiApril = {{ json_encode($ItemPDCDaihatsuSunterCutiApril) }};
        var ItemPDCDaihatsuSunterSakitMei = {{ json_encode($ItemPDCDaihatsuSunterSakitMei) }};
        var ItemPDCDaihatsuSunterIjinMei = {{ json_encode($ItemPDCDaihatsuSunterIjinMei) }};
        var ItemPDCDaihatsuSunterAlpaMei = {{ json_encode($ItemPDCDaihatsuSunterAlpaMei) }};
        var ItemPDCDaihatsuSunterCutiMei = {{ json_encode($ItemPDCDaihatsuSunterCutiMei) }};
        var ItemPDCDaihatsuSunterSakitJuni = {{ json_encode($ItemPDCDaihatsuSunterSakitJuni) }};
        var ItemPDCDaihatsuSunterIjinJuni = {{ json_encode($ItemPDCDaihatsuSunterIjinJuni) }};
        var ItemPDCDaihatsuSunterAlpaJuni = {{ json_encode($ItemPDCDaihatsuSunterAlpaJuni) }};
        var ItemPDCDaihatsuSunterCutiJuni = {{ json_encode($ItemPDCDaihatsuSunterCutiJuni) }};
        var ItemPDCDaihatsuSunterSakitJuli = {{ json_encode($ItemPDCDaihatsuSunterSakitJuli) }};
        var ItemPDCDaihatsuSunterIjinJuli = {{ json_encode($ItemPDCDaihatsuSunterIjinJuli) }};
        var ItemPDCDaihatsuSunterAlpaJuli = {{ json_encode($ItemPDCDaihatsuSunterAlpaJuli) }};
        var ItemPDCDaihatsuSunterCutiJuli = {{ json_encode($ItemPDCDaihatsuSunterCutiJuli) }};
        var ItemPDCDaihatsuSunterSakitAgustus = {{ json_encode($ItemPDCDaihatsuSunterSakitAgustus) }};
        var ItemPDCDaihatsuSunterIjinAgustus = {{ json_encode($ItemPDCDaihatsuSunterIjinAgustus) }};
        var ItemPDCDaihatsuSunterAlpaAgustus = {{ json_encode($ItemPDCDaihatsuSunterAlpaAgustus) }};
        var ItemPDCDaihatsuSunterCutiAgustus = {{ json_encode($ItemPDCDaihatsuSunterCutiAgustus) }};
        var ItemPDCDaihatsuSunterSakitSeptember = {{ json_encode($ItemPDCDaihatsuSunterSakitSeptember) }};
        var ItemPDCDaihatsuSunterIjinSeptember = {{ json_encode($ItemPDCDaihatsuSunterIjinSeptember) }};
        var ItemPDCDaihatsuSunterAlpaSeptember = {{ json_encode($ItemPDCDaihatsuSunterAlpaSeptember) }};
        var ItemPDCDaihatsuSunterCutiSeptember = {{ json_encode($ItemPDCDaihatsuSunterCutiSeptember) }};
        var ItemPDCDaihatsuSunterSakitOktober = {{ json_encode($ItemPDCDaihatsuSunterSakitOktober) }};
        var ItemPDCDaihatsuSunterIjinOktober = {{ json_encode($ItemPDCDaihatsuSunterIjinOktober) }};
        var ItemPDCDaihatsuSunterAlpaOktober = {{ json_encode($ItemPDCDaihatsuSunterAlpaOktober) }};
        var ItemPDCDaihatsuSunterCutiOktober = {{ json_encode($ItemPDCDaihatsuSunterCutiOktober) }};
        var ItemPDCDaihatsuSunterSakitNovember = {{ json_encode($ItemPDCDaihatsuSunterSakitNovember) }};
        var ItemPDCDaihatsuSunterIjinNovember = {{ json_encode($ItemPDCDaihatsuSunterIjinNovember) }};
        var ItemPDCDaihatsuSunterAlpaNovember = {{ json_encode($ItemPDCDaihatsuSunterAlpaNovember) }};
        var ItemPDCDaihatsuSunterCutiNovember = {{ json_encode($ItemPDCDaihatsuSunterCutiNovember) }};
        var ItemPDCDaihatsuSunterSakitDesember = {{ json_encode($ItemPDCDaihatsuSunterSakitDesember) }};
        var ItemPDCDaihatsuSunterIjinDesember = {{ json_encode($ItemPDCDaihatsuSunterIjinDesember) }};
        var ItemPDCDaihatsuSunterAlpaDesember = {{ json_encode($ItemPDCDaihatsuSunterAlpaDesember) }};
        var ItemPDCDaihatsuSunterCutiDesember = {{ json_encode($ItemPDCDaihatsuSunterCutiDesember) }};

        Highcharts.chart('containerabsensipdc', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'LAPORAN ABSENSI PDC DAIHATSU SUNTER TAHUN 2022'
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
                data: [ItemPDCDaihatsuSunterCutiJanuari, ItemPDCDaihatsuSunterCutiFebruari,
                    ItemPDCDaihatsuSunterCutiMaret, ItemPDCDaihatsuSunterCutiApril,
                    ItemPDCDaihatsuSunterCutiMei, ItemPDCDaihatsuSunterCutiJuni,
                    ItemPDCDaihatsuSunterCutiJuli, ItemPDCDaihatsuSunterCutiAgustus,
                    ItemPDCDaihatsuSunterCutiSeptember, ItemPDCDaihatsuSunterCutiOktober,
                    ItemPDCDaihatsuSunterCutiNovember, ItemPDCDaihatsuSunterCutiDesember
                ]

            }, {
                name: 'Sakit',
                data: [ItemPDCDaihatsuSunterSakitJanuari, ItemPDCDaihatsuSunterSakitFebruari,
                    ItemPDCDaihatsuSunterSakitMaret, ItemPDCDaihatsuSunterSakitApril,
                    ItemPDCDaihatsuSunterSakitMei, ItemPDCDaihatsuSunterSakitJuni,
                    ItemPDCDaihatsuSunterSakitJuli, ItemPDCDaihatsuSunterSakitAgustus,
                    ItemPDCDaihatsuSunterSakitSeptember, ItemPDCDaihatsuSunterSakitOktober,
                    ItemPDCDaihatsuSunterSakitNovember, ItemPDCDaihatsuSunterSakitDesember
                ]

            }, {
                name: 'Ijin',
                data: [ItemPDCDaihatsuSunterIjinJanuari, ItemPDCDaihatsuSunterIjinFebruari,
                    ItemPDCDaihatsuSunterIjinMaret, ItemPDCDaihatsuSunterIjinApril,
                    ItemPDCDaihatsuSunterIjinMei, ItemPDCDaihatsuSunterIjinJuni,
                    ItemPDCDaihatsuSunterIjinJuli, ItemPDCDaihatsuSunterIjinAgustus,
                    ItemPDCDaihatsuSunterIjinSeptember, ItemPDCDaihatsuSunterIjinOktober,
                    ItemPDCDaihatsuSunterIjinNovember, ItemPDCDaihatsuSunterIjinDesember
                ]

            }, {
                name: 'Alpa',
                data: [ItemPDCDaihatsuSunterAlpaJanuari, ItemPDCDaihatsuSunterAlpaFebruari,
                    ItemPDCDaihatsuSunterAlpaMaret, ItemPDCDaihatsuSunterAlpaApril,
                    ItemPDCDaihatsuSunterAlpaMei, ItemPDCDaihatsuSunterAlpaJuni,
                    ItemPDCDaihatsuSunterAlpaJuli, ItemPDCDaihatsuSunterAlpaAgustus,
                    ItemPDCDaihatsuSunterAlpaSeptember, ItemPDCDaihatsuSunterAlpaOktober,
                    ItemPDCDaihatsuSunterAlpaNovember, ItemPDCDaihatsuSunterAlpaDesember
                ]

            }]
        });
    </script>
    {{-- PDC DAIHATSU --}}
@endsection
