@extends('layouts.admin')
@section('content')
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="container"></div>
                    </div>
                </div>
            </div>
        </main>

        {{-- End Content --}}
    </div>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    {{-- comm --}}
    <script>
        var TahunOvertimes = {{ $TahunOvertimes }};
        var ProduksiJanuari = {{ json_encode($ProduksiJanuari) }};
        var PDCJanuari = {{ json_encode($PDCJanuari) }};
        var WarehouseJanuari = {{ json_encode($WarehouseJanuari) }};
        var DeliveryJanuari = {{ json_encode($DeliveryJanuari) }};
        var QualityJanuari = {{ json_encode($QualityJanuari) }};
        var PPCJanuari = {{ json_encode($PPCJanuari) }};
        var AccIcItHrdDcMktEngPurcJanuari = {{ json_encode($AccIcItHrdDcMktEngPurcJanuari) }};
        var ProduksiFebruari = {{ json_encode($ProduksiFebruari) }};
        var PDCFebruari = {{ json_encode($PDCFebruari) }};
        var WarehouseFebruari = {{ json_encode($WarehouseFebruari) }};
        var DeliveryFebruari = {{ json_encode($DeliveryFebruari) }};
        var QualityFebruari = {{ json_encode($QualityFebruari) }};
        var PPCFebruari = {{ json_encode($PPCFebruari) }};
        var AccIcItHrdDcMktEngPurcFebruari = {{ json_encode($AccIcItHrdDcMktEngPurcFebruari) }};
        var ProduksiMaret = {{ json_encode($ProduksiMaret) }};
        var PDCMaret = {{ json_encode($PDCMaret) }};
        var WarehouseMaret = {{ json_encode($WarehouseMaret) }};
        var DeliveryMaret = {{ json_encode($DeliveryMaret) }};
        var QualityMaret = {{ json_encode($QualityMaret) }};
        var PPCMaret = {{ json_encode($PPCMaret) }};
        var AccIcItHrdDcMktEngPurcMaret = {{ json_encode($AccIcItHrdDcMktEngPurcMaret) }};
        var ProduksiApril = {{ json_encode($ProduksiApril) }};
        var PDCApril = {{ json_encode($PDCApril) }};
        var WarehouseApril = {{ json_encode($WarehouseApril) }};
        var DeliveryApril = {{ json_encode($DeliveryApril) }};
        var QualityApril = {{ json_encode($QualityApril) }};
        var PPCApril = {{ json_encode($PPCApril) }};
        var AccIcItHrdDcMktEngPurcApril = {{ json_encode($AccIcItHrdDcMktEngPurcApril) }};
        var ProduksiMei = {{ json_encode($ProduksiMei) }};
        var PDCMei = {{ json_encode($PDCMei) }};
        var WarehouseMei = {{ json_encode($WarehouseMei) }};
        var DeliveryMei = {{ json_encode($DeliveryMei) }};
        var QualityMei = {{ json_encode($QualityMei) }};
        var PPCMei = {{ json_encode($PPCMei) }};
        var AccIcItHrdDcMktEngPurcMei = {{ json_encode($AccIcItHrdDcMktEngPurcMei) }};
        var ProduksiJuni = {{ json_encode($ProduksiJuni) }};
        var PDCJuni = {{ json_encode($PDCJuni) }};
        var WarehouseJuni = {{ json_encode($WarehouseJuni) }};
        var DeliveryJuni = {{ json_encode($DeliveryJuni) }};
        var QualityJuni = {{ json_encode($QualityJuni) }};
        var PPCJuni = {{ json_encode($PPCJuni) }};
        var AccIcItHrdDcMktEngPurcJuni = {{ json_encode($AccIcItHrdDcMktEngPurcJuni) }};
        var ProduksiJuli = {{ json_encode($ProduksiJuli) }};
        var PDCJuli = {{ json_encode($PDCJuli) }};
        var WarehouseJuli = {{ json_encode($WarehouseJuli) }};
        var DeliveryJuli = {{ json_encode($DeliveryJuli) }};
        var QualityJuli = {{ json_encode($QualityJuli) }};
        var PPCJuli = {{ json_encode($PPCJuli) }};
        var AccIcItHrdDcMktEngPurcJuli = {{ json_encode($AccIcItHrdDcMktEngPurcJuli) }};
        var ProduksiAgustus = {{ json_encode($ProduksiAgustus) }};
        var PDCAgustus = {{ json_encode($PDCAgustus) }};
        var WarehouseAgustus = {{ json_encode($WarehouseAgustus) }};
        var DeliveryAgustus = {{ json_encode($DeliveryAgustus) }};
        var QualityAgustus = {{ json_encode($QualityAgustus) }};
        var PPCAgustus = {{ json_encode($PPCAgustus) }};
        var AccIcItHrdDcMktEngPurcAgustus = {{ json_encode($AccIcItHrdDcMktEngPurcAgustus) }};
        var ProduksiSeptember = {{ json_encode($ProduksiSeptember) }};
        var PDCSeptember = {{ json_encode($PDCSeptember) }};
        var WarehouseSeptember = {{ json_encode($WarehouseSeptember) }};
        var DeliverySeptember = {{ json_encode($DeliverySeptember) }};
        var QualitySeptember = {{ json_encode($QualitySeptember) }};
        var PPCSeptember = {{ json_encode($PPCSeptember) }};
        var AccIcItHrdDcMktEngPurcSeptember = {{ json_encode($AccIcItHrdDcMktEngPurcSeptember) }};
        var ProduksiOktober = {{ json_encode($ProduksiOktober) }};
        var PDCOktober = {{ json_encode($PDCOktober) }};
        var WarehouseOktober = {{ json_encode($WarehouseOktober) }};
        var DeliveryOktober = {{ json_encode($DeliveryOktober) }};
        var QualityOktober = {{ json_encode($QualityOktober) }};
        var PPCOktober = {{ json_encode($PPCOktober) }};
        var AccIcItHrdDcMktEngPurcOktober = {{ json_encode($AccIcItHrdDcMktEngPurcOktober) }};
        var ProduksiNovember = {{ json_encode($ProduksiNovember) }};
        var PDCNovember = {{ json_encode($PDCNovember) }};
        var WarehouseNovember = {{ json_encode($WarehouseNovember) }};
        var DeliveryNovember = {{ json_encode($DeliveryNovember) }};
        var QualityNovember = {{ json_encode($QualityNovember) }};
        var PPCNovember = {{ json_encode($PPCNovember) }};
        var AccIcItHrdDcMktEngPurcNovember = {{ json_encode($AccIcItHrdDcMktEngPurcNovember) }};
        var ProduksiDesember = {{ json_encode($ProduksiDesember) }};
        var PDCDesember = {{ json_encode($PDCDesember) }};
        var WarehouseDesember = {{ json_encode($WarehouseDesember) }};
        var DeliveryDesember = {{ json_encode($DeliveryDesember) }};
        var QualityDesember = {{ json_encode($QualityDesember) }};
        var PPCDesember = {{ json_encode($PPCDesember) }};
        var AccIcItHrdDcMktEngPurcDesember = {{ json_encode($AccIcItHrdDcMktEngPurcDesember) }};

        Highcharts.chart('container', {
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Rekap Overtime Tahun ' + TahunOvertimes
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ],
                accessibility: {
                    description: 'Overtimes of the year'
                }
            },
            yAxis: {
                title: {
                    text: 'Dalam Satuan JAM'
                },
                labels: {
                    format: '{value}'
                }
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Produksi',
                marker: {
                    symbol: 'square'
                },
                data: [ProduksiJanuari, ProduksiFebruari, ProduksiMaret, ProduksiApril, ProduksiMei,
                    ProduksiJuni, ProduksiJuli, ProduksiAgustus, ProduksiSeptember, ProduksiOktober,
                    ProduksiNovember, ProduksiDesember
                ]

            }, {
                name: 'PDC Daihatsu',
                marker: {
                    symbol: 'square'
                },
                data: [PDCJanuari, PDCFebruari, PDCMaret, PDCApril, PDCMei, PDCJuni, PDCJuli, PDCAgustus,
                    PDCSeptember, PDCOktober, PDCNovember, PDCDesember
                ]
            }, {
                name: 'Warehouse',
                marker: {
                    symbol: 'square'
                },
                data: [WarehouseJanuari, WarehouseFebruari, WarehouseMaret, WarehouseApril, WarehouseMei,
                    WarehouseJuni, WarehouseJuli, WarehouseAgustus, WarehouseSeptember,
                    WarehouseOktober, WarehouseNovember, WarehouseDesember
                ]
            }, {
                name: 'Delivery',
                marker: {
                    symbol: 'square'
                },
                data: [DeliveryJanuari, DeliveryFebruari, DeliveryMaret, DeliveryApril, DeliveryMei,
                    DeliveryJuni, DeliveryJuli, DeliveryAgustus, DeliverySeptember, DeliveryOktober,
                    DeliveryNovember, DeliveryDesember
                ]
            }, {
                name: 'Quality',
                marker: {
                    symbol: 'square'
                },
                data: [QualityJanuari, QualityFebruari, QualityMaret, QualityApril, QualityMei, QualityJuni,
                    QualityJuli, QualityAgustus, QualitySeptember, QualityOktober, QualityNovember,
                    QualityDesember
                ]
            }, {
                name: 'PPC',
                marker: {
                    symbol: 'square'
                },
                data: [PPCJanuari, PPCFebruari, PPCMaret, PPCApril, PPCMei, PPCJuni, PPCJuli, PPCAgustus,
                    PPCSeptember, PPCOktober, PPCNovember, PPCDesember
                ]
            }, {
                name: 'Office',
                marker: {
                    symbol: 'square'
                },
                data: [AccIcItHrdDcMktEngPurcJanuari, AccIcItHrdDcMktEngPurcFebruari,
                    AccIcItHrdDcMktEngPurcMaret, AccIcItHrdDcMktEngPurcApril, AccIcItHrdDcMktEngPurcMei,
                    AccIcItHrdDcMktEngPurcJuni, AccIcItHrdDcMktEngPurcJuli,
                    AccIcItHrdDcMktEngPurcAgustus, AccIcItHrdDcMktEngPurcSeptember,
                    AccIcItHrdDcMktEngPurcOktober, AccIcItHrdDcMktEngPurcNovember,
                    AccIcItHrdDcMktEngPurcDesember
                ]
            }]
        });
    </script>
    {{-- comm --}}
@endsection
