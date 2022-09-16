{{-- Side Bar Menu --}}
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                {{-- Dashboard --}}
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                {{-- Dashboard --}}

                {{-- Master --}}
                <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseMaster"
                    aria-expanded="false" aria-controls="collapseMaster">
                    <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                    Master
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseMaster" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">User</a>
                        <a class="nav-link" href="{{ route('minimal-salaries.index') }}">Minimal
                            Upah</a>
                        <a class="nav-link" href="{{ route('maksimal-bpjskesehatan.index') }}">Maksimal Upah
                            BPJS Kesehatan</a>
                        <a class="nav-link" href="{{ route('maksimal-bpjsketenagakerjaan.index') }}">Maksimal
                            Upah BPJS Ketenagakerjaan</a>
                        <a class="nav-link" href="{{ route('company.index') }}">Perusahaan</a>
                        <a class="nav-link" href="{{ route('golongan.index') }}">Golongan</a>
                        <a class="nav-link" href="{{ route('area.index') }}">Area</a>
                        <a class="nav-link" href="{{ route('division.index') }}">Penempatan</a>
                        <a class="nav-link" href="{{ route('position.index') }}">Jabatan</a>
                        <a class="nav-link" href="{{ route('working-hour.index') }}">Jam Kerja</a>
                        <a class="nav-link" href="{{ route('school.index') }}">Sekolah</a>
                    </nav>
                </div>
                {{-- Master --}}

                {{-- Karyawan --}}
                <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseEmployee"
                    aria-expanded="false" aria-controls="collapseEmployee">
                    <div class="sb-nav-link-icon"><i class="fas fa-snowboarding"></i></div>
                    Karyawan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseEmployee" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('employee.index') }}">Data Karyawan Aktif</a>
                    </nav>
                </div>
                <div class="collapse" id="collapseEmployee" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('employee_out.index') }}">Data Karyawan
                            Keluar</a>
                    </nav>
                </div>
                {{-- Karyawan --}}

                {{-- Absensi --}}
                <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseAbsensi"
                    aria-expanded="false" aria-controls="collapseAbsensi">
                    <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                    Absensi
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseAbsensi" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">Data Absensi</a>
                    </nav>
                </div>
                {{-- Absensi --}}

                {{-- Siswa Prakerin --}}
                <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseStudents"
                    aria-expanded="false" aria-controls="collapseStudents">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
                    Siswa
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseStudents" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('student.index') }}">Data Siswa Prakerin</a>
                    </nav>
                </div>
                {{-- Siswa Prakerin --}}

                {{-- Inventaris --}}
                <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseHistory"
                    aria-expanded="false" aria-controls="collapseHistory">
                    <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                    Inventaris
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseHistory" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('inventory_motorcycle.index') }}">Motor</a>
                    </nav>
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('inventory_car.index') }}">Mobil</a>
                    </nav>
                </div>
                {{-- Inventaris --}}

                {{-- Training --}}
                <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTraining"
                    aria-expanded="false" aria-controls="collapseTraining">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                    Training
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseTraining" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('history_training_internal.index') }}">Internal</a>
                    </nav>
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('history_training_eksternal.index') }}">Eksternal</a>
                    </nav>
                </div>
                {{-- Training --}}

                {{-- Surat --}}
                <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseSurat"
                    aria-expanded="false" aria-controls="collapseSurat">
                    <div class="sb-nav-link-icon"><i class="fas fa-envelope-open-text"></i></i></div>
                    Surat
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseSurat" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('cetak.penilaian_karyawan') }}">Penilaian
                            Karyawan</a>
                    </nav>
                </div>
                <div class="collapse" id="collapseSurat" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('cetak.pkwt_kontrak') }}">PKWT Kontrak</a>
                    </nav>
                </div>
                <div class="collapse" id="collapseSurat" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('cetak.pkwt_harian') }}">PKWT Harian</a>
                    </nav>
                </div>
                {{-- Surat --}}

                {{-- Proses --}}
                <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseProses"
                    aria-expanded="false" aria-controls="collapseProses">
                    <div class="sb-nav-link-icon"><i class="fas fa-paperclip"></i></div>
                    Proses
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseProses" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('proses.proses_pkwt_kontrak') }}">PKWT
                            Kontrak</a>
                    </nav>
                </div>
                <div class="collapse" id="collapseProses" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('proses.proses_pkwt_harian') }}">PKWT
                            Harian</a>
                    </nav>
                </div>
                <div class="collapse" id="collapseProses" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('overtime.index') }}">Overtimes</a>
                    </nav>
                </div>
                <div class="collapse" id="collapseProses" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('proses.proses_rekon_salary') }}">Salary</a>
                    </nav>
                </div>
                {{-- Proses --}}

                {{-- Laporan --}}
                <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseLaporan"
                    aria-expanded="false" aria-controls="collapseLaporan">
                    <div class="sb-nav-link-icon"><i class="fas fa-pencil-alt"></i></div>
                    Laporan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">Rekap Gaji</a>
                    </nav>
                </div>

                <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">Absensi
                            Karyawan</a>
                    </nav>
                </div>

                <div class="collapse" id="collapseLaporan" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                            aria-controls="pagesCollapseAuth">
                            Absensi Department
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="#">PDC
                                    Daihatsu</a>
                                <a class="nav-link" href="#">Produksi</a>
                                <a class="nav-link" href="#">PPC</a>
                                <a class="nav-link" href="#">ACC,IC,IT</a>
                                <a class="nav-link" href="#">HRD-GA,DC</a>
                                <a class="nav-link" href="#">Marketing</a>
                                <a class="nav-link" href="#">Purchasing</a>
                                <a class="nav-link" href="#">Engineering</a>
                                <a class="nav-link" href="#">Quality</a>
                            </nav>
                        </div>
                    </nav>
                </div>

                <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">Karyawan
                            Masuk</a>
                    </nav>
                </div>

                <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">Karyawan
                            Keluar</a>
                    </nav>
                </div>

                <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#" target="_blank">Karyawan
                            Kontrak</a>
                    </nav>
                </div>

                <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#" target="_blank">Karyawan
                            Tetap</a>
                    </nav>
                </div>

                <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#" target="_blank">Karyawan
                            Harian</a>
                    </nav>
                </div>

                <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#" target="_blank">Karyawan
                            Outsourcing</a>
                    </nav>
                </div>

                <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#" target="_blank">Inventaris Laptop</a>
                    </nav>
                </div>

                <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#" target="_blank">Inventaris Motor</a>
                    </nav>
                </div>

                <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#" target="_blank">Inventaris Mobil</a>
                    </nav>
                </div>
                {{-- Laporan --}}

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Copyright:</div>
            <i class="fas fa-code"></i></i> OLAY
            <i class="fas fa-code"></i>
        </div>
    </nav>
</div>
{{-- End Side Bar Menu --}}
