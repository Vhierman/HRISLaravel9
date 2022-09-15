<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Admin\Employees;
use App\Models\Admin\Areas;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use App\Models\Admin\HistoryContracts;
use App\Models\Admin\HistorySalaries;
use App\Models\Admin\RekapSalaries;
use App\Models\Admin\MaksimalBpjskesehatans;
use App\Models\Admin\MaksimalBpjsketenagakerjaans;
use App\Http\Requests\Admin\ProsesRequest;
use App\Http\Requests\Admin\ProsesPKWTHarianRequest;
use App\Http\Requests\Admin\ProsesPerpanjangPKWTHarianRequest;
use App\Http\Requests\Admin\ProsesPerpanjangPKWTKontrakRequest;
// use App\Http\Requests\Admin\RekonSalaryRequest;
// use App\Http\Requests\Admin\EditSalaryRequest;
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

        $items              = Employees::where('tanggal_akhir_kerja', $akhirkontrak)->where('status_kerja', 'Harian')->where('golongans_id', $golongan)->get();

        foreach ($items as $item) {
            HistoryContracts::create([
                'employees_id'                  => $item->nik_karyawan,
                'tanggal_awal_kontrak'          => $awal_kontrak,
                'tanggal_akhir_kontrak'         => $akhir_kontrak,
                'status_kontrak_kerja'          => 'Harian',
                'masa_kontrak'                  => '1 Bulan',
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

        $items              = Employees::where('tanggal_akhir_kerja', $akhirkontrak)->where('status_kerja', 'PKWT')->get();

        foreach ($items as $item) {
            HistoryContracts::create([
                'employees_id'                  => $item->nik_karyawan,
                'tanggal_awal_kontrak'          => $awal_kontrak,
                'tanggal_akhir_kontrak'         => $akhir_kontrak,
                'status_kontrak_kerja'          => 'PKWT',
                'masa_kontrak'                  => '1 Bulan',
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
