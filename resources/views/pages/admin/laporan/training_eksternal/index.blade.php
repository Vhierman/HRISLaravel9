@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">Training Eksternal</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Training Eksternal
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
                            <form action="{{ route('laporan.tampil_laporan_training_eksternal') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">

                                    <label for="title" class="form-label">Periode Awal</label>
                                    <input type="date" class="form-control" name="awal" placeholder="DD-MM-YYYY"
                                        value="{{ old('awal') }}">

                                    <label for="title" class="form-label">Periode Akhir</label>
                                    <input type="date" class="form-control" name="akhir" placeholder="DD-MM-YYYY"
                                        value="{{ old('akhir') }}">

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Lihat
                                        </button>
                                        <a href="{{ route('laporan.training_eksternal') }}"
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
