@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="containerabsensipurchasing"></div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    {{-- Purchasing --}}
    <script>
        var ItemPurchasingSakitJanuari = {{ json_encode($ItemPurchasingSakitJanuari) }};
        var ItemPurchasingIjinJanuari = {{ json_encode($ItemPurchasingIjinJanuari) }};
        var ItemPurchasingAlpaJanuari = {{ json_encode($ItemPurchasingAlpaJanuari) }};
        var ItemPurchasingCutiJanuari = {{ json_encode($ItemPurchasingCutiJanuari) }};
        var ItemPurchasingSakitFebruari = {{ json_encode($ItemPurchasingSakitFebruari) }};
        var ItemPurchasingIjinFebruari = {{ json_encode($ItemPurchasingIjinFebruari) }};
        var ItemPurchasingAlpaFebruari = {{ json_encode($ItemPurchasingAlpaFebruari) }};
        var ItemPurchasingCutiFebruari = {{ json_encode($ItemPurchasingCutiFebruari) }};
        var ItemPurchasingSakitMaret = {{ json_encode($ItemPurchasingSakitMaret) }};
        var ItemPurchasingIjinMaret = {{ json_encode($ItemPurchasingIjinMaret) }};
        var ItemPurchasingAlpaMaret = {{ json_encode($ItemPurchasingAlpaMaret) }};
        var ItemPurchasingCutiMaret = {{ json_encode($ItemPurchasingCutiMaret) }};
        var ItemPurchasingSakitApril = {{ json_encode($ItemPurchasingSakitApril) }};
        var ItemPurchasingIjinApril = {{ json_encode($ItemPurchasingIjinApril) }};
        var ItemPurchasingAlpaApril = {{ json_encode($ItemPurchasingAlpaApril) }};
        var ItemPurchasingCutiApril = {{ json_encode($ItemPurchasingCutiApril) }};
        var ItemPurchasingSakitMei = {{ json_encode($ItemPurchasingSakitMei) }};
        var ItemPurchasingIjinMei = {{ json_encode($ItemPurchasingIjinMei) }};
        var ItemPurchasingAlpaMei = {{ json_encode($ItemPurchasingAlpaMei) }};
        var ItemPurchasingCutiMei = {{ json_encode($ItemPurchasingCutiMei) }};
        var ItemPurchasingSakitJuni = {{ json_encode($ItemPurchasingSakitJuni) }};
        var ItemPurchasingIjinJuni = {{ json_encode($ItemPurchasingIjinJuni) }};
        var ItemPurchasingAlpaJuni = {{ json_encode($ItemPurchasingAlpaJuni) }};
        var ItemPurchasingCutiJuni = {{ json_encode($ItemPurchasingCutiJuni) }};
        var ItemPurchasingSakitJuli = {{ json_encode($ItemPurchasingSakitJuli) }};
        var ItemPurchasingIjinJuli = {{ json_encode($ItemPurchasingIjinJuli) }};
        var ItemPurchasingAlpaJuli = {{ json_encode($ItemPurchasingAlpaJuli) }};
        var ItemPurchasingCutiJuli = {{ json_encode($ItemPurchasingCutiJuli) }};
        var ItemPurchasingSakitAgustus = {{ json_encode($ItemPurchasingSakitAgustus) }};
        var ItemPurchasingIjinAgustus = {{ json_encode($ItemPurchasingIjinAgustus) }};
        var ItemPurchasingAlpaAgustus = {{ json_encode($ItemPurchasingAlpaAgustus) }};
        var ItemPurchasingCutiAgustus = {{ json_encode($ItemPurchasingCutiAgustus) }};
        var ItemPurchasingSakitSeptember = {{ json_encode($ItemPurchasingSakitSeptember) }};
        var ItemPurchasingIjinSeptember = {{ json_encode($ItemPurchasingIjinSeptember) }};
        var ItemPurchasingAlpaSeptember = {{ json_encode($ItemPurchasingAlpaSeptember) }};
        var ItemPurchasingCutiSeptember = {{ json_encode($ItemPurchasingCutiSeptember) }};
        var ItemPurchasingSakitOktober = {{ json_encode($ItemPurchasingSakitOktober) }};
        var ItemPurchasingIjinOktober = {{ json_encode($ItemPurchasingIjinOktober) }};
        var ItemPurchasingAlpaOktober = {{ json_encode($ItemPurchasingAlpaOktober) }};
        var ItemPurchasingCutiOktober = {{ json_encode($ItemPurchasingCutiOktober) }};
        var ItemPurchasingSakitNovember = {{ json_encode($ItemPurchasingSakitNovember) }};
        var ItemPurchasingIjinNovember = {{ json_encode($ItemPurchasingIjinNovember) }};
        var ItemPurchasingAlpaNovember = {{ json_encode($ItemPurchasingAlpaNovember) }};
        var ItemPurchasingCutiNovember = {{ json_encode($ItemPurchasingCutiNovember) }};
        var ItemPurchasingSakitDesember = {{ json_encode($ItemPurchasingSakitDesember) }};
        var ItemPurchasingIjinDesember = {{ json_encode($ItemPurchasingIjinDesember) }};
        var ItemPurchasingAlpaDesember = {{ json_encode($ItemPurchasingAlpaDesember) }};
        var ItemPurchasingCutiDesember = {{ json_encode($ItemPurchasingCutiDesember) }};

        Highcharts.chart('containerabsensipurchasing', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'LAPORAN ABSENSI PURCHASING TAHUN 2022'
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
                data: [ItemPurchasingCutiJanuari, ItemPurchasingCutiFebruari,
                    ItemPurchasingCutiMaret, ItemPurchasingCutiApril,
                    ItemPurchasingCutiMei, ItemPurchasingCutiJuni,
                    ItemPurchasingCutiJuli, ItemPurchasingCutiAgustus,
                    ItemPurchasingCutiSeptember, ItemPurchasingCutiOktober,
                    ItemPurchasingCutiNovember, ItemPurchasingCutiDesember
                ]

            }, {
                name: 'Sakit',
                data: [ItemPurchasingSakitJanuari, ItemPurchasingSakitFebruari,
                    ItemPurchasingSakitMaret, ItemPurchasingSakitApril,
                    ItemPurchasingSakitMei, ItemPurchasingSakitJuni,
                    ItemPurchasingSakitJuli, ItemPurchasingSakitAgustus,
                    ItemPurchasingSakitSeptember, ItemPurchasingSakitOktober,
                    ItemPurchasingSakitNovember, ItemPurchasingSakitDesember
                ]

            }, {
                name: 'Ijin',
                data: [ItemPurchasingIjinJanuari, ItemPurchasingIjinFebruari,
                    ItemPurchasingIjinMaret, ItemPurchasingIjinApril,
                    ItemPurchasingIjinMei, ItemPurchasingIjinJuni,
                    ItemPurchasingIjinJuli, ItemPurchasingIjinAgustus,
                    ItemPurchasingIjinSeptember, ItemPurchasingIjinOktober,
                    ItemPurchasingIjinNovember, ItemPurchasingIjinDesember
                ]

            }, {
                name: 'Alpa',
                data: [ItemPurchasingAlpaJanuari, ItemPurchasingAlpaFebruari,
                    ItemPurchasingAlpaMaret, ItemPurchasingAlpaApril,
                    ItemPurchasingAlpaMei, ItemPurchasingAlpaJuni,
                    ItemPurchasingAlpaJuli, ItemPurchasingAlpaAgustus,
                    ItemPurchasingAlpaSeptember, ItemPurchasingAlpaOktober,
                    ItemPurchasingAlpaNovember, ItemPurchasingAlpaDesember
                ]

            }]
        });
    </script>
    {{-- Purchasing --}}
@endsection
