@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="containerabsensimarketing"></div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    {{-- Marketing --}}
    <script>
        var ItemMarketingSakitJanuari = {{ json_encode($ItemMarketingSakitJanuari) }};
        var ItemMarketingIjinJanuari = {{ json_encode($ItemMarketingIjinJanuari) }};
        var ItemMarketingAlpaJanuari = {{ json_encode($ItemMarketingAlpaJanuari) }};
        var ItemMarketingCutiJanuari = {{ json_encode($ItemMarketingCutiJanuari) }};
        var ItemMarketingSakitFebruari = {{ json_encode($ItemMarketingSakitFebruari) }};
        var ItemMarketingIjinFebruari = {{ json_encode($ItemMarketingIjinFebruari) }};
        var ItemMarketingAlpaFebruari = {{ json_encode($ItemMarketingAlpaFebruari) }};
        var ItemMarketingCutiFebruari = {{ json_encode($ItemMarketingCutiFebruari) }};
        var ItemMarketingSakitMaret = {{ json_encode($ItemMarketingSakitMaret) }};
        var ItemMarketingIjinMaret = {{ json_encode($ItemMarketingIjinMaret) }};
        var ItemMarketingAlpaMaret = {{ json_encode($ItemMarketingAlpaMaret) }};
        var ItemMarketingCutiMaret = {{ json_encode($ItemMarketingCutiMaret) }};
        var ItemMarketingSakitApril = {{ json_encode($ItemMarketingSakitApril) }};
        var ItemMarketingIjinApril = {{ json_encode($ItemMarketingIjinApril) }};
        var ItemMarketingAlpaApril = {{ json_encode($ItemMarketingAlpaApril) }};
        var ItemMarketingCutiApril = {{ json_encode($ItemMarketingCutiApril) }};
        var ItemMarketingSakitMei = {{ json_encode($ItemMarketingSakitMei) }};
        var ItemMarketingIjinMei = {{ json_encode($ItemMarketingIjinMei) }};
        var ItemMarketingAlpaMei = {{ json_encode($ItemMarketingAlpaMei) }};
        var ItemMarketingCutiMei = {{ json_encode($ItemMarketingCutiMei) }};
        var ItemMarketingSakitJuni = {{ json_encode($ItemMarketingSakitJuni) }};
        var ItemMarketingIjinJuni = {{ json_encode($ItemMarketingIjinJuni) }};
        var ItemMarketingAlpaJuni = {{ json_encode($ItemMarketingAlpaJuni) }};
        var ItemMarketingCutiJuni = {{ json_encode($ItemMarketingCutiJuni) }};
        var ItemMarketingSakitJuli = {{ json_encode($ItemMarketingSakitJuli) }};
        var ItemMarketingIjinJuli = {{ json_encode($ItemMarketingIjinJuli) }};
        var ItemMarketingAlpaJuli = {{ json_encode($ItemMarketingAlpaJuli) }};
        var ItemMarketingCutiJuli = {{ json_encode($ItemMarketingCutiJuli) }};
        var ItemMarketingSakitAgustus = {{ json_encode($ItemMarketingSakitAgustus) }};
        var ItemMarketingIjinAgustus = {{ json_encode($ItemMarketingIjinAgustus) }};
        var ItemMarketingAlpaAgustus = {{ json_encode($ItemMarketingAlpaAgustus) }};
        var ItemMarketingCutiAgustus = {{ json_encode($ItemMarketingCutiAgustus) }};
        var ItemMarketingSakitSeptember = {{ json_encode($ItemMarketingSakitSeptember) }};
        var ItemMarketingIjinSeptember = {{ json_encode($ItemMarketingIjinSeptember) }};
        var ItemMarketingAlpaSeptember = {{ json_encode($ItemMarketingAlpaSeptember) }};
        var ItemMarketingCutiSeptember = {{ json_encode($ItemMarketingCutiSeptember) }};
        var ItemMarketingSakitOktober = {{ json_encode($ItemMarketingSakitOktober) }};
        var ItemMarketingIjinOktober = {{ json_encode($ItemMarketingIjinOktober) }};
        var ItemMarketingAlpaOktober = {{ json_encode($ItemMarketingAlpaOktober) }};
        var ItemMarketingCutiOktober = {{ json_encode($ItemMarketingCutiOktober) }};
        var ItemMarketingSakitNovember = {{ json_encode($ItemMarketingSakitNovember) }};
        var ItemMarketingIjinNovember = {{ json_encode($ItemMarketingIjinNovember) }};
        var ItemMarketingAlpaNovember = {{ json_encode($ItemMarketingAlpaNovember) }};
        var ItemMarketingCutiNovember = {{ json_encode($ItemMarketingCutiNovember) }};
        var ItemMarketingSakitDesember = {{ json_encode($ItemMarketingSakitDesember) }};
        var ItemMarketingIjinDesember = {{ json_encode($ItemMarketingIjinDesember) }};
        var ItemMarketingAlpaDesember = {{ json_encode($ItemMarketingAlpaDesember) }};
        var ItemMarketingCutiDesember = {{ json_encode($ItemMarketingCutiDesember) }};

        Highcharts.chart('containerabsensimarketing', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'LAPORAN ABSENSI MARKETING TAHUN 2023'
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
                data: [ItemMarketingCutiJanuari, ItemMarketingCutiFebruari,
                    ItemMarketingCutiMaret, ItemMarketingCutiApril,
                    ItemMarketingCutiMei, ItemMarketingCutiJuni,
                    ItemMarketingCutiJuli, ItemMarketingCutiAgustus,
                    ItemMarketingCutiSeptember, ItemMarketingCutiOktober,
                    ItemMarketingCutiNovember, ItemMarketingCutiDesember
                ]

            }, {
                name: 'Sakit',
                data: [ItemMarketingSakitJanuari, ItemMarketingSakitFebruari,
                    ItemMarketingSakitMaret, ItemMarketingSakitApril,
                    ItemMarketingSakitMei, ItemMarketingSakitJuni,
                    ItemMarketingSakitJuli, ItemMarketingSakitAgustus,
                    ItemMarketingSakitSeptember, ItemMarketingSakitOktober,
                    ItemMarketingSakitNovember, ItemMarketingSakitDesember
                ]

            }, {
                name: 'Ijin',
                data: [ItemMarketingIjinJanuari, ItemMarketingIjinFebruari,
                    ItemMarketingIjinMaret, ItemMarketingIjinApril,
                    ItemMarketingIjinMei, ItemMarketingIjinJuni,
                    ItemMarketingIjinJuli, ItemMarketingIjinAgustus,
                    ItemMarketingIjinSeptember, ItemMarketingIjinOktober,
                    ItemMarketingIjinNovember, ItemMarketingIjinDesember
                ]

            }, {
                name: 'Alpa',
                data: [ItemMarketingAlpaJanuari, ItemMarketingAlpaFebruari,
                    ItemMarketingAlpaMaret, ItemMarketingAlpaApril,
                    ItemMarketingAlpaMei, ItemMarketingAlpaJuni,
                    ItemMarketingAlpaJuli, ItemMarketingAlpaAgustus,
                    ItemMarketingAlpaSeptember, ItemMarketingAlpaOktober,
                    ItemMarketingAlpaNovember, ItemMarketingAlpaDesember
                ]

            }]
        });
    </script>
    {{-- Marketing --}}
@endsection
