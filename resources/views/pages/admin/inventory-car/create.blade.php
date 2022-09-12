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
                    <li class="breadcrumb-item active">Mobil</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Tambah Data Inventaris Mobil
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
                            <form action="{{ route('inventory_car.store') }}" method="post" enctype="multipart/form-data">
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
                                        <label for="title" class="form-label">Merk Mobil</label>
                                        <input type="text" class="form-control" name="merk_mobil"
                                            placeholder="Merk Mobil" maxlength="30" value="{{ old('merk_mobil') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Type Mobil</label>
                                        <input type="text" class="form-control" name="type_mobil"
                                            placeholder="Type Mobil" maxlength="30" value="{{ old('type_mobil') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nomor Polisi</label>
                                        <input type="text" class="form-control" name="nomor_polisi"
                                            placeholder="Nomor Polisi " maxlength="20" value="{{ old('nomor_polisi') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Warna Mobil</label>
                                        <input type="text" class="form-control" name="warna_mobil"
                                            placeholder="Warna Mobil" maxlength="20" value="{{ old('warna_mobil') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nomor Rangka Mobil</label>
                                        <input type="text" class="form-control" name="nomor_rangka_mobil"
                                            placeholder="Nomor Rangka Mobil" maxlength="50"
                                            value="{{ old('nomor_rangka_mobil') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nomor Mesin Mobil</label>
                                        <input type="text" class="form-control" name="nomor_mesin_mobil"
                                            placeholder="Nomor Mesin Mobil" maxlength="50"
                                            value="{{ old('nomor_mesin_mobil') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Akhir Pajak</label>
                                        <input type="date" class="form-control" name="tanggal_akhir_pajak_mobil"
                                            placeholder="DD-MM-YYYY" value="{{ old('tanggal_akhir_pajak_mobil') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Akhir Plat</label>
                                        <input type="date" class="form-control" name="tanggal_akhir_plat_mobil"
                                            placeholder="DD-MM-YYYY" value="{{ old('tanggal_akhir_plat_mobil') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Penyerahan</label>
                                        <input type="date" class="form-control" name="tanggal_penyerahan_mobil"
                                            placeholder="DD-MM-YYYY" value="{{ old('tanggal_penyerahan_mobil') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Foto Mobil <font color="red">*Hanya
                                                File
                                                JPEG,JPG,PNG
                                                (Maksimal 500kb)</font>
                                        </label>
                                        <input type="file" class="form-control" name="foto_mobil"
                                            value="{{ old('foto_mobil') }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Foto STNK <font color="red">*Hanya
                                                File
                                                JPEG,JPG,PNG
                                                (Maksimal 500kb)</font>
                                        </label>
                                        <input type="file" class="form-control" name="foto_stnk_mobil"
                                            value="{{ old('foto_stnk_mobil') }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Simpan
                                        </button>
                                        <a href="{{ route('inventory_car.index') }}" class="btn btn-danger btn-block">
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
