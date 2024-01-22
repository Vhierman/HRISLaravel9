@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Kaizen</li>
                    <li class="breadcrumb-item active">SS Eksternal</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Edit Data SS Eksternal
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
                            <form action="{{ route('kaizen.update_ss_eksternal') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="edit_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">
                                    <input type="hidden" class="form-control" name="id" placeholder="Name"
                                        value="{{ $itemkaizen->id }}">

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Nama Karyawan</label>
                                        <select class="selectpicker" name="employees_id" data-width="100%"
                                            data-live-search="true" required>
                                            <option value="{{ $itemkaizen->employees_id }}">Pilih Nama Karyawan
                                            </option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->nik_karyawan }}"
                                                    @if ($itemkaizen->employees_id == $item->nik_karyawan) {{ 'selected="selected"' }} @endif>
                                                    {{ $item->nama_karyawan . ' / ' . $item->divisions->penempatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tema SS Eksternal</label>
                                        <input type="text" class="form-control" name="tema_ss_eksternal"
                                            placeholder="Tema SS Eksternal" maxlength="50"
                                            value="{{ $itemkaizen->tema_ss_eksternal }}">
                                    </div>


                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal SS</label>
                                        <input type="date" class="form-control" name="tanggal_ss_eksternal"
                                            placeholder="DD-MM-YYYY" value="{{ $itemkaizen->tanggal_ss_eksternal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Instansi</label>
                                        <input type="text" class="form-control" name="instansi" placeholder="Instansi"
                                            maxlength="50" value="{{ $itemkaizen->instansi }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Simpan
                                        </button>
                                        <a href="{{ route('kaizen.ss_eksternal') }}" class="btn btn-danger btn-block">
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
