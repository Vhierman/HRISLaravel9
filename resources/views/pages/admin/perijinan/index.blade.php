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
                    <li class="breadcrumb-item active">Perijinan</li>
                </ol>

                <a href="{{ route('laporan.tambah_perijinan') }}" class="btn btn-primary shadow-sm mb-3">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data Perijinan
                </a>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Perijinan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Perijinan</th>
                                        <th>Nomor</th>
                                        <th>Instansi</th>
                                        <th>Tanggal Habis</th>
                                        <th>Masa Berlaku</th>
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
                                            <td>{{ $item->nama_perijinan }}</td>
                                            <td>{{ $item->nomor_perijinan }}</td>
                                            <td>{{ $item->instansi_penerbit }}</td>
                                            <td>{{ $item->tanggal_habis }}</td>
                                            <td>{{ $item->masa_berlaku }}</td>
                                            <td>
                                                <a href="{{ route('laporan.edit_perijinan', $item->id) }}"
                                                    class="btn btn-success">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                                <form action="{{ route('laporan.hapus_perijinan', $item->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('post')
                                                    <button class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
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
