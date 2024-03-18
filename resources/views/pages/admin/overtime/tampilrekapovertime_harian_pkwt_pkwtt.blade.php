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
                        Data Rekap Overtimes {{ $divisions_id }}
                    </div>

                    <form action="{{ route('overtime.export_pdf_rekap_overtime_harian_pkwt_pkwtt') }}" target="_blank"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mt-2">
                            <input type="text" class="form-control" name="awal" readonly value="{{ $awal }}">
                        </div>
                        <div class="form-group mt-2">
                            <input type="text" class="form-control" name="akhir" readonly value="{{ $akhir }}">
                        </div>
                        <div class="form-group mt-2">
                            <input type="text" class="form-control" name="divisions_id" readonly
                                value="{{ $divisions_id }}">
                        </div>
                        <div class="form-group mt-2">
                            <input type="text" class="form-control" name="status_kerja" readonly
                                value="{{ $status_kerja }}">
                        </div>
                        <div class="form-group mt-2">
                            <input type="text" class="form-control" name="note_lembur" readonly
                                value="{{ $note_lembur }}">
                        </div>
                        <div class="d-grid gap-2 mt-2">
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-download fa-sm text-white-50"></i>
                                Download PDF
                            </button>
                        </div>
                    </form>

                    {{-- Export Excell Masih Dalam Tahap Pengembangan --}}
                    {{-- <form action="{{ route('overtimes.export_excel_rekap_overtime') }}" target="_blank" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mt-2">
                            <input type="hidden" class="form-control" name="awal" readonly value="{{ $awal }}">
                        </div>
                        <div class="form-group mt-2">
                            <input type="hidden" class="form-control" name="akhir" readonly value="{{ $akhir }}">
                        </div>
                        <div class="form-group mt-2">
                            <input type="hidden" class="form-control" name="divisions_id" readonly
                                value="{{ $divisions_id }}">
                        </div>
                        <div class="form-group mt-2">
                            <input type="hidden" class="form-control" name="status_kerja" readonly
                                value="{{ $status_kerja }}">
                        </div>
                        <div class="d-grid gap-2 mt-2">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-download fa-sm text-white-50"></i>
                                Download Excell
                            </button>
                        </div>
                    </form> --}}

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK Karyawan</th>
                                        <th>Nama Karyawan</th>
                                        <th>No Rekening</th>
                                        <th>Jabatan</th>
                                        <th>Jumlah Jam Lembur</th>
                                        <th>Upah Lembur Perjam</th>
                                        <th>Jumlah Uang Lembur</th>
                                        <th>Uang Makan Lembur</th>
                                        <th>Jumlah Uang Diterima</th>
                                        <th>Jumlah Uang Diterima Pembulatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($items as $item)
                                        @php
                                            $jumlahjam = $item->jumlah_jam_pertama + $item->jumlah_jam_kedua + $item->jumlah_jam_ketiga + $item->jumlah_jam_keempat;
                                            $uangmakanlembur = $item->uang_makan_lembur;
                                        @endphp

                                        @php

                                            $bulanawal = \Carbon\Carbon::parse($awal)->isoformat('MM');
                                            $bulanakhir = \Carbon\Carbon::parse($akhir)->isoformat('MM');
                                            $tahunawal = \Carbon\Carbon::parse($awal)->isoformat('YYYY');
                                            $tahunakhir = \Carbon\Carbon::parse($akhir)->isoformat('YYYY');

                                            $collections = DB::table('overtimes')
                                                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                                                ->join('history_salaries', 'employees.nik_karyawan', '=', 'history_salaries.employees_id')
                                                ->join('rekap_salaries', 'employees.nik_karyawan', '=', 'rekap_salaries.employees_id')
                                                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                                                ->where('overtimes.employees_id', $item->employees_id)
                                                ->where('overtimes.acc_hrd', '<>', null)
                                                ->where('overtimes.deleted_at', null)
                                                ->where('rekap_salaries.deleted_at', null)
                                                ->whereBetween('tanggal_lembur', [$awal, $akhir])
                                                ->whereMonth('rekap_salaries.periode_awal', $bulanawal)
                                                ->whereMonth('rekap_salaries.periode_akhir', $bulanakhir)
                                                ->whereYear('rekap_salaries.periode_awal', $tahunawal)
                                                ->whereYear('rekap_salaries.periode_akhir', $tahunakhir)
                                                ->first();
                                        @endphp
                                        @php
                                            $namakaryawan = $collections->nama_karyawan;
                                            $jabatan = $collections->jabatan;
                                            $nomorrekening = $collections->nomor_rekening;
                                            $upahlemburperjam = $collections->upah_lembur_perjam;
                                            $jumlahuanglembur = $upahlemburperjam * $jumlahjam;
                                            $jumlahuangditerima = $jumlahuanglembur + $uangmakanlembur;

                                            $jumlahuangditerimapembulatan = ceil($jumlahuangditerima);
                                            // if (substr($jumlahuangditerimapembulatan, -2) <= 0) {
                                            //     $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2);
                                            // } else {
                                            //     $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2) + 100;
                                            // }
                                            if (substr($jumlahuangditerimapembulatan, -2) > 50 && substr($jumlahuangditerimapembulatan, -2) < 100) {
                                                $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2);
                                            } elseif (substr($jumlahuangditerimapembulatan, -2) < 50 && substr($jumlahuangditerimapembulatan, -2) > 0) {
                                                $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2) + 100;
                                            } elseif (substr($jumlahuangditerimapembulatan, -2) <= 0) {
                                                $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2);
                                            } elseif (substr($jumlahuangditerimapembulatan, -2) == 50) {
                                                $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2);
                                            } else {
                                                $total_jumlahuangditerima = 0;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->employees_id }}</td>
                                            <td>{{ $namakaryawan }}</td>
                                            <td>{{ $nomorrekening }}</td>
                                            <td>{{ $jabatan }}</td>
                                            <td>{{ $jumlahjam }}</td>
                                            <td>{{ number_format($upahlemburperjam) }}</td>
                                            <td>{{ number_format($jumlahuanglembur) }}</td>
                                            <td>{{ number_format($uangmakanlembur) }} </td>
                                            <td>{{ number_format($jumlahuangditerima) }} </td>
                                            <td>{{ number_format($total_jumlahuangditerima) }} </td>
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
