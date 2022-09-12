@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Training</li>
                    <li class="breadcrumb-item active">Eksternal</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Edit Data History Training Eksternal {{ $item->nama_karyawan }}
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
                            <form action="{{ route('history_training_eksternal.update', $historytrainingeksternals->id) }}"
                                method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="edit_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">NIK Karyawan</label>
                                        <input type="text" class="form-control" name="nik_karyawan"
                                            placeholder="Masukan NIK Karyawan" value="{{ $item->nik_karyawan }}" readonly>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" name="nama_karyawan"
                                            placeholder="Masukan Nama Karyawan" value="{{ $item->nama_karyawan }}" readonly>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Institusi Training</label>
                                        <input type="text" class="form-control"
                                            name="institusi_penyelenggara_training_eksternal"
                                            placeholder="Masukan Institusi Training"
                                            value="{{ $historytrainingeksternals->institusi_penyelenggara_training_eksternal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Perihal Training</label>
                                        <input type="text" class="form-control" name="perihal_training_eksternal"
                                            placeholder="Masukan Perihal Training"
                                            value="{{ $historytrainingeksternals->perihal_training_eksternal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Awal Training</label>
                                        <input type="date" class="form-control" name="tanggal_awal_training_eksternal"
                                            placeholder="Masukan Tanggal Awal Training"
                                            value="{{ $historytrainingeksternals->tanggal_awal_training_eksternal }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Akhir Training</label>
                                        <input type="date" class="form-control" name="tanggal_akhir_training_eksternal"
                                            placeholder="Masukan Tanggal Akhir Training"
                                            value="{{ $historytrainingeksternals->tanggal_akhir_training_eksternal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Jam Training</label>
                                        <input type="time" class="form-control" name="jam_training_eksternal"
                                            placeholder="Masukan Jam Training"
                                            value="{{ $historytrainingeksternals->jam_training_eksternal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Lokasi Training</label>
                                        <input type="text" class="form-control" name="lokasi_training_eksternal"
                                            placeholder="Masukan Lokasi Training"
                                            value="{{ $historytrainingeksternals->lokasi_training_eksternal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Alamat Training</label>
                                        <input type="text" class="form-control" name="alamat_training_eksternal"
                                            placeholder="Masukan Alamat Training"
                                            value="{{ $historytrainingeksternals->alamat_training_eksternal }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Update
                                        </button>
                                        <a href="{{ route('employee.show', $item->id) }}" class="btn btn-danger btn-block">
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
