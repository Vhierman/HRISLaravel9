<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RekapSalaryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Admin\Attendances;
use App\Models\Admin\Employees;
use App\Models\Admin\Overtimes;
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
use App\Http\Requests\Admin\RekapAbsensiPerbulanRequest;
use App\Http\Requests\Admin\RekapAbsensiPertahunRequest;
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

    //ABSENSI KARYAWAN
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
    //ABSENSI KARYAWAN

    //REKAP ABSENSI
    public function rekap_absensi()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        
        return view('pages.admin.laporan.rekap_absensi.index');
    }

    public function rekap_perbulan()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        
        return view('pages.admin.laporan.rekap_absensi.rekap_perbulan');
    }

    public function tampil_rekap_absensi_perbulan(RekapAbsensiPerbulanRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING') {
            abort(403);
        }
        
        $awal           = $request->input('tanggal_awal');
        $akhir          = $request->input('tanggal_akhir');

        $itemsakit = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Sakit')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereBetween('tanggal_absen', [$awal, $akhir])
            ->count();

        $itemijin = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Ijin')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereBetween('tanggal_absen', [$awal, $akhir])
            ->count();
        $itemalpa = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Alpa')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereBetween('tanggal_absen', [$awal, $akhir])
            ->count();
        $itemcutitahunan = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Cuti Tahunan')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereBetween('tanggal_absen', [$awal, $akhir])
            ->count();
        $itemcutikhusus = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Cuti Khusus')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereBetween('tanggal_absen', [$awal, $akhir])
            ->count();
        
        $totalcuti = $itemcutitahunan+$itemcutikhusus;

        return view('pages.admin.laporan.rekap_absensi.tampil_perbulan', [
            'awal'  => $awal,
            'akhir' => $akhir,
            'sakit' => $itemsakit,
            'ijin'  => $itemijin,
            'alpa'  => $itemalpa,
            'cuti'  => $totalcuti
        ]);
    }

    public function rekap_pertahun()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        
        return view('pages.admin.laporan.rekap_absensi.rekap_pertahun');
    }

    public function tampil_rekap_absensi_pertahun(RekapAbsensiPertahunRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $tahun  = $request->input('tahun');

        if($tahun==2022)
        {
            $awal   = '2022-01-01';
            $akhir  = '2022-12-31';
            
            //Januari
            $sakitjanuari2022 = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Sakit')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereMonth('tanggal_absen','=','01')
            ->whereYear('tanggal_absen','=', '2022')
            ->count();
            $ijinjanuari2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Ijin')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','01')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $alpajanuari2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Alpa')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','01')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutitahunanjanuari2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Tahunan')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','01')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutikhususjanuari2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Khusus')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','01')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $totalcutijanuari2022 = $cutitahunanjanuari2022+$cutikhususjanuari2022;
            //Januari

            //februari
            $sakitfebruari2022 = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Sakit')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereMonth('tanggal_absen','=','02')
            ->whereYear('tanggal_absen','=', '2022')
            ->count();
            $ijinfebruari2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Ijin')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','02')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $alpafebruari2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Alpa')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','02')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutitahunanfebruari2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Tahunan')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','02')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutikhususfebruari2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Khusus')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','02')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $totalcutifebruari2022 = $cutitahunanfebruari2022+$cutikhususfebruari2022;
            //februari

            //maret
            $sakitmaret2022 = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Sakit')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereMonth('tanggal_absen','=','03')
            ->whereYear('tanggal_absen','=', '2022')
            ->count();
            $ijinmaret2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Ijin')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','03')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $alpamaret2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Alpa')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','03')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutitahunanmaret2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Tahunan')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','03')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutikhususmaret2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Khusus')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','03')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $totalcutimaret2022 = $cutitahunanmaret2022+$cutikhususmaret2022;
            //maret

            //april
            $sakitapril2022 = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Sakit')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereMonth('tanggal_absen','=','04')
            ->whereYear('tanggal_absen','=', '2022')
            ->count();
            $ijinapril2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Ijin')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','04')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $alpaapril2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Alpa')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','04')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutitahunanapril2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Tahunan')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','04')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutikhususapril2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Khusus')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','04')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $totalcutiapril2022 = $cutitahunanapril2022+$cutikhususapril2022;
            //april

            //mei
            $sakitmei2022 = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Sakit')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereMonth('tanggal_absen','=','05')
            ->whereYear('tanggal_absen','=', '2022')
            ->count();
            $ijinmei2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Ijin')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','05')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $alpamei2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Alpa')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','05')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutitahunanmei2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Tahunan')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','05')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutikhususmei2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Khusus')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','05')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $totalcutimei2022 = $cutitahunanmei2022+$cutikhususmei2022;
            //mei

            //juni
            $sakitjuni2022 = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Sakit')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereMonth('tanggal_absen','=','06')
            ->whereYear('tanggal_absen','=', '2022')
            ->count();
            $ijinjuni2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Ijin')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','06')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $alpajuni2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Alpa')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','06')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutitahunanjuni2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Tahunan')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','06')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutikhususjuni2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Khusus')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','06')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $totalcutijuni2022 = $cutitahunanjuni2022+$cutikhususjuni2022;
            //juni

            //juli
            $sakitjuli2022 = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Sakit')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereMonth('tanggal_absen','=','07')
            ->whereYear('tanggal_absen','=', '2022')
            ->count();
            $ijinjuli2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Ijin')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','07')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $alpajuli2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Alpa')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','07')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutitahunanjuli2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Tahunan')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','07')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutikhususjuli2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Khusus')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','07')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $totalcutijuli2022 = $cutitahunanjuli2022+$cutikhususjuli2022;
            //juli

            //agustus
            $sakitagustus2022 = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Sakit')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereMonth('tanggal_absen','=','08')
            ->whereYear('tanggal_absen','=', '2022')
            ->count();
            $ijinagustus2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Ijin')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','08')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $alpaagustus2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Alpa')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','08')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutitahunanagustus2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Tahunan')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','08')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutikhususagustus2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Khusus')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','08')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $totalcutiagustus2022 = $cutitahunanagustus2022+$cutikhususagustus2022;
            //agustus

            //september
            $sakitseptember2022 = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Sakit')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereMonth('tanggal_absen','=','09')
            ->whereYear('tanggal_absen','=', '2022')
            ->count();
            $ijinseptember2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Ijin')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','09')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $alpaseptember2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Alpa')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','09')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutitahunanseptember2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Tahunan')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','09')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutikhususseptember2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Khusus')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','09')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $totalcutiseptember2022 = $cutitahunanseptember2022+$cutikhususseptember2022;
            //september

            //oktober
            $sakitoktober2022 = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Sakit')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereMonth('tanggal_absen','=','10')
            ->whereYear('tanggal_absen','=', '2022')
            ->count();
            $ijinoktober2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Ijin')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','10')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $alpaoktober2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Alpa')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','10')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutitahunanoktober2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Tahunan')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','10')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutikhususoktober2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Khusus')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','10')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $totalcutioktober2022 = $cutitahunanoktober2022+$cutikhususoktober2022;
            //oktober

            //november
            $sakitnovember2022 = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Sakit')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereMonth('tanggal_absen','=','11')
            ->whereYear('tanggal_absen','=', '2022')
            ->count();
            $ijinnovember2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Ijin')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','11')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $alpanovember2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Alpa')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','11')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutitahunannovember2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Tahunan')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','11')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutikhususnovember2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Khusus')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','11')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $totalcutinovember2022 = $cutitahunannovember2022+$cutikhususnovember2022;
            //november

            //desember
            $sakitdesember2022 = 
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->whereIn('golongans_id', [1,2,4])
            ->where('keterangan_absen','Sakit')
            ->where('attendances.deleted_at',NULL)
            ->where('employees.deleted_at',NULL)
            ->whereMonth('tanggal_absen','=','12')
            ->whereYear('tanggal_absen','=', '2022')
            ->count();
            $ijindesember2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Ijin')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','12')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $alpadesember2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Alpa')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','12')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutitahunandesember2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Tahunan')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','12')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $cutikhususdesember2022 = 
                DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->whereIn('golongans_id', [1,2,4])
                ->where('keterangan_absen','Cuti Khusus')
                ->where('attendances.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->whereMonth('tanggal_absen','=','12')
                ->whereYear('tanggal_absen','=', '2022')
                ->count();
            $totalcutidesember2022 = $cutitahunandesember2022+$cutikhususdesember2022;
            //desember

            return view('pages.admin.laporan.rekap_absensi.tampil_pertahun', [
                'tahun'                 => $tahun,
                'sakitjanuari2022'      => $sakitjanuari2022,
                'sakitfebruari2022'     => $sakitfebruari2022,
                'sakitmaret2022'        => $sakitmaret2022,
                'sakitmaret2022'        => $sakitmaret2022,
                'sakitapril2022'        => $sakitapril2022,
                'sakitmei2022'          => $sakitmei2022,
                'sakitjuni2022'         => $sakitjuni2022,
                'sakitjuli2022'         => $sakitjuli2022,
                'sakitagustus2022'      => $sakitagustus2022,
                'sakitseptember2022'    => $sakitseptember2022,
                'sakitoktober2022'      => $sakitoktober2022,
                'sakitnovember2022'     => $sakitnovember2022,
                'sakitdesember2022'     => $sakitdesember2022,
                'ijinjanuari2022'       => $ijinjanuari2022,
                'ijinfebruari2022'      => $ijinfebruari2022,
                'ijinmaret2022'         => $ijinmaret2022,
                'ijinmaret2022'         => $ijinmaret2022,
                'ijinapril2022'         => $ijinapril2022,
                'ijinmei2022'           => $ijinmei2022,
                'ijinjuni2022'          => $ijinjuni2022,
                'ijinjuli2022'          => $ijinjuli2022,
                'ijinagustus2022'       => $ijinagustus2022,
                'ijinseptember2022'     => $ijinseptember2022,
                'ijinoktober2022'       => $ijinoktober2022,
                'ijinnovember2022'      => $ijinnovember2022,
                'ijindesember2022'      => $ijindesember2022,
                'alpajanuari2022'       => $alpajanuari2022,
                'alpafebruari2022'      => $alpafebruari2022,
                'alpamaret2022'         => $alpamaret2022,
                'alpamaret2022'         => $alpamaret2022,
                'alpaapril2022'         => $alpaapril2022,
                'alpamei2022'           => $alpamei2022,
                'alpajuni2022'          => $alpajuni2022,
                'alpajuli2022'          => $alpajuli2022,
                'alpaagustus2022'       => $alpaagustus2022,
                'alpaseptember2022'     => $alpaseptember2022,
                'alpaoktober2022'       => $alpaoktober2022,
                'alpanovember2022'      => $alpanovember2022,
                'alpadesember2022'      => $alpadesember2022,
                'totalcutijanuari2022'  => $totalcutijanuari2022,
                'totalcutifebruari2022' => $totalcutifebruari2022,
                'totalcutimaret2022'    => $totalcutimaret2022,
                'totalcutimaret2022'    => $totalcutimaret2022,
                'totalcutiapril2022'    => $totalcutiapril2022,
                'totalcutimei2022'      => $totalcutimei2022,
                'totalcutijuni2022'     => $totalcutijuni2022,
                'totalcutijuli2022'     => $totalcutijuli2022,
                'totalcutiagustus2022'  => $totalcutiagustus2022,
                'totalcutiseptember2022'=> $totalcutiseptember2022,
                'totalcutioktober2022'  => $totalcutioktober2022,
                'totalcutinovember2022' => $totalcutinovember2022,
                'totalcutidesember2022' => $totalcutidesember2022
            ]);
        }
        else{
            abort(403);
        }


        
    }
    //REKAP ABSENSI

    //ABSENSI DEPARTMENT

    public function absensi_department_pdc_daihatsu()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING') {
            abort(403);
        }

        // PDC
        //Januari
        $ItemPDCDaihatsuSunterSakitJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPDCDaihatsuSunterIjinJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPDCDaihatsuSunterAlpaJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiTahunanJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiKhususJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiJanuari = $ItemPDCDaihatsuSunterCutiTahunanJanuari + $ItemPDCDaihatsuSunterCutiKhususJanuari;
        //Januari
        //Februari
        $ItemPDCDaihatsuSunterSakitFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPDCDaihatsuSunterIjinFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPDCDaihatsuSunterAlpaFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPDCDaihatsuSunterCutiTahunanFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPDCDaihatsuSunterCutiKhususFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPDCDaihatsuSunterCutiFebruari = $ItemPDCDaihatsuSunterCutiTahunanFebruari + $ItemPDCDaihatsuSunterCutiKhususFebruari;
        //Februari
        //Maret
        $ItemPDCDaihatsuSunterSakitMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPDCDaihatsuSunterIjinMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPDCDaihatsuSunterAlpaMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiTahunanMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiKhususMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiMaret = $ItemPDCDaihatsuSunterCutiTahunanMaret + $ItemPDCDaihatsuSunterCutiKhususMaret;
        //Maret
        //April
        $ItemPDCDaihatsuSunterSakitApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPDCDaihatsuSunterIjinApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPDCDaihatsuSunterAlpaApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPDCDaihatsuSunterCutiTahunanApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPDCDaihatsuSunterCutiKhususApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPDCDaihatsuSunterCutiApril = $ItemPDCDaihatsuSunterCutiTahunanApril + $ItemPDCDaihatsuSunterCutiKhususApril;
        //April
        //Mei
        $ItemPDCDaihatsuSunterSakitMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPDCDaihatsuSunterIjinMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPDCDaihatsuSunterAlpaMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiTahunanMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiKhususMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiMei = $ItemPDCDaihatsuSunterCutiTahunanMei + $ItemPDCDaihatsuSunterCutiKhususMei;
        //Mei
        //Juni
        $ItemPDCDaihatsuSunterSakitJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPDCDaihatsuSunterIjinJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPDCDaihatsuSunterAlpaJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPDCDaihatsuSunterCutiTahunanJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPDCDaihatsuSunterCutiKhususJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPDCDaihatsuSunterCutiJuni = $ItemPDCDaihatsuSunterCutiTahunanJuni + $ItemPDCDaihatsuSunterCutiKhususJuni;
        //Juni
        //Juli
        $ItemPDCDaihatsuSunterSakitJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPDCDaihatsuSunterIjinJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPDCDaihatsuSunterAlpaJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiTahunanJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiKhususJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiJuli = $ItemPDCDaihatsuSunterCutiTahunanJuli + $ItemPDCDaihatsuSunterCutiKhususJuli;
        //Juli
        //Agustus
        $ItemPDCDaihatsuSunterSakitAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPDCDaihatsuSunterIjinAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPDCDaihatsuSunterAlpaAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiTahunanAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiKhususAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiAgustus = $ItemPDCDaihatsuSunterCutiTahunanAgustus + $ItemPDCDaihatsuSunterCutiKhususAgustus;
        //Agustus
        //September
        $ItemPDCDaihatsuSunterSakitSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPDCDaihatsuSunterIjinSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPDCDaihatsuSunterAlpaSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPDCDaihatsuSunterCutiTahunanSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPDCDaihatsuSunterCutiKhususSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPDCDaihatsuSunterCutiSeptember = $ItemPDCDaihatsuSunterCutiTahunanSeptember + $ItemPDCDaihatsuSunterCutiKhususSeptember;
        //September
        //Oktober
        $ItemPDCDaihatsuSunterSakitOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPDCDaihatsuSunterIjinOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPDCDaihatsuSunterAlpaOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiTahunanOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiKhususOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiOktober = $ItemPDCDaihatsuSunterCutiTahunanOktober + $ItemPDCDaihatsuSunterCutiKhususOktober;
        //Oktober
        //November
        $ItemPDCDaihatsuSunterSakitNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPDCDaihatsuSunterIjinNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPDCDaihatsuSunterAlpaNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPDCDaihatsuSunterCutiTahunanNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPDCDaihatsuSunterCutiKhususNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPDCDaihatsuSunterCutiNovember = $ItemPDCDaihatsuSunterCutiTahunanNovember + $ItemPDCDaihatsuSunterCutiKhususNovember;
        //November
        //Desember
        $ItemPDCDaihatsuSunterSakitDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPDCDaihatsuSunterIjinDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPDCDaihatsuSunterAlpaDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiTahunanDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiKhususDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '19')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPDCDaihatsuSunterCutiDesember = $ItemPDCDaihatsuSunterCutiTahunanDesember + $ItemPDCDaihatsuSunterCutiKhususDesember;
        //Desember
        // PDC

        return view('pages.admin.laporan.absensi.department.pdc_daihatsu', [
            'ItemPDCDaihatsuSunterSakitJanuari'     => $ItemPDCDaihatsuSunterSakitJanuari,
            'ItemPDCDaihatsuSunterIjinJanuari'      => $ItemPDCDaihatsuSunterIjinJanuari,
            'ItemPDCDaihatsuSunterAlpaJanuari'      => $ItemPDCDaihatsuSunterAlpaJanuari,
            'ItemPDCDaihatsuSunterCutiJanuari'      => $ItemPDCDaihatsuSunterCutiJanuari,
            'ItemPDCDaihatsuSunterSakitFebruari'    => $ItemPDCDaihatsuSunterSakitFebruari,
            'ItemPDCDaihatsuSunterIjinFebruari'     => $ItemPDCDaihatsuSunterIjinFebruari,
            'ItemPDCDaihatsuSunterAlpaFebruari'     => $ItemPDCDaihatsuSunterAlpaFebruari,
            'ItemPDCDaihatsuSunterCutiFebruari'     => $ItemPDCDaihatsuSunterCutiFebruari,
            'ItemPDCDaihatsuSunterSakitMaret'       => $ItemPDCDaihatsuSunterSakitMaret,
            'ItemPDCDaihatsuSunterIjinMaret'        => $ItemPDCDaihatsuSunterIjinMaret,
            'ItemPDCDaihatsuSunterAlpaMaret'        => $ItemPDCDaihatsuSunterAlpaMaret,
            'ItemPDCDaihatsuSunterCutiMaret'        => $ItemPDCDaihatsuSunterCutiMaret,
            'ItemPDCDaihatsuSunterSakitApril'       => $ItemPDCDaihatsuSunterSakitApril,
            'ItemPDCDaihatsuSunterIjinApril'        => $ItemPDCDaihatsuSunterIjinApril,
            'ItemPDCDaihatsuSunterAlpaApril'        => $ItemPDCDaihatsuSunterAlpaApril,
            'ItemPDCDaihatsuSunterCutiApril'        => $ItemPDCDaihatsuSunterCutiApril,
            'ItemPDCDaihatsuSunterSakitMei'         => $ItemPDCDaihatsuSunterSakitMei,
            'ItemPDCDaihatsuSunterIjinMei'          => $ItemPDCDaihatsuSunterIjinMei,
            'ItemPDCDaihatsuSunterAlpaMei'          => $ItemPDCDaihatsuSunterAlpaMei,
            'ItemPDCDaihatsuSunterCutiMei'          => $ItemPDCDaihatsuSunterCutiMei,
            'ItemPDCDaihatsuSunterSakitJuni'        => $ItemPDCDaihatsuSunterSakitJuni,
            'ItemPDCDaihatsuSunterIjinJuni'         => $ItemPDCDaihatsuSunterIjinJuni,
            'ItemPDCDaihatsuSunterAlpaJuni'         => $ItemPDCDaihatsuSunterAlpaJuni,
            'ItemPDCDaihatsuSunterCutiJuni'         => $ItemPDCDaihatsuSunterCutiJuni,
            'ItemPDCDaihatsuSunterSakitJuli'        => $ItemPDCDaihatsuSunterSakitJuli,
            'ItemPDCDaihatsuSunterIjinJuli'         => $ItemPDCDaihatsuSunterIjinJuli,
            'ItemPDCDaihatsuSunterAlpaJuli'         => $ItemPDCDaihatsuSunterAlpaJuli,
            'ItemPDCDaihatsuSunterCutiJuli'         => $ItemPDCDaihatsuSunterCutiJuli,
            'ItemPDCDaihatsuSunterSakitAgustus'     => $ItemPDCDaihatsuSunterSakitAgustus,
            'ItemPDCDaihatsuSunterIjinAgustus'      => $ItemPDCDaihatsuSunterIjinAgustus,
            'ItemPDCDaihatsuSunterAlpaAgustus'      => $ItemPDCDaihatsuSunterAlpaAgustus,
            'ItemPDCDaihatsuSunterCutiAgustus'      => $ItemPDCDaihatsuSunterCutiAgustus,
            'ItemPDCDaihatsuSunterSakitSeptember'   => $ItemPDCDaihatsuSunterSakitSeptember,
            'ItemPDCDaihatsuSunterIjinSeptember'    => $ItemPDCDaihatsuSunterIjinSeptember,
            'ItemPDCDaihatsuSunterAlpaSeptember'    => $ItemPDCDaihatsuSunterAlpaSeptember,
            'ItemPDCDaihatsuSunterCutiSeptember'    => $ItemPDCDaihatsuSunterCutiSeptember,
            'ItemPDCDaihatsuSunterSakitOktober'     => $ItemPDCDaihatsuSunterSakitOktober,
            'ItemPDCDaihatsuSunterIjinOktober'      => $ItemPDCDaihatsuSunterIjinOktober,
            'ItemPDCDaihatsuSunterAlpaOktober'      => $ItemPDCDaihatsuSunterAlpaOktober,
            'ItemPDCDaihatsuSunterCutiOktober'      => $ItemPDCDaihatsuSunterCutiOktober,
            'ItemPDCDaihatsuSunterSakitNovember'    => $ItemPDCDaihatsuSunterSakitNovember,
            'ItemPDCDaihatsuSunterIjinNovember'     => $ItemPDCDaihatsuSunterIjinNovember,
            'ItemPDCDaihatsuSunterAlpaNovember'     => $ItemPDCDaihatsuSunterAlpaNovember,
            'ItemPDCDaihatsuSunterCutiNovember'     => $ItemPDCDaihatsuSunterCutiNovember,
            'ItemPDCDaihatsuSunterSakitDesember'    => $ItemPDCDaihatsuSunterSakitDesember,
            'ItemPDCDaihatsuSunterIjinDesember'     => $ItemPDCDaihatsuSunterIjinDesember,
            'ItemPDCDaihatsuSunterAlpaDesember'     => $ItemPDCDaihatsuSunterAlpaDesember,
            'ItemPDCDaihatsuSunterCutiDesember'     => $ItemPDCDaihatsuSunterCutiDesember
        ]);
    }

    public function absensi_department_produksi()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING') {
            abort(403);
        }
        // Produksi
        //Januari
        $ItemProduksiSakitJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemProduksiIjinJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemProduksiAlpaJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemProduksiCutiTahunanJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemProduksiCutiKhususJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemProduksiCutiJanuari = $ItemProduksiCutiTahunanJanuari + $ItemProduksiCutiKhususJanuari;
        //Januari
        //Februari
        $ItemProduksiSakitFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemProduksiIjinFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemProduksiAlpaFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemProduksiCutiTahunanFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemProduksiCutiKhususFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemProduksiCutiFebruari = $ItemProduksiCutiTahunanFebruari +
            $ItemProduksiCutiKhususFebruari;
        //Februari
        //Maret
        $ItemProduksiSakitMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemProduksiIjinMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemProduksiAlpaMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemProduksiCutiTahunanMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemProduksiCutiKhususMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemProduksiCutiMaret = $ItemProduksiCutiTahunanMaret + $ItemProduksiCutiKhususMaret;
        //Maret
        //April
        $ItemProduksiSakitApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemProduksiIjinApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemProduksiAlpaApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemProduksiCutiTahunanApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemProduksiCutiKhususApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemProduksiCutiApril = $ItemProduksiCutiTahunanApril + $ItemProduksiCutiKhususApril;
        //April
        //Mei
        $ItemProduksiSakitMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemProduksiIjinMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemProduksiAlpaMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemProduksiCutiTahunanMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemProduksiCutiKhususMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemProduksiCutiMei = $ItemProduksiCutiTahunanMei + $ItemProduksiCutiKhususMei;
        //Mei
        //Juni
        $ItemProduksiSakitJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemProduksiIjinJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemProduksiAlpaJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemProduksiCutiTahunanJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemProduksiCutiKhususJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemProduksiCutiJuni = $ItemProduksiCutiTahunanJuni + $ItemProduksiCutiKhususJuni;
        //Juni
        //Juli
        $ItemProduksiSakitJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemProduksiIjinJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemProduksiAlpaJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemProduksiCutiTahunanJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemProduksiCutiKhususJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemProduksiCutiJuli = $ItemProduksiCutiTahunanJuli + $ItemProduksiCutiKhususJuli;
        //Juli
        //Agustus
        $ItemProduksiSakitAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemProduksiIjinAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemProduksiAlpaAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemProduksiCutiTahunanAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemProduksiCutiKhususAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemProduksiCutiAgustus = $ItemProduksiCutiTahunanAgustus + $ItemProduksiCutiKhususAgustus;
        //Agustus
        //September
        $ItemProduksiSakitSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemProduksiIjinSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemProduksiAlpaSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemProduksiCutiTahunanSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemProduksiCutiKhususSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemProduksiCutiSeptember = $ItemProduksiCutiTahunanSeptember +
            $ItemProduksiCutiKhususSeptember;
        //September
        //Oktober
        $ItemProduksiSakitOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemProduksiIjinOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemProduksiAlpaOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemProduksiCutiTahunanOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemProduksiCutiKhususOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemProduksiCutiOktober = $ItemProduksiCutiTahunanOktober + $ItemProduksiCutiKhususOktober;
        //Oktober
        //November
        $ItemProduksiSakitNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemProduksiIjinNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemProduksiAlpaNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemProduksiCutiTahunanNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemProduksiCutiKhususNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemProduksiCutiNovember = $ItemProduksiCutiTahunanNovember +
            $ItemProduksiCutiKhususNovember;
        //November
        //Desember
        $ItemProduksiSakitDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemProduksiIjinDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemProduksiAlpaDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemProduksiCutiTahunanDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemProduksiCutiKhususDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '11')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemProduksiCutiDesember = $ItemProduksiCutiTahunanDesember +
            $ItemProduksiCutiKhususDesember;
        //Desember
        // Produksi

        return view('pages.admin.laporan.absensi.department.produksi', [
            'ItemProduksiSakitJanuari' => $ItemProduksiSakitJanuari,
            'ItemProduksiIjinJanuari' => $ItemProduksiIjinJanuari,
            'ItemProduksiAlpaJanuari' => $ItemProduksiAlpaJanuari,
            'ItemProduksiCutiJanuari' => $ItemProduksiCutiJanuari,
            'ItemProduksiSakitFebruari' => $ItemProduksiSakitFebruari,
            'ItemProduksiIjinFebruari' => $ItemProduksiIjinFebruari,
            'ItemProduksiAlpaFebruari' => $ItemProduksiAlpaFebruari,
            'ItemProduksiCutiFebruari' => $ItemProduksiCutiFebruari,
            'ItemProduksiSakitMaret' => $ItemProduksiSakitMaret,
            'ItemProduksiIjinMaret' => $ItemProduksiIjinMaret,
            'ItemProduksiAlpaMaret' => $ItemProduksiAlpaMaret,
            'ItemProduksiCutiMaret' => $ItemProduksiCutiMaret,
            'ItemProduksiSakitApril' => $ItemProduksiSakitApril,
            'ItemProduksiIjinApril' => $ItemProduksiIjinApril,
            'ItemProduksiAlpaApril' => $ItemProduksiAlpaApril,
            'ItemProduksiCutiApril' => $ItemProduksiCutiApril,
            'ItemProduksiSakitMei' => $ItemProduksiSakitMei,
            'ItemProduksiIjinMei' => $ItemProduksiIjinMei,
            'ItemProduksiAlpaMei' => $ItemProduksiAlpaMei,
            'ItemProduksiCutiMei' => $ItemProduksiCutiMei,
            'ItemProduksiSakitJuni' => $ItemProduksiSakitJuni,
            'ItemProduksiIjinJuni' => $ItemProduksiIjinJuni,
            'ItemProduksiAlpaJuni' => $ItemProduksiAlpaJuni,
            'ItemProduksiCutiJuni' => $ItemProduksiCutiJuni,
            'ItemProduksiSakitJuli' => $ItemProduksiSakitJuli,
            'ItemProduksiIjinJuli' => $ItemProduksiIjinJuli,
            'ItemProduksiAlpaJuli' => $ItemProduksiAlpaJuli,
            'ItemProduksiCutiJuli' => $ItemProduksiCutiJuli,
            'ItemProduksiSakitAgustus' => $ItemProduksiSakitAgustus,
            'ItemProduksiIjinAgustus' => $ItemProduksiIjinAgustus,
            'ItemProduksiAlpaAgustus' => $ItemProduksiAlpaAgustus,
            'ItemProduksiCutiAgustus' => $ItemProduksiCutiAgustus,
            'ItemProduksiSakitSeptember' => $ItemProduksiSakitSeptember,
            'ItemProduksiIjinSeptember' => $ItemProduksiIjinSeptember,
            'ItemProduksiAlpaSeptember' => $ItemProduksiAlpaSeptember,
            'ItemProduksiCutiSeptember' => $ItemProduksiCutiSeptember,
            'ItemProduksiSakitOktober' => $ItemProduksiSakitOktober,
            'ItemProduksiIjinOktober' => $ItemProduksiIjinOktober,
            'ItemProduksiAlpaOktober' => $ItemProduksiAlpaOktober,
            'ItemProduksiCutiOktober' => $ItemProduksiCutiOktober,
            'ItemProduksiSakitNovember' => $ItemProduksiSakitNovember,
            'ItemProduksiIjinNovember' => $ItemProduksiIjinNovember,
            'ItemProduksiAlpaNovember' => $ItemProduksiAlpaNovember,
            'ItemProduksiCutiNovember' => $ItemProduksiCutiNovember,
            'ItemProduksiSakitDesember' => $ItemProduksiSakitDesember,
            'ItemProduksiIjinDesember' => $ItemProduksiIjinDesember,
            'ItemProduksiAlpaDesember' => $ItemProduksiAlpaDesember,
            'ItemProduksiCutiDesember' => $ItemProduksiCutiDesember
        ]);
    }

    public function absensi_department_ppc()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING') {
            abort(403);
        }
        // PPC
        //Januari
        $ItemPPCSakitJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPPCIjinJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPPCAlpaJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPPCCutiTahunanJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPPCCutiKhususJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPPCCutiJanuari = $ItemPPCCutiTahunanJanuari + $ItemPPCCutiKhususJanuari;
        //Januari
        //Februari
        $ItemPPCSakitFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPPCIjinFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPPCAlpaFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPPCCutiTahunanFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPPCCutiKhususFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPPCCutiFebruari = $ItemPPCCutiTahunanFebruari +
            $ItemPPCCutiKhususFebruari;
        //Februari
        //Maret
        $ItemPPCSakitMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPPCIjinMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPPCAlpaMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPPCCutiTahunanMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPPCCutiKhususMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPPCCutiMaret = $ItemPPCCutiTahunanMaret + $ItemPPCCutiKhususMaret;
        //Maret
        //April
        $ItemPPCSakitApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPPCIjinApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPPCAlpaApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPPCCutiTahunanApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPPCCutiKhususApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPPCCutiApril = $ItemPPCCutiTahunanApril + $ItemPPCCutiKhususApril;
        //April
        //Mei
        $ItemPPCSakitMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPPCIjinMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPPCAlpaMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPPCCutiTahunanMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPPCCutiKhususMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPPCCutiMei = $ItemPPCCutiTahunanMei + $ItemPPCCutiKhususMei;
        //Mei
        //Juni
        $ItemPPCSakitJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPPCIjinJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPPCAlpaJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPPCCutiTahunanJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPPCCutiKhususJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPPCCutiJuni = $ItemPPCCutiTahunanJuni + $ItemPPCCutiKhususJuni;
        //Juni
        //Juli
        $ItemPPCSakitJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPPCIjinJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPPCAlpaJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPPCCutiTahunanJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPPCCutiKhususJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPPCCutiJuli = $ItemPPCCutiTahunanJuli + $ItemPPCCutiKhususJuli;
        //Juli
        //Agustus
        $ItemPPCSakitAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPPCIjinAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPPCAlpaAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPPCCutiTahunanAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPPCCutiKhususAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPPCCutiAgustus = $ItemPPCCutiTahunanAgustus + $ItemPPCCutiKhususAgustus;
        //Agustus
        //September
        $ItemPPCSakitSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPPCIjinSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPPCAlpaSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPPCCutiTahunanSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPPCCutiKhususSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPPCCutiSeptember = $ItemPPCCutiTahunanSeptember +
            $ItemPPCCutiKhususSeptember;
        //September
        //Oktober
        $ItemPPCSakitOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPPCIjinOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPPCAlpaOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPPCCutiTahunanOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPPCCutiKhususOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPPCCutiOktober = $ItemPPCCutiTahunanOktober + $ItemPPCCutiKhususOktober;
        //Oktober
        //November
        $ItemPPCSakitNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPPCIjinNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPPCAlpaNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPPCCutiTahunanNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPPCCutiKhususNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPPCCutiNovember = $ItemPPCCutiTahunanNovember +
            $ItemPPCCutiKhususNovember;
        //November
        //Desember
        $ItemPPCSakitDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPPCIjinDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPPCAlpaDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPPCCutiTahunanDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPPCCutiKhususDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [10, 12, 13, 14, 15, 18])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPPCCutiDesember = $ItemPPCCutiTahunanDesember +
            $ItemPPCCutiKhususDesember;
        //Desember
        // PPC

        return view('pages.admin.laporan.absensi.department.ppc', [
            'ItemPPCSakitJanuari' => $ItemPPCSakitJanuari,
            'ItemPPCIjinJanuari' => $ItemPPCIjinJanuari,
            'ItemPPCAlpaJanuari' => $ItemPPCAlpaJanuari,
            'ItemPPCCutiJanuari' => $ItemPPCCutiJanuari,
            'ItemPPCSakitFebruari' => $ItemPPCSakitFebruari,
            'ItemPPCIjinFebruari' => $ItemPPCIjinFebruari,
            'ItemPPCAlpaFebruari' => $ItemPPCAlpaFebruari,
            'ItemPPCCutiFebruari' => $ItemPPCCutiFebruari,
            'ItemPPCSakitMaret' => $ItemPPCSakitMaret,
            'ItemPPCIjinMaret' => $ItemPPCIjinMaret,
            'ItemPPCAlpaMaret' => $ItemPPCAlpaMaret,
            'ItemPPCCutiMaret' => $ItemPPCCutiMaret,
            'ItemPPCSakitApril' => $ItemPPCSakitApril,
            'ItemPPCIjinApril' => $ItemPPCIjinApril,
            'ItemPPCAlpaApril' => $ItemPPCAlpaApril,
            'ItemPPCCutiApril' => $ItemPPCCutiApril,
            'ItemPPCSakitMei' => $ItemPPCSakitMei,
            'ItemPPCIjinMei' => $ItemPPCIjinMei,
            'ItemPPCAlpaMei' => $ItemPPCAlpaMei,
            'ItemPPCCutiMei' => $ItemPPCCutiMei,
            'ItemPPCSakitJuni' => $ItemPPCSakitJuni,
            'ItemPPCIjinJuni' => $ItemPPCIjinJuni,
            'ItemPPCAlpaJuni' => $ItemPPCAlpaJuni,
            'ItemPPCCutiJuni' => $ItemPPCCutiJuni,
            'ItemPPCSakitJuli' => $ItemPPCSakitJuli,
            'ItemPPCIjinJuli' => $ItemPPCIjinJuli,
            'ItemPPCAlpaJuli' => $ItemPPCAlpaJuli,
            'ItemPPCCutiJuli' => $ItemPPCCutiJuli,
            'ItemPPCSakitAgustus' => $ItemPPCSakitAgustus,
            'ItemPPCIjinAgustus' => $ItemPPCIjinAgustus,
            'ItemPPCAlpaAgustus' => $ItemPPCAlpaAgustus,
            'ItemPPCCutiAgustus' => $ItemPPCCutiAgustus,
            'ItemPPCSakitSeptember' => $ItemPPCSakitSeptember,
            'ItemPPCIjinSeptember' => $ItemPPCIjinSeptember,
            'ItemPPCAlpaSeptember' => $ItemPPCAlpaSeptember,
            'ItemPPCCutiSeptember' => $ItemPPCCutiSeptember,
            'ItemPPCSakitOktober' => $ItemPPCSakitOktober,
            'ItemPPCIjinOktober' => $ItemPPCIjinOktober,
            'ItemPPCAlpaOktober' => $ItemPPCAlpaOktober,
            'ItemPPCCutiOktober' => $ItemPPCCutiOktober,
            'ItemPPCSakitNovember' => $ItemPPCSakitNovember,
            'ItemPPCIjinNovember' => $ItemPPCIjinNovember,
            'ItemPPCAlpaNovember' => $ItemPPCAlpaNovember,
            'ItemPPCCutiNovember' => $ItemPPCCutiNovember,
            'ItemPPCSakitDesember' => $ItemPPCSakitDesember,
            'ItemPPCIjinDesember' => $ItemPPCIjinDesember,
            'ItemPPCAlpaDesember' => $ItemPPCAlpaDesember,
            'ItemPPCCutiDesember' => $ItemPPCCutiDesember
        ]);
    }

    public function absensi_department_accicit()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING') {
            abort(403);
        }
        // AccICIT
        //Januari
        $ItemAccICITSakitJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemAccICITIjinJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemAccICITAlpaJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemAccICITCutiTahunanJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemAccICITCutiKhususJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemAccICITCutiJanuari = $ItemAccICITCutiTahunanJanuari + $ItemAccICITCutiKhususJanuari;
        //Januari
        //Februari
        $ItemAccICITSakitFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemAccICITIjinFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemAccICITAlpaFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemAccICITCutiTahunanFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemAccICITCutiKhususFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemAccICITCutiFebruari = $ItemAccICITCutiTahunanFebruari +
            $ItemAccICITCutiKhususFebruari;
        //Februari
        //Maret
        $ItemAccICITSakitMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemAccICITIjinMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemAccICITAlpaMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemAccICITCutiTahunanMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemAccICITCutiKhususMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemAccICITCutiMaret = $ItemAccICITCutiTahunanMaret + $ItemAccICITCutiKhususMaret;
        //Maret
        //April
        $ItemAccICITSakitApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemAccICITIjinApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemAccICITAlpaApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemAccICITCutiTahunanApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemAccICITCutiKhususApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemAccICITCutiApril = $ItemAccICITCutiTahunanApril + $ItemAccICITCutiKhususApril;
        //April
        //Mei
        $ItemAccICITSakitMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemAccICITIjinMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemAccICITAlpaMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemAccICITCutiTahunanMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemAccICITCutiKhususMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemAccICITCutiMei = $ItemAccICITCutiTahunanMei + $ItemAccICITCutiKhususMei;
        //Mei
        //Juni
        $ItemAccICITSakitJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemAccICITIjinJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemAccICITAlpaJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemAccICITCutiTahunanJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemAccICITCutiKhususJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemAccICITCutiJuni = $ItemAccICITCutiTahunanJuni + $ItemAccICITCutiKhususJuni;
        //Juni
        //Juli
        $ItemAccICITSakitJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemAccICITIjinJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemAccICITAlpaJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemAccICITCutiTahunanJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemAccICITCutiKhususJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemAccICITCutiJuli = $ItemAccICITCutiTahunanJuli + $ItemAccICITCutiKhususJuli;
        //Juli
        //Agustus
        $ItemAccICITSakitAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemAccICITIjinAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemAccICITAlpaAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemAccICITCutiTahunanAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemAccICITCutiKhususAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemAccICITCutiAgustus = $ItemAccICITCutiTahunanAgustus + $ItemAccICITCutiKhususAgustus;
        //Agustus
        //September
        $ItemAccICITSakitSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemAccICITIjinSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemAccICITAlpaSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemAccICITCutiTahunanSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemAccICITCutiKhususSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemAccICITCutiSeptember = $ItemAccICITCutiTahunanSeptember +
            $ItemAccICITCutiKhususSeptember;
        //September
        //Oktober
        $ItemAccICITSakitOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemAccICITIjinOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemAccICITAlpaOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemAccICITCutiTahunanOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemAccICITCutiKhususOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemAccICITCutiOktober = $ItemAccICITCutiTahunanOktober + $ItemAccICITCutiKhususOktober;
        //Oktober
        //November
        $ItemAccICITSakitNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemAccICITIjinNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemAccICITAlpaNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemAccICITCutiTahunanNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemAccICITCutiKhususNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemAccICITCutiNovember = $ItemAccICITCutiTahunanNovember +
            $ItemAccICITCutiKhususNovember;
        //November
        //Desember
        $ItemAccICITSakitDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemAccICITIjinDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemAccICITAlpaDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemAccICITCutiTahunanDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemAccICITCutiKhususDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [1, 2, 3])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemAccICITCutiDesember = $ItemAccICITCutiTahunanDesember +
            $ItemAccICITCutiKhususDesember;
        //Desember
        // AccICIT

        return view('pages.admin.laporan.absensi.department.accicit', [
            'ItemAccICITSakitJanuari' => $ItemAccICITSakitJanuari,
            'ItemAccICITIjinJanuari' => $ItemAccICITIjinJanuari,
            'ItemAccICITAlpaJanuari' => $ItemAccICITAlpaJanuari,
            'ItemAccICITCutiJanuari' => $ItemAccICITCutiJanuari,
            'ItemAccICITSakitFebruari' => $ItemAccICITSakitFebruari,
            'ItemAccICITIjinFebruari' => $ItemAccICITIjinFebruari,
            'ItemAccICITAlpaFebruari' => $ItemAccICITAlpaFebruari,
            'ItemAccICITCutiFebruari' => $ItemAccICITCutiFebruari,
            'ItemAccICITSakitMaret' => $ItemAccICITSakitMaret,
            'ItemAccICITIjinMaret' => $ItemAccICITIjinMaret,
            'ItemAccICITAlpaMaret' => $ItemAccICITAlpaMaret,
            'ItemAccICITCutiMaret' => $ItemAccICITCutiMaret,
            'ItemAccICITSakitApril' => $ItemAccICITSakitApril,
            'ItemAccICITIjinApril' => $ItemAccICITIjinApril,
            'ItemAccICITAlpaApril' => $ItemAccICITAlpaApril,
            'ItemAccICITCutiApril' => $ItemAccICITCutiApril,
            'ItemAccICITSakitMei' => $ItemAccICITSakitMei,
            'ItemAccICITIjinMei' => $ItemAccICITIjinMei,
            'ItemAccICITAlpaMei' => $ItemAccICITAlpaMei,
            'ItemAccICITCutiMei' => $ItemAccICITCutiMei,
            'ItemAccICITSakitJuni' => $ItemAccICITSakitJuni,
            'ItemAccICITIjinJuni' => $ItemAccICITIjinJuni,
            'ItemAccICITAlpaJuni' => $ItemAccICITAlpaJuni,
            'ItemAccICITCutiJuni' => $ItemAccICITCutiJuni,
            'ItemAccICITSakitJuli' => $ItemAccICITSakitJuli,
            'ItemAccICITIjinJuli' => $ItemAccICITIjinJuli,
            'ItemAccICITAlpaJuli' => $ItemAccICITAlpaJuli,
            'ItemAccICITCutiJuli' => $ItemAccICITCutiJuli,
            'ItemAccICITSakitAgustus' => $ItemAccICITSakitAgustus,
            'ItemAccICITIjinAgustus' => $ItemAccICITIjinAgustus,
            'ItemAccICITAlpaAgustus' => $ItemAccICITAlpaAgustus,
            'ItemAccICITCutiAgustus' => $ItemAccICITCutiAgustus,
            'ItemAccICITSakitSeptember' => $ItemAccICITSakitSeptember,
            'ItemAccICITIjinSeptember' => $ItemAccICITIjinSeptember,
            'ItemAccICITAlpaSeptember' => $ItemAccICITAlpaSeptember,
            'ItemAccICITCutiSeptember' => $ItemAccICITCutiSeptember,
            'ItemAccICITSakitOktober' => $ItemAccICITSakitOktober,
            'ItemAccICITIjinOktober' => $ItemAccICITIjinOktober,
            'ItemAccICITAlpaOktober' => $ItemAccICITAlpaOktober,
            'ItemAccICITCutiOktober' => $ItemAccICITCutiOktober,
            'ItemAccICITSakitNovember' => $ItemAccICITSakitNovember,
            'ItemAccICITIjinNovember' => $ItemAccICITIjinNovember,
            'ItemAccICITAlpaNovember' => $ItemAccICITAlpaNovember,
            'ItemAccICITCutiNovember' => $ItemAccICITCutiNovember,
            'ItemAccICITSakitDesember' => $ItemAccICITSakitDesember,
            'ItemAccICITIjinDesember' => $ItemAccICITIjinDesember,
            'ItemAccICITAlpaDesember' => $ItemAccICITAlpaDesember,
            'ItemAccICITCutiDesember' => $ItemAccICITCutiDesember
        ]);
    }

    public function absensi_department_hrdgadc()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING') {
            abort(403);
        }
        // HRDGADC
        //Januari
        $ItemHRDGADCSakitJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemHRDGADCIjinJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemHRDGADCAlpaJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemHRDGADCCutiTahunanJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemHRDGADCCutiKhususJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemHRDGADCCutiJanuari = $ItemHRDGADCCutiTahunanJanuari + $ItemHRDGADCCutiKhususJanuari;
        //Januari
        //Februari
        $ItemHRDGADCSakitFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemHRDGADCIjinFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemHRDGADCAlpaFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemHRDGADCCutiTahunanFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemHRDGADCCutiKhususFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemHRDGADCCutiFebruari = $ItemHRDGADCCutiTahunanFebruari +
            $ItemHRDGADCCutiKhususFebruari;
        //Februari
        //Maret
        $ItemHRDGADCSakitMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemHRDGADCIjinMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemHRDGADCAlpaMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemHRDGADCCutiTahunanMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemHRDGADCCutiKhususMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemHRDGADCCutiMaret = $ItemHRDGADCCutiTahunanMaret + $ItemHRDGADCCutiKhususMaret;
        //Maret
        //April
        $ItemHRDGADCSakitApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemHRDGADCIjinApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemHRDGADCAlpaApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemHRDGADCCutiTahunanApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemHRDGADCCutiKhususApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemHRDGADCCutiApril = $ItemHRDGADCCutiTahunanApril + $ItemHRDGADCCutiKhususApril;
        //April
        //Mei
        $ItemHRDGADCSakitMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemHRDGADCIjinMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemHRDGADCAlpaMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemHRDGADCCutiTahunanMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemHRDGADCCutiKhususMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemHRDGADCCutiMei = $ItemHRDGADCCutiTahunanMei + $ItemHRDGADCCutiKhususMei;
        //Mei
        //Juni
        $ItemHRDGADCSakitJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemHRDGADCIjinJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemHRDGADCAlpaJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemHRDGADCCutiTahunanJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemHRDGADCCutiKhususJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemHRDGADCCutiJuni = $ItemHRDGADCCutiTahunanJuni + $ItemHRDGADCCutiKhususJuni;
        //Juni
        //Juli
        $ItemHRDGADCSakitJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemHRDGADCIjinJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemHRDGADCAlpaJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemHRDGADCCutiTahunanJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemHRDGADCCutiKhususJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemHRDGADCCutiJuli = $ItemHRDGADCCutiTahunanJuli + $ItemHRDGADCCutiKhususJuli;
        //Juli
        //Agustus
        $ItemHRDGADCSakitAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemHRDGADCIjinAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemHRDGADCAlpaAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemHRDGADCCutiTahunanAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemHRDGADCCutiKhususAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemHRDGADCCutiAgustus = $ItemHRDGADCCutiTahunanAgustus + $ItemHRDGADCCutiKhususAgustus;
        //Agustus
        //September
        $ItemHRDGADCSakitSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemHRDGADCIjinSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemHRDGADCAlpaSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemHRDGADCCutiTahunanSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemHRDGADCCutiKhususSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemHRDGADCCutiSeptember = $ItemHRDGADCCutiTahunanSeptember +
            $ItemHRDGADCCutiKhususSeptember;
        //September
        //Oktober
        $ItemHRDGADCSakitOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemHRDGADCIjinOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemHRDGADCAlpaOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemHRDGADCCutiTahunanOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemHRDGADCCutiKhususOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemHRDGADCCutiOktober = $ItemHRDGADCCutiTahunanOktober + $ItemHRDGADCCutiKhususOktober;
        //Oktober
        //November
        $ItemHRDGADCSakitNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemHRDGADCIjinNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemHRDGADCAlpaNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemHRDGADCCutiTahunanNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemHRDGADCCutiKhususNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemHRDGADCCutiNovember = $ItemHRDGADCCutiTahunanNovember +
            $ItemHRDGADCCutiKhususNovember;
        //November
        //Desember
        $ItemHRDGADCSakitDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemHRDGADCIjinDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemHRDGADCAlpaDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemHRDGADCCutiTahunanDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemHRDGADCCutiKhususDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->whereIn('divisions_id', [4, 5, 16])
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemHRDGADCCutiDesember = $ItemHRDGADCCutiTahunanDesember +
            $ItemHRDGADCCutiKhususDesember;
        //Desember
        // HRDGADC

        return view('pages.admin.laporan.absensi.department.hrdgadc', [
            'ItemHRDGADCSakitJanuari' => $ItemHRDGADCSakitJanuari,
            'ItemHRDGADCIjinJanuari' => $ItemHRDGADCIjinJanuari,
            'ItemHRDGADCAlpaJanuari' => $ItemHRDGADCAlpaJanuari,
            'ItemHRDGADCCutiJanuari' => $ItemHRDGADCCutiJanuari,
            'ItemHRDGADCSakitFebruari' => $ItemHRDGADCSakitFebruari,
            'ItemHRDGADCIjinFebruari' => $ItemHRDGADCIjinFebruari,
            'ItemHRDGADCAlpaFebruari' => $ItemHRDGADCAlpaFebruari,
            'ItemHRDGADCCutiFebruari' => $ItemHRDGADCCutiFebruari,
            'ItemHRDGADCSakitMaret' => $ItemHRDGADCSakitMaret,
            'ItemHRDGADCIjinMaret' => $ItemHRDGADCIjinMaret,
            'ItemHRDGADCAlpaMaret' => $ItemHRDGADCAlpaMaret,
            'ItemHRDGADCCutiMaret' => $ItemHRDGADCCutiMaret,
            'ItemHRDGADCSakitApril' => $ItemHRDGADCSakitApril,
            'ItemHRDGADCIjinApril' => $ItemHRDGADCIjinApril,
            'ItemHRDGADCAlpaApril' => $ItemHRDGADCAlpaApril,
            'ItemHRDGADCCutiApril' => $ItemHRDGADCCutiApril,
            'ItemHRDGADCSakitMei' => $ItemHRDGADCSakitMei,
            'ItemHRDGADCIjinMei' => $ItemHRDGADCIjinMei,
            'ItemHRDGADCAlpaMei' => $ItemHRDGADCAlpaMei,
            'ItemHRDGADCCutiMei' => $ItemHRDGADCCutiMei,
            'ItemHRDGADCSakitJuni' => $ItemHRDGADCSakitJuni,
            'ItemHRDGADCIjinJuni' => $ItemHRDGADCIjinJuni,
            'ItemHRDGADCAlpaJuni' => $ItemHRDGADCAlpaJuni,
            'ItemHRDGADCCutiJuni' => $ItemHRDGADCCutiJuni,
            'ItemHRDGADCSakitJuli' => $ItemHRDGADCSakitJuli,
            'ItemHRDGADCIjinJuli' => $ItemHRDGADCIjinJuli,
            'ItemHRDGADCAlpaJuli' => $ItemHRDGADCAlpaJuli,
            'ItemHRDGADCCutiJuli' => $ItemHRDGADCCutiJuli,
            'ItemHRDGADCSakitAgustus' => $ItemHRDGADCSakitAgustus,
            'ItemHRDGADCIjinAgustus' => $ItemHRDGADCIjinAgustus,
            'ItemHRDGADCAlpaAgustus' => $ItemHRDGADCAlpaAgustus,
            'ItemHRDGADCCutiAgustus' => $ItemHRDGADCCutiAgustus,
            'ItemHRDGADCSakitSeptember' => $ItemHRDGADCSakitSeptember,
            'ItemHRDGADCIjinSeptember' => $ItemHRDGADCIjinSeptember,
            'ItemHRDGADCAlpaSeptember' => $ItemHRDGADCAlpaSeptember,
            'ItemHRDGADCCutiSeptember' => $ItemHRDGADCCutiSeptember,
            'ItemHRDGADCSakitOktober' => $ItemHRDGADCSakitOktober,
            'ItemHRDGADCIjinOktober' => $ItemHRDGADCIjinOktober,
            'ItemHRDGADCAlpaOktober' => $ItemHRDGADCAlpaOktober,
            'ItemHRDGADCCutiOktober' => $ItemHRDGADCCutiOktober,
            'ItemHRDGADCSakitNovember' => $ItemHRDGADCSakitNovember,
            'ItemHRDGADCIjinNovember' => $ItemHRDGADCIjinNovember,
            'ItemHRDGADCAlpaNovember' => $ItemHRDGADCAlpaNovember,
            'ItemHRDGADCCutiNovember' => $ItemHRDGADCCutiNovember,
            'ItemHRDGADCSakitDesember' => $ItemHRDGADCSakitDesember,
            'ItemHRDGADCIjinDesember' => $ItemHRDGADCIjinDesember,
            'ItemHRDGADCAlpaDesember' => $ItemHRDGADCAlpaDesember,
            'ItemHRDGADCCutiDesember' => $ItemHRDGADCCutiDesember
        ]);
    }

    public function absensi_department_marketing()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING') {
            abort(403);
        }
        // Marketing
        //Januari
        $ItemMarketingSakitJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemMarketingIjinJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemMarketingAlpaJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemMarketingCutiTahunanJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemMarketingCutiKhususJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemMarketingCutiJanuari = $ItemMarketingCutiTahunanJanuari + $ItemMarketingCutiKhususJanuari;
        //Januari
        //Februari
        $ItemMarketingSakitFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemMarketingIjinFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemMarketingAlpaFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemMarketingCutiTahunanFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemMarketingCutiKhususFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemMarketingCutiFebruari = $ItemMarketingCutiTahunanFebruari +
            $ItemMarketingCutiKhususFebruari;
        //Februari
        //Maret
        $ItemMarketingSakitMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemMarketingIjinMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemMarketingAlpaMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemMarketingCutiTahunanMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemMarketingCutiKhususMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemMarketingCutiMaret = $ItemMarketingCutiTahunanMaret + $ItemMarketingCutiKhususMaret;
        //Maret
        //April
        $ItemMarketingSakitApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemMarketingIjinApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemMarketingAlpaApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemMarketingCutiTahunanApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemMarketingCutiKhususApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemMarketingCutiApril = $ItemMarketingCutiTahunanApril + $ItemMarketingCutiKhususApril;
        //April
        //Mei
        $ItemMarketingSakitMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemMarketingIjinMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemMarketingAlpaMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemMarketingCutiTahunanMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemMarketingCutiKhususMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemMarketingCutiMei = $ItemMarketingCutiTahunanMei + $ItemMarketingCutiKhususMei;
        //Mei
        //Juni
        $ItemMarketingSakitJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemMarketingIjinJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemMarketingAlpaJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemMarketingCutiTahunanJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemMarketingCutiKhususJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemMarketingCutiJuni = $ItemMarketingCutiTahunanJuni + $ItemMarketingCutiKhususJuni;
        //Juni
        //Juli
        $ItemMarketingSakitJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemMarketingIjinJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemMarketingAlpaJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemMarketingCutiTahunanJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemMarketingCutiKhususJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemMarketingCutiJuli = $ItemMarketingCutiTahunanJuli + $ItemMarketingCutiKhususJuli;
        //Juli
        //Agustus
        $ItemMarketingSakitAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemMarketingIjinAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemMarketingAlpaAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemMarketingCutiTahunanAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemMarketingCutiKhususAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemMarketingCutiAgustus = $ItemMarketingCutiTahunanAgustus + $ItemMarketingCutiKhususAgustus;
        //Agustus
        //September
        $ItemMarketingSakitSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemMarketingIjinSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemMarketingAlpaSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemMarketingCutiTahunanSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemMarketingCutiKhususSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemMarketingCutiSeptember = $ItemMarketingCutiTahunanSeptember +
            $ItemMarketingCutiKhususSeptember;
        //September
        //Oktober
        $ItemMarketingSakitOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemMarketingIjinOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemMarketingAlpaOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemMarketingCutiTahunanOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemMarketingCutiKhususOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemMarketingCutiOktober = $ItemMarketingCutiTahunanOktober + $ItemMarketingCutiKhususOktober;
        //Oktober
        //November
        $ItemMarketingSakitNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemMarketingIjinNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemMarketingAlpaNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemMarketingCutiTahunanNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemMarketingCutiKhususNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemMarketingCutiNovember = $ItemMarketingCutiTahunanNovember +
            $ItemMarketingCutiKhususNovember;
        //November
        //Desember
        $ItemMarketingSakitDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemMarketingIjinDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemMarketingAlpaDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemMarketingCutiTahunanDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemMarketingCutiKhususDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '6')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemMarketingCutiDesember = $ItemMarketingCutiTahunanDesember +
            $ItemMarketingCutiKhususDesember;
        //Desember
        // Marketing

        return view('pages.admin.laporan.absensi.department.marketing', [
            'ItemMarketingSakitJanuari' => $ItemMarketingSakitJanuari,
            'ItemMarketingIjinJanuari' => $ItemMarketingIjinJanuari,
            'ItemMarketingAlpaJanuari' => $ItemMarketingAlpaJanuari,
            'ItemMarketingCutiJanuari' => $ItemMarketingCutiJanuari,
            'ItemMarketingSakitFebruari' => $ItemMarketingSakitFebruari,
            'ItemMarketingIjinFebruari' => $ItemMarketingIjinFebruari,
            'ItemMarketingAlpaFebruari' => $ItemMarketingAlpaFebruari,
            'ItemMarketingCutiFebruari' => $ItemMarketingCutiFebruari,
            'ItemMarketingSakitMaret' => $ItemMarketingSakitMaret,
            'ItemMarketingIjinMaret' => $ItemMarketingIjinMaret,
            'ItemMarketingAlpaMaret' => $ItemMarketingAlpaMaret,
            'ItemMarketingCutiMaret' => $ItemMarketingCutiMaret,
            'ItemMarketingSakitApril' => $ItemMarketingSakitApril,
            'ItemMarketingIjinApril' => $ItemMarketingIjinApril,
            'ItemMarketingAlpaApril' => $ItemMarketingAlpaApril,
            'ItemMarketingCutiApril' => $ItemMarketingCutiApril,
            'ItemMarketingSakitMei' => $ItemMarketingSakitMei,
            'ItemMarketingIjinMei' => $ItemMarketingIjinMei,
            'ItemMarketingAlpaMei' => $ItemMarketingAlpaMei,
            'ItemMarketingCutiMei' => $ItemMarketingCutiMei,
            'ItemMarketingSakitJuni' => $ItemMarketingSakitJuni,
            'ItemMarketingIjinJuni' => $ItemMarketingIjinJuni,
            'ItemMarketingAlpaJuni' => $ItemMarketingAlpaJuni,
            'ItemMarketingCutiJuni' => $ItemMarketingCutiJuni,
            'ItemMarketingSakitJuli' => $ItemMarketingSakitJuli,
            'ItemMarketingIjinJuli' => $ItemMarketingIjinJuli,
            'ItemMarketingAlpaJuli' => $ItemMarketingAlpaJuli,
            'ItemMarketingCutiJuli' => $ItemMarketingCutiJuli,
            'ItemMarketingSakitAgustus' => $ItemMarketingSakitAgustus,
            'ItemMarketingIjinAgustus' => $ItemMarketingIjinAgustus,
            'ItemMarketingAlpaAgustus' => $ItemMarketingAlpaAgustus,
            'ItemMarketingCutiAgustus' => $ItemMarketingCutiAgustus,
            'ItemMarketingSakitSeptember' => $ItemMarketingSakitSeptember,
            'ItemMarketingIjinSeptember' => $ItemMarketingIjinSeptember,
            'ItemMarketingAlpaSeptember' => $ItemMarketingAlpaSeptember,
            'ItemMarketingCutiSeptember' => $ItemMarketingCutiSeptember,
            'ItemMarketingSakitOktober' => $ItemMarketingSakitOktober,
            'ItemMarketingIjinOktober' => $ItemMarketingIjinOktober,
            'ItemMarketingAlpaOktober' => $ItemMarketingAlpaOktober,
            'ItemMarketingCutiOktober' => $ItemMarketingCutiOktober,
            'ItemMarketingSakitNovember' => $ItemMarketingSakitNovember,
            'ItemMarketingIjinNovember' => $ItemMarketingIjinNovember,
            'ItemMarketingAlpaNovember' => $ItemMarketingAlpaNovember,
            'ItemMarketingCutiNovember' => $ItemMarketingCutiNovember,
            'ItemMarketingSakitDesember' => $ItemMarketingSakitDesember,
            'ItemMarketingIjinDesember' => $ItemMarketingIjinDesember,
            'ItemMarketingAlpaDesember' => $ItemMarketingAlpaDesember,
            'ItemMarketingCutiDesember' => $ItemMarketingCutiDesember
        ]);
    }

    public function absensi_department_purchasing()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING') {
            abort(403);
        }
        // Purchasing
        //Januari
        $ItemPurchasingSakitJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPurchasingIjinJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPurchasingAlpaJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPurchasingCutiTahunanJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPurchasingCutiKhususJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemPurchasingCutiJanuari = $ItemPurchasingCutiTahunanJanuari + $ItemPurchasingCutiKhususJanuari;
        //Januari
        //Februari
        $ItemPurchasingSakitFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPurchasingIjinFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPurchasingAlpaFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPurchasingCutiTahunanFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPurchasingCutiKhususFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemPurchasingCutiFebruari = $ItemPurchasingCutiTahunanFebruari +
            $ItemPurchasingCutiKhususFebruari;
        //Februari
        //Maret
        $ItemPurchasingSakitMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPurchasingIjinMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPurchasingAlpaMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPurchasingCutiTahunanMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPurchasingCutiKhususMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemPurchasingCutiMaret = $ItemPurchasingCutiTahunanMaret + $ItemPurchasingCutiKhususMaret;
        //Maret
        //April
        $ItemPurchasingSakitApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPurchasingIjinApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPurchasingAlpaApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPurchasingCutiTahunanApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPurchasingCutiKhususApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemPurchasingCutiApril = $ItemPurchasingCutiTahunanApril + $ItemPurchasingCutiKhususApril;
        //April
        //Mei
        $ItemPurchasingSakitMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPurchasingIjinMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPurchasingAlpaMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPurchasingCutiTahunanMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPurchasingCutiKhususMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemPurchasingCutiMei = $ItemPurchasingCutiTahunanMei + $ItemPurchasingCutiKhususMei;
        //Mei
        //Juni
        $ItemPurchasingSakitJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPurchasingIjinJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPurchasingAlpaJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPurchasingCutiTahunanJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPurchasingCutiKhususJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemPurchasingCutiJuni = $ItemPurchasingCutiTahunanJuni + $ItemPurchasingCutiKhususJuni;
        //Juni
        //Juli
        $ItemPurchasingSakitJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPurchasingIjinJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPurchasingAlpaJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPurchasingCutiTahunanJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPurchasingCutiKhususJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemPurchasingCutiJuli = $ItemPurchasingCutiTahunanJuli + $ItemPurchasingCutiKhususJuli;
        //Juli
        //Agustus
        $ItemPurchasingSakitAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPurchasingIjinAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPurchasingAlpaAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPurchasingCutiTahunanAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPurchasingCutiKhususAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemPurchasingCutiAgustus = $ItemPurchasingCutiTahunanAgustus + $ItemPurchasingCutiKhususAgustus;
        //Agustus
        //September
        $ItemPurchasingSakitSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPurchasingIjinSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPurchasingAlpaSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPurchasingCutiTahunanSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPurchasingCutiKhususSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemPurchasingCutiSeptember = $ItemPurchasingCutiTahunanSeptember +
            $ItemPurchasingCutiKhususSeptember;
        //September
        //Oktober
        $ItemPurchasingSakitOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPurchasingIjinOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPurchasingAlpaOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPurchasingCutiTahunanOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPurchasingCutiKhususOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemPurchasingCutiOktober = $ItemPurchasingCutiTahunanOktober + $ItemPurchasingCutiKhususOktober;
        //Oktober
        //November
        $ItemPurchasingSakitNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPurchasingIjinNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPurchasingAlpaNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPurchasingCutiTahunanNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPurchasingCutiKhususNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemPurchasingCutiNovember = $ItemPurchasingCutiTahunanNovember +
            $ItemPurchasingCutiKhususNovember;
        //November
        //Desember
        $ItemPurchasingSakitDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPurchasingIjinDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPurchasingAlpaDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPurchasingCutiTahunanDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPurchasingCutiKhususDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '9')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemPurchasingCutiDesember = $ItemPurchasingCutiTahunanDesember +
            $ItemPurchasingCutiKhususDesember;
        //Desember
        // Purchasing

        return view('pages.admin.laporan.absensi.department.purchasing', [
            'ItemPurchasingSakitJanuari' => $ItemPurchasingSakitJanuari,
            'ItemPurchasingIjinJanuari' => $ItemPurchasingIjinJanuari,
            'ItemPurchasingAlpaJanuari' => $ItemPurchasingAlpaJanuari,
            'ItemPurchasingCutiJanuari' => $ItemPurchasingCutiJanuari,
            'ItemPurchasingSakitFebruari' => $ItemPurchasingSakitFebruari,
            'ItemPurchasingIjinFebruari' => $ItemPurchasingIjinFebruari,
            'ItemPurchasingAlpaFebruari' => $ItemPurchasingAlpaFebruari,
            'ItemPurchasingCutiFebruari' => $ItemPurchasingCutiFebruari,
            'ItemPurchasingSakitMaret' => $ItemPurchasingSakitMaret,
            'ItemPurchasingIjinMaret' => $ItemPurchasingIjinMaret,
            'ItemPurchasingAlpaMaret' => $ItemPurchasingAlpaMaret,
            'ItemPurchasingCutiMaret' => $ItemPurchasingCutiMaret,
            'ItemPurchasingSakitApril' => $ItemPurchasingSakitApril,
            'ItemPurchasingIjinApril' => $ItemPurchasingIjinApril,
            'ItemPurchasingAlpaApril' => $ItemPurchasingAlpaApril,
            'ItemPurchasingCutiApril' => $ItemPurchasingCutiApril,
            'ItemPurchasingSakitMei' => $ItemPurchasingSakitMei,
            'ItemPurchasingIjinMei' => $ItemPurchasingIjinMei,
            'ItemPurchasingAlpaMei' => $ItemPurchasingAlpaMei,
            'ItemPurchasingCutiMei' => $ItemPurchasingCutiMei,
            'ItemPurchasingSakitJuni' => $ItemPurchasingSakitJuni,
            'ItemPurchasingIjinJuni' => $ItemPurchasingIjinJuni,
            'ItemPurchasingAlpaJuni' => $ItemPurchasingAlpaJuni,
            'ItemPurchasingCutiJuni' => $ItemPurchasingCutiJuni,
            'ItemPurchasingSakitJuli' => $ItemPurchasingSakitJuli,
            'ItemPurchasingIjinJuli' => $ItemPurchasingIjinJuli,
            'ItemPurchasingAlpaJuli' => $ItemPurchasingAlpaJuli,
            'ItemPurchasingCutiJuli' => $ItemPurchasingCutiJuli,
            'ItemPurchasingSakitAgustus' => $ItemPurchasingSakitAgustus,
            'ItemPurchasingIjinAgustus' => $ItemPurchasingIjinAgustus,
            'ItemPurchasingAlpaAgustus' => $ItemPurchasingAlpaAgustus,
            'ItemPurchasingCutiAgustus' => $ItemPurchasingCutiAgustus,
            'ItemPurchasingSakitSeptember' => $ItemPurchasingSakitSeptember,
            'ItemPurchasingIjinSeptember' => $ItemPurchasingIjinSeptember,
            'ItemPurchasingAlpaSeptember' => $ItemPurchasingAlpaSeptember,
            'ItemPurchasingCutiSeptember' => $ItemPurchasingCutiSeptember,
            'ItemPurchasingSakitOktober' => $ItemPurchasingSakitOktober,
            'ItemPurchasingIjinOktober' => $ItemPurchasingIjinOktober,
            'ItemPurchasingAlpaOktober' => $ItemPurchasingAlpaOktober,
            'ItemPurchasingCutiOktober' => $ItemPurchasingCutiOktober,
            'ItemPurchasingSakitNovember' => $ItemPurchasingSakitNovember,
            'ItemPurchasingIjinNovember' => $ItemPurchasingIjinNovember,
            'ItemPurchasingAlpaNovember' => $ItemPurchasingAlpaNovember,
            'ItemPurchasingCutiNovember' => $ItemPurchasingCutiNovember,
            'ItemPurchasingSakitDesember' => $ItemPurchasingSakitDesember,
            'ItemPurchasingIjinDesember' => $ItemPurchasingIjinDesember,
            'ItemPurchasingAlpaDesember' => $ItemPurchasingAlpaDesember,
            'ItemPurchasingCutiDesember' => $ItemPurchasingCutiDesember
        ]);
    }

    public function absensi_department_engineering()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING') {
            abort(403);
        }
        // Engineering
        //Januari
        $ItemEngineeringSakitJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemEngineeringIjinJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemEngineeringAlpaJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemEngineeringCutiTahunanJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemEngineeringCutiKhususJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemEngineeringCutiJanuari = $ItemEngineeringCutiTahunanJanuari + $ItemEngineeringCutiKhususJanuari;
        //Januari
        //Februari
        $ItemEngineeringSakitFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemEngineeringIjinFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemEngineeringAlpaFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemEngineeringCutiTahunanFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemEngineeringCutiKhususFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemEngineeringCutiFebruari = $ItemEngineeringCutiTahunanFebruari +
            $ItemEngineeringCutiKhususFebruari;
        //Februari
        //Maret
        $ItemEngineeringSakitMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemEngineeringIjinMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemEngineeringAlpaMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemEngineeringCutiTahunanMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemEngineeringCutiKhususMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemEngineeringCutiMaret = $ItemEngineeringCutiTahunanMaret + $ItemEngineeringCutiKhususMaret;
        //Maret
        //April
        $ItemEngineeringSakitApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemEngineeringIjinApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemEngineeringAlpaApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemEngineeringCutiTahunanApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemEngineeringCutiKhususApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemEngineeringCutiApril = $ItemEngineeringCutiTahunanApril + $ItemEngineeringCutiKhususApril;
        //April
        //Mei
        $ItemEngineeringSakitMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemEngineeringIjinMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemEngineeringAlpaMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemEngineeringCutiTahunanMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemEngineeringCutiKhususMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemEngineeringCutiMei = $ItemEngineeringCutiTahunanMei + $ItemEngineeringCutiKhususMei;
        //Mei
        //Juni
        $ItemEngineeringSakitJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemEngineeringIjinJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemEngineeringAlpaJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemEngineeringCutiTahunanJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemEngineeringCutiKhususJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemEngineeringCutiJuni = $ItemEngineeringCutiTahunanJuni + $ItemEngineeringCutiKhususJuni;
        //Juni
        //Juli
        $ItemEngineeringSakitJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemEngineeringIjinJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemEngineeringAlpaJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemEngineeringCutiTahunanJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemEngineeringCutiKhususJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemEngineeringCutiJuli = $ItemEngineeringCutiTahunanJuli + $ItemEngineeringCutiKhususJuli;
        //Juli
        //Agustus
        $ItemEngineeringSakitAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemEngineeringIjinAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemEngineeringAlpaAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemEngineeringCutiTahunanAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemEngineeringCutiKhususAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemEngineeringCutiAgustus = $ItemEngineeringCutiTahunanAgustus + $ItemEngineeringCutiKhususAgustus;
        //Agustus
        //September
        $ItemEngineeringSakitSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemEngineeringIjinSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemEngineeringAlpaSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemEngineeringCutiTahunanSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemEngineeringCutiKhususSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemEngineeringCutiSeptember = $ItemEngineeringCutiTahunanSeptember +
            $ItemEngineeringCutiKhususSeptember;
        //September
        //Oktober
        $ItemEngineeringSakitOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemEngineeringIjinOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemEngineeringAlpaOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemEngineeringCutiTahunanOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemEngineeringCutiKhususOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemEngineeringCutiOktober = $ItemEngineeringCutiTahunanOktober + $ItemEngineeringCutiKhususOktober;
        //Oktober
        //November
        $ItemEngineeringSakitNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemEngineeringIjinNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemEngineeringAlpaNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemEngineeringCutiTahunanNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemEngineeringCutiKhususNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemEngineeringCutiNovember = $ItemEngineeringCutiTahunanNovember +
            $ItemEngineeringCutiKhususNovember;
        //November
        //Desember
        $ItemEngineeringSakitDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemEngineeringIjinDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemEngineeringAlpaDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemEngineeringCutiTahunanDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemEngineeringCutiKhususDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '7')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemEngineeringCutiDesember = $ItemEngineeringCutiTahunanDesember +
            $ItemEngineeringCutiKhususDesember;
        //Desember
        // Engineering

        return view('pages.admin.laporan.absensi.department.engineering', [
            'ItemEngineeringSakitJanuari' => $ItemEngineeringSakitJanuari,
            'ItemEngineeringIjinJanuari' => $ItemEngineeringIjinJanuari,
            'ItemEngineeringAlpaJanuari' => $ItemEngineeringAlpaJanuari,
            'ItemEngineeringCutiJanuari' => $ItemEngineeringCutiJanuari,
            'ItemEngineeringSakitFebruari' => $ItemEngineeringSakitFebruari,
            'ItemEngineeringIjinFebruari' => $ItemEngineeringIjinFebruari,
            'ItemEngineeringAlpaFebruari' => $ItemEngineeringAlpaFebruari,
            'ItemEngineeringCutiFebruari' => $ItemEngineeringCutiFebruari,
            'ItemEngineeringSakitMaret' => $ItemEngineeringSakitMaret,
            'ItemEngineeringIjinMaret' => $ItemEngineeringIjinMaret,
            'ItemEngineeringAlpaMaret' => $ItemEngineeringAlpaMaret,
            'ItemEngineeringCutiMaret' => $ItemEngineeringCutiMaret,
            'ItemEngineeringSakitApril' => $ItemEngineeringSakitApril,
            'ItemEngineeringIjinApril' => $ItemEngineeringIjinApril,
            'ItemEngineeringAlpaApril' => $ItemEngineeringAlpaApril,
            'ItemEngineeringCutiApril' => $ItemEngineeringCutiApril,
            'ItemEngineeringSakitMei' => $ItemEngineeringSakitMei,
            'ItemEngineeringIjinMei' => $ItemEngineeringIjinMei,
            'ItemEngineeringAlpaMei' => $ItemEngineeringAlpaMei,
            'ItemEngineeringCutiMei' => $ItemEngineeringCutiMei,
            'ItemEngineeringSakitJuni' => $ItemEngineeringSakitJuni,
            'ItemEngineeringIjinJuni' => $ItemEngineeringIjinJuni,
            'ItemEngineeringAlpaJuni' => $ItemEngineeringAlpaJuni,
            'ItemEngineeringCutiJuni' => $ItemEngineeringCutiJuni,
            'ItemEngineeringSakitJuli' => $ItemEngineeringSakitJuli,
            'ItemEngineeringIjinJuli' => $ItemEngineeringIjinJuli,
            'ItemEngineeringAlpaJuli' => $ItemEngineeringAlpaJuli,
            'ItemEngineeringCutiJuli' => $ItemEngineeringCutiJuli,
            'ItemEngineeringSakitAgustus' => $ItemEngineeringSakitAgustus,
            'ItemEngineeringIjinAgustus' => $ItemEngineeringIjinAgustus,
            'ItemEngineeringAlpaAgustus' => $ItemEngineeringAlpaAgustus,
            'ItemEngineeringCutiAgustus' => $ItemEngineeringCutiAgustus,
            'ItemEngineeringSakitSeptember' => $ItemEngineeringSakitSeptember,
            'ItemEngineeringIjinSeptember' => $ItemEngineeringIjinSeptember,
            'ItemEngineeringAlpaSeptember' => $ItemEngineeringAlpaSeptember,
            'ItemEngineeringCutiSeptember' => $ItemEngineeringCutiSeptember,
            'ItemEngineeringSakitOktober' => $ItemEngineeringSakitOktober,
            'ItemEngineeringIjinOktober' => $ItemEngineeringIjinOktober,
            'ItemEngineeringAlpaOktober' => $ItemEngineeringAlpaOktober,
            'ItemEngineeringCutiOktober' => $ItemEngineeringCutiOktober,
            'ItemEngineeringSakitNovember' => $ItemEngineeringSakitNovember,
            'ItemEngineeringIjinNovember' => $ItemEngineeringIjinNovember,
            'ItemEngineeringAlpaNovember' => $ItemEngineeringAlpaNovember,
            'ItemEngineeringCutiNovember' => $ItemEngineeringCutiNovember,
            'ItemEngineeringSakitDesember' => $ItemEngineeringSakitDesember,
            'ItemEngineeringIjinDesember' => $ItemEngineeringIjinDesember,
            'ItemEngineeringAlpaDesember' => $ItemEngineeringAlpaDesember,
            'ItemEngineeringCutiDesember' => $ItemEngineeringCutiDesember
        ]);
    }

    public function absensi_department_quality()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING') {
            abort(403);
        }
        // Quality
        //Januari
        $ItemQualitySakitJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemQualityIjinJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemQualityAlpaJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemQualityCutiTahunanJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemQualityCutiKhususJanuari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-01-01', '2022-01-31'])
            ->count();
        $ItemQualityCutiJanuari = $ItemQualityCutiTahunanJanuari + $ItemQualityCutiKhususJanuari;
        //Januari
        //Februari
        $ItemQualitySakitFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemQualityIjinFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemQualityAlpaFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemQualityCutiTahunanFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemQualityCutiKhususFebruari =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-02-01', '2022-02-28'])
            ->count();
        $ItemQualityCutiFebruari = $ItemQualityCutiTahunanFebruari +
            $ItemQualityCutiKhususFebruari;
        //Februari
        //Maret
        $ItemQualitySakitMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemQualityIjinMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemQualityAlpaMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemQualityCutiTahunanMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemQualityCutiKhususMaret =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-03-01', '2022-03-31'])
            ->count();
        $ItemQualityCutiMaret = $ItemQualityCutiTahunanMaret + $ItemQualityCutiKhususMaret;
        //Maret
        //April
        $ItemQualitySakitApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemQualityIjinApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemQualityAlpaApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemQualityCutiTahunanApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemQualityCutiKhususApril =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-04-01', '2022-04-30'])
            ->count();
        $ItemQualityCutiApril = $ItemQualityCutiTahunanApril + $ItemQualityCutiKhususApril;
        //April
        //Mei
        $ItemQualitySakitMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemQualityIjinMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemQualityAlpaMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemQualityCutiTahunanMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemQualityCutiKhususMei =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-05-01', '2022-05-31'])
            ->count();
        $ItemQualityCutiMei = $ItemQualityCutiTahunanMei + $ItemQualityCutiKhususMei;
        //Mei
        //Juni
        $ItemQualitySakitJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemQualityIjinJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemQualityAlpaJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemQualityCutiTahunanJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemQualityCutiKhususJuni =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-06-01', '2022-06-30'])
            ->count();
        $ItemQualityCutiJuni = $ItemQualityCutiTahunanJuni + $ItemQualityCutiKhususJuni;
        //Juni
        //Juli
        $ItemQualitySakitJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemQualityIjinJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemQualityAlpaJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemQualityCutiTahunanJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemQualityCutiKhususJuli =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-07-01', '2022-07-31'])
            ->count();
        $ItemQualityCutiJuli = $ItemQualityCutiTahunanJuli + $ItemQualityCutiKhususJuli;
        //Juli
        //Agustus
        $ItemQualitySakitAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemQualityIjinAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemQualityAlpaAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemQualityCutiTahunanAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemQualityCutiKhususAgustus =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-08-01', '2022-08-31'])
            ->count();
        $ItemQualityCutiAgustus = $ItemQualityCutiTahunanAgustus + $ItemQualityCutiKhususAgustus;
        //Agustus
        //September
        $ItemQualitySakitSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemQualityIjinSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemQualityAlpaSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemQualityCutiTahunanSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemQualityCutiKhususSeptember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-09-01', '2022-09-30'])
            ->count();
        $ItemQualityCutiSeptember = $ItemQualityCutiTahunanSeptember +
            $ItemQualityCutiKhususSeptember;
        //September
        //Oktober
        $ItemQualitySakitOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemQualityIjinOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemQualityAlpaOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemQualityCutiTahunanOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemQualityCutiKhususOktober =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-10-01', '2022-10-31'])
            ->count();
        $ItemQualityCutiOktober = $ItemQualityCutiTahunanOktober + $ItemQualityCutiKhususOktober;
        //Oktober
        //November
        $ItemQualitySakitNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemQualityIjinNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemQualityAlpaNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemQualityCutiTahunanNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemQualityCutiKhususNovember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-11-01', '2022-11-30'])
            ->count();
        $ItemQualityCutiNovember = $ItemQualityCutiTahunanNovember +
            $ItemQualityCutiKhususNovember;
        //November
        //Desember
        $ItemQualitySakitDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Sakit')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemQualityIjinDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Ijin')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemQualityAlpaDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Alpa')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemQualityCutiTahunanDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Tahunan')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemQualityCutiKhususDesember =
            DB::table('attendances')
            ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->where('divisions_id', '8')
            ->where('keterangan_absen', 'Cuti Khusus')
            ->whereBetween('tanggal_absen', ['2022-12-01', '2022-12-31'])
            ->count();
        $ItemQualityCutiDesember = $ItemQualityCutiTahunanDesember +
            $ItemQualityCutiKhususDesember;
        //Desember
        // Quality

        return view('pages.admin.laporan.absensi.department.quality', [
            'ItemQualitySakitJanuari' => $ItemQualitySakitJanuari,
            'ItemQualityIjinJanuari' => $ItemQualityIjinJanuari,
            'ItemQualityAlpaJanuari' => $ItemQualityAlpaJanuari,
            'ItemQualityCutiJanuari' => $ItemQualityCutiJanuari,
            'ItemQualitySakitFebruari' => $ItemQualitySakitFebruari,
            'ItemQualityIjinFebruari' => $ItemQualityIjinFebruari,
            'ItemQualityAlpaFebruari' => $ItemQualityAlpaFebruari,
            'ItemQualityCutiFebruari' => $ItemQualityCutiFebruari,
            'ItemQualitySakitMaret' => $ItemQualitySakitMaret,
            'ItemQualityIjinMaret' => $ItemQualityIjinMaret,
            'ItemQualityAlpaMaret' => $ItemQualityAlpaMaret,
            'ItemQualityCutiMaret' => $ItemQualityCutiMaret,
            'ItemQualitySakitApril' => $ItemQualitySakitApril,
            'ItemQualityIjinApril' => $ItemQualityIjinApril,
            'ItemQualityAlpaApril' => $ItemQualityAlpaApril,
            'ItemQualityCutiApril' => $ItemQualityCutiApril,
            'ItemQualitySakitMei' => $ItemQualitySakitMei,
            'ItemQualityIjinMei' => $ItemQualityIjinMei,
            'ItemQualityAlpaMei' => $ItemQualityAlpaMei,
            'ItemQualityCutiMei' => $ItemQualityCutiMei,
            'ItemQualitySakitJuni' => $ItemQualitySakitJuni,
            'ItemQualityIjinJuni' => $ItemQualityIjinJuni,
            'ItemQualityAlpaJuni' => $ItemQualityAlpaJuni,
            'ItemQualityCutiJuni' => $ItemQualityCutiJuni,
            'ItemQualitySakitJuli' => $ItemQualitySakitJuli,
            'ItemQualityIjinJuli' => $ItemQualityIjinJuli,
            'ItemQualityAlpaJuli' => $ItemQualityAlpaJuli,
            'ItemQualityCutiJuli' => $ItemQualityCutiJuli,
            'ItemQualitySakitAgustus' => $ItemQualitySakitAgustus,
            'ItemQualityIjinAgustus' => $ItemQualityIjinAgustus,
            'ItemQualityAlpaAgustus' => $ItemQualityAlpaAgustus,
            'ItemQualityCutiAgustus' => $ItemQualityCutiAgustus,
            'ItemQualitySakitSeptember' => $ItemQualitySakitSeptember,
            'ItemQualityIjinSeptember' => $ItemQualityIjinSeptember,
            'ItemQualityAlpaSeptember' => $ItemQualityAlpaSeptember,
            'ItemQualityCutiSeptember' => $ItemQualityCutiSeptember,
            'ItemQualitySakitOktober' => $ItemQualitySakitOktober,
            'ItemQualityIjinOktober' => $ItemQualityIjinOktober,
            'ItemQualityAlpaOktober' => $ItemQualityAlpaOktober,
            'ItemQualityCutiOktober' => $ItemQualityCutiOktober,
            'ItemQualitySakitNovember' => $ItemQualitySakitNovember,
            'ItemQualityIjinNovember' => $ItemQualityIjinNovember,
            'ItemQualityAlpaNovember' => $ItemQualityAlpaNovember,
            'ItemQualityCutiNovember' => $ItemQualityCutiNovember,
            'ItemQualitySakitDesember' => $ItemQualitySakitDesember,
            'ItemQualityIjinDesember' => $ItemQualityIjinDesember,
            'ItemQualityAlpaDesember' => $ItemQualityAlpaDesember,
            'ItemQualityCutiDesember' => $ItemQualityCutiDesember
        ]);
    }
    //ABSENSI DEPARTMENT

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

    //INVENTARIS MOTOR
    public function inventaris_motor()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        $inventorymotors = InventoryMotorcycles::with([
            'employees'
        ])->orderBy('tanggal_akhir_pajak_motor', 'ASC')->get();

        $this->fpdf = new FPDF('P', 'mm', 'A4');
        $this->fpdf->AddPage();

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', '18');
        $this->fpdf->Cell(190, 5, 'DATA INVENTARIS MOTOR', 0, 1, 'C');
        $this->fpdf->Ln(10);

        $this->fpdf->Cell(0.1);
        $this->fpdf->SetFont('Arial', 'B', '12');
        $this->fpdf->SetFillColor(192, 192, 192); // Warna sel tabel header
        $this->fpdf->Cell(8, 10, 'No', 1, 0, 'C', 1);
        $this->fpdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $this->fpdf->Cell(45, 10, 'Merk/Type', 1, 0, 'C', 1);
        $this->fpdf->Cell(25, 10, 'No Polisi', 1, 0, 'C', 1);
        $this->fpdf->Cell(32, 10, 'Akhir Pajak', 1, 0, 'C', 1);
        $this->fpdf->Cell(32, 10, 'Akhir Plat', 1, 0, 'C', 1);

        $no = 1;

        foreach ($inventorymotors as $inventorymotor) {
            $this->fpdf->Ln();
            $this->fpdf->Cell(0.1);
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(8, 8, $no, 1, 0, 'C');
            $this->fpdf->Cell(55, 8, $inventorymotor->employees->nama_karyawan, 1, 0, 'L');
            $this->fpdf->Cell(45, 8, $inventorymotor->merk_motor . '/' . $inventorymotor->type_motor, 1, 0, 'C');
            $this->fpdf->Cell(25, 8, $inventorymotor->nomor_polisi, 1, 0, 'C');
            $this->fpdf->Cell(32, 8, \Carbon\Carbon::parse($inventorymotor->tanggal_akhir_pajak_motor)->isoformat(' D MMMM Y'), 1, 0, 'C');
            $this->fpdf->Cell(32, 8, \Carbon\Carbon::parse($inventorymotor->tanggal_akhir_plat_motor)->isoformat(' D MMMM Y'), 1, 0, 'C');
            $no++;
        }

        $this->fpdf->Output();
        exit;
    }
    //INVENTARIS MOTOR

    //INVENTARIS MOBIL
    public function inventaris_mobil()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        $inventorymobils = InventoryCars::with([
            'employees'
        ])->orderBy('tanggal_akhir_pajak_mobil', 'ASC')->get();

        $this->fpdf = new FPDF('P', 'mm', 'A4');
        $this->fpdf->AddPage();

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', '18');
        $this->fpdf->Cell(190, 5, 'DATA INVENTARIS MOBIL', 0, 1, 'C');
        $this->fpdf->Ln(10);

        $this->fpdf->Cell(0.1);
        $this->fpdf->SetFont('Arial', 'B', '12');
        $this->fpdf->SetFillColor(192, 192, 192); // Warna sel tabel header
        $this->fpdf->Cell(8, 10, 'No', 1, 0, 'C', 1);
        $this->fpdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $this->fpdf->Cell(45, 10, 'Merk/Type', 1, 0, 'C', 1);
        $this->fpdf->Cell(25, 10, 'No Polisi', 1, 0, 'C', 1);
        $this->fpdf->Cell(32, 10, 'Akhir Pajak', 1, 0, 'C', 1);
        $this->fpdf->Cell(32, 10, 'Akhir Plat', 1, 0, 'C', 1);

        $no = 1;

        foreach ($inventorymobils as $inventorymobil) {
            $this->fpdf->Ln();
            $this->fpdf->Cell(0.1);
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(8, 8, $no, 1, 0, 'C');
            $this->fpdf->Cell(55, 8, $inventorymobil->employees->nama_karyawan, 1, 0, 'L');
            $this->fpdf->Cell(45, 8, $inventorymobil->merk_mobil . '/' . $inventorymobil->type_mobil, 1, 0, 'C');
            $this->fpdf->Cell(25, 8, $inventorymobil->nomor_polisi, 1, 0, 'C');
            $this->fpdf->Cell(32, 8, \Carbon\Carbon::parse($inventorymobil->tanggal_akhir_pajak_mobil)->isoformat(' D MMMM Y'), 1, 0, 'C');
            $this->fpdf->Cell(32, 8, \Carbon\Carbon::parse($inventorymobil->tanggal_akhir_plat_mobil)->isoformat(' D MMMM Y'), 1, 0, 'C');
            $no++;
        }

        $this->fpdf->Output();
        exit;
    }
    //INVENTARIS MOBIL

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
