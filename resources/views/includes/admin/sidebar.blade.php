{{-- Side Bar Menu --}}
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                @if (Auth::user()->roles == 'LEADER' ||
                        Auth::user()->roles == 'MANAGER HRD' ||
                        Auth::user()->roles == 'ACCOUNTING' ||
                        Auth::user()->roles == 'MANAGER ACCOUNTING')
                    {{-- Dashboard --}}
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    {{-- Dashboard --}}
                @endif

                {{-- Halaman Karyawan --}}
                @if (Auth::user()->roles == 'KARYAWAN')
                    <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseStudents"
                        aria-expanded="false" aria-controls="collapseStudents">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
                        Halaman Karyawan
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseStudents" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('dashboard.form_slip_lembur_karyawan') }}">Lemburan</a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseStudents" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('dashboard.form_absensi_karyawan') }}">Absensi</a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseStudents" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('dashboard.training_internal') }}">Training Internal</a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseStudents" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('dashboard.training_eksternal') }}">Training
                                Eksternal</a>
                        </nav>
                    </div>
                    <a class="nav-link" href="https://wa.me/628152551696?text=Hallo BOR Saya Ingin Bertanya..?"
                        target="_blank">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Kritik & Saran
                    </a>
                @endif
                {{-- Halaman Karyawan --}}

                {{-- Master --}}
                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                    <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseDashboard"
                        aria-expanded="false" aria-controls="collapseDashboard">
                        <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                        Dashboard
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseDashboard" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard Karyawan</a>
                            {{-- <a class="nav-link" href="{{ route('dashboard-harian.index') }}">Dashboard Harian</a> --}}
                        </nav>
                    </div>
                    <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseMaster"
                        aria-expanded="false" aria-controls="collapseMaster">
                        <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                        Master
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseMaster" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('user.index') }}">User</a>
                            <a class="nav-link" href="{{ route('minimal-salaries.index') }}">Minimal
                                Upah Perbulan</a>
                            <a class="nav-link" href="{{ route('maksimal-bpjskesehatan.index') }}">Maksimal Upah
                                BPJS Kesehatan</a>
                            <a class="nav-link" href="{{ route('maksimal-bpjsketenagakerjaan.index') }}">Maksimal
                                Upah BPJS Ketenagakerjaan</a>
                            <a class="nav-link" href="{{ route('upah_lembur_perjam.index') }}">Upah Lembur
                                Perjam</a>
                            <a class="nav-link" href="{{ route('company.index') }}">Perusahaan</a>
                            <a class="nav-link" href="{{ route('golongan.index') }}">Golongan</a>
                            <a class="nav-link" href="{{ route('area.index') }}">Area</a>
                            <a class="nav-link" href="{{ route('division.index') }}">Penempatan</a>
                            <a class="nav-link" href="{{ route('position.index') }}">Jabatan</a>
                            <a class="nav-link" href="{{ route('working-hour.index') }}">Jam Kerja</a>
                            <a class="nav-link" href="{{ route('school.index') }}">Sekolah</a>
                            <a class="nav-link" href="{{ route('bonus.index') }}">Form Penilaian Bonus</a>
                        </nav>
                    </div>
                @endif
                {{-- Master --}}

                {{-- Karyawan --}}
                @if (Auth::user()->roles == 'ADMIN' ||
                        Auth::user()->roles == 'HRD' ||
                        Auth::user()->roles == 'LEADER' ||
                        Auth::user()->roles == 'MANAGER HRD' ||
                        Auth::user()->roles == 'ACCOUNTING' ||
                        Auth::user()->roles == 'MANAGER ACCOUNTING')
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
                @endif
                {{-- Karyawan --}}

                {{-- Absensi --}}
                @if (Auth::user()->roles == 'ADMIN' ||
                        Auth::user()->roles == 'MANAGER HRD' ||
                        Auth::user()->roles == 'HRD' ||
                        Auth::user()->roles == 'LEADER' ||
                        Auth::user()->roles == 'ACCOUNTING' ||
                        Auth::user()->roles == 'MANAGER ACCOUNTING')
                    <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseAbsensi"
                        aria-expanded="false" aria-controls="collapseAbsensi">
                        <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                        Absensi
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseAbsensi" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('absensi.index') }}">Absensi Karyawan</a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseAbsensi" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('absensipkl.index') }}">Absensi PKL</a>
                        </nav>
                    </div>
                @endif
                {{-- Absensi --}}

                {{-- Siswa Prakerin --}}
                @if (Auth::user()->roles == 'ADMIN' ||
                        Auth::user()->roles == 'MANAGER HRD' ||
                        Auth::user()->roles == 'HRD' ||
                        Auth::user()->roles == 'LEADER' ||
                        Auth::user()->roles == 'ACCOUNTING' ||
                        Auth::user()->roles == 'MANAGER ACCOUNTING')
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
                @endif
                {{-- Siswa Prakerin --}}

                {{-- Inventaris --}}
                @if (Auth::user()->roles == 'ADMIN' ||
                        Auth::user()->roles == 'MANAGER HRD' ||
                        Auth::user()->roles == 'HRD' ||
                        Auth::user()->roles == 'MANAGER ACCOUNTING' ||
                        Auth::user()->roles == 'ACCOUNTING')
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
                @endif
                {{-- Inventaris --}}

                {{-- Training --}}
                @if (Auth::user()->roles == 'ADMIN' ||
                        Auth::user()->roles == 'MANAGER HRD' ||
                        Auth::user()->roles == 'HRD' ||
                        Auth::user()->roles == 'LEADER')
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
                @endif
                {{-- Training --}}

                {{-- Surat --}}
                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
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
                @endif
                {{-- Surat --}}

                {{-- Proses --}}
                @if (Auth::user()->roles == 'ADMIN' ||
                        Auth::user()->roles == 'HRD' ||
                        Auth::user()->roles == 'LEADER' ||
                        Auth::user()->roles == 'ACCOUNTING' ||
                        Auth::user()->roles == 'MANAGER HRD' ||
                        Auth::user()->roles == 'MANAGER ACCOUNTING')
                    <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseProses"
                        aria-expanded="false" aria-controls="collapseProses">
                        <div class="sb-nav-link-icon"><i class="fas fa-paperclip"></i></div>
                        Proses
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                @endif
                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                    <div class="collapse" id="collapseProses" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('proses.proses_pkwt_kontrak') }}">PKWT
                                Kontrak</a>
                        </nav>
                    </div>
                @endif
                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'HRD')
                    <div class="collapse" id="collapseProses" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('proses.proses_pkwt_harian') }}">PKWT
                                Harian</a>
                        </nav>
                    </div>
                @endif
                @if (Auth::user()->roles == 'ADMIN' ||
                        Auth::user()->roles == 'HRD' ||
                        Auth::user()->roles == 'LEADER' ||
                        Auth::user()->roles == 'MANAGER HRD' ||
                        Auth::user()->roles == 'ACCOUNTING' ||
                        Auth::user()->roles == 'MANAGER ACCOUNTING')
                    <div class="collapse" id="collapseProses" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('overtime.index') }}">Overtimes</a>
                        </nav>
                    </div>
                @endif
                @if (Auth::user()->roles == 'ADMIN' ||
                        Auth::user()->roles == 'MANAGER HRD' ||
                        Auth::user()->roles == 'ACCOUNTING' ||
                        Auth::user()->roles == 'MANAGER ACCOUNTING')
                    <div class="collapse" id="collapseProses" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('proses.proses_rekon_salary') }}">Salary</a>
                        </nav>
                    </div>
                @endif
                {{-- Proses --}}

                {{-- Laporan --}}
                @if (Auth::user()->roles == 'ADMIN' ||
                        Auth::user()->roles == 'HRD' ||
                        Auth::user()->roles == 'MANAGER HRD' ||
                        Auth::user()->roles == 'LEADER' ||
                        Auth::user()->roles == 'ACCOUNTING' ||
                        Auth::user()->roles == 'MANAGER ACCOUNTING')
                    <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseLaporan"
                        aria-expanded="false" aria-controls="collapseLaporan">
                        <div class="sb-nav-link-icon"><i class="fas fa-pencil-alt"></i></div>
                        Laporan
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                @endif
                @if (Auth::user()->roles == 'ADMIN' ||
                        Auth::user()->roles == 'MANAGER HRD' ||
                        Auth::user()->roles == 'ACCOUNTING' ||
                        Auth::user()->roles == 'MANAGER ACCOUNTING')
                    <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('laporan.rekap_gaji') }}">Rekap Gaji</a>
                        </nav>
                    </div>
                @endif
                @if (Auth::user()->roles == 'ADMIN' ||
                        Auth::user()->roles == 'HRD' ||
                        Auth::user()->roles == 'MANAGER HRD' ||
                        Auth::user()->roles == 'ACCOUNTING' ||
                        Auth::user()->roles == 'MANAGER ACCOUNTING')
                    <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('laporan.absensi_karyawan') }}">Absensi
                                Karyawan</a>
                            <a class="nav-link" href="{{ route('laporan.overtimes') }}">Overtimes</a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('laporan.rekap_absensi') }}">Rekap Absensi</a>
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
                                    <a class="nav-link"
                                        href="{{ route('laporan.absensi_department_pdc_daihatsu') }}">PDC
                                        Daihatsu</a>
                                    <a class="nav-link"
                                        href="{{ route('laporan.absensi_department_produksi') }}">Produksi</a>
                                    <a class="nav-link" href="{{ route('laporan.absensi_department_ppc') }}">PPC</a>
                                    <a class="nav-link"
                                        href="{{ route('laporan.absensi_department_accicit') }}">ACC,IC,IT</a>
                                    <a class="nav-link"
                                        href="{{ route('laporan.absensi_department_hrdgadc') }}">HRD-GA,DC</a>
                                    <a class="nav-link"
                                        href="{{ route('laporan.absensi_department_marketing') }}">Marketing</a>
                                    <a class="nav-link"
                                        href="{{ route('laporan.absensi_department_purchasing') }}">Purchasing</a>
                                    <a class="nav-link"
                                        href="{{ route('laporan.absensi_department_engineering') }}">Engineering</a>
                                    <a class="nav-link"
                                        href="{{ route('laporan.absensi_department_quality') }}">Quality</a>
                                </nav>
                            </div>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('laporan.karyawan_masuk') }}">Karyawan
                                Masuk</a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('laporan.karyawan_keluar') }}">Karyawan
                                Keluar</a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('laporan.karyawan_kontrak') }}"
                                target="_blank">Karyawan
                                Kontrak</a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('laporan.karyawan_tetap') }}"
                                target="_blank">Karyawan
                                Tetap</a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('laporan.karyawan_harian') }}"
                                target="_blank">Karyawan
                                Harian</a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('laporan.karyawan_outsourcing') }}"
                                target="_blank">Karyawan
                                Outsourcing</a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('laporan.inventaris_motor') }}"
                                target="_blank">Inventaris Motor</a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('laporan.inventaris_mobil') }}"
                                target="_blank">Inventaris Mobil</a>
                        </nav>
                    </div>
                @endif
                @if (Auth::user()->roles == 'ADMIN' ||
                        Auth::user()->roles == 'HRD' ||
                        Auth::user()->roles == 'LEADER' ||
                        Auth::user()->roles == 'MANAGER HRD')
                    <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('laporan.training_internal') }}">Training Internal</a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('laporan.training_eksternal') }}">Training
                                Eksternal</a>
                        </nav>
                    </div>
                @endif
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
