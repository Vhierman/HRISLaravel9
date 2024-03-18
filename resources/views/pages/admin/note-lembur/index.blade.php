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
                    <li class="breadcrumb-item active">Note Lembur</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Note Lembur
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK Karyawan</th>
                                        <th>Nama Karyawan</th>
                                        <th>Golongan</th>
                                        <th>Note Lembur</th>
                                        @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                            <th>Action</th>
                                        @else
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->nik_karyawan }}</td>
                                            <td>{{ $item->nama_karyawan }}</td>
                                            <td>{{ $item->golongans_id }}</td>
                                            <td>{{ $item->note_lembur }}</td>
                                            @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                <td>
                                                    <a href="{{ route('note_lembur.edit', $item->id) }}"
                                                        class="btn btn-success">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                            @else
                                            @endif
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
