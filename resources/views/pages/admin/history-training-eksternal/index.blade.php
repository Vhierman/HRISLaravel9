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
                    <li class="breadcrumb-item active">Eksternals</li>
                </ol>

                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                    <a href="{{ route('history_training_eksternal.create') }}" class="btn btn-primary shadow-sm mb-3">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Training Eksternal
                    </a>
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Training Eksternal
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Institusi</th>
                                        <th>Perihal</th>
                                        <th>Tanggal Training</th>
                                        <th>Lokasi</th>
                                        <th>Jumlah</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->institusi_penyelenggara_training_eksternal }}</td>
                                            <td>{{ $item->perihal_training_eksternal }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_awal_training_eksternal)->isoformat('DD-MM-Y') }}
                                            </td>
                                            <td>{{ $item->lokasi_training_eksternal }}</td>
                                            <td>{{ $item->jumlah . ' Orang' }}</td>
                                            <td>
                                                <form
                                                    action="{{ route('history_training_eksternal.tampilmultipletrainingeksternal') }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" class="form-control"
                                                        name="institusi_penyelenggara_training_eksternal"
                                                        value="{{ $item->institusi_penyelenggara_training_eksternal }}">

                                                    <input type="hidden" class="form-control"
                                                        name="perihal_training_eksternal"
                                                        value="{{ $item->perihal_training_eksternal }}">

                                                    <input type="hidden" class="form-control"
                                                        name="tanggal_awal_training_eksternal"
                                                        value="{{ $item->tanggal_awal_training_eksternal }}">

                                                    <input type="hidden" class="form-control"
                                                        name="lokasi_training_eksternal"
                                                        value="{{ $item->lokasi_training_eksternal }}">

                                                    <button type="submit" class="btn btn-primary ">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
@endsection
