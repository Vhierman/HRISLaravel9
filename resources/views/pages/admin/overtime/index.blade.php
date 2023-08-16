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
                        Data Lembur
                    </div>

                    <div class="card shadow">

                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong>Informasi.!!!</strong> Periode Overtime Dimulai Dari Tanggal 16 Sampai Tanggal 15.
                            Overtime Di Rekap
                            Setiap Tanggal 15.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('overtime.lihat_overtime') }}" class="btn btn-primary btn-lg">
                                            <i class="fas fa-search"></i>
                                            Lihat Data
                                        </a>
                                    </div>
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('overtime.create') }}" class="btn btn-success btn-lg">
                                            <i class="fas fa-plus"></i>
                                            Tambah Data
                                        </a>
                                    </div>
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('overtime.edit_overtime') }}" class="btn btn-warning btn-lg">
                                            <i class="fas fa-sync-alt"></i>
                                            Edit Data
                                        </a>
                                    </div>
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('overtime.form_hapus_overtime') }}" class="btn btn-danger btn-lg">
                                            <i class="fas fa-trash-alt"></i>
                                            Hapus Data
                                        </a>
                                    </div>
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('overtime.form_approve_overtime') }}"
                                            class="btn btn-primary btn-lg">
                                            <i class="fas fa-check"></i>
                                            Rekap Data
                                        </a>
                                    </div>
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('overtime.form_cetak_slip_overtime') }}"
                                            class="btn btn-success btn-lg">
                                            <i class="fas fa-print"></i>
                                            Cetak Slip
                                        </a>
                                    </div>
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('overtime.form_rekap_overtime') }}"
                                            class="btn btn-warning btn-lg">
                                            <i class="fas fa-print"></i>
                                            Cetak Rekap
                                        </a>
                                    </div>
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('overtime.form_cancel_approve_overtime') }}"
                                            class="btn btn-danger btn-lg">
                                            <i class="fas fa-undo"></i>
                                            Cancel Rekap
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 d-grid gap-2 mt-2">
                                        <a href="{{ route('overtime.form_hapus_overtime_date') }}"
                                            class="btn btn-dark btn-lg">
                                            <i class="fas fa-trash-alt"></i>
                                            Hapus Data Berdasarkan Tanggal
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @elseif(Auth::user()->roles == 'ACCOUNTING' ||
                                Auth::user()->roles == 'MANAGER ACCOUNTING' ||
                                Auth::user()->roles == 'MANAGER HRD')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 d-grid gap-2 mt-1">
                                        <a href="{{ route('overtime.lihat_overtime') }}" class="btn btn-primary btn-lg">
                                            <i class="fas fa-search"></i>
                                            Lihat Data
                                        </a>
                                    </div>
                                    <div class="col-md-4 d-grid gap-2 mt-1">
                                        <a href="{{ route('overtime.form_cetak_slip_overtime') }}"
                                            class="btn btn-success btn-lg">
                                            <i class="fas fa-print"></i>
                                            Cetak Slip
                                        </a>
                                    </div>
                                    <div class="col-md-4 d-grid gap-2 mt-1">
                                        <a href="{{ route('overtime.form_rekap_overtime') }}"
                                            class="btn btn-warning btn-lg">
                                            <i class="fas fa-print"></i>
                                            Cetak Rekap
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @elseif(Auth::user()->roles == 'LEADER')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('overtime.lihat_overtime') }}" class="btn btn-primary btn-lg">
                                            <i class="fas fa-search"></i>
                                            Lihat Data
                                        </a>
                                    </div>
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('overtime.create') }}" class="btn btn-success btn-lg">
                                            <i class="fas fa-plus"></i>
                                            Tambah Data
                                        </a>
                                    </div>
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('overtime.edit_overtime') }}" class="btn btn-warning btn-lg">
                                            <i class="fas fa-sync-alt"></i>
                                            Edit Data
                                        </a>
                                    </div>
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('overtime.form_hapus_overtime') }}"
                                            class="btn btn-danger btn-lg">
                                            <i class="fas fa-trash-alt"></i>
                                            Hapus Data
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                        @endif

                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
@endsection
