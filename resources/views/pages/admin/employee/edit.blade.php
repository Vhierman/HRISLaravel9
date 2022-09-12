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
                        Edit Data Karyawan
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
                            <form action="{{ route('employee.update', $item->id) }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <input type="hidden" class="form-control" name="edit_oleh" placeholder="Name"
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

                                        <div class="form-group mt-4">
                                            <label for="companies_id">Perusahaan</label>
                                            <select name="companies_id" class="form-select">
                                                <option value="{{ $item->companies_id }}">Pilih Perusahaan</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        @if ($item->companies_id == $company->id) {{ 'selected="selected"' }} @endif>
                                                        {{ $company->nama_perusahaan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="areas_id">Area</label>
                                            <select name="areas_id" class="form-select">
                                                <option value="{{ $item->areas_id }}">Pilih Area</option>
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}"
                                                        @if ($item->areas_id == $area->id) {{ 'selected="selected"' }} @endif>
                                                        {{ $area->area }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="divisions_id">Penempatan</label>
                                            <select name="divisions_id" class="form-select">
                                                <option value="{{ $item->divisions_id }}">Pilih Penempatan</option>
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}"
                                                        @if ($item->divisions_id == $division->id) {{ 'selected="selected"' }} @endif>
                                                        {{ $division->penempatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="positions_id">Jabatan</label>
                                            <select name="positions_id" class="form-select">
                                                <option value="{{ $item->positions_id }}">Pilih Penempatan</option>
                                                @foreach ($positions as $position)
                                                    <option value="{{ $position->id }}"
                                                        @if ($item->positions_id == $position->id) {{ 'selected="selected"' }} @endif>
                                                        {{ $position->jabatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="golongans_id">Golongan</label>
                                            <select name="golongans_id" class="form-select">
                                                <option value="{{ $item->golongans_id }}">Pilih Golongan</option>
                                                @foreach ($golongans as $golongan)
                                                    <option value="{{ $golongan->id }}"
                                                        @if ($item->golongans_id == $golongan->id) {{ 'selected="selected"' }} @endif>
                                                        {{ $golongan->golongan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="working_hours_id">Jam Kerja</label>
                                            <select name="working_hours_id" class="form-select">
                                                <option value="{{ $item->working_hours_id }}">Pilih Jam Kerja</option>
                                                @foreach ($workinghours as $workinghour)
                                                    <option value="{{ $workinghour->id }}"
                                                        @if ($item->working_hours_id == $workinghour->id) {{ 'selected="selected"' }} @endif>
                                                        {{ $workinghour->jam_masuk . ' s/d ' . $workinghour->jam_pulang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Tanggal Masuk Kerja</label>
                                            <input type="date" class="form-control" name="tanggal_mulai_kerja"
                                                placeholder="dd/mm/yyyy" value="{{ $item->tanggal_mulai_kerja }}">
                                        </div>

                                        @if ($item->status_kerja == 'PKWTT')
                                            <div class="form-group mt-2">
                                                {{-- <label for="title" class="form-label">Tanggal Akhir Kerja</label> --}}
                                                <input type="hidden" class="form-control" name="tanggal_akhir_kerja"
                                                    placeholder="dd/mm/yyyy" value="{{ $item->tanggal_akhir_kerja }}">
                                            </div>
                                            <div class="form-group mt-2">
                                                <label for="title" class="form-label">Status Kerja</label>
                                                <input type="text" readonly class="form-control" name="status_kerja"
                                                    placeholder="Status Kerja" value="{{ $item->status_kerja }}"
                                                    readonly>
                                            </div>
                                        @else
                                            <div class="form-group mt-2">
                                                <label for="title" class="form-label">Tanggal Akhir Kerja</label>
                                                <input type="date" class="form-control" name="tanggal_akhir_kerja"
                                                    placeholder="dd/mm/yyyy" value="{{ $item->tanggal_akhir_kerja }}">
                                            </div>
                                            <div class="form-group  mt-2">
                                                <label for="status_kerja">Status Kerja</label>
                                                <select name="status_kerja" class="form-select">
                                                    <option value="">Pilih Status Kerja</option>
                                                    <option value="PKWT"
                                                        @if ($item->status_kerja == 'PKWT') {{ 'selected="selected"' }} @endif>
                                                        PKWT</option>
                                                    <option value="PKWTT"
                                                        @if ($item->status_kerja == 'PKWTT') {{ 'selected="selected"' }} @endif>
                                                        PKWTT</option>
                                                    <option value="Harian"
                                                        @if ($item->status_kerja == 'Harian') {{ 'selected="selected"' }} @endif>
                                                        Harian</option>
                                                    <option value="Outsourcing"
                                                        @if ($item->status_kerja == 'Outsourcing') {{ 'selected="selected"' }} @endif>
                                                        Outsourcing
                                                    </option>
                                                </select>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="tab-pane fade" id="karyawan" role="tabpanel"
                                        aria-labelledby="karyawan-tab">
                                        <div class="form-group mt-4">
                                            <label for="title" class="form-label">NIK KTP Karyawan</label>
                                            <input type="text" onkeyup="angka(this);" maxlength="16"
                                                class="form-control" readonly name="nik_karyawan"
                                                placeholder="Masukan NIK KTP" value="{{ $item->nik_karyawan }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nama Karyawan</label>
                                            <input type="text" onkeyup="huruf(this);" maxlength="50"
                                                class="form-control" name="nama_karyawan"
                                                placeholder="Masukan Nama Karyawan" value="{{ $item->nama_karyawan }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Email Karyawan</label>
                                            <input type="text" class="form-control" name="email_karyawan"
                                                placeholder="Masukan Email Karyawan" value="{{ $item->email_karyawan }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nomor Absen</label>
                                            <input type="text" class="form-control" onkeyup="angka(this);"
                                                maxlength="4" name="nomor_absen" placeholder="Masukan Nomor Absen"
                                                value="{{ $item->nomor_absen }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nomor NPWP</label>
                                            <input type="text" class="form-control" onkeyup="angka(this);"
                                                maxlength="15" name="nomor_npwp"
                                                placeholder="Masukan Nomor NPWP (Tanpa Karakter Khusus Hanya Angka)"
                                                value="{{ $item->nomor_npwp }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nomor Handphone</label>
                                            <input type="text" class="form-control" onkeyup="angka(this);"
                                                maxlength="15" name="nomor_handphone"
                                                placeholder="Masukan Nomor Handphone (Tanpa Karakter Khusus Hanya Angka)"
                                                value="{{ $item->nomor_handphone }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Tempat Lahir</label>
                                            <input type="text" class="form-control" maxlength="30"
                                                name="tempat_lahir" placeholder="Masukan Tempat Lahir"
                                                value="{{ $item->tempat_lahir }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tanggal_lahir"
                                                placeholder="dd/mm/yyyy" value="{{ $item->tanggal_lahir }}">
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="agama">Agama</label>
                                            <select name="agama" class="form-select">
                                                <option value="">Pilih Agama</option>
                                                <option value="Islam"
                                                    @if ($item->agama == 'Islam') {{ 'selected="selected"' }} @endif>
                                                    Islam</option>
                                                <option value="Kristen Protestan"
                                                    @if ($item->agama == 'Kristen Protestan') {{ 'selected="selected"' }} @endif>
                                                    Kristen
                                                    Protestan</option>
                                                <option value="Kristen Katholik"
                                                    @if ($item->agama == 'Kristen Katholik') {{ 'selected="selected"' }} @endif>
                                                    Kristen Katholik
                                                </option>
                                                <option value="Hindu"
                                                    @if ($item->agama == 'Hindu') {{ 'selected="selected"' }} @endif>
                                                    Hindu</option>
                                                <option value="Budha"
                                                    @if ($item->agama == 'Budha') {{ 'selected="selected"' }} @endif>
                                                    Budha</option>
                                                <option value="Konghucu"
                                                    @if ($item->agama == 'Konghucu') {{ 'selected="selected"' }} @endif>
                                                    Konghucu</option>
                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="form-select">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="Pria"
                                                    @if ($item->jenis_kelamin == 'Pria') {{ 'selected="selected"' }} @endif>
                                                    Pria</option>
                                                <option value="Wanita"
                                                    @if ($item->jenis_kelamin == 'Wanita') {{ 'selected="selected"' }} @endif>
                                                    Wanita</option>
                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                                            <select name="pendidikan_terakhir" class="form-select">
                                                <option value="">Pilih Pendidikan Terakhir</option>
                                                <option value="SD"
                                                    @if ($item->pendidikan_terakhir == 'SD') {{ 'selected="selected"' }} @endif>
                                                    SD</option>
                                                <option value="SMP"
                                                    @if ($item->pendidikan_terakhir == 'SMP') {{ 'selected="selected"' }} @endif>
                                                    SMP</option>
                                                <option value="SMA/SMK"
                                                    @if ($item->pendidikan_terakhir == 'SMA/SMK') {{ 'selected="selected"' }} @endif>
                                                    SMA/SMK</option>
                                                <option value="D1"
                                                    @if ($item->pendidikan_terakhir == 'D1') {{ 'selected="selected"' }} @endif>
                                                    D1</option>
                                                <option value="D2"
                                                    @if ($item->pendidikan_terakhir == 'D2') {{ 'selected="selected"' }} @endif>
                                                    D2</option>
                                                <option value="D3"
                                                    @if ($item->pendidikan_terakhir == 'D3') {{ 'selected="selected"' }} @endif>
                                                    D3</option>
                                                <option value="S1"
                                                    @if ($item->pendidikan_terakhir == 'S1') {{ 'selected="selected"' }} @endif>
                                                    S1</option>
                                                <option value="S2"
                                                    @if ($item->pendidikan_terakhir == 'S2') {{ 'selected="selected"' }} @endif>
                                                    S2</option>
                                                <option value="S3"
                                                    @if ($item->pendidikan_terakhir == 'S3') {{ 'selected="selected"' }} @endif>
                                                    S3</option>
                                            </select>
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="golongan_darah">Golongan Darah</label>
                                            <select name="golongan_darah" class="form-select">
                                                <option value="">Pilih Golongan Darah</option>
                                                <option value="A"
                                                    @if ($item->golongan_darah == 'A') {{ 'selected="selected"' }} @endif>
                                                    A</option>
                                                <option value="B"
                                                    @if ($item->golongan_darah == 'B') {{ 'selected="selected"' }} @endif>
                                                    B</option>
                                                <option value="AB"
                                                    @if ($item->golongan_darah == 'AB') {{ 'selected="selected"' }} @endif>
                                                    AB</option>
                                                <option value="O"
                                                    @if ($item->golongan_darah == 'O') {{ 'selected="selected"' }} @endif>
                                                    O</option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Alamat</label>
                                            <input type="text" class="form-control" maxlength="80" name="alamat"
                                                placeholder="Masukan Alamat" value="{{ $item->alamat }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" placeholder="Masukan Nomor RT"
                                                        class="form-control" onkeyup="angka(this);" maxlength="3"
                                                        name="rt" value="{{ $item->rt }}">
                                                </div>
                                                <div class="col">
                                                    <input type="text" placeholder="Masukan Nomor RT"
                                                        class="form-control" onkeyup="angka(this);" maxlength="3"
                                                        name="rw" value="{{ $item->rw }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" placeholder="Masukan Nama Kelurahan"
                                                        class="form-control" maxlength="30" name="kelurahan"
                                                        value="{{ $item->kelurahan }}">
                                                </div>
                                                <div class="col">
                                                    <input type="text" placeholder="Masukan Nama Kecamatan"
                                                        class="form-control" maxlength="30" name="kecamatan"
                                                        value="{{ $item->kecamatan }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" placeholder="Masukan Nama Kota"
                                                        class="form-control" maxlength="30" name="kota"
                                                        value="{{ $item->kota }}">
                                                </div>
                                                <div class="col">
                                                    <input type="text" placeholder="Masukan Nama Provinsi"
                                                        class="form-control" maxlength="30" name="provinsi"
                                                        value="{{ $item->provinsi }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Kode POS</label>
                                            <input type="text" class="form-control" onkeyup="angka(this);"
                                                maxlength="5" name="kode_pos" placeholder="Masukan Nomor Kode POS"
                                                value="{{ $item->kode_pos }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nomor Kartu Keluarga</label>
                                            <input type="text" class="form-control" onkeyup="angka(this);"
                                                maxlength="16" name="nomor_kartu_keluarga"
                                                placeholder="Masukan Nomor Kartu Keluarga"
                                                value="{{ $item->nomor_kartu_keluarga }}">
                                        </div>
                                        <div class="form-group  mt-2">
                                            <label for="status_nikah">Status Menikah</label>
                                            <select name="status_nikah" class="form-select">
                                                <option value="">Pilih Status Menikah</option>
                                                <option value="Single"
                                                    @if ($item->status_nikah == 'Single') {{ 'selected="selected"' }} @endif>
                                                    Single</option>
                                                <option value="Menikah"
                                                    @if ($item->status_nikah == 'Menikah') {{ 'selected="selected"' }} @endif>
                                                    Menikah</option>
                                                <option value="Janda"
                                                    @if ($item->status_nikah == 'Janda') {{ 'selected="selected"' }} @endif>
                                                    Janda</option>
                                                <option value="Duda"
                                                    @if ($item->status_nikah == 'Duda') {{ 'selected="selected"' }} @endif>
                                                    Duda</option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nama Ayah Kandung</label>
                                            <input type="text" class="form-control" onkeyup="huruf(this);"
                                                maxlength="30" name="nama_ayah" placeholder="Masukan Nama Ayah Kandung"
                                                value="{{ $item->nama_ayah }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nama Ibu Kandung</label>
                                            <input type="text" class="form-control" onkeyup="huruf(this);"
                                                maxlength="30" name="nama_ibu" placeholder="Masukan Nama Ibu Kandung"
                                                value="{{ $item->nama_ibu }}">
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="gaji" role="tabpanel"
                                        aria-labelledby="gaji-tab">

                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nomor Rekening</label>
                                            <input type="text" maxlength="30" class="form-control"
                                                name="nomor_rekening"
                                                placeholder="Masukan Nomor Rekening (Tanpa Karakter Khusus Hanya Angka)"
                                                value="{{ $item->nomor_rekening }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="nama_bank">Nama Bank</label>
                                            <select name="nama_bank" class="form-select">
                                                <option value="">Pilih Nama Bank</option>
                                                <option value="Permata"
                                                    @if ($item->nama_bank == 'Permata') {{ 'selected="selected"' }} @endif>
                                                    Permata</option>
                                                <option value="Mandiri"
                                                    @if ($item->nama_bank == 'Mandiri') {{ 'selected="selected"' }} @endif>
                                                    Mandiri</option>
                                            </select>
                                        </div>
                                        {{-- <div class="form-group mt-2">
                                            <label for="text">Gaji Pokok</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                <input type="text" name="gaji_pokok" class="form-control" maxlength="9"
                                                    onkeyup="angka(this);" value="{{ $salary->gaji_pokok }}"
                                                    placeholder="Masukan Gaji Pokok (Tanpa Karakter Khusus Hanya Angka)"
                                                    aria-label="text" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="text">Uang Makan</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                <input type="text" name="uang_makan" value="{{ $salary->uang_makan }}"
                                                    class="form-control" maxlength="9" onkeyup="angka(this);"
                                                    placeholder="Masukan Uang Makan (Tanpa Karakter Khusus Hanya Angka)"
                                                    aria-label="text" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="text">Uang Transport</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                <input type="text" name="uang_transport" class="form-control"
                                                    maxlength="9" onkeyup="angka(this);"
                                                    value="{{ $salary->uang_transport }}"
                                                    placeholder="Masukan Uang Transport (Tanpa Karakter Khusus Hanya Angka)"
                                                    aria-label="text" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="text">Tunjangan Tugas</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                <input type="text" name="tunjangan_tugas" class="form-control"
                                                    maxlength="9" onkeyup="angka(this);"
                                                    value="{{ $salary->tunjangan_tugas }}"
                                                    placeholder="Masukan Tunjangan Tugas (Tanpa Karakter Khusus Hanya Angka)"
                                                    aria-label="text" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="text">Tunjangan Pulsa</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                <input type="text" name="tunjangan_pulsa" class="form-control"
                                                    maxlength="9" onkeyup="angka(this);"
                                                    value="{{ $salary->tunjangan_pulsa }}"
                                                    placeholder="Masukan Tunjangan Pulsa (Tanpa Karakter Khusus Hanya Angka)"
                                                    aria-label="text" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="text">Tunjangan Jabatan</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                <input type="text" name="tunjangan_jabatan" class="form-control"
                                                    maxlength="9" onkeyup="angka(this);"
                                                    value="{{ $salary->tunjangan_jabatan }}"
                                                    placeholder="Masukan Tunjangan Jabatan (Tanpa Karakter Khusus Hanya Angka)"
                                                    aria-label="text" aria-describedby="basic-addon1">
                                            </div>
                                        </div> --}}
                                        {{-- <div class="form-group mt-2">
                                            <label for="title" class="form-label">Kepesertaan BPJS Ketenagakerjaan &
                                                Kesehatan</label>
                                        </div>
                                        <div class="form-group mt-2">
                                            <input class="form-check-input" name="jht" type="hidden" id="inlineCheckbox1"
                                                value="0">
                                            <input class="form-check-input" name="jht" type="checkbox" id="inlineCheckbox1"
                                                value="1" @if ($salary->potongan_jht_perusahaan != 0) checked @endif>
                                            <label class="form-check-label" for="inlineCheckbox1">JHT</label>

                                            <input class="form-check-input" name="jp" type="hidden" id="inlineCheckbox1"
                                                value="0">
                                            <input class="form-check-input" name="jp" type="checkbox" id="inlineCheckbox2"
                                                value="1" @if ($salary->potongan_jp_perusahaan != 0) checked @endif>
                                            <label class="form-check-label" for="inlineCheckbox2">JP</label>

                                            <input class="form-check-input" name="jkk" type="hidden" id="inlineCheckbox1"
                                                value="0">
                                            <input class="form-check-input" name="jkk" type="checkbox" id="inlineCheckbox3"
                                                value="1" @if ($salary->potongan_jkk_perusahaan != 0) checked @endif>
                                            <label class="form-check-label" for="inlineCheckbox3">JKK</label>

                                            <input class="form-check-input" name="jkm" type="hidden" id="inlineCheckbox1"
                                                value="0">
                                            <input class="form-check-input" name="jkm" type="checkbox" id="inlineCheckbox4"
                                                value="1" @if ($salary->potongan_jkm_perusahaan != 0) checked @endif>
                                            <label class="form-check-label" for="inlineCheckbox4">JKM</label>

                                            <input class="form-check-input" name="jkn" type="hidden" id="inlineCheckbox1"
                                                value="0">
                                            <input class="form-check-input" name="jkn" type="checkbox" id="inlineCheckbox5"
                                                value="1" @if ($salary->potongan_bpjsks_perusahaan != 0) checked @endif>
                                            <label class="form-check-label" for="inlineCheckbox5">JKN</label>
                                        </div> --}}
                                    </div>

                                    <div class="tab-pane fade" id="foto" role="tabpanel"
                                        aria-labelledby="foto-tab">
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor"
                                                class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"
                                                viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                                <path
                                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                            </svg> Jika Foto Tidak Diubah Maka Kosongkan
                                            Saja.
                                            <a class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
                                        </div>

                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Foto Karyawan</label>
                                            <input type="file" class="form-control" name="foto_karyawan"
                                                value="{{ $item->foto_karyawan }}">
                                            <input type="hidden" class="form-control" name="fotokaryawan"
                                                value="{{ $item->foto_karyawan }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Foto KTP</label>
                                            <input type="file" class="form-control" name="foto_ktp"
                                                value="{{ $item->foto_ktp }}">
                                            <input type="hidden" class="form-control" name="fotoktp"
                                                value="{{ $item->foto_ktp }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Foto NPWP</label>
                                            <input type="file" class="form-control" name="foto_npwp"
                                                value="{{ $item->foto_npwp }}">
                                            <input type="hidden" class="form-control" name="fotonpwp"
                                                value="{{ $item->foto_npwp }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Foto Kartu Keluarga</label>
                                            <input type="file" class="form-control" name="foto_kk"
                                                value="{{ $item->foto_kk }}">
                                            <input type="hidden" class="form-control" name="fotokk"
                                                value="{{ $item->foto_kk }}">
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="bpjs" role="tabpanel"
                                        aria-labelledby="bpjs-tab">
                                        <div class="form-group mt-4">
                                            <label for="title" class="form-label">Nomor BPJS Kesehatan</label>
                                            <input type="text" class="form-control" name="nomor_bpjskesehatan"
                                                placeholder="Masukan Nomor BPJS Kesehatan" onkeyup="angka(this);"
                                                maxlength="13" value="{{ $item->nomor_bpjskesehatan }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Nomor BPJS Ketenagakerjaan</label>
                                            <input type="text" class="form-control" name="nomor_bpjsketenagakerjaan"
                                                placeholder="Masukan Nomor BPJS Ketenagakerjaan" maxlength="11"
                                                value="{{ $item->nomor_bpjsketenagakerjaan }}">
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Update
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
