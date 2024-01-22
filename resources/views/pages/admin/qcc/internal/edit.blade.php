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
                    <li class="breadcrumb-item active">QCC Internal</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Edit Data QCC Internal
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
                            <form action="{{ route('kaizen.update', $itemkaizen->id) }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="edit_oleh" placeholder="Name"
                                        value="{{ Auth::user()->name }}">

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
                                        <label for="title" class="form-label">Nama Group QCC Internal</label>
                                        <input type="text" class="form-control" name="nama_group_qcc_internal"
                                            placeholder="Nama Group QCC Internal" maxlength="50"
                                            value="{{ $itemkaizen->nama_group_qcc_internal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tema QCC Internal</label>
                                        <input type="text" class="form-control" name="tema_qcc_internal"
                                            placeholder="Tema QCC Internal" maxlength="50"
                                            value="{{ $itemkaizen->tema_qcc_internal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Circle Leader</label>
                                        <input type="text" class="form-control" name="circle_leader_qcc_internal"
                                            placeholder="Circle Leader" maxlength="35"
                                            value="{{ $itemkaizen->circle_leader_qcc_internal }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Tanggal Konvensi</label>
                                        <input type="date" class="form-control" name="tanggal_konvensi_qcc_internal"
                                            placeholder="DD-MM-YYYY"
                                            value="{{ $itemkaizen->tanggal_konvensi_qcc_internal }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Simpan
                                        </button>
                                        <a href="{{ route('kaizen.index') }}" class="btn btn-danger btn-block">
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
