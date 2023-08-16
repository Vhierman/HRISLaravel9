<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CariOvertimeRequest;
use App\Http\Requests\Admin\CariOvertimeDateRequest;
use App\Http\Requests\Admin\OvertimeRequest;
use App\Http\Requests\Admin\EditOvertimeRequest;
use App\Http\Requests\Admin\EditOvertimeDateRequest;
use App\Http\Requests\Admin\SlipKaryawanOvertimeRequest;
use App\Http\Requests\Admin\RekapOvertimePKWTTRequest;
use App\Http\Requests\Admin\RekapOvertimePkwtHarianRequest;
use App\Models\Admin\Overtimes;
use App\Models\Admin\Employees;
use App\Models\Admin\HistorySalaries;
use App\Models\Admin\RekapSalaries;
use App\Models\Admin\Companies;
use App\Models\Admin\Areas;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use Illuminate\Http\Request;
use Carbon\Carbon;
use File;
use Storage;
use Codedge\Fpdf\Fpdf\Fpdf;
use DB;
use Alert;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'ACCOUNTING'  && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }
        return view('pages.admin.overtime.index');
    }

    public function lihat_overtime()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING'  && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }
        return view('pages.admin.overtime.cariovertime');
    }

    public function tampil_overtime(CariOvertimeRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $awal           = $request->input('awal');
        $akhir          = $request->input('akhir');

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Produksi
        if ($divisi == 11) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [11])
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //PDC
        elseif ($divisi == 19) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [19, 20, 21, 22])
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //IC
        elseif ($divisi == 2) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [2])
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //Engineering
        elseif ($divisi == 7) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [7])
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //Quality
        elseif ($divisi == 8) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [8])
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //Purchasing
        elseif ($divisi == 9) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [9])
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //PPC
        elseif ($divisi == 10) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [12, 13, 14, 15, 18])
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //HRD-GA
        elseif ($divisi == 4) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //Accounting
        elseif ($divisi == 1) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        } else {
            abort(403);
        }

        if (!$items->isEmpty()) {
            return view('pages.admin.overtime.tampilovertime', [
                'items' => $items
            ]);
        } else {
            Alert::error('Data Tidak Ditemukan');
            //Redirect
            return redirect()->route('overtime.lihat_overtime');
        }
    }

    public function form_approve_overtime()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        return view('pages.admin.overtime.formapproveovertime');
    }

    public function tampil_approve_overtime(CariOvertimeRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $awal           = $request->input('awal');
        $akhir          = $request->input('akhir');

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Produksi
        if ($divisi == 11) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [11])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //PDC
        elseif ($divisi == 19) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [19, 20, 21, 22])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //IC
        elseif ($divisi == 2) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [2])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //Engineering
        elseif ($divisi == 7) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [7])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //Quality
        elseif ($divisi == 8) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [8])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //Purchasing
        elseif ($divisi == 9) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [9])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //PPC
        elseif ($divisi == 10) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [12, 13, 14, 15, 18])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //HRD-GA
        elseif ($divisi == 4) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')

                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')

                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('overtimes.tanggal_lembur', [$awal, $akhir])->get();

        } else {
            abort(403);
        }

        if (!$items->isEmpty()) {
            return view('pages.admin.overtime.tampilapprovalovertime', [
                'items' => $items,
                'awal'  => $awal,
                'akhir' => $akhir
            ]);
        } else {
            Alert::error('Data Tidak Ditemukan');
            //Redirect
            return redirect()->route('overtime.form_approve_overtime');
        }
    }

    public function edit_approval($id)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')

                ->select('overtimes.id', 'employees.nik_karyawan','employees.nama_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')

                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->where('overtimes.id', $id)->first();

        return view('pages.admin.overtime.tampil_edit_approve_overtime', [
            'items' => $items
        ]);
    }

    public function proses_approve_overtime(CariOvertimeRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $awal   = $request->input('awal');
        $akhir  = $request->input('akhir');

        // TimeStamp
        $waktu_acc_hrd      = Carbon::now()->toDateTimeString();
        // TimeStamp

        $overtimes          = Overtimes::whereBetween('tanggal_lembur', [$awal, $akhir])

            ->update([
                'acc_hrd'       => auth()->user()->name,
                'waktu_acc_hrd' => $waktu_acc_hrd
            ]);

        Alert::success('Success Approve Data Lembur', 'Oleh ' . auth()->user()->name);
        return redirect()->route('overtime.index');
    }

    public function proses_delete_overtime_date(CariOvertimeDateRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $tanggal_lembur     = $request->input('tanggal_lembur');
        $divisions          = $request->input('divisions');

        // TimeStamp
        $waktu_acc_hrd      = Carbon::now()->toDateTimeString();
        $hapus_oleh         = 'Gufron Naka Santoro';
        // TimeStamp

        $datadeleteovertimedate =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')

                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->where('divisions_id', $divisions)
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->where('overtimes.tanggal_lembur', $tanggal_lembur)->update([
                    'overtimes.deleted_at' => $waktu_acc_hrd,
                    'overtimes.hapus_oleh' => $hapus_oleh
                ]);


        Alert::success('Success Delete Data Lembur', 'Oleh ' . auth()->user()->name);
        return redirect()->route('overtime.index');
    }
    
    public function form_cancel_approve_overtime()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        return view('pages.admin.overtime.formcancelapproveovertime');
    }

    public function tampil_cancel_approve_overtime(CariOvertimeRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $awal           = $request->input('awal');
        $akhir          = $request->input('akhir');

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Produksi
        if ($divisi == 11) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [11])
                ->where('overtimes.acc_hrd', '<>', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //PDC
        elseif ($divisi == 19) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [19, 20, 21, 22])
                ->where('overtimes.acc_hrd', '<>', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //IC
        elseif ($divisi == 2) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [2])
                ->where('overtimes.acc_hrd', '<>', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //Engineering
        elseif ($divisi == 7) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [7])
                ->where('overtimes.acc_hrd', '<>', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //Quality
        elseif ($divisi == 8) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [8])
                ->where('overtimes.acc_hrd', '<>', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //Purchasing
        elseif ($divisi == 9) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [9])
                ->where('overtimes.acc_hrd', '<>', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //PPC
        elseif ($divisi == 10) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->whereIn('divisions_id', [12, 13, 14, 15, 18])
                ->where('overtimes.acc_hrd', '<>', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        }
        //HRD-GA
        elseif ($divisi == 4) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->where('overtimes.acc_hrd', '<>', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereBetween('tanggal_lembur', [$awal, $akhir])->get();
        } else {
            abort(403);
        }

        if (!$items->isEmpty()) {
            return view('pages.admin.overtime.tampilcancelapprovalovertime', [
                'items' => $items,
                'awal'  => $awal,
                'akhir' => $akhir
            ]);
        } else {
            Alert::error('Data Tidak Ditemukan');
            //Redirect
            return redirect()->route('overtime.lihat_overtime');
        }
    }

    public function proses_cancel_approve_overtime(CariOvertimeRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $awal   = $request->input('awal');
        $akhir  = $request->input('akhir');
        // TimeStamp
        $waktu_acc_hrd      = Carbon::now()->toDateTimeString();
        // TimeStamp

        $overtimes          = Overtimes::whereBetween('tanggal_lembur', [$awal, $akhir])

            ->update([
                'acc_hrd'       => NULL,
                'waktu_acc_hrd' => NULL
            ]);

        Alert::success('Success Cancel Approve Data Lembur', 'Oleh ' . auth()->user()->name);
        //Redirect
        return redirect()->route('overtime.index');
    }

    public function edit_overtime()
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }
        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Produksi
        if ($divisi == 11) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [11])
                ->get();
        }
        //PDC
        elseif ($divisi == 19) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [19, 20, 21, 22])
                ->get();
        }
        //IC
        elseif ($divisi == 2) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [2])
                ->get();
        }
        //Engineering
        elseif ($divisi == 7) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [7])
                ->get();
        }
        //Quality
        elseif ($divisi == 8) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [8])
                ->get();
        }
        //Purchasing
        elseif ($divisi == 9) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [9])
                ->get();
        }
        //PPC
        elseif ($divisi == 10) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [12, 13, 14, 15, 18])
                ->get();
        }
        //HRD-GA
        elseif ($divisi == 4) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->get();
        } else {
            abort(403);
        }

        if (!$items->isEmpty()) {
            return view('pages.admin.overtime.editovertime', [
                'items'     => $items,
                'divisi'    => $divisi
            ]);
        } else {
            Alert::error('Data Overtimes Karyawan Sudah Di Approve Semua');
            return redirect()->route('overtime.index');
        }
    }

    public function tampiledit_overtime(EditOvertimeRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $employees_id       = $request->input('employees_id');
        $tanggal_lembur     = $request->input('tanggal_lembur');
        $divisi             = $request->input('divisi');

        $items = Overtimes::with([
            'employees'
        ])
            ->where('employees_id', $employees_id)
            ->where('tanggal_lembur', $tanggal_lembur)
            ->first();

        if ($items == null) {
            Alert::error('Data yang anda cari tidak ada');
            return redirect()->route('overtime.index');
        } else {
            return view('pages.admin.overtime.tampileditovertime', [
                'items'     => $items,
                'divisi'    => $divisi
            ]);
        }
    }

    public function form_hapus_overtime()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Produksi
        if ($divisi == 11) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [11])
                ->get();
        }
        //PDC
        elseif ($divisi == 19) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [19, 20, 21, 22])
                ->get();
        }
        //IC
        elseif ($divisi == 2) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [2])
                ->get();
        }
        //Engineering
        elseif ($divisi == 7) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [7])
                ->get();
        }
        //Quality
        elseif ($divisi == 8) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [8])
                ->get();
        }
        //Purchasing
        elseif ($divisi == 9) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [9])
                ->get();
        }
        //PPC
        elseif ($divisi == 10) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [12, 13, 14, 15, 18])
                ->get();
        }
        //HRD-GA
        elseif ($divisi == 4) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->get();
        } else {
            abort(403);
        }
        if (!$items->isEmpty()) {
            return view('pages.admin.overtime.formhapusovertime', [
                'items'     => $items
            ]);
        } else {
            Alert::error('Data Tidak Ditemukan, Data Sudah Di Approve');
            //Redirect
            return redirect()->route('overtime.index');
        }
    }

    public function form_hapus_overtime_date()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;
        $divisions      = Divisions::all();

        //Produksi
        if ($divisi == 11) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [11])
                ->get();
        }
        //PDC
        elseif ($divisi == 19) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [19, 20, 21, 22])
                ->get();
        }
        //IC
        elseif ($divisi == 2) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [2])
                ->get();
        }
        //Engineering
        elseif ($divisi == 7) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [7])
                ->get();
        }
        //Quality
        elseif ($divisi == 8) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [8])
                ->get();
        }
        //Purchasing
        elseif ($divisi == 9) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [9])
                ->get();
        }
        //PPC
        elseif ($divisi == 10) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->whereIn('divisions_id', [12, 13, 14, 15, 18])
                ->get();
        }
        //HRD-GA
        elseif ($divisi == 4) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->join('positions', 'positions.id', '=', 'employees.positions_id')
                ->groupBy('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->select('employees.nik_karyawan', 'employees.nama_karyawan', 'divisions.penempatan', 'positions.jabatan')
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->get();
        } else {
            abort(403);
        }
        if (!$items->isEmpty()) {
            return view('pages.admin.overtime.formhapusovertimedate', [
                'items'     => $items,
                'divisions' => $divisions
            ]);
        } else {
            Alert::error('Data Tidak Ditemukan, Data Sudah Di Approve');
            //Redirect
            return redirect()->route('overtime.index');
        }
    }

    public function tampilhapus_overtime(EditOvertimeRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $employees_id       = $request->input('employees_id');
        $tanggal_lembur     = $request->input('tanggal_lembur');

        $items = Overtimes::with([
            'employees'
        ])
            ->where('employees_id', $employees_id)
            ->where('acc_hrd', NULL)
            ->where('tanggal_lembur', $tanggal_lembur)
            ->first();
        if ($items == null) {
            Alert::error('Data yang anda cari tidak ada');
            return redirect()->route('overtime.index');
        } else {
            return view('pages.admin.overtime.tampilhapusovertime', [
                'items' => $items
            ]);
        }
    }

    public function tampilhapus_overtime_date(EditOvertimeDateRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $divisions      = $request->input('divisions_id');
        $tanggal_lembur = $request->input('tanggal_lembur');

        $nik            = auth()->user()->nik;

        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Produksi
        if ($divisi == 11) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [11])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->where('overtimes.tanggal_lembur', $tanggal_lembur)->get();
        }
        //PDC
        elseif ($divisi == 19) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [19, 20, 21, 22])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->where('overtimes.tanggal_lembur', $tanggal_lembur)->get();
        }
        //IC
        elseif ($divisi == 2) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [2])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->where('overtimes.tanggal_lembur', $tanggal_lembur)->get();
        }
        //Engineering
        elseif ($divisi == 7) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [7])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->where('overtimes.tanggal_lembur', $tanggal_lembur)->get();
        }
        //Quality
        elseif ($divisi == 8) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [8])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->where('overtimes.tanggal_lembur', $tanggal_lembur)->get();
        }
        //Purchasing
        elseif ($divisi == 9) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [9])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->where('overtimes.tanggal_lembur', $tanggal_lembur)->get();
        }
        //PPC
        elseif ($divisi == 10) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->whereIn('divisions_id', [12, 13, 14, 15, 18])
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->where('overtimes.tanggal_lembur', $tanggal_lembur)->get();
        }
        //HRD-GA
        elseif ($divisi == 4) {
            $items =
                DB::table('overtimes')
                ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')

                ->select('overtimes.id', 'employees.nama_karyawan','employees.nik_karyawan', 'divisions.penempatan','overtimes.jam_masuk','overtimes.jam_istirahat','overtimes.jam_pulang','overtimes.jam_lembur','overtimes.uang_makan_lembur','overtimes.keterangan_lembur','overtimes.tanggal_lembur','overtimes.jenis_lembur','overtimes.acc_hrd','overtimes.deleted_at')
                ->where('divisions_id', $divisions)
                ->where('overtimes.acc_hrd', NULL)
                ->where('overtimes.deleted_at', NULL)
                ->where('overtimes.tanggal_lembur', $tanggal_lembur)->get();

        } else {
            abort(403);
        }

        if (!$items->isEmpty()) {
            return view('pages.admin.overtime.tampildeleteovertimedate', [
                'items'             => $items,
                'divisions'        => $divisions,
                'tanggal_lembur'    => $tanggal_lembur
            ]);
        } else {
            Alert::error('Data Tidak Ditemukan');
            //Redirect
            return redirect()->route('overtime.form_hapus_overtime_date');
        }
    }
    
    public function form_cetak_slip_overtime()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'MANAGER HRD') {
            abort(403);
        }
        return view('pages.admin.overtime.tampilformslipovertime');
    }

    public function form_cetak_slip_karyawan_overtime()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $items = Employees::with([
            'companies',
            'areas',
            'divisions',
            'positions'
        ])->whereIn('golongans_id', [2, 3])->get();

        return view('pages.admin.overtime.slipkkaryawanovertime', [
            'items'     => $items
        ]);
    }

    public function hasil_slipkaryawan_overtime(SlipKaryawanOvertimeRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $employees_id       = $request->input('employees_id');
        $awal               = $request->input('awal');
        $akhir              = $request->input('akhir');

        // $itemcover = 
        // DB::table('overtimes')
        // ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
        // ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
        // ->join('areas', 'areas.id', '=', 'employees.areas_id')
        // ->join('positions', 'positions.id', '=', 'employees.positions_id')
        // ->join('history_salaries', 'history_salaries.employees_id', '=', 'employees.nik_karyawan')

        // ->where('overtimes.acc_hrd','<>',NULL)
        // ->where('overtimes.employees_id',$employees_id)
        // ->where('overtimes.deleted_at',NULL)
        // ->whereBetween('tanggal_lembur', [$awal, $akhir])
        // ->first();

        $itemcover      =   Employees::with([
            'areas',
            'divisions',
            'positions',
        ])->where('nik_karyawan', $employees_id)->first();

        $itemcoverdua   =   Overtimes::with([
            'employees',
        ])
            ->where('acc_hrd', '<>', NULL)
            ->where('employees_id', $employees_id)
            ->where('deleted_at', NULL)
            ->whereBetween('tanggal_lembur', [$awal, $akhir])
            ->first();

        $bulanawal   = Carbon::parse($awal)->isoformat('M');
        $bulanakhir  = Carbon::parse($akhir)->isoformat('M');
        $tahunawal   = Carbon::parse($awal)->isoformat('YYYY');
        $tahunakhir  = Carbon::parse($akhir)->isoformat('YYYY');

        $itemcoversatu  =   RekapSalaries::with([
            'employees'
        ])->where('employees_id', $employees_id)->whereMonth('periode_awal', $bulanawal)->whereMonth('periode_akhir', $bulanakhir)->whereYear('periode_awal', $tahunawal)->whereYear('periode_akhir', $tahunakhir)->first();

        // $items = 
        //         DB::table('overtimes')
        //         ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
        //         ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
        //         ->join('areas', 'areas.id', '=', 'employees.areas_id')
        //         ->where('overtimes.acc_hrd','<>',NULL)
        //         ->where('overtimes.employees_id',$employees_id)
        //         ->where('overtimes.deleted_at',NULL)
        //         ->whereBetween('tanggal_lembur', [$awal, $akhir])
        //         ->orderBy('tanggal_lembur')
        //         ->get();

        $items =     Overtimes::with([
            'employees',
        ])
            ->where('acc_hrd', '<>', NULL)
            ->where('employees_id', $employees_id)
            ->where('deleted_at', NULL)
            ->whereBetween('tanggal_lembur', [$awal, $akhir])
            ->orderBy('tanggal_lembur')
            ->get();

        $this->fpdf = new FPDF('P', 'cm', array(21, 28));
        $this->fpdf->setTopMargin(0.2);
        $this->fpdf->setLeftMargin(0.6);
        $this->fpdf->AddPage();
        $this->fpdf->SetAutoPageBreak(true);

        $this->fpdf->SetFont('Arial', 'B', '8');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(10, 1, "PT PRIMA KOMPONEN INDONESIA", 0, 0, 'L');
        $this->fpdf->Ln(0.4);
        $this->fpdf->SetFont('Arial', '', '9');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(10, 1, $itemcover->areas->area . " - " . $itemcover->divisions->penempatan . "", 0, 0, 'L');

        $this->fpdf->SetFont('Arial', 'B', '10');
        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(20, 1, "Bukti Tanda Terima Slip Lembur", 0, 0, 'C');

        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(20, 1, "Periode " . \Carbon\Carbon::parse($awal)->isoformat('D MMMM Y') . " s/d " . \Carbon\Carbon::parse($akhir)->isoformat('D MMMM Y') . "", 0, 0, 'C');

        $this->fpdf->Ln(0.6);

        $this->fpdf->SetFont('Arial', '', '8');
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(7, 0.5, "Nama     : " . $itemcover->nama_karyawan . "", 0, 0, 'L');

        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(7, 0.5, "Bagian   : " . $itemcover->positions->jabatan . " / " . $itemcover->divisions->penempatan . "", 0, 0, 'L');

        $this->fpdf->Ln(0.5);

        $this->fpdf->Cell(0.1);
        $this->fpdf->SetFont('Arial', '', '8');
        $this->fpdf->SetFillColor(255, 255, 255); // Warna sel tabel header
        $this->fpdf->Cell(1, 0.8, 'No', 1, 0, 'C', 1);
        $this->fpdf->Cell(2, 0.8, 'Hari', 1, 0, 'C', 1);
        $this->fpdf->Cell(2, 0.8, 'Tanggal', 1, 0, 'C', 1);

        $this->fpdf->Cell(4.5, 0.4, 'Jam Lembur ( Dlm Jam )', 1, 0, 'C', 1);
        $this->fpdf->Cell(1.5, 0.8, '', 1, 0, 'C', 1);

        $this->fpdf->Cell(4, 0.4, 'Perhitungan Jam Lembur', 1, 0, 'C', 1);
        $this->fpdf->Cell(2.2, 0.8, '', 1, 0, 'C', 1);
        $this->fpdf->Cell(2.2, 0.8, '', 1, 0, 'C', 1);

        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(5.1);
        $this->fpdf->Cell(1.5, 0.4, 'Masuk', 1, 0, 'C', 1);
        $this->fpdf->Cell(1.5, 0.4, 'Istirahat', 1, 0, 'C', 1);
        $this->fpdf->Cell(1.5, 0.4, 'Pulang', 1, 0, 'C', 1);

        $this->fpdf->Cell(1.5);
        $this->fpdf->Cell(1, 0.4, '1,5', 1, 0, 'C', 1);
        $this->fpdf->Cell(1, 0.4, '2', 1, 0, 'C', 1);
        $this->fpdf->Cell(1, 0.4, '3', 1, 0, 'C', 1);
        $this->fpdf->Cell(1, 0.4, '4', 1, 0, 'C', 1);

        $this->fpdf->Ln(-0.4);
        $this->fpdf->Cell(9.6);
        $this->fpdf->Cell(1.5, 0.4, 'Jam', 0, 0, 'C');

        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(9.6);
        $this->fpdf->Cell(1.5, 0.4, 'Lembur', 0, 0, 'C');


        $this->fpdf->Ln(-0.4);
        $this->fpdf->Cell(15.4);
        $this->fpdf->Cell(1.5, 0.4, 'Uang Makan', 0, 0, 'C');

        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(15.4);
        $this->fpdf->Cell(1.5, 0.4, 'perhari ( Rp )', 0, 0, 'C');

        $this->fpdf->Ln(-0.4);
        $this->fpdf->Cell(17.6);
        $this->fpdf->Cell(1.5, 0.4, 'U. Transport', 0, 0, 'C');

        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(17.6);
        $this->fpdf->Cell(1.5, 0.4, 'perhari ( Rp )', 0, 0, 'C');

        $no = 1;
        $jumlahjampertama = 0;
        $jumlahjamkedua = 0;
        $jumlahjamketiga = 0;
        $jumlahjamkeempat = 0;
        $jumlahuangmakanlembur = 0;
        $total = 0;

        foreach ($items as $item) {

            $harilembur         = \Carbon\Carbon::parse($item->tanggal_lembur)->isoformat('dddd');
            $tanggallembur      = \Carbon\Carbon::parse($item->tanggal_lembur)->isoformat('DD-MM-Y');
            $tahunlembur        = \Carbon\Carbon::parse($awal)->isoformat('YYYY');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(1, 0.4, $no, 1, 0, 'C');
            $this->fpdf->Cell(2, 0.4, $harilembur, 1, 0, 'C');
            $this->fpdf->Cell(2, 0.4, $tanggallembur, 1, 0, 'C');

            $this->fpdf->Cell(1.5, 0.4, $item->jam_masuk, 1, 0, 'C');
            $this->fpdf->Cell(1.5, 0.4, $item->jam_istirahat, 1, 0, 'C');
            $this->fpdf->Cell(1.5, 0.4, $item->jam_pulang, 1, 0, 'C');
            $this->fpdf->Cell(1.5, 0.4, $item->jam_lembur, 1, 0, 'C');

            $this->fpdf->Cell(1, 0.4, $item->jam_pertama, 1, 0, 'C');
            $this->fpdf->Cell(1, 0.4, $item->jam_kedua, 1, 0, 'C');
            $this->fpdf->Cell(1, 0.4, $item->jam_ketiga, 1, 0, 'C');
            $this->fpdf->Cell(1, 0.4, $item->jam_keempat, 1, 0, 'C');

            $this->fpdf->Cell(2.2, 0.4, number_format($item->uang_makan_lembur), 1, 0, 'C');
            $this->fpdf->Cell(2.2, 0.4, ' - ', 1, 0, 'C');

            $no++;
            $jumlahjampertama += $item->jumlah_jam_pertama;
            $jumlahjamkedua += $item->jumlah_jam_kedua;
            $jumlahjamketiga += $item->jumlah_jam_ketiga;
            $jumlahjamkeempat += $item->jumlah_jam_keempat;
            $jumlahuangmakanlembur += $item->uang_makan_lembur;
        }

        $jumlahjamlembur        = $jumlahjampertama + $jumlahjamkedua + $jumlahjamketiga + $jumlahjamkeempat;
        $jumlahuanglembur       = $jumlahjamlembur * $itemcoversatu->upah_lembur_perjam;
        $jumlahuangditerima     = $jumlahuanglembur + $jumlahuangmakanlembur;

        $this->fpdf->Ln(0.4);
        $this->fpdf->Cell(9.4);
        $this->fpdf->Cell(1.7, 0.4, 'Jumlah Jam', 0, 0, 'L');

        $this->fpdf->Cell(1, 0.4, $jumlahjampertama, 1, 0, 'C');
        $this->fpdf->Cell(1, 0.4, $jumlahjamkedua, 1, 0, 'C');
        $this->fpdf->Cell(1, 0.4, $jumlahjamketiga, 1, 0, 'C');
        $this->fpdf->Cell(1, 0.4, $jumlahjamkeempat, 1, 0, 'C');
        $this->fpdf->Cell(2.2, 0.4, $jumlahuangmakanlembur, 1, 0, 'C');
        $this->fpdf->Cell(2.2, 0.4, " - ", 1, 0, 'C');


        $this->fpdf->Ln(0.2);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5, 0.2, 'Jumlah Jam Lembur', 0, 0, 'L');

        $this->fpdf->Cell(1.5);
        $this->fpdf->Cell(3, 0.2, $jumlahjamlembur, 0, 0, 'C');

        $this->fpdf->Ln(0.3);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5, 0.2, 'Upah Lembur Perjam', 0, 0, 'L');
        $this->fpdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
        $this->fpdf->Cell(3, 0.2, number_format($itemcoversatu->upah_lembur_perjam), 0, 0, 'R');

        $this->fpdf->SetFont('Arial', 'B', '7');
        $this->fpdf->Cell(1.5);
        $this->fpdf->Cell(5, 0.2, 'Note : 0.5 Dlm angka = 30 menit dlm jam ( Jam Istirahat Lembur )', 0, 0, 'L');

        $this->fpdf->Ln(0.3);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(9.5, 0, '', 1, 0, 'L', 1);

        $this->fpdf->SetFont('Arial', '', '8');
        $this->fpdf->Ln(0.1);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5, 0.2, 'Jumlah Uang Lembur', 0, 0, 'L');
        $this->fpdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
        $this->fpdf->Cell(3, 0.2, number_format($jumlahuanglembur), 0, 0, 'R');

        $this->fpdf->Ln(0.3);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5, 0.2, 'Jumlah Uang Makan Lembur', 0, 0, 'L');
        $this->fpdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
        $this->fpdf->Cell(3, 0.2, number_format($jumlahuangmakanlembur), 0, 0, 'R');


        $this->fpdf->Ln(0.3);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5, 0.2, 'Jumlah Uang Transport Lembur', 0, 0, 'L');
        $this->fpdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
        $this->fpdf->Cell(3, 0.2, " - ", 0, 0, 'R');


        $this->fpdf->Ln(0.3);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(9.5, 0, '', 1, 0, 'L', 1);

        $this->fpdf->Ln(0.1);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5, 0.2, 'Jumlah Uang Yang Diterima', 0, 0, 'L');
        $this->fpdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
        $this->fpdf->Cell(3, 0.2, number_format($jumlahuangditerima), 0, 0, 'R');


        $this->fpdf->Ln(1);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5, 0.2, 'Mengetahui', 0, 0, 'L');

        $this->fpdf->Cell(6, 0.2, 'Tangerang Selatan, ............................,' . $tahunlembur, 0, 0, 'L');

        $this->fpdf->Cell(3);
        $this->fpdf->Cell(5.4, 0.2, 'Yang Menerima', 0, 0, 'L');


        $this->fpdf->Ln(2);
        $this->fpdf->Cell(0.1);
        $this->fpdf->Cell(5, 0.2, '(Rudiyanto)', 0, 0, 'L');


        $this->fpdf->Cell(9);
        $this->fpdf->Cell(5.4, 0.2, '(' . $itemcover->nama_karyawan . ')', 0, 0, 'L');


        $this->fpdf->Ln(60);

        $this->fpdf->Output();
        exit;
    }

    public function form_rekap_overtime()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'MANAGER HRD') {
            abort(403);
        }

        return view('pages.admin.overtime.rekapovertimepkwtharian');
    }

    public function form_cetak_rekap_overtime_pkwtt()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'MANAGER HRD') {
            abort(403);
        }

        return view('pages.admin.overtime.formrekapovertimepkwtt');
    }

    public function form_lihat_rekap_overtime_pkwtt(RekapOvertimePKWTTRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'MANAGER HRD') {
            abort(403);
        }

        $golongan       = $request->input('golongan');
        $divisions_id   = $request->input('divisions_id');
        $status_kerja   = $request->input('status_kerja');
        $awal           = $request->input('awal');
        $akhir          = $request->input('akhir');

        $divisi = '';

        if ($divisions_id == 'Produksi') {
            $divisi = array('11');
        } elseif ($divisions_id == 'Office') {
            $divisi = array('1', '2', '3', '4', '5', '6', '7', '9', '17');
        } elseif ($divisions_id == 'PPC') {
            $divisi = array('12', '13', '14', '15', '18', '10');
        } elseif ($divisions_id == 'Quality') {
            $divisi = array('8');
        } elseif ($divisions_id == 'PDC') {
            $divisi = array('19', '20', '21', '22');
        } else {
            abort(403);
        }

        $items = DB::table('overtimes')
            ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
            ->groupBy('employees_id', 'nama_karyawan', 'status_kerja')
            ->select('employees_id', 'nama_karyawan', 'status_kerja', DB::raw('sum(jumlah_jam_pertama) as jumlah_jam_pertama'), DB::raw('sum(jumlah_jam_kedua) as jumlah_jam_kedua'), DB::raw('sum(jumlah_jam_ketiga) as jumlah_jam_ketiga'), DB::raw('sum(jumlah_jam_keempat) as jumlah_jam_keempat'), DB::raw('sum(uang_makan_lembur) as uang_makan_lembur'))
            ->whereIn('divisions_id', $divisi)
            ->where('overtimes.acc_hrd', '<>', NULL)
            ->where('overtimes.deleted_at', NULL)
            ->where('status_kerja', $status_kerja)
            ->where('golongans_id', $golongan)
            ->whereBetween('tanggal_lembur', [$awal, $akhir])
            ->orderBy('nama_karyawan')
            ->get();

        return view('pages.admin.overtime.tampilrekapovertime_pkwtt', [
            'golongan'              => $golongan,
            'divisions_id'          => $divisions_id,
            'status_kerja'          => $status_kerja,
            'items'                 => $items,
            'awal'                  => $awal,
            'akhir'                 => $akhir
        ]);
    }

    public function export_pdf_rekap_overtime_pkwtt(Request $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'MANAGER HRD') {
            abort(403);
        }

        $golongan       = $request->input('golongan');
        $divisions_id   = $request->input('divisions_id');
        $status_kerja   = $request->input('status_kerja');
        $awal           = $request->input('awal');
        $akhir          = $request->input('akhir');

        $divisi = '';

        if ($divisions_id == 'Produksi') {
            $divisi = array('11');
        } elseif ($divisions_id == 'Office') {
            $divisi = array('1', '2', '3', '4', '5', '6', '7', '9', '17');
        } elseif ($divisions_id == 'PPC') {
            $divisi = array('12', '13', '14', '15', '18', '10');
        } elseif ($divisions_id == 'Quality') {
            $divisi = array('8');
        } elseif ($divisions_id == 'PDC') {
            $divisi = array('19', '20', '21', '22');
        } else {
            abort(403);
        }

        $items = DB::table('overtimes')
            ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
            ->groupBy('employees_id', 'nama_karyawan','golongans_id', 'status_kerja','nomor_rekening', 'divisions_id')
            ->select('employees_id', 'nama_karyawan', 'nomor_rekening','golongans_id', 'status_kerja', DB::raw('sum(jumlah_jam_pertama) as jumlah_jam_pertama'), DB::raw('sum(jumlah_jam_kedua) as jumlah_jam_kedua'), DB::raw('sum(jumlah_jam_ketiga) as jumlah_jam_ketiga'), DB::raw('sum(jumlah_jam_keempat) as jumlah_jam_keempat'), DB::raw('sum(uang_makan_lembur) as uang_makan_lembur'))
            ->whereIn('divisions_id', $divisi)
            ->where('overtimes.acc_hrd', '<>', NULL)
            ->where('overtimes.deleted_at', NULL)
            ->where('status_kerja', $status_kerja)
            ->where('golongans_id', $golongan)
            ->whereBetween('tanggal_lembur', [$awal, $akhir])
            ->orderBy('divisions_id')
            ->orderBy('nama_karyawan')
            ->get();

        foreach ($items as $item) {

            $this->fpdf = new FPDF('P', 'cm', array(21, 28));
            $this->fpdf->setTopMargin(0.2);
            $this->fpdf->setLeftMargin(0.2);
            $this->fpdf->SetAutoPageBreak(true);

            $this->fpdf->AddPage();
            $this->fpdf->Cell(20.5, 27.5, '', 0, 0, 'C');
            $this->fpdf->Ln(0.1);

            $this->fpdf->SetFont('Arial', 'B', '8');
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(10, 1, "PT PRIMA KOMPONEN INDONESIA", 0, 0, 'L');
            $this->fpdf->Ln(0.4);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(0.1);

            $this->fpdf->SetFont('Arial', 'B', '10');
            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(20, 1, "Daftar Rekap Lembur Karyawan", 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(20, 1, "Periode " . \Carbon\Carbon::parse($awal)->isoformat('D MMMM Y') . " s/d " . \Carbon\Carbon::parse($akhir)->isoformat('D MMMM Y') . "", 0, 0, 'C');

            $this->fpdf->Ln(0.6);

            $this->fpdf->SetFont('Arial', 'B', '8');
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(7, 0.5, $divisions_id, 0, 0, 'L');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(0.1);
            $this->fpdf->SetFont('Arial', '', '8');
            $this->fpdf->SetFillColor(255, 255, 255); // Warna sel tabel header
            $this->fpdf->Cell(0.6, 0.9, 'No', 1, 0, 'C', 1);
            $this->fpdf->Cell(3.5, 0.9, 'Nama Karyawan', 1, 0, 'C', 1);
            $this->fpdf->Cell(3, 0.9, 'Penempatan', 1, 0, 'C', 1);
            $this->fpdf->Cell(1.5, 0.9, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(1.5, 0.9, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(1.5, 0.9, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(3, 0.9, 'Jumlah Uang Lembur', 1, 0, 'C');
            $this->fpdf->Cell(1.5, 0.9, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(2, 0.9, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(2, 0.9, '', 1, 0, 'C', 1);

            $this->fpdf->Ln(0.1);
            $this->fpdf->Cell(7.5);
            $this->fpdf->Cell(1, 0.5, 'Nomor', 0, 0, 'C');

            $this->fpdf->Ln(0.3);
            $this->fpdf->Cell(7.5);
            $this->fpdf->Cell(1, 0.5, 'Rekening', 0, 0, 'C');

            $this->fpdf->Ln(-0.3);
            $this->fpdf->Cell(9);
            $this->fpdf->Cell(1, 0.5, 'Jam', 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(9);
            $this->fpdf->Cell(1, 0.5, 'Lembur', 0, 0, 'C');

            $this->fpdf->Ln(-0.4);
            $this->fpdf->Cell(10.2);
            $this->fpdf->SetFont('Arial', '', '6.5');
            $this->fpdf->Cell(1.5, 0.5, 'Upah Lembur', 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(10.2);
            $this->fpdf->Cell(1.5, 0.5, 'Perjam', 0, 0, 'C');

            $this->fpdf->Ln(-0.4);
            $this->fpdf->Cell(14.7);
            $this->fpdf->SetFont('Arial', '', '7');
            $this->fpdf->Cell(1.5, 0.5, 'Uang Makan', 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(14.7);
            $this->fpdf->Cell(1.5, 0.5, 'Lembur', 0, 0, 'C');

            $this->fpdf->Ln(-0.4);
            $this->fpdf->Cell(16.3);
            $this->fpdf->SetFont('Arial', '', '6.5');
            $this->fpdf->Cell(1.5, 0.5, 'Jumlah Uang', 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(16.3);
            $this->fpdf->Cell(1.5, 0.5, 'Yang Diterima', 0, 0, 'C');

            $this->fpdf->Ln(-0.4);
            $this->fpdf->Cell(18.3);
            $this->fpdf->SetFont('Arial', '', '6.5');
            $this->fpdf->Cell(1.5, 0.5, 'Hasil Uang', 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(18.3);
            $this->fpdf->Cell(1.5, 0.5, 'Yang Diterima', 0, 0, 'C');

            $no = 1;
            $totaljumlahuanglembur = 0;
            $totaluangmakanlembur = 0;
            $totaljumlahuangditerima = 0;
            $totalhasiluangditerima = 0;

            $bulanawal   = Carbon::parse($awal)->isoformat('MM');
            $bulanakhir  = Carbon::parse($akhir)->isoformat('MM');
            $tahunawal   = Carbon::parse($awal)->isoformat('YYYY');
            $tahunakhir  = Carbon::parse($akhir)->isoformat('YYYY');

            foreach ($items as $item) {

                $jumlahjam = $item->jumlah_jam_pertama + $item->jumlah_jam_kedua + $item->jumlah_jam_ketiga + $item->jumlah_jam_keempat;
                $uangmakanlembur = $item->uang_makan_lembur;


                $collections = DB::table('overtimes')
                    ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                    ->join('rekap_salaries', 'employees.nik_karyawan', '=', 'rekap_salaries.employees_id')
                    ->join('positions', 'positions.id', '=', 'employees.positions_id')
                    ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                    ->join('areas', 'areas.id', '=', 'employees.areas_id')
                    ->where('overtimes.employees_id', $item->employees_id)
                    ->where('overtimes.acc_hrd', '<>', null)
                    ->where('overtimes.deleted_at', null)
                    ->where('rekap_salaries.deleted_at', null)
                    ->where('employees.golongans_id', $golongan)
                    ->whereMonth('rekap_salaries.periode_awal', $bulanawal)
                    ->whereMonth('rekap_salaries.periode_akhir', $bulanakhir)
                    ->whereYear('rekap_salaries.periode_awal', $tahunawal)
                    ->whereYear('rekap_salaries.periode_akhir', $tahunakhir)
                    ->whereBetween('tanggal_lembur', [$awal, $akhir])

                    ->first();

                $namakaryawan = $collections->nama_karyawan;
                $jabatan = $collections->jabatan;
                $penempatan = $collections->penempatan;
                $nomorrekening = $collections->nomor_rekening;
                $area = $collections->area;
                $nomorrekening = $collections->nomor_rekening;
                $upahlemburperjam = $collections->upah_lembur_perjam;
                $jumlahuanglembur = $upahlemburperjam * $jumlahjam;
                $jumlahuangditerima = $jumlahuanglembur + $uangmakanlembur;

                $jumlahuangditerimapembulatan = ceil($jumlahuangditerima);
                // if (substr($jumlahuangditerimapembulatan, -2) <= 0) {
                //     $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2);
                // } else {
                //     $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2) + 100;
                // }

                if (substr($jumlahuangditerimapembulatan, -2) > 50 && substr($jumlahuangditerimapembulatan, -2) < 100) {
                    $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2);
                } elseif (substr($jumlahuangditerimapembulatan, -2) < 50 && substr($jumlahuangditerimapembulatan, -2) > 0) {
                    $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2) + 100;
                } elseif (substr($jumlahuangditerimapembulatan, -2) <= 0) {
                    $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2);
                }
                elseif (substr($jumlahuangditerimapembulatan, -2) == 50) {
                    $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2);
                } else {
                    $total_jumlahuangditerima = 0;
                }


                $this->fpdf->SetFont('Arial', '', '7');
                $this->fpdf->Ln(0.4);
                $this->fpdf->Cell(0.1);
                $this->fpdf->Cell(0.6, 0.4, $no, 1, 0, 'C');
                $this->fpdf->Cell(3.5, 0.4, $namakaryawan, 1, 0, 'L');
                $this->fpdf->Cell(3, 0.4, $penempatan, 1, 0, 'L');
                $this->fpdf->Cell(1.5, 0.4, $nomorrekening, 1, 0, 'C');
                $this->fpdf->Cell(1.5, 0.4, $jumlahjam, 1, 0, 'C');

                $this->fpdf->Cell(1.5, 0.4, number_format($upahlemburperjam), 1, 0, 'C');
                $this->fpdf->Cell(3, 0.4, number_format($jumlahuanglembur), 1, 0, 'R');
                $this->fpdf->Cell(1.5, 0.4, number_format($uangmakanlembur), 1, 0, 'R');
                $this->fpdf->Cell(2, 0.4, number_format($jumlahuangditerima), 1, 0, 'R');
                $this->fpdf->Cell(2, 0.4, number_format($total_jumlahuangditerima), 1, 0, 'R');

                $no++;
                $totaljumlahuanglembur += $jumlahuanglembur;
                $totaluangmakanlembur += $uangmakanlembur;
                $totaljumlahuangditerima += $jumlahuangditerima;
                $totalhasiluangditerima += $total_jumlahuangditerima;
            }
            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(11.7);
            $this->fpdf->Cell(3, 0.4, number_format($totaljumlahuanglembur), 1, 0, 'R');
            $this->fpdf->Cell(1.5, 0.4, number_format($totaluangmakanlembur), 1, 0, 'R');
            $this->fpdf->Cell(2, 0.4, number_format($totaljumlahuangditerima), 1, 0, 'R');
            $this->fpdf->Cell(2, 0.4, number_format($totalhasiluangditerima), 1, 0, 'R');

            $this->fpdf->Ln(0.7);

            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, 'Mengetahui', 0, 0, 'L');

            $this->fpdf->Cell(6, 0.2, 'Tangerang, ........................................,2023', 0, 0, 'L');

            $this->fpdf->Cell(3);
            $this->fpdf->Cell(5.4, 0.2, 'Diperiksa', 0, 0, 'L');


            $this->fpdf->Ln(1.5);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, 'Veronica', 0, 0, 'L');



            $this->fpdf->Cell(9);
            $this->fpdf->Cell(5.4, 0.2, 'Rudiyanto', 0, 0, 'L');

            $this->fpdf->Ln(0.3);
            $this->fpdf->Cell(0.2);
            $this->fpdf->Cell(1, 0, '', 1, 0, 'L', 1);

            $this->fpdf->Cell(13);
            $this->fpdf->Cell(1.1, 0, '', 1, 0, 'L', 1);

            $this->fpdf->Ln(0.1);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, '(Wakil Direktur Accounting,Finance,IC,&IT)', 0, 0, 'L');

            $this->fpdf->Cell(9);
            $this->fpdf->Cell(5, 0.2, '(General Manager HRD-GA)', 0, 0, 'L');

            $this->fpdf->Output();
            exit;
        }
    }

    public function form_cetak_rekap_overtime_pkwt_harian()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'MANAGER HRD') {
            abort(403);
        }

        return view('pages.admin.overtime.formrekapovertimepkwtharian');
    }

    public function form_lihat_rekap_overtime_pkwt_harian(RekapOvertimePkwtHarianRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'MANAGER HRD') {
            abort(403);
        }

        $golongan       = $request->input('golongan');
        $status_kerja   = $request->input('status_kerja');
        $awal           = $request->input('awal');
        $akhir          = $request->input('akhir');

        $items = DB::table('overtimes')
            ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
            ->groupBy('employees_id', 'nama_karyawan','golongans_id', 'status_kerja')
            ->select('employees_id', 'nama_karyawan','golongans_id', 'status_kerja', DB::raw('sum(jumlah_jam_pertama) as jumlah_jam_pertama'), DB::raw('sum(jumlah_jam_kedua) as jumlah_jam_kedua'), DB::raw('sum(jumlah_jam_ketiga) as jumlah_jam_ketiga'), DB::raw('sum(jumlah_jam_keempat) as jumlah_jam_keempat'), DB::raw('sum(uang_makan_lembur) as uang_makan_lembur'))
            ->where('overtimes.acc_hrd', '<>', NULL)
            ->where('overtimes.deleted_at', NULL)
            ->where('status_kerja', $status_kerja)
            ->where('golongans_id', $golongan)
            ->whereBetween('tanggal_lembur', [$awal, $akhir])
            ->orderBy('nama_karyawan')
            ->get();

        return view('pages.admin.overtime.tampilrekapovertimespkwtharian', [
            'golongan'              => $golongan,
            'status_kerja'          => $status_kerja,
            'items'                 => $items,
            'awal'                  => $awal,
            'akhir'                 => $akhir
        ]);
    }

    public function export_pdf_rekap_overtime_pkwt_harian(Request $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'MANAGER HRD') {
            abort(403);
        }

        $golongan       = $request->input('golongan');
        $status_kerja   = $request->input('status_kerja');
        $awal           = $request->input('awal');
        $akhir          = $request->input('akhir');


        $items = DB::table('overtimes')
            ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
            ->groupBy('employees_id', 'nama_karyawan','golongans_id', 'status_kerja', 'divisions_id')
            ->select('employees_id', 'nama_karyawan','golongans_id', 'status_kerja', DB::raw('sum(jumlah_jam_pertama) as jumlah_jam_pertama'), DB::raw('sum(jumlah_jam_kedua) as jumlah_jam_kedua'), DB::raw('sum(jumlah_jam_ketiga) as jumlah_jam_ketiga'), DB::raw('sum(jumlah_jam_keempat) as jumlah_jam_keempat'), DB::raw('sum(uang_makan_lembur) as uang_makan_lembur'))
            ->where('overtimes.acc_hrd', '<>', NULL)
            ->where('overtimes.deleted_at', NULL)
            ->where('status_kerja', $status_kerja)
            ->where('golongans_id', $golongan)
            ->whereBetween('tanggal_lembur', [$awal, $akhir])
            ->orderBy('divisions_id')
            ->orderBy('nama_karyawan')
            ->get();

        foreach ($items as $item) {

            $this->fpdf = new FPDF('P', 'cm', array(21, 28));
            $this->fpdf->setTopMargin(0.2);
            $this->fpdf->setLeftMargin(0.2);
            $this->fpdf->SetAutoPageBreak(true);

            $this->fpdf->AddPage();
            $this->fpdf->Cell(20.5, 27.5, '', 0, 0, 'C');
            $this->fpdf->Ln(0.1);

            $this->fpdf->SetFont('Arial', 'B', '8');
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(10, 1, "PT PRIMA KOMPONEN INDONESIA", 0, 0, 'L');
            $this->fpdf->Ln(0.4);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(0.1);

            $this->fpdf->SetFont('Arial', 'B', '10');
            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(20, 1, "Daftar Rekap Lembur Karyawan", 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(20, 1, "Periode " . \Carbon\Carbon::parse($awal)->isoformat('D MMMM Y') . " s/d " . \Carbon\Carbon::parse($akhir)->isoformat('D MMMM Y') . "", 0, 0, 'C');

            $this->fpdf->Ln(0.6);

            $this->fpdf->SetFont('Arial', 'B', '8');
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(7, 0.5, $status_kerja, 0, 0, 'L');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(0.1);
            $this->fpdf->SetFont('Arial', '', '8');
            $this->fpdf->SetFillColor(255, 255, 255); // Warna sel tabel header
            $this->fpdf->Cell(0.6, 0.9, 'No', 1, 0, 'C', 1);
            $this->fpdf->Cell(3.5, 0.9, 'Nama Karyawan', 1, 0, 'C', 1);
            $this->fpdf->Cell(3, 0.9, 'Penempatan', 1, 0, 'C', 1);
            $this->fpdf->Cell(1.5, 0.9, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(1.5, 0.9, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(1.5, 0.9, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(3, 0.9, 'Jumlah Uang Lembur', 1, 0, 'C');
            $this->fpdf->Cell(1.5, 0.9, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(2, 0.9, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(2, 0.9, '', 1, 0, 'C', 1);

            $this->fpdf->Ln(0.1);
            $this->fpdf->Cell(7.5);
            $this->fpdf->Cell(1, 0.5, 'Nomor', 0, 0, 'C');

            $this->fpdf->Ln(0.3);
            $this->fpdf->Cell(7.5);
            $this->fpdf->Cell(1, 0.5, 'Rekening', 0, 0, 'C');

            $this->fpdf->Ln(-0.3);
            $this->fpdf->Cell(9);
            $this->fpdf->Cell(1, 0.5, 'Jam', 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(9);
            $this->fpdf->Cell(1, 0.5, 'Lembur', 0, 0, 'C');

            $this->fpdf->Ln(-0.4);
            $this->fpdf->Cell(10.2);
            $this->fpdf->SetFont('Arial', '', '6.5');
            $this->fpdf->Cell(1.5, 0.5, 'Upah Lembur', 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(10.2);
            $this->fpdf->Cell(1.5, 0.5, 'Perjam', 0, 0, 'C');

            $this->fpdf->Ln(-0.4);
            $this->fpdf->Cell(14.7);
            $this->fpdf->SetFont('Arial', '', '7');
            $this->fpdf->Cell(1.5, 0.5, 'Uang Makan', 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(14.7);
            $this->fpdf->Cell(1.5, 0.5, 'Lembur', 0, 0, 'C');

            $this->fpdf->Ln(-0.4);
            $this->fpdf->Cell(16.3);
            $this->fpdf->SetFont('Arial', '', '6.5');
            $this->fpdf->Cell(1.5, 0.5, 'Jumlah Uang', 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(16.3);
            $this->fpdf->Cell(1.5, 0.5, 'Yang Diterima', 0, 0, 'C');

            $this->fpdf->Ln(-0.4);
            $this->fpdf->Cell(18.3);
            $this->fpdf->SetFont('Arial', '', '6.5');
            $this->fpdf->Cell(1.5, 0.5, 'Hasil Uang', 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(18.3);
            $this->fpdf->Cell(1.5, 0.5, 'Yang Diterima', 0, 0, 'C');

            $no = 1;
            $totaljumlahuanglembur = 0;
            $totaluangmakanlembur = 0;
            $totaljumlahuangditerima = 0;
            $totalhasiluangditerima = 0;

            $bulanawal   = Carbon::parse($awal)->isoformat('MM');
            $bulanakhir  = Carbon::parse($akhir)->isoformat('MM');
            $tahunawal   = Carbon::parse($awal)->isoformat('YYYY');
            $tahunakhir  = Carbon::parse($akhir)->isoformat('YYYY');

            foreach ($items as $item) {

                $jumlahjam = $item->jumlah_jam_pertama + $item->jumlah_jam_kedua + $item->jumlah_jam_ketiga + $item->jumlah_jam_keempat;
                $uangmakanlembur = $item->uang_makan_lembur;


                $collections = DB::table('overtimes')
                    ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
                    ->join('rekap_salaries', 'employees.nik_karyawan', '=', 'rekap_salaries.employees_id')
                    ->join('positions', 'positions.id', '=', 'employees.positions_id')
                    ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
                    ->join('areas', 'areas.id', '=', 'employees.areas_id')
                    ->where('overtimes.employees_id', $item->employees_id)
                    ->where('overtimes.acc_hrd', '<>', null)
                    ->where('overtimes.deleted_at', null)
                    ->where('rekap_salaries.deleted_at', null)
                    ->where('employees.golongans_id', $golongan)
                    ->whereMonth('rekap_salaries.periode_awal', $bulanawal)
                    ->whereMonth('rekap_salaries.periode_akhir', $bulanakhir)
                    ->whereYear('rekap_salaries.periode_awal', $tahunawal)
                    ->whereYear('rekap_salaries.periode_akhir', $tahunakhir)
                    ->whereBetween('tanggal_lembur', [$awal, $akhir])
                    ->first();

                $namakaryawan = $collections->nama_karyawan;
                $jabatan = $collections->jabatan;
                $penempatan = $collections->penempatan;
                $area = $collections->area;
                $nomorrekening = $collections->nomor_rekening;
                $upahlemburperjam = $collections->upah_lembur_perjam;
                $jumlahuanglembur = $upahlemburperjam * $jumlahjam;
                $jumlahuangditerima = $jumlahuanglembur + $uangmakanlembur;

                $jumlahuangditerimapembulatan = ceil($jumlahuangditerima);
                // if (substr($jumlahuangditerimapembulatan, -2) <= 0) {
                //     $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2);
                // } else {
                //     $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2) + 100;
                // }
                if (substr($jumlahuangditerimapembulatan, -2) > 50 && substr($jumlahuangditerimapembulatan, -2) < 100) {
                    $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2);
                } elseif (substr($jumlahuangditerimapembulatan, -2) < 50 && substr($jumlahuangditerimapembulatan, -2) > 0) {
                    $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2) + 100;
                } elseif (substr($jumlahuangditerimapembulatan, -2) <= 0) {
                    $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2);
                }
                elseif (substr($jumlahuangditerimapembulatan, -2) == 50) {
                    $total_jumlahuangditerima = round($jumlahuangditerimapembulatan, -2);
                } else {
                    $total_jumlahuangditerima = 0;
                }


                $this->fpdf->SetFont('Arial', '', '7');
                $this->fpdf->Ln(0.4);
                $this->fpdf->Cell(0.1);
                $this->fpdf->Cell(0.6, 0.4, $no, 1, 0, 'C');
                $this->fpdf->Cell(3.5, 0.4, $namakaryawan, 1, 0, 'L');
                $this->fpdf->Cell(3, 0.4, $penempatan, 1, 0, 'L');
                $this->fpdf->Cell(1.5, 0.4, $nomorrekening, 1, 0, 'C');
                $this->fpdf->Cell(1.5, 0.4, $jumlahjam, 1, 0, 'C');

                $this->fpdf->Cell(1.5, 0.4, number_format($upahlemburperjam), 1, 0, 'C');
                $this->fpdf->Cell(3, 0.4, number_format($jumlahuanglembur), 1, 0, 'R');
                $this->fpdf->Cell(1.5, 0.4, number_format($uangmakanlembur), 1, 0, 'R');
                $this->fpdf->Cell(2, 0.4, number_format($jumlahuangditerima), 1, 0, 'R');
                $this->fpdf->Cell(2, 0.4, number_format($total_jumlahuangditerima), 1, 0, 'R');

                $no++;
                $totaljumlahuanglembur += $jumlahuanglembur;
                $totaluangmakanlembur += $uangmakanlembur;
                $totaljumlahuangditerima += $jumlahuangditerima;
                $totalhasiluangditerima += $total_jumlahuangditerima;
            }
            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(11.7);
            $this->fpdf->Cell(3, 0.4, number_format($totaljumlahuanglembur), 1, 0, 'R');
            $this->fpdf->Cell(1.5, 0.4, number_format($totaluangmakanlembur), 1, 0, 'R');
            $this->fpdf->Cell(2, 0.4, number_format($totaljumlahuangditerima), 1, 0, 'R');
            $this->fpdf->Cell(2, 0.4, number_format($totalhasiluangditerima), 1, 0, 'R');

            $this->fpdf->Ln(0.7);

            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, 'Mengetahui', 0, 0, 'L');

            $this->fpdf->Cell(6, 0.2, 'Tangerang, ........................................,2023', 0, 0, 'L');

            $this->fpdf->Cell(3);
            $this->fpdf->Cell(5.4, 0.2, 'Diperiksa', 0, 0, 'L');


            $this->fpdf->Ln(1.5);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, 'Veronica', 0, 0, 'L');



            $this->fpdf->Cell(9);
            $this->fpdf->Cell(5.4, 0.2, 'Rudiyanto', 0, 0, 'L');

            $this->fpdf->Ln(0.3);
            $this->fpdf->Cell(0.2);
            $this->fpdf->Cell(1, 0, '', 1, 0, 'L', 1);

            $this->fpdf->Cell(13);
            $this->fpdf->Cell(1.1, 0, '', 1, 0, 'L', 1);

            $this->fpdf->Ln(0.1);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, '(Wakil Direktur Accounting,Finance,IC,&IT)', 0, 0, 'L');

            $this->fpdf->Cell(9);
            $this->fpdf->Cell(5, 0.2, '(General Manager HRD-GA)', 0, 0, 'L');

            $this->fpdf->Output();
            exit;
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Produksi
        if ($divisi == 11) {
            $items = Employees::with([
                'companies',
                'areas',
                'divisions',
                'positions'
            ])->where('status_kerja', '<>', 'Outsourcing')->whereIn('golongans_id', [2, 3])->whereIn('divisions_id', [11])->get();
        }
        //PDC
        elseif ($divisi == 19) {
            $items = Employees::with([
                'companies',
                'areas',
                'divisions',
                'positions'
            ])->where('status_kerja', '<>', 'Outsourcing')->whereIn('golongans_id', [2, 3])->whereIn('divisions_id', [19, 20, 21, 22])->get();
        }
        //IC
        elseif ($divisi == 2) {
            $items = Employees::with([
                'companies',
                'areas',
                'divisions',
                'positions'
            ])->where('status_kerja', '<>', 'Outsourcing')->whereIn('golongans_id', [2, 3])->whereIn('divisions_id', [2])->get();
        }
        //Engineering
        elseif ($divisi == 7) {
            $items = Employees::with([
                'companies',
                'areas',
                'divisions',
                'positions'
            ])->where('status_kerja', '<>', 'Outsourcing')->whereIn('golongans_id', [2, 3])->whereIn('divisions_id', [7])->get();
        }
        //Quality
        elseif ($divisi == 8) {
            $items = Employees::with([
                'companies',
                'areas',
                'divisions',
                'positions'
            ])->where('status_kerja', '<>', 'Outsourcing')->whereIn('golongans_id', [2, 3])->whereIn('divisions_id', [8])->get();
        }
        //Purchasing
        elseif ($divisi == 9) {
            $items = Employees::with([
                'companies',
                'areas',
                'divisions',
                'positions'
            ])->where('status_kerja', '<>', 'Outsourcing')->whereIn('golongans_id', [2, 3])->whereIn('divisions_id', [9])->get();
        }
        //PPC
        elseif ($divisi == 10) {
            $items = Employees::with([
                'companies',
                'areas',
                'divisions',
                'positions'
            ])->where('status_kerja', '<>', 'Outsourcing')->whereIn('golongans_id', [2, 3])->whereIn('divisions_id', [12, 13, 14, 15, 18])->get();
        }
        //HRD-GA
        elseif ($divisi == 4) {
            $items = Employees::with([
                'companies',
                'areas',
                'divisions',
                'positions'
            ])->where('status_kerja', '<>', 'Outsourcing')->whereIn('golongans_id', [2, 3])->get();
        } else {
            abort(403);
        }

        return view('pages.admin.overtime.create', [
            'items'     => $items,
            'divisi'    => $divisi
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OvertimeRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $employees_id       = $request->input('employees_id');
        $tanggal_lembur     = $request->input('tanggal_lembur');
        $jenis_lembur       = $request->input('jenis_lembur');
        $keterangan_lembur  = $request->input('keterangan_lembur');
        $jam_masuk          = $request->input('jam_masuk');
        $jam_istirahat      = $request->input('jam_istirahat');
        $jam_pulang         = $request->input('jam_pulang');
        $uang_makan_lembur  = $request->input('uang_makan_lembur');
        $jam_lembur         = $jam_pulang - $jam_istirahat - $jam_masuk;

        //Rumus Lembur
        if ($jenis_lembur == "Libur") {

            $jam_pertama = 0;

            if ($jam_lembur < 8) {
                $jam_kedua = $jam_lembur;
                $jam_ketiga = 0;
                $jam_keempat = 0;
            } elseif ($jam_lembur == 8) {
                $jam_kedua = 8;
                $jam_ketiga = 0;
                $jam_keempat = 0;
            } elseif ($jam_lembur > 8) {

                $jam_kedua = 8;

                if ($jam_lembur - $jam_kedua > 1) {
                    $jam_ketiga = 1;
                    $jam_keempat = $jam_lembur - $jam_kedua - $jam_ketiga;
                } elseif ($jam_lembur - $jam_kedua == 1) {
                    $jam_ketiga = 1;
                    $jam_keempat = 0;
                } else {
                    $jam_ketiga = $jam_lembur - $jam_kedua;
                    $jam_keempat = 0;
                }
            }
        } elseif ($jenis_lembur == "Biasa") {
            // $jam_pertama = 0;

            if ($jam_lembur < 1) {
                $jam_pertama = $jam_lembur;
                $jam_kedua   = 0;
                $jam_ketiga  = 0;
                $jam_keempat = 0;
            } elseif ($jam_lembur == 1) {
                $jam_pertama = 1;
                $jam_kedua   = 0;
                $jam_ketiga  = 0;
                $jam_keempat = 0;
            } elseif ($jam_lembur > 1) {

                $jam_pertama = 1;

                if ($jam_lembur < 9) {
                    $jam_kedua = $jam_lembur - $jam_pertama;
                    $jam_ketiga = 0;
                    $jam_keempat = 0;
                } elseif ($jam_lembur == 9) {
                    $jam_kedua = 8;
                    $jam_ketiga = 0;
                    $jam_keempat = 0;
                } elseif ($jam_lembur > 9) {

                    $jam_kedua = 8;

                    if ($jam_lembur - $jam_kedua - $jam_pertama == 1) {

                        $jam_ketiga = 1;
                        $jam_keempat = 0;
                    } elseif ($jam_lembur - $jam_kedua - $jam_pertama > 1) {

                        $jam_ketiga = 1;
                        $jam_keempat = $jam_lembur - $jam_ketiga - $jam_kedua - $jam_pertama;
                    } elseif ($jam_lembur - $jam_kedua - $jam_pertama < 1) {

                        $jam_ketiga = $jam_lembur - $jam_kedua - $jam_pertama;
                        $jam_keempat = 0;
                    }
                }
            }
        } else {
            return redirect()->route('overtime.create');
        }

        $jumlah_jam_pertama     = $jam_pertama * 1.5;
        $jumlah_jam_kedua       = $jam_kedua * 2;
        $jumlah_jam_ketiga      = $jam_ketiga * 3;
        $jumlah_jam_keempat     = $jam_keempat * 4;
        //Rumus Lembur

        foreach ($request->input('employees_id') as $key => $name) {

            $insert = [
                'employees_id'          => $request->input('employees_id')[$key],
                'jam_masuk'             => $jam_masuk,
                'jam_istirahat'         => $jam_istirahat,
                'jam_pulang'            => $jam_pulang,
                'keterangan_lembur'     => $keterangan_lembur,
                'tanggal_lembur'        => $tanggal_lembur,
                'jenis_lembur'          => $jenis_lembur,
                'jam_lembur'            => $jam_lembur,
                'jam_pertama'           => $jam_pertama,
                'jumlah_jam_pertama'    => $jumlah_jam_pertama,
                'jam_kedua'             => $jam_kedua,
                'jumlah_jam_kedua'      => $jumlah_jam_kedua,
                'jam_ketiga'            => $jam_ketiga,
                'jumlah_jam_ketiga'     => $jumlah_jam_ketiga,
                'jam_keempat'           => $jam_keempat,
                'jumlah_jam_keempat'    => $jumlah_jam_keempat,
                'uang_makan_lembur'     => $uang_makan_lembur,
                'input_oleh'            => $request->input('input_oleh')
            ];

            Overtimes::create($insert);
        }

        Alert::success('Success Input Data Lembur', 'Oleh ' . auth()->user()->name);
        //Redirect
        return redirect()->route('overtime.create');
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
    public function update(OvertimeRequest $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $employees_id       = $request->input('employees_id');
        $nama_karyawan      = $request->input('nama_karyawan');
        $tanggal_lembur     = $request->input('tanggal_lembur');
        $jenis_lembur       = $request->input('jenis_lembur');
        $keterangan_lembur  = $request->input('keterangan_lembur');
        $jam_masuk          = $request->input('jam_masuk');
        $jam_istirahat      = $request->input('jam_istirahat');
        $jam_pulang         = $request->input('jam_pulang');
        $uang_makan_lembur  = $request->input('uang_makan_lembur');
        $jam_lembur         = $jam_pulang - $jam_istirahat - $jam_masuk;

        //Rumus Lembur
        if ($jenis_lembur == "Libur") {

            $jam_pertama = 0;

            if ($jam_lembur < 8) {
                $jam_kedua = $jam_lembur;
                $jam_ketiga = 0;
                $jam_keempat = 0;
            } elseif ($jam_lembur == 8) {
                $jam_kedua = 8;
                $jam_ketiga = 0;
                $jam_keempat = 0;
            } elseif ($jam_lembur > 8) {

                $jam_kedua = 8;

                if ($jam_lembur - $jam_kedua > 1) {
                    $jam_ketiga = 1;
                    $jam_keempat = $jam_lembur - $jam_kedua - $jam_ketiga;
                } elseif ($jam_lembur - $jam_kedua == 1) {
                    $jam_ketiga = 1;
                    $jam_keempat = 0;
                } else {
                    $jam_ketiga = $jam_lembur - $jam_kedua;
                    $jam_keempat = 0;
                }
            }
        } elseif ($jenis_lembur == "Biasa") {
            // $jam_pertama = 0;

            if ($jam_lembur < 1) {
                $jam_pertama = $jam_lembur;
                $jam_kedua   = 0;
                $jam_ketiga  = 0;
                $jam_keempat = 0;
            } elseif ($jam_lembur == 1) {
                $jam_pertama = 1;
                $jam_kedua   = 0;
                $jam_ketiga  = 0;
                $jam_keempat = 0;
            } elseif ($jam_lembur > 1) {

                $jam_pertama = 1;

                if ($jam_lembur < 9) {
                    $jam_kedua = $jam_lembur - $jam_pertama;
                    $jam_ketiga = 0;
                    $jam_keempat = 0;
                } elseif ($jam_lembur == 9) {
                    $jam_kedua = 8;
                    $jam_ketiga = 0;
                    $jam_keempat = 0;
                } elseif ($jam_lembur > 9) {

                    $jam_kedua = 8;

                    if ($jam_lembur - $jam_kedua - $jam_pertama == 1) {

                        $jam_ketiga = 1;
                        $jam_keempat = 0;
                    } elseif ($jam_lembur - $jam_kedua - $jam_pertama > 1) {

                        $jam_ketiga = 1;
                        $jam_keempat = $jam_lembur - $jam_ketiga - $jam_kedua - $jam_pertama;
                    } elseif ($jam_lembur - $jam_kedua - $jam_pertama < 1) {

                        $jam_ketiga = $jam_lembur - $jam_kedua - $jam_pertama;
                        $jam_keempat = 0;
                    }
                }
            }
        } else {
            return redirect()->route('overtimes.index');
        }

        $jumlah_jam_pertama     = $jam_pertama * 1.5;
        $jumlah_jam_kedua       = $jam_kedua * 2;
        $jumlah_jam_ketiga      = $jam_ketiga * 3;
        $jumlah_jam_keempat     = $jam_keempat * 4;
        //Rumus Lembur

        $overtimes              = Overtimes::where('id', $id)->first();
        $overtimes->update([
            'jam_masuk'             => $jam_masuk,
            'jam_istirahat'         => $jam_istirahat,
            'jam_pulang'            => $jam_pulang,
            'keterangan_lembur'     => $keterangan_lembur,
            'tanggal_lembur'        => $tanggal_lembur,
            'jenis_lembur'          => $jenis_lembur,
            'jam_lembur'            => $jam_lembur,
            'jam_pertama'           => $jam_pertama,
            'jumlah_jam_pertama'    => $jumlah_jam_pertama,
            'jam_kedua'             => $jam_kedua,
            'jumlah_jam_kedua'      => $jumlah_jam_kedua,
            'jam_ketiga'            => $jam_ketiga,
            'jumlah_jam_ketiga'     => $jumlah_jam_ketiga,
            'jam_keempat'           => $jam_keempat,
            'jumlah_jam_keempat'    => $jumlah_jam_keempat,
            'uang_makan_lembur'     => $uang_makan_lembur,
            'edit_oleh'             => $request->input('edit_oleh')
        ]);

        Alert::info('Success Edit Data Overtime', 'Oleh ' . auth()->user()->name);
        return redirect()->route('overtime.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $hapus_oleh     = $request->input('hapus_oleh');
        $overtimes      = Overtimes::where('id', $id)->first();

        $overtimes->update([
            'hapus_oleh'    => $request->input('hapus_oleh')
        ]);

        $item = Overtimes::findOrFail($id);
        $item->delete();

        Alert::error('Menghapus Data Overtime', 'Oleh ' . auth()->user()->name);
        return redirect()->route('overtime.index');
    }
}
