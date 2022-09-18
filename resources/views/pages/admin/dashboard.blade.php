@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">

        <main>
            <section class="section-dashboard-top mt-3">
                <div class="container-fluid px-4">

                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Total Karyawan</p>
                                            <h4 class="my-1 text-info">{{ $itemall }}</h4>
                                            <p class="mb-0 font-13">Acc,BSD,PDC</p>
                                        </div>
                                        <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
                                            <i class="fa fa-users"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-3 border-danger">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Accounting Office</p>
                                            <h4 class="my-1 text-danger">{{ $itemaw }}</h4>
                                            <p class="mb-0 font-13">PK66 And Blok BL</p>
                                        </div>
                                        <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
                                            <i class="fa fa-building"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-3 border-success">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Head Office</p>
                                            <h4 class="my-1 text-success">{{ $itembsd }}</h4>
                                            <p class="mb-0 font-13">BSD</p>
                                        </div>
                                        <div
                                            class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                            <i class="fa fa-city"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-3 border-warning">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">PDC</p>
                                            <h4 class="my-1 text-warning">{{ $itempdc }}</h4>
                                            <p class="mb-0 font-13">Daihatsu</p>
                                        </div>
                                        <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
                                            <i class="fa fa-warehouse"></i>
                                        </div>
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
                                <div id="containerkontrak"></div>
                            </div>
                            <div class="col-md-6">
                                <div id="containerstatusnikah"></div>
                            </div>
                        </div>
                        <div class="row  mt-3">
                            <div class="col-md-6">
                                <div id="containerjeniskelamin"></div>
                            </div>
                            <div class="col-md-6">
                                <div id="containeragama"></div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div id="containerpenempatandetail"></div>
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
        var accounting = {{ json_encode($itemaccounting) }};
        var ic = {{ json_encode($itemic) }};
        var it = {{ json_encode($itemit) }};
        var hrd = {{ json_encode($itemhrd) }};
        var doccontrol = {{ json_encode($itemdoccontrol) }};
        var marketing = {{ json_encode($itemmarketing) }};
        var engineering = {{ json_encode($itemengineering) }};
        var quality = {{ json_encode($itemquality) }};
        var purchasing = {{ json_encode($itempurchasing) }};
        var ppc = {{ json_encode($itemppc) }};
        var produksi = {{ json_encode($itemproduksi) }};
        var deliveryproduksi = {{ json_encode($itemdeliveryproduksi) }};
        var gudangrm = {{ json_encode($itemgudangrm) }};
        var gudangfg = {{ json_encode($itemgudangfg) }};
        var delivery = {{ json_encode($itemdelivery) }};
        var security = {{ json_encode($itemsecurity) }};
        var blokbl = {{ json_encode($itemblokbl) }};
        var bloke = {{ json_encode($itembloke) }};
        var pdcdaihatsusunter = {{ json_encode($itempdcdaihatsusunter) }};
        var pdcdaihatsucibinong = {{ json_encode($itempdcdaihatsucibinong) }};
        var pdcdaihatsucibitung = {{ json_encode($itempdcdaihatsucibitung) }};
        var pdcdaihatsukarawangtimur = {{ json_encode($itempdcdaihatsukarawangtimur) }};
        var jumlahgreenville = {{ json_encode($itemjumlahgreenville) }};
        var jumlahhrd = {{ json_encode($itemjumlahhrd) }};
        var jumlahppc = {{ json_encode($itemjumlahppc) }};
        var jumlahproduksi = {{ json_encode($itemjumlahproduksi) }};

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
                        name: "Accounting",
                        y: jumlahgreenville,
                        drilldown: "Accounting"
                    },
                    {
                        name: "HRD-GA",
                        y: jumlahhrd,
                        drilldown: "HRD-GA"
                    },
                    {
                        name: "PPC",
                        y: jumlahppc,
                        drilldown: "PPC"
                    },
                    {
                        name: "Produksi",
                        y: jumlahproduksi,
                        drilldown: "Produksi"
                    },
                    {
                        name: "Document Control",
                        y: doccontrol,
                        drilldown: null
                    },
                    {
                        name: "Marketing",
                        y: marketing,
                        drilldown: null
                    },
                    {
                        name: "Purchasing",
                        y: purchasing,
                        drilldown: null
                    },
                    {
                        name: "Engineering",
                        y: engineering,
                        drilldown: null
                    },
                    {
                        name: "Quality",
                        y: quality,
                        drilldown: null
                    }
                ]
            }],
            drilldown: {
                series: [{
                        name: "Accounting",
                        id: "Accounting",
                        data: [
                            [
                                "Accounting",
                                accounting
                            ],
                            [
                                "IC",
                                ic
                            ],
                            [
                                "IT",
                                it
                            ]
                        ]
                    },
                    {
                        name: "HRD-GA",
                        id: "HRD-GA",
                        data: [
                            [
                                "HRD-GA",
                                hrd
                            ],
                            [
                                "Security",
                                security
                            ]
                        ]
                    },
                    {
                        name: "PPC",
                        id: "PPC",
                        data: [
                            [
                                "PPC",
                                ppc
                            ],
                            [
                                "Delivery Produksi",
                                deliveryproduksi
                            ],
                            [
                                "Delivery",
                                delivery
                            ],
                            [
                                "Gudang Rawa Material",
                                gudangrm
                            ],
                            [
                                "Gudang Finish Goods",
                                gudangfg
                            ],
                            [
                                "Blok E",
                                bloke
                            ]
                        ]
                    },
                    {
                        name: "Produksi",
                        id: "Produksi",
                        data: [
                            [
                                "Produksi",
                                produksi
                            ],
                            [
                                "PDC Daihatsu Sunter",
                                pdcdaihatsusunter
                            ],
                            [
                                "PDC Daihatsu Cibinong",
                                pdcdaihatsucibinong
                            ],
                            [
                                "PDC Daihatsu Cibitung",
                                pdcdaihatsucibitung
                            ],
                            [
                                "PDC Daihatsu Karawang Timur",
                                pdcdaihatsukarawangtimur
                            ]
                        ]
                    }
                ]
            }
        });
    </script>
    {{-- Chart Penempatan --}}

    {{-- Chart KOntrak --}}
    <script>
        var kontrak = {{ json_encode($itemkontrak) }};
        var tetap = {{ json_encode($itemtetap) }};
        var harian = {{ json_encode($itemharian) }};
        var outsourcing = {{ json_encode($itemoutsourcing) }};
        Highcharts.chart('containerkontrak', {
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
                    name: 'Tetap',
                    y: tetap,
                    sliced: true,
                    selected: true
                }, {
                    name: 'Kontrak',
                    y: kontrak
                }, {
                    name: 'Harian',
                    y: harian
                }, {
                    name: 'Outsourcing',
                    y: outsourcing
                }]
            }]
        });
    </script>
    {{-- Chart KOntrak --}}

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

    {{-- Chart Agama --}}
    <script>
        var islam = {{ json_encode($itemislam) }};
        var kristenprotestan = {{ json_encode($itemkristenprotestan) }};
        var kristenkatholik = {{ json_encode($itemkristenkatholik) }};
        var hindu = {{ json_encode($itemhindu) }};
        var budha = {{ json_encode($itembudha) }};
        Highcharts.chart('containeragama', {
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
                    name: 'Islam',
                    y: islam,
                    sliced: true,
                    selected: true
                }, {
                    name: 'Kristen Protestan',
                    y: kristenprotestan
                }, {
                    name: 'Kristen Katholik',
                    y: kristenkatholik
                }, {
                    name: 'Hindu',
                    y: hindu
                }, {
                    name: 'Budha',
                    y: budha
                }]
            }]
        });
    </script>
    {{-- Chart Agama --}}

    {{-- Chart Penempatan Detail --}}
    <script>
        var accountingpkwtt = {{ json_encode($itemaccountingpkwtt) }};
        var accountingpkwt = {{ json_encode($itemaccountingpkwt) }};
        var accountingharian = {{ json_encode($itemaccountingharian) }};
        var accountingoutsourcing = {{ json_encode($itemaccountingoutsourcing) }};
        var icpkwtt = {{ json_encode($itemicpkwtt) }};
        var icpkwt = {{ json_encode($itemicpkwt) }};
        var icharian = {{ json_encode($itemicharian) }};
        var icoutsourcing = {{ json_encode($itemicoutsourcing) }};
        var itpkwtt = {{ json_encode($itemitpkwtt) }};
        var itpkwt = {{ json_encode($itemitpkwt) }};
        var itharian = {{ json_encode($itemitharian) }};
        var itoutsourcing = {{ json_encode($itemitoutsourcing) }};
        var hrdpkwtt = {{ json_encode($itemhrdpkwtt) }};
        var hrdpkwt = {{ json_encode($itemhrdpkwt) }};
        var hrdharian = {{ json_encode($itemhrdharian) }};
        var hrdoutsourcing = {{ json_encode($itemhrdoutsourcing) }};
        var doccontrolpkwtt = {{ json_encode($itemdoccontrolpkwtt) }};
        var doccontrolpkwt = {{ json_encode($itemdoccontrolpkwt) }};
        var doccontrolharian = {{ json_encode($itemdoccontrolharian) }};
        var doccontroloutsourcing = {{ json_encode($itemdoccontroloutsourcing) }};
        var marketingpkwtt = {{ json_encode($itemmarketingpkwtt) }};
        var marketingpkwt = {{ json_encode($itemmarketingpkwt) }};
        var marketingharian = {{ json_encode($itemmarketingharian) }};
        var marketingoutsourcing = {{ json_encode($itemmarketingoutsourcing) }};
        var engineeringpkwtt = {{ json_encode($itemengineeringpkwtt) }};
        var engineeringpkwt = {{ json_encode($itemengineeringpkwt) }};
        var engineeringharian = {{ json_encode($itemengineeringharian) }};
        var engineeringoutsourcing = {{ json_encode($itemengineeringoutsourcing) }};
        var qualitypkwtt = {{ json_encode($itemqualitypkwtt) }};
        var qualitypkwt = {{ json_encode($itemqualitypkwt) }};
        var qualityharian = {{ json_encode($itemqualityharian) }};
        var qualityoutsourcing = {{ json_encode($itemqualityoutsourcing) }};
        var purchasingpkwtt = {{ json_encode($itempurchasingpkwtt) }};
        var purchasingpkwt = {{ json_encode($itempurchasingpkwt) }};
        var purchasingharian = {{ json_encode($itempurchasingharian) }};
        var purchasingoutsourcing = {{ json_encode($itempurchasingoutsourcing) }};
        var ppcpkwtt = {{ json_encode($itemppcpkwtt) }};
        var ppcpkwt = {{ json_encode($itemppcpkwt) }};
        var ppcharian = {{ json_encode($itemppcharian) }};
        var ppcoutsourcing = {{ json_encode($itemppcoutsourcing) }};
        var produksipkwtt = {{ json_encode($itemproduksipkwtt) }};
        var produksipkwt = {{ json_encode($itemproduksipkwt) }};
        var produksiharian = {{ json_encode($itemproduksiharian) }};
        var produksioutsourcing = {{ json_encode($itemproduksioutsourcing) }};
        var deliveryproduksipkwtt = {{ json_encode($itemdeliveryproduksipkwtt) }};
        var deliveryproduksipkwt = {{ json_encode($itemdeliveryproduksipkwt) }};
        var deliveryproduksiharian = {{ json_encode($itemdeliveryproduksiharian) }};
        var deliveryproduksioutsourcing = {{ json_encode($itemdeliveryproduksioutsourcing) }};
        var deliveryproduksipkwtt = {{ json_encode($itemdeliveryproduksipkwtt) }};
        var deliveryproduksipkwt = {{ json_encode($itemdeliveryproduksipkwt) }};
        var deliveryproduksiharian = {{ json_encode($itemdeliveryproduksiharian) }};
        var deliveryproduksioutsourcing = {{ json_encode($itemdeliveryproduksioutsourcing) }};
        var gudangrmpkwtt = {{ json_encode($itemgudangrmpkwtt) }};
        var gudangrmpkwt = {{ json_encode($itemgudangrmpkwt) }};
        var gudangrmharian = {{ json_encode($itemgudangrmharian) }};
        var gudangrmoutsourcing = {{ json_encode($itemgudangrmoutsourcing) }};
        var gudangfgpkwtt = {{ json_encode($itemgudangfgpkwtt) }};
        var gudangfgpkwt = {{ json_encode($itemgudangfgpkwt) }};
        var gudangfgharian = {{ json_encode($itemgudangfgharian) }};
        var gudangfgoutsourcing = {{ json_encode($itemgudangfgoutsourcing) }};
        var deliverypkwtt = {{ json_encode($itemdeliverypkwtt) }};
        var deliverypkwt = {{ json_encode($itemdeliverypkwt) }};
        var deliveryharian = {{ json_encode($itemdeliveryharian) }};
        var deliveryoutsourcing = {{ json_encode($itemdeliveryoutsourcing) }};
        var securitypkwtt = {{ json_encode($itemsecuritypkwtt) }};
        var securitypkwt = {{ json_encode($itemsecuritypkwt) }};
        var securityharian = {{ json_encode($itemdeliveryharian) }};
        var securityoutsourcing = {{ json_encode($itemsecurityoutsourcing) }};
        var blokblpkwtt = {{ json_encode($itemblokblpkwtt) }};
        var blokblpkwt = {{ json_encode($itemblokblpkwt) }};
        var blokblharian = {{ json_encode($itemblokblharian) }};
        var blokbloutsourcing = {{ json_encode($itemblokbloutsourcing) }};
        var blokepkwtt = {{ json_encode($itemblokepkwtt) }};
        var blokepkwt = {{ json_encode($itemblokepkwt) }};
        var blokeharian = {{ json_encode($itemblokeharian) }};
        var blokeoutsourcing = {{ json_encode($itemblokeoutsourcing) }};
        var pdcdaihatsusunterpkwtt = {{ json_encode($itempdcdaihatsusunterpkwtt) }};
        var pdcdaihatsusunterpkwt = {{ json_encode($itempdcdaihatsusunterpkwt) }};
        var pdcdaihatsusunterharian = {{ json_encode($itempdcdaihatsusunterharian) }};
        var pdcdaihatsusunteroutsourcing = {{ json_encode($itempdcdaihatsusunteroutsourcing) }};
        var pdcdaihatsucibinongpkwtt = {{ json_encode($itempdcdaihatsucibinongpkwtt) }};
        var pdcdaihatsucibinongpkwt = {{ json_encode($itempdcdaihatsucibinongpkwt) }};
        var pdcdaihatsucibinongharian = {{ json_encode($itempdcdaihatsucibinongharian) }};
        var pdcdaihatsucibinongoutsourcing = {{ json_encode($itempdcdaihatsucibinongoutsourcing) }};
        var pdcdaihatsucibitungpkwtt = {{ json_encode($itempdcdaihatsucibitungpkwtt) }};
        var pdcdaihatsucibitungpkwt = {{ json_encode($itempdcdaihatsucibitungpkwt) }};
        var pdcdaihatsucibitungharian = {{ json_encode($itempdcdaihatsucibitungharian) }};
        var pdcdaihatsucibitungoutsourcing = {{ json_encode($itempdcdaihatsucibitungoutsourcing) }};
        var pdcdaihatsukarawangtimurpkwtt = {{ json_encode($itempdcdaihatsukarawangtimurpkwtt) }};
        var pdcdaihatsukarawangtimurpkwt = {{ json_encode($itempdcdaihatsukarawangtimurpkwt) }};
        var pdcdaihatsukarawangtimurharian = {{ json_encode($itempdcdaihatsukarawangtimurharian) }};
        var pdcdaihatsukarawangtimuroutsourcing = {{ json_encode($itempdcdaihatsukarawangtimuroutsourcing) }};

        Highcharts.chart('containerpenempatandetail', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Detail Penempatan Karyawan'
            },
            xAxis: {
                categories: ['Blok BL', 'Accounting', 'IC', 'IT', 'HRD', 'Doc Control', 'Marketing', 'Engineering',
                    'Quality',
                    'Purchasing', 'PPC', 'Produksi', 'Delivery Produksi', 'Gudang RM', 'Gudang FG', 'Delivery',
                    'Blok E', 'Daihatsu Sunter', 'Daihatsu Cibinong',
                    'Daihatsu Cibitung', 'Daihatsu Karawang Timur'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total Jumlah Karyawan'
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                column: {
                    stacking: 'percent'
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Tetap',
                data: [blokblpkwtt, accountingpkwtt, icpkwtt, itpkwtt, hrdpkwtt, doccontrolpkwtt,
                    marketingpkwtt,
                    engineeringpkwtt, qualitypkwtt, purchasingpkwtt, ppcpkwtt, produksipkwtt,
                    deliveryproduksipkwtt, gudangrmpkwtt, gudangfgpkwtt, deliverypkwtt,
                    blokepkwtt, pdcdaihatsusunterpkwtt,
                    pdcdaihatsucibinongpkwtt, pdcdaihatsucibitungpkwtt, pdcdaihatsukarawangtimurpkwtt
                ]
            }, {
                name: 'Kontrak',
                data: [blokblpkwt, accountingpkwt, icpkwt, itpkwt, hrdpkwt, doccontrolpkwt, marketingpkwt,
                    engineeringpkwt, qualitypkwt, purchasingpkwt, ppcpkwt, produksipkwt,
                    deliveryproduksipkwt, gudangrmpkwt, gudangfgpkwt, deliverypkwt,
                    blokepkwt, pdcdaihatsusunterpkwt, pdcdaihatsucibinongpkwt,
                    pdcdaihatsucibitungpkwt, pdcdaihatsukarawangtimurpkwt
                ]
            }, {
                name: 'Harian',
                data: [blokblharian, accountingharian, icharian, itharian, hrdharian, doccontrolharian,
                    marketingharian,
                    engineeringharian, qualityharian, purchasingharian, ppcharian, produksiharian,
                    deliveryproduksiharian, gudangrmharian, gudangfgharian, deliveryharian,
                    blokeharian, pdcdaihatsusunterharian,
                    pdcdaihatsucibinongharian, pdcdaihatsucibitungharian, pdcdaihatsukarawangtimurharian
                ]
            }]
        });
    </script>
    {{-- Chart Penempatan Detail --}}
    {{-- Chart ADMIN/HRD/MANAGER --}}

    {{-- Chart Leader --}}
    {{-- Chart Leader --}}
@endsection
