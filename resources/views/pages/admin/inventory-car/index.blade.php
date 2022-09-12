@extends('layouts.admin')

@section('content')
    <script type="text/javascript">
        function viewdata($nama_karyawan, $merk_mobil, $type_mobil, $nomor_polisi, $warna_mobil, $nomor_rangka_mobil,
            $nomor_mesin_mobil, $tanggal_akhir_pajak_mobil, $tanggal_akhir_plat_mobil, $tanggal_penyerahan_mobil,
            $foto_stnk_mobil, $foto_mobil) {
            $("#nama_karyawan").val($nama_karyawan);
            $("#merk_mobil").val($merk_mobil);
            $("#type_mobil").val($type_mobil);
            $("#nomor_polisi").val($nomor_polisi);
            $("#warna_mobil").val($warna_mobil);
            $("#nomor_rangka_mobil").val($nomor_rangka_mobil);
            $("#nomor_mesin_mobil").val($nomor_mesin_mobil);
            $("#tanggal_akhir_pajak_mobil").val($tanggal_akhir_pajak_mobil);
            $("#tanggal_akhir_plat_mobil").val($tanggal_akhir_plat_mobil);
            $("#tanggal_penyerahan_mobil").val($tanggal_penyerahan_mobil);
            $('#foto_stnk_mobil').attr("href", "{{ Storage::url('') }}" + $foto_stnk_mobil);
            $('#foto_mobil').attr("src", "{{ Storage::url('') }}" + $foto_mobil);
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
                    <li class="breadcrumb-item active">Mobil</li>
                </ol>

                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                    <a href="{{ route('inventory_car.create') }}" class="btn btn-primary shadow-sm mb-3">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Inventaris Mobil
                    </a>
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Data Inventaris Mobil
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
                                            <td>{{ $item->merk_mobil }}.'/'.{{ $item->type_mobil }}</td>
                                            <td>{{ $item->nomor_polisi }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_akhir_pajak_mobil)->isoformat('D MMMM Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_akhir_plat_mobil)->isoformat('D MMMM Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_penyerahan_mobil)->isoformat('D MMMM Y') }}
                                            </td>
                                            <td>
                                                <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#ViewInventoryMobil"
                                                    onclick="viewdata('{{ $item->employees->nama_karyawan }}','{{ $item->merk_mobil }}','{{ $item->type_mobil }}','{{ $item->nomor_polisi }}','{{ $item->warna_mobil }}','{{ $item->nomor_rangka_mobil }}','{{ $item->nomor_mesin_mobil }}','{{ \Carbon\Carbon::parse($item->tanggal_akhir_pajak_mobil)->isoformat('D MMMM Y') }}','{{ \Carbon\Carbon::parse($item->tanggal_akhir_plat_mobil)->isoformat('D MMMM Y') }}','{{ \Carbon\Carbon::parse($item->tanggal_penyerahan_mobil)->isoformat('D MMMM Y') }}','{{ $item->foto_stnk_mobil }}','{{ $item->foto_mobil }}')">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                                                    <a href="{{ route('inventory_car.edit', $item->id) }}"
                                                        class="btn btn-success">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('inventory_car.destroy', $item->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger ">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('inventory_car.show', $item->id) }}"
                                                        class="btn btn-info" target="_blank">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                @elseif (Auth::user()->roles == 'MANAGER HRD' ||
                                                    Auth::user()->roles == 'MANAGER ACCOUNTING' ||
                                                    Auth::user()->roles == 'ACCOUNTING')
                                                    <a href="{{ route('inventory_car.show', $item->id) }}"
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
        <div class="modal fade" id="ViewInventoryMobil" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Inventaris Mobil </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="text-center">
                                <img id="foto_mobil" class="img-fluid" width="40%">
                            </div>
                            <a id="foto_stnk_mobil" target="_blank" class="btn btn-success">STNK</a>
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
                                <input type="text" readonly class="form-control-plaintext" id="merk_mobil">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Type</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" id="type_mobil">
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
                                <input type="text" readonly class="form-control-plaintext" id="warna_mobil">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Nomor Rangka</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" id="nomor_rangka_mobil">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Nomor Mesin</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext" id="nomor_mesin_mobil">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Tgl Pajak</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="tanggal_akhir_pajak_mobil">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Tgl Plat</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="tanggal_akhir_plat_mobil">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><b>Tgl Penyerahan</b></label>
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext"
                                    id="tanggal_penyerahan_mobil">
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
