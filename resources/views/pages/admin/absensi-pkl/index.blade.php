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
                        Data Absensi Siswa Prakerin
                    </div>

                    <div class="card shadow">
                        @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD' || Auth::user()->roles == 'LEADER')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('absensipkl.lihat_absensi') }}" class="btn btn-primary btn-lg">
                                            <i class="fas fa-search"></i>
                                            Lihat Data
                                        </a>
                                    </div>
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('absensipkl.create') }}" class="btn btn-success btn-lg">
                                            <i class="fas fa-plus"></i>
                                            Tambah Data
                                        </a>
                                    </div>
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('absensipkl.form_edit') }}" class="btn btn-warning btn-lg">
                                            <i class="fas fa-sync-alt"></i>
                                            Edit Data
                                        </a>
                                    </div>
                                    <div class="col-md-3 d-grid gap-2 mt-2">
                                        <a href="{{ route('absensipkl.form_hapus') }}" class="btn btn-danger btn-lg">
                                            <i class="fas fa-trash-alt"></i>
                                            Hapus Data
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @elseif(Auth::user()->roles == 'MANAGER HRD' ||
                            Auth::user()->roles == 'MANAGER ACCOUNTING' ||
                            Auth::user()->roles == 'ACCOUNTING')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 d-grid gap-2 mt-2">
                                        <a href="{{ route('absensipkl.lihat_absensi') }}" class="btn btn-primary btn-lg">
                                            <i class="fas fa-search"></i>
                                            Lihat Data
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
@endsection
