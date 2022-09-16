<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RekapSalaryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Admin\Attendances;
use App\Models\Admin\Employees;
use App\Models\Admin\Areas;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use App\Models\Admin\EmployeesOuts;
use App\Models\Admin\InventoryLaptops;
use App\Models\Admin\InventoryMotorcycles;
use App\Models\Admin\InventoryCars;
use App\Models\Admin\RekapSalaries;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\RekapGajiRequest;
use App\Http\Requests\Admin\LaporanAbsensiKaryawanRequest;
use App\Http\Requests\Admin\LaporanKaryawanMasukRequest;
use App\Http\Requests\Admin\LaporanKaryawanKeluarRequest;
use Carbon\Carbon;
use Storage;
use Alert;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //GAJI
    public function rekap_gaji()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        return view('pages.admin.laporan.rekap_gaji.index');
    }

    public function tampil_rekap_gaji(RekapGajiRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $awal       = $request->input('awal');
        $akhir      = $request->input('akhir');

        $salary = RekapSalaries::where('periode_awal', $awal)->where('periode_akhir', $akhir)->first();

        //
        if (auth()->user()->roles == 'MANAGER HRD') {
            $items =
            DB::table('rekap_salaries')
            ->join('employees', 'employees.nik_karyawan', '=', 'rekap_salaries.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('golongans', 'golongans.id', '=', 'employees.golongans_id')
            ->join('areas', 'areas.id', '=', 'employees.areas_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where('periode_awal', '=', $awal)
            ->where('periode_akhir', '=', $akhir)
            ->where('golongan', '=','II')
            ->where('rekap_salaries.deleted_at', '=', null)
            ->get();
        } 
        elseif (auth()->user()->roles == 'MANAGER ACCOUNTING') {
            $items =
            DB::table('rekap_salaries')
            ->join('employees', 'employees.nik_karyawan', '=', 'rekap_salaries.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('areas', 'areas.id', '=', 'employees.areas_id')
            ->join('golongans', 'golongans.id', '=', 'employees.golongans_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where('periode_awal', '=', $awal)
            ->where('periode_akhir', '=', $akhir)
            ->where('golongan', '=','I')
            ->where('rekap_salaries.deleted_at', '=', null)
            ->get();
        }        
        elseif (auth()->user()->roles == 'ACCOUNTING') {
            $items =
            DB::table('rekap_salaries')
            ->join('employees', 'employees.nik_karyawan', '=', 'rekap_salaries.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('areas', 'areas.id', '=', 'employees.areas_id')
            ->join('golongans', 'golongans.id', '=', 'employees.golongans_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where('periode_awal', '=', $awal)
            ->where('periode_akhir', '=', $akhir)
            ->where('golongan', '=','II')
            ->where('rekap_salaries.deleted_at', '=', null)
            ->get();
        }        
        elseif (auth()->user()->roles == 'ADMIN') {
            $items =
            DB::table('rekap_salaries')
            ->join('employees', 'employees.nik_karyawan', '=', 'rekap_salaries.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('areas', 'areas.id', '=', 'employees.areas_id')
            ->join('golongans', 'golongans.id', '=', 'employees.golongans_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where('periode_awal', '=', $awal)
            ->where('periode_akhir', '=', $akhir)
            ->where('rekap_salaries.deleted_at', '=', null)
            ->get();
        }        
        else {
            Alert::error('Data Tidak Ditemukan');
            return redirect()->route('laporan.rekap_gaji');
        }

        if ($salary == null) {
            Alert::error('Data Tidak Ditemukan');
            return redirect()->route('laporan.rekap_gaji');
        } else {
            return view('pages.admin.laporan.rekap_gaji.tampil_rekap_gaji', [
                'awal'  => $awal,
                'akhir' => $akhir,
                'items' => $items
            ]);
        }
    }

    public function cancel_rekap_gaji(RekapGajiRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $awal       = $request->input('awal');
        $akhir      = $request->input('akhir');

        $rekapsalaries      = RekapSalaries::where('periode_awal', $awal)->delete();

        Alert::success('Success Cancel Rekap Gaji', 'Oleh ' . auth()->user()->name);
        //Redirect
        return redirect()->route('laporan.rekap_gaji');
    }

    public function export_excell_rekap_gaji(RekapGajiRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $roles      = auth()->user()->roles;
        $awal       = $request->input('awal');
        $akhir      = $request->input('akhir');

        return Excel::download(new RekapSalaryExport($awal,$roles), 'rekapsalary.xlsx');

    }

    public function cetak_slip_gaji(Request $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $nik_karyawan   = $request->input('nik_karyawan');
        $awal           = $request->input('awal');
        $akhir          = $request->input('akhir');

        $judul = Employees::with([
            'areas',
            'divisions',
            'positions'
        ])->where('nik_karyawan', $nik_karyawan)->first();

        $hasilslip = RekapSalaries::where('periode_awal', $awal)
            ->where('periode_akhir', $akhir)
            ->where('employees_id', $nik_karyawan)
            ->first();

        $this->fpdf = new FPDF('L', 'cm', array(21, 14));
        $this->fpdf->setTopMargin(0.1);
        $this->fpdf->setLeftMargin(0.6);
        $this->fpdf->AddPage();

        $this->fpdf->Ln(0.1);

        $this->fpdf->SetFont('Arial', 'B', '8');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(10, 1, "PT Prima Komponen Indonesia", 0, 0, 'L');
        $this->fpdf->Ln(0.4);
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(10, 1, "Jl.Kawasan Industri Taman Tekno, Blok F2. No.10-11, F1J", 0, 0, 'L');
        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(10, 1, "Setu, Setu, Tangerang Selatan, 15314.", 0, 0, 'L');

        $this->fpdf->SetFont('Arial', 'B', '10');
        $this->fpdf->Ln(0.3);
        $this->fpdf->Cell(20, 1, "Bukti Tanda Terima Slip Gaji", 0, 0, 'C');
        $this->fpdf->SetFont('Arial', '', '10');
        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(20, 1, "Periode " . \Carbon\Carbon::parse($akhir)->isoformat('MMMM Y') . "", 0, 0, 'C');
        $this->fpdf->Ln(0.3);
        $this->fpdf->Cell(22, 1, "------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------", 0, 0, 'C');
        $this->fpdf->Ln(0.3);
        $this->fpdf->SetFont('Arial', 'B', '9');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(3, 1, "Nama ", 0, 0, 'L');
        $this->fpdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $this->fpdf->Cell(5, 1, $judul->nama_karyawan, 0, 0, 'L');

        $this->fpdf->Ln(0.4);
        $this->fpdf->SetFont('Arial', 'B', '9');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(3, 1, "Tanggal Mulai Kerja ", 0, 0, 'L');
        $this->fpdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $this->fpdf->Cell(5, 1, \Carbon\Carbon::parse($judul->tanggal_mulai_kerja)->isoformat('D MMMM Y') . '', 0, 0, 'L');

        $this->fpdf->Ln(0.4);
        $this->fpdf->SetFont('Arial', 'B', '9');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(3, 1, "Jabatan ", 0, 0, 'L');
        $this->fpdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $this->fpdf->Cell(5, 1, $judul->positions->jabatan . " / " . $judul->divisions->penempatan . "", 0, 0, 'L');

        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Ln(0.3);
        $this->fpdf->Cell(22, 1, "--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------", 0, 0, 'C');
        $this->fpdf->Ln(0.3);

        $this->fpdf->SetFont('Arial', 'BI', '9');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5.4, 1, "Gaji Pokok ", 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $this->fpdf->Cell(1.7, 1, number_format($hasilslip->gaji_pokok), 0, 0, 'R');
        $this->fpdf->SetFont('Arial', 'I', '9');
        $this->fpdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');

        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5.4, 1, "Uang Makan ", 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $this->fpdf->Cell(1.7, 1, number_format($hasilslip->uang_makan), 0, 0, 'R');
        $this->fpdf->SetFont('Arial', 'I', '9');
        $this->fpdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');
        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5.4, 1, "Uang Transport ", 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $this->fpdf->Cell(1.7, 1, number_format($hasilslip->uang_transport), 0, 0, 'R');
        $this->fpdf->SetFont('Arial', 'I', '9');
        $this->fpdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');
        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5.4, 1, "Tunjangan Tugas ", 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $this->fpdf->Cell(1.7, 1, number_format($hasilslip->tunjangan_tugas), 0, 0, 'R');
        $this->fpdf->SetFont('Arial', 'I', '9');
        $this->fpdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');
        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5.4, 1, "Tunjangan Pulsa ", 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $this->fpdf->Cell(1.7, 1, number_format($hasilslip->tunjangan_pulsa), 0, 0, 'R');
        $this->fpdf->SetFont('Arial', 'I', '9');
        $this->fpdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');
        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5.4, 1, "Tunjangan Jabatan ", 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $this->fpdf->Cell(1.7, 1, number_format($hasilslip->tunjangan_jabatan), 0, 0, 'R');
        $this->fpdf->SetFont('Arial', 'I', '9');
        $this->fpdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');

        $this->fpdf->Ln(0.5);
        $this->fpdf->SetFont('Arial', 'BI', '9');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(3, 1, "Potongan ", 0, 0, 'L');

        $this->fpdf->Ln(0.4);
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5.4, 1, "Iuran BPJS Ketenagakerjaan(JHT) 2%", 0, 0, 'L');
        $this->fpdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $this->fpdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $this->fpdf->Cell(1.7, 1, number_format($hasilslip->potongan_jht_karyawan), 0, 0, 'R');
        $this->fpdf->SetFont('Arial', 'I', '9');
        $this->fpdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');

        $this->fpdf->Ln(0.4);
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5.4, 1, "Iuran BPJS Ketenagakerjaan(JP) 1%", 0, 0, 'L');
        $this->fpdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $this->fpdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $this->fpdf->Cell(1.7, 1, number_format($hasilslip->potongan_jp_karyawan), 0, 0, 'R');
        $this->fpdf->SetFont('Arial', 'I', '9');
        $this->fpdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');

        $this->fpdf->Ln(0.4);
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5.4, 1, "Iuran BPJS Kesehatan 1%", 0, 0, 'L');
        $this->fpdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $this->fpdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $this->fpdf->Cell(1.7, 1, number_format($hasilslip->potongan_bpjsks_karyawan), 0, 0, 'R');
        $this->fpdf->SetFont('Arial', 'I', '9');
        $this->fpdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');

        $this->fpdf->Ln(0.3);
        $this->fpdf->Cell(22, 1, "--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------", 0, 0, 'C');
        $this->fpdf->Ln(0.4);

        $this->fpdf->SetFont('Arial', 'BI', '9');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5.4, 1, "JUMLAH UPAH YANG DITERIMA ", 0, 0, 'L');
        $this->fpdf->SetFont('Arial', 'B', '9');
        $this->fpdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $this->fpdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $this->fpdf->Cell(1.8, 1, number_format($hasilslip->take_home_pay), 0, 0, 'R');
        $this->fpdf->SetFont('Arial', 'BI', '9');
        $this->fpdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');

        $this->fpdf->Ln(0.5);
        $this->fpdf->SetFont('Arial', 'BI', '8');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(1.8, 1, "Tangerang Selatan, " . \Carbon\Carbon::parse($akhir)->isoformat('MMMM Y') . "", 0, 0, 'L');

        $this->fpdf->Ln(0.4);
        $this->fpdf->SetFont('Arial', 'B', '8');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(1.8, 1, "Mengetahui", 0, 0, 'L');
        $this->fpdf->Cell(11.5);
        $this->fpdf->Cell(1.8, 1, "Menerima", 0, 0, 'C');

        $this->fpdf->Ln(1.6);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(1.8, 1, "Rudiyanto", 0, 0, 'L');
        $this->fpdf->Cell(11.5);
        $this->fpdf->Cell(1.8, 1, $judul->nama_karyawan, 0, 0, 'C');

        $this->fpdf->Ln(0.3);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(1.8, 1, "( Manager HRD - GA )", 0, 0, 'L');
        $this->fpdf->Cell(11.5);
        $this->fpdf->Cell(1.8, 1, "( " . $judul->positions->jabatan . " " .  $judul->divisions->penempatan . " )", 0, 0, 'C');

        $this->fpdf->Output();
        exit;
    }
    //GAJI

    //ABSENSI
    public function absensi_karyawan()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $items = Employees::with([
            'companies',
            'areas',
            'divisions',
            'positions'
        ])->get();

        return view('pages.admin.laporan.absensi.karyawan.index', [
            'items'     => $items
        ]);
    }

    public function tampil_absensi_karyawan(LaporanAbsensiKaryawanRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING') {
            abort(403);
        }
        $employees_id   = $request->input('employees_id');
        $awal           = $request->input('tanggal_awal');
        $akhir          = $request->input('tanggal_akhir');

        $item = Attendances::with([
            'employees'
        ])->where('employees_id', $employees_id)->first();

        

            $absens = Attendances::with([
                'employees'
            ])
                ->where('employees_id', $employees_id)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->get();

        if (!$absens->isEmpty()) {

            $cutitahunan = DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->groupBy('keterangan_absen', 'lama_absen', 'employees_id')
                ->select('keterangan_absen', 'employees_id', 'lama_absen', DB::raw('sum(lama_absen) as lama_absen'))
                ->where('employees_id', $employees_id)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->where('attendances.deleted_at', NULL)
                ->where('keterangan_absen', 'Cuti Tahunan')
                ->count();
            $cutikhusus = DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->groupBy('keterangan_absen', 'lama_absen', 'employees_id')
                ->select('keterangan_absen', 'employees_id', 'lama_absen', DB::raw('sum(lama_absen) as lama_absen'))
                ->where('employees_id', $employees_id)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->where('attendances.deleted_at', NULL)
                ->where('keterangan_absen', 'Cuti Khusus')
                ->count();
            $sakit = DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->groupBy('keterangan_absen', 'lama_absen', 'employees_id')
                ->select('keterangan_absen', 'employees_id', 'lama_absen', DB::raw('sum(lama_absen) as lama_absen'))
                ->where('employees_id', $employees_id)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->where('attendances.deleted_at', NULL)
                ->where('keterangan_absen', 'Sakit')
                ->count();
            $ijin = DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->groupBy('keterangan_absen', 'lama_absen', 'employees_id')
                ->select('keterangan_absen', 'employees_id', 'lama_absen', DB::raw('sum(lama_absen) as lama_absen'))
                ->where('employees_id', $employees_id)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->where('attendances.deleted_at', NULL)
                ->where('keterangan_absen', 'Ijin')
                ->count();
            $alpa = DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->groupBy('keterangan_absen', 'lama_absen', 'employees_id')
                ->select('keterangan_absen', 'employees_id', 'lama_absen', DB::raw('sum(lama_absen) as lama_absen'))
                ->where('employees_id', $employees_id)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->where('attendances.deleted_at', NULL)
                ->where('keterangan_absen', 'Alpa')
                ->count();


            $this->fpdf = new FPDF('P', 'mm', 'A4');
            $this->fpdf->AddPage();

            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', 'B', '18');
            $this->fpdf->Cell(190, 5, 'DATA ABSENSI', 0, 1, 'C');
            $this->fpdf->Ln(5);

            $this->fpdf->Cell(190, 5, $item->employees->nama_karyawan, 0, 1, 'C');
            $this->fpdf->Ln(5);

            $this->fpdf->Cell(190, 5, \Carbon\Carbon::parse($awal)->isoformat('D MMMM Y') . ' s/d ' . \Carbon\Carbon::parse($akhir)->isoformat('D MMMM Y') . '', 0, 1, 'C');

            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(25, 10, 'Sakit', 0, 0, 'L');
            $this->fpdf->Cell(5, 10, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(60, 10, $sakit . ' Hari', 0, 0, 'L');

            $this->fpdf->Cell(25, 10, 'Cuti Tahunan', 0, 0, 'L');
            $this->fpdf->Cell(5, 10, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(15, 10, $cutitahunan . ' Hari', 0, 0, 'L');
            $this->fpdf->Ln();

            $this->fpdf->Cell(25, 10, 'Ijin', 0, 0, 'L');
            $this->fpdf->Cell(5, 10, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(60, 10, $ijin . ' Hari', 0, 0, 'L');

            $this->fpdf->Cell(25, 10, 'Cuti Khusus', 0, 0, 'L');
            $this->fpdf->Cell(5, 10, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(15, 10, $cutikhusus . ' Hari', 0, 0, 'L');
            $this->fpdf->Ln();

            $this->fpdf->Cell(25, 10, 'Alpa', 0, 0, 'L');
            $this->fpdf->Cell(5, 10, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(15, 10, $alpa . ' Hari', 0, 0, 'L');
            $this->fpdf->Ln();

            $this->fpdf->Cell(1);
            $this->fpdf->SetFont('Arial', 'B', '12');
            $this->fpdf->SetFillColor(192, 192, 192); // Warna sel tabel header
            $this->fpdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
            $this->fpdf->Cell(60, 10, 'Tanggal Absen', 1, 0, 'C', 1);
            $this->fpdf->Cell(60, 10, 'Jenis', 1, 0, 'C', 1);
            $this->fpdf->Cell(60, 10, 'Keterangan', 1, 0, 'C', 1);

            $no = 1;

            foreach ($absens as $absen) {
                $this->fpdf->Ln();
                $this->fpdf->Cell(1);
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(10, 8, $no, 1, 0, 'C');
                $this->fpdf->Cell(60, 8, \Carbon\Carbon::parse($absen->tanggal_absen)->isoformat(' D MMMM Y'), 1, 0, 'C');
                $this->fpdf->Cell(60, 8, $absen->keterangan_absen, 1, 0, 'C');
                $this->fpdf->Cell(60, 8, $absen->keterangan_cuti_khusus, 1, 0, 'C');
                $no++;
            }

            $this->fpdf->Output();
            exit;
        }
        else {
            Alert::error('Data Tidak Ditemukan');
            //Redirect
            return redirect()->route('laporan.absensi_karyawan');
        }
    }
    //ABSENSI

    //KARYAWAN MASUK
    public function karyawan_masuk()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        return view('pages.admin.laporan.karyawan_masuk.index');
    }

    public function tampil_karyawan_masuk(LaporanKaryawanMasukRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        $awal               = $request->input('tanggal_awal');
        $akhir              = $request->input('tanggal_akhir');

        $employees = Employees::with([
            'divisions',
            'positions'
        ])->whereBetween('tanggal_mulai_kerja', [$awal, $akhir])->get();

        if (!$employees->isEmpty()) {
        
        $this->fpdf = new FPDF('P', 'mm', 'A4');
        $this->fpdf->AddPage();

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', '18');
        $this->fpdf->Cell(190, 5, 'DATA KARYAWAN MASUK', 0, 1, 'C');
        $this->fpdf->Ln(5);

        $this->fpdf->Cell(190, 5, 'PERIODE', 0, 1, 'C');
        $this->fpdf->Ln(5);

        $this->fpdf->Cell(190, 5, \Carbon\Carbon::parse($awal)->isoformat(' D MMMM Y') . ' s/d ' . \Carbon\Carbon::parse($akhir)->isoformat(' D MMMM Y') . '', 0, 1, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->Cell(1);
        $this->fpdf->SetFont('Arial', 'B', '12');
        $this->fpdf->SetFillColor(192, 192, 192); // Warna sel tabel header
        $this->fpdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
        $this->fpdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $this->fpdf->Cell(40, 10, 'Mulai Kerja', 1, 0, 'C', 1);
        $this->fpdf->Cell(40, 10, 'No Rekening', 1, 0, 'C', 1);
        $this->fpdf->Cell(50, 10, 'Penempatan', 1, 0, 'C', 1);

        $no = 1;

        foreach ($employees as $employee) {
            $this->fpdf->Ln();
            $this->fpdf->Cell(1);
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(10, 8, $no, 1, 0, 'C');
            $this->fpdf->Cell(55, 8, $employee->nama_karyawan, 1, 0, 'L');
            $this->fpdf->Cell(40, 8, \Carbon\Carbon::parse($employee->tanggal_mulai_kerja)->isoformat(' D MMMM Y'), 1, 0, 'C');
            $this->fpdf->Cell(40, 8, $employee->nomor_rekening, 1, 0, 'C');
            $this->fpdf->Cell(50, 8, $employee->divisions->penempatan, 1, 0, 'C');
            $no++;
        }

        $this->fpdf->Output();
        exit;
        }
        else {
            Alert::error('Data Tidak Ditemukan');
            //Redirect
            return redirect()->route('laporan.karyawan_masuk');
        }
    }
    //KARYAWAN MASUK

    //KARYAWAN KELUAR
    public function karyawan_keluar()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        return view('pages.admin.laporan.karyawan_keluar.index');
    }

    public function tampil_karyawan_keluar(LaporanKaryawanKeluarRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        $awal               = $request->input('tanggal_awal');
        $akhir              = $request->input('tanggal_akhir');

        $employeesouts = EmployeesOuts::with([
            'divisions',
            'positions'
        ])->whereBetween('tanggal_keluar_karyawan_keluar', [$awal, $akhir])->get();
        
        if (!$employeesouts->isEmpty()) {

        $this->fpdf = new FPDF('P', 'mm', 'A4');
        $this->fpdf->AddPage();

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', '18');
        $this->fpdf->Cell(190, 5, 'DATA KARYAWAN KELUAR', 0, 1, 'C');
        $this->fpdf->Ln(5);

        $this->fpdf->Cell(190, 5, 'PERIODE', 0, 1, 'C');
        $this->fpdf->Ln(5);

        $this->fpdf->Cell(190, 5, \Carbon\Carbon::parse($awal)->isoformat(' D MMMM Y') . ' s/d ' . \Carbon\Carbon::parse($akhir)->isoformat(' D MMMM Y') . '', 0, 1, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->Cell(1);
        $this->fpdf->SetFont('Arial', 'B', '12');
        $this->fpdf->SetFillColor(192, 192, 192); // Warna sel tabel header
        $this->fpdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
        $this->fpdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $this->fpdf->Cell(40, 10, 'Tanggal Masuk', 1, 0, 'C', 1);
        $this->fpdf->Cell(40, 10, 'Tanggal Keluar', 1, 0, 'C', 1);
        $this->fpdf->Cell(50, 10, 'Penempatan', 1, 0, 'C', 1);

        $no = 1;

        foreach ($employeesouts as $employeesout) {
            $this->fpdf->Ln();
            $this->fpdf->Cell(1);
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(10, 8, $no, 1, 0, 'C');
            $this->fpdf->Cell(55, 8, $employeesout->nama_karyawan_keluar, 1, 0, 'L');
            $this->fpdf->Cell(40, 8, \Carbon\Carbon::parse($employeesout->tanggal_masuk_karyawan_keluar)->isoformat(' D MMMM Y'), 1, 0, 'C');
            $this->fpdf->Cell(40, 8, \Carbon\Carbon::parse($employeesout->tanggal_keluar_karyawan_keluar)->isoformat(' D MMMM Y'), 1, 0, 'C');
            $this->fpdf->Cell(50, 8, $employeesout->divisions->penempatan, 1, 0, 'C');
            $no++;
        }

        $this->fpdf->Output();
        exit;
        }
        else {
            Alert::error('Data Tidak Ditemukan');
            //Redirect
            return redirect()->route('laporan.karyawan_keluar');
        }
    }
    //KARYAWAN KELUAR

    //KARYAWAN KONTRAK
    public function karyawan_kontrak()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        $employees = Employees::with([
            'divisions',
            'positions'
        ])->where('status_kerja', 'PKWT')->orderBy('tanggal_akhir_kerja', 'ASC')->get();

        $this->fpdf = new FPDF('P', 'mm', 'A4');
        $this->fpdf->AddPage();

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', '18');
        $this->fpdf->Cell(190, 5, 'DATA KARYAWAN KONTRAK', 0, 1, 'C');
        $this->fpdf->Ln(10);

        $this->fpdf->Cell(1);
        $this->fpdf->SetFont('Arial', 'B', '12');
        $this->fpdf->SetFillColor(192, 192, 192); // Warna sel tabel header
        $this->fpdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
        $this->fpdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $this->fpdf->Cell(40, 10, 'Penempatan', 1, 0, 'C', 1);
        $this->fpdf->Cell(40, 10, 'Jabatan', 1, 0, 'C', 1);
        $this->fpdf->Cell(50, 10, 'Akhir Kerja', 1, 0, 'C', 1);

        $no = 1;

        foreach ($employees as $employee) {
            $this->fpdf->Ln();
            $this->fpdf->Cell(1);
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(10, 8, $no, 1, 0, 'C');
            $this->fpdf->Cell(55, 8, $employee->nama_karyawan, 1, 0, 'L');
            $this->fpdf->Cell(40, 8, $employee->divisions->penempatan, 1, 0, 'C');
            $this->fpdf->Cell(40, 8, $employee->positions->jabatan, 1, 0, 'C');
            $this->fpdf->Cell(50, 8, \Carbon\Carbon::parse($employee->tanggal_akhir_kerja)->isoformat(' D MMMM Y'), 1, 0, 'C');
            $no++;
        }

        $this->fpdf->Output();
        exit;
    }
    //KARYAWAN KONTRAK
    
    //KARYAWAN TETAP
    public function karyawan_tetap()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        $employees = Employees::with([
            'areas',
            'divisions',
            'positions'
        ])->where('status_kerja', 'PKWTT')->orderBy('divisions_id', 'ASC')->get();

        $this->fpdf = new FPDF('P', 'mm', 'A4');
        $this->fpdf->AddPage();

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', '18');
        $this->fpdf->Cell(190, 5, 'DATA KARYAWAN TETAP', 0, 1, 'C');
        $this->fpdf->Ln(10);

        $this->fpdf->Cell(1);
        $this->fpdf->SetFont('Arial', 'B', '12');
        $this->fpdf->SetFillColor(192, 192, 192); // Warna sel tabel header
        $this->fpdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
        $this->fpdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $this->fpdf->Cell(40, 10, 'Area', 1, 0, 'C', 1);
        $this->fpdf->Cell(40, 10, 'Penempatan', 1, 0, 'C', 1);
        $this->fpdf->Cell(50, 10, 'Jabatan', 1, 0, 'C', 1);

        $no = 1;

        foreach ($employees as $employee) {
            $this->fpdf->Ln();
            $this->fpdf->Cell(1);
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(10, 8, $no, 1, 0, 'C');
            $this->fpdf->Cell(55, 8, $employee->nama_karyawan, 1, 0, 'L');
            $this->fpdf->Cell(40, 8, $employee->areas->area, 1, 0, 'C');
            $this->fpdf->Cell(40, 8, $employee->divisions->penempatan, 1, 0, 'C');
            $this->fpdf->Cell(50, 8, $employee->positions->jabatan, 1, 0, 'C');
            $no++;
        }

        $this->fpdf->Output();
        exit;
    }
    //KARYAWAN TETAP

    //KARYAWAN HARIAN
    public function karyawan_harian()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        $employees = Employees::with([
            'divisions',
            'positions'
        ])->where('status_kerja', 'Harian')->orderBy('tanggal_akhir_kerja', 'ASC')->get();

        $this->fpdf = new FPDF('P', 'mm', 'A4');
        $this->fpdf->AddPage();

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', '18');
        $this->fpdf->Cell(190, 5, 'DATA KARYAWAN HARIAN', 0, 1, 'C');
        $this->fpdf->Ln(10);

        $this->fpdf->Cell(1);
        $this->fpdf->SetFont('Arial', 'B', '12');
        $this->fpdf->SetFillColor(192, 192, 192); // Warna sel tabel header
        $this->fpdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
        $this->fpdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $this->fpdf->Cell(40, 10, 'Penempatan', 1, 0, 'C', 1);
        $this->fpdf->Cell(40, 10, 'Jabatan', 1, 0, 'C', 1);
        $this->fpdf->Cell(50, 10, 'Akhir Kerja', 1, 0, 'C', 1);

        $no = 1;

        foreach ($employees as $employee) {
            $this->fpdf->Ln();
            $this->fpdf->Cell(1);
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(10, 8, $no, 1, 0, 'C');
            $this->fpdf->Cell(55, 8, $employee->nama_karyawan, 1, 0, 'L');
            $this->fpdf->Cell(40, 8, $employee->divisions->penempatan, 1, 0, 'C');
            $this->fpdf->Cell(40, 8, $employee->positions->jabatan, 1, 0, 'C');
            $this->fpdf->Cell(50, 8, \Carbon\Carbon::parse($employee->tanggal_akhir_kerja)->isoformat(' D MMMM Y'), 1, 0, 'C');
            $no++;
        }

        $this->fpdf->Output();
        exit;
    }
    //KARYAWAN HARIAN

    //KARYAWAN OUTSOURCING
    public function karyawan_outsourcing()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        $employees = Employees::with([
            'divisions',
            'positions'
        ])->where('status_kerja', 'Outsourcing')->orderBy('tanggal_akhir_kerja', 'ASC')->get();

        $this->fpdf = new FPDF('P', 'mm', 'A4');
        $this->fpdf->AddPage();

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', '18');
        $this->fpdf->Cell(190, 5, 'DATA KARYAWAN OUTSOURCING', 0, 1, 'C');
        $this->fpdf->Ln(10);

        $this->fpdf->Cell(1);
        $this->fpdf->SetFont('Arial', 'B', '12');
        $this->fpdf->SetFillColor(192, 192, 192); // Warna sel tabel header
        $this->fpdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
        $this->fpdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $this->fpdf->Cell(40, 10, 'Penempatan', 1, 0, 'C', 1);
        $this->fpdf->Cell(40, 10, 'Jabatan', 1, 0, 'C', 1);
        $this->fpdf->Cell(50, 10, 'Akhir Kerja', 1, 0, 'C', 1);

        $no = 1;

        foreach ($employees as $employee) {
            $this->fpdf->Ln();
            $this->fpdf->Cell(1);
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(10, 8, $no, 1, 0, 'C');
            $this->fpdf->Cell(55, 8, $employee->nama_karyawan, 1, 0, 'L');
            $this->fpdf->Cell(40, 8, $employee->divisions->penempatan, 1, 0, 'C');
            $this->fpdf->Cell(40, 8, $employee->positions->jabatan, 1, 0, 'C');
            $this->fpdf->Cell(50, 8, \Carbon\Carbon::parse($employee->tanggal_akhir_kerja)->isoformat(' D MMMM Y'), 1, 0, 'C');
            $no++;
        }

        $this->fpdf->Output();
        exit;
    }
    //KARYAWAN OUTSOURCING

    public function index()
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
    }
}
