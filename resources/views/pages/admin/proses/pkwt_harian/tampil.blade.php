@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Proses</li>
                    <li class="breadcrumb-item active">PKWT Harian</li>
                </ol>

                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('proses.prosess_pkwt_harian') }}" method="POST" class="d-inline">
                            @csrf

                            <div class="form-group">

                                <input type="hidden" class="form-control" name="akhir_kontrak" readonly
                                    value="{{ $akhir_kontrak }}">
                                <input type="hidden" class="form-control" name="golongan" readonly
                                    value="{{ $golongan }}">

                                <div class="d-grid gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Perpanjangan
                                    </button>
                                    <a href="{{ route('proses.proses_pkwt_harian') }}" class="btn btn-danger btn-block">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data PKWT Harian Habis Tanggal {{ \Carbon\Carbon::parse($akhir_kontrak)->isoformat('D MMMM Y') }}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Penempatan</th>
                                        <th>Jabatan</th>
                                        <th>Tanggal Akhir Kerja</th>
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
                                            <td>{{ $item->divisions->penempatan }}</td>
                                            <td>{{ $item->positions->jabatan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_akhir_kerja)->isoformat('D MMMM Y') }}
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
