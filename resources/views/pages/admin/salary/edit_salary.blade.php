@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Process</li>
                    <li class="breadcrumb-item active">Salary {{ $item->nama_karyawan }}</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Edit Data Salary
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
                        <div class="card-body">
                            <form action="{{ route('proses.hasil_edit_salary', $item->employees_id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="edit_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">NIK Karyawan</label>
                                        <input type="text" class="form-control" name="nik_karyawan" readonly
                                            placeholder="Masukan NIK Karyawan" value="{{ $item->nik_karyawan }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" name="nama_karyawan" readonly
                                            placeholder="Masukan Nama Karyawan" value="{{ $item->nama_karyawan }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" readonly
                                            placeholder="Masukan Jabatan" value="{{ $item->jabatan }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Penempatan</label>
                                        <input type="text" class="form-control" name="penempatan" readonly
                                            placeholder="Masukan Penempatan" value="{{ $item->penempatan }}">
                                    </div>


                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Gaji Pokok</label>
                                        <input type="text" class="form-control" name="gaji_pokok" onkeyup="angka(this);"
                                            placeholder="Masukan Gaji Pokok" value="{{ $item->gaji_pokok }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Uang Makan</label>
                                        <input type="text" class="form-control" name="uang_makan" onkeyup="angka(this);"
                                            placeholder="Masukan Uang Makan" value="{{ $item->uang_makan }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Uang Transport</label>
                                        <input type="text" class="form-control" name="uang_transport"
                                            onkeyup="angka(this);" placeholder="Masukan Uang Transport"
                                            value="{{ $item->uang_transport }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tunjangan Tugas</label>
                                        <input type="text" class="form-control" name="tunjangan_tugas"
                                            onkeyup="angka(this);" placeholder="Masukan Tunjangan Tugas"
                                            value="{{ $item->tunjangan_tugas }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tunjangan Pulsa</label>
                                        <input type="text" class="form-control" name="tunjangan_pulsa"
                                            onkeyup="angka(this);" placeholder="Masukan Tunjangan Pulsa"
                                            value="{{ $item->tunjangan_pulsa }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tunjangan Jabatan</label>
                                        <input type="text" class="form-control" name="tunjangan_jabatan"
                                            onkeyup="angka(this);" placeholder="Masukan Tunjangan Jabatan"
                                            value="{{ $item->tunjangan_jabatan }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Kepesertaan BPJS Ketenagakerjaan &
                                            Kesehatan</label>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input class="form-check-input" name="jht" type="hidden"
                                            id="inlineCheckbox1" value="0">
                                        <input class="form-check-input" name="jht" type="checkbox"
                                            id="inlineCheckbox1" value="1"
                                            @if ($item->potongan_jht_perusahaan != 0) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox1">JHT</label>

                                        <input class="form-check-input" name="jp" type="hidden"
                                            id="inlineCheckbox1" value="0">
                                        <input class="form-check-input" name="jp" type="checkbox"
                                            id="inlineCheckbox2" value="1"
                                            @if ($item->potongan_jp_perusahaan != 0) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox2">JP</label>

                                        <input class="form-check-input" name="jkk" type="hidden"
                                            id="inlineCheckbox1" value="0">
                                        <input class="form-check-input" name="jkk" type="checkbox"
                                            id="inlineCheckbox3" value="1"
                                            @if ($item->potongan_jkk_perusahaan != 0) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox3">JKK</label>

                                        <input class="form-check-input" name="jkm" type="hidden"
                                            id="inlineCheckbox1" value="0">
                                        <input class="form-check-input" name="jkm" type="checkbox"
                                            id="inlineCheckbox4" value="1"
                                            @if ($item->potongan_jkm_perusahaan != 0) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox4">JKM</label>

                                        <input class="form-check-input" name="jkn" type="hidden"
                                            id="inlineCheckbox1" value="0">
                                        <input class="form-check-input" name="jkn" type="checkbox"
                                            id="inlineCheckbox5" value="1"
                                            @if ($item->potongan_bpjsks_perusahaan != 0) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox5">JKN</label>
                                    </div>


                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Update
                                        </button>
                                        <a href="{{ route('dashboard') }}" class="btn btn-danger btn-block">
                                            Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
@endsection
