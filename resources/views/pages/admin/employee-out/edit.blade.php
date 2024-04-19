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
                    <li class="breadcrumb-item active">Data Karyawan Keluar</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Edit Data Karyawan Keluar
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
                            <form action="{{ route('employee_out.update', $item->id) }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="edit_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">NIK Karyawan</label>
                                        <input type="text" readonly class="form-control" name="employees_id"
                                            placeholder="NIK Karyawan" value="{{ $item->employees_id }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Karyawan</label>
                                        <input type="text" readonly class="form-control" name="nama_karyawan_keluar"
                                            placeholder="Nama Karyawan" value="{{ $item->nama_karyawan_keluar }}">
                                    </div>

                                    <div class="form-group  mt-2">
                                        <label for="keterangan_keluar">Keterangan Keluar</label>
                                        <select name="keterangan_keluar" class="form-select">
                                            <option value="">Pilih Keterangan Keluar</option>
                                            <option value="Usia Pensiun"
                                                @if ($item->keterangan_keluar == 'Usia Pensiun') {{ 'selected="selected"' }} @endif>
                                                Usia Pensiun</option>
                                            <option value="Pengunduran Diri"
                                                @if ($item->keterangan_keluar == 'Pengunduran Diri') {{ 'selected="selected"' }} @endif>
                                                Pengunduran Diri</option>
                                            <option value="Berakhir Kontrak Kerja"
                                                @if ($item->keterangan_keluar == 'Berakhir Kontrak Kerja') {{ 'selected="selected"' }} @endif>
                                                Berakhir Kontrak Kerja</option>
                                            <option value="Pemutusan Hubungan Kerja"
                                                @if ($item->keterangan_keluar == 'Pemutusan Hubungan Kerja') {{ 'selected="selected"' }} @endif>
                                                Pemutusan Hubungan Kerja</option>
                                            <option value="Meninggal Dunia"
                                                @if ($item->keterangan_keluar == 'Meninggal Dunia') {{ 'selected="selected"' }} @endif>
                                                Meninggal Dunia</option>


                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Keluar</label>
                                        <input type="date" class="form-control" name="tanggal_keluar_karyawan_keluar"
                                            placeholder="DD-MM-YYYY" value="{{ $item->tanggal_keluar_karyawan_keluar }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Update
                                        </button>
                                        <a href="{{ route('employee_out.index') }}" class="btn btn-danger btn-block">
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
