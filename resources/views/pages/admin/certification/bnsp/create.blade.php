@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Sertifikasi</li>
                    <li class="breadcrumb-item active">BNSP</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Tambah Data Sertifikasi
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
                            <form action="{{ route('certification.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="input_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Karyawan</label>
                                        <select class="selectpicker" name="employees_id" data-width="100%"
                                            data-live-search="true" required>
                                            <option value="">Pilih Nama Karyawan</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->nik_karyawan }}">
                                                    {{ $item->nama_karyawan . ' / ' . $item->divisions->penempatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nomor Sertifikat</label>
                                        <input type="text" class="form-control" name="nomor_sertifikat_bnsp"
                                            placeholder="Nomor Sertifikat" maxlength="30"
                                            value="{{ old('nomor_sertifikat_bnsp') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Jenis Sertifikasi</label>
                                        <input type="text" class="form-control" name="jenis_sertifikat_bnsp"
                                            placeholder="Jenis Sertifikasi" maxlength="50"
                                            value="{{ old('jenis_sertifikat_bnsp') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Masa Berlaku</label>
                                        <input type="text" class="form-control" name="masa_berlaku_sertifikat_bnsp"
                                            placeholder="Masa Berlaku Sertifikat " maxlength="20"
                                            value="{{ old('masa_berlaku_sertifikat_bnsp') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Terbit Sertifikat</label>
                                        <input type="date" class="form-control" name="tanggal_terbit_bnsp"
                                            placeholder="DD-MM-YYYY" value="{{ old('tanggal_terbit_bnsp') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Habis Sertifikat</label>
                                        <input type="date" class="form-control" name="sampai_tanggal_bnsp"
                                            placeholder="DD-MM-YYYY" value="{{ old('sampai_tanggal_bnsp') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">LSP</label>
                                        <input type="text" class="form-control" name="lsp_bnsp"
                                            placeholder="LSP Sertifikasi" maxlength="50" value="{{ old('lsp_bnsp') }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Simpan
                                        </button>
                                        <a href="{{ route('certification.index') }}" class="btn btn-danger btn-block">
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
