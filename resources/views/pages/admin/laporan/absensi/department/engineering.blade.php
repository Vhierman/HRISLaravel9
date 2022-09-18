@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="containerabsensiengineering"></div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    {{-- Engineering --}}
    <script>
        var ItemEngineeringSakitJanuari = {{ json_encode($ItemEngineeringSakitJanuari) }};
        var ItemEngineeringIjinJanuari = {{ json_encode($ItemEngineeringIjinJanuari) }};
        var ItemEngineeringAlpaJanuari = {{ json_encode($ItemEngineeringAlpaJanuari) }};
        var ItemEngineeringCutiJanuari = {{ json_encode($ItemEngineeringCutiJanuari) }};
        var ItemEngineeringSakitFebruari = {{ json_encode($ItemEngineeringSakitFebruari) }};
        var ItemEngineeringIjinFebruari = {{ json_encode($ItemEngineeringIjinFebruari) }};
        var ItemEngineeringAlpaFebruari = {{ json_encode($ItemEngineeringAlpaFebruari) }};
        var ItemEngineeringCutiFebruari = {{ json_encode($ItemEngineeringCutiFebruari) }};
        var ItemEngineeringSakitMaret = {{ json_encode($ItemEngineeringSakitMaret) }};
        var ItemEngineeringIjinMaret = {{ json_encode($ItemEngineeringIjinMaret) }};
        var ItemEngineeringAlpaMaret = {{ json_encode($ItemEngineeringAlpaMaret) }};
        var ItemEngineeringCutiMaret = {{ json_encode($ItemEngineeringCutiMaret) }};
        var ItemEngineeringSakitApril = {{ json_encode($ItemEngineeringSakitApril) }};
        var ItemEngineeringIjinApril = {{ json_encode($ItemEngineeringIjinApril) }};
        var ItemEngineeringAlpaApril = {{ json_encode($ItemEngineeringAlpaApril) }};
        var ItemEngineeringCutiApril = {{ json_encode($ItemEngineeringCutiApril) }};
        var ItemEngineeringSakitMei = {{ json_encode($ItemEngineeringSakitMei) }};
        var ItemEngineeringIjinMei = {{ json_encode($ItemEngineeringIjinMei) }};
        var ItemEngineeringAlpaMei = {{ json_encode($ItemEngineeringAlpaMei) }};
        var ItemEngineeringCutiMei = {{ json_encode($ItemEngineeringCutiMei) }};
        var ItemEngineeringSakitJuni = {{ json_encode($ItemEngineeringSakitJuni) }};
        var ItemEngineeringIjinJuni = {{ json_encode($ItemEngineeringIjinJuni) }};
        var ItemEngineeringAlpaJuni = {{ json_encode($ItemEngineeringAlpaJuni) }};
        var ItemEngineeringCutiJuni = {{ json_encode($ItemEngineeringCutiJuni) }};
        var ItemEngineeringSakitJuli = {{ json_encode($ItemEngineeringSakitJuli) }};
        var ItemEngineeringIjinJuli = {{ json_encode($ItemEngineeringIjinJuli) }};
        var ItemEngineeringAlpaJuli = {{ json_encode($ItemEngineeringAlpaJuli) }};
        var ItemEngineeringCutiJuli = {{ json_encode($ItemEngineeringCutiJuli) }};
        var ItemEngineeringSakitAgustus = {{ json_encode($ItemEngineeringSakitAgustus) }};
        var ItemEngineeringIjinAgustus = {{ json_encode($ItemEngineeringIjinAgustus) }};
        var ItemEngineeringAlpaAgustus = {{ json_encode($ItemEngineeringAlpaAgustus) }};
        var ItemEngineeringCutiAgustus = {{ json_encode($ItemEngineeringCutiAgustus) }};
        var ItemEngineeringSakitSeptember = {{ json_encode($ItemEngineeringSakitSeptember) }};
        var ItemEngineeringIjinSeptember = {{ json_encode($ItemEngineeringIjinSeptember) }};
        var ItemEngineeringAlpaSeptember = {{ json_encode($ItemEngineeringAlpaSeptember) }};
        var ItemEngineeringCutiSeptember = {{ json_encode($ItemEngineeringCutiSeptember) }};
        var ItemEngineeringSakitOktober = {{ json_encode($ItemEngineeringSakitOktober) }};
        var ItemEngineeringIjinOktober = {{ json_encode($ItemEngineeringIjinOktober) }};
        var ItemEngineeringAlpaOktober = {{ json_encode($ItemEngineeringAlpaOktober) }};
        var ItemEngineeringCutiOktober = {{ json_encode($ItemEngineeringCutiOktober) }};
        var ItemEngineeringSakitNovember = {{ json_encode($ItemEngineeringSakitNovember) }};
        var ItemEngineeringIjinNovember = {{ json_encode($ItemEngineeringIjinNovember) }};
        var ItemEngineeringAlpaNovember = {{ json_encode($ItemEngineeringAlpaNovember) }};
        var ItemEngineeringCutiNovember = {{ json_encode($ItemEngineeringCutiNovember) }};
        var ItemEngineeringSakitDesember = {{ json_encode($ItemEngineeringSakitDesember) }};
        var ItemEngineeringIjinDesember = {{ json_encode($ItemEngineeringIjinDesember) }};
        var ItemEngineeringAlpaDesember = {{ json_encode($ItemEngineeringAlpaDesember) }};
        var ItemEngineeringCutiDesember = {{ json_encode($ItemEngineeringCutiDesember) }};

        Highcharts.chart('containerabsensiengineering', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'LAPORAN ABSENSI ENGINEERING TAHUN 2022'
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
                data: [ItemEngineeringCutiJanuari, ItemEngineeringCutiFebruari,
                    ItemEngineeringCutiMaret, ItemEngineeringCutiApril,
                    ItemEngineeringCutiMei, ItemEngineeringCutiJuni,
                    ItemEngineeringCutiJuli, ItemEngineeringCutiAgustus,
                    ItemEngineeringCutiSeptember, ItemEngineeringCutiOktober,
                    ItemEngineeringCutiNovember, ItemEngineeringCutiDesember
                ]

            }, {
                name: 'Sakit',
                data: [ItemEngineeringSakitJanuari, ItemEngineeringSakitFebruari,
                    ItemEngineeringSakitMaret, ItemEngineeringSakitApril,
                    ItemEngineeringSakitMei, ItemEngineeringSakitJuni,
                    ItemEngineeringSakitJuli, ItemEngineeringSakitAgustus,
                    ItemEngineeringSakitSeptember, ItemEngineeringSakitOktober,
                    ItemEngineeringSakitNovember, ItemEngineeringSakitDesember
                ]

            }, {
                name: 'Ijin',
                data: [ItemEngineeringIjinJanuari, ItemEngineeringIjinFebruari,
                    ItemEngineeringIjinMaret, ItemEngineeringIjinApril,
                    ItemEngineeringIjinMei, ItemEngineeringIjinJuni,
                    ItemEngineeringIjinJuli, ItemEngineeringIjinAgustus,
                    ItemEngineeringIjinSeptember, ItemEngineeringIjinOktober,
                    ItemEngineeringIjinNovember, ItemEngineeringIjinDesember
                ]

            }, {
                name: 'Alpa',
                data: [ItemEngineeringAlpaJanuari, ItemEngineeringAlpaFebruari,
                    ItemEngineeringAlpaMaret, ItemEngineeringAlpaApril,
                    ItemEngineeringAlpaMei, ItemEngineeringAlpaJuni,
                    ItemEngineeringAlpaJuli, ItemEngineeringAlpaAgustus,
                    ItemEngineeringAlpaSeptember, ItemEngineeringAlpaOktober,
                    ItemEngineeringAlpaNovember, ItemEngineeringAlpaDesember
                ]

            }]
        });
    </script>
    {{-- Engineering --}}
@endsection
