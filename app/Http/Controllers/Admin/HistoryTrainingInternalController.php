<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\HistoryTrainingInternalRequest;
use App\Http\Requests\Admin\HistoryTrainingInternalMultipleViewRequest;
use App\Models\Admin\Employees;
use App\Models\Admin\Companies;
use App\Models\Admin\Areas;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use App\Models\Admin\HistoryTrainingInternals;
use DB;
use Alert;

class HistoryTrainingInternalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambahhistorytraininginternal($nik_karyawan)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $item       = Employees::where('nik_karyawan', $nik_karyawan)->first();

        $historytraininginternals = HistoryTrainingInternals::with([
            'employees'
            ])->where('employees_id', $nik_karyawan)->first();

        return view ('pages.admin.history-training-internal.create',[
            'item'                      => $item,
            'historytraininginternals'  => $historytraininginternals
        ]);

    }

    public function index()
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Produksi
        if ($divisi == 11) {
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_training_internal) as jumlah'),'tanggal_training_internal', 'materi_training_internal','jam_training_internal','trainer_training_internal')
            ->groupByRaw('tanggal_training_internal, materi_training_internal,jam_training_internal,trainer_training_internal')
            ->whereIn('divisions_id', [11])
            ->where('history_training_internals.deleted_at',NULL)
            ->get();
        }
        //IC
        elseif($divisi == 2){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_training_internal) as jumlah'),'tanggal_training_internal', 'materi_training_internal','jam_training_internal','trainer_training_internal')
            ->groupByRaw('tanggal_training_internal, materi_training_internal,jam_training_internal,trainer_training_internal')
            ->whereIn('divisions_id', [2])
            ->where('history_training_internals.deleted_at',NULL)
            ->get();
        } 
        //Engineering
        elseif($divisi == 7){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_training_internal) as jumlah'),'tanggal_training_internal', 'materi_training_internal','jam_training_internal','trainer_training_internal')
            ->groupByRaw('tanggal_training_internal, materi_training_internal,jam_training_internal,trainer_training_internal')
            ->whereIn('divisions_id', [7])
            ->where('history_training_internals.deleted_at',NULL)
            ->get();
        } 
        //Quality
        elseif($divisi == 8){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_training_internal) as jumlah'),'tanggal_training_internal', 'materi_training_internal','jam_training_internal','trainer_training_internal')
            ->groupByRaw('tanggal_training_internal, materi_training_internal,jam_training_internal,trainer_training_internal')
            ->whereIn('divisions_id', [8])
            ->where('history_training_internals.deleted_at',NULL)
            ->get();
        } 
        //Purchasing
        elseif($divisi == 9){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_training_internal) as jumlah'),'tanggal_training_internal', 'materi_training_internal','jam_training_internal','trainer_training_internal')
            ->groupByRaw('tanggal_training_internal, materi_training_internal,jam_training_internal,trainer_training_internal')
            ->whereIn('divisions_id', [9])
            ->where('history_training_internals.deleted_at',NULL)
            ->get();
        } 
        //PPC
        elseif($divisi == 10){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_training_internal) as jumlah'),'tanggal_training_internal', 'materi_training_internal','jam_training_internal','trainer_training_internal')
            ->groupByRaw('tanggal_training_internal, materi_training_internal,jam_training_internal,trainer_training_internal')
            ->whereIn('divisions_id', [12,13,14,15,18])
            ->where('history_training_internals.deleted_at',NULL)
            ->get();
        } 
        //PDC
        elseif($divisi == 19){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_training_internal) as jumlah'),'tanggal_training_internal', 'materi_training_internal','jam_training_internal','trainer_training_internal')
            ->groupByRaw('tanggal_training_internal, materi_training_internal,jam_training_internal,trainer_training_internal')
            ->whereIn('divisions_id', [19,20,21,22])
            ->where('history_training_internals.deleted_at',NULL)
            ->get();
        } 
        //HRD-GA
        elseif($divisi == 4){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->select(DB::raw('count(tanggal_training_internal) as jumlah'),'tanggal_training_internal', 'materi_training_internal','jam_training_internal','trainer_training_internal')
            ->groupByRaw('tanggal_training_internal, materi_training_internal,jam_training_internal,trainer_training_internal')
            ->where('history_training_internals.deleted_at',NULL)
            ->get();
        } 
        else {
            abort(403);
        }

        return view('pages.admin.history-training-internal.index',[
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

        return view ('pages.admin.history-training-internal.createmultiple',[
            'items' => $items
        ]);
    }

    public function storemultipletraininginternal(HistoryTrainingInternalRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $tanggal    = $request->input('tanggal_training_internal');
        $hari       = \Carbon\Carbon::parse($tanggal)->isoformat('dddd');

        foreach ($request->input('employees_id') as $key=>$name) {
            $insert =[
                'employees_id'                  => $request->input('employees_id')[$key],
                'hari_training_internal'        => $hari,
                'tanggal_training_internal'     => $request->input('tanggal_training_internal'),
                'jam_training_internal'         => $request->input('jam_training_internal'),
                'lokasi_training_internal'      => $request->input('lokasi_training_internal'),
                'materi_training_internal'      => $request->input('materi_training_internal'),
                'trainer_training_internal'     => $request->input('trainer_training_internal'),
                'input_oleh'                    => $request->input('input_oleh')
            ];
            HistoryTrainingInternals::create($insert);
        }

        Alert::success('Success Input Data Training Internal','Oleh '.auth()->user()->name);
        //Redirect
        return redirect()->route('history_training_internal.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HistoryTrainingInternalRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $tanggal    = $request->input('tanggal_training_internal');
        $hari       = \Carbon\Carbon::parse($tanggal)->isoformat('dddd');

        //Insert History Training Internal
        HistoryTrainingInternals::create([
            'employees_id'                  => $request->input('nik_karyawan'),
            'hari_training_internal'        => $hari,
            'tanggal_training_internal'     => $request->input('tanggal_training_internal'),
            'jam_training_internal'         => $request->input('jam_training_internal'),
            'lokasi_training_internal'      => $request->input('lokasi_training_internal'),
            'materi_training_internal'      => $request->input('materi_training_internal'),
            'trainer_training_internal'     => $request->input('trainer_training_internal'),
            'input_oleh'                    => $request->input('input_oleh')
        ]);
        $employees                          = Employees::where('nik_karyawan', $request->input('nik_karyawan'))->first();
        //Insert History Training Internal
        Alert::success('Success Input Data Training Internal','Oleh '.auth()->user()->name);
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
        $itemhistory        = HistoryTrainingInternals::findOrFail($id);
        $nikkaryawan        = $itemhistory->employees_id;
        $item               = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $historytraininginternals   = HistoryTrainingInternals::where('id', $id)->first();

        return view ('pages.admin.history-training-internal.edit',[
            'item'                          => $item,
            'historytraininginternals'      => $historytraininginternals
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function tampilmultipletraininginternal(HistoryTrainingInternalMultipleViewRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }
        
        $materi_training_internal   = $request->input('materi_training_internal');
        $tanggal_training_internal  = $request->input('tanggal_training_internal');
        $jam_training_internal      = $request->input('jam_training_internal');
        $trainer_training_internal  = $request->input('trainer_training_internal');

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Produksi
        if ($divisi == 11) {
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')

            ->where([
                ['materi_training_internal','=',$materi_training_internal],
                ['tanggal_training_internal','=',$tanggal_training_internal],
                ['jam_training_internal','=',$jam_training_internal],
                ['trainer_training_internal','=',$trainer_training_internal],
                ['divisions_id','=',11],
                ['history_training_internals.deleted_at','=',NULL]
            ])
            ->get();
        }
        //IC
        elseif($divisi == 2){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')

            ->where([
                ['materi_training_internal','=',$materi_training_internal],
                ['tanggal_training_internal','=',$tanggal_training_internal],
                ['jam_training_internal','=',$jam_training_internal],
                ['trainer_training_internal','=',$trainer_training_internal],
                ['divisions_id','=',2],
                ['history_training_internals.deleted_at','=',NULL]
            ])
            ->get();
        } 
        //Engineering
        elseif($divisi == 7){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')

            ->where([
                ['materi_training_internal','=',$materi_training_internal],
                ['tanggal_training_internal','=',$tanggal_training_internal],
                ['jam_training_internal','=',$jam_training_internal],
                ['trainer_training_internal','=',$trainer_training_internal],
                ['divisions_id','=',7],
                ['history_training_internals.deleted_at','=',NULL]
            ])
            ->get();
        } 
        //Quality
        elseif($divisi == 8){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')

            ->where([
                ['materi_training_internal','=',$materi_training_internal],
                ['tanggal_training_internal','=',$tanggal_training_internal],
                ['jam_training_internal','=',$jam_training_internal],
                ['trainer_training_internal','=',$trainer_training_internal],
                ['divisions_id','=',8],
                ['history_training_internals.deleted_at','=',NULL]
            ])
            ->get();
        } 
        //Purchasing
        elseif($divisi == 9){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')

            ->where([
                ['materi_training_internal','=',$materi_training_internal],
                ['tanggal_training_internal','=',$tanggal_training_internal],
                ['jam_training_internal','=',$jam_training_internal],
                ['trainer_training_internal','=',$trainer_training_internal],
                ['divisions_id','=',9],
                ['history_training_internals.deleted_at','=',NULL]
            ])
            ->get();
        } 
        //PPC
        elseif($divisi == 10){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')

            ->where([
                ['materi_training_internal','=',$materi_training_internal],
                ['tanggal_training_internal','=',$tanggal_training_internal],
                ['jam_training_internal','=',$jam_training_internal],
                ['trainer_training_internal','=',$trainer_training_internal],
                ['history_training_internals.deleted_at','=',NULL]
            ])
            ->whereIn('divisions_id', [12,13,14,15,18])
            ->get();
        } 
        //PDC
        elseif($divisi == 19){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')

            ->where([
                ['materi_training_internal','=',$materi_training_internal],
                ['tanggal_training_internal','=',$tanggal_training_internal],
                ['jam_training_internal','=',$jam_training_internal],
                ['trainer_training_internal','=',$trainer_training_internal],
                ['history_training_internals.deleted_at','=',NULL]
            ])
            ->whereIn('divisions_id', [19,20,21,22])
            ->get();
        } 
        //HRD-GA
        elseif($divisi == 4){
            $items = DB::table('history_training_internals')
            ->join('employees', 'employees.nik_karyawan', '=', 'history_training_internals.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')

            ->where([
                ['materi_training_internal','=',$materi_training_internal],
                ['tanggal_training_internal','=',$tanggal_training_internal],
                ['jam_training_internal','=',$jam_training_internal],
                ['trainer_training_internal','=',$trainer_training_internal],
                ['history_training_internals.deleted_at','=',NULL]
            ])
            ->get();
        } 
        else {
            abort(403);
        }
        
        return view('pages.admin.history-training-internal.viewmultiple',[
            'items' => $items
        ]);
    }

    public function update(HistoryTrainingInternalRequest $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $itemhistory    = HistoryTrainingInternals::findOrFail($id);
        $nikkaryawan    = $itemhistory->employees_id;
        $itemkaryawan   = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $tanggal        = $request->input('tanggal_training_internal');
        $hari           = \Carbon\Carbon::parse($tanggal)->isoformat('dddd');

        $data           = $request->all();
        $item           = HistoryTrainingInternals::findOrFail($id);

        $item->update([
            'employees_id'              => $request->input('nik_karyawan'),
            'hari_training_internal'    => $hari,
            'tanggal_training_internal' => $request->input('tanggal_training_internal'),
            'jam_training_internal'     => $request->input('jam_training_internal'),
            'lokasi_training_internal'  => $request->input('lokasi_training_internal'),
            'materi_training_internal'  => $request->input('materi_training_internal'),
            'trainer_training_internal' => $request->input('trainer_training_internal'),
            'edit_oleh'                 => $request->input('edit_oleh')
        ]);
        Alert::info('Success Edit Data Training Internal','Oleh '.auth()->user()->name);
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
        $item = HistoryTrainingInternals::findOrFail($id);

        //Hapus Oleh
        $item->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh

        $nikkaryawan    = $item->employees_id;
        $itemkaryawan   = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $item->delete();
        Alert::error('Menghapus Data Training Internal','Oleh '.auth()->user()->name);
        return redirect()->route('employee.show',$itemkaryawan->id);
    }
}
