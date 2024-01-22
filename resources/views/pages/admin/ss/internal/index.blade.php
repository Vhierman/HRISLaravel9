@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Kaizen</li>
                    <li class="breadcrumb-item active">SS Internal</li>
                </ol>

                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                    <a href="{{ route('kaizen.tambah_ss_internal') }}" class="btn btn-primary shadow-sm mb-3">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data SS Internal
                    </a>
                @else
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data SS Internal Karyawan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>NIK Karyawan</th>
                                        <th>Tema SS</th>
                                        <th>Tanggal SS</th>
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
                                            <td>{{ $item->employees->nama_karyawan }}</td>
                                            <td>{{ $item->employees->nik_karyawan }}</td>
                                            <td>{{ $item->tema_ss_internal }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_ss_internal)->isoformat('DD-MM-Y') }}
                                            </td>
                                            @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                <td align=center>
                                                    <a href="{{ route('kaizen.edit_ss_internal', $item->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('kaizen.hapus_ss_internal', $item->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('post')
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
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
