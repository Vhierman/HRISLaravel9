@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>

            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Change Password</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Change Your Password
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
                            <form action="{{ route('dashboard.hasil_ubah_password') }}" method="post"
                                enctype="multipart/form-data">

                                @csrf
                                <div class="form-group">
                                    <div class="form-group mt-1">
                                        <label for="title" class="form-label">New Password</label>
                                        <input type="text" class="form-control" name="password"
                                            placeholder="New Password" value="{{ old('password') }}">
                                    </div>
                                    <div class="form-group mt-1">
                                        <label for="title" class="form-label">Confirm New Password</label>
                                        <input type="text" class="form-control" name="password_confirmation"
                                            placeholder="New Password" value="{{ old('password_confirmation') }}">
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Ubah
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
