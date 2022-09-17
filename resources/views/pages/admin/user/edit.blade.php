@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item active">User {{ $item->name }}</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Edit Data Users
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
                            <form action="{{ route('user.update', $item->id) }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group">

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email"
                                            placeholder="Masukan Email" value="{{ $item->email }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">Name</label>
                                        <input type="text" maxlength="40" onkeyup="huruf(this);" class="form-control"
                                            name="name" placeholder="Masukan Name" value="{{ $item->name }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="title" class="form-label">NIK</label>
                                        <input type="text" maxlength="16" onkeyup="angka(this);" class="form-control"
                                            name="nik" placeholder="Masukan NIK KTP" value="{{ $item->nik }}">
                                    </div>

                                    <div class="form-group  mt-2">
                                        <label for="roles">Roles</label>
                                        <select name="roles" class="form-select">
                                            <option value="">Pilih Roles</option>
                                            <option value="USER"
                                                @if ($item->roles == 'USER') {{ 'selected="selected"' }} @endif>
                                                USER</option>
                                            <option value="ADMIN"
                                                @if ($item->roles == 'ADMIN') {{ 'selected="selected"' }} @endif>
                                                ADMIN</option>
                                            <option value="HRD"
                                                @if ($item->roles == 'HRD') {{ 'selected="selected"' }} @endif>
                                                HRD</option>
                                            <option value="ACCOUNTING"
                                                @if ($item->roles == 'ACCOUNTING') {{ 'selected="selected"' }} @endif>
                                                ACCOUNTING</option>
                                            <option value="LEADER"
                                                @if ($item->roles == 'LEADER') {{ 'selected="selected"' }} @endif>
                                                LEADER</option>
                                            <option value="MANAGER HRD"
                                                @if ($item->roles == 'MANAGER HRD') {{ 'selected="selected"' }} @endif>
                                                MANAGER HRD
                                            </option>
                                            <option value="MANAGER ACCOUNTING"
                                                @if ($item->roles == 'MANAGER ACCOUNTING') {{ 'selected="selected"' }} @endif>
                                                MANAGER ACCOUNTING
                                            </option>
                                            <option value="KARYAWAN"
                                                @if ($item->roles == 'KARYAWAN') {{ 'selected="selected"' }} @endif>
                                                KARYAWAN
                                            </option>
                                        </select>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Update
                                        </button>
                                        <a href="{{ route('user.index') }}" class="btn btn-danger btn-block">
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
