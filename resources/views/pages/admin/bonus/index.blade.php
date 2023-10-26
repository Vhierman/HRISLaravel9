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
                    <li class="breadcrumb-item active">BONUS</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        BONUS
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
                            <form action="{{ route('bonus.cetak_form_penilaian') }}" method="post" target="_blank"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">

                                    <div class="form-group mt-2">
                                        <label for="divisions_id">Penempatan</label>
                                        <select name="divisions_id" class="form-select">
                                            <option value="">Pilih Penempatan</option>
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division->id }}">
                                                    {{ $division->penempatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Cetak
                                        </button>
                                        <a href="{{ route('bonus.index') }}" class="btn btn-danger btn-block">
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
