<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RekonSalaryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Admin\Employees;
use App\Models\Admin\Companies;
use App\Models\Admin\Areas;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use App\Models\Admin\HistoryContracts;
use App\Models\Admin\HistorySalaries;
use App\Models\Admin\RekapSalaries;
use App\Models\Admin\MaksimalUpahBpjskesehatans;
use App\Models\Admin\MaksimalUpahBpjsketenagakerjaans;
use App\Http\Requests\Admin\ProsesRequest;
use App\Http\Requests\Admin\ProsesPKWTHarianRequest;
use App\Http\Requests\Admin\ProsesPerpanjangPKWTHarianRequest;
use App\Http\Requests\Admin\ProsesPerpanjangPKWTKontrakRequest;
use App\Http\Requests\Admin\ProsesPerpanjangPKWTShiftRequest;
use App\Http\Requests\Admin\RekonSalaryTampilRequest;
use App\Http\Requests\Admin\EditSalaryRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use File;
use Storage;
use Alert;

class ProsesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //PKWT HARIAN
    public function proses_pkwt_harian()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        return view('pages.admin.proses.pkwt_harian.index');
    }

    public function tampil_pkwt_harian(ProsesPKWTHarianRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $golongan       = $request->input('golongan');
        $akhir_kontrak  = $request->input('akhir_kontrak');

        $items = Employees::with([
            'golongans',
            'divisions',
            'positions'
        ])->where('status_kerja', 'Harian')
            ->where('tanggal_akhir_kerja', $akhir_kontrak)
            ->where('golongans_id', $golongan)->get();
        
        if (!$items->isEmpty()) {
            return view('pages.admin.proses.pkwt_harian.tampil', [
                'items' => $items,
                'akhir_kontrak' => $akhir_kontrak,
                'golongan' => $golongan
            ]);
        }
        else{
            Alert::error('Data Tidak Ditemukan');
            //Redirect
            return redirect()->route('proses.proses_pkwt_harian');
        }
    }

    public function prosess_pkwt_harian(Request $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $akhir_kontrak  = $request->input('akhir_kontrak');
        $golongan       = $request->input('golongan');

        $items = Employees::where('tanggal_akhir_kerja', $akhir_kontrak)->where('golongans_id', $golongan)->where('status_kerja', 'Harian')->get();
        
        return view('pages.admin.proses.pkwt_harian.proses', [
            'items'         => $items,
            'akhir_kontrak' => $akhir_kontrak,
            'golongan'      => $golongan
        ]);
    }

    public function perpanjang_pkwt_harian(ProsesPerpanjangPKWTHarianRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $akhirkontrak       = $request->input('akhirkontrak');
        $golongan           = $request->input('golongan');
        $awal_kontrak       = $request->input('awal_kontrak');
        $akhir_kontrak      = $request->input('akhir_kontrak');

        //Hitung Bulan
        $date1          = date_create($request->input('awal_kontrak')); 
        $date2          = date_create($request->input('akhir_kontrak')); 
        $interval       = date_diff($date1,$date2);
        $masa_kontrak   = $interval->m+1;
        if ($masa_kontrak == 12) {
            $masakontrak = "1 Tahun";
        }
        elseif ($masa_kontrak > 12) {
            $masakontrak = "Salah";
        }
        else{
            $masakontrak = $masa_kontrak." Bulan";
        }
        //Hitung Bulan

        $items              = Employees::where('tanggal_akhir_kerja', $akhirkontrak)->where('status_kerja', 'Harian')->where('golongans_id', $golongan)->get();

        foreach ($items as $item) {
            HistoryContracts::create([
                'employees_id'                  => $item->nik_karyawan,
                'tanggal_awal_kontrak'          => $awal_kontrak,
                'tanggal_akhir_kontrak'         => $akhir_kontrak,
                'status_kontrak_kerja'          => 'Harian',
                'masa_kontrak'                  => $masakontrak,
                'jumlah_kontrak'                => 1
            ]);

            $employees  = Employees::where('nik_karyawan', $item->nik_karyawan)->where('status_kerja', 'Harian')->first();
            $employees->update([
                'tanggal_akhir_kerja'   => $akhir_kontrak
            ]);
        }
        Alert::success('Success Proses PKWT Harian', 'Oleh ' . auth()->user()->name);
        return view('pages.admin.proses.pkwt_harian.index');
        
    }
    //PKWT HARIAN

    //PKWT KONTRAK
    public function proses_pkwt_kontrak()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        return view('pages.admin.proses.pkwt_kontrak.index');
    }

    public function tampil_pkwt_kontrak(ProsesRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $akhir_kontrak  = $request->input('akhir_kontrak');

        $items = Employees::with([
            'divisions',
            'positions'
        ])->where('status_kerja', 'PKWT')
            ->where('tanggal_akhir_kerja', $akhir_kontrak)->get();

        return view('pages.admin.proses.pkwt_kontrak.tampil', [
            'items' => $items,
            'akhir_kontrak' => $akhir_kontrak
        ]);
    }

    public function prosess_pkwt_kontrak($akhir_kontrak)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $items = Employees::where('tanggal_akhir_kerja', $akhir_kontrak)->where('status_kerja', 'PKWT')->get();

        return view('pages.admin.proses.pkwt_kontrak.proses', [
            'items'         => $items,
            'akhir_kontrak' => $akhir_kontrak
        ]);
    }

    public function perpanjang_pkwt_kontrak(ProsesPerpanjangPKWTKontrakRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $akhirkontrak       = $request->input('akhirkontrak');
        $awal_kontrak       = $request->input('awal_kontrak');
        $akhir_kontrak      = $request->input('akhir_kontrak');

        //Hitung Bulan
        $date1          = date_create($request->input('awal_kontrak')); 
        $date2          = date_create($request->input('akhir_kontrak')); 
        $interval       = date_diff($date1,$date2);
        $masa_kontrak   = $interval->m+1;
        if ($masa_kontrak == 12) {
            $masakontrak = "1 Tahun";
        }
        elseif ($masa_kontrak > 12) {
            $masakontrak = "Salah";
        }
        else{
            $masakontrak = $masa_kontrak." Bulan";
        }
        //Hitung Bulan


        $items              = Employees::where('tanggal_akhir_kerja', $akhirkontrak)->where('status_kerja', 'PKWT')->get();

        foreach ($items as $item) {
            HistoryContracts::create([
                'employees_id'                  => $item->nik_karyawan,
                'tanggal_awal_kontrak'          => $awal_kontrak,
                'tanggal_akhir_kontrak'         => $akhir_kontrak,
                'status_kontrak_kerja'          => 'PKWT',
                'masa_kontrak'                  => $masakontrak,
                'jumlah_kontrak'                => 1
            ]);

            $employees  = Employees::where('nik_karyawan', $item->nik_karyawan)->where('status_kerja', 'PKWT')->first();
            $employees->update([
                'tanggal_akhir_kerja'   => $akhir_kontrak
            ]);
        }
        Alert::success('Success Proses PKWT Kontrak', 'Oleh ' . auth()->user()->name);
        return redirect()->route('proses.proses_pkwt_kontrak');
    }
    //PKWT KONTRAK

    //PKWT SHIFT HARIAN
    public function proses_pkwt_shift_harian()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $items = Employees::with([
            'companies',
            'areas',
            'divisions',
            'positions'
        ])->where('status_kerja', '<>', 'Outsourcing')->whereIn('golongans_id', [2, 3])->get();

        return view('pages.admin.proses.pkwt_shift_harian.index', [
            'items'     => $items
        ]);
    }

    public function perpanjang_pkwt_shift_harian(ProsesPerpanjangPKWTShiftRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $employees_id       = $request->input('employees_id');
        $awal_kontrak       = $request->input('awal_kontrak');
        $akhir_kontrak      = $request->input('akhir_kontrak');

        //Hitung Bulan
        $date1          = date_create($request->input('awal_kontrak')); 
        $date2          = date_create($request->input('akhir_kontrak')); 
        $interval       = date_diff($date1,$date2);
        $masa_kontrak   = $interval->m+1;
        if ($masa_kontrak == 12) {
            $masakontrak = "1 Tahun";
        }
        elseif ($masa_kontrak > 12) {
            $masakontrak = "Salah";
        }
        else{
            $masakontrak = $masa_kontrak." Bulan";
        }
        //Hitung Bulan

        foreach ($employees_id as $key => $name) {
                
            $insert = [
                'employees_id'          => $request->input('employees_id')[$key],
                'tanggal_awal_kontrak'  => $awal_kontrak,
                'tanggal_akhir_kontrak' => $akhir_kontrak,
                'status_kontrak_kerja'  => 'Harian',
                'masa_kontrak'          => $masakontrak,
                'jumlah_kontrak'        => 1
            ];

            HistoryContracts::create($insert);

            $employees  = Employees::where('nik_karyawan', $request->input('employees_id')[$key])->first();
            $employees->update([
                'tanggal_akhir_kerja'   => $akhir_kontrak
            ]);

        }

        

        Alert::success('Success Proses PKWT Shift', 'Oleh ' . auth()->user()->name);
        return redirect()->route('proses.proses_pkwt_shift_harian');
    }
    //PKWT SHIFT HARIAN

    //PKWT SHIFT KONTRAK
    public function proses_pkwt_shift_kontrak()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $items = Employees::with([
            'companies',
            'areas',
            'divisions',
            'positions'
        ])->where('status_kerja', '<>', 'Outsourcing')->whereIn('golongans_id', [1, 2, 3])->get();

        return view('pages.admin.proses.pkwt_shift_harian.index', [
            'items'     => $items
        ]);
    }

    public function perpanjang_pkwt_shift_kontrak(ProsesPerpanjangPKWTShiftRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $employees_id       = $request->input('employees_id');
        $awal_kontrak       = $request->input('awal_kontrak');
        $akhir_kontrak      = $request->input('akhir_kontrak');

        //Hitung Bulan
        $date1          = date_create($request->input('awal_kontrak')); 
        $date2          = date_create($request->input('akhir_kontrak')); 
        $interval       = date_diff($date1,$date2);
        $masa_kontrak   = $interval->m+1;
        if ($masa_kontrak == 12) {
            $masakontrak = "1 Tahun";
        }
        elseif ($masa_kontrak > 12) {
            $masakontrak = "Salah";
        }
        else{
            $masakontrak = $masa_kontrak." Bulan";
        }
        //Hitung Bulan

        foreach ($employees_id as $key => $name) {
                
            $insert = [
                'employees_id'          => $request->input('employees_id')[$key],
                'tanggal_awal_kontrak'  => $awal_kontrak,
                'tanggal_akhir_kontrak' => $akhir_kontrak,
                'status_kontrak_kerja'  => 'PKWT',
                'masa_kontrak'          => $masakontrak,
                'jumlah_kontrak'        => 1
            ];

            HistoryContracts::create($insert);

            $employees  = Employees::where('nik_karyawan', $request->input('employees_id')[$key])->first();
            $employees->update([
                'tanggal_akhir_kerja'   => $akhir_kontrak
            ]);

        }

        Alert::success('Success Proses PKWT Shift', 'Oleh ' . auth()->user()->name);
        return redirect()->route('proses.proses_pkwt_shift_kontrak');
    }
    //PKWT SHIFT KONTRAK

    //SALARY
    public function proses_rekon_salary()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        return view('pages.admin.salary.rekon_salary');
    }
    public function tampil_rekon_salary(RekonSalaryTampilRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $awal       = $request->input('awal');
        $akhir      = $request->input('akhir');

        $items =
            DB::table('history_salaries')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_salaries.employees_id')
            ->join('golongans', 'golongans.id', '=', 'employees.golongans_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('areas', 'areas.id', '=', 'employees.areas_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where('history_salaries.deleted_at', '=', null)
            ->get();
            
        $salary = RekapSalaries::where('periode_awal', $awal)->first();

        if ($salary != null) {
            Alert::error('Data Sudah Di Rekon');
            //Redirect
            return redirect()->route('proses.proses_rekon_salary');
        } else {
            return view('pages.admin.salary.tampil_rekon_salary', [
                'awal'  => $awal,
                'akhir' => $akhir,
                'items' => $items
            ]);
        }
    }
    public function hasil_rekon_salary(RekonSalaryTampilRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $awal       = $request->input('awal');
        $akhir      = $request->input('akhir');
        $input_oleh = $request->input('input_oleh');

        $items = HistorySalaries::all();

        foreach ($items as $item) {

            RekapSalaries::create([
                'periode_awal'                      => $awal,
                'periode_akhir'                     => $akhir,
                'employees_id'                      => $item->employees_id,
                'gaji_pokok'                        => $item->gaji_pokok,
                'uang_makan'                        => $item->uang_makan,
                'uang_transport'                    => $item->uang_transport,
                'tunjangan_tugas'                   => $item->tunjangan_tugas,
                'tunjangan_pulsa'                   => $item->tunjangan_pulsa,
                'tunjangan_jabatan'                 => $item->tunjangan_jabatan,
                'jumlah_upah'                       => $item->jumlah_upah,
                'upah_lembur_perjam'                => $item->upah_lembur_perjam,
                'potongan_bpjsks_perusahaan'        => $item->potongan_bpjsks_perusahaan,
                'potongan_jht_perusahaan'           => $item->potongan_jht_perusahaan,
                'potongan_jp_perusahaan'            => $item->potongan_jp_perusahaan,
                'potongan_jkm_perusahaan'           => $item->potongan_jkm_perusahaan,
                'potongan_jkk_perusahaan'           => $item->potongan_jkk_perusahaan,
                'jumlah_bpjstk_perusahaan'          => $item->jumlah_bpjstk_perusahaan,
                'potongan_bpjsks_karyawan'          => $item->potongan_bpjsks_karyawan,
                'potongan_jht_karyawan'             => $item->potongan_jht_karyawan,
                'potongan_jp_karyawan'              => $item->potongan_jp_karyawan,
                'jumlah_bpjstk_karyawan'            => $item->jumlah_bpjstk_karyawan,
                'take_home_pay'                     => $item->take_home_pay,
                'edit_oleh'                         => $item->edit_oleh,
                'input_oleh'                        => $input_oleh
            ]);
        }

        Alert::success('Success Rekonsiliasi Data Salary', 'Oleh ' . auth()->user()->name);
        return redirect()->route('dashboard');
    }
    public function edit_salary($employees_id)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        $item =
            DB::table('history_salaries')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_salaries.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('areas', 'areas.id', '=', 'employees.areas_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where('history_salaries.employees_id', '=', $employees_id)
            ->first();

        return view('pages.admin.salary.edit_salary', [
            'item' => $item
        ]);
    }
    public function hasil_edit_salary(EditSalaryRequest $request, $employees_id)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $gaji_pokok         = $request->input('gaji_pokok');
        $uang_makan         = $request->input('uang_makan');
        $uang_transport     = $request->input('uang_transport');
        $tunjangan_tugas    = $request->input('tunjangan_tugas');
        $tunjangan_pulsa    = $request->input('tunjangan_pulsa');
        $tunjangan_jabatan  = $request->input('tunjangan_jabatan');

        $jht                = $request->input('jht');
        $jp                 = $request->input('jp');
        $jkk                = $request->input('jkk');
        $jkm                = $request->input('jkm');
        $jkn                = $request->input('jkn');

        //Ikut Semua Kepesertaan BPJS Ketenagakerjaan Dan Kesehatan
        if ($jht != 0 && $jp != 0 && $jkk != 0 && $jkm != 0 && $jkn != 0) {
            //End Rumus
            $jumlah_upah                        = $gaji_pokok + $uang_makan + $uang_transport + $tunjangan_tugas + $tunjangan_pulsa + $tunjangan_jabatan;
            $upah_lembur_perjam                 = $jumlah_upah / 173;
            $hasil_upah_lembur_perjam           = round($upah_lembur_perjam);

            $itemBpjskesehatans                 = MaksimalUpahBpjskesehatans::where('id', 1)->first();
            $itemBpjsketenagakerjaans           = MaksimalUpahBpjsketenagakerjaans::where('id', 1)->first();
            $maksimal_upah_bpjs_kesehatan       = $itemBpjskesehatans->maksimal_upah_bpjskesehatan;
            $maksimal_upah_bpjs_ketenagakerjaan = $itemBpjsketenagakerjaans->maksimal_upah_bpjsketenagakerjaan;

            if ($jumlah_upah <= $maksimal_upah_bpjs_kesehatan && $jumlah_upah <= $maksimal_upah_bpjs_ketenagakerjaan) {

                $potongan_bpjsks_perusahaan     = $jumlah_upah * 4 / 100;
                $potongan_bpjsks_karyawan       = $jumlah_upah * 1 / 100;

                $potongan_jht_perusahaan        = $jumlah_upah * 3.7 / 100;
                $potongan_jp_perusahaan         = $jumlah_upah * 2 / 100;
                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
                $potongan_jht_karyawan          = $jumlah_upah * 2 / 100;
                $potongan_jp_karyawan           = $jumlah_upah * 1 / 100;
            } elseif ($jumlah_upah <= $maksimal_upah_bpjs_kesehatan && $jumlah_upah > $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_bpjsks_perusahaan     = $jumlah_upah * 4 / 100;
                $potongan_bpjsks_karyawan       = $jumlah_upah * 1 / 100;

                $potongan_jht_perusahaan        = $jumlah_upah * 3.7 / 100;
                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
                $potongan_jht_karyawan          = $jumlah_upah * 2 / 100;
                $potongan_jp_perusahaan         = $maksimal_upah_bpjs_ketenagakerjaan * 2 / 100;
                $potongan_jp_karyawan           = $maksimal_upah_bpjs_ketenagakerjaan * 1 / 100;
            } elseif ($jumlah_upah > $maksimal_upah_bpjs_kesehatan && $jumlah_upah > $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_bpjsks_perusahaan     = $maksimal_upah_bpjs_kesehatan * 4 / 100;
                $potongan_bpjsks_karyawan       = $maksimal_upah_bpjs_kesehatan * 1 / 100;

                $potongan_jht_perusahaan        = $jumlah_upah * 3.7 / 100;
                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
                $potongan_jht_karyawan          = $jumlah_upah * 2 / 100;
                $potongan_jp_perusahaan         = $maksimal_upah_bpjs_ketenagakerjaan * 2 / 100;
                $potongan_jp_karyawan           = $maksimal_upah_bpjs_ketenagakerjaan * 1 / 100;
            } else {
                dd('Salah');
            }

            $hasil_potongan_bpjsks_perusahaan   = round($potongan_bpjsks_perusahaan, 0);
            $hasil_potongan_bpjsks_karyawan     = round($potongan_bpjsks_karyawan, 0);
            $hasil_potongan_jht_perusahaan      = round($potongan_jht_perusahaan, 0);
            $hasil_potongan_jp_perusahaan       = round($potongan_jp_perusahaan, 0);
            $hasil_potongan_jkm_perusahaan      = round($potongan_jkm_perusahaan, 0);
            $hasil_potongan_jkk_perusahaan      = round($potongan_jkk_perusahaan, 0);
            $hasil_potongan_jht_karyawan        = round($potongan_jht_karyawan, 0);
            $hasil_potongan_jp_karyawan         = round($potongan_jp_karyawan, 0);

            $jumlah_bpjstk_perusahaan           = $hasil_potongan_jht_perusahaan + $hasil_potongan_jp_perusahaan + $hasil_potongan_jkm_perusahaan + $hasil_potongan_jkk_perusahaan;
            $jumlah_bpjstk_karyawan             = $hasil_potongan_jht_karyawan + $hasil_potongan_jp_karyawan;
            $take_home_pay                      = $jumlah_upah - $jumlah_bpjstk_karyawan - $hasil_potongan_bpjsks_karyawan;
            //End Rumus
        }

        //Tidak Ikut Semua Kepesertaan BPJS Ketenagakerjaan Dan Kesehatan
        elseif ($jht == 0 && $jp == 0 && $jkk == 0 && $jkm == 0 && $jkn == 0) {

            //End Rumus
            $jumlah_upah                        = $gaji_pokok + $uang_makan + $uang_transport + $tunjangan_tugas + $tunjangan_pulsa + $tunjangan_jabatan;
            $upah_lembur_perjam                 = $jumlah_upah / 173;
            $hasil_upah_lembur_perjam           = round($upah_lembur_perjam);

            $hasil_potongan_bpjsks_perusahaan   = 0;
            $hasil_potongan_bpjsks_karyawan     = 0;
            $hasil_potongan_jht_perusahaan      = 0;
            $hasil_potongan_jp_perusahaan       = 0;
            $hasil_potongan_jkm_perusahaan      = 0;
            $hasil_potongan_jkk_perusahaan      = 0;
            $hasil_potongan_jht_karyawan        = 0;
            $hasil_potongan_jp_karyawan         = 0;

            $jumlah_bpjstk_perusahaan           = $hasil_potongan_jht_perusahaan + $hasil_potongan_jp_perusahaan + $hasil_potongan_jkm_perusahaan + $hasil_potongan_jkk_perusahaan;
            $jumlah_bpjstk_karyawan             = $hasil_potongan_jht_karyawan + $hasil_potongan_jp_karyawan;
            $take_home_pay                      = $jumlah_upah - $jumlah_bpjstk_karyawan - $hasil_potongan_bpjsks_karyawan;
            //End Rumus
        }

        //Ikut Kepesertaan BPJS Ketenagakerjaan Dan Tidak Ikut Kepesertaan BPJS Kesehatan
        elseif ($jht != 0 && $jp != 0 && $jkk != 0 && $jkm != 0 && $jkn == 0) {
            //End Rumus
            $jumlah_upah                        = $gaji_pokok + $uang_makan + $uang_transport + $tunjangan_tugas + $tunjangan_pulsa + $tunjangan_jabatan;
            $upah_lembur_perjam                 = $jumlah_upah / 173;
            $hasil_upah_lembur_perjam           = round($upah_lembur_perjam);

            $itemBpjskesehatans                 = MaksimalUpahBpjskesehatans::where('id', 1)->first();
            $itemBpjsketenagakerjaans           = MaksimalUpahBpjsketenagakerjaans::where('id', 1)->first();
            $maksimal_upah_bpjs_kesehatan       = $itemBpjskesehatans->maksimal_upah_bpjskesehatan;
            $maksimal_upah_bpjs_ketenagakerjaan = $itemBpjsketenagakerjaans->maksimal_upah_bpjsketenagakerjaan;

            if ($jumlah_upah <= $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_jht_perusahaan        = $jumlah_upah * 3.7 / 100;
                $potongan_jp_perusahaan         = $jumlah_upah * 2 / 100;
                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
                $potongan_jht_karyawan          = $jumlah_upah * 2 / 100;
                $potongan_jp_karyawan           = $jumlah_upah * 1 / 100;
            } elseif ($jumlah_upah > $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_jht_perusahaan        = $jumlah_upah * 3.7 / 100;
                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
                $potongan_jht_karyawan          = $jumlah_upah * 2 / 100;
                $potongan_jp_perusahaan         = $maksimal_upah_bpjs_ketenagakerjaan * 2 / 100;
                $potongan_jp_karyawan           = $maksimal_upah_bpjs_ketenagakerjaan * 1 / 100;
            } else {
                dd('Salah');
            }

            $hasil_potongan_bpjsks_perusahaan   = 0;
            $hasil_potongan_bpjsks_karyawan     = 0;
            $hasil_potongan_jht_perusahaan      = round($potongan_jht_perusahaan, 0);
            $hasil_potongan_jp_perusahaan       = round($potongan_jp_perusahaan, 0);
            $hasil_potongan_jkm_perusahaan      = round($potongan_jkm_perusahaan, 0);
            $hasil_potongan_jkk_perusahaan      = round($potongan_jkk_perusahaan, 0);
            $hasil_potongan_jht_karyawan        = round($potongan_jht_karyawan, 0);
            $hasil_potongan_jp_karyawan         = round($potongan_jp_karyawan, 0);

            $jumlah_bpjstk_perusahaan           = $hasil_potongan_jht_perusahaan + $hasil_potongan_jp_perusahaan + $hasil_potongan_jkm_perusahaan + $hasil_potongan_jkk_perusahaan;
            $jumlah_bpjstk_karyawan             = $hasil_potongan_jht_karyawan + $hasil_potongan_jp_karyawan;
            $take_home_pay                      = $jumlah_upah - $jumlah_bpjstk_karyawan - $hasil_potongan_bpjsks_karyawan;
            //End Rumus
        }

        //Ikut Kepesertaan BPJS Kesehatan Dan Tidak Ikut Kepesertaan BPJS Ketenagakerjaan 
        elseif ($jht == 0 && $jp == 0 && $jkk == 0 && $jkm == 0 && $jkn != 0) {
            //End Rumus
            $jumlah_upah                        = $gaji_pokok + $uang_makan + $uang_transport + $tunjangan_tugas + $tunjangan_pulsa + $tunjangan_jabatan;
            $upah_lembur_perjam                 = $jumlah_upah / 173;
            $hasil_upah_lembur_perjam           = round($upah_lembur_perjam);

            $itemBpjskesehatans                 = MaksimalUpahBpjskesehatans::where('id', 1)->first();
            $itemBpjsketenagakerjaans           = MaksimalUpahBpjsketenagakerjaans::where('id', 1)->first();
            $maksimal_upah_bpjs_kesehatan       = $itemBpjskesehatans->maksimal_upah_bpjskesehatan;
            $maksimal_upah_bpjs_ketenagakerjaan = $itemBpjsketenagakerjaans->maksimal_upah_bpjsketenagakerjaan;

            if ($jumlah_upah <= $maksimal_upah_bpjs_kesehatan) {
                $potongan_bpjsks_perusahaan     = $jumlah_upah * 4 / 100;
                $potongan_bpjsks_karyawan       = $jumlah_upah * 1 / 100;
            } elseif ($jumlah_upah > $maksimal_upah_bpjs_kesehatan && $jumlah_upah > $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_bpjsks_perusahaan     = $maksimal_upah_bpjs_kesehatan * 4 / 100;
                $potongan_bpjsks_karyawan       = $maksimal_upah_bpjs_kesehatan * 1 / 100;
            } else {
                dd('Salah');
            }

            $hasil_potongan_bpjsks_perusahaan   = round($potongan_bpjsks_perusahaan, 0);
            $hasil_potongan_bpjsks_karyawan     = round($potongan_bpjsks_karyawan, 0);
            $hasil_potongan_jht_perusahaan      = 0;
            $hasil_potongan_jp_perusahaan       = 0;
            $hasil_potongan_jkm_perusahaan      = 0;
            $hasil_potongan_jkk_perusahaan      = 0;
            $hasil_potongan_jht_karyawan        = 0;
            $hasil_potongan_jp_karyawan         = 0;

            $jumlah_bpjstk_perusahaan           = $hasil_potongan_jht_perusahaan + $hasil_potongan_jp_perusahaan + $hasil_potongan_jkm_perusahaan + $hasil_potongan_jkk_perusahaan;
            $jumlah_bpjstk_karyawan             = $hasil_potongan_jht_karyawan + $hasil_potongan_jp_karyawan;
            $take_home_pay                      = $jumlah_upah - $jumlah_bpjstk_karyawan - $hasil_potongan_bpjsks_karyawan;
            //End Rumus
        }

        //Tidak Ikut JHT Dan JP, Hanya Ikut JKK Dan JKM Dan Ikut Kepesertaan BPJS Kesehatan
        elseif ($jht == 0 && $jp == 0 && $jkk != 0 && $jkm != 0 && $jkn != 0) {
            //End Rumus
            $jumlah_upah                        = $gaji_pokok + $uang_makan + $uang_transport + $tunjangan_tugas + $tunjangan_pulsa + $tunjangan_jabatan;
            $upah_lembur_perjam                 = $jumlah_upah / 173;
            $hasil_upah_lembur_perjam           = round($upah_lembur_perjam);

            $itemBpjskesehatans                 = MaksimalUpahBpjskesehatans::where('id', 1)->first();
            $itemBpjsketenagakerjaans           = MaksimalUpahBpjsketenagakerjaans::where('id', 1)->first();
            $maksimal_upah_bpjs_kesehatan       = $itemBpjskesehatans->maksimal_upah_bpjskesehatan;
            $maksimal_upah_bpjs_ketenagakerjaan = $itemBpjsketenagakerjaans->maksimal_upah_bpjsketenagakerjaan;

            if ($jumlah_upah <= $maksimal_upah_bpjs_kesehatan && $jumlah_upah <= $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_bpjsks_perusahaan     = $jumlah_upah * 4 / 100;
                $potongan_bpjsks_karyawan       = $jumlah_upah * 1 / 100;

                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
            } elseif ($jumlah_upah <= $maksimal_upah_bpjs_kesehatan && $jumlah_upah > $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_bpjsks_perusahaan     = $jumlah_upah * 4 / 100;
                $potongan_bpjsks_karyawan       = $jumlah_upah * 1 / 100;

                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
            } elseif ($jumlah_upah > $maksimal_upah_bpjs_kesehatan && $jumlah_upah > $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_bpjsks_perusahaan     = $maksimal_upah_bpjs_kesehatan * 4 / 100;
                $potongan_bpjsks_karyawan       = $maksimal_upah_bpjs_kesehatan * 1 / 100;

                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
            } else {
                dd('Salah');
            }

            $hasil_potongan_bpjsks_perusahaan   = round($potongan_bpjsks_perusahaan, 0);
            $hasil_potongan_bpjsks_karyawan     = round($potongan_bpjsks_karyawan, 0);
            $hasil_potongan_jht_perusahaan      = 0;
            $hasil_potongan_jp_perusahaan       = 0;
            $hasil_potongan_jkm_perusahaan      = round($potongan_jkm_perusahaan, 0);
            $hasil_potongan_jkk_perusahaan      = round($potongan_jkk_perusahaan, 0);
            $hasil_potongan_jht_karyawan        = 0;
            $hasil_potongan_jp_karyawan         = 0;

            $jumlah_bpjstk_perusahaan           = $hasil_potongan_jht_perusahaan + $hasil_potongan_jp_perusahaan + $hasil_potongan_jkm_perusahaan + $hasil_potongan_jkk_perusahaan;
            $jumlah_bpjstk_karyawan             = $hasil_potongan_jht_karyawan + $hasil_potongan_jp_karyawan;
            $take_home_pay                      = $jumlah_upah - $jumlah_bpjstk_karyawan - $hasil_potongan_bpjsks_karyawan;
            //End Rumus
        }

        //Tidak Ikut JHT, JP, dan BPJS Kesehatan, Hanya Ikut JKK Dan JKM
        elseif ($jht == 0 && $jp == 0 && $jkk != 0 && $jkm != 0 && $jkn == 0) {
            //End Rumus
            $jumlah_upah                        = $gaji_pokok + $uang_makan + $uang_transport + $tunjangan_tugas + $tunjangan_pulsa + $tunjangan_jabatan;
            $upah_lembur_perjam                 = $jumlah_upah / 173;
            $hasil_upah_lembur_perjam           = round($upah_lembur_perjam);

            $itemBpjsketenagakerjaans           = MaksimalUpahBpjsketenagakerjaans::where('id', 1)->first();
            $maksimal_upah_bpjs_ketenagakerjaan = $itemBpjsketenagakerjaans->maksimal_upah_bpjsketenagakerjaan;

            if ($jumlah_upah <= $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
            } elseif ($jumlah_upah > $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
            } else {
                dd('Salah');
            }

            $hasil_potongan_bpjsks_perusahaan   = 0;
            $hasil_potongan_bpjsks_karyawan     = 0;
            $hasil_potongan_jht_perusahaan      = 0;
            $hasil_potongan_jp_perusahaan       = 0;
            $hasil_potongan_jkm_perusahaan      = round($potongan_jkm_perusahaan, 0);
            $hasil_potongan_jkk_perusahaan      = round($potongan_jkk_perusahaan, 0);
            $hasil_potongan_jht_karyawan        = 0;
            $hasil_potongan_jp_karyawan         = 0;

            $jumlah_bpjstk_perusahaan           = $hasil_potongan_jht_perusahaan + $hasil_potongan_jp_perusahaan + $hasil_potongan_jkm_perusahaan + $hasil_potongan_jkk_perusahaan;
            $jumlah_bpjstk_karyawan             = $hasil_potongan_jht_karyawan + $hasil_potongan_jp_karyawan;
            $take_home_pay                      = $jumlah_upah - $jumlah_bpjstk_karyawan - $hasil_potongan_bpjsks_karyawan;
            //End Rumus
        }

        //Tidak Ikut JP, Hanya Ikut JHT, JKK Dan JKM Dan Ikut Kepesertaan BPJS Kesehatan
        elseif ($jht != 0 && $jp == 0 && $jkk != 0 && $jkm != 0 && $jkn != 0) {
            //End Rumus
            $jumlah_upah                        = $gaji_pokok + $uang_makan + $uang_transport + $tunjangan_tugas + $tunjangan_pulsa + $tunjangan_jabatan;
            $upah_lembur_perjam                 = $jumlah_upah / 173;
            $hasil_upah_lembur_perjam           = round($upah_lembur_perjam);

            $itemBpjskesehatans                 = MaksimalUpahBpjskesehatans::where('id', 1)->first();
            $itemBpjsketenagakerjaans           = MaksimalUpahBpjsketenagakerjaans::where('id', 1)->first();
            $maksimal_upah_bpjs_kesehatan       = $itemBpjskesehatans->maksimal_upah_bpjskesehatan;
            $maksimal_upah_bpjs_ketenagakerjaan = $itemBpjsketenagakerjaans->maksimal_upah_bpjsketenagakerjaan;

            if ($jumlah_upah <= $maksimal_upah_bpjs_kesehatan && $jumlah_upah <= $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_bpjsks_perusahaan     = $jumlah_upah * 4 / 100;
                $potongan_bpjsks_karyawan       = $jumlah_upah * 1 / 100;

                $potongan_jht_perusahaan        = $jumlah_upah * 3.7 / 100;
                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
                $potongan_jht_karyawan          = $jumlah_upah * 2 / 100;
            } elseif ($jumlah_upah <= $maksimal_upah_bpjs_kesehatan && $jumlah_upah > $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_bpjsks_perusahaan     = $jumlah_upah * 4 / 100;
                $potongan_bpjsks_karyawan       = $jumlah_upah * 1 / 100;

                $potongan_jht_perusahaan        = $jumlah_upah * 3.7 / 100;
                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
                $potongan_jht_karyawan          = $jumlah_upah * 2 / 100;
            } elseif ($jumlah_upah > $maksimal_upah_bpjs_kesehatan && $jumlah_upah > $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_bpjsks_perusahaan     = $maksimal_upah_bpjs_kesehatan * 4 / 100;
                $potongan_bpjsks_karyawan       = $maksimal_upah_bpjs_kesehatan * 1 / 100;

                $potongan_jht_perusahaan        = $jumlah_upah * 3.7 / 100;
                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
                $potongan_jht_karyawan          = $jumlah_upah * 2 / 100;
            } else {
                dd('Salah');
            }

            $hasil_potongan_bpjsks_perusahaan   = round($potongan_bpjsks_perusahaan, 0);
            $hasil_potongan_bpjsks_karyawan     = round($potongan_bpjsks_karyawan, 0);
            $hasil_potongan_jht_perusahaan      = round($potongan_jht_perusahaan, 0);
            $hasil_potongan_jp_perusahaan       = 0;
            $hasil_potongan_jkm_perusahaan      = round($potongan_jkm_perusahaan, 0);
            $hasil_potongan_jkk_perusahaan      = round($potongan_jkk_perusahaan, 0);
            $hasil_potongan_jht_karyawan        = round($potongan_jht_karyawan, 0);
            $hasil_potongan_jp_karyawan         = 0;

            $jumlah_bpjstk_perusahaan           = $hasil_potongan_jht_perusahaan + $hasil_potongan_jp_perusahaan + $hasil_potongan_jkm_perusahaan + $hasil_potongan_jkk_perusahaan;
            $jumlah_bpjstk_karyawan             = $hasil_potongan_jht_karyawan + $hasil_potongan_jp_karyawan;
            $take_home_pay                      = $jumlah_upah - $jumlah_bpjstk_karyawan - $hasil_potongan_bpjsks_karyawan;
            //End Rumus
        }

        //Tidak Ikut JP, dan BPJS Kesehatan, Hanya Ikut JHT, JKK , Dan JKM
        elseif ($jht != 0 && $jp == 0 && $jkk != 0 && $jkm != 0 && $jkn == 0) {
            //End Rumus
            $jumlah_upah                        = $gaji_pokok + $uang_makan + $uang_transport + $tunjangan_tugas + $tunjangan_pulsa + $tunjangan_jabatan;
            $upah_lembur_perjam                 = $jumlah_upah / 173;
            $hasil_upah_lembur_perjam           = round($upah_lembur_perjam);

            $itemBpjsketenagakerjaans           = MaksimalUpahBpjsketenagakerjaans::where('id', 1)->first();
            $maksimal_upah_bpjs_ketenagakerjaan = $itemBpjsketenagakerjaans->maksimal_upah_bpjsketenagakerjaan;

            if ($jumlah_upah <= $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_jht_perusahaan        = $jumlah_upah * 3.7 / 100;
                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
                $potongan_jht_karyawan          = $jumlah_upah * 2 / 100;
            } elseif ($jumlah_upah > $maksimal_upah_bpjs_ketenagakerjaan) {
                $potongan_jht_perusahaan        = $jumlah_upah * 3.7 / 100;
                $potongan_jkm_perusahaan        = $jumlah_upah * 0.3 / 100;
                $potongan_jkk_perusahaan        = $jumlah_upah * 0.24 / 100;
                $potongan_jht_karyawan          = $jumlah_upah * 2 / 100;
            } else {
                dd('Salah');
            }

            $hasil_potongan_bpjsks_perusahaan   = 0;
            $hasil_potongan_bpjsks_karyawan     = 0;
            $hasil_potongan_jht_perusahaan      = round($potongan_jht_perusahaan, 0);
            $hasil_potongan_jp_perusahaan       = 0;
            $hasil_potongan_jkm_perusahaan      = round($potongan_jkm_perusahaan, 0);
            $hasil_potongan_jkk_perusahaan      = round($potongan_jkk_perusahaan, 0);
            $hasil_potongan_jht_karyawan        = round($potongan_jht_karyawan, 0);
            $hasil_potongan_jp_karyawan         = 0;

            $jumlah_bpjstk_perusahaan           = $hasil_potongan_jht_perusahaan + $hasil_potongan_jp_perusahaan + $hasil_potongan_jkm_perusahaan + $hasil_potongan_jkk_perusahaan;
            $jumlah_bpjstk_karyawan             = $hasil_potongan_jht_karyawan + $hasil_potongan_jp_karyawan;
            $take_home_pay                      = $jumlah_upah - $jumlah_bpjstk_karyawan - $hasil_potongan_bpjsks_karyawan;
            //End Rumus
        }

        //Kondisi Salah
        else {
            dd('Kondisi Salah');
        }

        $salary = HistorySalaries::where('employees_id', $employees_id)->first();
        $salary->update([
            'gaji_pokok'                    => $gaji_pokok,
            'uang_makan'                    => $uang_makan,
            'uang_transport'                => $uang_transport,
            'tunjangan_tugas'               => $tunjangan_tugas,
            'tunjangan_pulsa'               => $tunjangan_pulsa,
            'tunjangan_jabatan'             => $tunjangan_jabatan,
            'jumlah_upah'                   => $jumlah_upah,
            // 'upah_lembur_perjam'            => $hasil_upah_lembur_perjam,
            'potongan_bpjsks_perusahaan'    => $hasil_potongan_bpjsks_perusahaan,
            'potongan_jht_perusahaan'       => $hasil_potongan_jht_perusahaan,
            'potongan_jp_perusahaan'        => $hasil_potongan_jp_perusahaan,
            'potongan_jkm_perusahaan'       => $hasil_potongan_jkm_perusahaan,
            'potongan_jkk_perusahaan'       => $hasil_potongan_jkk_perusahaan,
            'jumlah_bpjstk_perusahaan'      => $jumlah_bpjstk_perusahaan,
            'potongan_bpjsks_karyawan'      => $hasil_potongan_bpjsks_karyawan,
            'potongan_jht_karyawan'         => $hasil_potongan_jht_karyawan,
            'potongan_jp_karyawan'          => $hasil_potongan_jp_karyawan,
            'jumlah_bpjstk_karyawan'        => $jumlah_bpjstk_karyawan,
            'take_home_pay'                 => $take_home_pay,
            'edit_oleh'                     => $request->input('edit_oleh')
        ]);

        Alert::info('Success Edit Data Salary', 'Oleh ' . auth()->user()->name);
        return redirect()->route('proses.proses_rekon_salary');
    }
    public function export_excell_rekon_salary()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        return Excel::download(new RekonSalaryExport, 'rekonsalary.xlsx');
    }
    //SALARY

    //OVERTIME

    //OVERTIME


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
