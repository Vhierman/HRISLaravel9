@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">

        <main>
            <section class="section-dashboard-top mt-3">
                <div class="container-fluid px-4">

                    <div class="row">
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-dark text-white mb-4">
                                <div class="card-body"><i class="fas fa-city"></i> Jumlah Karyawan ALL</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white"><i class="fas fa-users"></i> {{ $itemall }}
                                        Acc,BSD,PDC
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-dark text-white mb-4">
                                <div class="card-body"><i class="fas fa-city"></i> Head Office</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white"><i class="fas fa-users"></i> {{ $itembsd }}
                                        BSD
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-dark text-white mb-4">
                                <div class="card-body"><i class="fas fa-city"></i> Sunter</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white"><i class="fas fa-users"></i> {{ $itempdc }}
                                        Daihatsu
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div id="containerpenempatan"></div>
                            </div>
                        </div>
                        <div class="row  mt-3">
                            <div class="col-md-6">
                                <div id="containerjeniskelamin"></div>
                            </div>
                            <div class="col-md-6">
                                <div id="containerstatusnikah"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </main>


        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    {{-- Chart ADMIN/HRD/MANAGER --}}
    {{-- Chart Penempatan --}}
    <script>
        var hrd = {{ json_encode($itemhrd) }};
        var quality = {{ json_encode($itemquality) }};
        var produksi = {{ json_encode($itemproduksi) }};
        var deliveryproduksi = {{ json_encode($itemdeliveryproduksi) }};
        var gudangrm = {{ json_encode($itemgudangrm) }};
        var gudangfg = {{ json_encode($itemgudangfg) }};
        var delivery = {{ json_encode($itemdelivery) }};
        var bloke = {{ json_encode($itembloke) }};
        var pdcdaihatsusunter = {{ json_encode($itempdcdaihatsusunter) }};

        Highcharts.chart('containerpenempatan', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:1f}'
                    }
                }
            },
            credits: {
                enabled: false
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>'
            },

            series: [{
                name: "Penempatan",
                colorByPoint: true,
                data: [{
                        name: "HRD-GA",
                        y: hrd,
                        drilldown: null
                    },
                    {
                        name: "Quality",
                        y: quality,
                        drilldown: null
                    },
                    {
                        name: "Produksi",
                        y: produksi,
                        drilldown: null
                    },
                    {
                        name: "Delivery Produksi",
                        y: deliveryproduksi,
                        drilldown: null
                    },
                    {
                        name: "Raw Material",
                        y: gudangrm,
                        drilldown: null
                    },
                    {
                        name: "Finish Goods",
                        y: gudangfg,
                        drilldown: null
                    },
                    {
                        name: "Delivery",
                        y: delivery,
                        drilldown: null
                    },
                    {
                        name: "Blok E",
                        y: bloke,
                        drilldown: null
                    },
                    {
                        name: "PDC Daihatsu",
                        y: pdcdaihatsusunter,
                        drilldown: null
                    }
                ]
            }],
        });
    </script>
    {{-- Chart Penempatan --}}

    {{-- Chart Status Menikah --}}
    <script>
        var single = {{ json_encode($itemsingle) }};
        var menikah = {{ json_encode($itemmenikah) }};
        var janda = {{ json_encode($itemjanda) }};
        var duda = {{ json_encode($itemduda) }};
        Highcharts.chart('containerstatusnikah', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },

            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Single',
                    y: single,
                    sliced: true,
                    selected: true
                }, {
                    name: 'Menikah',
                    y: menikah
                }, {
                    name: 'Janda',
                    y: janda
                }, {
                    name: 'Duda',
                    y: duda
                }]
            }]
        });
    </script>
    {{-- Chart Status Menikah --}}

    {{-- Chart Jenis Kelamin --}}
    <script>
        var pria = {{ json_encode($itempria) }};
        var wanita = {{ json_encode($itemwanita) }};
        Highcharts.chart('containerjeniskelamin', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },

            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Pria',
                    y: pria,
                    sliced: true,
                    selected: true
                }, {
                    name: 'Wanita',
                    y: wanita
                }]
            }]
        });
    </script>
    {{-- Chart Jenis Kelamin --}}

    {{-- Chart ADMIN/HRD/MANAGER --}}
@endsection
