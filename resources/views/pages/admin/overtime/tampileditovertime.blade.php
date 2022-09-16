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
                        Edit Overtimes
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
                            <form action="{{ route('overtime.update', $items->id) }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" readonly class="form-control" name="edit_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">NIK Karyawan</label>
                                        <input type="text" class="form-control" name="employees_id" readonly
                                            value="{{ $items->employees->nik_karyawan }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" name="nama_karyawan" readonly
                                            value="{{ $items->employees->nama_karyawan }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Lembur</label>
                                        <input type="date" class="form-control" name="tanggal_lembur"
                                            value="{{ $items->tanggal_lembur }}">
                                    </div>
                                    <div class="form-group  mt-2">
                                        <label for="jenis_lembur">Jenis Lembur</label>
                                        <select name="jenis_lembur" class="form-select">
                                            <option value="">Pilih Jenis Lembur</option>
                                            <option value="Biasa"
                                                @if ($items->jenis_lembur == 'Biasa') {{ 'selected="selected"' }} @endif>
                                                Biasa</option>
                                            <option value="Libur"
                                                @if ($items->jenis_lembur == 'Libur') {{ 'selected="selected"' }} @endif>
                                                Libur</option>
                                        </select>
                                    </div>

                                    @if ($divisi == 19)
                                        <label for="title" class="form-label">Uang Makan Lembur</label>
                                        <input type="text" class="form-control" name="uang_makan_lembur" readonly
                                            value="0">
                                    @else
                                        <div class="form-group  mt-2">
                                            <label for="uang_makan_lembur">Uang Makan Lembur</label>
                                            <select name="uang_makan_lembur" class="form-select">
                                                <option value="">Dapat Uang Makan Lembur ?</option>
                                                <option value="12500"
                                                    @if ($items->uang_makan_lembur == '12500') {{ 'selected' }} @endif>Dapat
                                                </option>
                                                <option value="0"
                                                    @if ($items->uang_makan_lembur == '0') {{ 'selected' }} @endif>
                                                    Tidak
                                                </option>
                                            </select>
                                        </div>
                                    @endif


                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Keterangan Lembur</label>
                                        <input type="text" class="form-control" name="keterangan_lembur"
                                            placeholder="Masukan Keterangan Lembur"
                                            value="{{ $items->keterangan_lembur }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Jam Masuk</label>
                                        <input type="text" class="form-control" name="jam_masuk"
                                            placeholder="Masukan Jam Masuk" maxlength="4" value="{{ $items->jam_masuk }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Jam Istirahat</label>
                                        <input type="text" class="form-control" name="jam_istirahat"
                                            placeholder="Masukan Jam Istirahat" maxlength="4"
                                            value="{{ $items->jam_istirahat }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Jam Pulang</label>
                                        <input type="text" class="form-control" name="jam_pulang"
                                            placeholder="Masukan Jam Pulang" maxlength="4"
                                            value="{{ $items->jam_pulang }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Update Data
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
