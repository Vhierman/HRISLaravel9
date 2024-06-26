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
                    <li class="breadcrumb-item active">Overtime</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Overtimes
                    </div>

                    @if (!$items->isEmpty())
                        <div class="card shadow">
                            <div class="card-body">
                                <form action="{{ route('overtime.proses_approve_overtime') }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <div class="form-group">

                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Mulai Dari</label>
                                            <input type="date" class="form-control" name="awal" readonly
                                                value="{{ $awal }}">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="title" class="form-label">Sampai Tanggal</label>
                                            <input type="date" class="form-control" name="akhir" readonly
                                                value="{{ $akhir }}">
                                        </div>

                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                Approve
                                            </button>
                                            <a href="{{ route('overtime.index') }}" class="btn btn-danger btn-block">
                                                Cancel
                                            </a>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>NIK Karyawan</th>
                                        <th>Golongan</th>
                                        <th>Jabatan</th>
                                        <th>Penempatan</th>
                                        <th>Tanggal Lembur</th>
                                        <th>Jenis Lembur</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Istirahat</th>
                                        <th>Jam Pulang</th>
                                        <th>Jumlah Jam</th>
                                        <th>Uang Makan</th>
                                        <th>Keterangan</th>
                                        <th>Approval</th>
                                        <th>Status</th>
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
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_lembur)->isoformat('DD-MM-Y') }}
                                            </td>
                                            <td>{{ $item->jenis_lembur }}</td>
                                            <td>{{ $item->jam_masuk }}</td>
                                            <td>{{ $item->jam_istirahat }}</td>
                                            <td>{{ $item->jam_pulang }}</td>
                                            <td>{{ $item->jam_lembur }}</td>
                                            <td>{{ $item->uang_makan_lembur }}</td>
                                            <td>{{ $item->keterangan_lembur }}</td>
                                            <td>
                                                <a href="{{ route('overtime.edit_approval', $item->id) }}"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fa fa-pencil-alt"></i> Edit
                                                </a>
                                            </td>
                                            @if ($item->acc_hrd == null)
                                                <td><span class="badge bg-danger">Belum Disetujui</span></td>
                                            @else
                                                <td><span class="badge bg-primary">Disetujui</span></td>
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
