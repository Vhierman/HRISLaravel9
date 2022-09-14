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
                    <li class="breadcrumb-item active">PKWT Harian</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data PKWT Harian Habis Tanggal {{ \Carbon\Carbon::parse($akhir_kontrak)->isoformat('D MMMM Y') }}
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
                            <form action="{{ route('proses.perpanjang_pkwt_harian') }}" method="POST" class="d-inline">
                                @csrf
                                <div class="form-group">

                                    <input type="hidden" class="form-control" name="akhirkontrak" placeholder="DD-MM-YYYY"
                                        value="{{ $akhir_kontrak }}">
                                    <input type="hidden" class="form-control" name="golongan" placeholder="DD-MM-YYYY"
                                        value="{{ $golongan }}">

                                    <div class="form-group mb-2">
                                        <label for="title" class="form-label">Awal Kontrak</label>
                                        <input type="date" class="form-control" name="awal_kontrak"
                                            placeholder="DD-MM-YYYY" value="{{ old('awal_kontrak') }}">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="title" class="form-label">Akhir Kontrak</label>
                                        <input type="date" class="form-control" name="akhir_kontrak"
                                            placeholder="DD-MM-YYYY" value="{{ old('akhir_kontrak') }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button class="btn btn-primary btn-block">
                                            Perpanjang
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
