@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item active">Sekolah</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Tambah Data Sekolah
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
                            <form action="{{ route('school.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">

                                    <input type="hidden" class="form-control" name="input_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

                                    <div class="form-group">
                                        <label for="title" class="form-label">Nama Sekolah</label>
                                        <input type="text" class="form-control" name="nama_sekolah"
                                            placeholder="Masukan Nama Sekolah" value="{{ old('nama_sekolah') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">No Telepon Sekolah</label>
                                        <input type="text" class="form-control" onkeyup="angka(this);"
                                            name="no_telepon_sekolah" placeholder="Masukan No Telepon Sekolah"
                                            value="{{ old('no_telepon_sekolah') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Email Sekolah</label>
                                        <input type="text" class="form-control" name="email_sekolah"
                                            placeholder="Masukan Email Sekolah" value="{{ old('email_sekolah') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Guru Pembimbing</label>
                                        <input type="text" class="form-control" maxlength="40" onkeyup="huruf(this);"
                                            name="nama_guru_pembimbing" placeholder="Masukan Nama Guru Pembimbing"
                                            value="{{ old('nama_guru_pembimbing') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">No HP Guru Pembimbing</label>
                                        <input type="text" class="form-control" onkeyup="angka(this);"
                                            name="no_handphone_guru_pembimbing" placeholder="Masukan No HP Guru Pembimbing"
                                            value="{{ old('no_handphone_guru_pembimbing') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Alamat Sekolah</label>
                                        <input type="text" class="form-control" name="alamat_sekolah"
                                            placeholder="Masukan Alamat Sekolah" value="{{ old('alamat_sekolah') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nomor RW" class="form-control"
                                                    onkeyup="angka(this);" maxlength="3" name="rt_sekolah"
                                                    value="{{ old('rt_sekolah') }}">
                                            </div>
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nomor RW" class="form-control"
                                                    onkeyup="angka(this);" maxlength="3" name="rw_sekolah"
                                                    value="{{ old('rw_sekolah') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nama Kelurahan"
                                                    class="form-control" maxlength="30" name="kelurahan_sekolah"
                                                    value="{{ old('kelurahan_sekolah') }}">
                                            </div>
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nama Kecamatan"
                                                    class="form-control" maxlength="30" name="kecamatan_sekolah"
                                                    value="{{ old('kecamatan_sekolah') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nama Kota"
                                                    class="form-control" maxlength="30" name="kota_sekolah"
                                                    value="{{ old('kota_sekolah') }}">
                                            </div>
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nama Provinsi"
                                                    class="form-control" maxlength="30" name="provinsi_sekolah"
                                                    value="{{ old('provinsi_sekolah') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Kode POS</label>
                                        <input type="text" class="form-control" onkeyup="angka(this);" maxlength="5"
                                            name="kode_pos_sekolah" placeholder="Masukan Nomor Kode POS"
                                            value="{{ old('kode_pos_sekolah') }}">
                                    </div>


                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Simpan
                                        </button>
                                        <a href="{{ route('school.index') }}" class="btn btn-danger btn-block">
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
