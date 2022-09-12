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
                    <li class="breadcrumb-item active">Data Siswa Prakerin</li>
                </ol>

                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                    <a href="{{ route('student.create') }}" class="btn btn-primary shadow-sm mb-3">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data Siswa
                    </a>
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Siswa Prakerin
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Nama Sekolah</th>
                                        <th>Penempatan</th>
                                        <th>Tgl Masuk</th>
                                        <th>Tgl Selesai</th>
                                        @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                            <th>Action</th>
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
                                            <td>{{ $item->nama_siswa }}</td>
                                            <td>{{ $item->schools->nama_sekolah }}</td>
                                            <td>{{ $item->divisions->penempatan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk_pkl)->isoformat('D MMMM Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai_pkl)->isoformat('D MMMM Y') }}
                                            </td>
                                            @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                <td>
                                                    <a href="{{ route('student.edit', $item->id) }}"
                                                        class="btn btn-success">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('student.destroy', $item->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger ">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
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
