<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AbsensiPklRequest;
use App\Http\Requests\Admin\AbsensiPklLihatRequest;
use App\Http\Requests\Admin\AbsensiPklTambahRequest;
use App\Http\Requests\Admin\AbsensiPklEditRequest;
use App\Models\Admin\Employees;
use App\Models\Admin\Divisions;
use App\Models\Admin\Students;
use App\Models\Admin\Schools;
use App\Models\Admin\AttendancesPkls;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Alert;
use DB;

class AbsensiPklController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING') {
            abort(403);
        }
        return view('pages.admin.absensi-pkl.index');
    }

    public function lihat_absensi()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' &&  auth()->user()->roles != 'LEADER' &&  auth()->user()->roles != 'MANAGER ACCOUNTING' &&  auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        return view('pages.admin.absensi-pkl.cariabsensi');
    }

    public function tampil_absensi(AbsensiPklLihatRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER' && auth()->user()->roles != 'ACCOUNTING' && auth()->user()->roles != 'MANAGER ACCOUNTING') {
            abort(403);
        }

        $awal           = $request->input('awal');
        $akhir          = $request->input('akhir');

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //PDC Daihatsu
        if ($divisi == 19) {
            $items = 
                DB::table('attendances_pkls')
                ->join('students', 'students.nis_siswa', '=', 'attendances_pkls.students_id')
                ->join('divisions', 'divisions.id', '=', 'students.divisions_id')
                ->join('schools', 'schools.id', '=', 'students.schools_id')
                ->whereIn('divisions_id', [19,20,21,22])
                ->where('attendances_pkls.deleted_at',NULL)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->get();
        } 
        //Produksi
        elseif ($divisi == 11) {
            $items = 
                DB::table('attendances_pkls')
                ->join('students', 'students.nis_siswa', '=', 'attendances_pkls.students_id')
                ->join('divisions', 'divisions.id', '=', 'students.divisions_id')
                ->join('schools', 'schools.id', '=', 'students.schools_id')
                ->whereIn('divisions_id', [11])
                ->where('attendances_pkls.deleted_at',NULL)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->get();
        } 
        //HRD-GA
        elseif ($divisi == 4) {
            $items = 
                DB::table('attendances_pkls')
                ->join('students', 'students.nis_siswa', '=', 'attendances_pkls.students_id')
                ->join('divisions', 'divisions.id', '=', 'students.divisions_id')
                ->join('schools', 'schools.id', '=', 'students.schools_id')
                ->where('attendances_pkls.deleted_at',NULL)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->get();
        }
        elseif ($divisi == 1) {
            $items = 
                DB::table('attendances_pkls')
                ->join('students', 'students.nis_siswa', '=', 'attendances_pkls.students_id')
                ->join('divisions', 'divisions.id', '=', 'students.divisions_id')
                ->join('schools', 'schools.id', '=', 'students.schools_id')
                ->where('attendances_pkls.deleted_at',NULL)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->get();
        }
        else {
            abort(403);
        }

        if (!$items->isEmpty()) {
            return view('pages.admin.absensi-pkl.tampilabsensi',[
                'awal'  => $awal,
                'akhir'  => $akhir,
                'items' => $items
            ]);
        } else {
            Alert::error('Data Tidak Ditemukan');
            return redirect()->route('absensipkl.lihat_absensi');
        }
    }

    public function form_edit()
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //PDC
        if ($divisi == 19) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->whereIn('divisions_id', [19,20,21,22])->get();
        }
        //Produksi
        elseif ($divisi == 11) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->whereIn('divisions_id', [11])->get();
        }
        //HRD-GA
        elseif ($divisi == 4) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->get();
        }
        else {
            abort(403);
        }

        return view ('pages.admin.absensi-pkl.editabsensi',[
                'items'     => $items
        ]);
        
    }

    public function form_hapus()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //PDC
        if ($divisi == 19) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->whereIn('divisions_id', [19,20,21,22])->get();
        }
        //Produksi
        elseif ($divisi == 11) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->whereIn('divisions_id', [11])->get();
        }
        //HRD-GA
        elseif ($divisi == 4) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->get();
        }
        else {
            abort(403);
        }

        return view ('pages.admin.absensi-pkl.hapusabsensi',[
                'items'     => $items
        ]);
    }

    public function tampil_hapus(AbsensiPklEditRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $students_id    = $request->input('students_id');
        $tanggal_absen  = $request->input('tanggal_absen');

        $items = AttendancesPkls::with([
            'students'
            ])
            ->where('students_id', $students_id)
            ->where('tanggal_absen', $tanggal_absen)
            ->first();

        if ($items == null) {
            Alert::error('Data yang anda cari tidak ada');
            return redirect()->route('absensipkl.index');
        } else {
        return view('pages.admin.absensi-pkl.tampilhapusabsensi',[
            'items' => $items
        ]);
        }
    }

    public function tampil_edit(AbsensiPklEditRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $students_id    = $request->input('students_id');
        $tanggal_absen  = $request->input('tanggal_absen');

        $items = AttendancesPkls::with([
            'students'
            ])
            ->where('students_id', $students_id)
            ->where('tanggal_absen', $tanggal_absen)
            ->first();

        if ($items == null) {
            Alert::error('Data yang anda cari tidak ada');
            return redirect()->route('absensipkl.index');
        } else {
        return view('pages.admin.absensi-pkl.tampileditabsensi',[
            'items' => $items
        ]);
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //PDC
        if ($divisi == 19) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->whereIn('divisions_id', [19,20,21,22])->get();
        }
        //Produksi
        elseif ($divisi == 11) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->whereIn('divisions_id', [11])->get();
        }
        //HRD-GA
        elseif ($divisi == 4) {
            $items = Students::with([
                'schools',
                'divisions'
                ])->get();
        }
        else {
            abort(403);
        }

        return view ('pages.admin.absensi-pkl.create',[
            'items'     => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AbsensiPklRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        AttendancesPkls::create([
            'students_id'               => $request->input('students_id'),
            'tanggal_absen'             => $request->input('tanggal_absen'),
            'keterangan_absen'          => $request->input('keterangan_absen'),
            'lama_absen'                => 1,
            'input_oleh'                => $request->input('input_oleh'),
        ]);

        Alert::success('Success Input Data Absensi','Oleh '.auth()->user()->name);
        return redirect()->route('absensipkl.create');
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
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
    public function update(AbsensiPklRequest $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $students_id        = $request->input('students_id');
        $tanggal_absen      = $request->input('tanggal_absen');
        $keterangan_absen   = $request->input('keterangan_absen');

        $attendancespkl             = AttendancesPkls::where('id', $id)->first();

        // dd($attendancespkl);
        $attendancespkl->update([
            'tanggal_absen'             => $tanggal_absen,
            'keterangan_absen'          => $keterangan_absen,
            'edit_oleh'                 => $request->input('edit_oleh')
        ]);
        Alert::info('Success Edit Data Absensi','Oleh '.auth()->user()->name);
        return redirect()->route('absensipkl.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER') {
            abort(403);
        }

        $hapus_oleh     = $request->input('hapus_oleh');

        $attendances     = AttendancesPkls::where('id', $id)->first();
        $attendances->update([
            'hapus_oleh'    => $request->input('hapus_oleh')
        ]);

        $item = AttendancesPkls::findOrFail($id);
        $item->delete();
        
        Alert::error('Menghapus Data Absensi','Oleh '.auth()->user()->name);
        return redirect()->route('absensipkl.index');
    }
}
