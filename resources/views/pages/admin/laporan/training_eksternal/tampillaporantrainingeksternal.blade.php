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
                    <li class="breadcrumb-item active">Laporan Training Eksternal</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Laporan Training Eksternal Karyawan Periode
                        {{ \Carbon\Carbon::parse($awal)->isoformat('DD-MM-Y') . ' s/d ' . \Carbon\Carbon::parse($akhir)->isoformat('DD-MM-Y') }}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>NIK</th>
                                        <th>Jabatan</th>
                                        <th>Materi Training</th>
                                        <th>Tanggal Training</th>
                                        <th>Institusi</th>
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
                                            <td>{{ $item->jabatan }}</td>
                                            <td>{{ $item->perihal_training_eksternal }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_awal_training_eksternal)->isoformat('DD-MM-Y') }}
                                            </td>
                                            <td>{{ $item->institusi_penyelenggara_training_eksternal }}</td>
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
