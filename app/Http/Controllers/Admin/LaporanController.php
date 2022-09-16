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
// use App\Http\Requests\Admin\LaporanKaryawanMasukRequest;
// use App\Http\Requests\Admin\LaporanAbsensiKaryawanRequest;
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
