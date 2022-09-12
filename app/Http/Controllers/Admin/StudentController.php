<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StudentRequest;
use App\Models\Admin\Students;
use App\Models\Admin\Employees;
use App\Models\Admin\Schools;
use App\Models\Admin\Divisions;
use Alert;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Produksi
        if ($divisi == 11) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->whereIn('divisions_id', [11, 19, 20,21])->get();
        }
        //PDC
        elseif ($divisi == 19) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->whereIn('divisions_id', [19, 20,21])->get();
        } 
        //IC
        elseif ($divisi == 2) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->whereIn('divisions_id', [2])->get();
        } 
        //Engineering
        elseif ($divisi == 7) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->whereIn('divisions_id', [7])->get();
        } 
        //Quality
        elseif ($divisi == 8) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->whereIn('divisions_id', [8])->get();
        } 
        //Purchasing
        elseif ($divisi == 9) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->whereIn('divisions_id', [9])->get();
        } 
        //PPC
        elseif ($divisi == 10) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->whereIn('divisions_id', [12,13,14,15,18])->get();
        } 
        //HRD-GA
        elseif ($divisi == 4) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->get();
        } 
        //Accounting
        elseif ($divisi == 1) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->get();
        } 
        else {
            abort(403);
        }

        return view('pages.admin.student.index',[
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
        $schools        = Schools::all();
        $divisions      = Divisions::all();
        
        return view ('pages.admin.student.create',[
            'divisions'     => $divisions,
            'schools'       => $schools
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $data = $request->all();
        Students::create($data);
        Alert::success('Success Input Data Siswa','Oleh '.auth()->user()->name);
        return redirect()->route('student.index');
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
        $item           = Students::findOrFail($id);
        $schools        = Schools::all();
        $divisions      = Divisions::all();

        return view ('pages.admin.student.edit',[
            'item'          => $item,
            'schools'       => $schools,
            'divisions'     => $divisions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $data       = $request->all();
        $item       = Students::findOrFail($id);
        $item->update($data);
        Alert::info('Success Edit Data Siswa','Oleh '.auth()->user()->name);
        return redirect()->route('student.index');
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
        $item = Students::findOrFail($id);
        //Hapus Oleh
        $item->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh
        $item->delete();
        Alert::error('Menghapus Data Siswa','Oleh '.auth()->user()->name);
        return redirect()->route('student.index');
    }
}
