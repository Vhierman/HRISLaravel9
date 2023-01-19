<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Employees;
use App\Models\Admin\Companies;
use App\Models\Admin\Areas;
use App\Models\Admin\Golongans;
use App\Models\User;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use App\Models\Admin\Overtimes;
use App\Models\Admin\Attendances;
use App\Models\Admin\HistoryContracts;
use App\Models\Admin\HistoryFamilies;
use Carbon\Carbon;
use File;
use Storage;
use Codedge\Fpdf\Fpdf\Fpdf;
use DB;
use Alert;
use Auth;

class DashboardHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        toast('Hello ' . auth()->user()->name, 'success');
        $nik_karyawan = auth()->user()->nik;

        //Jumlah Karyawan
        $itembsd = Employees::with([
            'areas'
        ])->where('areas_id', 2)->whereIn('golongans_id', [3])->count();
        $itemsunter = Employees::with([
            'areas'
        ])->where('areas_id', 3)->whereIn('golongans_id', [3])->count();
        $itemcibinong = Employees::with([
            'areas'
        ])->where('areas_id', 4)->whereIn('golongans_id', [3])->count();
        $itemcibitung = Employees::with([
            'areas'
        ])->where('areas_id', 5)->whereIn('golongans_id', [3])->count();
        $itemkarawangtimur = Employees::with([
            'areas'
        ])->where('areas_id', 6)->whereIn('golongans_id', [3])->count();
        $itembl = Employees::with([
            'areas'
        ])->where('areas_id', 7)->whereIn('golongans_id', [3])->count();
        $itempdc = $itemsunter + $itemcibinong + $itemcibitung + $itemkarawangtimur;
        $itemall = $itembsd + $itempdc ;
        //Jumlah Karyawan
        // Chart Penempatan
        $itemhrd = Employees::with([
            'divisions'
        ])->where('divisions_id', 4)->whereIn('golongans_id', [3])->count();
        $itemquality = Employees::with([
            'divisions'
        ])->where('divisions_id', 8)->whereIn('golongans_id', [3])->count();
        $itemproduksi = Employees::with([
            'divisions'
        ])->where('divisions_id', 11)->whereIn('golongans_id', [3])->count();
        $itemdeliveryproduksi = Employees::with([
            'divisions'
        ])->where('divisions_id', 12)->whereIn('golongans_id', [3])->count();
        $itemgudangrm = Employees::with([
            'divisions'
        ])->where('divisions_id', 13)->whereIn('golongans_id', [3])->count();
        $itemgudangfg = Employees::with([
            'divisions'
        ])->where('divisions_id', 14)->whereIn('golongans_id', [3])->count();
        $itemdelivery = Employees::with([
            'divisions'
        ])->where('divisions_id', 15)->whereIn('golongans_id', [3])->count();
        $itembloke = Employees::with([
            'divisions'
        ])->where('divisions_id', 18)->whereIn('golongans_id', [3])->count();
        $itempdcdaihatsusunter = Employees::with([
            'divisions'
        ])->where('divisions_id', 19)->whereIn('golongans_id', [1,2,4])->count();
        // Chart Penempatan
        // Chart Status Menikah
        $itemsingle = Employees::all()
            ->where('status_nikah', 'Single')->whereIn('golongans_id', [3])
            ->count();
        $itemmenikah = Employees::all()
            ->where('status_nikah', 'Menikah')->whereIn('golongans_id', [3])
            ->count();
        $itemjanda = Employees::all()
            ->where('status_nikah', 'Janda')->whereIn('golongans_id', [3])
            ->count();
        $itemduda = Employees::all()
            ->where('status_nikah', 'Duda')->whereIn('golongans_id', [3])
            ->count();
        // Chart Status Menikah
        // Chart Jenis Kelamin
        $itempria = Employees::all()
            ->where('jenis_kelamin', 'Pria')->whereIn('golongans_id', [3])
            ->count();
        $itemwanita = Employees::all()
            ->where('jenis_kelamin', 'Wanita')->whereIn('golongans_id', [3])
            ->count();
        // Chart Jenis Kelamin

        return view('pages.admin.dashboard-harian',[
            //Halaman HRD, ADMIN, Accounting TOP
            'itempdc'                       => $itempdc,
            'itemall'                       => $itemall,
            'itembsd'                       => $itembsd,
            //Halaman HRD, ADMIN, Accounting TOP
            //Halaman HRD, ADMIN, Accounting 
           
            'itemhrd'                       => $itemhrd,
            'itemquality'                   => $itemquality,
            'itemproduksi'                  => $itemproduksi,
            'itemdeliveryproduksi'          => $itemdeliveryproduksi,
            'itemgudangrm'                  => $itemgudangrm,
            'itemgudangfg'                  => $itemgudangfg,
            'itemdelivery'                  => $itemdelivery,
            'itembloke'                     => $itembloke,
            'itempdcdaihatsusunter'         => $itempdcdaihatsusunter,
            
            'itemsingle'                    => $itemsingle,
            'itemmenikah'                   => $itemmenikah,
            'itemjanda'                     => $itemjanda,
            'itemduda'                      => $itemduda,

            'itempria'                      => $itempria,
            'itemwanita'                    => $itemwanita,
            
            //Halaman HRD, ADMIN, Accounting 
           
            
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING') {
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING') {
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING') {
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING') {
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING') {
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
    }
}
