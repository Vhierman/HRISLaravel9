<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Employees;
use App\Models\Admin\QccInternals;
use App\Models\Admin\QccEksternals;
use App\Models\Admin\SsInternals;
use App\Models\Admin\SsEksternals;
use App\Http\Requests\Admin\QccInternalRequest;
use App\Http\Requests\Admin\SsInternalRequest;
use App\Http\Requests\Admin\QccEksternalRequest;
use App\Http\Requests\Admin\SsEksternalRequest;
use App\Http\Requests\Admin\QccInternalUpdateRequest;
use App\Http\Requests\Admin\SsInternalUpdateRequest;
use App\Http\Requests\Admin\QccEksternalUpdateRequest;
use App\Http\Requests\Admin\SsEksternalUpdateRequest;
use Carbon\Carbon;
use File;
use Storage;
use Alert;

class KaizenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'LEADER' ) {
            abort(403);
        }
        $items = QccInternals::with([
            'employees',
            ])->get();
    
        return view('pages.admin.qcc.internal.index',[
            'items' => $items
        ]);
    }

    //QCC Eksternal
    public function qcc_eksternal()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'LEADER' ) {
            abort(403);
        }
        $items = QccEksternals::with([
            'employees',
            ])->get();
    
        return view('pages.admin.qcc.eksternal.index',[
            'items' => $items
        ]);
    }

    public function tambah_qcc_eksternal()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        
        $items = Employees::with([
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.qcc.eksternal.create',[
            'items'     => $items
        ]);
    }

    public function store_qcc_eksternal(QccEksternalRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        QccEksternals::create([
            'employees_id'                      => $request->input('employees_id'),
            'nama_group_qcc_eksternal'          => $request->input('nama_group_qcc_eksternal'),
            'tema_qcc_eksternal'                => $request->input('tema_qcc_eksternal'),
            'circle_leader_qcc_eksternal'       => $request->input('circle_leader_qcc_eksternal'),
            'tanggal_konvensi_qcc_eksternal'    => $request->input('tanggal_konvensi_qcc_eksternal'),
            'instansi'                          => $request->input('instansi'),
            'input_oleh'                        => $request->input('input_oleh'),
        ]);

        Alert::success('Success Input Data QCC Eksternal ','Oleh '.auth()->user()->name);
        return redirect()->route('kaizen.qcc_eksternal');
    }

    public function edit_qcc_eksternal($id)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $itemkaizen     = QccEksternals::findOrFail($id);
        $nikkaryawan    = $itemkaizen->employees_id;
        $item           = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $items = Employees::with([
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.qcc.eksternal.edit',[
            'items'         => $items,
            'item'          => $item,
            'itemkaizen'    => $itemkaizen
        ]);
    }

    public function update_qcc_eksternal(QccEksternalUpdateRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $id             = $request->input('id');
        $itemkaizen     = QccEksternals::findOrFail($id);
        $nikkaryawan    = $itemkaizen->nik_karyawan;
        $item           = Employees::where('nik_karyawan', $nikkaryawan)->first();
        $data           = $request->all();

        $itemkaizen->update($data);
        Alert::info('Success Edit Data QCC Eksternal ','Oleh '.auth()->user()->name);
        return redirect()->route('kaizen.qcc_eksternal');

    }

    public function hapus_qcc_eksternal($id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $itemkaizen  = QccEksternals::findOrFail($id);
        
        //Hapus Oleh
        $itemkaizen->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh

        $itemkaizen->delete();
        Alert::error('Menghapus Data QCC Eksternal','Oleh '.auth()->user()->name);
        return redirect()->route('kaizen.qcc_eksternal');
    }
    //QCC Eksternal


    //SS Internal
    public function ss_internal()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'LEADER' ) {
            abort(403);
        }
        $items = SsInternals::with([
            'employees',
            ])->get();
    
        return view('pages.admin.ss.internal.index',[
            'items' => $items
        ]);
    }

    public function tambah_ss_internal()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        
        $items = Employees::with([
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.ss.internal.create',[
            'items'     => $items
        ]);
    }

    public function store_ss_internal(SsInternalRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        SsInternals::create([
            'employees_id'          => $request->input('employees_id'),
            'tema_ss_internal'      => $request->input('tema_ss_internal'),
            'tanggal_ss_internal'   => $request->input('tanggal_ss_internal'),
            'input_oleh'            => $request->input('input_oleh'),
        ]);

        Alert::success('Success Input Data SS Internal ','Oleh '.auth()->user()->name);
        return redirect()->route('kaizen.ss_internal');
    }

    public function edit_ss_internal($id)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $itemkaizen     = SsInternals::findOrFail($id);
        $nikkaryawan    = $itemkaizen->employees_id;
        $item           = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $items = Employees::with([
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.ss.internal.edit',[
            'items'         => $items,
            'item'          => $item,
            'itemkaizen'    => $itemkaizen
        ]);
    }

    public function update_ss_internal(SsInternalUpdateRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $id             = $request->input('id');
        $itemkaizen     = SsInternals::findOrFail($id);
        $nikkaryawan    = $itemkaizen->nik_karyawan;
        $item           = Employees::where('nik_karyawan', $nikkaryawan)->first();
        $data           = $request->all();

        $itemkaizen->update($data);
        Alert::info('Success Edit Data SS Internal ','Oleh '.auth()->user()->name);
        return redirect()->route('kaizen.ss_internal');

    }

    public function hapus_ss_internal($id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $itemkaizen  = SsInternals::findOrFail($id);
        
        //Hapus Oleh
        $itemkaizen->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh

        $itemkaizen->delete();
        Alert::error('Menghapus Data SS Internal','Oleh '.auth()->user()->name);
        return redirect()->route('kaizen.ss_internal');
    }
    //SS Internal

    //SS Eksternal
    public function ss_eksternal()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'LEADER' ) {
            abort(403);
        }
        $items = SsEksternals::with([
            'employees',
            ])->get();
    
        return view('pages.admin.ss.eksternal.index',[
            'items' => $items
        ]);
    }

    public function tambah_ss_eksternal()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        
        $items = Employees::with([
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.ss.eksternal.create',[
            'items'     => $items
        ]);
    }

    public function store_ss_eksternal(SsEksternalRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        SsEksternals::create([
            'employees_id'          => $request->input('employees_id'),
            'tema_ss_eksternal'     => $request->input('tema_ss_eksternal'),
            'tanggal_ss_eksternal'  => $request->input('tanggal_ss_eksternal'),
            'instansi'              => $request->input('instansi'),
            'input_oleh'            => $request->input('input_oleh'),
        ]);

        Alert::success('Success Input Data SS Eksternal ','Oleh '.auth()->user()->name);
        return redirect()->route('kaizen.ss_eksternal');
    }

    public function edit_ss_eksternal($id)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $itemkaizen     = SsEksternals::findOrFail($id);
        $nikkaryawan    = $itemkaizen->employees_id;
        $item           = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $items = Employees::with([
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.ss.eksternal.edit',[
            'items'         => $items,
            'item'          => $item,
            'itemkaizen'    => $itemkaizen
        ]);
    }

    public function update_ss_eksternal(SsEksternalUpdateRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $id             = $request->input('id');
        $itemkaizen     = SsEksternals::findOrFail($id);
        $nikkaryawan    = $itemkaizen->nik_karyawan;
        $item           = Employees::where('nik_karyawan', $nikkaryawan)->first();
        $data           = $request->all();

        $itemkaizen->update($data);
        Alert::info('Success Edit Data SS Eksternal ','Oleh '.auth()->user()->name);
        return redirect()->route('kaizen.ss_eksternal');

    }

    public function hapus_ss_eksternal($id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $itemkaizen  = SsEksternals::findOrFail($id);
        
        //Hapus Oleh
        $itemkaizen->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh

        $itemkaizen->delete();
        Alert::error('Menghapus Data SS Eksternal','Oleh '.auth()->user()->name);
        return redirect()->route('kaizen.ss_eksternal');
    }
    //SS Eksternal
    
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
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.qcc.internal.create',[
            'items' => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QccInternalRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        QccInternals::create([
            'employees_id'                  => $request->input('employees_id'),
            'nama_group_qcc_internal'       => $request->input('nama_group_qcc_internal'),
            'tema_qcc_internal'             => $request->input('tema_qcc_internal'),
            'circle_leader_qcc_internal'    => $request->input('circle_leader_qcc_internal'),
            'tanggal_konvensi_qcc_internal' => $request->input('tanggal_konvensi_qcc_internal'),
            'input_oleh'                    => $request->input('input_oleh'),
        ]);

        Alert::success('Success Input Data QCC Internal ','Oleh '.auth()->user()->name);
        return redirect()->route('kaizen.index');
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

        $itemkaizen     = QccInternals::findOrFail($id);
        $nikkaryawan    = $itemkaizen->employees_id;
        $item           = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $items = Employees::with([
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.qcc.internal.edit',[
            'items'         => $items,
            'item'          => $item,
            'itemkaizen'    => $itemkaizen
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QccInternalUpdateRequest $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $itemkaizen         = QccInternals::findOrFail($id);
        $nikkaryawan        = $itemkaizen->nik_karyawan;
        $item               = Employees::where('nik_karyawan', $nikkaryawan)->first();
        $data               = $request->all();

        $itemkaizen->update($data);
        Alert::info('Success Edit Data QCC Internal ','Oleh '.auth()->user()->name);
        return redirect()->route('kaizen.index');
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

        $itemkaizen  = QccInternals::findOrFail($id);
        
        //Hapus Oleh
        $itemkaizen->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh

        $itemkaizen->delete();
        Alert::error('Menghapus Data QCC Internal','Oleh '.auth()->user()->name);
        return redirect()->route('kaizen.index');
    }
}
