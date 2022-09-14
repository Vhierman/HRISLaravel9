@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>

            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Prosess</li>
                    <li class="breadcrumb-item active">PKWT Harian</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        PKWT Harian
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
                            <form action="{{ route('proses.tampil_pkwt_harian') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="golongan">Data</label>
                                        <select name="golongan" class="form-select">
                                            <option value="">Pilih Data</option>
                                            <option value="2"
                                                @if (old('golongan') == '2') {{ 'selected' }} @endif>
                                                Susan
                                            </option>
                                            <option value="3"
                                                @if (old('golongan') == '3') {{ 'selected' }} @endif>Ghufron
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Akhir Kontrak</label>
                                        <input type="date" class="form-control" name="akhir_kontrak"
                                            placeholder="DD-MM-YYYY" value="{{ old('akhir_kontrak') }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Process
                                        </button>
                                        <a href="{{ route('proses.proses_pkwt_harian') }}" class="btn btn-danger btn-block">
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
