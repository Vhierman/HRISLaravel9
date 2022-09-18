@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid px-4">
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div id="containerstruktur"></div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/sankey.js"></script>
    <script src="https://code.highcharts.com/modules/organization.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        Highcharts.chart('containerstruktur', {
            chart: {
                height: 600,
                inverted: true
            },

            title: {
                text: 'STRUKTUR ORGANISASI HRD-GA'
            },

            accessibility: {
                point: {
                    descriptionFormatter: function(point) {
                        var nodeName = point.toNode.name,
                            nodeId = point.toNode.id,
                            nodeDesc = nodeName === nodeId ? nodeName : nodeName + ', ' + nodeId,
                            parentDesc = point.fromNode.id;
                        return point.index + '. ' + nodeDesc + ', reports to ' + parentDesc + '.';
                    }
                }
            },

            series: [{
                type: 'organization',
                name: 'Highsoft',
                keys: ['from', 'to'],
                data: [
                    ['Manager'],
                    ['Manager', 'CEO'],
                    ['CEO', 'CTO'],
                    ['CEO', 'CPO'],
                    ['CEO', 'HR'],
                    ['CTO', 'Product'],
                    ['CPO', 'Web'],
                    ['HR', 'Sales']
                ],
                levels: [{
                    level: 0,
                    color: '#980104'
                }, {
                    level: 1,
                    color: '#359154'
                }, {
                    level: 2,
                    color: '#007ad0'
                }, {
                    level: 3,
                    color: '#000000'
                }],
                nodes: [{
                    id: 'Manager',
                    title: 'Manager HRD-GA',
                    name: 'Rudiyanto',
                    image: '{{ Storage::url('assets/foto/Rudiyanto.jpeg') }}'
                }, {
                    id: 'CEO',
                    title: 'Supervisor HRD-GA',
                    name: 'Iwan Rahmat',
                    image: '{{ Storage::url('assets/foto/Taron.jpg') }}'
                }, {
                    id: 'HR',
                    title: 'Staff HRD-GA',
                    name: 'A Firmansyah',
                    image: '{{ Storage::url('assets/foto/karyawan/g5RmutgnZLgaBIfJeNxb5R89mRKNtpCuY01GdktT.jpg') }}'
                }, {
                    id: 'CTO',
                    title: 'Staff HRD-GA',
                    name: 'Gufron N.S',
                    image: '{{ Storage::url('assets/foto/karyawan/OgB82QXtS12vatdjk2MxSQ3u3lnztwNmgx3ibQRU.jpg') }}'
                }, {
                    id: 'CPO',
                    title: 'Staff HRD-GA',
                    name: 'Amir Machmud',
                    image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2020/03/17131213/Highsoft_03998_.jpg'
                }, {
                    id: 'Product',
                    name: 'HRD-GA'
                }, {
                    id: 'Web',
                    name: 'Document ISO'
                }, {
                    id: 'Sales',
                    name: 'K3 & Lingkungan'
                }],
                colorByPoint: false,
                color: '#007ad0',
                dataLabels: {
                    color: 'white'
                },
                borderColor: 'white',
                nodeWidth: 65
            }],
            tooltip: {
                outside: true
            },
            exporting: {
                allowHTML: true,
                sourceWidth: 800,
                sourceHeight: 600
            }

        });
    </script>
@endsection
