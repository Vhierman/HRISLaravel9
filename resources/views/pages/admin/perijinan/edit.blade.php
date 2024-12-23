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
                        Edit Perijinan
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
                            <form action="{{ route('laporan.hasil_edit_perijinan', $items->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" readonly class="form-control" name="edit_oleh" placeholder="name"
                                        value="{{ Auth::user()->name }}">

                                    <input type="hidden" readonly class="form-control" name="id" placeholder="id"
                                        value="{{ $items->id }}">

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Perijinan</label>
                                        <input type="text" class="form-control" name="nama_perijinan"
                                            value="{{ $items->nama_perijinan }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nomor Perijinan</label>
                                        <input type="text" class="form-control" name="nomor_perijinan"
                                            value="{{ $items->nomor_perijinan }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Instansi Penerbit</label>
                                        <input type="text" class="form-control" name="instansi_penerbit"
                                            value="{{ $items->instansi_penerbit }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Dikeluarkan</label>
                                        <input type="date" class="form-control" name="tanggal_berlaku"
                                            value="{{ $items->tanggal_berlaku }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Habis Masa Berlaku</label>
                                        <input type="date" class="form-control" name="tanggal_habis"
                                            value="{{ $items->tanggal_habis }}">
                                    </div>

                                    <div class="form-group  mt-2">
                                        <label for="masa_berlaku">Masa Berlaku</label>
                                        <select name="masa_berlaku" class="form-select">
                                            <option value="">Pilih Masa Berlaku</option>
                                            <option value="Tidak Ada"
                                                @if ($items->masa_berlaku == 'Tidak Ada') {{ 'selected="selected"' }} @endif>
                                                Tidak Ada</option>
                                            <option value="1 Bulan"
                                                @if ($items->masa_berlaku == '1 Bulan') {{ 'selected="selected"' }} @endif>
                                                1 Bulan</option>
                                            <option value="3 Bulan"
                                                @if ($items->masa_berlaku == '3 Bulan') {{ 'selected="selected"' }} @endif>
                                                3 Bulan
                                            </option>
                                            <option value="6 Bulan"
                                                @if ($items->masa_berlaku == '6 Bulan') {{ 'selected="selected"' }} @endif>
                                                6 Bulan</option>
                                            <option value="1 Tahun"
                                                @if ($items->masa_berlaku == '1 Tahun') {{ 'selected="selected"' }} @endif>
                                                1 Tahun</option>
                                            <option value="2 Tahun"
                                                @if ($items->masa_berlaku == '2 Tahun') {{ 'selected="selected"' }} @endif>
                                                2 Tahun</option>
                                            <option value="3 Tahun"
                                                @if ($items->masa_berlaku == '3 Tahun') {{ 'selected="selected"' }} @endif>
                                                3 Tahun</option>
                                            <option value="4 Tahun"
                                                @if ($items->masa_berlaku == '4 Tahun') {{ 'selected="selected"' }} @endif>
                                                4 Tahun</option>
                                            <option value="5 Tahun"
                                                @if ($items->masa_berlaku == '5 Tahun') {{ 'selected="selected"' }} @endif>
                                                5 Tahun</option>
                                            <option value="6 Tahun"
                                                @if ($items->masa_berlaku == '6 Tahun') {{ 'selected="selected"' }} @endif>
                                                6 Tahun</option>
                                            <option value="7 Tahun"
                                                @if ($items->masa_berlaku == '7 Tahun') {{ 'selected="selected"' }} @endif>
                                                7 Tahun</option>
                                            <option value="8 Tahun"
                                                @if ($items->masa_berlaku == '8 Tahun') {{ 'selected="selected"' }} @endif>
                                                8 Tahun</option>
                                            <option value="9 Tahun"
                                                @if ($items->masa_berlaku == '9 Tahun') {{ 'selected="selected"' }} @endif>
                                                9 Tahun</option>
                                            <option value="10 Tahun"
                                                @if ($items->masa_berlaku == '10 Tahun') {{ 'selected="selected"' }} @endif>
                                                10 Tahun</option>

                                        </select>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Update Data
                                        </button>
                                        <a href="{{ route('laporan.perijinan') }}" class="btn btn-danger btn-block">
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
