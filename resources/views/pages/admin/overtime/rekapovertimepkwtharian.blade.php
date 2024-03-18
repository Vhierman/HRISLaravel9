@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Rekap Lembur
                    </div>

                    <div class="card shadow">

                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-md-6 d-grid gap-2 mt-2">
                                    <a href="{{ route('overtime.form_cetak_rekap_overtime_pkwt_harian') }}"
                                        class="btn btn-success btn-lg">
                                        <i class="fas fa-print"></i>
                                        Cetak Rekap PKWT Dan Harian
                                    </a>
                                </div> --}}
                                {{-- <div class="col-md-12 d-grid gap-2 mt-2">
                                    <a href="{{ route('overtime.form_cetak_rekap_overtime_pkwtt') }}"
                                        class="btn btn-primary btn-lg">
                                        <i class="fas fa-print"></i>
                                        Cetak Rekap HARIAN, PKWT, DAN PKWTT
                                    </a>
                                </div> --}}
                                <div class="col-md-12 d-grid gap-2 mt-2">
                                    <a href="{{ route('overtime.form_cetak_rekap_overtime_harian_pkwt_pkwtt') }}"
                                        class="btn btn-primary btn-lg">
                                        <i class="fas fa-print"></i>
                                        Cetak Rekap HARIAN, PKWT, DAN PKWTT
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
@endsection
