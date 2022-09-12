@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Employee</li>
                    <li class="breadcrumb-item active">Data Karyawan Aktif</li>
                </ol>

                <div class="card text-dark bg-info mb-3">
                    <div class="card-header">
                        <i class="fab fa-mailchimp"></i>
                        Show Data {{ $item->nama_karyawan }}
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card shadow">
                        <div class="card text-dark bg-light">
                            <div class="row p-3">

                                {{-- Foto --}}
                                <div class="col-lg-3 mt-4 mb-4">
                                    <div class="row">
                                        <img src="{{ Storage::url($item->foto_karyawan) }}" class="img-fluid rounded-circle"
                                            style="width: 250px;height: 250px;">
                                    </div>

                                    @if (Auth::user()->roles == 'ADMIN' ||
                                        Auth::user()->roles == 'MANAGER HRD' ||
                                        Auth::user()->roles == 'HRD' ||
                                        Auth::user()->roles == 'MANAGER ACCOUNTING' ||
                                        Auth::user()->roles == 'ACCOUNTING')
                                        <div class="text-center mt-4">
                                            <a href="{{ Storage::url($item->foto_ktp) }}" target="_blank"
                                                class="btn btn-primary btn-block">
                                                KTP
                                            </a>
                                            <a href="{{ Storage::url($item->foto_npwp) }}" target="_blank"
                                                class="btn btn-primary btn-block">
                                                NPWP
                                            </a>
                                            <a href="{{ Storage::url($item->foto_kk) }}" target="_blank"
                                                class="btn btn-primary btn-block">
                                                KK
                                            </a>
                                        </div>
                                    @endif

                                </div>
                                {{-- Foto --}}

                                <div class="col-lg-9 col-md-12">
                                    <div class="card-body">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-karyawan-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-karyawan" type="button"
                                                    role="tab" aria-controls="pills-karyawan"
                                                    aria-selected="true">Karyawan</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-divisi-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-divisi" type="button" role="tab"
                                                    aria-controls="pills-divisi" aria-selected="false">Divisi</button>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-salary-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-salary" type="button" role="tab"
                                                    aria-controls="pills-salary" aria-selected="false">Rekening</button>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-alamat-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-alamat" type="button" role="tab"
                                                    aria-controls="pills-alamat" aria-selected="false">Alamat</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-bpjs-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-bpjs" type="button" role="tab"
                                                    aria-controls="pills-bpjs" aria-selected="false">BPJS</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-history-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-history" type="button" role="tab"
                                                    aria-controls="pills-history" aria-selected="false">History</button>
                                            </li>
                                        </ul>

                                        <div class="tab-content p-3" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-karyawan" role="tabpanel"
                                                aria-labelledby="pills-karyawan-tab">

                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Nomor NIK KTP</h6>
                                                        <p class="card-text">{{ $item->nik_karyawan }}</p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <h6 class="card-title">Nama Karyawan</h6>
                                                        <p class="card-text">{{ $item->nama_karyawan }}</p>
                                                    </div>
                                                </div>


                                                @if ($item->nomor_npwp != null)
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-6">
                                                            <h6 class="card-title">Nomor NPWP</h6>
                                                            <p class="card-text">{{ $item->nomor_npwp }}</p>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6">
                                                            <h6 class="card-title">Nomor Absen</h6>
                                                            <p class="card-text">{{ $item->nomor_absen }}</p>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-6">
                                                            <h6 class="card-title">Nomor Absen</h6>
                                                            <p class="card-text">{{ $item->nomor_absen }}</p>
                                                        </div>
                                                    </div>
                                                @endif


                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Email</h6>
                                                        <p class="card-text">{{ $item->email_karyawan }}</p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <h6 class="card-title">Tempat / Tanggal Lahir</h6>
                                                        <p class="card-text">
                                                            {{ $item->tempat_lahir }} /
                                                            {{ \Carbon\Carbon::parse($item->tanggal_lahir)->isoformat('D MMMM Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Agama</h6>
                                                        <p class="card-text">{{ $item->agama }}</p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <h6 class="card-title">Jenis Kelamin</h6>
                                                        <p class="card-text">{{ $item->jenis_kelamin }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Pendidikan Terakhir</h6>
                                                        <p class="card-text">{{ $item->pendidikan_terakhir }}
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <h6 class="card-title">Golongan Darah</h6>
                                                        <p class="card-text">{{ $item->golongan_darah }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Nomor KK</h6>
                                                        <p class="card-text">{{ $item->nomor_kartu_keluarga }}
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <h6 class="card-title">Status Menikah</h6>
                                                        <p class="card-text">{{ $item->status_nikah }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Nama Ayah</h6>
                                                        <p class="card-text">{{ $item->nama_ayah }}</p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <h6 class="card-title">Nama Ibu</h6>
                                                        <p class="card-text">{{ $item->nama_ibu }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Nomor Handphone</h6>
                                                        <p class="card-text">{{ $item->nomor_handphone }}</p>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade" id="pills-divisi" role="tabpanel"
                                                aria-labelledby="pills-divisi-tab">

                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Perusahaan</h6>
                                                        <p class="card-text">
                                                            {{ $item->companies->nama_perusahaan }}
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <h6 class="card-title">Area</h6>
                                                        <p class="card-text">{{ $item->areas->area }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Penempatan</h6>
                                                        <p class="card-text">{{ $item->divisions->penempatan }}
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <h6 class="card-title">Jabatan</h6>
                                                        <p class="card-text">{{ $item->positions->jabatan }}
                                                        </p>
                                                    </div>
                                                </div>

                                                @if ($item->status_kerja == 'PKWTT')
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-6">
                                                            <h6 class="card-title">Tanggal Mulai Kerja</h6>
                                                            <p class="card-text">
                                                                {{ \Carbon\Carbon::parse($item->tanggal_mulai_kerja)->isoformat('D MMMM Y') }}
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6">
                                                            <h6 class="card-title">Status Kerja</h6>
                                                            <p class="card-text">
                                                                {{ $item->status_kerja }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-6">
                                                            <h6 class="card-title">Tanggal Mulai Kerja</h6>
                                                            <p class="card-text">
                                                                {{ \Carbon\Carbon::parse($item->tanggal_mulai_kerja)->isoformat('D MMMM Y') }}
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6">
                                                            <h6 class="card-title">Tanggal Akhir Kerja</h6>
                                                            <p class="card-text">
                                                                {{ \Carbon\Carbon::parse($item->tanggal_akhir_kerja)->isoformat('D MMMM Y') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-6">
                                                            <h6 class="card-title">Status Kerja</h6>
                                                            <p class="card-text">
                                                                {{ $item->status_kerja }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif


                                            </div>

                                            <div class="tab-pane fade" id="pills-salary" role="tabpanel"
                                                aria-labelledby="pills-salary-tab">

                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Nama Bank</h6>
                                                        <p class="card-text">{{ $item->nama_bank }}
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <h6 class="card-title">Nomor Rekening</h6>
                                                        <p class="card-text">{{ $item->nomor_rekening }}</p>
                                                    </div>
                                                </div>

                                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-6">
                                                            <h6 class="card-title">Gaji Pokok</h6>
                                                            <p class="card-text">
                                                                Rp.{{ number_format($salaries->gaji_pokok) }}
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6">
                                                            <h6 class="card-title">Uang Makan</h6>
                                                            <p class="card-text">
                                                                Rp.{{ number_format($salaries->uang_makan) }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-6">
                                                            <h6 class="card-title">Uang Transport</h6>
                                                            <p class="card-text">
                                                                Rp.{{ number_format($salaries->uang_transport) }}
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6">
                                                            <h6 class="card-title">Tunjangan Tugas</h6>
                                                            <p class="card-text">
                                                                Rp.{{ number_format($salaries->tunjangan_tugas) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-6">
                                                            <h6 class="card-title">Tunjangan Pulsa</h6>
                                                            <p class="card-text">
                                                                Rp.{{ number_format($salaries->tunjangan_pulsa) }}
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6">
                                                            <h6 class="card-title">Tunjangan Jabatan</h6>
                                                            <p class="card-text">
                                                                Rp.{{ number_format($salaries->tunjangan_jabatan) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-6">
                                                            <h6 class="card-title">Jumlah Upah</h6>
                                                            <p class="card-text">
                                                                Rp.{{ number_format($salaries->jumlah_upah) }}
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6">
                                                            <h6 class="card-title">Upah Lembur Perjam</h6>
                                                            <p class="card-text">
                                                                Rp.{{ number_format(round($salaries->upah_lembur_perjam, 0)) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>

                                            <div class="tab-pane fade" id="pills-alamat" role="tabpanel"
                                                aria-labelledby="pills-alamat-tab">

                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Alamat</h6>
                                                        <p class="card-text">{{ $item->alamat }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">RT</h6>
                                                        <p class="card-text">{{ $item->rt }}
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <h6 class="card-title">RW</h6>
                                                        <p class="card-text">{{ $item->rw }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Kelurahan</h6>
                                                        <p class="card-text">{{ $item->kelurahan }}
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <h6 class="card-title">Kecamatan</h6>
                                                        <p class="card-text">{{ $item->kecamatan }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Kota</h6>
                                                        <p class="card-text">{{ $item->kota }}
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <h6 class="card-title">Provinsi</h6>
                                                        <p class="card-text">{{ $item->provinsi }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6">
                                                        <h6 class="card-title">Kode POS</h6>
                                                        <p class="card-text">{{ $item->kode_pos }}
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade" id="pills-bpjs" role="tabpanel"
                                                aria-labelledby="pills-bpjs-tab">

                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <h6 class="card-title">BPJS Kesehatan</h6>
                                                        <p class="card-text">{{ $item->nomor_bpjskesehatan }}
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <h6 class="card-title">BPJS Ketenagakerjaan</h6>
                                                        <p class="card-text">{{ $item->nomor_bpjsketenagakerjaan }}</p>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade" id="pills-history" role="tabpanel"
                                                aria-labelledby="pills-history-tab">

                                                <div class="row">
                                                    <div class="col-lg-5 col-sm-5 mt-1">
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#HistoryKontrak">
                                                            History Kontrak
                                                        </button>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 mt-1">
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#HistoryJabatan">
                                                            History Jabatan
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-5 col-sm-5 mt-1">
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#HistoryTrainingInternal">
                                                            History Training Internal
                                                        </button>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 mt-1">
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#HistoryTrainingEksternal">
                                                            History Training Eksternal
                                                        </button>
                                                    </div>
                                                </div>

                                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'MANAGER HRD' || Auth::user()->roles == 'HRD')
                                                    <div class="row">
                                                        <div class="col-lg-5 col-sm-5 mt-1">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#HistoryKeluarga">
                                                                History Keluarga
                                                            </button>
                                                        </div>
                                                        <div class="col-lg-4 col-sm-4 mt-1">
                                                            <a href="{{ route('cetak.aktifkerja', $item->id) }}"
                                                                target="_blank" class="btn btn-primary btn-block">
                                                                Surat Keterangan Aktif Kerja
                                                            </a>
                                                        </div>
                                                    </div>
                                                @elseif (Auth::user()->roles == 'LEADER' ||
                                                    Auth::user()->roles == 'MANAGER ACCOUNTING' ||
                                                    Auth::user()->roles == 'ACCOUNTING')
                                                    <div class="row">
                                                        <div class="col-lg-5 col-sm-5 mt-1">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#HistoryKeluarga">
                                                                History Keluarga
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                {{-- Modal History Kontrak --}}
                <div class="modal fade" id="HistoryKontrak" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">History Kontrak
                                    {{ $item->nama_karyawan }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">

                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                    @if ($item->status_kerja != 'PKWTT')
                                        <a href="{{ route('history_contract.tambahhistorykontrak', $item->nik_karyawan) }}"
                                            class="btn btn-primary shadow-sm mb-3">
                                            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah History
                                        </a>
                                    @endif
                                @endif

                                <table class="table table-bordered" id="tableHistoryKontrak" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Awal Kontrak</th>
                                            <th>Akhir Kontrak</th>
                                            <th>Masa Kontrak</th>
                                            <th>Status Kontrak</th>
                                            @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($historycontracts as $historycontract)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ \Carbon\Carbon::parse($historycontract->tanggal_awal_kontrak)->isoformat('D MMMM Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($historycontract->tanggal_akhir_kontrak)->isoformat('D MMMM Y') }}
                                                </td>
                                                <td>{{ $historycontract->masa_kontrak }}</td>
                                                <td>{{ $historycontract->status_kontrak_kerja }}</td>
                                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                    <td>
                                                        <a href="{{ route('history_contract.edit', $historycontract->id) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('history_contract.destroy', $historycontract->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        <a href="{{ route('cetak.pkwt', $historycontract->id) }}"
                                                            class="btn btn-primary btn-sm" target="_blank">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Modal History Kontrak --}}

                {{-- Modal History Jabatan --}}
                <div class="modal fade" id="HistoryJabatan" tabindex="-1" aria-labelledby="HistoryJabatanLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="HistoryJabatanLabel">History Jabatan
                                    {{ $item->nama_karyawan }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">

                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                    <a href="{{ route('history_position.tambahhistoryjabatan', $item->nik_karyawan) }}"
                                        class="btn btn-primary shadow-sm mb-3">
                                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah History
                                    </a>
                                @endif

                                <table class="table table-bordered" id="tableHistoryJabatan" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Perusahaan</th>
                                            <th>Area</th>
                                            <th>Penempatan</th>
                                            <th>Jabatan</th>
                                            <th>Tanggal Mutasi</th>
                                            @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($historyjabatans as $historyjabatan)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $historyjabatan->companies->nama_perusahaan }}</td>
                                                <td>{{ $historyjabatan->areas->area }}</td>
                                                <td>{{ $historyjabatan->divisions->penempatan }}</td>
                                                <td>{{ $historyjabatan->positions->jabatan }}</td>
                                                <td>{{ \Carbon\Carbon::parse($historyjabatan->tanggal_mutasi)->isoformat('D MMMM Y') }}
                                                </td>
                                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                    <td>
                                                        <a href="{{ route('history_position.edit', $historyjabatan->id) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('history_position.destroy', $historyjabatan->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        <a href="{{ Storage::url($historyjabatan->file_surat_mutasi) }}"
                                                            target="_blank" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Modal History Jabatan --}}

                {{-- Modal History Training Internal --}}
                <div class="modal fade" id="HistoryTrainingInternal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">History Training Internal
                                    {{ $item->nama_karyawan }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">

                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                    <a href="{{ route('history_training_internal.tambahhistorytraininginternal', $item->nik_karyawan) }}"
                                        class="btn btn-primary shadow-sm mb-3">
                                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah History
                                    </a>
                                @endif

                                <table class="table table-bordered" id="tableHistoryTrainingInternal" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Training</th>
                                            <th>Jam Training</th>
                                            <th>Lokasi Training</th>
                                            <th>Materi Training</th>
                                            <th>Trainer</th>
                                            @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($historytraininginternals as $historytraininginternal)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ \Carbon\Carbon::parse($historytraininginternal->tanggal_training_internal)->isoformat('D MMMM Y') }}
                                                </td>
                                                <td>{{ $historytraininginternal->jam_training_internal }}</td>
                                                <td>{{ $historytraininginternal->lokasi_training_internal }}</td>
                                                <td>{{ $historytraininginternal->materi_training_internal }}</td>
                                                <td>{{ $historytraininginternal->trainer_training_internal }}</td>
                                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                    <td>
                                                        <a href="{{ route('history_training_internal.edit', $historytraininginternal->id) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('history_training_internal.destroy', $historytraininginternal->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger btn-sm">
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Modal History Training Internal --}}

                {{-- Modal History Training Eksternal --}}
                <div class="modal fade" id="HistoryTrainingEksternal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">History Training Eksternal
                                    {{ $item->nama_karyawan }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">

                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                    <a href="{{ route('history_training_eksternal.tambahhistorytrainingeksternal', $item->nik_karyawan) }}"
                                        class="btn btn-primary shadow-sm mb-3">
                                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah History
                                    </a>
                                @endif

                                <table class="table table-bordered" id="tableHistoryTrainingEksternal" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Institusi</th>
                                            <th>Perihal Training</th>
                                            <th>Awal Training</th>
                                            <th>Akhir Training</th>
                                            <th>Lokasi Training</th>
                                            @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($historytrainingeksternals as $historytrainingeksternal)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $historytrainingeksternal->institusi_penyelenggara_training_eksternal }}
                                                </td>
                                                <td>{{ $historytrainingeksternal->perihal_training_eksternal }}</td>
                                                <td>{{ \Carbon\Carbon::parse($historytrainingeksternal->tanggal_awal_training_eksternal)->isoformat('D MMMM Y') }}
                                                <td>{{ \Carbon\Carbon::parse($historytrainingeksternal->tanggal_akhir_training_eksternal)->isoformat('D MMMM Y') }}
                                                </td>
                                                <td>{{ $historytrainingeksternal->lokasi_training_eksternal }}</td>
                                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                    <td>
                                                        <a href="{{ route('history_training_eksternal.edit', $historytrainingeksternal->id) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('history_training_eksternal.destroy', $historytrainingeksternal->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger btn-sm">
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Modal History Training Internal --}}

                {{-- Modal History Keluarga --}}
                <div class="modal fade" id="HistoryKeluarga" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">History Keluarga
                                    {{ $item->nama_karyawan }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">

                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                    <a href="{{ route('history_family.tambahhistoryfamily', $item->nik_karyawan) }}"
                                        class="btn btn-primary shadow-sm mb-3">
                                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah History
                                    </a>
                                @endif

                                <table class="table table-bordered" id="tableHistoryKeluarga" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Status</th>
                                            <th>NIK</th>
                                            <th>No BPJS</th>
                                            <th>Nama</th>
                                            <th>Tempat Tgl Lahir</th>
                                            @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($historyfamilies as $historyfamily)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $historyfamily->hubungan_keluarga }}</td>
                                                <td>{{ $historyfamily->nik_history_keluarga }}</td>
                                                <td>{{ $historyfamily->nomor_bpjs_kesehatan_history_keluarga }}</td>
                                                <td>{{ $historyfamily->nama_history_keluarga }}</td>
                                                <td>{{ $historyfamily->tempat_lahir_history_keluarga . '-' . \Carbon\Carbon::parse($historyfamily->tanggal_lahir_history_keluarga)->isoformat('D MMMM Y') }}
                                                </td>
                                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                    <td>
                                                        <a href="{{ route('history_family.edit', $historyfamily->id) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('history_family.destroy', $historyfamily->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        <a href="{{ Storage::url($historyfamily->dokumen_history_keluarga) }}"
                                                            target="_blank" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Modal History Keluarga --}}

            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
@endsection
