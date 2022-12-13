@extends('layouts.admin')
@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="containerovertimespdc"></div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>


    <script>
        var ItemPDCApril = {{ json_encode($ItemPDCApril) }};
        var ItemPDCMei = {{ json_encode($ItemPDCMei) }};
        var ItemPDCJuni = {{ json_encode($ItemPDCJuni) }};
        var ItemPDCJuli = {{ json_encode($ItemPDCJuli) }};
        var ItemPDCAgustus = {{ json_encode($ItemPDCAgustus) }};
        var ItemPDCSeptember = {{ json_encode($ItemPDCSeptember) }};
        var ItemPDCOktober = {{ json_encode($ItemPDCOktober) }};
        var ItemPDCNovember = {{ json_encode($ItemPDCNovember) }};
        // var ItemBSDApril = {{ json_encode($ItemBSDApril) }};
        // var ItemBSDMei = {{ json_encode($ItemBSDMei) }};
        // var ItemBSDJuni = {{ json_encode($ItemBSDJuni) }};
        // var ItemBSDJuli = {{ json_encode($ItemBSDJuli) }};
        // var ItemBSDAgustus = {{ json_encode($ItemBSDAgustus) }};
        // var ItemBSDSeptember = {{ json_encode($ItemBSDSeptember) }};
        // var ItemBSDOktober = {{ json_encode($ItemBSDOktober) }};
        // var ItemBSDNovember = {{ json_encode($ItemBSDNovember) }};


        Highcharts.chart('containerovertimespdc', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Chart Overtimes PDC TAHUN 2022'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'APRIL',
                    'MEI',
                    'JUNI',
                    'JULI',
                    'AGUSTUS',
                    'SEPTEMBER',
                    'OKTOBER',
                    'NOVEMBER'
                ],
                crosshair: true
            },
            yAxis: {
                title: {
                    useHTML: true,
                    text: 'Rupiah'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:1f}</b></td></tr>',
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
            series: [{
                name: 'PDC',
                data: [ItemPDCApril, ItemPDCMei, ItemBSDJuni, ItemPDCJuli, ItemPDCAgustus, ItemPDCSeptember,
                    ItemPDCOktober, ItemPDCNovember
                ]

            }, {
                name: 'BSD',
                data: [1, 2, 3, 4, 5, 6, 7, 8]

            }]
        });
    </script>
@endsection
