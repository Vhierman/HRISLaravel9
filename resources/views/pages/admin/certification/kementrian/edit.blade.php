@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Sertifikasi</li>
                    <li class="breadcrumb-item active">KEMENTRIAN</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Edit Data Sertifikasi KEMENTRIAN
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
                            <form action="{{ route('certification.update_sertifikasi_kementrian') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="edit_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">
                                    <input type="hidden" class="form-control" name="id" placeholder="Name"
                                        value="{{ $itemcertification->id }}">

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Karyawan</label>
                                        <select class="selectpicker" name="employees_id" data-width="100%"
                                            data-live-search="true" required>
                                            <option value="{{ $itemcertification->employees_id }}">Pilih Nama Karyawan
                                            </option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->nik_karyawan }}"
                                                    @if ($itemcertification->employees_id == $item->nik_karyawan) {{ 'selected="selected"' }} @endif>
                                                    {{ $item->nama_karyawan . ' / ' . $item->divisions->penempatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nomor Sertifikat</label>
                                        <input type="text" class="form-control" name="nomor_sertifikat_kementrian"
                                            placeholder="Nomor Sertifikat" maxlength="30"
                                            value="{{ $itemcertification->nomor_sertifikat_kementrian }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Jenis Sertifikasi</label>
                                        <input type="text" class="form-control" name="jenis_sertifikat_kementrian"
                                            placeholder="Jenis Sertifikasi" maxlength="50"
                                            value="{{ $itemcertification->jenis_sertifikat_kementrian }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Masa Berlaku</label>
                                        <input type="text" class="form-control" name="masa_berlaku_sertifikat_kementrian"
                                            placeholder="Masa Berlaku Sertifikat " maxlength="20"
                                            value="{{ $itemcertification->masa_berlaku_sertifikat_kementrian }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Terbit Sertifikat</label>
                                        <input type="date" class="form-control" name="tanggal_terbit_kementrian"
                                            placeholder="DD-MM-YYYY"
                                            value="{{ $itemcertification->tanggal_terbit_kementrian }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Habis Sertifikat</label>
                                        <input type="date" class="form-control" name="sampai_tanggal_kementrian"
                                            placeholder="DD-MM-YYYY"
                                            value="{{ $itemcertification->sampai_tanggal_kementrian }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">LSP</label>
                                        <input type="text" class="form-control" name="lsp_kementrian"
                                            placeholder="LSP Sertifikasi" maxlength="50"
                                            value="{{ $itemcertification->lsp_kementrian }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Simpan
                                        </button>
                                        <a href="{{ route('certification.sertifikasi_kementrian') }}"
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
