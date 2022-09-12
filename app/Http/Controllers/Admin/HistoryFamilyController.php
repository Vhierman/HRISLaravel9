<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employees;
use App\Models\Admin\HistoryFamilies;
use App\Http\Requests\Admin\HistoryFamilyRequest;
use App\Http\Requests\Admin\HistoryFamilyUpdateRequest;
use File;
use Storage;
use Alert;

class HistoryFamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function tambahhistoryfamily($nik_karyawan)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $item               = Employees::where('nik_karyawan', $nik_karyawan)->first();
        $historyfamilies    = HistoryFamilies::with([
            'employees'
            ])->where('employees_id', $nik_karyawan)->first();
        
        return view ('pages.admin.history-family.create',[
            'item'              => $item,
            'historyfamilies'   => $historyfamilies
        ]);
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
    public function store(HistoryFamilyRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $data['dokumen_history_keluarga']  = $request->file('dokumen_history_keluarga')->store(
            'assets/dokumenhistorykeluarga','public'
        );

        HistoryFamilies::create([
            'employees_id'                          => $request->input('employees_id'),
            'hubungan_keluarga'                     => $request->input('hubungan_keluarga'),
            'nik_history_keluarga'                  => $request->input('nik_history_keluarga'),
            'nomor_bpjs_kesehatan_history_keluarga' => $request->input('nomor_bpjs_kesehatan_history_keluarga'),
            'nama_history_keluarga'                 => $request->input('nama_history_keluarga'),
            'jenis_kelamin_history_keluarga'        => $request->input('jenis_kelamin_history_keluarga'),
            'tempat_lahir_history_keluarga'         => $request->input('tempat_lahir_history_keluarga'),
            'tanggal_lahir_history_keluarga'        => $request->input('tanggal_lahir_history_keluarga'),
            'golongan_darah_history_keluarga'       => $request->input('golongan_darah_history_keluarga'),
            'dokumen_history_keluarga'              => $data['dokumen_history_keluarga'],
            'input_oleh'                            => $request->input('input_oleh')
        ]);

        $employees  = Employees::where('nik_karyawan', $request->input('employees_id'))->first();
        Alert::success('Success Input Data History Keluarga','Oleh '.auth()->user()->name);
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
        $itemhistory            = HistoryFamilies::findOrFail($id);
        $nikkaryawan            = $itemhistory->employees_id;
        $item                   = Employees::where('nik_karyawan', $nikkaryawan)->first();
        $historyfamilies        = HistoryFamilies::where('id', $id)->first();

        return view ('pages.admin.history-family.edit',[
            'item'              => $item,
            'historyfamilies'   => $historyfamilies
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HistoryFamilyUpdateRequest $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $itemhistory    = HistoryFamilies::findOrFail($id);
        $nikkaryawan    = $itemhistory->employees_id;
        $itemkaryawan   = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $data           = $request->all();
        $item           = HistoryFamilies::findOrFail($id);

        //Unlink / Tambah Storage Images
        $dokumenkeluarga            = $itemhistory->dokumen_history_keluarga;
        $dokumen_history_keluarga   = $request->file('dokumen_history_keluarga');

        if(Storage::exists('public/'.$dokumenkeluarga) && $dokumen_history_keluarga <> null){
            Storage::delete('public/'.$dokumenkeluarga);
            $data['dokumen_history_keluarga'] = $request->file('dokumen_history_keluarga')->store(
                'assets/dokumenhistorykeluarga','public'
            );
        }
        elseif (Storage::exists('public/'.$dokumenkeluarga) && $dokumen_history_keluarga == null ) {
            $data['dokumen_history_keluarga'] = $dokumenkeluarga;
        }
        else{
            dd('File does not exists.');
        }
        
        $item->update($data);
        Alert::info('Success Edit Data History Keluarga','Oleh '.auth()->user()->name);
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
        $item = HistoryFamilies::findOrFail($id);

        //Hapus Oleh
        $item->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh

        $nikkaryawan    = $item->employees_id;
        $itemkaryawan   = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $dokumenkeluarga           = $item->dokumen_history_keluarga;
        Storage::delete('public/'.$dokumenkeluarga);

        $item->delete();
        Alert::error('Menghapus Data History Keluarga','Oleh '.auth()->user()->name);
        return redirect()->route('employee.show',$itemkaryawan->id);
    }
}
