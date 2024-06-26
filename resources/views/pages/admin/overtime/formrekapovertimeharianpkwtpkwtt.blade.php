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
                        Data Overtimes
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
                            <form action="{{ route('overtime.form_lihat_rekap_overtime_harian_pkwt_pkwtt') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">

                                    <div class="form-group  mt-2">
                                        <label for="status_kerja">Status Kerja</label>
                                        <select name="status_kerja" class="form-select">
                                            <option value="">Pilih Status Kerja</option>
                                            <option value="Harian"
                                                @if (old('status_kerja') == 'Harian') {{ 'selected' }} @endif>Harian
                                            </option>
                                            <option value="PKWT"
                                                @if (old('status_kerja') == 'PKWT') {{ 'selected' }} @endif>PKWT
                                            </option>
                                            <option value="PKWTT"
                                                @if (old('status_kerja') == 'PKWTT') {{ 'selected' }} @endif>PKWTT
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="divisions_id">Divisi</label>
                                        <select name="divisions_id" class="form-select">
                                            <option value="">Pilih Divisi</option>

                                            <option value="PDC"
                                                @if (old('divisions_id') == 'PDC') {{ 'selected' }} @endif>PDC
                                            </option>
                                            <option value="Office"
                                                @if (old('divisions_id') == 'Office') {{ 'selected' }} @endif>Office
                                            </option>
                                            <option value="Produksi"
                                                @if (old('divisions_id') == 'Produksi') {{ 'selected' }} @endif>Produksi
                                            </option>
                                            <option value="Quality"
                                                @if (old('divisions_id') == 'Quality') {{ 'selected' }} @endif>Quality
                                            </option>
                                            <option value="PPC"
                                                @if (old('divisions_id') == 'PPC') {{ 'selected' }} @endif>PPC
                                            </option>

                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Mulai dari</label>
                                        <input type="date" class="form-control" name="awal" placeholder="DD-MM-YYYY"
                                            value="{{ old('awal') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Sampai Tanggal</label>
                                        <input type="date" class="form-control" name="akhir" placeholder="DD-MM-YYYY"
                                            value="{{ old('akhir') }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Lihat Rekap
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
