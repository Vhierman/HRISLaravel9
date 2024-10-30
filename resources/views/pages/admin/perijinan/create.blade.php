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
                    <li class="breadcrumb-item active">Perijinan</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Tambah Data Perijinan
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
                            <form action="{{ route('laporan.proses_tambah_perijinan') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="input_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Perijinan</label>
                                        <input type="text" class="form-control" name="nama_perijinan"
                                            placeholder="Masukan Nama Perijinan" maxlength="50"
                                            value="{{ old('nama_perijinan') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nomor Perijinan</label>
                                        <input type="text" class="form-control" name="nomor_perijinan"
                                            placeholder="Masukan Nomor Perijinan" maxlength="50"
                                            value="{{ old('nomor_perijinan') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Instansi Penerbit</label>
                                        <input type="text" class="form-control" name="instansi_penerbit"
                                            placeholder="Masukan Instansi Penerbit" maxlength="50"
                                            value="{{ old('instansi_penerbit') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Dikeluarkan</label>
                                        <input type="date" class="form-control" name="tanggal_berlaku"
                                            placeholder="DD-MM-YYYY" value="{{ old('tanggal_berlaku') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Habis Berlaku</label>
                                        <input type="date" class="form-control" name="tanggal_habis"
                                            placeholder="DD-MM-YYYY" value="{{ old('tanggal_habis') }}">
                                    </div>
                                    <div class="form-group  mt-2">
                                        <label for="masa_berlaku">Masa Berlaku</label>
                                        <select name="masa_berlaku" class="form-select">
                                            <option value="">Pilih Masa Berlaku</option>
                                            <option value="Tidak Ada"
                                                @if (old('masa_berlaku') == 'Tidak Ada') {{ 'selected' }} @endif>Tidak Ada
                                            </option>
                                            <option value="1 Bulan"
                                                @if (old('masa_berlaku') == '1 Bulan') {{ 'selected' }} @endif>1 Bulan
                                            </option>
                                            <option value="3 Bulan"
                                                @if (old('masa_berlaku') == '3 Bulan') {{ 'selected' }} @endif>3 Bulan
                                            </option>
                                            <option value="6 Bulan"
                                                @if (old('masa_berlaku') == '6 Bulan') {{ 'selected' }} @endif>6 Bulan
                                            </option>
                                            <option value="1 Tahun"
                                                @if (old('masa_berlaku') == '1 Tahun') {{ 'selected' }} @endif>1 Tahun
                                            </option>
                                            <option value="2 Tahun"
                                                @if (old('masa_berlaku') == '2 Tahun') {{ 'selected' }} @endif>2 Tahun
                                            </option>
                                            <option value="3 Tahun"
                                                @if (old('masa_berlaku') == '3 Tahun') {{ 'selected' }} @endif>3 Tahun
                                            </option>
                                            <option value="4 Tahun"
                                                @if (old('masa_berlaku') == '4 Tahun') {{ 'selected' }} @endif>4 Tahun
                                            </option>
                                            <option value="5 Tahun"
                                                @if (old('masa_berlaku') == '5 Tahun') {{ 'selected' }} @endif>5 Tahun
                                            </option>
                                            <option value="6 Tahun"
                                                @if (old('masa_berlaku') == '6 Tahun') {{ 'selected' }} @endif>6 Tahun
                                            </option>
                                            <option value="7 Tahun"
                                                @if (old('masa_berlaku') == '7 Tahun') {{ 'selected' }} @endif>7 Tahun
                                            </option>
                                            <option value="8 Tahun"
                                                @if (old('masa_berlaku') == '8 Tahun') {{ 'selected' }} @endif>8 Tahun
                                            </option>
                                            <option value="9 Tahun"
                                                @if (old('masa_berlaku') == '9 Tahun') {{ 'selected' }} @endif>9 Tahun
                                            </option>
                                            <option value="10 Tahun"
                                                @if (old('masa_berlaku') == '10 Tahun') {{ 'selected' }} @endif>10 Tahun
                                            </option>
                                        </select>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Simpan
                                        </button>
                                        <a href="{{ route('laporan.perijinan') }}" class="btn btn-danger btn-block">
                                            Back
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
