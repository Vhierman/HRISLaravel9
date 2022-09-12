@extends('layouts.admin')

@section('content')
    <script type="text/javascript">
        function viewdata($nama_karyawan, $merk_motor, $type_motor, $nomor_polisi, $warna_motor, $nomor_rangka_motor,
            $nomor_mesin_motor, $tanggal_akhir_pajak_motor, $tanggal_akhir_plat_motor, $tanggal_penyerahan_motor,
            $foto_stnk_motor, $foto_motor) {
            $("#nama_karyawan").val($nama_karyawan);
            $("#merk_motor").val($merk_motor);
            $("#type_motor").val($type_motor);
            $("#nomor_polisi").val($nomor_polisi);
            $("#warna_motor").val($warna_motor);
            $("#nomor_rangka_motor").val($nomor_rangka_motor);
            $("#nomor_mesin_motor").val($nomor_mesin_motor);
            $("#tanggal_akhir_pajak_motor").val($tanggal_akhir_pajak_motor);
            $("#tanggal_akhir_plat_motor").val($tanggal_akhir_plat_motor);
            $("#tanggal_penyerahan_motor").val($tanggal_penyerahan_motor);
            $('#foto_stnk_motor').attr("href", "{{ Storage::url('') }}" + $foto_stnk_motor);
            $('#foto_motor').attr("src", "{{ Storage::url('') }}" + $foto_motor);
        }
    </script>
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Inventaris</li>
                    <li class="breadcrumb-item active">Motor</li>
                </ol>

                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                    <a href="{{ route('inventory_motorcycle.create') }}" class="btn btn-primary shadow-sm mb-3">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Inventaris Motor
                    </a>
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Inventaris Motor
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Merk/Type</th>
                                        <th>No Polisi</th>
                                        <th>Tanggal Pajak</th>
                                        <th>Tanggal Plat</th>
                                        <th>Tanggal Penyerahan</th>
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
                                            <td>{{ $item->employees->nama_karyawan }}</td>
                                            <td>{{ $item->merk_motor }}.'/'.{{ $item->type_motor }}</td>
                                            <td>{{ $item->nomor_polisi }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_akhir_pajak_motor)->isoformat('D MMMM Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_akhir_plat_motor)->isoformat('D MMMM Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_penyerahan_motor)->isoformat('D MMMM Y') }}
                                            </td>
                                            <td>
                                                <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#ViewInventoryMotor"
                                                    onclick="viewdata('{{ $item->employees->nama_karyawan }}','{{ $item->merk_motor }}','{{ $item->type_motor }}','{{ $item->nomor_polisi }}','{{ $item->warna_motor }}','{{ $item->nomor_rangka_motor }}','{{ $item->nomor_mesin_motor }}','{{ \Carbon\Carbon::parse($item->tanggal_akhir_pajak_motor)->isoformat('D MMMM Y') }}','{{ \Carbon\Carbon::parse($item->tanggal_akhir_plat_motor)->isoformat('D MMMM Y') }}','{{ \Carbon\Carbon::parse($item->tanggal_penyerahan_motor)->isoformat('D MMMM Y') }}','{{ $item->foto_stnk_motor }}','{{ $item->foto_motor }}')">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                    <a href="{{ route('inventory_motorcycle.edit', $item->id) }}"
                                                        class="btn btn-success">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('inventory_motorcycle.destroy', $item->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger ">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('inventory_motorcycle.show', $item->id) }}"
                                                        class="btn btn-info" target="_blank">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                @elseif (Auth::user()->roles == 'MANAGER HRD' ||
                                                    Auth::user()->roles == 'MANAGER ACCOUNTING' ||
                                                    Auth::user()->roles == 'ACCOUNTING')
                                                    <a href="{{ route('inventory_motorcycle.show', $item->id) }}"
                                                        class="btn btn-info" target="_blank">
                                                        <i class="fa fa-download"></i>
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
        <div class="modal fade" id="ViewInventoryMotor" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Inventaris Motor </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="text-center">
                                <img id="foto_motor" class="img-fluid" width="40%">
                            </div>
                            <a id="foto_stnk_motor" target="_blank" class="btn btn-success">STNK</a>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Nama</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" id="nama_karyawan">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Merk</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" id="merk_motor">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Type</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" id="type_motor">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Nomor Polisi</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" id="nomor_polisi">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Warna</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" id="warna_motor">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Nomor Rangka</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" id="nomor_rangka_motor">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Nomor Mesin</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" id="nomor_mesin_motor">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Tgl Pajak</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="tanggal_akhir_pajak_motor">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Tgl Plat</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="tanggal_akhir_plat_motor">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Tgl Penyerahan</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="tanggal_penyerahan_motor">
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
