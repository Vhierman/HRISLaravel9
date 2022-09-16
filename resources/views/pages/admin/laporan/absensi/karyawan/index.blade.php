@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">Absensi Karyawan</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Absensi Karyawan
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card shadow">
                        <div class="card-body">
                            <form action="{{ route('laporan.tampil_absensi_karyawan') }}" method="post"
                                enctype="multipart/form-data" target="_blank">
                                @csrf
                                <div class="form-group">

                                    <div class="form-group mt-2">

                                        <input type="hidden" class="form-control" name="input_oleh" placeholder="Name"
                                            value="{{ Auth::user()->name }}">

                                        <label for="title" class="form-label">Nama Karyawan</label>
                                        <select class="selectpicker" name="employees_id" data-width="100%"
                                            data-live-search="true" required>
                                            <option value="">--Pilih Karyawan--</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->nik_karyawan }}">
                                                    {{ $item->nama_karyawan . ' / ' . $item->divisions->penempatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label for="title" class="form-label">Mulai Dari</label>
                                    <input type="date" class="form-control" name="tanggal_awal" placeholder="DD-MM-YYYY"
                                        value="{{ old('tanggal_awal') }}">

                                    <label for="title" class="form-label">Sampai Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal_akhir" placeholder="DD-MM-YYYY"
                                        value="{{ old('tanggal_akhir') }}">


                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Cetak
                                        </button>
                                        <a href="{{ route('laporan.absensi_karyawan') }}" class="btn btn-danger btn-block">
                                            Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
@endsection
