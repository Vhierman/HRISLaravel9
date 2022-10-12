@extends('layouts.admin')

@section('content')
    <script type="text/javascript">
        function viewdata($employees_id, $companies_id, $golongans_id, $areas_id, $divisions_id, $positions_id,
            $nama_karyawan_keluar,
            $nomor_npwp_karyawan_keluar, $email_karyawan_keluar, $nomor_handphone_karyawan_keluar,
            $tempat_lahir_karyawan_keluar,
            $tanggal_lahir_karyawan_keluar, $nomor_bpjsketenagakerjaan_karyawan_keluar,
            $nomor_bpjskesehatan_karyawan_keluar, $nomor_rekening_karyawan_keluar, $pendidikan_terakhir_karyawan_keluar,
            $jenis_kelamin_karyawan_keluar, $agama_karyawan_keluar,
            $alamat_karyawan_keluar, $rt_karyawan_keluar, $rw_karyawan_keluar, $kelurahan_karyawan_keluar,
            $kecamatan_karyawan_keluar, $kota_karyawan_keluar, $provinsi_karyawan_keluar, $kode_pos_karyawan_keluar,
            $nomor_absen_karyawan_keluar, $golongan_darah_karyawan_keluar, $nomor_kartu_keluarga_karyawan_keluar,
            $status_nikah_karyawan_keluar, $nama_ayah_karyawan_keluar, $nama_ibu_karyawan_keluar,
            $tanggal_masuk_karyawan_keluar, $tanggal_keluar_karyawan_keluar,
            $status_kerja_karyawan_keluar, $keterangan_keluar) {
            $("#employees_id").val($employees_id);
            $("#companies_id").val($companies_id);
            $("#golongans_id").val($golongans_id);
            $("#areas_id").val($areas_id);
            $("#divisions_id").val($divisions_id);
            $("#positions_id").val($positions_id);
            $("#nama_karyawan_keluar").val($nama_karyawan_keluar);
            $("#nomor_npwp_karyawan_keluar").val($nomor_npwp_karyawan_keluar);
            $("#email_karyawan_keluar").val($email_karyawan_keluar);
            $("#nomor_handphone_karyawan_keluar").val($nomor_handphone_karyawan_keluar);
            $("#tempat_lahir_karyawan_keluar").val($tempat_lahir_karyawan_keluar);
            $("#tanggal_lahir_karyawan_keluar").val($tanggal_lahir_karyawan_keluar);
            $("#nomor_bpjsketenagakerjaan_karyawan_keluar").val($nomor_bpjsketenagakerjaan_karyawan_keluar);
            $("#nomor_bpjskesehatan_karyawan_keluar").val($nomor_bpjskesehatan_karyawan_keluar);
            $("#nomor_rekening_karyawan_keluar").val($nomor_rekening_karyawan_keluar);
            $("#pendidikan_terakhir_karyawan_keluar").val($pendidikan_terakhir_karyawan_keluar);
            $("#jenis_kelamin_karyawan_keluar").val($jenis_kelamin_karyawan_keluar);
            $("#agama_karyawan_keluar").val($agama_karyawan_keluar);
            $("#alamat_karyawan_keluar").val($alamat_karyawan_keluar);
            $("#rt_karyawan_keluar").val($rt_karyawan_keluar);
            $("#rw_karyawan_keluar").val($rw_karyawan_keluar);
            $("#kelurahan_karyawan_keluar").val($kelurahan_karyawan_keluar);
            $("#kecamatan_karyawan_keluar").val($kecamatan_karyawan_keluar);
            $("#kota_karyawan_keluar").val($kota_karyawan_keluar);
            $("#provinsi_karyawan_keluar").val($provinsi_karyawan_keluar);
            $("#kode_pos_karyawan_keluar").val($kode_pos_karyawan_keluar);
            $("#nomor_absen_karyawan_keluar").val($nomor_absen_karyawan_keluar);
            $("#golongan_darah_karyawan_keluar").val($golongan_darah_karyawan_keluar);
            $("#nomor_kartu_keluarga_karyawan_keluar").val($nomor_kartu_keluarga_karyawan_keluar);
            $("#status_nikah_karyawan_keluar").val($status_nikah_karyawan_keluar);
            $("#nama_ayah_karyawan_keluar").val($nama_ayah_karyawan_keluar);
            $("#nama_ibu_karyawan_keluar").val($nama_ibu_karyawan_keluar);
            $("#tanggal_masuk_karyawan_keluar").val($tanggal_masuk_karyawan_keluar);
            $("#tanggal_keluar_karyawan_keluar").val($tanggal_keluar_karyawan_keluar);
            $("#status_kerja_karyawan_keluar").val($status_kerja_karyawan_keluar);
            $("#keterangan_keluar").val($keterangan_keluar);
        }
    </script>
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Karyawan</li>
                    <li class="breadcrumb-item active">Data Karyawan Keluar</li>
                </ol>

                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                    <a href="{{ route('employee_out.create') }}" class="btn btn-primary shadow-sm mb-3">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Karyawan Keluar
                    </a>
                    <a href="{{ route('employee_out.export_excel') }}" target="_blank"
                        class="btn btn-success shadow-sm mb-3">
                        <i class="fas fa-download fa-sm text-white-50"></i> Download Excell Karyawan Keluar
                    </a>
                @elseif (Auth::user()->roles == 'ACCOUNTING' ||
                    Auth::user()->roles == 'MANAGER HRD' ||
                    Auth::user()->roles == 'MANAGER ACCOUNTING')
                    <a href="{{ route('employee_out.export_excel') }}" target="_blank"
                        class="btn btn-success shadow-sm mb-3">
                        <i class="fas fa-download fa-sm text-white-50"></i> Download Excell Karyawan Keluar
                    </a>
                @endif


                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Karyawan Keluar
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK Karyawan</th>
                                        <th>Nama Karyawan</th>
                                        <th>Penempatan</th>
                                        <th>Akhir Kerja</th>
                                        <th>Status Kerja</th>
                                        <th>JKN</th>
                                        <th>JHT</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->employees_id }}</td>
                                            <td>{{ $item->nama_karyawan_keluar }}</td>
                                            <td>{{ $item->divisions->penempatan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar_karyawan_keluar)->isoformat('DD-MM-Y') }}
                                            </td>
                                            <td>{{ $item->status_kerja_karyawan_keluar }}</td>
                                            <td>{{ $item->nomor_bpjskesehatan_karyawan_keluar }}</td>
                                            <td>{{ $item->nomor_bpjsketenagakerjaan_karyawan_keluar }}</td>
                                            <td align=center>
                                                <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#ViewKaryawanKeluar"
                                                    onclick="viewdata('{{ $item->employees_id }}','{{ $item->companies->nama_perusahaan }}','{{ $item->golongans->golongan }}','{{ $item->areas->area }}','{{ $item->divisions->penempatan }}','{{ $item->positions->jabatan }}','{{ $item->nama_karyawan_keluar }}','{{ $item->nomor_npwp_karyawan_keluar }}','{{ $item->email_karyawan_keluar }}','{{ $item->nomor_handphone_karyawan_keluar }}','{{ $item->tempat_lahir_karyawan_keluar }}','{{ \Carbon\Carbon::parse($item->tanggal_lahir_karyawan_keluar)->isoformat('D MMMM Y') }}','{{ $item->nomor_jht_karyawan_keluar }}','{{ $item->nomor_jp_karyawan_keluar }}','{{ $item->nomor_jkn_karyawan_keluar }}','{{ $item->nomor_rekening_karyawan_keluar }}','{{ $item->pendidikan_terakhir_karyawan_keluar }}','{{ $item->jenis_kelamin_karyawan_keluar }}','{{ $item->agama_karyawan_keluar }}','{{ $item->alamat_karyawan_keluar }}','{{ $item->rt_karyawan_keluar }}','{{ $item->rw_karyawan_keluar }}','{{ $item->kelurahan_karyawan_keluar }}','{{ $item->kecamatan_karyawan_keluar }}','{{ $item->kota_karyawan_keluar }}','{{ $item->provinsi_karyawan_keluar }}','{{ $item->kode_pos_karyawan_keluar }}','{{ $item->nomor_absen_karyawan_keluar }}','{{ $item->golongan_darah_karyawan_keluar }}','{{ $item->nomor_kartu_keluarga_karyawan_keluar }}','{{ $item->status_nikah_karyawan_keluar }}','{{ $item->nama_ayah_karyawan_keluar }}','{{ $item->nama_ibu_karyawan_keluar }}','{{ \Carbon\Carbon::parse($item->tanggal_masuk_karyawan_keluar)->isoformat('D MMMM Y') }}','{{ \Carbon\Carbon::parse($item->tanggal_keluar_karyawan_keluar)->isoformat('D MMMM Y') }}','{{ $item->status_kerja_karyawan_keluar }}','{{ $item->keterangan_keluar }}')">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                    <a href="{{ route('employee_out.edit', $item->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('employee_out.destroy', $item->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('employee_out.show', $item->id) }}"
                                                        class="btn btn-info btn-sm" target="_blank">
                                                        <i class="fa fa-print"></i>
                                                    </a>
                                                @elseif(Auth::user()->roles == 'MANAGER HRD' ||
                                                    Auth::user()->roles == 'MANAGER ACCOUNTING' ||
                                                    Auth::user()->roles == 'ACCOUNTING')
                                                    <a href="{{ route('employee_out.show', $item->id) }}"
                                                        class="btn btn-info btn-sm" target="_blank">
                                                        <i class="fa fa-print"></i>
                                                    </a>
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
        {{-- Modal --}}
        <div class="modal fade" id="ViewKaryawanKeluar" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Karyawan Keluar </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">NIK</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="employees_id">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="nama_karyawan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Perusahaan</label>
                            <div class="col-sm-9">
                                <input type="text" readonly class="form-control-plaintext" id="companies_id">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Golongan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="golongans_id">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Area</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="areas_id">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Penempatan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="divisions_id">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Jabatan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="positions_id">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Tgl Masuk</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="tanggal_masuk_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Tgl Keluar</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="tanggal_keluar_karyawan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Status Kerja</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="status_kerja_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Ket Keluar</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="keterangan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">NPWP</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="nomor_npwp_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">No Handphone</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="nomor_handphone_karyawan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Tempat Lahir</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="tempat_lahir_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="tanggal_lahir_karyawan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="email_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">No Rekening</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="nomor_rekening_karyawan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">BPJSTK</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="nomor_bpjsketenagakerjaan_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">BPJS Kesehatan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="nomor_bpjskesehatan_karyawan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="pendidikan_terakhir_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="jenis_kelamin_karyawan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Agama</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="agama_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="alamat_karyawan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">RT</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="rt_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">RW</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="rw_karyawan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Kelurahan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="kelurahan_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Kecamatan</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="kecamatan_karyawan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Kota</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext" id="kota_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Provinsi</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="provinsi_karyawan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">No Absen</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="nomor_absen_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Gol Darah</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="golongan_darah_karyawan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">No KK</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="nomor_kartu_keluarga_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Status Nikah</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="status_nikah_karyawan_keluar">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Nama Ayah</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="nama_ayah_karyawan_keluar">
                            </div>
                            <label for="staticEmail" class="col-sm-3 col-form-label">Nama Ibu</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="nama_ibu_karyawan_keluar">
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
