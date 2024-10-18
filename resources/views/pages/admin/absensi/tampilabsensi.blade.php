@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Absensi</li>
                    <li class="breadcrumb-item active">Data Absensi</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Absensi Karyawan Periode
                        {{ \Carbon\Carbon::parse($awal)->isoformat('DD-MM-Y') . ' s/d ' . \Carbon\Carbon::parse($akhir)->isoformat('DD-MM-Y') }}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>NIK Karyawan</th>
                                        <th>Gol</th>
                                        <th>Jabatan</th>
                                        <th>Penempatan</th>
                                        <th>Status</th>
                                        <th>Tanggal Absen</th>
                                        <th>Jenis Absen</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->nama_karyawan }}</td>
                                            <td>{{ $item->nik_karyawan }}</td>
                                            <td>{{ $item->golongan }}</td>
                                            <td>{{ $item->jabatan }}</td>
                                            <td>{{ $item->penempatan }}</td>
                                            <td>{{ $item->status_kerja }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_absen)->isoformat('DD-MM-Y') }}
                                            </td>
                                            <td>{{ $item->keterangan_absen }}</td>
                                            <td>{{ $item->keterangan_cuti_khusus }}</td>
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
