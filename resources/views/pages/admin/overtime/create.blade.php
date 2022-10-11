@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Proses</li>
                    <li class="breadcrumb-item active">Overtime</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Tambah Data Lembur
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
                            <form action="{{ route('overtime.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">

                                    <div class="form-group mt-2">

                                        <input type="hidden" class="form-control" name="input_oleh" placeholder="Name"
                                            value="{{ Auth::user()->name }}">

                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Tanggal Lembur</label>
                                            <input type="date" class="form-control" name="tanggal_lembur"
                                                placeholder="dd/mm/yyyy" value="{{ old('tanggal_lembur') }}">
                                        </div>

                                        <label for="title" class="form-label">Nama Karyawan</label>
                                        <select class="selectpicker" name="employees_id[]" data-width="100%"
                                            data-live-search="true" multiple required>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->nik_karyawan }}">
                                                    {{ $item->nama_karyawan . ' / ' . $item->positions->jabatan . ' / ' . $item->divisions->penempatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group  mt-2">
                                        <label for="jenis_lembur">Jenis Lembur</label>
                                        <select name="jenis_lembur" class="form-select">
                                            <option value="">Pilih Jenis Lembur</option>
                                            <option value="Biasa"
                                                @if (old('jenis_lembur') == 'Biasa') {{ 'selected' }} @endif>Biasa
                                            </option>
                                            <option value="Libur"
                                                @if (old('jenis_lembur') == 'Libur') {{ 'selected' }} @endif>Libur
                                            </option>
                                        </select>
                                    </div>

                                    @if ($divisi == 19)
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Uang Makan Lembur</label>
                                            <input type="text" class="form-control" name="uang_makan_lembur" readonly
                                                value="0">
                                        </div>
                                    @else
                                        <div class="form-group  mt-2">
                                            <label for="uang_makan_lembur">Uang Makan Lembur</label>
                                            <select name="uang_makan_lembur" class="form-select">
                                                <option value="">Dapat Uang Makan Lembur ?</option>
                                                <option value="12500"
                                                    @if (old('uang_makan_lembur') == '12500') {{ 'selected' }} @endif>Dapat Uang
                                                    Makan
                                                </option>
                                                <option value="0"
                                                    @if (old('uang_makan_lembur') == '0') {{ 'selected' }} @endif>
                                                    Tidak Dapat Uang Makan
                                                </option>
                                            </select>
                                        </div>
                                    @endif


                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Keterangan Lembur</label>
                                        <input type="text" class="form-control" name="keterangan_lembur"
                                            placeholder="Masukan Keterangan Lembur" value="{{ old('keterangan_lembur') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Jam Masuk</label>
                                        <input type="text" class="form-control" name="jam_masuk"
                                            placeholder="Masukan Jam Masuk" maxlength="4" value="{{ old('jam_masuk') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Jam Istirahat</label>
                                        <input type="text" class="form-control" name="jam_istirahat"
                                            placeholder="Masukan Jam Istirahat" maxlength="4"
                                            value="{{ old('jam_istirahat') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Jam Pulang</label>
                                        <input type="text" class="form-control" name="jam_pulang"
                                            placeholder="Masukan Jam Pulang" maxlength="4"
                                            value="{{ old('jam_pulang') }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Simpan
                                        </button>
                                        <a href="{{ route('overtime.index') }}" class="btn btn-danger btn-block">
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
