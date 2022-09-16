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
                        Hapus Absensi
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
                            <form action="{{ route('absensi.destroy', $items->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('delete')
                                <div class="form-group">
                                    <input type="hidden" readonly class="form-control" name="hapus_oleh" placeholder="Name"
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
                                        <label for="title" class="form-label">Tanggal Absen</label>
                                        <input type="date" class="form-control" name="tanggal_absen" readonly
                                            value="{{ $items->tanggal_absen }}">
                                    </div>
                                    <div class="form-group  mt-2">
                                        <label for="keterangan_absen">Keterangan Absen</label>
                                        <select name="keterangan_absen" class="form-select" disabled>
                                            <option value="">Pilih Keterangan Absen</option>
                                            <option value="Sakit"
                                                @if ($items->keterangan_absen == 'Sakit') {{ 'selected="selected"' }} @endif>
                                                Sakit</option>
                                            <option value="Ijin"
                                                @if ($items->keterangan_absen == 'Ijin') {{ 'selected="selected"' }} @endif>
                                                Ijin</option>
                                            <option value="Alpa"
                                                @if ($items->keterangan_absen == 'Alpa') {{ 'selected="selected"' }} @endif>
                                                Alpa</option>
                                            <option value="Cuti Tahunan"
                                                @if ($items->keterangan_absen == 'Cuti Tahunan') {{ 'selected="selected"' }} @endif>
                                                Cuti Tahunan</option>
                                            <option value="Cuti Khusus"
                                                @if ($items->keterangan_absen == 'Cuti Khusus') {{ 'selected="selected"' }} @endif>
                                                Cuti Khusus</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Keterangan Cuti Khusus</label>
                                        <input type="text" class="form-control" name="keterangan_cuti_khusus"
                                            placeholder="Masukan Keterangan Cuti Khusus" readonly
                                            value="{{ $items->keterangan_cuti_khusus }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Delete Data
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
