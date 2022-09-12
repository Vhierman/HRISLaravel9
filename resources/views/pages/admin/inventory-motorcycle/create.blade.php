@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Inventaris</li>
                    <li class="breadcrumb-item active">Motor</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Tambah Data Inventaris Motor
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
                            <form action="{{ route('inventory_motorcycle.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="input_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Karyawan</label>
                                        <select class="selectpicker" name="employees_id" data-width="100%"
                                            data-live-search="true" required>
                                            <option value="">Pilih Nama Karyawan</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->nik_karyawan }}">
                                                    {{ $item->nama_karyawan . ' / ' . $item->divisions->penempatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Merk Motor</label>
                                        <input type="text" class="form-control" name="merk_motor"
                                            placeholder="Merk Motor" maxlength="30" value="{{ old('merk_motor') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Type Motor</label>
                                        <input type="text" class="form-control" name="type_motor"
                                            placeholder="Type Motor" maxlength="30" value="{{ old('type_motor') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nomor Polisi</label>
                                        <input type="text" class="form-control" name="nomor_polisi"
                                            placeholder="Nomor Polisi " maxlength="20" value="{{ old('nomor_polisi') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Warna Motor</label>
                                        <input type="text" class="form-control" name="warna_motor"
                                            placeholder="Warna Motor" maxlength="20" value="{{ old('warna_motor') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nomor Rangka Motor</label>
                                        <input type="text" class="form-control" name="nomor_rangka_motor"
                                            placeholder="Nomor Rangka Motor" maxlength="50"
                                            value="{{ old('nomor_rangka_motor') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nomor Mesin Motor</label>
                                        <input type="text" class="form-control" name="nomor_mesin_motor"
                                            placeholder="Nomor Mesin Motor" maxlength="50"
                                            value="{{ old('nomor_mesin_motor') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Akhir Pajak</label>
                                        <input type="date" class="form-control" name="tanggal_akhir_pajak_motor"
                                            placeholder="DD-MM-YYYY" value="{{ old('tanggal_akhir_pajak_motor') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Akhir Plat</label>
                                        <input type="date" class="form-control" name="tanggal_akhir_plat_motor"
                                            placeholder="DD-MM-YYYY" value="{{ old('tanggal_akhir_plat_motor') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Penyerahan</label>
                                        <input type="date" class="form-control" name="tanggal_penyerahan_motor"
                                            placeholder="DD-MM-YYYY" value="{{ old('tanggal_penyerahan_motor') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Foto Motor <font color="red">*Hanya
                                                File
                                                JPEG,JPG,PNG
                                                (Maksimal 500kb)</font>
                                        </label>
                                        <input type="file" class="form-control" name="foto_motor"
                                            value="{{ old('foto_motor') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Foto STNK <font color="red">*Hanya
                                                File
                                                JPEG,JPG,PNG
                                                (Maksimal 500kb)</font>
                                        </label>
                                        <input type="file" class="form-control" name="foto_stnk_motor"
                                            value="{{ old('foto_stnk_motor') }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Simpan
                                        </button>
                                        <a href="{{ route('inventory_motorcycle.index') }}"
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
