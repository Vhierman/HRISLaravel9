@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="containerabsensihrdgadc"></div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    {{-- HRDGADC --}}
    <script>
        var ItemHRDGADCSakitJanuari = {{ json_encode($ItemHRDGADCSakitJanuari) }};
        var ItemHRDGADCIjinJanuari = {{ json_encode($ItemHRDGADCIjinJanuari) }};
        var ItemHRDGADCAlpaJanuari = {{ json_encode($ItemHRDGADCAlpaJanuari) }};
        var ItemHRDGADCCutiJanuari = {{ json_encode($ItemHRDGADCCutiJanuari) }};
        var ItemHRDGADCSakitFebruari = {{ json_encode($ItemHRDGADCSakitFebruari) }};
        var ItemHRDGADCIjinFebruari = {{ json_encode($ItemHRDGADCIjinFebruari) }};
        var ItemHRDGADCAlpaFebruari = {{ json_encode($ItemHRDGADCAlpaFebruari) }};
        var ItemHRDGADCCutiFebruari = {{ json_encode($ItemHRDGADCCutiFebruari) }};
        var ItemHRDGADCSakitMaret = {{ json_encode($ItemHRDGADCSakitMaret) }};
        var ItemHRDGADCIjinMaret = {{ json_encode($ItemHRDGADCIjinMaret) }};
        var ItemHRDGADCAlpaMaret = {{ json_encode($ItemHRDGADCAlpaMaret) }};
        var ItemHRDGADCCutiMaret = {{ json_encode($ItemHRDGADCCutiMaret) }};
        var ItemHRDGADCSakitApril = {{ json_encode($ItemHRDGADCSakitApril) }};
        var ItemHRDGADCIjinApril = {{ json_encode($ItemHRDGADCIjinApril) }};
        var ItemHRDGADCAlpaApril = {{ json_encode($ItemHRDGADCAlpaApril) }};
        var ItemHRDGADCCutiApril = {{ json_encode($ItemHRDGADCCutiApril) }};
        var ItemHRDGADCSakitMei = {{ json_encode($ItemHRDGADCSakitMei) }};
        var ItemHRDGADCIjinMei = {{ json_encode($ItemHRDGADCIjinMei) }};
        var ItemHRDGADCAlpaMei = {{ json_encode($ItemHRDGADCAlpaMei) }};
        var ItemHRDGADCCutiMei = {{ json_encode($ItemHRDGADCCutiMei) }};
        var ItemHRDGADCSakitJuni = {{ json_encode($ItemHRDGADCSakitJuni) }};
        var ItemHRDGADCIjinJuni = {{ json_encode($ItemHRDGADCIjinJuni) }};
        var ItemHRDGADCAlpaJuni = {{ json_encode($ItemHRDGADCAlpaJuni) }};
        var ItemHRDGADCCutiJuni = {{ json_encode($ItemHRDGADCCutiJuni) }};
        var ItemHRDGADCSakitJuli = {{ json_encode($ItemHRDGADCSakitJuli) }};
        var ItemHRDGADCIjinJuli = {{ json_encode($ItemHRDGADCIjinJuli) }};
        var ItemHRDGADCAlpaJuli = {{ json_encode($ItemHRDGADCAlpaJuli) }};
        var ItemHRDGADCCutiJuli = {{ json_encode($ItemHRDGADCCutiJuli) }};
        var ItemHRDGADCSakitAgustus = {{ json_encode($ItemHRDGADCSakitAgustus) }};
        var ItemHRDGADCIjinAgustus = {{ json_encode($ItemHRDGADCIjinAgustus) }};
        var ItemHRDGADCAlpaAgustus = {{ json_encode($ItemHRDGADCAlpaAgustus) }};
        var ItemHRDGADCCutiAgustus = {{ json_encode($ItemHRDGADCCutiAgustus) }};
        var ItemHRDGADCSakitSeptember = {{ json_encode($ItemHRDGADCSakitSeptember) }};
        var ItemHRDGADCIjinSeptember = {{ json_encode($ItemHRDGADCIjinSeptember) }};
        var ItemHRDGADCAlpaSeptember = {{ json_encode($ItemHRDGADCAlpaSeptember) }};
        var ItemHRDGADCCutiSeptember = {{ json_encode($ItemHRDGADCCutiSeptember) }};
        var ItemHRDGADCSakitOktober = {{ json_encode($ItemHRDGADCSakitOktober) }};
        var ItemHRDGADCIjinOktober = {{ json_encode($ItemHRDGADCIjinOktober) }};
        var ItemHRDGADCAlpaOktober = {{ json_encode($ItemHRDGADCAlpaOktober) }};
        var ItemHRDGADCCutiOktober = {{ json_encode($ItemHRDGADCCutiOktober) }};
        var ItemHRDGADCSakitNovember = {{ json_encode($ItemHRDGADCSakitNovember) }};
        var ItemHRDGADCIjinNovember = {{ json_encode($ItemHRDGADCIjinNovember) }};
        var ItemHRDGADCAlpaNovember = {{ json_encode($ItemHRDGADCAlpaNovember) }};
        var ItemHRDGADCCutiNovember = {{ json_encode($ItemHRDGADCCutiNovember) }};
        var ItemHRDGADCSakitDesember = {{ json_encode($ItemHRDGADCSakitDesember) }};
        var ItemHRDGADCIjinDesember = {{ json_encode($ItemHRDGADCIjinDesember) }};
        var ItemHRDGADCAlpaDesember = {{ json_encode($ItemHRDGADCAlpaDesember) }};
        var ItemHRDGADCCutiDesember = {{ json_encode($ItemHRDGADCCutiDesember) }};

        Highcharts.chart('containerabsensihrdgadc', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'LAPORAN ABSENSI HRD-GA, DOCUMENT CONTROL TAHUN 2023'
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
                data: [ItemHRDGADCCutiJanuari, ItemHRDGADCCutiFebruari,
                    ItemHRDGADCCutiMaret, ItemHRDGADCCutiApril,
                    ItemHRDGADCCutiMei, ItemHRDGADCCutiJuni,
                    ItemHRDGADCCutiJuli, ItemHRDGADCCutiAgustus,
                    ItemHRDGADCCutiSeptember, ItemHRDGADCCutiOktober,
                    ItemHRDGADCCutiNovember, ItemHRDGADCCutiDesember
                ]

            }, {
                name: 'Sakit',
                data: [ItemHRDGADCSakitJanuari, ItemHRDGADCSakitFebruari,
                    ItemHRDGADCSakitMaret, ItemHRDGADCSakitApril,
                    ItemHRDGADCSakitMei, ItemHRDGADCSakitJuni,
                    ItemHRDGADCSakitJuli, ItemHRDGADCSakitAgustus,
                    ItemHRDGADCSakitSeptember, ItemHRDGADCSakitOktober,
                    ItemHRDGADCSakitNovember, ItemHRDGADCSakitDesember
                ]

            }, {
                name: 'Ijin',
                data: [ItemHRDGADCIjinJanuari, ItemHRDGADCIjinFebruari,
                    ItemHRDGADCIjinMaret, ItemHRDGADCIjinApril,
                    ItemHRDGADCIjinMei, ItemHRDGADCIjinJuni,
                    ItemHRDGADCIjinJuli, ItemHRDGADCIjinAgustus,
                    ItemHRDGADCIjinSeptember, ItemHRDGADCIjinOktober,
                    ItemHRDGADCIjinNovember, ItemHRDGADCIjinDesember
                ]

            }, {
                name: 'Alpa',
                data: [ItemHRDGADCAlpaJanuari, ItemHRDGADCAlpaFebruari,
                    ItemHRDGADCAlpaMaret, ItemHRDGADCAlpaApril,
                    ItemHRDGADCAlpaMei, ItemHRDGADCAlpaJuni,
                    ItemHRDGADCAlpaJuli, ItemHRDGADCAlpaAgustus,
                    ItemHRDGADCAlpaSeptember, ItemHRDGADCAlpaOktober,
                    ItemHRDGADCAlpaNovember, ItemHRDGADCAlpaDesember
                ]

            }]
        });
    </script>
    {{-- HRDGADC --}}
@endsection
