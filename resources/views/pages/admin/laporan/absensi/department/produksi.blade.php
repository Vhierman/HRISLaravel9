@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="containerabsensiproduksi"></div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    {{-- Produksi --}}
    <script>
        var ItemProduksiSakitJanuari = {{ json_encode($ItemProduksiSakitJanuari) }};
        var ItemProduksiIjinJanuari = {{ json_encode($ItemProduksiIjinJanuari) }};
        var ItemProduksiAlpaJanuari = {{ json_encode($ItemProduksiAlpaJanuari) }};
        var ItemProduksiCutiJanuari = {{ json_encode($ItemProduksiCutiJanuari) }};
        var ItemProduksiSakitFebruari = {{ json_encode($ItemProduksiSakitFebruari) }};
        var ItemProduksiIjinFebruari = {{ json_encode($ItemProduksiIjinFebruari) }};
        var ItemProduksiAlpaFebruari = {{ json_encode($ItemProduksiAlpaFebruari) }};
        var ItemProduksiCutiFebruari = {{ json_encode($ItemProduksiCutiFebruari) }};
        var ItemProduksiSakitMaret = {{ json_encode($ItemProduksiSakitMaret) }};
        var ItemProduksiIjinMaret = {{ json_encode($ItemProduksiIjinMaret) }};
        var ItemProduksiAlpaMaret = {{ json_encode($ItemProduksiAlpaMaret) }};
        var ItemProduksiCutiMaret = {{ json_encode($ItemProduksiCutiMaret) }};
        var ItemProduksiSakitApril = {{ json_encode($ItemProduksiSakitApril) }};
        var ItemProduksiIjinApril = {{ json_encode($ItemProduksiIjinApril) }};
        var ItemProduksiAlpaApril = {{ json_encode($ItemProduksiAlpaApril) }};
        var ItemProduksiCutiApril = {{ json_encode($ItemProduksiCutiApril) }};
        var ItemProduksiSakitMei = {{ json_encode($ItemProduksiSakitMei) }};
        var ItemProduksiIjinMei = {{ json_encode($ItemProduksiIjinMei) }};
        var ItemProduksiAlpaMei = {{ json_encode($ItemProduksiAlpaMei) }};
        var ItemProduksiCutiMei = {{ json_encode($ItemProduksiCutiMei) }};
        var ItemProduksiSakitJuni = {{ json_encode($ItemProduksiSakitJuni) }};
        var ItemProduksiIjinJuni = {{ json_encode($ItemProduksiIjinJuni) }};
        var ItemProduksiAlpaJuni = {{ json_encode($ItemProduksiAlpaJuni) }};
        var ItemProduksiCutiJuni = {{ json_encode($ItemProduksiCutiJuni) }};
        var ItemProduksiSakitJuli = {{ json_encode($ItemProduksiSakitJuli) }};
        var ItemProduksiIjinJuli = {{ json_encode($ItemProduksiIjinJuli) }};
        var ItemProduksiAlpaJuli = {{ json_encode($ItemProduksiAlpaJuli) }};
        var ItemProduksiCutiJuli = {{ json_encode($ItemProduksiCutiJuli) }};
        var ItemProduksiSakitAgustus = {{ json_encode($ItemProduksiSakitAgustus) }};
        var ItemProduksiIjinAgustus = {{ json_encode($ItemProduksiIjinAgustus) }};
        var ItemProduksiAlpaAgustus = {{ json_encode($ItemProduksiAlpaAgustus) }};
        var ItemProduksiCutiAgustus = {{ json_encode($ItemProduksiCutiAgustus) }};
        var ItemProduksiSakitSeptember = {{ json_encode($ItemProduksiSakitSeptember) }};
        var ItemProduksiIjinSeptember = {{ json_encode($ItemProduksiIjinSeptember) }};
        var ItemProduksiAlpaSeptember = {{ json_encode($ItemProduksiAlpaSeptember) }};
        var ItemProduksiCutiSeptember = {{ json_encode($ItemProduksiCutiSeptember) }};
        var ItemProduksiSakitOktober = {{ json_encode($ItemProduksiSakitOktober) }};
        var ItemProduksiIjinOktober = {{ json_encode($ItemProduksiIjinOktober) }};
        var ItemProduksiAlpaOktober = {{ json_encode($ItemProduksiAlpaOktober) }};
        var ItemProduksiCutiOktober = {{ json_encode($ItemProduksiCutiOktober) }};
        var ItemProduksiSakitNovember = {{ json_encode($ItemProduksiSakitNovember) }};
        var ItemProduksiIjinNovember = {{ json_encode($ItemProduksiIjinNovember) }};
        var ItemProduksiAlpaNovember = {{ json_encode($ItemProduksiAlpaNovember) }};
        var ItemProduksiCutiNovember = {{ json_encode($ItemProduksiCutiNovember) }};
        var ItemProduksiSakitDesember = {{ json_encode($ItemProduksiSakitDesember) }};
        var ItemProduksiIjinDesember = {{ json_encode($ItemProduksiIjinDesember) }};
        var ItemProduksiAlpaDesember = {{ json_encode($ItemProduksiAlpaDesember) }};
        var ItemProduksiCutiDesember = {{ json_encode($ItemProduksiCutiDesember) }};

        Highcharts.chart('containerabsensiproduksi', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'LAPORAN ABSENSI PRODUKSI TAHUN 2022'
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
                data: [ItemProduksiCutiJanuari, ItemProduksiCutiFebruari,
                    ItemProduksiCutiMaret, ItemProduksiCutiApril,
                    ItemProduksiCutiMei, ItemProduksiCutiJuni,
                    ItemProduksiCutiJuli, ItemProduksiCutiAgustus,
                    ItemProduksiCutiSeptember, ItemProduksiCutiOktober,
                    ItemProduksiCutiNovember, ItemProduksiCutiDesember
                ]

            }, {
                name: 'Sakit',
                data: [ItemProduksiSakitJanuari, ItemProduksiSakitFebruari,
                    ItemProduksiSakitMaret, ItemProduksiSakitApril,
                    ItemProduksiSakitMei, ItemProduksiSakitJuni,
                    ItemProduksiSakitJuli, ItemProduksiSakitAgustus,
                    ItemProduksiSakitSeptember, ItemProduksiSakitOktober,
                    ItemProduksiSakitNovember, ItemProduksiSakitDesember
                ]

            }, {
                name: 'Ijin',
                data: [ItemProduksiIjinJanuari, ItemProduksiIjinFebruari,
                    ItemProduksiIjinMaret, ItemProduksiIjinApril,
                    ItemProduksiIjinMei, ItemProduksiIjinJuni,
                    ItemProduksiIjinJuli, ItemProduksiIjinAgustus,
                    ItemProduksiIjinSeptember, ItemProduksiIjinOktober,
                    ItemProduksiIjinNovember, ItemProduksiIjinDesember
                ]

            }, {
                name: 'Alpa',
                data: [ItemProduksiAlpaJanuari, ItemProduksiAlpaFebruari,
                    ItemProduksiAlpaMaret, ItemProduksiAlpaApril,
                    ItemProduksiAlpaMei, ItemProduksiAlpaJuni,
                    ItemProduksiAlpaJuli, ItemProduksiAlpaAgustus,
                    ItemProduksiAlpaSeptember, ItemProduksiAlpaOktober,
                    ItemProduksiAlpaNovember, ItemProduksiAlpaDesember
                ]

            }]
        });
    </script>
    {{-- Produksi --}}
@endsection
