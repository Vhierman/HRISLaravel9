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
                        Tambah Data History Keluarga {{ $item->nama_karyawan }}
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
                            <form action="{{ route('history_family.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="input_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">NIK Karyawan</label>
                                        <input type="text" class="form-control" name="employees_id"
                                            placeholder="Masukan NIK Karyawan" value="{{ $item->nik_karyawan }}" readonly>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" name="nama_karyawan"
                                            placeholder="Masukan Nama Karyawan" value="{{ $item->nama_karyawan }}" readonly>
                                    </div>

                                    <div class="form-group  mt-2">
                                        <label for="hubungan_keluarga">Hubungan Keluarga</label>
                                        <select name="hubungan_keluarga" class="form-select">
                                            <option value="">Pilih Hubungan Keluarga</option>
                                            <option value="Istri"
                                                @if (old('hubungan_keluarga') == 'Istri') {{ 'selected' }} @endif>Istri</option>
                                            <option value="Suami"
                                                @if (old('hubungan_keluarga') == 'Suami') {{ 'selected' }} @endif>Suami</option>
                                            <option value="Anak"
                                                @if (old('hubungan_keluarga') == 'Anak') {{ 'selected' }} @endif>Anak</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">NIK KTP</label>
                                        <input type="text" class="form-control" name="nik_history_keluarga"
                                            onkeyup="angka(this);" maxlength="16" placeholder="Masukan NIK KTP"
                                            value="{{ old('nik_history_keluarga') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama_history_keluarga"
                                            maxlength="50" onkeyup="huruf(this);" placeholder="Masukan Nama Lengkap"
                                            value="{{ old('nama_history_keluarga') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">No BPJS</label>
                                        <input type="text" class="form-control"
                                            name="nomor_bpjs_kesehatan_history_keluarga" onkeyup="angka(this);"
                                            maxlength="13" placeholder="Masukan No BPJS Kesehatan"
                                            value="{{ old('nomor_bpjs_kesehatan_history_keluarga') }}">
                                    </div>

                                    <div class="form-group  mt-2">
                                        <label for="jenis_kelamin_history_keluarga">Jenis Kelamin</label>
                                        <select name="jenis_kelamin_history_keluarga" class="form-select">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Pria"
                                                @if (old('jenis_kelamin_history_keluarga') == 'Pria') {{ 'selected' }} @endif>Pria</option>
                                            <option value="Wanita"
                                                @if (old('jenis_kelamin_history_keluarga') == 'Wanita') {{ 'selected' }} @endif>Wanita
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" name="tempat_lahir_history_keluarga"
                                            maxlength="50" placeholder="Masukan Tempat Lahir"
                                            value="{{ old('tempat_lahir_history_keluarga') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="tanggal_lahir_history_keluarga"
                                            placeholder="Masukan Tanggal Lahir"
                                            value="{{ old('tanggal_lahir_history_keluarga') }}">
                                    </div>

                                    <div class="form-group  mt-2">
                                        <label for="golongan_darah_history_keluarga">Golongan Darah</label>
                                        <select name="golongan_darah_history_keluarga" class="form-select">
                                            <option value="">Pilih Golongan Darah</option>
                                            <option value="A"
                                                @if (old('golongan_darah_history_keluarga') == 'A') {{ 'selected' }} @endif>
                                                A</option>
                                            <option value="B"
                                                @if (old('golongan_darah_history_keluarga') == 'B') {{ 'selected' }} @endif>
                                                B</option>
                                            <option value="AB"
                                                @if (old('golongan_darah_history_keluarga') == 'AB') {{ 'selected' }} @endif>AB</option>
                                            <option value="O"
                                                @if (old('golongan_darah_history_keluarga') == 'O') {{ 'selected' }} @endif>
                                                O</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Dokumen <font color="red">*Hanya File
                                                JPEG,JPG,PNG
                                                (Maksimal 500kb) ( Jika Istri/Suami Dokumen KTP) (Jika Anak Dokumen Akta
                                                Kelahiran)</font>
                                        </label>
                                        <input type="file" class="form-control" name="dokumen_history_keluarga"
                                            value="{{ old('dokumen_history_keluarga') }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Simpan
                                        </button>
                                        <a href="{{ route('employee.show', $item->id) }}"
                                            class="btn btn-danger btn-block">
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
