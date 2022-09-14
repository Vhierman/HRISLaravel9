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
                        Tambah Data Karyawan
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
                            <form action="{{ route('employee.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" name="input_oleh" placeholder="Name"
                                    value="{{ Auth::user()->name }}">

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="divisi-tab" data-bs-toggle="tab"
                                            data-bs-target="#divisi" type="button" role="tab" aria-controls="divisi"
                                            aria-selected="true">Divisi</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="karyawan-tab" data-bs-toggle="tab"
                                            data-bs-target="#karyawan" type="button" role="tab"
                                            aria-controls="karyawan" aria-selected="false">Karyawan</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="gaji-tab" data-bs-toggle="tab" data-bs-target="#gaji"
                                            type="button" role="tab" aria-controls="gaji"
                                            aria-selected="false">Rekening</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="foto-tab" data-bs-toggle="tab" data-bs-target="#foto"
                                            type="button" role="tab" aria-controls="foto"
                                            aria-selected="false">Foto</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="bpjs-tab" data-bs-toggle="tab" data-bs-target="#bpjs"
                                            type="button" role="tab" aria-controls="bpjs"
                                            aria-selected="false">BPJS</button>
                                    </li>
                                </ul>


                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="divisi" role="tabpanel"
                                        aria-labelledby="divisi-tab">

                                        <div class="form-group mt-2 mb-2">
                                            <label for="companies_id">Perusahaan</label>
                                            <select name="companies_id" class="form-select">
                                                <option value="">Pilih Perusahaan</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}">
                                                        {{ $company->nama_perusahaan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="areas_id">Area</label>
                                            <select name="areas_id" class="form-select">
                                                <option value="">Pilih Area</option>
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}">
                                                        {{ $area->area }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="divisions_id">Penempatan</label>
                                            <select name="divisions_id" class="form-select">
                                                <option value="">Pilih Penempatan</option>
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}">
                                                        {{ $division->penempatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="positions_id">Golongan</label>
                                            <select name="golongans_id" class="form-select">
                                                <option value="">Pilih Golongan</option>
                                                @foreach ($golongans as $golongan)
                                                    <option value="{{ $golongan->id }}">
                                                        {{ $golongan->golongan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="positions_id">Jabatan</label>
                                            <select name="positions_id" class="form-select">
                                                <option value="">Pilih Jabatan</option>
                                                @foreach ($positions as $position)
                                                    <option value="{{ $position->id }}">
                                                        {{ $position->jabatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="working_hours_id">Jam Kerja</label>
                                            <select name="working_hours_id" class="form-select">
                                                <option value="">Pilih Jam Kerja</option>
                                                @foreach ($workinghours as $workinghour)
                                                    <option value="{{ $workinghour->id }}">
                                                        {{ $workinghour->jam_masuk . ' s/d ' . $workinghour->jam_pulang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Tanggal Masuk Kerja</label>
                                            <input type="date" class="form-control" name="tanggal_mulai_kerja"
                                                placeholder="dd/mm/yyyy" value="{{ old('tanggal_mulai_kerja') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Tanggal Akhir Kerja</label>
                                            <input type="date" class="form-control" name="tanggal_akhir_kerja"
                                                placeholder="dd/mm/yyyy" value="{{ old('tanggal_akhir_kerja') }}">
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="status_kerja">Status Kerja</label>
                                            <select name="status_kerja" class="form-select">
                                                <option value="">Pilih Status Kerja</option>
                                                <option value="PKWT"
                                                    @if (old('status_kerja') == 'PKWT') {{ 'selected' }} @endif>PKWT
                                                </option>
                                                <option value="PKWTT"
                                                    @if (old('status_kerja') == 'PKWTT') {{ 'selected' }} @endif>PKWTT
                                                </option>
                                                <option value="Harian"
                                                    @if (old('status_kerja') == 'Harian') {{ 'selected' }} @endif>Harian
                                                </option>
                                                <option value="Outsourcing"
                                                    @if (old('status_kerja') == 'Outsourcing') {{ 'selected' }} @endif>
                                                    Outsourcing</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="karyawan" role="tabpanel"
                                        aria-labelledby="karyawan-tab">
                                        <div class="form-group mt-4">
                                            <label for="title" class="form-label">NIK KTP Karyawan</label>
                                            <input type="text" onkeyup="angka(this);" maxlength="16"
                                                class="form-control" name="nik_karyawan" placeholder="Masukan NIK KTP"
                                                value="{{ old('nik_karyawan') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nama Karyawan</label>
                                            <input type="text" onkeyup="huruf(this);" maxlength="50"
                                                class="form-control" name="nama_karyawan"
                                                placeholder="Masukan Nama Karyawan" value="{{ old('nama_karyawan') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Email Karyawan</label>
                                            <input type="text" class="form-control" name="email_karyawan"
                                                placeholder="Masukan Email Karyawan" value="{{ old('email_karyawan') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nomor Absen</label>
                                            <input type="text" class="form-control" onkeyup="angka(this);"
                                                maxlength="4" name="nomor_absen" placeholder="Masukan Nomor Absen"
                                                value="{{ old('nomor_absen') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nomor NPWP</label>
                                            <input type="text" class="form-control" onkeyup="angka(this);"
                                                maxlength="15" name="nomor_npwp"
                                                placeholder="Masukan Nomor NPWP (Tanpa Karakter Khusus Hanya Angka)"
                                                value="{{ old('nomor_npwp') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nomor Handphone</label>
                                            <input type="text" class="form-control" onkeyup="angka(this);"
                                                name="nomor_handphone"
                                                placeholder="Masukan Nomor Handphone (Tanpa Karakter Khusus Hanya Angka)"
                                                value="{{ old('nomor_handphone') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Tempat Lahir</label>
                                            <input type="text" class="form-control" maxlength="30"
                                                name="tempat_lahir" placeholder="Masukan Tempat Lahir"
                                                value="{{ old('tempat_lahir') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tanggal_lahir"
                                                placeholder="dd/mm/yyyy" value="{{ old('tanggal_lahir') }}">
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="agama">Agama</label>
                                            <select name="agama" class="form-select">
                                                <option value="">Pilih Agama</option>
                                                <option value="Islam"
                                                    @if (old('agama') == 'Islam') {{ 'selected' }} @endif>Islam
                                                </option>
                                                <option value="Kristen Protestan"
                                                    @if (old('agama') == 'Kristen Protestan') {{ 'selected' }} @endif>Kristen
                                                    Protestan
                                                </option>
                                                <option value="Kristen Katholik"
                                                    @if (old('agama') == 'Kristen Katholik') {{ 'selected' }} @endif>Kristen
                                                    Katholik
                                                </option>
                                                <option value="Hindu"
                                                    @if (old('agama') == 'Hindu') {{ 'selected' }} @endif>Hindu
                                                </option>
                                                <option value="Budha"
                                                    @if (old('agama') == 'Budha') {{ 'selected' }} @endif>Budha
                                                </option>
                                                <option value="Konghucu"
                                                    @if (old('agama') == 'Konghucu') {{ 'selected' }} @endif>Konghucu
                                                </option>

                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="form-select">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="Pria"
                                                    @if (old('jenis_kelamin') == 'Pria') {{ 'selected' }} @endif>Pria
                                                </option>
                                                <option value="Wanita"
                                                    @if (old('jenis_kelamin') == 'Wanita') {{ 'selected' }} @endif>Wanita
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                                            <select name="pendidikan_terakhir" class="form-select">
                                                <option value="">Pilih Pendidikan Terakhir</option>
                                                <option value="SD"
                                                    @if (old('pendidikan_terakhir') == 'SD') {{ 'selected' }} @endif>SD
                                                </option>
                                                <option value="SMP"
                                                    @if (old('pendidikan_terakhir') == 'SMP') {{ 'selected' }} @endif>SMP
                                                </option>
                                                <option value="SMA/SMK"
                                                    @if (old('pendidikan_terakhir') == 'SMA/SMK') {{ 'selected' }} @endif>SMA/SMK
                                                </option>
                                                <option value="D1"
                                                    @if (old('pendidikan_terakhir') == 'D1') {{ 'selected' }} @endif>D1
                                                </option>
                                                <option value="D2"
                                                    @if (old('pendidikan_terakhir') == 'D2') {{ 'selected' }} @endif>D2
                                                </option>
                                                <option value="D3"
                                                    @if (old('pendidikan_terakhir') == 'D3') {{ 'selected' }} @endif>D3
                                                </option>
                                                <option value="S1"
                                                    @if (old('pendidikan_terakhir') == 'S1') {{ 'selected' }} @endif>S1
                                                </option>
                                                <option value="S2"
                                                    @if (old('pendidikan_terakhir') == 'S2') {{ 'selected' }} @endif>S2
                                                </option>
                                                <option value="S3"
                                                    @if (old('pendidikan_terakhir') == 'S3') {{ 'selected' }} @endif>S3
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="golongan_darah">Golongan Darah</label>
                                            <select name="golongan_darah" class="form-select">
                                                <option value="">Pilih Golongan Darah</option>
                                                <option value="A"
                                                    @if (old('golongan_darah') == 'A') {{ 'selected' }} @endif>A
                                                </option>
                                                <option value="B"
                                                    @if (old('golongan_darah') == 'B') {{ 'selected' }} @endif>B
                                                </option>
                                                <option value="AB"
                                                    @if (old('golongan_darah') == 'AB') {{ 'selected' }} @endif>AB
                                                </option>
                                                <option value="O"
                                                    @if (old('golongan_darah') == 'O') {{ 'selected' }} @endif>O
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Alamat</label>
                                            <input type="text" class="form-control" maxlength="80" name="alamat"
                                                placeholder="Masukan Alamat" value="{{ old('alamat') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" placeholder="Masukan Nomor RT"
                                                        class="form-control" onkeyup="angka(this);" maxlength="3"
                                                        name="rt" value="{{ old('rt') }}">
                                                </div>
                                                <div class="col">
                                                    <input type="text" placeholder="Masukan Nomor RW"
                                                        class="form-control" onkeyup="angka(this);" maxlength="3"
                                                        name="rw" value="{{ old('rw') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" placeholder="Masukan Nama Kelurahan"
                                                        class="form-control" maxlength="30" name="kelurahan"
                                                        value="{{ old('kelurahan') }}">
                                                </div>
                                                <div class="col">
                                                    <input type="text" placeholder="Masukan Nama Kecamatan"
                                                        class="form-control" maxlength="30" name="kecamatan"
                                                        value="{{ old('kecamatan') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" placeholder="Masukan Nama Kota"
                                                        class="form-control" maxlength="30" name="kota"
                                                        value="{{ old('kota') }}">
                                                </div>
                                                <div class="col">
                                                    <input type="text" placeholder="Masukan Nama Provinsi"
                                                        class="form-control" maxlength="30" name="provinsi"
                                                        value="{{ old('provinsi') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Kode POS</label>
                                            <input type="text" class="form-control" onkeyup="angka(this);"
                                                maxlength="5" name="kode_pos" placeholder="Masukan Nomor Kode POS"
                                                value="{{ old('kode_pos') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nomor Kartu Keluarga</label>
                                            <input type="text" class="form-control" onkeyup="angka(this);"
                                                maxlength="16" name="nomor_kartu_keluarga"
                                                placeholder="Masukan Nomor Kartu Keluarga"
                                                value="{{ old('nomor_kartu_keluarga') }}">
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="status_nikah">Status Menikah</label>
                                            <select name="status_nikah" class="form-select">
                                                <option value="">Pilih Status Menikah</option>
                                                <option value="Single"
                                                    @if (old('status_nikah') == 'Single') {{ 'selected' }} @endif>Single
                                                </option>
                                                <option value="Menikah"
                                                    @if (old('status_nikah') == 'Menikah') {{ 'selected' }} @endif>Menikah
                                                </option>
                                                <option value="Janda"
                                                    @if (old('status_nikah') == 'Janda') {{ 'selected' }} @endif>Janda
                                                </option>
                                                <option value="Duda"
                                                    @if (old('status_nikah') == 'Duda') {{ 'selected' }} @endif>Duda
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nama Ayah Kandung</label>
                                            <input type="text" class="form-control" onkeyup="huruf(this);"
                                                maxlength="30" name="nama_ayah" placeholder="Masukan Nama Ayah Kandung"
                                                value="{{ old('nama_ayah') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nama Ibu Kandung</label>
                                            <input type="text" class="form-control" onkeyup="huruf(this);"
                                                maxlength="30" name="nama_ibu" placeholder="Masukan Nama Ibu Kandung"
                                                value="{{ old('nama_ibu') }}">
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="gaji" role="tabpanel"
                                        aria-labelledby="gaji-tab">
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nomor Rekening</label>
                                            <input type="text" maxlength="30" class="form-control"
                                                name="nomor_rekening"
                                                placeholder="Masukan Nomor Rekening (Tanpa Karakter Khusus Hanya Angka)"
                                                value="{{ old('nomor_rekening') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="nama_bank">Nama Bank</label>
                                            <select name="nama_bank" class="form-select">
                                                <option value="">Pilih Nama Bank</option>
                                                <option value="Permata"
                                                    @if (old('nama_bank') == 'Permata') {{ 'selected' }} @endif>Permata
                                                </option>
                                                <option value="Mandiri"
                                                    @if (old('nama_bank') == 'Mandiri') {{ 'selected' }} @endif>Mandiri
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="gaji_pokok" class="form-control" maxlength="9"
                                                onkeyup="angka(this);" value="{{ $salary->minimal_upah }}" readonly
                                                placeholder="Masukan Gaji Pokok (Tanpa Karakter Khusus Hanya Angka)"
                                                aria-label="text" aria-describedby="basic-addon1">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="uang_makan" value="0" class="form-control"
                                                maxlength="9" onkeyup="angka(this);" readonly
                                                placeholder="Masukan Uang Makan (Tanpa Karakter Khusus Hanya Angka)"
                                                aria-label="text" aria-describedby="basic-addon1">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="uang_transport" class="form-control"
                                                maxlength="9" onkeyup="angka(this);" value="0" readonly
                                                placeholder="Masukan Uang Transport (Tanpa Karakter Khusus Hanya Angka)"
                                                aria-label="text" aria-describedby="basic-addon1">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="tunjangan_tugas" class="form-control"
                                                maxlength="9" onkeyup="angka(this);" value="0" readonly
                                                placeholder="Masukan Tunjangan Tugas (Tanpa Karakter Khusus Hanya Angka)"
                                                aria-label="text" aria-describedby="basic-addon1">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="tunjangan_pulsa" class="form-control"
                                                maxlength="9" onkeyup="angka(this);" value="0" readonly
                                                placeholder="Masukan Tunjangan Pulsa (Tanpa Karakter Khusus Hanya Angka)"
                                                aria-label="text" aria-describedby="basic-addon1">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="tunjangan_jabatan" class="form-control"
                                                maxlength="9" onkeyup="angka(this);" value="0" readonly
                                                placeholder="Masukan Tunjangan Jabatan (Tanpa Karakter Khusus Hanya Angka)"
                                                aria-label="text" aria-describedby="basic-addon1">
                                        </div>

                                        <div class="form-group">
                                            <label for="title" class="form-label">Kepesertaan BPJS Ketenagakerjaan &
                                                Kesehatan</label>
                                        </div>
                                        <div class="form-group mt-2">
                                            <input class="form-check-input" name="jht" type="hidden"
                                                id="inlineCheckbox1" value="0">
                                            <input class="form-check-input" name="jht" type="checkbox"
                                                id="inlineCheckbox1" value="1"
                                                {{ old('jht') != 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineCheckbox1">JHT</label>

                                            <input class="form-check-input" name="jp" type="hidden"
                                                id="inlineCheckbox1" value="0">
                                            <input class="form-check-input" name="jp" type="checkbox"
                                                id="inlineCheckbox2" value="1"
                                                {{ old('jp') != 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineCheckbox2">JP</label>

                                            <input class="form-check-input" name="jkk" type="hidden"
                                                id="inlineCheckbox1" value="0">
                                            <input class="form-check-input" name="jkk" type="checkbox"
                                                id="inlineCheckbox3" value="1"
                                                {{ old('jkk') != 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineCheckbox3">JKK</label>

                                            <input class="form-check-input" name="jkm" type="hidden"
                                                id="inlineCheckbox1" value="0">
                                            <input class="form-check-input" name="jkm" type="checkbox"
                                                id="inlineCheckbox4" value="1"
                                                {{ old('jkm') != 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineCheckbox4">JKM</label>

                                            <input class="form-check-input" name="jkn" type="hidden"
                                                id="inlineCheckbox1" value="0">
                                            <input class="form-check-input" name="jkn" type="checkbox"
                                                id="inlineCheckbox5" value="1"
                                                {{ old('jkn') != 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineCheckbox5">JKN</label>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="foto" role="tabpanel"
                                        aria-labelledby="foto-tab">
                                        <div class="form-group mt-4">
                                            <label for="title" class="form-label">Foto Karyawan</label>
                                            <input type="file" class="form-control" name="foto_karyawan"
                                                value="{{ old('foto_karyawan') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Foto KTP</label>
                                            <input type="file" class="form-control" name="foto_ktp"
                                                value="{{ old('foto_ktp') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Foto NPWP</label>
                                            <input type="file" class="form-control" name="foto_npwp"
                                                value="{{ old('foto_npwp') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Foto Kartu Keluarga</label>
                                            <input type="file" class="form-control" name="foto_kk"
                                                value="{{ old('foto_kk') }}">
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="bpjs" role="tabpanel"
                                        aria-labelledby="bpjs-tab">
                                        <div class="form-group mt-4">
                                            <label for="title" class="form-label">Nomor BPJS Kesehatan</label>
                                            <input type="text" class="form-control" name="nomor_bpjskesehatan"
                                                placeholder="Masukan Nomor BPJS Kesehatan" onkeyup="angka(this);"
                                                maxlength="13" value="{{ old('nomor_bpjskesehatan') }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nomor BPJS Ketenagakerjaan</label>
                                            <input type="text" class="form-control" name="nomor_bpjsketenagakerjaan"
                                                placeholder="Masukan Nomor BPJS Ketenagakerjaan" maxlength="11"
                                                value="{{ old('nomor_bpjsketenagakerjaan') }}">
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Simpan
                                        </button>
                                        <a href="{{ route('employee.index') }}" class="btn btn-danger btn-block">
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
