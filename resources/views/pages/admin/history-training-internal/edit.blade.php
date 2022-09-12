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
                    <li class="breadcrumb-item active">Internal</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Edit Data History Training Internal {{ $item->nama_karyawan }}
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
                            <form action="{{ route('history_training_internal.update', $historytraininginternals->id) }}"
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
                                        <input type="hidden" class="form-control" name="hari_training_internal"
                                            placeholder="Masukan Hari Training" readonly
                                            value="{{ $historytraininginternals->hari_training_internal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Training</label>
                                        <input type="date" class="form-control" name="tanggal_training_internal"
                                            placeholder="Masukan Tanggal Training"
                                            value="{{ $historytraininginternals->tanggal_training_internal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Jam Training</label>
                                        <input type="time" class="form-control" name="jam_training_internal"
                                            placeholder="Masukan Jam Training"
                                            value="{{ $historytraininginternals->jam_training_internal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Lokasi Training</label>
                                        <input type="text" class="form-control" name="lokasi_training_internal"
                                            placeholder="Masukan Lokasi Training"
                                            value="{{ $historytraininginternals->lokasi_training_internal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Materi Training</label>
                                        <input type="text" class="form-control" name="materi_training_internal"
                                            placeholder="Masukan Materi Training"
                                            value="{{ $historytraininginternals->materi_training_internal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Trainer Training</label>
                                        <input type="text" class="form-control" name="trainer_training_internal"
                                            placeholder="Masukan Trainer Training" onkeyup="huruf(this);"
                                            value="{{ $historytraininginternals->trainer_training_internal }}">
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
