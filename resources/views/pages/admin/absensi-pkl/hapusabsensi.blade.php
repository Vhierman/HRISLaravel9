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
                        Hapus Absensi Prakerin
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
                            <form action="{{ route('absensipkl.tampil_hapus') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">

                                    <label for="title" class="form-label">Nama Siswa</label>
                                    <select class="selectpicker" name="students_id" data-width="100%"
                                        data-live-search="true" required>
                                        <option value="">Pilih Siswa</option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->nis_siswa }}">
                                                {{ $item->nama_siswa . ' / ' . $item->divisions->penempatan }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Absen</label>
                                        <input type="date" class="form-control" name="tanggal_absen"
                                            placeholder="DD-MM-YYYY" value="{{ old('tanggal_absen') }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Cari Data
                                        </button>
                                        <a href="{{ route('absensipkl.index') }}" class="btn btn-danger btn-block">
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
