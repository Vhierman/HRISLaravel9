<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\CertificationBnsps;
use App\Models\Admin\CertificationMinistrys;
use App\Models\Admin\CertificationOthers;
use App\Models\Admin\Employees;
use App\Http\Requests\Admin\CertificationBNSPRequest;
use App\Http\Requests\Admin\CertificationBNSPUpdateRequest;
use App\Http\Requests\Admin\CertificationKementrianRequest;
use App\Http\Requests\Admin\CertificationKementrianUpdateRequest;
use App\Http\Requests\Admin\CertificationOtherRequest;
use App\Http\Requests\Admin\CertificationOtherUpdateRequest;
use Carbon\Carbon;
use File;
use Storage;
use Alert;

class CertificationController extends Controller
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
        $items = CertificationBnsps::with([
            'employees',
            ])->get();
    
        return view('pages.admin.certification.bnsp.index',[
            'items' => $items
        ]);
    }

    //Kementrian
    public function sertifikasi_kementrian()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'LEADER' ) {
            abort(403);
        }
        $items = CertificationMinistrys::with([
            'employees',
            ])->get();
    
        return view('pages.admin.certification.kementrian.index',[
            'items' => $items
        ]);
    }

    public function tambah_sertifikasi_kementrian()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        
        $items = Employees::with([
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.certification.kementrian.create',[
            'items'     => $items
        ]);
    }

    public function store_sertifikasi_kementrian(CertificationKementrianRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        CertificationMinistrys::create([
            'employees_id'                          => $request->input('employees_id'),
            'jumlah_sertifikat_kementrian'          => 1,
            'nomor_sertifikat_kementrian'           => $request->input('nomor_sertifikat_kementrian'),
            'jenis_sertifikat_kementrian'           => $request->input('jenis_sertifikat_kementrian'),
            'masa_berlaku_sertifikat_kementrian'    => $request->input('masa_berlaku_sertifikat_kementrian'),
            'tanggal_terbit_kementrian'             => $request->input('tanggal_terbit_kementrian'),
            'sampai_tanggal_kementrian'             => $request->input('sampai_tanggal_kementrian'),
            'lsp_kementrian'                        => $request->input('lsp_kementrian'),
            'input_oleh'                            => $request->input('input_oleh'),
        ]);

        Alert::success('Success Input Data Sertifikasi Kementrian ','Oleh '.auth()->user()->name);
        return redirect()->route('certification.sertifikasi_kementrian');
    }

    public function edit_sertifikasi_kementrian($id)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $itemcertification  = CertificationMinistrys::findOrFail($id);
        $nikkaryawan        = $itemcertification->employees_id;
        $item               = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $items = Employees::with([
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.certification.kementrian.edit',[
            'items'             => $items,
            'item'              => $item,
            'itemcertification' => $itemcertification
        ]);
    }

    public function update_sertifikasi_kementrian(CertificationKementrianUpdateRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $id                 = $request->input('id');
        $itemcertification  = CertificationMinistrys::findOrFail($id);
        $nikkaryawan        = $itemcertification->nik_karyawan;
        $item               = Employees::where('nik_karyawan', $nikkaryawan)->first();
        $data               = $request->all();

        $itemcertification->update($data);
        Alert::info('Success Edit Data Sertifikasi KEMENTRIAN','Oleh '.auth()->user()->name);
        return redirect()->route('certification.sertifikasi_kementrian');

    }

    public function hapus_sertifikasi_kementrian($id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $itemcertification  = CertificationMinistrys::findOrFail($id);
        
        //Hapus Oleh
        $itemcertification->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh

        $itemcertification->delete();
        Alert::error('Menghapus Data Sertifikasi KEMENTRIAN','Oleh '.auth()->user()->name);
        return redirect()->route('certification.sertifikasi_kementrian');
    }
    //Kementrian

    //Lainnya
    public function sertifikasi_lainnya()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'LEADER' ) {
            abort(403);
        }
        $items = CertificationOthers::with([
            'employees',
            ])->get();
    
        return view('pages.admin.certification.lainnya.index',[
            'items' => $items
        ]);
    }

    public function tambah_sertifikasi_lainnya()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        
        $items = Employees::with([
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.certification.lainnya.create',[
            'items'     => $items
        ]);
    }

    public function store_sertifikasi_lainnya(CertificationOtherRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        CertificationOthers::create([
            'employees_id'              => $request->input('employees_id'),
            'jumlah_sertifikat_lain'    => 1,
            'nomor_sertifikat_lain'     => $request->input('nomor_sertifikat_lain'),
            'jenis_sertifikat_lain'     => $request->input('jenis_sertifikat_lain'),
            'tanggal_terbit_lain'       => $request->input('tanggal_terbit_lain'),
            'input_oleh'                => $request->input('input_oleh'),
        ]);

        Alert::success('Success Input Data Sertifikasi Lainnya ','Oleh '.auth()->user()->name);
        return redirect()->route('certification.sertifikasi_lainnya');
    }

    public function edit_sertifikasi_lainnya($id)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $itemcertification  = CertificationOthers::findOrFail($id);
        $nikkaryawan        = $itemcertification->employees_id;
        $item               = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $items = Employees::with([
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.certification.lainnya.edit',[
            'items'             => $items,
            'item'              => $item,
            'itemcertification' => $itemcertification
        ]);
    }

    public function update_sertifikasi_lainnya(CertificationOtherUpdateRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $id                 = $request->input('id');
        $itemcertification  = CertificationOthers::findOrFail($id);
        $nikkaryawan        = $itemcertification->nik_karyawan;
        $item               = Employees::where('nik_karyawan', $nikkaryawan)->first();
        $data               = $request->all();

        $itemcertification->update($data);
        Alert::info('Success Edit Data Sertifikasi Lainnya','Oleh '.auth()->user()->name);
        return redirect()->route('certification.sertifikasi_lainnya');

    }

    public function hapus_sertifikasi_lainnya($id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $itemcertification  = CertificationOthers::findOrFail($id);
        
        //Hapus Oleh
        $itemcertification->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh

        $itemcertification->delete();
        Alert::error('Menghapus Data Sertifikasi Lainnya','Oleh '.auth()->user()->name);
        return redirect()->route('certification.sertifikasi_lainnya');
    }
    //Lainnya

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

        return view ('pages.admin.certification.bnsp.create',[
            'items'     => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CertificationBNSPRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        CertificationBnsps::create([
            'employees_id'                  => $request->input('employees_id'),
            'jumlah_sertifikat_bnsp'        => 1,
            'nomor_sertifikat_bnsp'         => $request->input('nomor_sertifikat_bnsp'),
            'jenis_sertifikat_bnsp'         => $request->input('jenis_sertifikat_bnsp'),
            'masa_berlaku_sertifikat_bnsp'  => $request->input('masa_berlaku_sertifikat_bnsp'),
            'tanggal_terbit_bnsp'           => $request->input('tanggal_terbit_bnsp'),
            'sampai_tanggal_bnsp'           => $request->input('sampai_tanggal_bnsp'),
            'lsp_bnsp'                      => $request->input('lsp_bnsp'),
            'input_oleh'                    => $request->input('input_oleh'),
        ]);

        Alert::success('Success Input Data Sertifikasi BNSP ','Oleh '.auth()->user()->name);
        return redirect()->route('certification.index');


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

        $itemcertification  = CertificationBnsps::findOrFail($id);
        $nikkaryawan        = $itemcertification->employees_id;
        $item               = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $items = Employees::with([
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.certification.bnsp.edit',[
            'items'             => $items,
            'item'              => $item,
            'itemcertification' => $itemcertification
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CertificationBNSPUpdateRequest $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $itemcertification  = CertificationBnsps::findOrFail($id);
        $nikkaryawan        = $itemcertification->nik_karyawan;
        $item               = Employees::where('nik_karyawan', $nikkaryawan)->first();
        $data               = $request->all();

        $itemcertification->update($data);
        Alert::info('Success Edit Data Sertifikasi BNSP','Oleh '.auth()->user()->name);
        return redirect()->route('certification.index');
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

        $itemcertification  = CertificationBnsps::findOrFail($id);
        
        //Hapus Oleh
        $itemcertification->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh

        $itemcertification->delete();
        Alert::error('Menghapus Data Sertifikasi BNSP','Oleh '.auth()->user()->name);
        return redirect()->route('certification.index');
    }
}
