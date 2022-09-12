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

                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                    <a href="{{ route('history_training_internal.create') }}" class="btn btn-primary shadow-sm mb-3">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Training Internal
                    </a>
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Training Internal
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Materi</th>
                                        <th>Tanggal Training</th>
                                        <th>Jam Training</th>
                                        <th>Trainer</th>
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
                                            <td>{{ $item->materi_training_internal }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_training_internal)->isoformat('DD-MM-Y') }}
                                            </td>
                                            <td>{{ $item->jam_training_internal }}</td>
                                            <td>{{ $item->trainer_training_internal }}</td>
                                            <td>{{ $item->jumlah . ' Orang' }}</td>
                                            <td>
                                                <form
                                                    action="{{ route('history_training_internal.tampilmultipletraininginternal') }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" class="form-control"
                                                        name="materi_training_internal"
                                                        value="{{ $item->materi_training_internal }}">

                                                    <input type="hidden" class="form-control"
                                                        name="tanggal_training_internal"
                                                        value="{{ $item->tanggal_training_internal }}">

                                                    <input type="hidden" class="form-control" name="jam_training_internal"
                                                        value="{{ $item->jam_training_internal }}">

                                                    <input type="hidden" class="form-control"
                                                        name="trainer_training_internal"
                                                        value="{{ $item->trainer_training_internal }}">

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
