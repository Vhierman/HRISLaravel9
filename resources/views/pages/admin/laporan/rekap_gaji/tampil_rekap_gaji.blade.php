@extends('layouts.admin')

@section('content')
    <script type="text/javascript">
        function viewdata($nik_karyawan, $nama_karyawan, $jabatan, $penempatan, $gaji_pokok, $uang_makan,
            $uang_transport, $tunjangan_tugas, $tunjangan_pulsa,
            $tunjangan_jabatan,
            $jumlah_upah, $upah_lembur_perjam, $potongan_bpjsks_perusahaan,
            $potongan_jht_perusahaan, $potongan_jp_perusahaan, $potongan_jkm_perusahaan,
            $potongan_jkk_perusahaan, $jumlah_bpjstk_perusahaan,
            $potongan_bpjsks_karyawan, $potongan_jht_karyawan, $potongan_jp_karyawan, $jumlah_bpjstk_karyawan,
            $take_home_pay) {
            $("#nik_karyawan").val($nik_karyawan);
            $("#nama_karyawan").val($nama_karyawan);
            $("#jabatan").val($jabatan);
            $("#penempatan").val($penempatan);
            $("#gaji_pokok").val($gaji_pokok);
            $("#uang_makan").val($uang_makan);
            $("#uang_transport").val($uang_transport);
            $("#tunjangan_tugas").val($tunjangan_tugas);
            $("#tunjangan_pulsa").val($tunjangan_pulsa);
            $("#tunjangan_jabatan").val($tunjangan_jabatan);
            $("#jumlah_upah").val($jumlah_upah);
            $("#upah_lembur_perjam").val($upah_lembur_perjam);
            $("#potongan_bpjsks_perusahaan").val($potongan_bpjsks_perusahaan);
            $("#potongan_jht_perusahaan").val($potongan_jht_perusahaan);
            $("#potongan_jp_perusahaan").val($potongan_jp_perusahaan);
            $("#potongan_jkm_perusahaan").val($potongan_jkm_perusahaan);
            $("#potongan_jkk_perusahaan").val($potongan_jkk_perusahaan);
            $("#jumlah_bpjstk_perusahaan").val($jumlah_bpjstk_perusahaan);
            $("#potongan_bpjsks_karyawan").val($potongan_bpjsks_karyawan);
            $("#potongan_jht_karyawan").val($potongan_jht_karyawan);
            $("#potongan_jp_karyawan").val($potongan_jp_karyawan);
            $("#jumlah_bpjstk_karyawan").val($jumlah_bpjstk_karyawan);
            $("#take_home_pay").val($take_home_pay);
        }
    </script>

    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Process</li>
                    <li class="breadcrumb-item active">Tampil Rekap Salary</li>
                </ol>

                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('laporan.export_excell_rekap_gaji') }}" method="POST" class="d-inline">
                            @csrf
                            <div class="form-group">

                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="awal" readonly
                                        value="{{ $awal }}">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="akhir" readonly
                                        value="{{ $akhir }}">
                                </div>

                                <div class="d-grid gap-2 mt-3">
                                    <button type="submit" class="btn btn-success btn-block">
                                        Download Excell Rekap Gaji Periode
                                        {{ \Carbon\Carbon::parse($awal)->isoformat('D MMMM Y') }} s/d
                                        {{ \Carbon\Carbon::parse($akhir)->isoformat('D MMMM Y') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('laporan.cancel_rekap_gaji') }}" method="POST" class="d-inline">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="awal" readonly
                                    value="{{ $awal }}">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="akhir" readonly
                                    value="{{ $akhir }}">
                            </div>
                            <div class="form-group">
                                <div class="d-grid gap-2 mt-2">
                                    <button type="submit" class="btn btn-danger btn-block">
                                        Cancel Rekap Gaji Periode
                                        {{ \Carbon\Carbon::parse($awal)->isoformat('D MMMM Y') }} s/d
                                        {{ \Carbon\Carbon::parse($akhir)->isoformat('D MMMM Y') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Rekap Salary
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
                                        <th>Penempatan</th>
                                        <th>Jumlah Upah</th>
                                        <th>Upah Lembur Perjam</th>
                                        <th>Pot Absen</th>
                                        <th>Take Home Pay</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($items as $item)
                                        @php
                                            $nik = $item->nik_karyawan;
                                            
                                            $konversibulanawal = \Carbon\Carbon::parse($awal)->isoformat('MM');
                                            $konversitahunawal = \Carbon\Carbon::parse($awal)->isoformat('YYYY');
                                            $tanggal_awal = $konversitahunawal . '-' . $konversibulanawal . '-' . '16';
                                            
                                            $konversibulanakhir = \Carbon\Carbon::parse($akhir)->isoformat('MM');
                                            $konversitahunakhir = \Carbon\Carbon::parse($akhir)->isoformat('YYYY');
                                            $tanggal_akhir = $konversitahunakhir . '-' . $konversibulanakhir . '-' . '15';
                                            
                                            $potabsen = DB::table('attendances')
                                                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                                                ->groupBy('employees_id', 'nama_karyawan', 'nik_karyawan', 'lama_absen')
                                                ->select('employees_id', 'nama_karyawan', 'nik_karyawan', 'lama_absen', DB::raw('sum(lama_absen) as lama_absen'))
                                                ->where('attendances.employees_id', $nik)
                                                ->where('attendances.deleted_at', null)
                                                ->where('employees.deleted_at', null)
                                                ->whereBetween('tanggal_absen', [$tanggal_awal, $tanggal_akhir])
                                                ->first();
                                        @endphp

                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->nik_karyawan }}</td>
                                            <td>{{ $item->nama_karyawan }}</td>
                                            <td>{{ $item->golongan }}</td>
                                            <td>{{ $item->penempatan }}</td>
                                            <td>{{ number_format($item->jumlah_upah) }}</td>
                                            <td>{{ number_format($item->upah_lembur_perjam) }}</td>
                                            @if ($potabsen == null)
                                                <td>{{ 0 }}</td>
                                            @else
                                                <td>{{ $potabsen->lama_absen }}</td>
                                            @endif
                                            <td>{{ number_format($item->take_home_pay) }}</td>
                                            <td align=center>
                                                <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#ViewSalary"
                                                    onclick="viewdata(
                                                    '{{ $item->nik_karyawan }}',
                                                    '{{ $item->nama_karyawan }}',
                                                    '{{ $item->jabatan }}',
                                                    '{{ $item->penempatan }}',
                                                    '{{ number_format($item->gaji_pokok) }}',
                                                    '{{ number_format($item->uang_makan) }}',
                                                    '{{ number_format($item->uang_transport) }}',
                                                    '{{ number_format($item->tunjangan_tugas) }}',
                                                    '{{ number_format($item->tunjangan_pulsa) }}',
                                                    '{{ number_format($item->tunjangan_jabatan) }}',
                                                    '{{ number_format($item->jumlah_upah) }}',
                                                    '{{ number_format($item->upah_lembur_perjam) }}',
                                                    '{{ number_format($item->potongan_bpjsks_perusahaan) }}',
                                                    '{{ number_format($item->potongan_jht_perusahaan) }}',
                                                    '{{ number_format($item->potongan_jp_perusahaan) }}',
                                                    '{{ number_format($item->potongan_jkm_perusahaan) }}',
                                                    '{{ number_format($item->potongan_jkk_perusahaan) }}',
                                                    '{{ number_format($item->jumlah_bpjstk_perusahaan) }}',
                                                    '{{ number_format($item->potongan_bpjsks_karyawan) }}',
                                                    '{{ number_format($item->potongan_jht_karyawan) }}',
                                                    '{{ number_format($item->potongan_jp_karyawan) }}',
                                                    '{{ number_format($item->jumlah_bpjstk_karyawan) }}',
                                                    '{{ number_format($item->take_home_pay) }}'
                                                    )">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <form action="{{ route('laporan.cetak_slip_gaji') }}" method="POST"
                                                    class="d-inline" target="_blank">
                                                    @csrf
                                                    <input type="hidden" class="form-control" name="nik_karyawan" readonly
                                                        value="{{ $item->employees_id }}">
                                                    <input type="hidden" class="form-control" name="awal" readonly
                                                        value="{{ $awal }}">
                                                    <input type="hidden" class="form-control" name="akhir" readonly
                                                        value="{{ $akhir }}">
                                                    <button type="submit" class="btn btn-info btn-sm ">
                                                        <i class="fa fa-print"></i>
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
        {{-- Modal --}}
        <div class="modal fade" id="ViewSalary" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Salary</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">NIK</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="nik_karyawan">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="nama_karyawan">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Jabatan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="jabatan">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Penempatan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="penempatan">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Gaji Pokok</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="gaji_pokok">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Uang Makan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="uang_makan">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Uang Transport</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="uang_transport">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Tunjangan Tugas</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="tunjangan_tugas">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Tunjangan Pulsa</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="tunjangan_pulsa">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Tunjangan Jabatan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="tunjangan_jabatan">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Jumlah Upah</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="jumlah_upah">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Upah Lembur Perjam</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="upah_lembur_perjam">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">POT BPJKS Perusahaan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="potongan_bpjsks_perusahaan">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">POT JHT Perusahaan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="potongan_jht_perusahaan">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">POT JP Perusahaan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="potongan_jp_perusahaan">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">POT JKM Perusahaan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="potongan_jkm_perusahaan">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">POT JKK Perusahaan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="potongan_jkk_perusahaan">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Jmlh BPJSTK Perusahaan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="jumlah_bpjstk_perusahaan">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">POT BPJSKS Karyawan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="potongan_bpjsks_karyawan">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">POT JHT Karyawan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="potongan_jht_karyawan">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">POT JP Karyawan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="potongan_jp_karyawan">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Jmlh BPJSTK Karyawan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="jumlah_bpjstk_karyawan">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Take Home Pay</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="take_home_pay">
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Modal --}}
    </div>
    {{-- End Content Dan Footer --}}
@endsection
