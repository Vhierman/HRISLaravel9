<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpahLemburPerjamRequest;
use App\Models\Admin\HistorySalaries;
use App\Models\Admin\Employees;
use App\Models\Admin\Divisions;
use Carbon\Carbon;
use File;
use Storage;
use Alert;

class UpahLemburPerjamController extends Controller
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

        $items = HistorySalaries::with(['employees'])->get();

        return view('pages.admin.upah-lembur-perjam.index',[
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

        $itemsalary     = HistorySalaries::findOrFail($id);
        $nikkaryawan    = $itemsalary->employees_id;
        $item = HistorySalaries::with([
            'employees'
        ])->where('employees_id',$nikkaryawan)->first();
       
        return view('pages.admin.upah-lembur-perjam.edit',[
        'item'          => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpahLemburPerjamRequest $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $item           = HistorySalaries::findOrFail($id);
        $nikkaryawan    = $item->employees_id;
        
        $items = Employees::with([
            'history_salaries'
        ])->where('nik_karyawan',$nikkaryawan)->first();

        $item->update([
            'upah_lembur_perjam'    => $request->input('upah_lembur_perjam'),
            'edit_oleh'             => $request->input('edit_oleh')
        ]);
        
        Alert::info('Success Edit','Oleh '.auth()->user()->name);
        return redirect()->route('upah_lembur_perjam.index');
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
