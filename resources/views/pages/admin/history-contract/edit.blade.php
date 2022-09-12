@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Karyawan</li>
                    <li class="breadcrumb-item active">Data Karyawan Aktif</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Edit Data History Kontrak {{ $item->nama_karyawan }}
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
                            <form action="{{ route('history_contract.update', $historycontracts->id) }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group">

                                    <input type="hidden" class="form-control" name="edit_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">NIK Karyawan</label>
                                        <input type="text" class="form-control" name="nik_karyawan"
                                            placeholder="Masukan NIK Karyawan" value="{{ $item->nik_karyawan }}" readonly>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" name="nama_karyawan"
                                            placeholder="Masukan Nama Karyawan" value="{{ $item->nama_karyawan }}" readonly>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Awal Kontrak</label>
                                        <input type="date" class="form-control" name="tanggal_awal_kontrak"
                                            placeholder="Masukan Tanggal Awal Kontrak"
                                            value="{{ $historycontracts->tanggal_awal_kontrak }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Akhir Kontrak</label>
                                        <input type="date" class="form-control" name="tanggal_akhir_kontrak"
                                            placeholder="Masukan Tanggal Akhir Kontrak"
                                            value="{{ $historycontracts->tanggal_akhir_kontrak }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="status_kontrak_kerja" class="form-label">Status Kontrak
                                            Kerja</label>
                                        <select name="status_kontrak_kerja" class="form-select">
                                            <option value="">Pilih Status Kerja</option>
                                            <option value="PKWT"
                                                @if ($historycontracts->status_kontrak_kerja == 'PKWT') {{ 'selected="selected"' }} @endif>PKWT
                                            </option>
                                            <option value="PKWTT"
                                                @if ($historycontracts->status_kontrak_kerja == 'PKWTT') {{ 'selected="selected"' }} @endif>PKWTT
                                            </option>
                                            <option value="Harian"
                                                @if ($historycontracts->status_kontrak_kerja == 'Harian') {{ 'selected="selected"' }} @endif>
                                                Harian</option>
                                            <option value="Outsourcing"
                                                @if ($historycontracts->status_kontrak_kerja == 'Outsourcing') {{ 'selected="selected"' }} @endif>
                                                Outsourcing
                                            </option>
                                        </select>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Update
                                        </button>
                                        <a href="{{ route('employee.show', $item->id) }}" class="btn btn-danger btn-block">
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
