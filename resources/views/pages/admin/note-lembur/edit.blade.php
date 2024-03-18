@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item active">Edit Note Lembur </li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Edit Data Note Lembur
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
                            <form action="{{ route('note_lembur.update', $item->id) }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="edit_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

                                    <div class="form-group mb-2">
                                        <label for="title" class="form-label">NIK Karyawan</label>
                                        <input type="text" class="form-control" readonly name="nik_karyawan"
                                            placeholder="Masukan NIK Karyawan" value="{{ $item->nik_karyawan }}">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="title" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" readonly name="nama_karyawan"
                                            placeholder="Masukan Nama Karyawan" value="{{ $item->nama_karyawan }}">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="title" class="form-label">Golongan</label>
                                        <input type="text" class="form-control" readonly name="golongan"
                                            placeholder="Golongan" value="{{ $item->golongans_id }}">
                                    </div>
                                    <div class="form-group  mt-2">
                                        <label for="note_lembur">Note Lembur</label>
                                        <select name="note_lembur" class="form-select">
                                            <option value="">Pilih Note Lembur</option>
                                            <option value="1"
                                                @if ($item->note_lembur == '1') {{ 'selected="selected"' }} @endif>
                                                1</option>
                                            <option value="2"
                                                @if ($item->note_lembur == '2') {{ 'selected="selected"' }} @endif>
                                                2</option>
                                            <option value="3"
                                                @if ($item->note_lembur == '3') {{ 'selected="selected"' }} @endif>
                                                3</option>
                                            <option value="4"
                                                @if ($item->note_lembur == '4') {{ 'selected="selected"' }} @endif>
                                                4
                                            </option>
                                        </select>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Update
                                        </button>
                                        <a href="{{ route('note_lembur.index') }}" class="btn btn-danger btn-block">
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
