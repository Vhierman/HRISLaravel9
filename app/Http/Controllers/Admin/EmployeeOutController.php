<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\EmployeesOutExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\EmployeeOutRequest;
use App\Models\Admin\Employees;
use App\Models\Admin\EmployeesOuts;
use App\Models\Admin\Companies;
use App\Models\Admin\Golongans;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use App\Models\Admin\Areas;
use App\Models\Admin\HistoryContracts;
use App\Models\Admin\HistoryPositions;
use App\Models\Admin\HistorySalaries;
use App\Models\Admin\HistoryTrainingInternals;
use App\Models\Admin\HistoryTrainingEksternals;
use App\Models\Admin\HistoryFamilies;
use App\Models\Admin\InventoryMotorcycles;
use App\Models\Admin\InventoryCars;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;
use File;
use Storage;
use Alert;

class EmployeeOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $fpdf;
 
    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    public function index()
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Produksi
        if ($divisi == 11) {
            $items = EmployeesOuts::with([
                'companies',
                'golongans',
                'areas',
                'divisions',
                'positions'
                ])->whereIn('divisions_id', [11, 19, 20,21])->get();
        }
        //PDC
        elseif ($divisi == 19) {
            $items = EmployeesOuts::with([
                'companies',
                'golongans',
                'areas',
                'divisions',
                'positions'
                ])->whereIn('divisions_id', [19, 20,21])->get();
        } 
        //IC
        elseif ($divisi == 2) {
            $items = EmployeesOuts::with([
                'companies',
                'golongans',
                'areas',
                'divisions',
                'positions'
                ])->whereIn('divisions_id', [2])->get();
        } 
        //Engineering
        elseif ($divisi == 7) {
            $items = EmployeesOuts::with([
                'companies',
                'golongans',
                'areas',
                'divisions',
                'positions'
                ])->whereIn('divisions_id', [7])->get();
        } 
        //Quality
        elseif ($divisi == 8) {
            $items = EmployeesOuts::with([
                'companies',
                'golongans',
                'areas',
                'divisions',
                'positions'
                ])->whereIn('divisions_id', [8])->get();
        } 
        //Purchasing
        elseif ($divisi == 9) {
            $items = EmployeesOuts::with([
                'companies',
                'golongans',
                'areas',
                'divisions',
                'positions'
                ])->whereIn('divisions_id', [9])->get();
        } 
        //PPC
        elseif ($divisi == 10) {
            $items = EmployeesOuts::with([
                'companies',
                'golongans',
                'areas',
                'divisions',
                'positions'
                ])->whereIn('divisions_id', [12,13,14,15,18])->get();
        } 
        //HRD-GA
        elseif ($divisi == 4) {
            $items = EmployeesOuts::with([
                'companies',
                'golongans',
                'areas',
                'divisions',
                'positions'
                ])->get();
        } 
        //Accounting
        elseif ($divisi == 1) {
            $items = EmployeesOuts::with([
                'companies',
                'golongans',
                'areas',
                'divisions',
                'positions'
                ])->get();
        } 
        else {
            abort(403);
        }
        
        return view('pages.admin.employee-out.index',[
            'items' => $items
        ]);
    }

    public function export_excel()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
		return Excel::download(new EmployeesOutExport, 'databasekaryawankeluar.xlsx');
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

        return view ('pages.admin.employee-out.create',[
            'items'     => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeOutRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $nik_karyawan   = $request->input('employees_id');
        $item           = Employees::where('nik_karyawan', $nik_karyawan)->first();

        EmployeesOuts::create([
            'employees_id'                              => $request->input('employees_id'),
            'companies_id'                              => $item->companies_id,
            'golongans_id'                              => $item->golongans_id,
            'areas_id'                                  => $item->areas_id,
            'divisions_id'                              => $item->divisions_id,
            'positions_id'                              => $item->positions_id,
            'nama_karyawan_keluar'                      => $item->nama_karyawan,
            'nomor_npwp_karyawan_keluar'                => $item->nomor_npwp,
            'email_karyawan_keluar'                     => $item->email_karyawan,
            'nomor_handphone_karyawan_keluar'           => $item->nomor_handphone,
            'tempat_lahir_karyawan_keluar'              => $item->tempat_lahir,
            'tanggal_lahir_karyawan_keluar'             => $item->tanggal_lahir,
            'nomor_bpjsketenagakerjaan_karyawan_keluar' => $item->nomor_bpjsketenagakerjaan,
            'nomor_bpjskesehatan_karyawan_keluar'       => $item->nomor_bpjskesehatan,
            'nomor_rekening_karyawan_keluar'            => $item->nomor_rekening,
            'pendidikan_terakhir_karyawan_keluar'       => $item->pendidikan_terakhir,
            'jenis_kelamin_karyawan_keluar'             => $item->jenis_kelamin,
            'agama_karyawan_keluar'                     => $item->agama,
            'alamat_karyawan_keluar'                    => $item->alamat,
            'rt_karyawan_keluar'                        => $item->rt,
            'rw_karyawan_keluar'                        => $item->rw,
            'kelurahan_karyawan_keluar'                 => $item->kelurahan,
            'kecamatan_karyawan_keluar'                 => $item->kecamatan,
            'kota_karyawan_keluar'                      => $item->kota,
            'provinsi_karyawan_keluar'                  => $item->provinsi,
            'kode_pos_karyawan_keluar'                  => $item->kode_pos,
            'nomor_absen_karyawan_keluar'               => $item->nomor_absen,
            'golongan_darah_karyawan_keluar'            => $item->golongan_darah,
            'nomor_kartu_keluarga_karyawan_keluar'      => $item->nomor_kartu_keluarga,
            'status_nikah_karyawan_keluar'              => $item->status_nikah,
            'nama_ayah_karyawan_keluar'                 => $item->nama_ayah,
            'nama_ibu_karyawan_keluar'                  => $item->nama_ibu,
            'tanggal_masuk_karyawan_keluar'             => $item->tanggal_mulai_kerja,
            'tanggal_keluar_karyawan_keluar'            => $request->input('tanggal_keluar_karyawan_keluar'),
            'status_kerja_karyawan_keluar'              => $item->status_kerja,
            'keterangan_keluar'                         => $request->input('keterangan_keluar'),
            'input_oleh'                                => $request->input('input_oleh')
        ]);

        //Hapus Data
        $nikkaryawan            = $item->nik_karyawan;
        $employee               = Employees::where('nik_karyawan', $nikkaryawan)->first();
        $salary                 = HistorySalaries::where('employees_id', $nikkaryawan)->first();
        $contracts              = HistoryContracts::where('employees_id', $nikkaryawan)->get();
        $positions              = HistoryPositions::where('employees_id', $nikkaryawan)->get();
        $familys                = HistoryFamilies::where('employees_id', $nikkaryawan)->get();
        $trainingeksternals     = HistoryTrainingEksternals::where('employees_id', $nikkaryawan)->get();
        $traininginternals      = HistoryTrainingInternals::where('employees_id', $nikkaryawan)->get();
        $inventorymotorcycle    = InventoryMotorcycles::where('employees_id', $nikkaryawan)->first();
        $inventorycar           = InventoryCars::where('employees_id', $nikkaryawan)->first();

        //Foto Keluarga
        // $dokumenhistorykeluarga = $family->dokumen_history_keluarga;
        // if(Storage::exists('public/'.$dokumenhistorykeluarga)){
        //     Storage::delete('public/'.$dokumenhistorykeluarga);
        // }
        // else{
        //     dd('File does not exists.');
        // }
        //End Foto Keluarga
        //Foto Surat Mutasi
        // $suratmutasi            = $position->file_surat_mutasi;
        // if(Storage::exists('public/'.$suratmutasi)){
        //     Storage::delete('public/'.$suratmutasi);
        // }
        // else{
        //     dd('File does not exists.');
        // }
        //End Foto Surat Mutasi
        
        $employee->delete();
        $salary->delete();

        if ($contracts <> null) {
        foreach ($contracts as $contract ) {
            $contract->delete();
        }
        } else {}
        
        if ($familys <> null) {
            foreach ($familys as $family ) {
                $family->delete();
            }
        } else {}

        if ($positions <> null) {
            foreach ($positions as $position ) {
                $position->delete();
            }
        } else {}

        if ($trainingeksternals <> null) {
            foreach ($trainingeksternals as $trainingeksternal ) {
                $trainingeksternal->delete();
            }
        } else {}

        if ($traininginternals <> null) {
            foreach ($traininginternals as $traininginternal ) {
                $traininginternal->delete();
            }
        } else {}

        if ($inventorymotorcycle <> null) {
            $inventorymotorcycle->delete();
        } else {}

        if ($inventorycar <> null) {
            $inventorycar->delete();
        } else {}
        //Hapus
        Alert::success('Success Input Data Karyawan Keluar','Oleh '.auth()->user()->name);
        //Redirect
        return redirect()->route('employee_out.index');
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        $item           = EmployeesOuts::findOrFail($id);
        $nikkaryawan    = $item->employees_id;

        $items = EmployeesOuts::with([
            'companies',
            'golongans',
            'areas',
            'divisions',
            'positions'
            ])->where('employees_id', $nikkaryawan)->first();
        
        
        //Create Nomor DOkumen
        $nik            = substr($nikkaryawan, 12);
        $mytime         = $item->tanggal_keluar_karyawan_keluar;
        $bulan          = substr($mytime, 5, -3);
        $tahun          = substr($mytime, 0,4);

        if ($bulan == 1) {
            $romawi = 'I';
        }
        elseif ($bulan == 2) {
            $romawi = 'II';
        } 
        elseif ($bulan == 3) {
            $romawi = 'III';
        } 
        elseif ($bulan == 4) {
            $romawi = 'IV';
        } 
        elseif ($bulan == 5) {
            $romawi = 'V';
        } 
        elseif ($bulan == 6) {
            $romawi = 'VI';
        } 
        elseif ($bulan == 7) {
            $romawi = 'VII';
        } 
        elseif ($bulan == 8) {
            $romawi = 'VIII';
        } 
        elseif ($bulan == 9) {
            $romawi = 'IX';
        } 
        elseif ($bulan == 10) {
            $romawi = 'X';
        } 
        elseif ($bulan == 11) {
            $romawi = 'XI';
        } 
        elseif ($bulan == 12) {
            $romawi = 'XII';
        } 
        else {
            $romawi = 'SALAH';
        }
        //Create Nomor DOkumen

        $this->fpdf = new FPDF('P', 'mm', 'A4');
        $this->fpdf->AddPage();

        $this->fpdf->Ln(15);
        $this->fpdf->SetFont('Arial', 'BU', '18');
        $this->fpdf->Cell(-5);
        $this->fpdf->Cell(200, 10, 'SURAT PENGALAMAN KERJA', 0, 0, 'C');

        $this->fpdf->Ln(6);
        $this->fpdf->SetFont('Arial', 'B', '14');
        $this->fpdf->Cell(-5);
        $this->fpdf->Cell(200, 10, 'No.' . $nik . '/HRD/PK/' . $romawi . '/' . $tahun . '.', 0, 0, 'C');
        $this->fpdf->Ln(30);

        $this->fpdf->SetFont('Arial', '', '12');
        $this->fpdf->Cell(10);
        $this->fpdf->Cell(100, 10, 'Kami Yang Bertanda Tangan Dibawah Ini :', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(50, 10, 'Nama', 0, 0, 'L');
        $this->fpdf->Cell(100, 10, ' : Rudiyanto', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(50, 10, 'Jabatan', 0, 0, 'L');
        $this->fpdf->Cell(100, 10, ' : General Manager ( HRD - GA )', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(50, 10, 'Menerangkan Bahwa', 0, 0, 'L');
        $this->fpdf->Cell(100, 10, ' : ', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(50, 10, 'Nama', 0, 0, 'L');
        $this->fpdf->Cell(100, 10, ' : ' . $item->nama_karyawan_keluar . '', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(50, 10, 'Jabatan ', 0, 0, 'L');
        $this->fpdf->Cell(100, 10, ' : ' . $items->positions->jabatan . ' / ' . $items->divisions->penempatan . '', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(50, 10, 'Tanggal Mulai Kerja', 0, 0, 'L');
        $this->fpdf->Cell(100, 10, ' : ' . \Carbon\Carbon::parse($item->tanggal_masuk_karyawan_keluar)->isoformat('D MMMM Y') . ' s/d ' . \Carbon\Carbon::parse($item->tanggal_keluar_karyawan_keluar)->isoformat('D MMMM Y') . '', 0, 0, 'L');
        $this->fpdf->Ln(15);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(180, 10, 'Adalah benar pernah menjadi karyawan di PT Prima Komponen Indonesia dengan jabatan dan', 0, 0, 'L');

        $this->fpdf->Ln(5);
        $this->fpdf->Cell(10);
        $this->fpdf->Cell(180, 10, 'masa  kerja  di  atas , sehubungan dengan ' . $item->keterangan_keluar . ' dari yang bersangkutan, ', 0, 0, 'L');

        $this->fpdf->Ln(5);
        $this->fpdf->Cell(10);
        $this->fpdf->Cell(180, 10, 'maka hubungan perusahaan dengan yang bersangkutan dinyatakan terputus.', 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->Cell(10);
        $this->fpdf->Cell(180, 10, 'Selama  bekerja  yang  bersangkutan  telah menunjukan loyalitas dan dedikasi yang tinggi', 0, 0, 'L');

        $this->fpdf->Ln(5);
        $this->fpdf->Cell(10);
        $this->fpdf->Cell(180, 10, 'untuk itu atas nama pimpinan perusahaan mengucapkan terima kasih.', 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->Cell(10);
        $this->fpdf->Cell(180, 10, 'Demikianlah surat keterangan ini kami buat untuk digunakan dengan seperlunya.', 0, 0, 'L');

        $this->fpdf->Ln(15);
        $this->fpdf->Cell(10);
        $this->fpdf->Cell(180, 10, 'Tangerang Selatan, ' . \Carbon\Carbon::parse($item->tanggal_keluar_karyawan_keluar)->isoformat('D MMMM Y') . ' ', 0, 0, 'L');

        $this->fpdf->Ln(5);
        $this->fpdf->Cell(10);
        $this->fpdf->Cell(180, 10, 'Hormat kami,', 0, 0, 'L');

        $this->fpdf->Ln(35);

        $this->fpdf->SetFont('Arial', 'BU', '12');
        $this->fpdf->Cell(10);
        $this->fpdf->Cell(180, 10, 'Rudiyanto', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', 'B', '12');
        $this->fpdf->Cell(10);
        $this->fpdf->Cell(180, 10, 'General Manager ( HRD - GA )', 0, 0, 'L');

        $this->fpdf->Output();

        exit;
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
        $item  = EmployeesOuts::findOrFail($id);

        return view ('pages.admin.employee-out.edit',[
            'item'              => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeOutRequest $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $data = $request->all();
        $item = EmployeesOuts::findOrFail($id);
        $item->update($data);
        Alert::info('Success Edit Data Karyawan Keluar','Oleh '.auth()->user()->name);
        return redirect()->route('employee_out.index');
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
        $item                   = EmployeesOuts::findOrFail($id);

        //Hapus Oleh
        $item->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh

        $item->delete();
        Alert::error('Menghapus Data Karyawan Keluar','Oleh '.auth()->user()->name);
        return redirect()->route('employee_out.index');
    }
}
