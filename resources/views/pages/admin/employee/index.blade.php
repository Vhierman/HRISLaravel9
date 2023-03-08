@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Karyawan</li>
                    <li class="breadcrumb-item active">Data Karyawan Aktif</li>
                </ol>

                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                    <a href="{{ route('employee.create') }}" class="btn btn-primary shadow-sm mb-3">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data Karyawan
                    </a>
                    <a href="{{ route('employee.export_excel') }}" target="_blank" class="btn btn-success shadow-sm mb-3">
                        <i class="fas fa-download fa-sm text-white-50"></i> Download Excell Karyawan
                    </a>
                @elseif (Auth::user()->roles == 'ACCOUNTING' ||
                        Auth::user()->roles == 'MANAGER HRD' ||
                        Auth::user()->roles == 'MANAGER ACCOUNTING')
                    <a href="{{ route('employee.export_excel') }}" target="_blank" class="btn btn-success shadow-sm mb-3">
                        <i class="fas fa-download fa-sm text-white-50"></i> Download Excell Karyawan
                    </a>
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Karyawan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>NIK Karyawan</th>
                                        <th>GOL</th>
                                        <th>Jabatan</th>
                                        <th>Penempatan</th>
                                        <th>Status Kerja</th>
                                        <th>Awal Kerja</th>
                                        <th>Akhir Kerja</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($items as $item)
                                        @if ($item->status_kerja == 'PKWTT')
                                            @php
                                                $tanggal_akhir_kerja = $item->status_kerja;
                                                $statuskerja = 'Tetap';
                                            @endphp
                                        @elseif($item->status_kerja == 'PKWT')
                                            @php
                                                $tanggal_akhir_kerja = \Carbon\Carbon::parse($item->tanggal_akhir_kerja)->isoformat('DD-MM-Y');
                                                $statuskerja = 'Kontrak';
                                            @endphp
                                        @elseif($item->status_kerja == 'Harian')
                                            @php
                                                $tanggal_akhir_kerja = \Carbon\Carbon::parse($item->tanggal_akhir_kerja)->isoformat('DD-MM-Y');
                                                $statuskerja = 'Harian';
                                            @endphp
                                        @elseif($item->status_kerja == 'Outsourcing')
                                            @php
                                                $tanggal_akhir_kerja = \Carbon\Carbon::parse($item->tanggal_akhir_kerja)->isoformat('DD-MM-Y');
                                                $statuskerja = 'Outsourcing';
                                            @endphp
                                        @else
                                            @php
                                                $tanggal_akhir_kerja = \Carbon\Carbon::parse($item->tanggal_akhir_kerja)->isoformat('DD-MM-Y');
                                            @endphp
                                        @endif
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->nama_karyawan }}</td>
                                            <td>{{ $item->nik_karyawan }}</td>
                                            <td>{{ $item->golongans->golongan }}</td>
                                            <td>{{ $item->positions->jabatan }}</td>
                                            <td>{{ $item->divisions->penempatan }}</td>
                                            <td>{{ $statuskerja }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai_kerja)->isoformat('DD-MM-Y') }}
                                            </td>
                                            <td>{{ $tanggal_akhir_kerja }}
                                            </td>
                                            <td align=center>
                                                <a href="{{ route('employee.show', $item->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('employee.detail_employees', $item->nik_karyawan) }}"
                                                    class="btn btn-info btn-sm" target="_blank">
                                                    <i class="fa fa-print"></i>
                                                </a>

                                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                    <a href="{{ route('employee.edit', $item->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('employee.destroy', $item->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                @endif

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
