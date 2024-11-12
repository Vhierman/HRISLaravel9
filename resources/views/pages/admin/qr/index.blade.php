@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item active">Area</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data QQ Code
                    </div>
                    <div class="card-body">
                        <div class="visible-print text-center">
                            {!! QrCode::size(256)->generate(
                                'https://docs.google.com/forms/d/e/1FAIpQLSdGj4IQ9g-cHGj3dRdXFTpAEDPRhR_VJcz7ghxsOOxdQaBJew/viewform',
                            ) !!}

                        </div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}



        {{-- End Content Dan Footer --}}

        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    </div>
@endsection
