<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Http\Requests\Admin\InventoryCarRequest;
use App\Http\Requests\Admin\InventoryCarUpdateRequest;
use App\Models\Admin\Employees;
use App\Models\Admin\InventoryCars;
use App\Models\Admin\Areas;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use Carbon\Carbon;
use File;
use Storage;
use Alert;

class InventoryCarController extends Controller
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        $items = InventoryCars::with([
            'employees',
            ])->get();
    
        return view('pages.admin.inventory-car.index',[
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
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.inventory-car.create',[
            'items'     => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InventoryCarRequest $request)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $data['foto_stnk_mobil']  = $request->file('foto_stnk_mobil')->store(
            'assets/inventaris/mobil/stnk','public'
        );
        $data['foto_mobil']  = $request->file('foto_mobil')->store(
            'assets/inventaris/mobil/mobil','public'
        );

        InventoryCars::create([
            'employees_id'              => $request->input('employees_id'),
            'merk_mobil'                => $request->input('merk_mobil'),
            'type_mobil'                => $request->input('type_mobil'),
            'nomor_polisi'              => $request->input('nomor_polisi'),
            'warna_mobil'               => $request->input('warna_mobil'),
            'nomor_rangka_mobil'        => $request->input('nomor_rangka_mobil'),
            'nomor_mesin_mobil'         => $request->input('nomor_mesin_mobil'),
            'tanggal_akhir_pajak_mobil' => $request->input('tanggal_akhir_pajak_mobil'),
            'tanggal_akhir_plat_mobil'  => $request->input('tanggal_akhir_plat_mobil'),
            'tanggal_penyerahan_mobil'  => $request->input('tanggal_penyerahan_mobil'),
            'foto_stnk_mobil'           => $data['foto_stnk_mobil'],
            'foto_mobil'                => $data['foto_mobil'],
            'input_oleh'                => $request->input('input_oleh')
        ]);
        Alert::success('Success Input Data Inventaris Mobil','Oleh '.auth()->user()->name);
        return redirect()->route('inventory_car.index');
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
        $item           = InventoryCars::findOrFail($id);
        $nikkaryawan    = $item->employees_id;

        $itemkaryawan   = Employees::with([
            'divisions',
            'positions'
            ])->where('nik_karyawan', $nikkaryawan)->first();
        
        //Create Nomor Dokumen
        $nik            = substr($nikkaryawan, 12);
        $mytime         = $item->tanggal_penyerahan_mobil;
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
        //Create Nomor Dokumen

        $this->fpdf = new FPDF('P', 'mm', 'A4');
        $this->fpdf->AddPage();

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'BU', '18');
        $this->fpdf->Cell(-5);
        $this->fpdf->Cell(200, 10, 'SURAT PENYERAHAN INVENTARIS PERUSAHAAN', 0, 0, 'C');
        $this->fpdf->Ln(6);
        $this->fpdf->SetFont('Arial', 'B', '14');
        $this->fpdf->Cell(-5);
        $this->fpdf->Cell(200, 10, 'No.' . $nik . '/HRD/PK/' . $romawi . '/' . $tahun . '.', 0, 0, 'C');
        $this->fpdf->Ln(15);

        $this->fpdf->SetFont('Arial', '', '12');

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(100, 10, 'Pada hari ini : ' . \Carbon\Carbon::parse($item->tanggal_penyerahan_mobil)->isoformat('D MMMM Y') . '. Diserahkan inventaris perusahaan kepada', 0, 0, 'L');

        $this->fpdf->Ln(10);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(65, 5, 'Nama ', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ' :', 0, 0, 'L');
        $this->fpdf->Cell(100, 5, $itemkaryawan->nama_karyawan, 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(65, 5, 'NIK ', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ' :', 0, 0, 'L');
        $this->fpdf->Cell(100, 5, $itemkaryawan->nik_karyawan, 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(65, 5, 'Jabatan / Penempatan ', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ' :', 0, 0, 'L');
        $this->fpdf->Cell(100, 5, $itemkaryawan->positions->jabatan . ' / ' . $itemkaryawan->divisions->penempatan . '', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(65, 5, 'Alamat ', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ' :', 0, 0, 'L');
        $this->fpdf->Cell(100, 5, $itemkaryawan->alamat . ', RT/RW.' . $itemkaryawan->rt . '/' . $itemkaryawan->rw . '', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(80);
        $this->fpdf->Cell(100, 5, 'Kelurahan ' . $itemkaryawan->kelurahan . ', Kecamatan ' . $itemkaryawan->kecamatan . '.', 0, 0, 'L');

        $this->fpdf->Ln(7);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(100, 10, 'Dengan data inventaris utama sebagai berikut : ', 0, 0, 'L');

        $this->fpdf->Ln(10);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(65, 5, 'Jenis Inventaris ', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ' :', 0, 0, 'L');
        $this->fpdf->Cell(100, 5, 'Mobil', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(65, 5, 'Nomor Polisi ', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ' :', 0, 0, 'L');
        $this->fpdf->Cell(100, 5, $item->nomor_polisi, 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(65, 5, 'Merk / Type Motor ', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ' :', 0, 0, 'L');
        $this->fpdf->Cell(100, 5, $item->merk_mobil . ' / ' . $item->type_mobil . '', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(65, 5, 'Warna Motor ', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ' :', 0, 0, 'L');
        $this->fpdf->Cell(100, 5, $item->warna_mobil, 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(65, 5, 'Nomor Rangka ', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ' :', 0, 0, 'L');
        $this->fpdf->Cell(100, 5, $item->nomor_rangka_mobil, 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(65, 5, 'Nomor Mesin ', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ' :', 0, 0, 'L');
        $this->fpdf->Cell(100, 5, $item->nomor_mesin_mobil, 0, 0, 'L');

        $this->fpdf->Ln(8);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(100, 10, 'Dengan ketentuan : ', 0, 0, 'L');

        $this->fpdf->Ln(10);

        $this->fpdf->Cell(20);
        $this->fpdf->Cell(100, 10, '1. Inventaris tersebut diberikan sebagai sarana penunjang tugas sesuai dengan', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(25);
        $this->fpdf->Cell(100, 10, 'tugas atau keperluan tugas.', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(20);
        $this->fpdf->Cell(100, 10, '2. Tidak diperkenankan merubah bentuk luar / dalam kecuali atas izin pimpinan', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(25);
        $this->fpdf->Cell(100, 10, 'perusahaan.', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(20);
        $this->fpdf->Cell(100, 10, '3. Tidak diperkenankan meminjamkan inventaris ini kepada pihak lain', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(25);
        $this->fpdf->Cell(100, 10, '( luar perusahaan ) tanpa seizin pimpinan perusahaan.', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(20);
        $this->fpdf->Cell(100, 10, '4. Segala resiko yang terjadi sehubungan dengan inventaris di atas ( Kerusakan,', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(25);
        $this->fpdf->Cell(100, 10, 'Kehilangan, dll ) sepenuhnya menjadi tanggung jawab saudara ( Ganti ).', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(20);
        $this->fpdf->Cell(100, 10, '5. Apabila suatu saat tidak bekerja di PT Prima Komponen Indonesia, maka', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(25);
        $this->fpdf->Cell(100, 10, 'saudara wajib mengembalikan seluruh inventaris ini pada perusahaan.', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(20);
        $this->fpdf->Cell(100, 10, '6. Apabila suatu saat inventaris ini diperlukan perusahaan, maka perusahaan ', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(25);
        $this->fpdf->Cell(100, 10, 'dapat menarik seketika dari saudara. Untuk itu saudara harap maklum.', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(20);
        $this->fpdf->Cell(100, 10, '7. Harap saudara menjaga / merawat inventaris ini dengan sebaik - baiknya.', 0, 0, 'L');

        $this->fpdf->Ln(10);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(100, 10, 'Demikianlah surat inventaris ini dibuat untuk ditandatangani dan dimaklumi.', 0, 0, 'L');

        $this->fpdf->Ln(10);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(70, 10, 'Tangerang Selatan,' . \Carbon\Carbon::parse($item->tanggal_penyerahan_mobil)->isoformat('D MMMM Y') . '', 0, 0, 'L');

        $this->fpdf->Cell(40);
        $this->fpdf->Cell(60, 10, 'Diterima yang bersangkutan', 0, 0, 'L');

        $this->fpdf->Ln(5);

        $this->fpdf->Cell(10);
        $this->fpdf->Cell(70, 10, 'PT Prima Komponen Indonesia', 0, 0, 'L');

        $this->fpdf->Ln(40);

        $this->fpdf->SetFont('Arial', 'BU', '12');
        $this->fpdf->Cell(10);
        $this->fpdf->Cell(70, 10, 'Achmad Firmansyah', 0, 0, 'L');

        $this->fpdf->SetFont('Arial', 'B', '12');
        $this->fpdf->Cell(40);
        $this->fpdf->Cell(60, 10, '( ' . $itemkaryawan->nama_karyawan . ' )', 0, 0, 'L');

        $this->fpdf->Ln(5);
        $this->fpdf->Cell(10);
        $this->fpdf->Cell(70, 10, 'Manager ( HRD - GA )', 0, 0, 'L');

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
        $iteminventory  = InventoryCars::findOrFail($id);
        $nikkaryawan    = $iteminventory->employees_id;
        $item           = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $items = Employees::with([
            'areas',
            'divisions',
            'positions'
            ])->get();

        return view ('pages.admin.inventory-car.edit',[
            'items'             => $items,
            'item'              => $item,
            'iteminventory'     => $iteminventory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InventoryCarUpdateRequest $request, $id)
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $iteminventory  = InventoryCars::findOrFail($id);
        $nikkaryawan    = $iteminventory->nik_karyawan;
        $item           = Employees::where('nik_karyawan', $nikkaryawan)->first();
        $data           = $request->all();

        //Unlink / Tambah Storage Images
        $fotomobil     = $iteminventory->foto_mobil;
        $foto_mobil    = $request->file('foto_mobil');
        
        if(Storage::exists('public/'.$fotomobil) && $foto_mobil <> null){
            Storage::delete('public/'.$fotomobil);
            $data['foto_mobil'] = $request->file('foto_mobil')->store(
                'assets/inventaris/mobil/mobil','public'
            );
        }
        elseif (Storage::exists('public/'.$fotomobil) && $foto_mobil == null ) {
            $data['foto_mobil'] = $fotomobil;
        }
        else{
            dd('File does not exists.');
        }

        $fotostnkmobil      = $iteminventory->foto_stnk_mobil;
        $foto_stnk_mobil    = $request->file('foto_stnk_mobil');

        if(Storage::exists('public/'.$fotostnkmobil) && $foto_stnk_mobil <> null){
            Storage::delete('public/'.$fotostnkmobil);
            $data['foto_stnk_mobil'] = $request->file('foto_stnk_mobil')->store(
                'assets/inventaris/mobil/stnk','public'
            );
        }
        elseif (Storage::exists('public/'.$fotostnkmobil) && $foto_stnk_mobil == null ) {
            $data['foto_stnk_mobil'] = $fotostnkmobil;
        }
        else{
            dd('File does not exists.');
        }

        $iteminventory->update($data);
        Alert::info('Success Edit Data Inventaris Mobil','Oleh '.auth()->user()->name);
        return redirect()->route('inventory_car.index');
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
        $iteminventory  = InventoryCars::findOrFail($id);
        
        //Hapus Oleh
        $iteminventory->update([
            'hapus_oleh'    => auth()->user()->name
        ]);
        //Hapus Oleh

        $nikkaryawan    = $iteminventory->nik_karyawan;
        $item           = Employees::where('nik_karyawan', $nikkaryawan)->first();

        $fotostnkmobil  = $iteminventory->foto_stnk_mobil;
        $fotomobil      = $iteminventory->foto_mobil;
        Storage::delete('public/'.$fotostnkmobil);
        Storage::delete('public/'.$fotomobil);

        $iteminventory->delete();
        Alert::error('Menghapus Data Inventaris Mobil','Oleh '.auth()->user()->name);
        return redirect()->route('inventory_car.index');
    }
}
