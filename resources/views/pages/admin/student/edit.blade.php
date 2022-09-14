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
                        Edit Data Siswa
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
                            <form action="{{ route('student.update', $item->id) }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group">

                                    <input type="hidden" class="form-control" name="edit_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

                                    <div class="form-group  mt-2">
                                        <label for="schools_id">Sekolah</label>
                                        <select name="schools_id" class="form-select">
                                            <option value="{{ $item->schools_id }}">Pilih Sekolah</option>
                                            @foreach ($schools as $school)
                                                <option value="{{ $school->id }}"
                                                    @if ($item->schools_id == $school->id) {{ 'selected="selected"' }} @endif>
                                                    {{ $school->nama_sekolah }}
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
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Masuk</label>
                                        <input type="date" class="form-control" name="tanggal_masuk_pkl"
                                            placeholder="DD-MM-YYYY" value="{{ $item->tanggal_masuk_pkl }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Selesai</label>
                                        <input type="date" class="form-control" name="tanggal_selesai_pkl"
                                            placeholder="DD-MM-YYYY" value="{{ $item->tanggal_selesai_pkl }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">NIS Siswa</label>
                                        <input type="text" class="form-control" name="nis_siswa"
                                            placeholder="Masukan NIS Siswa" value="{{ $item->nis_siswa }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Siswa</label>
                                        <input type="text" onkeyup="huruf(this);" class="form-control" name="nama_siswa"
                                            placeholder="Masukan Nama Siswa" value="{{ $item->nama_siswa }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" name="tempat_lahir_siswa"
                                            placeholder="Masukan Tempat Lahir" value="{{ $item->tempat_lahir_siswa }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="tanggal_lahir_siswa"
                                            placeholder="DD-MM-YYYY" value="{{ $item->tanggal_lahir_siswa }}">
                                    </div>
                                    <div class="form-group  mt-2">
                                        <label for="jenis_kelamin_siswa">Jenis Kelamin</label>
                                        <select name="jenis_kelamin_siswa" class="form-select">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Pria"
                                                @if ($item->jenis_kelamin_siswa == 'Pria') {{ 'selected="selected"' }} @endif>
                                                Pria</option>
                                            <option value="Wanita"
                                                @if ($item->jenis_kelamin_siswa == 'Wanita') {{ 'selected="selected"' }} @endif>
                                                Wanita</option>
                                        </select>
                                    </div>
                                    <div class="form-group  mt-2">
                                        <label for="agama_siswa">Agama</label>
                                        <select name="agama_siswa" class="form-select">
                                            <option value="">Pilih Agama</option>
                                            <option value="Islam"
                                                @if ($item->agama_siswa == 'Islam') {{ 'selected="selected"' }} @endif>
                                                Islam</option>
                                            <option value="Kristen Protestan"
                                                @if ($item->agama_siswa == 'Kristen Protestan') {{ 'selected="selected"' }} @endif>
                                                Kristen
                                                Protestan</option>
                                            <option value="Kristen Katholik"
                                                @if ($item->agama_siswa == 'Kristen Katholik') {{ 'selected="selected"' }} @endif>
                                                Kristen Katholik
                                            </option>
                                            <option value="Hindu"
                                                @if ($item->agama_siswa == 'Hindu') {{ 'selected="selected"' }} @endif>
                                                Hindu</option>
                                            <option value="Budha"
                                                @if ($item->agama_siswa == 'Budha') {{ 'selected="selected"' }} @endif>
                                                Budha</option>
                                            <option value="Konghucu"
                                                @if ($item->agama_siswa == 'Konghucu') {{ 'selected="selected"' }} @endif>
                                                Konghucu</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">No Handphone</label>
                                        <input type="text" onkeyup="angka(this);" class="form-control"
                                            name="no_handphone_siswa" placeholder="Masukan No Handphone"
                                            value="{{ $item->no_handphone_siswa }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Jurusan</label>
                                        <input type="text" class="form-control" name="jurusan"
                                            placeholder="Masukan Jurusan" value="{{ $item->jurusan }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" maxlength="80" name="alamat_siswa"
                                            placeholder="Masukan Alamat" value="{{ $item->alamat_siswa }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nomor RT" class="form-control"
                                                    onkeyup="angka(this);" maxlength="3" name="rt_siswa"
                                                    value="{{ $item->rt_siswa }}">
                                            </div>
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nomor RW" class="form-control"
                                                    onkeyup="angka(this);" maxlength="3" name="rw_siswa"
                                                    value="{{ $item->rw_siswa }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nama Kelurahan"
                                                    class="form-control" maxlength="30" name="kelurahan_siswa"
                                                    value="{{ $item->kelurahan_siswa }}">
                                            </div>
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nama Kecamatan"
                                                    class="form-control" maxlength="30" name="kecamatan_siswa"
                                                    value="{{ $item->kecamatan_siswa }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nama Kota"
                                                    class="form-control" maxlength="30" name="kota_siswa"
                                                    value="{{ $item->kota_siswa }}">
                                            </div>
                                            <div class="col">
                                                <input type="text" placeholder="Masukan Nama Provinsi"
                                                    class="form-control" maxlength="30" name="provinsi_siswa"
                                                    value="{{ $item->provinsi_siswa }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Kode POS</label>
                                        <input type="text" class="form-control" onkeyup="angka(this);" maxlength="5"
                                            name="kode_pos_siswa" placeholder="Masukan Nomor Kode POS"
                                            value="{{ $item->kode_pos_siswa }}">
                                    </div>


                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Update
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
