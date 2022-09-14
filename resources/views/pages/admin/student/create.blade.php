@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Siswa</li>
                    <li class="breadcrumb-item active">Data Siswa Prakerin</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Tambah Data Siswa
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
                            <form action="{{ route('student.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">

                                    <input type="hidden" class="form-control" name="input_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

                                    <div class="form-group  mt-2">
                                        <label for="schools_id">Sekolah</label>
                                        <select name="schools_id" class="form-select">
                                            <option value="">Pilih Sekolah</option>
                                            @foreach ($schools as $school)
                                                <option value="{{ $school->id }}">
                                                    {{ $school->nama_sekolah }}
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
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Masuk</label>
                                        <input type="date" class="form-control" name="tanggal_masuk_pkl"
                                            placeholder="DD-MM-YYYY" value="{{ old('tanggal_masuk_pkl') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Selesai</label>
                                        <input type="date" class="form-control" name="tanggal_selesai_pkl"
                                            placeholder="DD-MM-YYYY" value="{{ old('tanggal_selesai_pkl') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">NIS Siswa</label>
                                        <input type="text" class="form-control" name="nis_siswa"
                                            placeholder="Masukan NIS Siswa" value="{{ old('nis_siswa') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Siswa</label>
                                        <input type="text" onkeyup="huruf(this);" class="form-control" name="nama_siswa"
                                            placeholder="Masukan Nama Siswa" value="{{ old('nama_siswa') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" name="tempat_lahir_siswa"
                                            placeholder="Masukan Tempat Lahir" value="{{ old('tempat_lahir_siswa') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="tanggal_lahir_siswa"
                                            placeholder="DD-MM-YYYY" value="{{ old('tanggal_lahir_siswa') }}">
                                    </div>
                                    <div class="form-group  mt-2">
                                        <label for="jenis_kelamin_siswa">Jenis Kelamin</label>
                                        <select name="jenis_kelamin_siswa" class="form-select">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Pria"
                                                @if (old('jenis_kelamin_siswa') == 'Pria') {{ 'selected' }} @endif>Pria
                                            </option>
                                            <option value="Wanita"
                                                @if (old('jenis_kelamin_siswa') == 'Wanita') {{ 'selected' }} @endif>Wanita
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group  mt-2">
                                        <label for="agama_siswa">Agama</label>
                                        <select name="agama_siswa" class="form-select">
                                            <option value="">Pilih Agama</option>
                                            <option value="Islam"
                                                @if (old('agama_siswa') == 'Islam') {{ 'selected' }} @endif>Islam
                                            </option>
                                            <option value="Kristen Protestan"
                                                @if (old('agama_siswa') == 'Kristen Protestan') {{ 'selected' }} @endif>Kristen
                                                Protestan
                                            </option>
                                            <option value="Kristen Katholik"
                                                @if (old('agama_siswa') == 'Kristen Katholik') {{ 'selected' }} @endif>Kristen
                                                Katholik
                                            </option>
                                            <option value="Hindu"
                                                @if (old('agama_siswa') == 'Hindu') {{ 'selected' }} @endif>Hindu
                                            </option>
                                            <option value="Budha"
                                                @if (old('agama_siswa') == 'Budha') {{ 'selected' }} @endif>Budha
                                            </option>
                                            <option value="Konghucu"
                                                @if (old('agama_siswa') == 'Konghucu') {{ 'selected' }} @endif>Konghucu
                                            </option>

                                        </select>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">No Handphone</label>
                                        <input type="text" onkeyup="angka(this);" class="form-control"
                                            name="no_handphone_siswa" placeholder="Masukan No Handphone"
                                            value="{{ old('no_handphone_siswa') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Jurusan</label>
                                        <input type="text" class="form-control" name="jurusan"
                                            placeholder="Masukan Jurusan" value="{{ old('jurusan') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" maxlength="80" name="alamat_siswa"
                                            placeholder="Masukan Alamat" value="{{ old('alamat_siswa') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nomor RT" class="form-control"
                                                    onkeyup="angka(this);" maxlength="3" name="rt_siswa"
                                                    value="{{ old('rt_siswa') }}">
                                            </div>
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nomor RW" class="form-control"
                                                    onkeyup="angka(this);" maxlength="3" name="rw_siswa"
                                                    value="{{ old('rw_siswa') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nama Kelurahan"
                                                    class="form-control" maxlength="30" name="kelurahan_siswa"
                                                    value="{{ old('kelurahan_siswa') }}">
                                            </div>
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nama Kecamatan"
                                                    class="form-control" maxlength="30" name="kecamatan_siswa"
                                                    value="{{ old('kecamatan_siswa') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nama Kota"
                                                    class="form-control" maxlength="30" name="kota_siswa"
                                                    value="{{ old('kota_siswa') }}">
                                            </div>
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nama Provinsi"
                                                    class="form-control" maxlength="30" name="provinsi_siswa"
                                                    value="{{ old('provinsi_siswa') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Kode POS</label>
                                        <input type="text" class="form-control" onkeyup="angka(this);" maxlength="5"
                                            name="kode_pos_siswa" placeholder="Masukan Nomor Kode POS"
                                            value="{{ old('kode_pos_siswa') }}">
                                    </div>


                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Simpan
                                        </button>
                                        <a href="{{ route('student.index') }}" class="btn btn-danger btn-block">
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
