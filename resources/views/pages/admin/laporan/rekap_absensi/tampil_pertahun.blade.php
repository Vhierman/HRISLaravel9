@extends('layouts.admin')

@section('content')
    {{-- Content Dan Footer --}}
    <div id="layoutSidenav_content">
        {{-- Content --}}
        <main>
            <div class="container-fluid mt-4">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">Rekap Absensi</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Rekap Absensi Periode Tahun {{ $tahun }}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>Mar</th>
                                        <th>Apr</th>
                                        <th>Mei</th>
                                        <th>Jun</th>
                                        <th>Jul</th>
                                        <th>Aug</th>
                                        <th>Sep</th>
                                        <th>Okt</th>
                                        <th>Nov</th>
                                        <th>Des</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp

                                    <tr>
                                        <td>{{ 'Cuti' }}</td>
                                        <td>{{ $totalcutijanuari }}</td>
                                        <td>{{ $totalcutifebruari }}</td>
                                        <td>{{ $totalcutimaret }}</td>
                                        <td>{{ $totalcutiapril }}</td>
                                        <td>{{ $totalcutimei }}</td>
                                        <td>{{ $totalcutijuni }}</td>
                                        <td>{{ $totalcutijuli }}</td>
                                        <td>{{ $totalcutiagustus }}</td>
                                        <td>{{ $totalcutiseptember }}</td>
                                        <td>{{ $totalcutioktober }}</td>
                                        <td>{{ $totalcutinovember }}</td>
                                        <td>{{ $totalcutidesember }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'Sakit' }}</td>
                                        <td>{{ $sakitjanuari }}</td>
                                        <td>{{ $sakitfebruari }}</td>
                                        <td>{{ $sakitmaret }}</td>
                                        <td>{{ $sakitapril }}</td>
                                        <td>{{ $sakitmei }}</td>
                                        <td>{{ $sakitjuni }}</td>
                                        <td>{{ $sakitjuli }}</td>
                                        <td>{{ $sakitagustus }}</td>
                                        <td>{{ $sakitseptember }}</td>
                                        <td>{{ $sakitoktober }}</td>
                                        <td>{{ $sakitnovember }}</td>
                                        <td>{{ $sakitdesember }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'Ijin' }}</td>
                                        <td>{{ $ijinjanuari }}</td>
                                        <td>{{ $ijinfebruari }}</td>
                                        <td>{{ $ijinmaret }}</td>
                                        <td>{{ $ijinapril }}</td>
                                        <td>{{ $ijinmei }}</td>
                                        <td>{{ $ijinjuni }}</td>
                                        <td>{{ $ijinjuli }}</td>
                                        <td>{{ $ijinagustus }}</td>
                                        <td>{{ $ijinseptember }}</td>
                                        <td>{{ $ijinoktober }}</td>
                                        <td>{{ $ijinnovember }}</td>
                                        <td>{{ $ijindesember }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'Alpa' }}</td>
                                        <td>{{ $alpajanuari }}</td>
                                        <td>{{ $alpafebruari }}</td>
                                        <td>{{ $alpamaret }}</td>
                                        <td>{{ $alpaapril }}</td>
                                        <td>{{ $alpamei }}</td>
                                        <td>{{ $alpajuni }}</td>
                                        <td>{{ $alpajuli }}</td>
                                        <td>{{ $alpaagustus }}</td>
                                        <td>{{ $alpaseptember }}</td>
                                        <td>{{ $alpaoktober }}</td>
                                        <td>{{ $alpanovember }}</td>
                                        <td>{{ $alpadesember }}</td>
                                    </tr>



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        {{-- End Content --}}
    </div>
    {{-- End Content Dan Footer --}}
@endsection
