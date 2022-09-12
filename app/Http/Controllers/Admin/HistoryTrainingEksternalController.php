<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\HistoryTrainingEksternalRequest;
use App\Http\Requests\Admin\HistoryTrainingEksternalMultipleViewRequest;
use App\Models\Admin\Employees;
use App\Models\Admin\Companies;
use App\Models\Admin\Areas;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use App\Models\Admin\HistoryTrainingEksternals;
use DB;
use Alert;

class HistoryTrainingEksternalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function tambahhistorytrainingeksternal($nik_karyawan)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $item       = Employees::where('nik_karyawan', $nik_karyawan)->first();

        $historytrainingeksternals = HistoryTrainingEksternals::with([
            'employees'
            ])->where('employees_id', $nik_karyawan)->first();

        return view ('pages.admin.history-training-eksternal.create',[
            'item'                      => $item,
            'historytrainingeksternals' => $historytrainingeksternals
        ]);

    }

    public function index()
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER' && auth()->user()->roles != 'MANAGER HRD') {
            abort(403);
        }

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Produksi
        if ($divisi == 11) {
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_awal_training_eksternal) as jumlah'),'tanggal_awal_training_eksternal', 'institusi_penyelenggara_training_eksternal','perihal_training_eksternal','lokasi_training_eksternal')
            ->groupByRaw('tanggal_awal_training_eksternal, institusi_penyelenggara_training_eksternal,perihal_training_eksternal,lokasi_training_eksternal')
            ->whereIn('divisions_id', [11])
            ->where('history_training_eksternals.deleted_at',NULL)
            ->get();
        } 
        //IC
        elseif($divisi == 2){
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_awal_training_eksternal) as jumlah'),'tanggal_awal_training_eksternal', 'institusi_penyelenggara_training_eksternal','perihal_training_eksternal','lokasi_training_eksternal')
            ->groupByRaw('tanggal_awal_training_eksternal, institusi_penyelenggara_training_eksternal,perihal_training_eksternal,lokasi_training_eksternal')
            ->whereIn('divisions_id', [2])
            ->where('history_training_eksternals.deleted_at',NULL)
            ->get();
        }
        //Engineering
        elseif($divisi == 7){
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_awal_training_eksternal) as jumlah'),'tanggal_awal_training_eksternal', 'institusi_penyelenggara_training_eksternal','perihal_training_eksternal','lokasi_training_eksternal')
            ->groupByRaw('tanggal_awal_training_eksternal, institusi_penyelenggara_training_eksternal,perihal_training_eksternal,lokasi_training_eksternal')
            ->whereIn('divisions_id', [7])
            ->where('history_training_eksternals.deleted_at',NULL)
            ->get();
        }
        //Quality
        elseif($divisi == 8){
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_awal_training_eksternal) as jumlah'),'tanggal_awal_training_eksternal', 'institusi_penyelenggara_training_eksternal','perihal_training_eksternal','lokasi_training_eksternal')
            ->groupByRaw('tanggal_awal_training_eksternal, institusi_penyelenggara_training_eksternal,perihal_training_eksternal,lokasi_training_eksternal')
            ->whereIn('divisions_id', [8])
            ->where('history_training_eksternals.deleted_at',NULL)
            ->get();
        }
        //Purchasing
        elseif($divisi == 9){
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_awal_training_eksternal) as jumlah'),'tanggal_awal_training_eksternal', 'institusi_penyelenggara_training_eksternal','perihal_training_eksternal','lokasi_training_eksternal')
            ->groupByRaw('tanggal_awal_training_eksternal, institusi_penyelenggara_training_eksternal,perihal_training_eksternal,lokasi_training_eksternal')
            ->whereIn('divisions_id', [9])
            ->where('history_training_eksternals.deleted_at',NULL)
            ->get();
        }
        //PPC
        elseif($divisi == 10){
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_awal_training_eksternal) as jumlah'),'tanggal_awal_training_eksternal', 'institusi_penyelenggara_training_eksternal','perihal_training_eksternal','lokasi_training_eksternal')
            ->groupByRaw('tanggal_awal_training_eksternal, institusi_penyelenggara_training_eksternal,perihal_training_eksternal,lokasi_training_eksternal')
            ->whereIn('divisions_id', [12,13,14,15,18])
            ->where('history_training_eksternals.deleted_at',NULL)
            ->get();
        }
        //PDC
        elseif($divisi == 19){
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_awal_training_eksternal) as jumlah'),'tanggal_awal_training_eksternal', 'institusi_penyelenggara_training_eksternal','perihal_training_eksternal','lokasi_training_eksternal')
            ->groupByRaw('tanggal_awal_training_eksternal, institusi_penyelenggara_training_eksternal,perihal_training_eksternal,lokasi_training_eksternal')
            ->whereIn('divisions_id', [19,20,21,22])
            ->where('history_training_eksternals.deleted_at',NULL)
            ->get();
        }
        //HRD-GA
        elseif($divisi == 4){
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_awal_training_eksternal) as jumlah'),'tanggal_awal_training_eksternal', 'institusi_penyelenggara_training_eksternal','perihal_training_eksternal','lokasi_training_eksternal')
            ->groupByRaw('tanggal_awal_training_eksternal, institusi_penyelenggara_training_eksternal,perihal_training_eksternal,lokasi_training_eksternal')
            ->where('history_training_eksternals.deleted_at',NULL)
            ->get();
        }
        else {
            abort(403);
        }
        
        return view('pages.admin.history-training-eksternal.index',[
            'items' => $items
        ]);
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

        $items = Employees::with([
            'companies',
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.history-training-eksternal.createmultiple',[
            'items' => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storemultipletrainingeksternal(HistoryTrainingEksternalRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $tanggalawal    = $request->input('tanggal_awal_training_eksternal');
        $hariawal       = \Carbon\Carbon::parse($tanggalawal)->isoformat('dddd');
        $tanggalakhir   = $request->input('tanggal_akhir_training_eksternal');
        $hariakhir      = \Carbon\Carbon::parse($tanggalakhir)->isoformat('dddd');

        foreach ($request->input('employees_id') as $key=>$name) {
            $insert =[
                'employees_id'                                  => $request->input('employees_id')[$key],
                'institusi_penyelenggara_training_eksternal'    => $request->input('institusi_penyelenggara_training_eksternal'),
                'perihal_training_eksternal'                    => $request->input('perihal_training_eksternal'),
                'hari_awal_training_eksternal'                  => $hariawal,
                'hari_akhir_training_eksternal'                 => $hariakhir,
                'tanggal_awal_training_eksternal'               => $tanggalawal,
                'tanggal_akhir_training_eksternal'              => $tanggalakhir,
                'jam_training_eksternal'                        => $request->input('jam_training_eksternal'),
                'lokasi_training_eksternal'                     => $request->input('lokasi_training_eksternal'),
                'alamat_training_eksternal'                     => $request->input('alamat_training_eksternal'),
                'input_oleh'                                    => $request->input('input_oleh')
            ];
            HistoryTrainingEksternals::create($insert);
        }

        Alert::success('Success Input Data Training Eksternal','Oleh '.auth()->user()->name);
        //Redirect
        return redirect()->route('history_training_eksternal.index');
    }

    public function store(HistoryTrainingEksternalRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $tanggalawal    = $request->input('tanggal_awal_training_eksternal');
        $tanggalakhir   = $request->input('tanggal_akhir_training_eksternal');
        $hariawal       = \Carbon\Carbon::parse($tanggalawal)->isoformat('dddd');
        $hariakhir      = \Carbon\Carbon::parse($tanggalakhir)->isoformat('dddd');

        //Insert History Training Eksternal
        HistoryTrainingEksternals::create([
            'employees_id'                                  => $request->input('nik_karyawan'),
            'institusi_penyelenggara_training_eksternal'    => $request->input('institusi_penyelenggara_training_eksternal'),
            'perihal_training_eksternal'                    => $request->input('perihal_training_eksternal'),
            'hari_awal_training_eksternal'                  => $hariawal,
            'hari_akhir_training_eksternal'                 => $hariakhir,
            'tanggal_awal_training_eksternal'               => $request->input('tanggal_awal_training_eksternal'),
            'tanggal_akhir_training_eksternal'              => $request->input('tanggal_akhir_training_eksternal'),
            'jam_training_eksternal'                        => $request->input('jam_training_eksternal'),
            'lokasi_training_eksternal'                     => $request->input('lokasi_training_eksternal'),
            'alamat_training_eksternal'                     => $request->input('alamat_training_eksternal'),
            'input_oleh'                                    => $request->input('input_oleh')
        ]);
        $employees  = Employees::where('nik_karyawan', $request->input('nik_karyawan'))->first();
        //Insert History Training Eksternal
        Alert::success('Success Input Data Training Eksternal','Oleh '.auth()->user()->name);
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
        $itemhistory        = HistoryTrainingEksternals::findOrFail($id);
        $nikkaryawan        = $itemhistory->employees_id;
        $item               = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $historytrainingeksternals   = HistoryTrainingEksternals::where('id', $id)->first();

        return view ('pages.admin.history-training-eksternal.edit',[
            'item'                      => $item,
            'historytrainingeksternals' => $historytrainingeksternals
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tampilmultipletrainingeksternal(HistoryTrainingEksternalMultipleViewRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }
        
        $institusi_penyelenggara_training_eksternal = $request->input('institusi_penyelenggara_training_eksternal');
        $perihal_training_eksternal                 = $request->input('perihal_training_eksternal');
        $tanggal_awal_training_eksternal            = $request->input('tanggal_awal_training_eksternal');
        $lokasi_training_eksternal                  = $request->input('lokasi_training_eksternal');

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Produksi
        if ($divisi == 11) {
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where([
                ['institusi_penyelenggara_training_eksternal','=',$institusi_penyelenggara_training_eksternal],
                ['perihal_training_eksternal','=',$perihal_training_eksternal],
                ['tanggal_awal_training_eksternal','=',$tanggal_awal_training_eksternal],
                ['lokasi_training_eksternal','=',$lokasi_training_eksternal],
                ['divisions_id','=',11],
                ['history_training_eksternals.deleted_at','=',NULL]
            ])
            ->get();
        }
        //IC
        elseif ($divisi == 2) {
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where([
                ['institusi_penyelenggara_training_eksternal','=',$institusi_penyelenggara_training_eksternal],
                ['perihal_training_eksternal','=',$perihal_training_eksternal],
                ['tanggal_awal_training_eksternal','=',$tanggal_awal_training_eksternal],
                ['lokasi_training_eksternal','=',$lokasi_training_eksternal],
                ['divisions_id','=',2],
                ['history_training_eksternals.deleted_at','=',NULL]
            ])
            ->get();
        } 
        //Engineering
        elseif ($divisi == 7) {
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where([
                ['institusi_penyelenggara_training_eksternal','=',$institusi_penyelenggara_training_eksternal],
                ['perihal_training_eksternal','=',$perihal_training_eksternal],
                ['tanggal_awal_training_eksternal','=',$tanggal_awal_training_eksternal],
                ['lokasi_training_eksternal','=',$lokasi_training_eksternal],
                ['divisions_id','=',7],
                ['history_training_eksternals.deleted_at','=',NULL]
            ])
            ->get();
        } 
        //Quality
        elseif ($divisi == 8) {
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where([
                ['institusi_penyelenggara_training_eksternal','=',$institusi_penyelenggara_training_eksternal],
                ['perihal_training_eksternal','=',$perihal_training_eksternal],
                ['tanggal_awal_training_eksternal','=',$tanggal_awal_training_eksternal],
                ['lokasi_training_eksternal','=',$lokasi_training_eksternal],
                ['divisions_id','=',8],
                ['history_training_eksternals.deleted_at','=',NULL]
            ])
            ->get();
        } 
        //Purchasing
        elseif ($divisi == 9) {
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where([
                ['institusi_penyelenggara_training_eksternal','=',$institusi_penyelenggara_training_eksternal],
                ['perihal_training_eksternal','=',$perihal_training_eksternal],
                ['tanggal_awal_training_eksternal','=',$tanggal_awal_training_eksternal],
                ['lokasi_training_eksternal','=',$lokasi_training_eksternal],
                ['divisions_id','=',9],
                ['history_training_eksternals.deleted_at','=',NULL]
            ])
            ->get();
        } 
        //PPC
        elseif ($divisi == 10) {
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where([
                ['institusi_penyelenggara_training_eksternal','=',$institusi_penyelenggara_training_eksternal],
                ['perihal_training_eksternal','=',$perihal_training_eksternal],
                ['tanggal_awal_training_eksternal','=',$tanggal_awal_training_eksternal],
                ['lokasi_training_eksternal','=',$lokasi_training_eksternal],
                ['history_training_eksternals.deleted_at','=',NULL]
            ])
            ->whereIn('divisions_id', [12,13,14,15,18])
            ->get();
        } 
        //PDC
        elseif ($divisi == 19) {
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where([
                ['institusi_penyelenggara_training_eksternal','=',$institusi_penyelenggara_training_eksternal],
                ['perihal_training_eksternal','=',$perihal_training_eksternal],
                ['tanggal_awal_training_eksternal','=',$tanggal_awal_training_eksternal],
                ['lokasi_training_eksternal','=',$lokasi_training_eksternal],
                ['history_training_eksternals.deleted_at','=',NULL]
            ])
            ->whereIn('divisions_id', [19,20,21,22])
            ->get();
        } 
        //HRD-GA
        elseif ($divisi == 4) {
            $items = DB::table('history_training_eksternals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_eksternals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where([
                ['institusi_penyelenggara_training_eksternal','=',$institusi_penyelenggara_training_eksternal],
                ['perihal_training_eksternal','=',$perihal_training_eksternal],
                ['tanggal_awal_training_eksternal','=',$tanggal_awal_training_eksternal],
                ['lokasi_training_eksternal','=',$lokasi_training_eksternal],
                ['history_training_eksternals.deleted_at','=',NULL]
            ])
            ->get();
        } 
        else {
            abort(403);
        }

        return view('pages.admin.history-training-eksternal.viewmultiple',[
            'items' => $items
        ]);
    }

    public function update(HistoryTrainingEksternalRequest $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $itemhistory    = HistoryTrainingEksternals::findOrFail($id);
        $nikkaryawan    = $itemhistory->employees_id;
        $itemkaryawan   = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $tanggalawal    = $request->input('tanggal_awal_training_eksternal');
        $tanggalakhir   = $request->input('tanggal_akhir_training_eksternal');
        $hariawal       = \Carbon\Carbon::parse($tanggalawal)->isoformat('dddd');
        $hariakhir      = \Carbon\Carbon::parse($tanggalakhir)->isoformat('dddd');

        $data           = $request->all();
        $item           = HistoryTrainingEksternals::findOrFail($id);

        $item->update([
            'institusi_penyelenggara_training_eksternal'    => $request->input('institusi_penyelenggara_training_eksternal'),
            'perihal_training_eksternal'                    => $request->input('perihal_training_eksternal'),
            'hari_awal_training_eksternal'                  => $hariawal,
            'hari_akhir_training_eksternal'                 => $hariakhir,
            'tanggal_awal_training_eksternal'               => $request->input('tanggal_awal_training_eksternal'),
            'tanggal_akhir_training_eksternal'              => $request->input('tanggal_akhir_training_eksternal'),
            'jam_training_eksternal'                        => $request->input('jam_training_eksternal'),
            'lokasi_training_eksternal'                     => $request->input('lokasi_training_eksternal'),
            'alamat_training_eksternal'                     => $request->input('alamat_training_eksternal'),
            'edit_oleh'                                     => $request->input('edit_oleh')
        ]);
        Alert::info('Success Edit Data Training Eksternal','Oleh '.auth()->user()->name);
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
        $item = HistoryTrainingEksternals::findOrFail($id);

        //Hapus Oleh
        $item->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh

        $nikkaryawan    = $item->employees_id;
        $itemkaryawan   = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $item->delete();
        Alert::error('Menghapus Data Training Eksternal','Oleh '.auth()->user()->name);
        return redirect()->route('employee.show',$itemkaryawan->id);
    }
}
