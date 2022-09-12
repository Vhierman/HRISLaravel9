<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\EmployeesRequest;
use App\Http\Requests\Admin\HistoryPositionRequest;
use App\Http\Requests\Admin\HistoryPositionUpdateRequest;
use App\Models\Admin\Employees;
use App\Models\Admin\HistoryPositions;
use App\Models\Admin\Companies;
use App\Models\Admin\WorkingHours;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use App\Models\Admin\Areas;
use File;
use Storage;
use Alert;

class HistoryPositionController extends Controller
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

    public function tambahhistoryjabatan($nik_karyawan)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $item           = Employees::where('nik_karyawan', $nik_karyawan)->first();

        $companies      = Companies::all();
        $divisions      = Divisions::all();
        $positions      = Positions::all();
        $areas          = Areas::all();

        $historypositions = HistoryPositions::with([
            'employees'
            ])->where('employees_id', $nik_karyawan)->first();

        return view ('pages.admin.history-position.create',[
            'item'                  => $item,
            'companies'             => $companies,
            'areas'                 => $areas,
            'divisions'             => $divisions,
            'positions'             => $positions,
            'historypositions'      => $historypositions
        ]);
    }
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
    public function store(HistoryPositionRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $data['file_surat_mutasi']  = $request->file('file_surat_mutasi')->store(
            'assets/suratmutasi','public'
        );

        HistoryPositions::create([
            'employees_id'          => $request->input('employees_id'),
            'companies_id_history'  => $request->input('companies_id_history'),
            'areas_id_history'      => $request->input('areas_id_history'),
            'divisions_id_history'  => $request->input('divisions_id_history'),
            'positions_id_history'  => $request->input('positions_id_history'),
            'tanggal_mutasi'        => $request->input('tanggal_mutasi'),
            'file_surat_mutasi'     => $data['file_surat_mutasi'],
            'input_oleh'            => $request->input('input_oleh')
        ]);

        // Update Employees
        $employees                  = Employees::where('nik_karyawan', $request->input('employees_id'))->first();
        $employees->update([
            'companies_id'          => $request->input('companies_id_history'),
            'areas_id'              => $request->input('areas_id_history'),
            'divisions_id'          => $request->input('divisions_id_history'),
            'positions_id'          => $request->input('positions_id_history'),
            'edit_oleh'             => $request->input('input_oleh')
        ]);
        //Update Employees

        $employees                  = Employees::where('nik_karyawan', $request->input('employees_id'))->first();
        Alert::success('Success Input Data History Jabatan','Oleh '.auth()->user()->name);
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
        $itemhistory            = HistoryPositions::findOrFail($id);

        $nikkaryawan            = $itemhistory->employees_id;
        $item                   = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $historypositions       = HistoryPositions::where('id', $id)->first();

        $companies              = Companies::all();
        $divisions              = Divisions::all();
        $positions              = Positions::all();
        $areas                  = Areas::all();

        return view ('pages.admin.history-position.edit',[
            'item'              => $item,
            'companies'         => $companies,
            'divisions'         => $divisions,
            'positions'         => $positions,
            'areas'             => $areas,
            'historypositions'  => $historypositions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HistoryPositionUpdateRequest $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $itemhistory    = HistoryPositions::findOrFail($id);
        $nikkaryawan    = $itemhistory->employees_id;
        $itemkaryawan   = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $data = $request->all();
        $item = HistoryPositions::findOrFail($id);

        //Unlink / Tambah Storage Images
        $surat_mutasi           = $itemhistory->file_surat_mutasi;
        $file_surat_mutasi      = $request->file('file_surat_mutasi');

        if(Storage::exists('public/'.$surat_mutasi) && $file_surat_mutasi <> null){
            Storage::delete('public/'.$surat_mutasi);
            $data['file_surat_mutasi'] = $request->file('file_surat_mutasi')->store(
                'assets/suratmutasi','public'
            );
        }
        elseif (Storage::exists('public/'.$surat_mutasi) && $file_surat_mutasi == null ) {
            $data['file_surat_mutasi'] = $surat_mutasi;
        }
        else{
            dd('File does not exists.');
        }
        
        $item->update($data);
        Alert::info('Success Edit Data History Jabatan','Oleh '.auth()->user()->name);
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
        $item = HistoryPositions::findOrFail($id);

        //Hapus Oleh
        $item->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh

        $nikkaryawan    = $item->employees_id;
        $itemkaryawan   = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $surat_mutasi           = $item->file_surat_mutasi;
        Storage::delete('public/'.$surat_mutasi);

        $item->delete();
        Alert::error('Menghapus Data History Jabatan','Oleh '.auth()->user()->name);
        return redirect()->route('employee.show',$itemkaryawan->id);
    }
}
