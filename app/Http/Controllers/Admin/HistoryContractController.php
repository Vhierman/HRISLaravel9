<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\EmployeesRequest;
use App\Http\Requests\Admin\HistoryContractRequest;
use App\Models\Admin\Employees;
use App\Models\Admin\HistoryContracts;
use App\Models\Admin\Companies;
use App\Models\Admin\WorkingHours;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use App\Models\Admin\Areas;
use DB;
use Alert;

class HistoryContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    public function tambahhistorykontrak($nik_karyawan)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $item       = Employees::where('nik_karyawan', $nik_karyawan)->first();

        $historycontracts = HistoryContracts::with([
            'employees'
            ])->where('employees_id', $nik_karyawan)->first();

        return view ('pages.admin.history-contract.create',[
            'item'                  => $item,
            'historycontracts'      => $historycontracts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HistoryContractRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        //Hitung Bulan
        $date1          = date_create($request->input('tanggal_awal_kontrak')); 
        $date2          = date_create($request->input('tanggal_akhir_kontrak')); 
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

        //Insert History Contracts
        HistoryContracts::create([
            'employees_id'          => $request->input('nik_karyawan'),
            'tanggal_awal_kontrak'  => $request->input('tanggal_awal_kontrak'),
            'tanggal_akhir_kontrak' => $request->input('tanggal_akhir_kontrak'),
            'status_kontrak_kerja'  => $request->input('status_kontrak_kerja'),
            'masa_kontrak'          => $masakontrak,
            'jumlah_kontrak'        => 1,
            'input_oleh'            => $request->input('input_oleh')
        ]);
        //Insert History Contracts

        // Update Employees
        $employees                  = Employees::where('nik_karyawan', $request->input('nik_karyawan'))->first();
        $employees->update([
            'tanggal_akhir_kerja'   => $request->input('tanggal_akhir_kontrak'),
            'status_kerja'          => $request->input('status_kontrak_kerja'),
            'edit_oleh'             => $request->input('input_oleh')
        ]);
        //Update Employees
        Alert::success('Success Input Data History Kontrak','Oleh '.auth()->user()->name);
        return redirect()->route('employee.show',$employees->id);
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
        $itemhistory        = HistoryContracts::findOrFail($id);
        $nikkaryawan        = $itemhistory->employees_id;
        $item               = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $historycontracts   = HistoryContracts::where('id', $id)->first();

        return view ('pages.admin.history-contract.edit',[
            'item'                  => $item,
            'historycontracts'      => $historycontracts
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HistoryContractRequest $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $itemhistory    = HistoryContracts::findOrFail($id);
        $nikkaryawan    = $itemhistory->employees_id;
        $itemkaryawan   = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $data = $request->all();
        $item = HistoryContracts::findOrFail($id);
        $item->update($data);
        Alert::info('Success Edit Data History Kontrak','Oleh '.auth()->user()->name);
        return redirect()->route('employee.show',$itemkaryawan->id);
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
        $item = HistoryContracts::findOrFail($id);

        $nikkaryawan    = $item->employees_id;
        $itemkaryawan   = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $item->delete();
        Alert::error('Menghapus Data History Kontrak','Oleh '.auth()->user()->name);
        return redirect()->route('employee.show',$itemkaryawan->id);
    }
}
