@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">

        <main>
            <div class="container-fluid px-4">
                <div class="row mt-4">

                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-dark text-white mb-4">
                            <div class="card-body"><i class="fas fa-city"></i> Jumlah Karyawan ALL</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <div class="small text-white"><i class="fas fa-users"></i> #
                                    Man
                                    Power
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-dark text-white mb-4">
                            <div class="card-body"><i class="fas fa-city"></i> Jumlah Karyawan PK66</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <div class="small text-white"><i class="fas fa-users"></i> #
                                    Man
                                    Power
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-dark text-white mb-4">
                            <div class="card-body"><i class="fas fa-city"></i> Jumlah Karyawan BSD</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <div class="small text-white"><i class="fas fa-users"></i> #
                                    Man
                                    Power
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-dark text-white mb-4">
                            <div class="card-body"><i class="fas fa-city"></i> Jumlah Karyawan PDC</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <div class="small text-white"><i class="fas fa-users"></i> #
                                    Man
                                    Power
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
@endsection
