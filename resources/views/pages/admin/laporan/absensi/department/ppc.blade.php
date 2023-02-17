@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="containerabsensippc"></div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    {{-- PPC --}}
    <script>
        var ItemPPCSakitJanuari = {{ json_encode($ItemPPCSakitJanuari) }};
        var ItemPPCIjinJanuari = {{ json_encode($ItemPPCIjinJanuari) }};
        var ItemPPCAlpaJanuari = {{ json_encode($ItemPPCAlpaJanuari) }};
        var ItemPPCCutiJanuari = {{ json_encode($ItemPPCCutiJanuari) }};
        var ItemPPCSakitFebruari = {{ json_encode($ItemPPCSakitFebruari) }};
        var ItemPPCIjinFebruari = {{ json_encode($ItemPPCIjinFebruari) }};
        var ItemPPCAlpaFebruari = {{ json_encode($ItemPPCAlpaFebruari) }};
        var ItemPPCCutiFebruari = {{ json_encode($ItemPPCCutiFebruari) }};
        var ItemPPCSakitMaret = {{ json_encode($ItemPPCSakitMaret) }};
        var ItemPPCIjinMaret = {{ json_encode($ItemPPCIjinMaret) }};
        var ItemPPCAlpaMaret = {{ json_encode($ItemPPCAlpaMaret) }};
        var ItemPPCCutiMaret = {{ json_encode($ItemPPCCutiMaret) }};
        var ItemPPCSakitApril = {{ json_encode($ItemPPCSakitApril) }};
        var ItemPPCIjinApril = {{ json_encode($ItemPPCIjinApril) }};
        var ItemPPCAlpaApril = {{ json_encode($ItemPPCAlpaApril) }};
        var ItemPPCCutiApril = {{ json_encode($ItemPPCCutiApril) }};
        var ItemPPCSakitMei = {{ json_encode($ItemPPCSakitMei) }};
        var ItemPPCIjinMei = {{ json_encode($ItemPPCIjinMei) }};
        var ItemPPCAlpaMei = {{ json_encode($ItemPPCAlpaMei) }};
        var ItemPPCCutiMei = {{ json_encode($ItemPPCCutiMei) }};
        var ItemPPCSakitJuni = {{ json_encode($ItemPPCSakitJuni) }};
        var ItemPPCIjinJuni = {{ json_encode($ItemPPCIjinJuni) }};
        var ItemPPCAlpaJuni = {{ json_encode($ItemPPCAlpaJuni) }};
        var ItemPPCCutiJuni = {{ json_encode($ItemPPCCutiJuni) }};
        var ItemPPCSakitJuli = {{ json_encode($ItemPPCSakitJuli) }};
        var ItemPPCIjinJuli = {{ json_encode($ItemPPCIjinJuli) }};
        var ItemPPCAlpaJuli = {{ json_encode($ItemPPCAlpaJuli) }};
        var ItemPPCCutiJuli = {{ json_encode($ItemPPCCutiJuli) }};
        var ItemPPCSakitAgustus = {{ json_encode($ItemPPCSakitAgustus) }};
        var ItemPPCIjinAgustus = {{ json_encode($ItemPPCIjinAgustus) }};
        var ItemPPCAlpaAgustus = {{ json_encode($ItemPPCAlpaAgustus) }};
        var ItemPPCCutiAgustus = {{ json_encode($ItemPPCCutiAgustus) }};
        var ItemPPCSakitSeptember = {{ json_encode($ItemPPCSakitSeptember) }};
        var ItemPPCIjinSeptember = {{ json_encode($ItemPPCIjinSeptember) }};
        var ItemPPCAlpaSeptember = {{ json_encode($ItemPPCAlpaSeptember) }};
        var ItemPPCCutiSeptember = {{ json_encode($ItemPPCCutiSeptember) }};
        var ItemPPCSakitOktober = {{ json_encode($ItemPPCSakitOktober) }};
        var ItemPPCIjinOktober = {{ json_encode($ItemPPCIjinOktober) }};
        var ItemPPCAlpaOktober = {{ json_encode($ItemPPCAlpaOktober) }};
        var ItemPPCCutiOktober = {{ json_encode($ItemPPCCutiOktober) }};
        var ItemPPCSakitNovember = {{ json_encode($ItemPPCSakitNovember) }};
        var ItemPPCIjinNovember = {{ json_encode($ItemPPCIjinNovember) }};
        var ItemPPCAlpaNovember = {{ json_encode($ItemPPCAlpaNovember) }};
        var ItemPPCCutiNovember = {{ json_encode($ItemPPCCutiNovember) }};
        var ItemPPCSakitDesember = {{ json_encode($ItemPPCSakitDesember) }};
        var ItemPPCIjinDesember = {{ json_encode($ItemPPCIjinDesember) }};
        var ItemPPCAlpaDesember = {{ json_encode($ItemPPCAlpaDesember) }};
        var ItemPPCCutiDesember = {{ json_encode($ItemPPCCutiDesember) }};

        Highcharts.chart('containerabsensippc', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'LAPORAN ABSENSI PPC TAHUN 2023'
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
                data: [ItemPPCCutiJanuari, ItemPPCCutiFebruari,
                    ItemPPCCutiMaret, ItemPPCCutiApril,
                    ItemPPCCutiMei, ItemPPCCutiJuni,
                    ItemPPCCutiJuli, ItemPPCCutiAgustus,
                    ItemPPCCutiSeptember, ItemPPCCutiOktober,
                    ItemPPCCutiNovember, ItemPPCCutiDesember
                ]

            }, {
                name: 'Sakit',
                data: [ItemPPCSakitJanuari, ItemPPCSakitFebruari,
                    ItemPPCSakitMaret, ItemPPCSakitApril,
                    ItemPPCSakitMei, ItemPPCSakitJuni,
                    ItemPPCSakitJuli, ItemPPCSakitAgustus,
                    ItemPPCSakitSeptember, ItemPPCSakitOktober,
                    ItemPPCSakitNovember, ItemPPCSakitDesember
                ]

            }, {
                name: 'Ijin',
                data: [ItemPPCIjinJanuari, ItemPPCIjinFebruari,
                    ItemPPCIjinMaret, ItemPPCIjinApril,
                    ItemPPCIjinMei, ItemPPCIjinJuni,
                    ItemPPCIjinJuli, ItemPPCIjinAgustus,
                    ItemPPCIjinSeptember, ItemPPCIjinOktober,
                    ItemPPCIjinNovember, ItemPPCIjinDesember
                ]

            }, {
                name: 'Alpa',
                data: [ItemPPCAlpaJanuari, ItemPPCAlpaFebruari,
                    ItemPPCAlpaMaret, ItemPPCAlpaApril,
                    ItemPPCAlpaMei, ItemPPCAlpaJuni,
                    ItemPPCAlpaJuli, ItemPPCAlpaAgustus,
                    ItemPPCAlpaSeptember, ItemPPCAlpaOktober,
                    ItemPPCAlpaNovember, ItemPPCAlpaDesember
                ]

            }]
        });
    </script>
    {{-- PPC --}}
@endsection
