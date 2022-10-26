@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Absensi</li>
                    <li class="breadcrumb-item active">Data Absensi</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Tambah Data Absensi
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
                            <form action="{{ route('absensi.store') }}" method="post" enctype="multipart/form-data">
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
                                                    {{ $item->nama_karyawan . ' / ' . $item->positions->jabatan . ' / ' . $item->divisions->penempatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Absen</label>
                                        <input type="date" class="form-control" name="tanggal_absen"
                                            placeholder="dd/mm/yyyy" value="{{ old('tanggal_absen') }}">
                                    </div>

                                    <div class="form-group  mt-2">
                                        <label for="keterangan_absen">Keterangan Absen</label>
                                        <select name="keterangan_absen" class="form-select">
                                            <option value="">Pilih Keterangan Absen</option>
                                            <option value="Sakit"
                                                @if (old('keterangan_absen') == 'Sakit') {{ 'selected' }} @endif>Sakit
                                            </option>
                                            <option value="Ijin"
                                                @if (old('keterangan_absen') == 'Ijin') {{ 'selected' }} @endif>Ijin
                                            </option>
                                            <option value="Alpa"
                                                @if (old('keterangan_absen') == 'Alpa') {{ 'selected' }} @endif>Alpa
                                            </option>
                                            <option value="Cuti Tahunan"
                                                @if (old('keterangan_absen') == 'Cuti Tahunan') {{ 'selected' }} @endif>Cuti Tahunan
                                            </option>
                                            <option value="Cuti Khusus"
                                                @if (old('keterangan_absen') == 'Cuti Khusus') {{ 'selected' }} @endif>Cuti Khusus
                                            </option>
                                        </select>
                                    </div>


                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Keterangan Cuti Khusus</label>
                                        <span class="badge bg-danger">
                                            Diisi jika Karyawan Cuti Khusus, Jika Tidak Kosongkan Saja...!
                                        </span>
                                        <input type="text" class="form-control" name="keterangan_cuti_khusus"
                                            placeholder="Masukan Keterangan Cuti Khusus"
                                            value="{{ old('keterangan_cuti_khusus') }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Simpan
                                        </button>
                                        <a href="{{ route('absensi.index') }}" class="btn btn-danger btn-block">
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
