@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        @if (Auth::user()->roles == 'KARYAWAN')
            <main>
                {{-- Sumber --}}
                {{-- https://www.bootdey.com/ --}}
                {{-- Sumber --}}
                <div class="halaman-karyawan">
                    <div class="container">
                        <div class="col-lg-12">
                            <div class="panel profile-cover">
                                <div class="profile-cover__img">
                                    <img src="{{ Storage::url($datakaryawan->foto_karyawan) }}" class="img-fluid" />
                                    <h3 class="h3">{{ $datakaryawan->nama_karyawan }}</h3>
                                </div>
                                <div class="profile-cover__action bg--img" data-overlay="0.3">
                                    {{-- <a class="btn btn-rounded btn-info"
                                        href="{{ route('cetak.aktifkerja', $datakaryawan->id) }}" target=" _blank">
                                        <i class="fas fa-address-card"></i>
                                        <span>ID : {{ $datakaryawan->nik_karyawan }}</span>
                                    </a> --}}
                                    <a class="btn btn-rounded btn-info"
                                        href="{{ route('dashboard.form_ganti_foto_karyawan') }}">
                                        <i class="fas fa-address-card"></i>
                                        <span>Ganti Foto Profile</span>
                                    </a>
                                </div>

                                <div class="profile-cover__info">
                                    <ul class="nav">
                                        <li>Penempatan<strong>{{ $datakaryawan->divisions->penempatan }}</strong></li>
                                        <li>Jabatan<strong>{{ $datakaryawan->positions->jabatan }}</strong></li>
                                    </ul>
                                </div>

                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Profile {{ $datakaryawan->nama_karyawan }}</h3>
                                </div>

                                <div class="panel-content panel-activity">

                                    <div class="accordion" id="accordionExample">

                                        {{-- Informasi --}}
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingFour">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                    aria-expanded="false" aria-controls="collapseFour">
                                                    Informasi
                                                </button>
                                            </h2>
                                            <div id="collapseFour" class="accordion-collapse collapse"
                                                aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="alert alert-danger" role="alert">
                                                        Jika Biodata Diri, Status Pekerjaan, Dan Data Keluarga Ada yang
                                                        tidak sesuai dengan data sebenarnya, Harap Menghubungi HRD-GA....!!
                                                    </div>
                                                    <div class="alert alert-danger" role="alert">
                                                        Ganti Foto Profile Dengan Maksimal Size 500KB....!!
                                                    </div>
                                                    {{-- <img src={{ url('backend/assets/comingsoon/comingsoon2.jpg') }}
                                                        class="img-fluid" /> --}}

                                                </div>
                                            </div>
                                        </div>
                                        {{-- Informasi --}}

                                        {{-- Biodata --}}
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                    Biodata Diri
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">

                                                    <div class="row">
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>NIK
                                                                Karyawan</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->nik_karyawan }}">
                                                        </div>
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>Nama
                                                                Lengkap</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->nama_karyawan }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>No
                                                                NPWP</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->nomor_npwp }}">
                                                        </div>
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>No
                                                                Absen</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->nomor_absen }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label"><b>Email</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ $datakaryawan->email_karyawan }}">
                                                        </div>
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>No
                                                                HP</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ $datakaryawan->nomor_handphone }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>Tempat
                                                                Lahir</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ $datakaryawan->tempat_lahir }}">
                                                        </div>
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label"><b>Tanggal
                                                                Lahir</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ \Carbon\Carbon::parse($datakaryawan->tanggal_lahir)->isoformat('D MMMM Y') }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label"><b>Agama</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->agama }}">
                                                        </div>
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>Jenis
                                                                Kelamin</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ $datakaryawan->jenis_kelamin }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label"><b>Pendidikan
                                                                Terakhir</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ $datakaryawan->pendidikan_terakhir }}">
                                                        </div>
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label"><b>Golongan
                                                                Darah</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ $datakaryawan->golongan_darah }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label"><b>Alamat</b></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->alamat }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label"><b>RT</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->rt }}">
                                                        </div>
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label"><b>RW</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->rw }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label"><b>Kelurahan</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->kelurahan }}">
                                                        </div>
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label"><b>Kecamatan</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->kecamatan }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label"><b>Kabupaten/Kota</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->kota }}">
                                                        </div>
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label"><b>Provinsi</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->provinsi }}">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        {{-- Biodata --}}

                                        {{-- Pekerjaan --}}
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                    Status Pekerjaan
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">

                                                    <div class="row">
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>Nomor
                                                                Rekening</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ $datakaryawan->nomor_rekening }}">
                                                        </div>
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>Nomor
                                                                Kesehatan</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ $datakaryawan->nomor_bpjskesehatan }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>Nomor
                                                                BPJSTK</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ $datakaryawan->nomor_bpjsketenagakerjaan }}">
                                                        </div>
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>Status
                                                                Kerja</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ $datakaryawan->status_kerja }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>Mulai
                                                                Kerja</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ \Carbon\Carbon::parse($datakaryawan->tanggal_mulai_kerja)->isoformat('D MMMM Y') }}">
                                                        </div>
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>Akhir
                                                                Kerja</b></label>
                                                        @if ($datakaryawan->status_kerja == 'PKWTT')
                                                            @php
                                                                $akhirkerja = 'PKWTT';
                                                            @endphp
                                                        @else
                                                            @php
                                                                $akhirkerja = \Carbon\Carbon::parse($datakaryawan->tanggal_akhir_kerja)->isoformat('D MMMM Y');
                                                            @endphp
                                                        @endif
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $akhirkerja }}">
                                                        </div>
                                                    </div>

                                                    @if ($historykontrak != null)
                                                        <div class="timeline-kontrak">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <h4 class="card-title">History Kontrak</h4>
                                                                            <div class="mt-5">

                                                                                <div class="timeline">
                                                                                    @php
                                                                                        $no = 0;
                                                                                    @endphp
                                                                                    @foreach ($datahistorykontraks as $datahistorykontrak)
                                                                                        @php
                                                                                            $no++;
                                                                                        @endphp
                                                                                        @if ($no % 2 == 0)
                                                                                            <div
                                                                                                class="timeline-wrapper timeline-inverted timeline-wrapper-success">
                                                                                                <div
                                                                                                    class="timeline-badge">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="timeline-panel">
                                                                                                    <div
                                                                                                        class="timeline-heading">
                                                                                                        <h6
                                                                                                            class="timeline-title">
                                                                                                            {{ $datahistorykontrak->status_kontrak_kerja }}
                                                                                                        </h6>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="timeline-body">
                                                                                                        <p>{{ \Carbon\Carbon::parse($datahistorykontrak->tanggal_akhir_kontrak)->isoformat('D MMMM Y') }}
                                                                                                        </p>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="timeline-footer d-flex align-items-center flex-wrap">
                                                                                                        <i
                                                                                                            class="mdi mdi-heart-outline text-muted mr-1"></i>
                                                                                                        <span>{{ $datahistorykontrak->masa_kontrak }}</span>
                                                                                                    </div>
                                                                                                    <a href="{{ route('cetak.pkwt', $datahistorykontrak->id) }}"
                                                                                                        class="btn btn-primary btn-sm"
                                                                                                        target="_blank">
                                                                                                        <i
                                                                                                            class="fa fa-print"></i>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @else
                                                                                            <div
                                                                                                class="timeline-wrapper timeline-wrapper-primary">
                                                                                                <div
                                                                                                    class="timeline-badge">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="timeline-panel">
                                                                                                    <div
                                                                                                        class="timeline-heading">
                                                                                                        <h6
                                                                                                            class="timeline-title">
                                                                                                            {{ $datahistorykontrak->status_kontrak_kerja }}
                                                                                                        </h6>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="timeline-body">
                                                                                                        <p>{{ \Carbon\Carbon::parse($datahistorykontrak->tanggal_akhir_kontrak)->isoformat('D MMMM Y') }}
                                                                                                        </p>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="timeline-footer d-flex align-items-center flex-wrap">
                                                                                                        <i
                                                                                                            class="mdi mdi-heart-outline text-muted mr-1"></i>
                                                                                                        <span>{{ $datahistorykontrak->masa_kontrak }}</span>
                                                                                                    </div>
                                                                                                    <a href="{{ route('cetak.pkwt', $datahistorykontrak->id) }}"
                                                                                                        class="btn btn-primary btn-sm"
                                                                                                        target="_blank">
                                                                                                        <i
                                                                                                            class="fa fa-print"></i>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Pekerjaan --}}

                                        {{-- Keluarga --}}
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    Data Keluarga
                                                </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">

                                                    <div class="row">
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>Nomor
                                                                KK</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ $datakaryawan->nomor_kartu_keluarga }}">
                                                        </div>
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label"><b>Status</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="{{ $datakaryawan->status_nikah }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>Nama
                                                                Ayah</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->nama_ayah }}">
                                                        </div>
                                                        <label for="staticEmail" class="col-sm-2 col-form-label"><b>Nama
                                                                Ibu</b></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail" value="{{ $datakaryawan->nama_ibu }}">
                                                        </div>
                                                    </div>


                                                    @if ($datakaryawan->status_nikah == 'Menikah' && $historykeluarga != null)
                                                        <div class="timeline-keluarga">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <h4 class="card-title mb-5">History Keluarga
                                                                            </h4>

                                                                            <div class="hori-timeline" dir="ltr">
                                                                                <ul class="list-inline events">
                                                                                    @foreach ($datahistorykeluargas as $datahistorykeluarga)
                                                                                        <li
                                                                                            class="list-inline-item event-list">
                                                                                            <div
                                                                                                class="event-date bg-soft-primary text-primary">
                                                                                                {{ $datahistorykeluarga->hubungan_keluarga }}
                                                                                            </div>
                                                                                            <h5 class="font-size-16">
                                                                                                {{ $datahistorykeluarga->nama_history_keluarga }}
                                                                                            </h5>
                                                                                            <p class="text-muted">
                                                                                                {{ $datahistorykeluarga->nik_history_keluarga }}
                                                                                            </p>
                                                                                            <p class="text-muted">
                                                                                                {{ \Carbon\Carbon::parse($datahistorykeluarga->tanggal_lahir_history_keluarga)->isoformat('D MMMM Y') }}
                                                                                            </p>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end card -->
                                                                </div>
                                                            </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Keluarga --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        @elseif (Auth::user()->roles == 'LEADER')
        @else
            <main>
                <section class="section-dashboard-top mt-3">
                    <div class="container-fluid px-4">

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-dark text-white mb-4">
                                    <div class="card-body"><i class="fas fa-city"></i> Jumlah Karyawan ALL</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <div class="small text-white"><i class="fas fa-users"></i> {{ $itemall }}
                                            Acc,BSD,PDC
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-dark text-white mb-4">
                                    <div class="card-body"><i class="fas fa-city"></i> Accounting Office</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <div class="small text-white"><i class="fas fa-users"></i> {{ $itemaw }}
                                            PK66,BL25
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-dark text-white mb-4">
                                    <div class="card-body"><i class="fas fa-city"></i> Head Office</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <div class="small text-white"><i class="fas fa-users"></i> {{ $itembsd }}
                                            BSD
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-dark text-white mb-4">
                                    <div class="card-body"><i class="fas fa-city"></i> Sunter,Cibinong,Cibitung</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <div class="small text-white"><i class="fas fa-users"></i> {{ $itempdc }}
                                            Daihatsu
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div id="containerpenempatan"></div>
                                </div>
                            </div>
                            <div class="row  mt-3">
                                <div class="col-md-6">
                                    <div id="containerkontrak"></div>
                                </div>
                                <div class="col-md-6">
                                    <div id="containerstatusnikah"></div>
                                </div>
                            </div>
                            <div class="row  mt-3">
                                <div class="col-md-6">
                                    <div id="containerjeniskelamin"></div>
                                </div>
                                <div class="col-md-6">
                                    <div id="containeragama"></div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div id="containerpenempatandetail"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </main>
        @endif

        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    {{-- Chart ADMIN/HRD/MANAGER --}}
    {{-- Chart Penempatan --}}
    <script>
        var accounting = {{ json_encode($itemaccounting) }};
        var ic = {{ json_encode($itemic) }};
        var it = {{ json_encode($itemit) }};
        var hrd = {{ json_encode($itemhrd) }};
        var doccontrol = {{ json_encode($itemdoccontrol) }};
        var marketing = {{ json_encode($itemmarketing) }};
        var engineering = {{ json_encode($itemengineering) }};
        var quality = {{ json_encode($itemquality) }};
        var purchasing = {{ json_encode($itempurchasing) }};
        var ppc = {{ json_encode($itemppc) }};
        var produksi = {{ json_encode($itemproduksi) }};
        var deliveryproduksi = {{ json_encode($itemdeliveryproduksi) }};
        var gudangrm = {{ json_encode($itemgudangrm) }};
        var gudangfg = {{ json_encode($itemgudangfg) }};
        var delivery = {{ json_encode($itemdelivery) }};
        var security = {{ json_encode($itemsecurity) }};
        var blokbl = {{ json_encode($itemblokbl) }};
        var bloke = {{ json_encode($itembloke) }};
        var pdcdaihatsusunter = {{ json_encode($itempdcdaihatsusunter) }};
        var pdcdaihatsucibinong = {{ json_encode($itempdcdaihatsucibinong) }};
        var pdcdaihatsucibitung = {{ json_encode($itempdcdaihatsucibitung) }};
        var pdcdaihatsukarawangtimur = {{ json_encode($itempdcdaihatsukarawangtimur) }};
        var jumlahgreenville = {{ json_encode($itemjumlahgreenville) }};
        var jumlahhrd = {{ json_encode($itemjumlahhrd) }};
        var jumlahppc = {{ json_encode($itemjumlahppc) }};
        var jumlahproduksi = {{ json_encode($itemjumlahproduksi) }};

        Highcharts.chart('containerpenempatan', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:1f}'
                    }
                }
            },
            credits: {
                enabled: false
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>'
            },

            series: [{
                name: "Penempatan",
                colorByPoint: true,
                data: [{
                        name: "Accounting",
                        y: jumlahgreenville,
                        drilldown: "Accounting"
                    },
                    {
                        name: "HRD-GA",
                        y: jumlahhrd,
                        drilldown: "HRD-GA"
                    },
                    {
                        name: "PPC",
                        y: jumlahppc,
                        drilldown: "PPC"
                    },
                    {
                        name: "Produksi",
                        y: jumlahproduksi,
                        drilldown: "Produksi"
                    },
                    {
                        name: "Document Control",
                        y: doccontrol,
                        drilldown: null
                    },
                    {
                        name: "Marketing",
                        y: marketing,
                        drilldown: null
                    },
                    {
                        name: "Purchasing",
                        y: purchasing,
                        drilldown: null
                    },
                    {
                        name: "Engineering",
                        y: engineering,
                        drilldown: null
                    },
                    {
                        name: "Quality",
                        y: quality,
                        drilldown: null
                    }
                ]
            }],
            drilldown: {
                series: [{
                        name: "Accounting",
                        id: "Accounting",
                        data: [
                            [
                                "Accounting",
                                accounting
                            ],
                            [
                                "IC",
                                ic
                            ],
                            [
                                "IT",
                                it
                            ]
                        ]
                    },
                    {
                        name: "HRD-GA",
                        id: "HRD-GA",
                        data: [
                            [
                                "HRD-GA",
                                hrd
                            ],
                            [
                                "Security",
                                security
                            ]
                        ]
                    },
                    {
                        name: "PPC",
                        id: "PPC",
                        data: [
                            [
                                "PPC",
                                ppc
                            ],
                            [
                                "Delivery Produksi",
                                deliveryproduksi
                            ],
                            [
                                "Delivery",
                                delivery
                            ],
                            [
                                "Gudang Rawa Material",
                                gudangrm
                            ],
                            [
                                "Gudang Finish Goods",
                                gudangfg
                            ],
                            [
                                "Blok E",
                                bloke
                            ]
                        ]
                    },
                    {
                        name: "Produksi",
                        id: "Produksi",
                        data: [
                            [
                                "Produksi",
                                produksi
                            ],
                            [
                                "PDC Daihatsu Sunter",
                                pdcdaihatsusunter
                            ],
                            [
                                "PDC Daihatsu Cibinong",
                                pdcdaihatsucibinong
                            ],
                            [
                                "PDC Daihatsu Cibitung",
                                pdcdaihatsucibitung
                            ],
                            [
                                "PDC Daihatsu Karawang Timur",
                                pdcdaihatsukarawangtimur
                            ]
                        ]
                    }
                ]
            }
        });
    </script>
    {{-- Chart Penempatan --}}

    {{-- Chart Kontrak --}}
    <script>
        var kontrak = {{ json_encode($itemkontrak) }};
        var tetap = {{ json_encode($itemtetap) }};
        var harian = {{ json_encode($itemharian) }};
        var outsourcing = {{ json_encode($itemoutsourcing) }};
        Highcharts.chart('containerkontrak', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },

            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Tetap',
                    y: tetap,
                    sliced: true,
                    selected: true
                }, {
                    name: 'Kontrak',
                    y: kontrak
                }, {
                    name: 'Harian',
                    y: harian
                }, {
                    name: 'Outsourcing',
                    y: outsourcing
                }]
            }]
        });
    </script>
    {{-- Chart KOntrak --}}

    {{-- Chart Status Menikah --}}
    <script>
        var single = {{ json_encode($itemsingle) }};
        var menikah = {{ json_encode($itemmenikah) }};
        var janda = {{ json_encode($itemjanda) }};
        var duda = {{ json_encode($itemduda) }};
        Highcharts.chart('containerstatusnikah', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },

            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Single',
                    y: single,
                    sliced: true,
                    selected: true
                }, {
                    name: 'Menikah',
                    y: menikah
                }, {
                    name: 'Janda',
                    y: janda
                }, {
                    name: 'Duda',
                    y: duda
                }]
            }]
        });
    </script>
    {{-- Chart Status Menikah --}}

    {{-- Chart Jenis Kelamin --}}
    <script>
        var pria = {{ json_encode($itempria) }};
        var wanita = {{ json_encode($itemwanita) }};
        Highcharts.chart('containerjeniskelamin', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },

            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Pria',
                    y: pria,
                    sliced: true,
                    selected: true
                }, {
                    name: 'Wanita',
                    y: wanita
                }]
            }]
        });
    </script>
    {{-- Chart Jenis Kelamin --}}

    {{-- Chart Agama --}}
    <script>
        var islam = {{ json_encode($itemislam) }};
        var kristenprotestan = {{ json_encode($itemkristenprotestan) }};
        var kristenkatholik = {{ json_encode($itemkristenkatholik) }};
        var hindu = {{ json_encode($itemhindu) }};
        var budha = {{ json_encode($itembudha) }};
        Highcharts.chart('containeragama', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },

            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Islam',
                    y: islam,
                    sliced: true,
                    selected: true
                }, {
                    name: 'Kristen Protestan',
                    y: kristenprotestan
                }, {
                    name: 'Kristen Katholik',
                    y: kristenkatholik
                }, {
                    name: 'Hindu',
                    y: hindu
                }, {
                    name: 'Budha',
                    y: budha
                }]
            }]
        });
    </script>
    {{-- Chart Agama --}}

    {{-- Chart Penempatan Detail --}}
    <script>
        var accountingpkwtt = {{ json_encode($itemaccountingpkwtt) }};
        var accountingpkwt = {{ json_encode($itemaccountingpkwt) }};
        var accountingharian = {{ json_encode($itemaccountingharian) }};
        var accountingoutsourcing = {{ json_encode($itemaccountingoutsourcing) }};
        var icpkwtt = {{ json_encode($itemicpkwtt) }};
        var icpkwt = {{ json_encode($itemicpkwt) }};
        var icharian = {{ json_encode($itemicharian) }};
        var icoutsourcing = {{ json_encode($itemicoutsourcing) }};
        var itpkwtt = {{ json_encode($itemitpkwtt) }};
        var itpkwt = {{ json_encode($itemitpkwt) }};
        var itharian = {{ json_encode($itemitharian) }};
        var itoutsourcing = {{ json_encode($itemitoutsourcing) }};
        var hrdpkwtt = {{ json_encode($itemhrdpkwtt) }};
        var hrdpkwt = {{ json_encode($itemhrdpkwt) }};
        var hrdharian = {{ json_encode($itemhrdharian) }};
        var hrdoutsourcing = {{ json_encode($itemhrdoutsourcing) }};
        var doccontrolpkwtt = {{ json_encode($itemdoccontrolpkwtt) }};
        var doccontrolpkwt = {{ json_encode($itemdoccontrolpkwt) }};
        var doccontrolharian = {{ json_encode($itemdoccontrolharian) }};
        var doccontroloutsourcing = {{ json_encode($itemdoccontroloutsourcing) }};
        var marketingpkwtt = {{ json_encode($itemmarketingpkwtt) }};
        var marketingpkwt = {{ json_encode($itemmarketingpkwt) }};
        var marketingharian = {{ json_encode($itemmarketingharian) }};
        var marketingoutsourcing = {{ json_encode($itemmarketingoutsourcing) }};
        var engineeringpkwtt = {{ json_encode($itemengineeringpkwtt) }};
        var engineeringpkwt = {{ json_encode($itemengineeringpkwt) }};
        var engineeringharian = {{ json_encode($itemengineeringharian) }};
        var engineeringoutsourcing = {{ json_encode($itemengineeringoutsourcing) }};
        var qualitypkwtt = {{ json_encode($itemqualitypkwtt) }};
        var qualitypkwt = {{ json_encode($itemqualitypkwt) }};
        var qualityharian = {{ json_encode($itemqualityharian) }};
        var qualityoutsourcing = {{ json_encode($itemqualityoutsourcing) }};
        var purchasingpkwtt = {{ json_encode($itempurchasingpkwtt) }};
        var purchasingpkwt = {{ json_encode($itempurchasingpkwt) }};
        var purchasingharian = {{ json_encode($itempurchasingharian) }};
        var purchasingoutsourcing = {{ json_encode($itempurchasingoutsourcing) }};
        var ppcpkwtt = {{ json_encode($itemppcpkwtt) }};
        var ppcpkwt = {{ json_encode($itemppcpkwt) }};
        var ppcharian = {{ json_encode($itemppcharian) }};
        var ppcoutsourcing = {{ json_encode($itemppcoutsourcing) }};
        var produksipkwtt = {{ json_encode($itemproduksipkwtt) }};
        var produksipkwt = {{ json_encode($itemproduksipkwt) }};
        var produksiharian = {{ json_encode($itemproduksiharian) }};
        var produksioutsourcing = {{ json_encode($itemproduksioutsourcing) }};
        var deliveryproduksipkwtt = {{ json_encode($itemdeliveryproduksipkwtt) }};
        var deliveryproduksipkwt = {{ json_encode($itemdeliveryproduksipkwt) }};
        var deliveryproduksiharian = {{ json_encode($itemdeliveryproduksiharian) }};
        var deliveryproduksioutsourcing = {{ json_encode($itemdeliveryproduksioutsourcing) }};
        var deliveryproduksipkwtt = {{ json_encode($itemdeliveryproduksipkwtt) }};
        var deliveryproduksipkwt = {{ json_encode($itemdeliveryproduksipkwt) }};
        var deliveryproduksiharian = {{ json_encode($itemdeliveryproduksiharian) }};
        var deliveryproduksioutsourcing = {{ json_encode($itemdeliveryproduksioutsourcing) }};
        var gudangrmpkwtt = {{ json_encode($itemgudangrmpkwtt) }};
        var gudangrmpkwt = {{ json_encode($itemgudangrmpkwt) }};
        var gudangrmharian = {{ json_encode($itemgudangrmharian) }};
        var gudangrmoutsourcing = {{ json_encode($itemgudangrmoutsourcing) }};
        var gudangfgpkwtt = {{ json_encode($itemgudangfgpkwtt) }};
        var gudangfgpkwt = {{ json_encode($itemgudangfgpkwt) }};
        var gudangfgharian = {{ json_encode($itemgudangfgharian) }};
        var gudangfgoutsourcing = {{ json_encode($itemgudangfgoutsourcing) }};
        var deliverypkwtt = {{ json_encode($itemdeliverypkwtt) }};
        var deliverypkwt = {{ json_encode($itemdeliverypkwt) }};
        var deliveryharian = {{ json_encode($itemdeliveryharian) }};
        var deliveryoutsourcing = {{ json_encode($itemdeliveryoutsourcing) }};
        var securitypkwtt = {{ json_encode($itemsecuritypkwtt) }};
        var securitypkwt = {{ json_encode($itemsecuritypkwt) }};
        var securityharian = {{ json_encode($itemdeliveryharian) }};
        var securityoutsourcing = {{ json_encode($itemsecurityoutsourcing) }};
        var blokblpkwtt = {{ json_encode($itemblokblpkwtt) }};
        var blokblpkwt = {{ json_encode($itemblokblpkwt) }};
        var blokblharian = {{ json_encode($itemblokblharian) }};
        var blokbloutsourcing = {{ json_encode($itemblokbloutsourcing) }};
        var blokepkwtt = {{ json_encode($itemblokepkwtt) }};
        var blokepkwt = {{ json_encode($itemblokepkwt) }};
        var blokeharian = {{ json_encode($itemblokeharian) }};
        var blokeoutsourcing = {{ json_encode($itemblokeoutsourcing) }};
        var pdcdaihatsusunterpkwtt = {{ json_encode($itempdcdaihatsusunterpkwtt) }};
        var pdcdaihatsusunterpkwt = {{ json_encode($itempdcdaihatsusunterpkwt) }};
        var pdcdaihatsusunterharian = {{ json_encode($itempdcdaihatsusunterharian) }};
        var pdcdaihatsusunteroutsourcing = {{ json_encode($itempdcdaihatsusunteroutsourcing) }};
        var pdcdaihatsucibinongpkwtt = {{ json_encode($itempdcdaihatsucibinongpkwtt) }};
        var pdcdaihatsucibinongpkwt = {{ json_encode($itempdcdaihatsucibinongpkwt) }};
        var pdcdaihatsucibinongharian = {{ json_encode($itempdcdaihatsucibinongharian) }};
        var pdcdaihatsucibinongoutsourcing = {{ json_encode($itempdcdaihatsucibinongoutsourcing) }};
        var pdcdaihatsucibitungpkwtt = {{ json_encode($itempdcdaihatsucibitungpkwtt) }};
        var pdcdaihatsucibitungpkwt = {{ json_encode($itempdcdaihatsucibitungpkwt) }};
        var pdcdaihatsucibitungharian = {{ json_encode($itempdcdaihatsucibitungharian) }};
        var pdcdaihatsucibitungoutsourcing = {{ json_encode($itempdcdaihatsucibitungoutsourcing) }};
        var pdcdaihatsukarawangtimurpkwtt = {{ json_encode($itempdcdaihatsukarawangtimurpkwtt) }};
        var pdcdaihatsukarawangtimurpkwt = {{ json_encode($itempdcdaihatsukarawangtimurpkwt) }};
        var pdcdaihatsukarawangtimurharian = {{ json_encode($itempdcdaihatsukarawangtimurharian) }};
        var pdcdaihatsukarawangtimuroutsourcing = {{ json_encode($itempdcdaihatsukarawangtimuroutsourcing) }};

        Highcharts.chart('containerpenempatandetail', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Detail Penempatan Karyawan'
            },
            xAxis: {
                categories: ['Blok BL', 'Accounting', 'IC', 'IT', 'HRD', 'Doc Control', 'Marketing', 'Engineering',
                    'Quality',
                    'Purchasing', 'PPC', 'Produksi', 'Delivery Produksi', 'Gudang RM', 'Gudang FG', 'Delivery',
                    'Blok E', 'Daihatsu Sunter', 'Daihatsu Cibinong',
                    'Daihatsu Cibitung', 'Daihatsu Karawang Timur'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total Jumlah Karyawan'
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                column: {
                    stacking: 'percent'
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Tetap',
                data: [blokblpkwtt, accountingpkwtt, icpkwtt, itpkwtt, hrdpkwtt, doccontrolpkwtt,
                    marketingpkwtt,
                    engineeringpkwtt, qualitypkwtt, purchasingpkwtt, ppcpkwtt, produksipkwtt,
                    deliveryproduksipkwtt, gudangrmpkwtt, gudangfgpkwtt, deliverypkwtt,
                    blokepkwtt, pdcdaihatsusunterpkwtt,
                    pdcdaihatsucibinongpkwtt, pdcdaihatsucibitungpkwtt, pdcdaihatsukarawangtimurpkwtt
                ]
            }, {
                name: 'Kontrak',
                data: [blokblpkwt, accountingpkwt, icpkwt, itpkwt, hrdpkwt, doccontrolpkwt, marketingpkwt,
                    engineeringpkwt, qualitypkwt, purchasingpkwt, ppcpkwt, produksipkwt,
                    deliveryproduksipkwt, gudangrmpkwt, gudangfgpkwt, deliverypkwt,
                    blokepkwt, pdcdaihatsusunterpkwt, pdcdaihatsucibinongpkwt,
                    pdcdaihatsucibitungpkwt, pdcdaihatsukarawangtimurpkwt
                ]
            }, {
                name: 'Harian',
                data: [blokblharian, accountingharian, icharian, itharian, hrdharian, doccontrolharian,
                    marketingharian,
                    engineeringharian, qualityharian, purchasingharian, ppcharian, produksiharian,
                    deliveryproduksiharian, gudangrmharian, gudangfgharian, deliveryharian,
                    blokeharian, pdcdaihatsusunterharian,
                    pdcdaihatsucibinongharian, pdcdaihatsucibitungharian, pdcdaihatsukarawangtimurharian
                ]
            }]
        });
    </script>
    {{-- Chart Penempatan Detail --}}
    {{-- Chart ADMIN/HRD/MANAGER --}}

    {{-- Chart Leader --}}
    {{-- Chart Leader --}}
@endsection
