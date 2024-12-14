<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Admin\Employees;
use App\Models\Admin\Companies;
use App\Models\Admin\WorkingHours;
use App\Models\Admin\Divisions;
use App\Models\Admin\HistorySalaries;
use App\Models\Admin\Positions;
use App\Models\Admin\Areas;
use App\Models\Admin\HistoryContracts;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CetakRequest;
use App\Http\Requests\Admin\CetakPKWTHarianRequest;
use Carbon\Carbon;
use Storage;
use Alert;

class CetakController extends Controller
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

    public function aktifkerja($id)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'KARYAWAN') {
            abort(403);
        }
        $item           = Employees::findOrFail($id);
        $companies      = Companies::all();
        $divisions      = Divisions::all();
        $positions      = Positions::all();
        $workinghours   = WorkingHours::all();
        $areas          = Areas::all();

        //Create Nomor Dokumen
        $nikkaryawan    = $item->nik_karyawan;
        $nik            = substr($nikkaryawan, 12);
        $mytime         = Carbon::now();
        $bulan          = substr($mytime, 5, -12);
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
        $this->fpdf->setTopMargin(2);
        $this->fpdf->setLeftMargin(2);
        $this->fpdf->SetAutoPageBreak(false);
        $this->fpdf->AddPage();

        $this->fpdf->Cell(205, 293, '', 0, 0, 'C');
        $this->fpdf->SetFont('Arial', 'B', '8');
        //KOP SURAT
        // $this->fpdf->Cell(-200);
        // $this->fpdf->Ln(5);
        // $this->fpdf->Cell(5);
        // $this->fpdf->Image('backend/assets/logo/logopanjang.jpg' , 10,8,100);
        //KOP SURAT
        
        $this->fpdf->Ln(30);
        $this->fpdf->SetFont('Arial', 'BU', '18');
        $this->fpdf->Cell(3);
        $this->fpdf->Cell(200, 10, 'SURAT KETERANGAN', 0, 0, 'C'); 
        $this->fpdf->Ln(6);
        $this->fpdf->SetFont('Arial', 'B', '14');
        $this->fpdf->Cell(3);
        $this->fpdf->Cell(200, 10, 'No.' . $nik . '/HRD/PK/'. $romawi . '/'.$tahun.'', 0, 0, 'C');
        $this->fpdf->Ln(30);

        $this->fpdf->SetFont('Arial', '', '12');
        $this->fpdf->Cell(15);
        $this->fpdf->Cell(100, 10, 'Kami Yang Bertanda Tangan Dibawah Ini :', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(15);
        $this->fpdf->Cell(50, 10, 'Nama', 0, 0, 'L');
        $this->fpdf->Cell(100, 10, ' : Achmad Firmansyah', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(15);
        $this->fpdf->Cell(50, 10, 'Jabatan', 0, 0, 'L');
        $this->fpdf->Cell(100, 10, ' : Manager (HRD-GA)', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(15);
        $this->fpdf->Cell(50, 10, 'Menerangkan Bahwa', 0, 0, 'L');
        $this->fpdf->Cell(100, 10, '  ', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(15);
        $this->fpdf->Cell(50, 10, 'Nama', 0, 0, 'L');
        $this->fpdf->Cell(100, 10, ' : ' . $item->nama_karyawan . '', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(15);
        $this->fpdf->Cell(50, 10, 'NIK ', 0, 0, 'L');
        $this->fpdf->Cell(100, 10, ' : ' . $item->nik_karyawan. '', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(15);
        $this->fpdf->Cell(50, 10, 'Jabatan / Penempatan ', 0, 0, 'L');
        $this->fpdf->Cell(100, 10, ' : ' . $item->positions->jabatan . ' / ' . $item->divisions->penempatan . '', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(15);
        $this->fpdf->Cell(50, 10, 'Tanggal Mulai Kerja', 0, 0, 'L');
        $this->fpdf->Cell(100, 10, ' : ' . \Carbon\Carbon::parse($item->tanggal_mulai_kerja)->isoformat('D MMMM Y') . '', 0, 0, 'L');
        $this->fpdf->Ln(9);

        $this->fpdf->Cell(15);
        $this->fpdf->Cell(180, 10, 'Adalah benar yang bersangkutan masih bekerja dan aktif menjadi karyawan kami,', 0, 0, 'L');
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(15);
        $this->fpdf->Cell(180, 10, 'dengan jabatan dan masa kerja di atas.', 0, 0, 'L');

        $this->fpdf->Ln(15);
        $this->fpdf->Cell(15);
        $this->fpdf->Cell(180, 10, 'Demikianlah surat keterangan ini kami buat untuk digunakan dengan seperlunya.', 0, 0, 'L');

        $this->fpdf->Ln(15);
        $this->fpdf->Cell(15);
        $this->fpdf->Cell(180, 10, 'Tangerang Selatan, ' . \Carbon\Carbon::now()->isoformat('D MMMM Y') . '', 0, 0, 'L');

        $this->fpdf->Ln(5);
        $this->fpdf->Cell(15);
        $this->fpdf->Cell(180, 10, 'Hormat kami,', 0, 0, 'L');

        $this->fpdf->Ln(38);
        //QRCODE
        // $this->fpdf->Cell(5);
        // $this->fpdf->Image('backend/assets/qrcode/qrcodesigns.png' , 17,195,30);
        // $this->fpdf->Ln(5);
        //QRCODE
        
        $this->fpdf->SetFont('Arial', 'BU', '12');
        $this->fpdf->Cell(15);
        $this->fpdf->Cell(180, 10, 'Achmad Firmansyah', 0, 0, 'L');

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', '12');
        $this->fpdf->Cell(15);
        $this->fpdf->Cell(180, 10, 'Manager (HRD-GA)', 0, 0, 'L');

        //FOOTER SURAT
        // $this->fpdf->Ln(45);
        // $this->fpdf->SetFont('Arial', '', '12');
        // $this->fpdf->SetTextColor(0,128,255);
        // $this->fpdf->Cell(10);
        // $this->fpdf->Cell(180, 4, 'Kawasan Industri Taman Tekno Blok F2 No.10-11 BSD City. Tangerang', 0, 0, 'C');
        // $this->fpdf->Ln();
        // $this->fpdf->Cell(10);
        // $this->fpdf->Cell(180, 4, 'Telp.: (+621) 75880223, 75880224, 75880225 Fax.: (+621) 75880220, 75880221', 0, 0, 'C');
        // $this->fpdf->SetFillColor(0,128,255);
        // $this->fpdf->Ln(10);
        // $this->fpdf->Cell(-2);
        // $this->fpdf->Cell(240, 8, '', 0, 0, 'C', 1);
        //FOOTER SURAT

        $this->fpdf->Output();

        exit;
    }

    public function penilaian_karyawan()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        return view('pages.admin.surat.penilaian-karyawan.index');
    }

    public function tampil_penilaian_karyawan(CetakRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $awal               = $request->input('awal_kontrak');
        $akhir              = $request->input('akhir_kontrak');

        $penilaiankaryawans = Employees::with([
            'divisions',
            'positions'
            ])->whereBetween('tanggal_akhir_kerja', [$awal, $akhir])->get();
        
        if (!$penilaiankaryawans->isEmpty()) 
        {

            $this->fpdf = new FPDF('P', 'mm', 'A4');
            $this->fpdf->setTopMargin(2);
            $this->fpdf->setLeftMargin(2);
            $this->fpdf->SetAutoPageBreak(true);
            
            foreach ($penilaiankaryawans as $penilaiankaryawan) {
                $this->fpdf->AddPage();

                $this->fpdf->Cell(205, 290, '', 1, 0, 'C');
                $this->fpdf->SetFont('Arial', 'B', '8');
                $this->fpdf->Cell(-200);
                $this->fpdf->Ln(5);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(70, 20, '', 1, 0, 'C');
                $this->fpdf->Image('../public/storage/assets/logo/logopanjang.jpg' , 9, 12, 65);
                $this->fpdf->Cell(50, 20, '', 1, 0, 'C');

                $this->fpdf->Cell(30, 5, "No.Form", 1, 0, 'L');
                $this->fpdf->Cell(43, 5, "FR/HRD-GA/HR/006/Rev.01", 1, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(125);
                $this->fpdf->Cell(30, 5, "Tgl.Dikeluarkan", 1, 0, 'L');
                $this->fpdf->Cell(43, 5, "24 November 2012", 1, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(125);
                $this->fpdf->Cell(30, 5, "Tgl.Revisi", 1, 0, 'L');
                $this->fpdf->Cell(43, 5, "01 April 2015", 1, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(125);
                $this->fpdf->Cell(30, 5, "Halaman", 1, 0, 'L');
                $this->fpdf->Cell(43, 5, "1 Dari 1", 1, 0, 'L');

                $this->fpdf->SetFont('Arial', 'B', '10');
                $this->fpdf->Ln(-13);
                $this->fpdf->Cell(75);
                $this->fpdf->Cell(50, 5, "FORM PENILAIAN I", 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(75);
                $this->fpdf->Cell(50, 5, "PRESTASI KERJA", 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(75);
                $this->fpdf->Cell(50, 5, "OPERATOR / PELAKSANA", 0, 0, 'C');

                $this->fpdf->Ln(15);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(30, 5, "Nama ", 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '10');
                $this->fpdf->Cell(5, 5, " : ", 0, 0, 'C');
                $this->fpdf->Cell(50, 5, $penilaiankaryawan->nama_karyawan, 0, 0, 'L');

                $this->fpdf->SetFont('Arial', 'B', '10');
                $this->fpdf->Ln(5);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(30, 5, "Tanggal Masuk ", 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '10');
                $this->fpdf->Cell(5, 5, " : ", 0, 0, 'C');
                $this->fpdf->Cell(50, 5, \Carbon\Carbon::parse($penilaiankaryawan->tanggal_mulai_kerja)->isoformat('dddd, D MMMM Y') . '', 0, 0, 'L');

                $this->fpdf->SetFont('Arial', 'B', '10');
                $this->fpdf->Ln(5);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(30, 5, "Jabatan / Bagian ", 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '10');
                $this->fpdf->Cell(5, 5, " : ", 0, 0, 'C');
                $this->fpdf->Cell(50, 5, $penilaiankaryawan->positions->jabatan . ' / ' . $penilaiankaryawan->divisions->penempatan . '', 0, 0, 'L');

                $this->fpdf->SetFont('Arial', 'B', '10');
                $this->fpdf->Ln(5);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(30, 5, "Tanggal Akhir", 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '10');
                $this->fpdf->Cell(5, 5, " : ", 0, 0, 'C');
                $this->fpdf->Cell(50, 5, \Carbon\Carbon::parse($penilaiankaryawan->tanggal_akhir_kerja)->isoformat('dddd, D MMMM Y') . '', 0, 0, 'L');
                
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(73, 10, 'Unsur - unsur kerja yang dinilai', 1, 0, 'C');

                $this->fpdf->Cell(17, 10, '', 1, 0, 'C');
                $this->fpdf->Cell(-17);
                $this->fpdf->Cell(17, 5, '*Hasil', 0, 0, 'C');
                $this->fpdf->Cell(60, 10, '**Kalkulasi Over All Prestasi', 1, 0, 'C');
                $this->fpdf->Cell(44, 10, '**Komulatif Prestasi', 1, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(78);
                $this->fpdf->Cell(17, 5, 'Penilaian', 0, 0, 'C');

                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Ln(5);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(73, 6, 'Kepahaman Pengetahuan Tentang Pekerjaaannya', 1, 0, 'L');
                $this->fpdf->Cell(17, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(12, 6, 'A', 1, 0, 'C');
                $this->fpdf->Cell(12, 6, 'B', 1, 0, 'C');
                $this->fpdf->Cell(12, 6, 'C', 1, 0, 'C');
                $this->fpdf->Cell(12, 6, 'D', 1, 0, 'C');
                $this->fpdf->Cell(12, 6, 'E', 1, 0, 'C');
                $this->fpdf->Cell(22, 6, 'Tingkat', 1, 0, 'C');
                $this->fpdf->Cell(22, 6, 'Angka', 1, 0, 'C');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(73, 6, 'Kepahaman Mengenal Methode Kerja', 1, 0, 'L');
                $this->fpdf->Cell(17, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, 'F', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, 'K', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, 'F', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, 'K', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, 'F', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, 'K', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, 'F', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, 'K', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, 'F', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, 'K', 1, 0, 'C');
                $this->fpdf->Ln(6);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(73, 6, 'Ketrampilan Menggunakan Sarana Kerja', 1, 0, 'L');
                $this->fpdf->Cell(17, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(6, 6, '', 1, 0, 'C');
                $this->fpdf->Ln(-6);
                $this->fpdf->Cell(155);
                $this->fpdf->Cell(22, 12, '', 1, 0, 'C');
                $this->fpdf->Cell(22, 12, '', 1, 0, 'C');
                $this->fpdf->Ln(12);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(73, 6, 'Kwantitas Hasil Kerja', 1, 0, 'L');
                $this->fpdf->Cell(17, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(104, 6, ' Keterangan ', 1, 0, 'C');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(73, 6, 'Kwalitas Hasil Kerja', 1, 0, 'L');
                $this->fpdf->Cell(17, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(104, 6, 'Sebelum menilai hendaklah terlebih dahulu membaca " Pedoman', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(73, 6, 'Inisiatif', 1, 0, 'L');
                $this->fpdf->Cell(17, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(104, 6, 'memberi nilai prestasi " yang telah disediakan. Berilah penilaian dengan', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(73, 6, 'Kerjasama', 1, 0, 'L');
                $this->fpdf->Cell(17, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(104, 6, 'Huruf ( A ) atau ( B ) atau ( C ) atau ( D ) atau ( E )', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(90, 12, 'Unsur - unsur kondite yang dinilai', 1, 0, 'C');

                $this->fpdf->Cell(104, 6, 'dalam lajur kotak " Hasil Pencarian " ', 0, 0, 'L');
                $this->fpdf->Ln(5);
                $this->fpdf->Cell(95);
                $this->fpdf->Cell(104, 6, 'F = Frekwensi dan K = Komulatif', 0, 0, 'L');

                $this->fpdf->Ln(7);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(73, 6, 'Kerajinan Kerja', 1, 0, 'L');
                $this->fpdf->Cell(17, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(104, 6, 'Nilai Konklusi :', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(73, 6, 'Kepatuhan Kerja', 1, 0, 'L');
                $this->fpdf->Cell(17, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(104, 6, 'A = 4, B = 3, C = 2, D = 1, E = 0.', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(73, 6, 'Kejujuran Wewenang', 1, 0, 'L');
                $this->fpdf->Cell(17, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(104, 6, 'Tingkat :', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(73, 6, 'Kesadaran dan Tanggung Jawab', 1, 0, 'L');
                $this->fpdf->Cell(17, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(104, 6, '[ A = 3.6 - 4 ] [ B = 2.8 - 3.5 ] [ C = 2 - 2.75 ] [ D = < 2 ]', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(73, 6, 'Kemauan Gairah Kerja', 1, 0, 'L');
                $this->fpdf->Cell(17, 6, '', 1, 0, 'C');
                $this->fpdf->Cell(104, 6, 'Tanda " * Diisi oleh Penilai  **Diisi Oleh HRD', 0, 0, 'L');

                $this->fpdf->Ln(-54);
                $this->fpdf->Cell(95);
                $this->fpdf->Cell(104, 60, '', 1, 0, 'L');

                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Ln(65);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(104, 6, '*Usulan dari atasan', 0, 0, 'L');

                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Ln(6);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(194, 5, '1. Diangkat menjadi karyawan tetap', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(8);
                $this->fpdf->Cell(191, 6, ' Dengan alasan .......................................................................................................................................................................', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(8);
                $this->fpdf->Cell(191, 6, ' ................................................................................................................................................................................................', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(8);
                $this->fpdf->Cell(191, 6, ' ................................................................................................................................................................................................', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(194, 5, '2. Diperpanjang kontrak kerja selama ...................... Tahun / Bulan', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(8);
                $this->fpdf->Cell(191, 6, ' Dengan alasan .......................................................................................................................................................................', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(8);
                $this->fpdf->Cell(191, 6, ' ................................................................................................................................................................................................', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(8);
                $this->fpdf->Cell(191, 6, ' ................................................................................................................................................................................................', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(194, 5, '3. Tidak diperpanjang kontrak kerja', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(8);
                $this->fpdf->Cell(191, 6, ' Dengan alasan ........................................................................................................................................................................', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(8);
                $this->fpdf->Cell(191, 6, ' ................................................................................................................................................................................................', 0, 0, 'L');

                $this->fpdf->Ln(6);
                $this->fpdf->Cell(8);
                $this->fpdf->Cell(191, 6, ' .................................................................................................................................................................................................', 0, 0, 'L');

                $this->fpdf->Ln(-66);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(194, 80, '', 1, 0, 'L');

                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Ln(82);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(104, 6, 'Pengesahan', 0, 0, 'L');

                $this->fpdf->SetFont('Arial', '', '9');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(48, 6, 'Penilai :', 0, 0, 'L');

                $this->fpdf->Cell(48, 6, 'Diperiksa :', 0, 0, 'L');

                $this->fpdf->Cell(48, 6, 'Diproses :', 0, 0, 'L');

                $this->fpdf->Cell(48, 6, 'Disetujui :', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(48, 6, 'Tanggal ..................................', 0, 0, 'L');
                $this->fpdf->Cell(48, 6, 'Tanggal ..................................', 0, 0, 'L');
                $this->fpdf->Cell(48, 6, 'Tanggal ..................................', 0, 0, 'L');
                $this->fpdf->Cell(48, 6, 'Tanggal ..................................', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(48, 6, 'Atasan Langsung :', 0, 0, 'C');

                $this->fpdf->Cell(48, 6, 'Kepala Dept. / Manager', 0, 0, 'C');

                $this->fpdf->Cell(48, 6, 'HRD - GA', 0, 0, 'C');

                $this->fpdf->Cell(48, 6, 'Direktur', 0, 0, 'C');

                $this->fpdf->Ln(-10);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(48, 15, '', 1, 0, 'C');

                $this->fpdf->Cell(48, 15, '', 1, 0, 'C');

                $this->fpdf->Cell(48, 15, '', 1, 0, 'C');

                $this->fpdf->Cell(48, 15, '', 1, 0, 'C');

                $this->fpdf->Ln(15);
                $this->fpdf->Cell(5);
                $this->fpdf->Cell(48, 24, '', 1, 0, 'C');
                $this->fpdf->Cell(48, 24, '', 1, 0, 'C');
                $this->fpdf->Cell(48, 24, '', 1, 0, 'C');
                $this->fpdf->Cell(48, 24, '', 1, 0, 'C');
            
            }
                $this->fpdf->Output();
                exit;
        
        } 
        else {
            Alert::error('Data Tidak Ditemukan');
            //Redirect
            return redirect()->route('cetak.penilaian_karyawan');
        }

    }

    public function pkwt($id)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'KARYAWAN') {
            abort(403);
        }
        $item               = HistoryContracts::findOrFail($id);
        $statuskontrakkerja = $item->status_kontrak_kerja;
        $nikkaryawan        = $item->employees_id;
        $karyawan           = Employees::with([
            'divisions',
            'positions'
            ])->where('nik_karyawan', $nikkaryawan)->first();
        $salary             = HistorySalaries::with([
            'employees'
            ])->where('employees_id', $nikkaryawan)->first();
        
        $companies          = Companies::all();
        $divisions          = Divisions::all();
        $positions          = Positions::all();
        $workinghours       = WorkingHours::all();
        $areas              = Areas::all();
        
        //Create Nomor Dokumen
        $nik                = substr($nikkaryawan, 12);
        $mytime             = Carbon::now();
        $bulan              = substr($mytime, 5, -12);
        $tahun              = substr($mytime, 0,4);
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

        //Jika Pria Maka Sdr Jika Wanita Maka Sdri
        if ($karyawan->jenis_kelamin == "Pria") {
            $saudara = "Sdr.";
        } elseif ($karyawan->jenis_kelamin == "Wanita") {
            $saudara = "Sdri.";
        }

        //Jika Karyawan Kontrak
        if ($statuskontrakkerja == "PKWT") 
        {
            $this->fpdf = new FPDF('P', 'mm', 'A4');
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'BU', '10');
            $this->fpdf->Cell(190, 10, 'PERJANJIAN KERJA WAKTU TERTENTU', 0, 0, 'C');
            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('Arial', 'B', '10');
            $this->fpdf->Cell(60);
            $this->fpdf->Cell(70, 10, 'No.' . $nik . '/ HRD / PK / ' . $romawi . ' / ' . $tahun . '', 0, 0, 'C');

            $this->fpdf->Ln(10);

            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(60, 7, 'Yang bertanda tangan dibawah ini :', 0, 0, 'L');

            $this->fpdf->Ln(10);

            $this->fpdf->Cell(20);
            $this->fpdf->Cell(30, 5, 'Nama', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(30, 5, ': Achmad Firmansyah', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(30, 5, 'Jabatan', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(30, 5, ': Manager (HRD-GA)', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(30, 5, 'Alamat', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(140, 5, ': Kawasan Industri Taman tekno, Blok F2. No.10-11 / F. No.1.J', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(50);
            $this->fpdf->Cell(140, 5, '  Kelurahan Setu, Kecamatan Setu, Tangerang Selatan, 15314.', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'Dalam hal ini bertindak untuk dan atas nama PT Prima Komponen Indonesia yang selanjutnya disebut pihak PERTAMA :', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->Cell(30, 5, 'Nama', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(50, 5, ': ' . $karyawan->nama_karyawan . '', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(30, 5, 'Tempat & Tgl Lahir', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(50, 5, ': ' . $karyawan->tempat_lahir . ',' . \Carbon\Carbon::parse($karyawan->tanggal_lahir)->isoformat('D MMMM Y') . '', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(30, 5, 'Alamat', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(140, 5, ': ' . $karyawan->alamat . ', RT.' . $karyawan->rt . ' / ' . $karyawan->rw . ', Kecamatan ' . $karyawan->kecamatan . '', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(50);
            $this->fpdf->Cell(140, 5, '  Kelurahan ' . $karyawan->kelurahan . ', Kota ' . $karyawan->kota . ', Provinsi ' . $karyawan->provinsi . ',' . $karyawan->kode_pos . '', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'Dalam hal ini bertindak untuk dan atas nama dirinya sendiri dan selanjutnya disebut PIHAK KEDUA. Pada hari', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(40, 5,\Carbon\Carbon::parse($item->tanggal_awal_kontrak)->isoformat('dddd, D MMMM Y'), 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(132, 5,'bertempat di gedung PT Prima Komponen Indonesia, kedua belah pihak dengan ini sepakat', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'untuk mengadakan perjanjian / ikatan kerja dalam jangka waktu tertentu, yaitu melalui kontrak kerja yang hubungan', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'kerjanya berpegang pada syarat - syarat dan ketentuan sebagai berikut : ', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'Pasal 1', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'STATUS KARYAWAN DARI PIHAK KEDUA', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'PIHAK PERTAMA memberi tugas kepada PIHAK KEDUA, dan PIHAK KEDUA menyetujui dan menerima status sebagai', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'karyawan kontrak berjangka di PT Prima Komponen Indonesia.', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'Pasal 2', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'JANGKA WAKTU KONTRAK KERJA', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(150, 5, 'PIHAK KEDUA bersedia bekerja sebagai karyawan kontrak pada PIHAK PERTAMA untuk jangka waktu ', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(20, 5,$item->masa_kontrak, 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(85, 5,'terhitung sejak perjanjian kerja ini ditandatangani yaitu dari ', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(28, 5, \Carbon\Carbon::parse($item->tanggal_awal_kontrak)->isoformat('D MMMM Y'), 0, 0, 'C');
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(25, 5, ' sampai dengan ', 0, 0, 'C');
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(28, 5,\Carbon\Carbon::parse($item->tanggal_akhir_kontrak)->isoformat('D MMMM Y'), 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'Pasal 3', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'TUGAS TUGAS POKOK PIHAK KEDUA', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'PIHAK KEDUA menerima tugas dari PIHAK PERTAMA sebagai berikut : ', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(50, 5, 'Nama Jabatan / Penempatan ', 0, 0, 'L');

            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(80, 5, ': ' . $karyawan->divisions->penempatan . ' / ' . $karyawan->positions->jabatan . '', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(50, 5, 'Perusahaan ', 0, 0, 'L');

            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(80, 5, ': PT Prima Komponen Indonesia', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'PIHAK KEDUA menyatakan tidak keberatan melakukan tugas lain dari tugas pokoknya, apabila PIHAK PERTAMA', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'memerlukannya.', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'Pasal 4', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'HARI KERJA DAN JAM KERJA', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'a. Guna kelancaran penuaian tugas tersebut pada pasal 3 diatas, PIHAK KEDUA harus sudah berada di kantor atau', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, '    ditempat lain yang ditentukan oleh PIHAK PERTAMA selama hari kerja an jam kerja yang berlaku di PT Prima ', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, '    Komponen Indonesia.', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'b. PIHAK KEDUA menyetujui untuk bekerja menurut ketentuan hari kerja dan jam kerja pada PIHAK PERTAMA sesuai', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, '    dengan ketentuan yang berlaku.', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'c. PIHAK KEDUA juga menyatakan bersedia untuk bekerja diluar hari tau jam kerja tersebut bilamana PIHAK PERTAMA ', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, '    memerlukannya.', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'Pasal 5', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'PENDAPATAN YANG DITERIMA DARI PIHAK KEDUA DARI PIHAK PERTAMA', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'Sesuai dengan kesepakatan antara kedua belah pihak, dalam perjanjian kerja ini, PIHAK KEDUA menyetujui untuk', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'menerima imbalan jasa pendapatan / upah dari PIHAK PERTAMA sebagai berikut :', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'a. Honorium / perhari sebesar sebagai berikut :', 0, 0, 'L');

            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(65, 5, 'Gaji Perbulan Yang Diterimas', 0, 0, 'L');
            $this->fpdf->Cell(65, 5, ': Rp.'.number_format($salary->jumlah_upah), 0, 0, 'L');

            $this->fpdf->Ln(10);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'b. Pihak KEDUA termasuk level karyawan non staff', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'c. Sistem pengupahan yang berlaku untuk PIHAK KEDUA adalah sistem No Work No Pay sesuai dengan ketentuan ', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, '    yang berlaku di PT Prima Komponen Indonesia.', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'Pasal 6', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'PAJAK PENDAPATAN', 0, 0, 'C');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'PIHAK PERTAMA menanggung Pajak Pendapatan PIHAK KEDUA pada Pasal 5 Di atas.', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'Pasal 7', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'KEWAJIBAN PIHAK KEDUA', 0, 0, 'C');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'a. PIHAK KEDUA wajib melaksanakan tugas dengan sebaik-baiknya dan dengan penuh Tanggung Jawab.', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, '    PIHAK KEDUA bersedia dan wajib mentaati segala peraturan perusahaan PT Prima Komponen Indonesia dan menjaga', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, '    semua rahasia perusahaan.', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'Pasal 8', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'PEMUTUSAN HUBUNGAN KERJA', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'a. Hubungan kerja antar PIHAK PERTAMA dengan PIHAK KEDUA menjadi putus dengan sendirinya tanpa perlu', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, '    pemberitahuan dari PIHAK PERTAMA pada PIHAK KEDUA. Apabila perjanjian kerja yang telah disepakati ini habis', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(37, 5, '    waktunya yaitu tanggal ', 0, 0, 'L');

            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(40, 5, \Carbon\Carbon::parse($item->tanggal_akhir_kontrak)->isoformat('dddd, D MMMM Y'), 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'b. Pemutusan hubungan kerja atas permintaan PIHAK KEDUA harus disampaikan paling sedikit satu bulan setengah', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, '    sebelum tanggal pengun duran diri PIHAK KEDUA pada PIHAK PERTAMA.', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'c. Pemutusan hubungan kerja oleh PIHAK PERTAMA terhadap PIHAK KEDUA dapat segera dilakukan jika PIHAK', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, '    KEDUA melakukan pelanggaran sesuai ketentua Tata Tertib yang diatur pada Peraturan Perusahaan.', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'Pasal 9', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(170, 5, 'LAIN - LAIN', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'a. Perjanjian kerjasama ini dibuat dan ditandatangani oleh PIHAK PERTAMA dan PIHAK KEDUA dalam keadaan sadar,', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, '    sehat jasmani dan rohani, tanpa paksaan dari pihak manapun dan merupakan dasar bagi hubungan kerja berdasar', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, '    kontrak, sesuai dengan kesepakatan bersama PIHAK PERTAMA dan PIHAK KEDUA.', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'b. Perjanjian kerja ini dibuat dalam rangkap 2 ( Dua ) dan ditandatangani oleh PIHAK PERTAMA dan PIHAK KEDUA.', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, 'c. Jika terdapat perselisihan dalam perjanjian kerja ini. Maka kedua belah pihak sepakat untuk menyelesaikan secara', 0, 0, 'L');

            $this->fpdf->Ln(5);

            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(170, 5, '    musyawarah dan mufakat.', 0, 0, 'L');

            $this->fpdf->Ln(15);
            $this->fpdf->Cell(60);
            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Cell(70, 5, 'Tangerang Selatan, ' . \Carbon\Carbon::parse($item->tanggal_awal_kontrak)->isoformat('dddd, D MMMM Y'), 0, 0, 'C');

            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(70, 5, 'Memahami dan menyetujui', 0, 0, 'C');

            $this->fpdf->Cell(30);
            $this->fpdf->Cell(70, 5, 'Perjanjian Kerja ini', 0, 0, 'C');

            $this->fpdf->Ln(4);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(70, 5, 'PIHAK KEDUA', 0, 0, 'C');

            $this->fpdf->Cell(30);
            $this->fpdf->Cell(70, 5, 'PIHAK PERTAMA', 0, 0, 'C');

            $this->fpdf->SetFont('Arial', 'B', '9');
            $this->fpdf->Ln(40);
            //TTD
            // $this->fpdf->Cell(20);
            // $this->fpdf->Image('../public/storage/assets/ttdAchmad FirmansyahFinal.png' , 150,170,30);
            // $this->fpdf->Ln(5);
            //TTD
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(70, 5, '( ' . $karyawan->nama_karyawan . ' )', 0, 0, 'C');

            
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(70, 5, '( Achmad Firmansyah )', 0, 0, 'C');

            $this->fpdf->Output();
            exit;
        }

        //Jika Karyawan Tetap
        elseif ($statuskontrakkerja == "PKWTT") 
        {
            
            $this->fpdf = new FPDF('P', 'mm', 'A4');
            $this->fpdf->setTopMargin(2);
            $this->fpdf->setLeftMargin(2);
            $this->fpdf->SetAutoPageBreak(false);
            $this->fpdf->AddPage();

            
            $this->fpdf->SetFont('Arial', 'B', '8');

            //KOP SURAT
            // $this->fpdf->Cell(-200);
            // $this->fpdf->Ln(5);
            // $this->fpdf->Cell(5);
            // $this->fpdf->Image('../public/storage/assets/logo/logopanjang.jpg' , 10,8,100);
            //KOP SURAT

            $this->fpdf->Ln(25);
            $this->fpdf->SetFont('Arial', '', '12');
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(40, 7, 'Kepada Yth :', 0, 0, 'L');

            $this->fpdf->Cell(70);
            $this->fpdf->Cell(70, 7, 'No : ' . $nik . '/HRD/PK/' . $romawi . '/' . $tahun . '', 0, 0, 'R');

            $this->fpdf->SetFont('Arial', 'B', '12');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(40, 7, $saudara . '' . $karyawan->nama_karyawan . '', 0, 0, 'L');

            $this->fpdf->SetFont('Arial', '', '12');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(40, 7, 'Di tempat.', 0, 0, 'L');

            $this->fpdf->SetFont('Arial', 'BUI', '12');
            $this->fpdf->Ln(15);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(40, 7, 'Perihal : Pengangkatan Karyawan Tetap', 0, 0, 'L');


            $this->fpdf->SetFont('Arial', '', '12');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(40, 7, 'Dengan hormat,', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(48, 7, 'Terhitung sejak tanggal, ', 0, 0, 'L');

            $this->fpdf->SetFont('Arial', 'B', '12');
            $this->fpdf->Cell(36, 7, \Carbon\Carbon::parse($item->tanggal_awal_kontrak)->isoformat('D MMMM Y') . ',', 0, 0, 'C');

            $this->fpdf->SetFont('Arial', '', '12');
            $this->fpdf->Cell(51, 7, 'Management PT Prima Komponen Indonesia,', 0, 0, 'L');

            $this->fpdf->SetFont('Arial', '', '12');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(180, 7, 'mengangkat saudara ' . $karyawan->nama_karyawan . ' sebagai Karyawan Tetap setelah menjalani masa kontrak', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(37, 7, 'kerja sejak tanggal ', 0, 0, 'L');

            $this->fpdf->SetFont('Arial', 'B', '12');
            $this->fpdf->Cell(40, 7, \Carbon\Carbon::parse($karyawan->tanggal_mulai_kerja)->isoformat('D MMMM Y') . '.', 0, 0, 'L');

            $this->fpdf->SetFont('Arial', '', '12');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 7, '1. Hak saudara sebagai karyawan tetap mulai berlaku sejak tanggal pengangkatan', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25);
            $this->fpdf->Cell(165, 7, 'karyawan tetap ini, yaitu ( Pesangon, Penghargaan Masa Kerja, dan lain-lain apabila', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25);
            $this->fpdf->Cell(165, 7, 'terjadi pengakhiran masa kerja ).Namun masa kerja saudara berlaku untuk perhitungan', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25);
            $this->fpdf->Cell(165, 7, 'masa cuti yang belum diambil sejak kontrak di tandatangani.', 0, 0, 'L');

            $this->fpdf->Ln(7);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(55, 7, '2. Jabatan / Nama Bagian : ', 0, 0, 'L');

            $this->fpdf->SetFont('Arial', 'B', '12');
            $this->fpdf->Cell(90, 7, $karyawan->positions->jabatan . ' / ' . $karyawan->divisions->penempatan . '.', 0, 0, 'L');

            $this->fpdf->SetFont('Arial', '', '12');
            $this->fpdf->Ln(7);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 7, '3. Sistem pengupahan adalah azas No Work No Pay.', 0, 0, 'L');

            $this->fpdf->Ln(7);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 7, '4. Wajib mengikuti / mematuhi tata tertib yang berlaku pada pihak perusahaan serta', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25);
            $this->fpdf->Cell(165, 7, 'undang-undang ketenagakerjaan yang berlaku.', 0, 0, 'L');

            $this->fpdf->Ln(7);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 7, '5. Berhak mendapat cuti tahunan 12 hari kerja dalam satu tahun masa kerja', 0, 0, 'L');

            $this->fpdf->Ln(7);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 7, '6. Berhak mendapat asuransi tenaga kerja sesuai dengan ketentuan undang-undang yang', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25);
            $this->fpdf->Cell(165, 7, 'berlaku.', 0, 0, 'L');

            $this->fpdf->Ln(15);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(180, 7, 'Hal-hal yang belum jelas pada surat pengangkatan ini akan dijelaskan kemudian secara lisan', 0, 0, 'L');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(180, 7, 'atau tertulis.', 0, 0, 'L');

            $this->fpdf->Ln(15);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(180, 7, 'Demikianlah surat pengangkatan ini dibuat untuk dapat dimaklumi.', 0, 0, 'L');

            $this->fpdf->SetFont('Arial', 'B', '12');
            $this->fpdf->Ln(15);
            $this->fpdf->Cell(50);
            $this->fpdf->Cell(100, 7, 'Dikeluarkan di Tangerang Selatan, tanggal, ' . \Carbon\Carbon::parse($item->tanggal_awal_kontrak)->isoformat('D MMMM Y'), 0, 0, 'C');

            $this->fpdf->SetFont('Arial', '', '12');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(70, 7, 'Atas nama pimpinan perusahaan', 0, 0, 'C');

            $this->fpdf->Cell(40);
            $this->fpdf->Cell(70, 7, 'Diterima yang bersangkutan', 0, 0, 'C');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(70, 7, 'PT Prima Komponen Indonesia', 0, 0, 'C');

            $this->fpdf->SetFont('Arial', 'BU', '12');
            $this->fpdf->Ln(35);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(70, 7, 'Achmad Firmansyah', 0, 0, 'C');

            $this->fpdf->SetFont('Arial', '', '12');
            $this->fpdf->Cell(40);
            $this->fpdf->Cell(70, 7, '( ' . $karyawan->nama_karyawan . ' )', 0, 0, 'C');

            $this->fpdf->SetFont('Arial', 'B', '12');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(70, 7, 'Manager (HRD-GA)', 0, 0, 'C');

            //FOOTER SURAT
            // $this->fpdf->Ln(18);
            // $this->fpdf->SetFont('Arial', '', '12');
            // $this->fpdf->SetTextColor(0,128,255);
            // $this->fpdf->Cell(10);
            // $this->fpdf->Cell(180, 4, 'Kawasan Industri Taman Tekno Blok F2 No.10-11 BSD City. Tangerang', 0, 0, 'C');
            // $this->fpdf->Ln();
            // $this->fpdf->Cell(10);
            // $this->fpdf->Cell(180, 4, 'Telp.: (+621) 75880223, 75880224, 75880225 Fax.: (+621) 75880220, 75880221', 0, 0, 'C');
            // $this->fpdf->SetFillColor(0,128,255);
            // $this->fpdf->Ln(10);
            // $this->fpdf->Cell(-2);
            // $this->fpdf->Cell(240, 8, '', 0, 0, 'C', 1);
            //FOOTER SURAT

            $this->fpdf->Output();
            exit;
        } 

        //Jika Karyawan Harian
        elseif ($statuskontrakkerja == "Harian") 
        {
            $this->fpdf = new FPDF('P', 'mm', 'A4');
            $this->fpdf->setTopMargin(10);
            $this->fpdf->setLeftMargin(4);
            $this->fpdf->SetAutoPageBreak(true);
            $this->fpdf->AddPage();
    
            $this->fpdf->SetFont('Arial', 'BU', '12');
            $this->fpdf->Cell(190, 10, 'SURAT PERJANJIAN KERJA HARIAN LEPAS', 0, 0, 'C');
            $this->fpdf->Ln(5);
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(190, 10, 'No : ' . $nik . '/ PK / HRD / ' . $romawi . ' / ' . $tahun . '.', 0, 0, 'C');
    
            $this->fpdf->Ln(15);
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Yang bertanda tangan di bawah ini :', 0, 0, 'L');
    
            $this->fpdf->Ln(10);
    
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(10, 7, '1. ', 0, 0, 'L');
            $this->fpdf->Cell(50, 7, 'Nama', 0, 0, 'L');
            $this->fpdf->Cell(5, 7, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(115, 7, ' Achmad Firmansyah', 0, 0, 'L');
    
            $this->fpdf->Ln();
    
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(50, 7, 'Jabatan', 0, 0, 'L');
            $this->fpdf->Cell(5, 7, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(115, 7, ' Manager HRD-GA PT Prima Komponen Indonesia', 0, 0, 'L');
    
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Dalam hal  ini  bertindak atas nama Manager HRD-GA PT Prima Komponen  Indonesia  yang', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'berkedudukan di Kawasan Industri Pergudangan Taman Tekno Blok F2 No.10-11, Kelurahan', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(120, 5, 'Setu, Kecamatan Setu, Tangerang Selatan. Dan selanjutnya disebut', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(50, 5, ' PIHAK  PERTAMA (I).', 0, 0, 'L');
    
            $this->fpdf->Ln(10);
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(10);
            $this->fpdf->Cell(10, 8, '2. ', 0, 0, 'L');
            $this->fpdf->Cell(50, 8, 'No.KTP/SIM', 0, 0, 'L');
            $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(115, 8, ' '.$karyawan->nik_karyawan, 0, 0, 'L');
    
            $this->fpdf->Ln();
    
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(50, 8, 'Nama', 0, 0, 'L');
            $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(115, 8, ' '.$karyawan->nama_karyawan, 0, 0, 'L');
    
            $this->fpdf->Ln();
    
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(50, 8, 'Tempat,Tanggal Lahir', 0, 0, 'L');
            $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(115, 8, ' '.$karyawan->tempat_lahir.', '.\Carbon\Carbon::parse($karyawan->tanggal_lahir)->isoformat('D MMMM Y'), 0, 0, 'L');
    
            $this->fpdf->Ln();
    
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(50, 8, 'Pendidikan Terakhir', 0, 0, 'L');
            $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(115, 8, ' '.$karyawan->pendidikan_terakhir, 0, 0, 'L');
    
            $this->fpdf->Ln();
    
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(50, 8, 'Jenis Kelamin', 0, 0, 'L');
            $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(115, 8, ' '.$karyawan->jenis_kelamin, 0, 0, 'L');
    
            $this->fpdf->Ln();
    
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(50, 8, 'Agama', 0, 0, 'L');
            $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(115, 8, ' '.$karyawan->agama, 0, 0, 'L');
    
            $this->fpdf->Ln();
    
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(50, 8, 'Alamat', 0, 0, 'L');
            $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(115, 6, ' '.$karyawan->alamat.', '.$karyawan->rt.'/'.$karyawan->rw.', Kelurahan.'.$karyawan->kelurahan, 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(75);
            $this->fpdf->Cell(115, 6, ' Kecamatan.'.$karyawan->kecamatan.', Kota.'.$karyawan->kota.', '.$karyawan->provinsi, 0, 0, 'L');
    
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(144, 8, 'Dalam  hal  ini  bertindak  untuk dan atas nama dari pribadi dan selanjutnya disebut', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(27, 8, '  PIHAK', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(30, 8, 'KEDUA (II).', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
    
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PASAL 1', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PERNYATAAN - PERNYATAAN', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(35, 6, 'PIHAK PERTAMA ', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(96, 6, ' telah   menyatakan   persetujuannya  untuk   menerima', 0, 0, 'L');
            
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(30, 6, ' PIHAK  KEDUA', 0, 0, 'L');
            
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 6, 'selaku pekerja harian lepas.', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(28, 6, 'PIHAK KEDUA ', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(96, 6, 'menyatakan kesediannya selaku pekerja harian lepas yang tunduk pada tata,', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(115, 6, 'tertib, peraturan, dan sistem kerja yang berlaku pada perusahaan', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(28, 6, 'PIHAK PERTAMA ', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
    
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PASAL 2', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'RUANG LINGKUP PEKERJAAN', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
            
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(57, 6, 'Pekerjaan yang harus dilakukan', 0, 0, 'L');
            
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(28, 6, 'PIHAK KEDUA ', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(58, 6, 'selaku pekerja harian lepas pada', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(28, 6, 'PIHAK', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(21, 6, 'PERTAMA', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(16, 6, ' adalah ', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'BU', '11');
            $this->fpdf->Cell(60, 6, ''.$karyawan->positions->jabatan.' / '.$karyawan->divisions->penempatan, 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(28, 6, 'PIHAK KEDUA ', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(96, 6, 'tidak diperkenankan mengerjakan pekerjaan lain selain yang disebutkan pada,', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(116, 6, 'ayat 1 tersebut di atas, kecuali atas persetujuan dan perintah dari', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(36, 6, ' PIHAK  PERTAMA ', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(10, 6, ' atau ', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(15, 6, 'atasan', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(36, 6, 'PIHAK KEDUA.', 0, 0, 'L');
    
            
            //TTD
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            // $this->fpdf->Image('../public/storage/assets/ttdAchmad FirmansyahFinal.png' , 36,270,30);
            $this->fpdf->Ln(5);
            //TTD
            $this->fpdf->Ln(100);
    
            $this->fpdf->Ln(50);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, '', 0, 0, 'C');
    
    
            $this->fpdf->Ln(20);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PASAL 3', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'MASA BERLAKU PERJANJIAN KERJA', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
            
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 6, 'Perjanjian kerja ini berlaku untuk jangka waktu 20 hari(dua puluh hari), terhitung sejak tanggal', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(135, 6, 'penandatanganan surat perjanjian kerja ini dan akan berakhir pada tanggal : ', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'BU', '11');
            $this->fpdf->Cell(30, 6, ' '.\Carbon\Carbon::parse($item->tanggal_akhir_kontrak)->isoformat('D MMMM Y').'.', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
            
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(117, 6, 'Setelah berakhirnya jangka waktu tersebut. Hubungan kerja antara', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(35, 6, 'PIHAK PERTAMA.', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(15, 6, 'dengan', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(35, 6, 'PIHAK KEDUA', 0, 0, 'C');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(115, 6, 'menjadi putus dengan sendirinya tanpa perlu pemberitahuan dari', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(35, 6, 'PIHAK PERTAMA', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(10, 6, 'pada', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(35, 6, 'PIHAK KEDUA.', 0, 0, 'L');
    
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PASAL 4', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'CARA KERJA', 0, 0, 'C');
            
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(35, 6, 'PIHAK PERTAMA', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(95, 6, 'atau wakil perusahaan PT Prima Komponen Indonesia akan memberikan', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(70, 6, 'pengarahan perihal cara kerja sebelum', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(30, 6, 'PIHAK KEDUA', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(65, 6, 'memulai pekerjaannya.', 0, 0, 'L');
    
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PASAL 5', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'JAM KERJA', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Berdasarkan peraturan ketenagakerjaan yang berlaku, jam kerja efektif perusahaan ditetapkan', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, '8 (delapan) jam perhari, 40 (empat puluh) jam perminggu, dengan jumlah hari kerja 5 (lima) hari', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'dalam seminggu.', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Jam masuk adalah jam 08:00 (delapan) pagi dan jam pulang adalah jam (17:00) (lima sore).', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 3', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '1.  Waktu istirahat pada hari Senin hingga Kamis ditetapkan selama 1 (satu) jam, yaitu', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '     pada pukul 12:00 (dua belas siang) hingga pukul 13:00 (satu siang).', 0, 0, 'L');
    
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '2.  Waktu istirahat pada hari Jumat ditetapkan selama 1,5 (satu koma lima) jam, yaitu', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '     pada pukul 11:30 (sebelas tiga puluh siang) hingga pukul 13:00 (satu siang).', 0, 0, 'L');
    
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PASAL 6', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'UPAH DAN PEMBAYARAN', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(35, 5, 'PIHAK PERTAMA', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(57, 5, 'akan memberikan upah sebesar ', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(25, 5, 'Rp.'.number_format($salary->jumlah_upah/20), 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(60, 5, 'rupiah setiap hari kehadiran', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(15, 5, 'kepada', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(30, 5, 'PIHAK KEDUA', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Pembayaran  upah  akan  dibayarkan setiap tanggal 25 setiap bulannya. ', 0, 0, 'L');
    
            //TTD
            $this->fpdf->Ln();
            // $this->fpdf->Cell(20);
            // $this->fpdf->Image('../public/storage/assets/ttdAchmad FirmansyahFinal.png' , 36,265,30);
            $this->fpdf->Ln(5);
            //TTD
            $this->fpdf->Ln(100);
    
            $this->fpdf->Ln(50);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, '', 0, 0, 'C');
    
    
            $this->fpdf->Ln(20);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PASAL 7', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'LEMBUR', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
            
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(30, 6, 'PIHAK KEDUA', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(140, 6, 'diharuskan masuk kerja lembur jika tersedia pekerjaan yang harus segera', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(140, 6, 'diselesaikan atau bersifat mendesak (URGENT).', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
            
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(77, 6, 'Sebagai imbalan kerja lembur sesuai ayat 1,', 0, 0, 'L');
            
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(33, 6, 'PIHAK PERTAMA ', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(28, 6, 'akan membayar', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(35, 6, ' PIHAK KEDUA', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(16, 6, 'sebesar', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(23, 6, 'Rp.'.number_format($salary->upah_lembur_perjam), 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(60, 6, 'rupiah setiap jam lembur.', 0, 0, 'L');

            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(40, 6, 'rupiah setiap jam lembur.', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 3', 0, 0, 'C');
            
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(150, 6, 'Pembayaran upah lembur akan di satukan dengan pembayaran upah yang akan diterima', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(30, 6, 'PIHAK KEDUA', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(105, 6, 'sesuai Pasal 6 ayat 2 perjanjian ini.', 0, 0, 'L');
    
            $this->fpdf->Ln(20);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PASAL 8', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'BERAKHIRNYA PERJANJIAN', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(80, 6, 'Setiap saat hubungan kerja dapat diakhiri jika', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(30, 6, 'PIHAK KEDUA', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(50, 6, 'melanggar tata tertib, peraturan,', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(85, 6, 'dan sistem kerja yang berlaku pada perusahaan', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(35, 6, 'PIHAK PERTAMA.', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(80, 6, 'Pelanggaran yang dimaksud pada ayat 1 tersebut diatas, adalah :', 0, 0, 'L');
    
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '1.   Tidak masuk kerja selama 1 (satu) hari kerja tanpa keterangan tertulis atau alasan sah', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '      yang dapat dibenarkan oleh atasan atau pihak perusahaan.', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '2.   Melakukan tindak penipuan, pencurian, penggelapan, atau tindak-tindak melawan', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '      hukum lainnya.', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '3.   Menyalahgunakan wewenang dan jabatan untuk kepentingan pribadi.', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(125, 5, '4.   Melakukan perusakan dengan sengaja yang menimbulkan kerugian ', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(35, 5, 'PIHAK PERTAMA.', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '11');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(125, 5, '5.   Melakukan hal-hal lain karena kecerobohannya yang mengakibatkan', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(35, 5, 'PIHAK PERTAMA', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '      mengalami kerugian.', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '6.   Melakukan perjudian di tempat kerja.', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '7.   Mabuk-mabukan atau mengkonsumsi narkotika dan obat-obatan terlarang di lingkungan', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '      kerja perusahaan.', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '8.   Melakukan keributan atau keonaran yang mengganggu suasana kerja di lingkungan kerja', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '      perusahaan.', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '9.   Melakukan perkelahian atau penganiayaan terhadap pekerja lain.', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(29);
            $this->fpdf->Cell(160, 5,'10.  Menghasut para pekerja lain untuk melakukan mogok kerja.', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(29);
            $this->fpdf->Cell(160, 5,'11.  Merokok ditempat kerja atau membawa rokok dan korek api dalam lingkungan kerja.', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(29);
            $this->fpdf->Cell(160, 5,'12.  Masuk jam kerja tidak tepat waktu selama 2 (dua) kali.', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(29);
            $this->fpdf->Cell(160, 5,'13.  Tidak menggunakan alat keselamatan kerja yang sudah ditetapkan.', 0, 0, 'L');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(29);
            $this->fpdf->Cell(160, 5,'14.  Tidak menggunakan alat keselamatan dalam berkendara baik berangkat maupun pulang', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(160, 5, '      kerja.', 0, 0, 'L');
            //TTD
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            // $this->fpdf->Image('../public/storage/assets/ttdAchmad FirmansyahFinal.png' , 36,270,30);
            $this->fpdf->Ln(5);
            //TTD
            $this->fpdf->Ln(100);
    
            $this->fpdf->Ln(50);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, '', 0, 0, 'C');
    
    
            $this->fpdf->Ln(20);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PASAL 9', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'KEADAAN DARURAT (FORCE MAJEUR)', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Perjanjian kerja ini batal dengan sendirinya jika karena keadaan atau situasi yang memaksa,', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Seperti : Bencana Alam, Pemberontakan, Perang, Huru-hara, Kerusuhan, Peraturan Pemerintah', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'atau apapun.', 0, 0, 'L');
    
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PASAL 10', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PENYELESAIAN PERSELISIHAN', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
            
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Apabila terjadi perselisihan antara kedua belah pihak, akan diselesaikan secara musyawarah ', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'untuk mencapai mufakat.', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
            
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Apabila dengan cara ayat 1 pasal ini tidak tercapai kata sepakat, maka kedua belah pihak sepakat', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'untuk menyelesaikan permasalahan tersebut dilakukan melalui prosedur hukum.', 0, 0, 'L');
    
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PASAL 11', 0, 0, 'C');
    
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'PENUTUP', 0, 0, 'C');
    
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Demikianlah perjanjian ini dibuat, disetujui, dan ditandatangani dalam rangkap dua, asli, dan ', 0, 0, 'L');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'tembusan bermaterai cukup dan berkekuatan hukum yang sama. Satu dipegang oleh', 0, 0, 'L');
    
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Ln();
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(35, 5, 'PIHAK PERTAMA', 0, 0, 'L');
            
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(35, 5, 'dan lainnya untuk', 0, 0, 'L');
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(35, 5, 'PIHAK KEDUA.', 0, 0, 'L');
    
            $this->fpdf->Ln(30);
            $this->fpdf->SetFont('Arial', '', '11');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(170, 5, 'Tangerang Selatan, '.\Carbon\Carbon::parse($item->tanggal_awal_kontrak)->isoformat('D MMMM Y'), 0, 0, 'C');
    
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(50, 5, 'PIHAK PERTAMA', 0, 0, 'C');
            $this->fpdf->Cell(70, 5, '', 0, 0, 'C');
            $this->fpdf->Cell(50, 5, 'PIHAK KEDUA', 0, 0, 'C');
    
            $this->fpdf->Ln(30);
            //TTD
            $this->fpdf->Cell(20);
            // $this->fpdf->Image('../public/storage/assets/ttdAchmad FirmansyahStempelFinal.png' , 17,188,70);
            $this->fpdf->Ln(5);
            //TTD
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(20);
            $this->fpdf->Cell(50, 5, '( Achmad Firmansyah )', 0, 0, 'C');
            $this->fpdf->Cell(70, 5, '', 0, 0, 'C');
            $this->fpdf->Cell(50, 5, '( '.$karyawan->nama_karyawan.' )', 0, 0, 'C');


            $this->fpdf->Output();
            exit;
        } 

        //Jika Karyawan Outsourcing
        else {
            $this->fpdf = new FPDF('P', 'mm', 'A4');
            $this->fpdf->setTopMargin(2);
            $this->fpdf->setLeftMargin(2);
            $this->fpdf->SetAutoPageBreak(true);
            $this->fpdf->AddPage();

            $this->fpdf->Cell(205, 293, '', 0, 0, 'C');
            $this->fpdf->SetFont('Arial', 'B', '8');
            $this->fpdf->Cell(-200);
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(5);
            $this->fpdf->Ln(40);
            $this->fpdf->SetFont('Arial', 'BU', '12');
            $this->fpdf->Cell(15);
            $this->fpdf->Cell(180, 10, 'Outsourcing', 0, 0, 'L');


            $this->fpdf->Output();
            exit;
        }
    
    }

    public function pkwt_harian()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        return view('pages.admin.surat.pkwt.harian.index');
    }

    public function tampil_pkwt_harian(CetakPKWTHarianRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $awal               = $request->input('awal_kontrak');
        $akhir              = $request->input('akhir_kontrak');
        $golongan           = $request->input('golongan');
        
        $pkwtharians = HistoryContracts::with([
            'employees'
            ])->where('status_kontrak_kerja', 'Harian')
            ->whereBetween('tanggal_akhir_kontrak', [$awal, $akhir])
            ->orderBy('tanggal_akhir_kontrak', 'ASC')->get();
            
            $this->fpdf = new FPDF('P', 'mm', 'A4');
            $this->fpdf->setTopMargin(10);
            $this->fpdf->setLeftMargin(4);
            $this->fpdf->SetAutoPageBreak(true);
            $this->fpdf->AddPage();
            
            foreach ($pkwtharians as $pkwtharian) {

                $items = Employees::with([
                    'divisions',
                    'positions'
                    ])->where('nik_karyawan', $pkwtharian->employees_id)->where('golongans_id', $golongan)->get();

                $salaries = HistorySalaries::with([
                    'employees'
                    ])->where('employees_id', $pkwtharian->employees_id)->get();
                
                foreach ($salaries as $salary) {

                foreach ($items as $item) {
                 
                $nik            = substr($pkwtharian->employees_id, 12);
                $mytime         = $pkwtharian->tanggal_awal_kontrak;
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

                $upah_perhari = $salary->jumlah_upah/20;
         
                $this->fpdf->SetFont('Arial', 'BU', '12');
                $this->fpdf->Cell(190, 10, 'SURAT PERJANJIAN KERJA HARIAN LEPAS', 0, 0, 'C');
                $this->fpdf->Ln(5);
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(190, 10, 'No : ' . $nik . '/ PK / HRD / ' . $romawi . ' / ' . $tahun . '.', 0, 0, 'C');
        
                $this->fpdf->Ln(15);
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Yang bertanda tangan di bawah ini :', 0, 0, 'L');
        
                $this->fpdf->Ln(10);
    
                $this->fpdf->Cell(10);
                $this->fpdf->Cell(10, 7, '1. ', 0, 0, 'L');
                $this->fpdf->Cell(50, 7, 'Nama', 0, 0, 'L');
                $this->fpdf->Cell(5, 7, ' : ', 0, 0, 'C');
                $this->fpdf->Cell(115, 7, ' Achmad Firmansyah', 0, 0, 'L');
        
                $this->fpdf->Ln();
        
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(50, 7, 'Jabatan', 0, 0, 'L');
                $this->fpdf->Cell(5, 7, ' : ', 0, 0, 'C');
                $this->fpdf->Cell(115, 7, ' Manager HRD-GA PT Prima Komponen Indonesia', 0, 0, 'L');
        
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Dalam hal  ini  bertindak atas nama Manager HRD-GA PT Prima Komponen  Indonesia  yang', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'berkedudukan di Kawasan Industri Pergudangan Taman Tekno Blok F2 No.10-11, Kelurahan', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(120, 5, 'Setu, Kecamatan Setu, Tangerang Selatan. Dan selanjutnya disebut', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(50, 5, ' PIHAK  PERTAMA (I).', 0, 0, 'L');
        
                $this->fpdf->Ln(10);
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(10);
                $this->fpdf->Cell(10, 8, '2. ', 0, 0, 'L');
                $this->fpdf->Cell(50, 8, 'No.KTP/SIM', 0, 0, 'L');
                $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
                $this->fpdf->Cell(115, 8, ' '.$pkwtharian->employees->nik_karyawan, 0, 0, 'L');
        
                $this->fpdf->Ln();
        
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(50, 8, 'Nama', 0, 0, 'L');
                $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
                $this->fpdf->Cell(115, 8, ' '.$pkwtharian->employees->nama_karyawan, 0, 0, 'L');
        
                $this->fpdf->Ln();
        
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(50, 8, 'Tempat,Tanggal Lahir', 0, 0, 'L');
                $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
                $this->fpdf->Cell(115, 8, ' '.$pkwtharian->employees->tempat_lahir.', '.\Carbon\Carbon::parse($pkwtharian->employees->tanggal_lahir)->isoformat('D MMMM Y'), 0, 0, 'L');
        
                $this->fpdf->Ln();
        
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(50, 8, 'Pendidikan Terakhir', 0, 0, 'L');
                $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
                $this->fpdf->Cell(115, 8, ' '.$pkwtharian->employees->pendidikan_terakhir, 0, 0, 'L');
        
                $this->fpdf->Ln();
        
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(50, 8, 'Jenis Kelamin', 0, 0, 'L');
                $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
                $this->fpdf->Cell(115, 8, ' '.$pkwtharian->employees->jenis_kelamin, 0, 0, 'L');
        
                $this->fpdf->Ln();
        
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(50, 8, 'Agama', 0, 0, 'L');
                $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
                $this->fpdf->Cell(115, 8, ' '.$pkwtharian->employees->agama, 0, 0, 'L');
        
                $this->fpdf->Ln();
        
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(50, 8, 'Alamat', 0, 0, 'L');
                $this->fpdf->Cell(5, 8, ' : ', 0, 0, 'C');
                $this->fpdf->Cell(115, 6, ' '.$pkwtharian->employees->alamat.', '.$pkwtharian->employees->rt.'/'.$pkwtharian->employees->rw.', Kelurahan.'.$pkwtharian->employees->kelurahan, 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(75);
                $this->fpdf->Cell(115, 6, ' Kecamatan.'.$pkwtharian->employees->kecamatan.', Kota.'.$pkwtharian->employees->kota.', '.$pkwtharian->employees->provinsi, 0, 0, 'L');
        
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(144, 8, 'Dalam  hal  ini  bertindak  untuk dan atas nama dari pribadi dan selanjutnya disebut', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(27, 8, '  PIHAK', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(30, 8, 'KEDUA (II).', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
        
                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PASAL 1', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PERNYATAAN - PERNYATAAN', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(35, 6, 'PIHAK PERTAMA ', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(96, 6, ' telah   menyatakan   persetujuannya  untuk   menerima', 0, 0, 'L');
                
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(30, 6, ' PIHAK  KEDUA', 0, 0, 'L');
                
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 6, 'selaku pekerja harian lepas.', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(28, 6, 'PIHAK KEDUA ', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(96, 6, 'menyatakan kesediannya selaku pekerja harian lepas yang tunduk pada tata,', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(115, 6, 'tertib, peraturan, dan sistem kerja yang berlaku pada perusahaan', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(28, 6, 'PIHAK PERTAMA ', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
        
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PASAL 2', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'RUANG LINGKUP PEKERJAAN', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
                
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(57, 6, 'Pekerjaan yang harus dilakukan', 0, 0, 'L');
                
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(28, 6, 'PIHAK KEDUA ', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(58, 6, 'selaku pekerja harian lepas pada', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(28, 6, 'PIHAK', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(21, 6, 'PERTAMA', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(16, 6, ' adalah ', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'BU', '11');
                $this->fpdf->Cell(60, 6, ''.$item->divisions->penempatan.' / '.$item->positions->jabatan, 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(28, 6, 'PIHAK KEDUA ', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(96, 6, 'tidak diperkenankan mengerjakan pekerjaan lain selain yang disebutkan pada,', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(116, 6, 'ayat 1 tersebut di atas, kecuali atas persetujuan dan perintah dari', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(36, 6, ' PIHAK  PERTAMA ', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(10, 6, ' atau ', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(15, 6, 'atasan', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(36, 6, 'PIHAK KEDUA.', 0, 0, 'L');
        
                $this->fpdf->Ln(100);
                $this->fpdf->Ln(50);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, '', 0, 0, 'C');
        
                $this->fpdf->Ln(20);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PASAL 3', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'MASA BERLAKU PERJANJIAN KERJA', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
                
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 6, 'Perjanjian kerja ini berlaku untuk jangka waktu 20 hari (dua puluh hari) kerja, terhitung sejak tanggal', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(135, 6, 'penandatanganan surat perjanjian kerja ini dan akan berakhir pada tanggal : ', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'BU', '11');
                $this->fpdf->Cell(30, 6, ' '.\Carbon\Carbon::parse($pkwtharian->tanggal_akhir_kontrak)->isoformat('D MMMM Y').'.', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
                
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(117, 6, 'Setelah berakhirnya jangka waktu tersebut. Hubungan kerja antara', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(35, 6, 'PIHAK PERTAMA.', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(15, 6, 'dengan', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(35, 6, 'PIHAK KEDUA', 0, 0, 'C');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(115, 6, 'menjadi putus dengan sendirinya tanpa perlu pemberitahuan dari', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(35, 6, 'PIHAK PERTAMA', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(10, 6, 'pada', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(35, 6, 'PIHAK KEDUA.', 0, 0, 'L');
        
                $this->fpdf->Ln(10);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PASAL 4', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'CARA KERJA', 0, 0, 'C');
                
                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(35, 6, 'PIHAK PERTAMA', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(95, 6, 'atau wakil perusahaan PT Prima Komponen Indonesia akan memberikan', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(70, 6, 'pengarahan perihal cara kerja sebelum', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(30, 6, 'PIHAK KEDUA', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(65, 6, 'memulai pekerjaannya.', 0, 0, 'L');
        
                $this->fpdf->Ln(10);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PASAL 5', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'JAM KERJA', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Berdasarkan peraturan ketenagakerjaan yang berlaku, jam kerja efektif perusahaan ditetapkan', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, '8 (delapan) jam perhari, 40 (empat puluh) jam perminggu, dengan jumlah hari kerja 5 (lima) hari', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'dalam seminggu.', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Jam masuk adalah jam 08:00 (delapan) pagi dan jam pulang adalah jam (17:00) (lima sore).', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 3', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '1.  Waktu istirahat pada hari Senin hingga Kamis ditetapkan selama 1 (satu) jam, yaitu', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '     pada pukul 12:00 (dua belas siang) hingga pukul 13:00 (satu siang).', 0, 0, 'L');
        
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '2.  Waktu istirahat pada hari Jumat ditetapkan selama 1,5 (satu koma lima) jam, yaitu', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '     pada pukul 11:30 (sebelas tiga puluh siang) hingga pukul 13:00 (satu siang).', 0, 0, 'L');
        
                $this->fpdf->Ln(10);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PASAL 6', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'UPAH DAN PEMBAYARAN', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(35, 5, 'PIHAK PERTAMA', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(57, 5, 'akan memberikan upah sebesar ', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(25, 5, 'Rp.'.number_format($upah_perhari), 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(60, 5, 'rupiah setiap hari kehadiran', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(15, 5, 'kepada', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(30, 5, 'PIHAK KEDUA', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Pembayaran  upah  akan  dibayarkan setiap tanggal 25 setiap bulannya. ', 0, 0, 'L');
        
                $this->fpdf->Ln(100);
                $this->fpdf->Ln(50);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, '', 0, 0, 'C');
        
                $this->fpdf->Ln(20);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PASAL 7', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'LEMBUR', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
                
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(30, 6, 'PIHAK KEDUA', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(140, 6, 'diharuskan masuk kerja lembur jika tersedia pekerjaan yang harus segera', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(140, 6, 'diselesaikan atau bersifat mendesak (URGENT).', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
                
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(77, 6, 'Sebagai imbalan kerja lembur sesuai ayat 1,', 0, 0, 'L');
                
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(33, 6, 'PIHAK PERTAMA ', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(28, 6, 'akan membayar', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(35, 6, ' PIHAK KEDUA', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(16, 6, 'sebesar', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(23, 6, 'Rp.'.number_format($salary->upah_lembur_perjam), 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(60, 6, 'rupiah setiap jam lembur.', 0, 0, 'L');

                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(40, 6, 'rupiah setiap jam lembur.', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 3', 0, 0, 'C');
                
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(150, 6, 'Pembayaran upah lembur akan di satukan dengan pembayaran upah yang akan diterima', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(30, 6, 'PIHAK KEDUA', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(105, 6, 'sesuai Pasal 6 ayat 2 perjanjian ini.', 0, 0, 'L');
        
                $this->fpdf->Ln(20);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PASAL 8', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'BERAKHIRNYA PERJANJIAN', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(80, 6, 'Setiap saat hubungan kerja dapat diakhiri jika', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(30, 6, 'PIHAK KEDUA', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(50, 6, 'melanggar tata tertib, peraturan,', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(85, 6, 'dan sistem kerja yang berlaku pada perusahaan', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(35, 6, 'PIHAK PERTAMA.', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(80, 6, 'Pelanggaran yang dimaksud pada ayat 1 tersebut diatas, adalah :', 0, 0, 'L');
        
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '1.   Tidak masuk kerja selama 1 (satu) hari kerja tanpa keterangan tertulis atau alasan sah', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '      yang dapat dibenarkan oleh atasan atau pihak perusahaan.', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '2.   Melakukan tindak penipuan, pencurian, penggelapan, atau tindak-tindak melawan', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '      hukum lainnya.', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '3.   Menyalahgunakan wewenang dan jabatan untuk kepentingan pribadi.', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(125, 5, '4.   Melakukan perusakan dengan sengaja yang menimbulkan kerugian ', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(35, 5, 'PIHAK PERTAMA.', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '11');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(125, 5, '5.   Melakukan hal-hal lain karena kecerobohannya yang mengakibatkan', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(35, 5, 'PIHAK PERTAMA', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '      mengalami kerugian.', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '6.   Melakukan perjudian di tempat kerja.', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '7.   Mabuk-mabukan atau mengkonsumsi narkotika dan obat-obatan terlarang di lingkungan', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '      kerja perusahaan.', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '8.   Melakukan keributan atau keonaran yang mengganggu suasana kerja di lingkungan kerja', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '      perusahaan.', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '9.   Melakukan perkelahian atau penganiayaan terhadap pekerja lain.', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(29);
                $this->fpdf->Cell(160, 5,'10.  Menghasut para pekerja lain untuk melakukan mogok kerja.', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(29);
                $this->fpdf->Cell(160, 5,'11.  Merokok ditempat kerja atau membawa rokok dan korek api dalam lingkungan kerja.', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(29);
                $this->fpdf->Cell(160, 5,'12.  Masuk jam kerja tidak tepat waktu selama 2 (dua) kali.', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(29);
                $this->fpdf->Cell(160, 5,'13.  Tidak menggunakan alat keselamatan kerja yang sudah ditetapkan.', 0, 0, 'L');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(29);
                $this->fpdf->Cell(160, 5,'14.  Tidak menggunakan alat keselamatan dalam berkendara baik berangkat maupun pulang', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(160, 5, '      kerja.', 0, 0, 'L');
        
                $this->fpdf->Ln(100);
        
                $this->fpdf->Ln(50);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, '', 0, 0, 'C');
        
        
                $this->fpdf->Ln(20);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PASAL 9', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'KEADAAN DARURAT (FORCE MAJEUR)', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Perjanjian kerja ini batal dengan sendirinya jika karena keadaan atau situasi yang memaksa,', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Seperti : Bencana Alam, Pemberontakan, Perang, Huru-hara, Kerusuhan, Peraturan Pemerintah', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'atau apapun.', 0, 0, 'L');
        
                $this->fpdf->Ln(10);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PASAL 10', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PENYELESAIAN PERSELISIHAN', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');
                
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Apabila terjadi perselisihan antara kedua belah pihak, akan diselesaikan secara musyawarah ', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'untuk mencapai mufakat.', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');
                
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Apabila dengan cara ayat 1 pasal ini tidak tercapai kata sepakat, maka kedua belah pihak sepakat', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'untuk menyelesaikan permasalahan tersebut dilakukan melalui prosedur hukum.', 0, 0, 'L');
        
                $this->fpdf->Ln(10);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PASAL 11', 0, 0, 'C');
        
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'PENUTUP', 0, 0, 'C');
        
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Demikianlah perjanjian ini dibuat, disetujui, dan ditandatangani dalam rangkap dua, asli, dan ', 0, 0, 'L');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'tembusan bermaterai cukup dan berkekuatan hukum yang sama. Satu dipegang oleh', 0, 0, 'L');
        
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(35, 5, 'PIHAK PERTAMA', 0, 0, 'L');
                
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(35, 5, 'dan lainnya untuk', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(35, 5, 'PIHAK KEDUA.', 0, 0, 'L');
        
                $this->fpdf->Ln(30);
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(170, 5, 'Tangerang Selatan, '.\Carbon\Carbon::parse($pkwtharian->tanggal_awal_kontrak)->isoformat('D MMMM Y'), 0, 0, 'C');
        
                $this->fpdf->Ln(10);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(50, 5, 'PIHAK PERTAMA', 0, 0, 'C');
                $this->fpdf->Cell(70, 5, '', 0, 0, 'C');
                $this->fpdf->Cell(50, 5, 'PIHAK KEDUA', 0, 0, 'C');
        
                $this->fpdf->Ln(40);
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(50, 5, '( Achmad Firmansyah )', 0, 0, 'C');
                $this->fpdf->Cell(70, 5, '', 0, 0, 'C');
                $this->fpdf->Cell(50, 5, '( '.$pkwtharian->employees->nama_karyawan.' )', 0, 0, 'C');
                $this->fpdf->Ln(100);
            }
            }
            }
            $this->fpdf->Output();
            exit;
    }

    public function pkwt_kontrak()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        return view('pages.admin.surat.pkwt.kontrak.index');
    }

    public function tampil_pkwt_kontrak(CetakRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
        $awal               = $request->input('awal_kontrak');
        $akhir              = $request->input('akhir_kontrak');
        
        $pkwtkontraks = HistoryContracts::with([
            'employees'
            ])->where('status_kontrak_kerja', 'PKWT')
            ->whereBetween('tanggal_akhir_kontrak', [$awal, $akhir])
            ->orderBy('tanggal_akhir_kontrak', 'ASC')->get();
            
            $this->fpdf = new FPDF('P', 'mm', 'A4');
            $this->fpdf->AddPage();
            
            foreach ($pkwtkontraks as $pkwtkontrak) {

                $items = Employees::with([
                    'divisions',
                    'positions'
                    ])->where('nik_karyawan', $pkwtkontrak->employees_id)->get();

                $salaries = HistorySalaries::with([
                    'employees'
                    ])->where('employees_id', $pkwtkontrak->employees_id)->get();
                
                foreach ($salaries as $salary) {
                foreach ($items as $item) {
                //Create Nomor Dokumen
                $nik            = substr($pkwtkontrak->employees_id, 12);
                $mytime         = $pkwtkontrak->tanggal_awal_kontrak;
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

                $this->fpdf->SetFont('Arial', 'BU', '10');
                $this->fpdf->Cell(190, 10, 'PERJANJIAN KERJA WAKTU TERTENTU', 0, 0, 'C');
                $this->fpdf->Ln(5);
                $this->fpdf->SetFont('Arial', 'B', '10');
                $this->fpdf->Cell(60);
                $this->fpdf->Cell(70, 10, 'No.' . $nik . '/ HRD / PK / ' . $romawi . ' / ' . $tahun . '', 0, 0, 'C');

                $this->fpdf->Ln(10);

                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(60, 7, 'Yang bertanda tangan dibawah ini :', 0, 0, 'L');

                $this->fpdf->Ln(10);

                $this->fpdf->Cell(20);
                $this->fpdf->Cell(30, 5, 'Nama', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(30, 5, ': Achmad Firmansyah', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(30, 5, 'Jabatan', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(30, 5, ': Manager (HRD-GA)', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(30, 5, 'Alamat', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(140, 5, ': Kawasan Industri Taman tekno, Blok F2. No.10-11 / F. No.1.J', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(50);
                $this->fpdf->Cell(140, 5, '  Kelurahan Setu, Kecamatan Setu, Tangerang Selatan, 15314.', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'Dalam hal ini bertindak untuk dan atas nama PT Prima Komponen Indonesia yang selanjutnya disebut pihak PERTAMA :', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->Cell(30, 5, 'Nama', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(50, 5, ': ' . $item->nama_karyawan . '', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(30, 5, 'Tempat & Tgl Lahir', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(50, 5, ': ' . $item->tempat_lahir . ',' . \Carbon\Carbon::parse($item->tanggal_lahir)->isoformat('D MMMM Y') . '', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(30, 5, 'Alamat', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(140, 5, ': ' . $item->alamat . ', RT.' . $item->rt . ' / ' . $item->rw . ', Kecamatan ' . $item->kecamatan . '', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(50);
                $this->fpdf->Cell(140, 5, '  Kelurahan ' . $item->kelurahan . ', Kota ' . $item->kota . ', Provinsi ' . $item->provinsi . ',' . $item->kode_pos . '', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'Dalam hal ini bertindak untuk dan atas nama dirinya sendiri dan selanjutnya disebut PIHAK KEDUA. Pada hari', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(40, 5,\Carbon\Carbon::parse($pkwtkontrak->tanggal_awal_kontrak)->isoformat('dddd, D MMMM Y'), 0, 0, 'L');
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(132, 5,'bertempat di gedung PT Prima Komponen Indonesia, kedua belah pihak dengan ini sepakat', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'untuk mengadakan perjanjian / ikatan kerja dalam jangka waktu tertentu, yaitu melalui kontrak kerja yang hubungan', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'kerjanya berpegang pada syarat - syarat dan ketentuan sebagai berikut : ', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'Pasal 1', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'STATUS KARYAWAN DARI PIHAK KEDUA', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'PIHAK PERTAMA memberi tugas kepada PIHAK KEDUA, dan PIHAK KEDUA menyetujui dan menerima status sebagai', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'karyawan kontrak berjangka di PT Prima Komponen Indonesia.', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'Pasal 2', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'JANGKA WAKTU KONTRAK KERJA', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(150, 5, 'PIHAK KEDUA bersedia bekerja sebagai karyawan kontrak pada PIHAK PERTAMA untuk jangka waktu ', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(20, 5,$item->masa_kontrak, 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(85, 5,'terhitung sejak perjanjian kerja ini ditandatangani yaitu dari ', 0, 0, 'L');
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(28, 5, \Carbon\Carbon::parse($pkwtkontrak->tanggal_awal_kontrak)->isoformat('D MMMM Y'), 0, 0, 'C');
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(25, 5, ' sampai dengan ', 0, 0, 'C');
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(28, 5,\Carbon\Carbon::parse($pkwtkontrak->tanggal_akhir_kontrak)->isoformat('D MMMM Y'), 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'Pasal 3', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'TUGAS TUGAS POKOK PIHAK KEDUA', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'PIHAK KEDUA menerima tugas dari PIHAK PERTAMA sebagai berikut : ', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(50, 5, 'Nama Jabatan / Penempatan ', 0, 0, 'L');

                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(80, 5, ': ' . $item->positions->jabatan . ' / ' . $item->divisions->penempatan . '', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(50, 5, 'Perusahaan ', 0, 0, 'L');

                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(80, 5, ': PT Prima Komponen Indonesia', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'PIHAK KEDUA menyatakan tidak keberatan melakukan tugas lain dari tugas pokoknya, apabila PIHAK PERTAMA', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'memerlukannya.', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'Pasal 4', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'HARI KERJA DAN JAM KERJA', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'a. Guna kelancaran penuaian tugas tersebut pada pasal 3 diatas, PIHAK KEDUA harus sudah berada di kantor atau', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, '    ditempat lain yang ditentukan oleh PIHAK PERTAMA selama hari kerja an jam kerja yang berlaku di PT Prima ', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, '    Komponen Indonesia.', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'b. PIHAK KEDUA menyetujui untuk bekerja menurut ketentuan hari kerja dan jam kerja pada PIHAK PERTAMA sesuai', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, '    dengan ketentuan yang berlaku.', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'c. PIHAK KEDUA juga menyatakan bersedia untuk bekerja diluar hari tau jam kerja tersebut bilamana PIHAK PERTAMA ', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, '    memerlukannya.', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'Pasal 5', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'PENDAPATAN YANG DITERIMA DARI PIHAK KEDUA DARI PIHAK PERTAMA', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'Sesuai dengan kesepakatan antara kedua belah pihak, dalam perjanjian kerja ini, PIHAK KEDUA menyetujui untuk', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'menerima imbalan jasa pendapatan / upah dari PIHAK PERTAMA sebagai berikut :', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'a. Honorium / perhari sebesar sebagai berikut :', 0, 0, 'L');

                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(65, 5, 'Gaji Perbulan Yang Diterima', 0, 0, 'L');
                $this->fpdf->Cell(65, 5, ': Rp.'.number_format($salary->jumlah_upah), 0, 0, 'L');

                $this->fpdf->Ln(10);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'b. Pihak KEDUA termasuk level karyawan non staff', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'c. Sistem pengupahan yang berlaku untuk PIHAK KEDUA adalah sistem No Work No Pay sesuai dengan ketentuan ', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, '    yang berlaku di PT Prima Komponen Indonesia.', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'Pasal 6', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'PAJAK PENDAPATAN', 0, 0, 'C');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'PIHAK PERTAMA menanggung Pajak Pendapatan PIHAK KEDUA pada Pasal 5 Di atas.', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'Pasal 7', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'KEWAJIBAN PIHAK KEDUA', 0, 0, 'C');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'a. PIHAK KEDUA wajib melaksanakan tugas dengan sebaik-baiknya dan dengan penuh Tanggung Jawab.', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, '    PIHAK KEDUA bersedia dan wajib mentaati segala peraturan perusahaan PT Prima Komponen Indonesia dan menjaga', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, '    semua rahasia perusahaan.', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'Pasal 8', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'PEMUTUSAN HUBUNGAN KERJA', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'a. Hubungan kerja antar PIHAK PERTAMA dengan PIHAK KEDUA menjadi putus dengan sendirinya tanpa perlu', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, '    pemberitahuan dari PIHAK PERTAMA pada PIHAK KEDUA. Apabila perjanjian kerja yang telah disepakati ini habis', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(37, 5, '    waktunya yaitu tanggal ', 0, 0, 'L');

                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(40, 5, \Carbon\Carbon::parse($pkwtkontrak->tanggal_akhir_kontrak)->isoformat('dddd, D MMMM Y'), 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'b. Pemutusan hubungan kerja atas permintaan PIHAK KEDUA harus disampaikan paling sedikit satu bulan setengah', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, '    sebelum tanggal pengun duran diri PIHAK KEDUA pada PIHAK PERTAMA.', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'c. Pemutusan hubungan kerja oleh PIHAK PERTAMA terhadap PIHAK KEDUA dapat segera dilakukan jika PIHAK', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, '    KEDUA melakukan pelanggaran sesuai ketentua Tata Tertib yang diatur pada Peraturan Perusahaan.', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'Pasal 9', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(170, 5, 'LAIN - LAIN', 0, 0, 'C');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'a. Perjanjian kerjasama ini dibuat dan ditandatangani oleh PIHAK PERTAMA dan PIHAK KEDUA dalam keadaan sadar,', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, '    sehat jasmani dan rohani, tanpa paksaan dari pihak manapun dan merupakan dasar bagi hubungan kerja berdasar', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, '    kontrak, sesuai dengan kesepakatan bersama PIHAK PERTAMA dan PIHAK KEDUA.', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'b. Perjanjian kerja ini dibuat dalam rangkap 2 ( Dua ) dan ditandatangani oleh PIHAK PERTAMA dan PIHAK KEDUA.', 0, 0, 'L');

                $this->fpdf->Ln(5);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, 'c. Jika terdapat perselisihan dalam perjanjian kerja ini. Maka kedua belah pihak sepakat untuk menyelesaikan secara', 0, 0, 'L');

                $this->fpdf->Ln(5);

                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(170, 5, '    musyawarah dan mufakat.', 0, 0, 'L');

                $this->fpdf->Ln(15);
                $this->fpdf->Cell(60);
                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Cell(70, 5, 'Tangerang Selatan, ' . \Carbon\Carbon::parse($pkwtkontrak->tanggal_awal_kontrak)->isoformat('dddd, D MMMM Y'), 0, 0, 'C');

                $this->fpdf->Ln(10);
                $this->fpdf->Cell(20);
                $this->fpdf->SetFont('Arial', '', '9');
                $this->fpdf->Cell(70, 5, 'Memahami dan menyetujui', 0, 0, 'C');

                $this->fpdf->Cell(30);
                $this->fpdf->Cell(70, 5, 'Perjanjian Kerja ini', 0, 0, 'C');

                $this->fpdf->Ln(4);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(70, 5, 'PIHAK KEDUA', 0, 0, 'C');

                $this->fpdf->Cell(30);
                $this->fpdf->Cell(70, 5, 'PIHAK PERTAMA', 0, 0, 'C');

                $this->fpdf->SetFont('Arial', 'B', '9');
                $this->fpdf->Ln(40);
                $this->fpdf->Cell(20);
                $this->fpdf->Cell(70, 5, '( ' . $item->nama_karyawan . ' )', 0, 0, 'C');

                $this->fpdf->Cell(30);
                $this->fpdf->Cell(70, 5, '( Achmad Firmansyah )', 0, 0, 'C');
                $this->fpdf->Ln(90);
            }
            }   
            }
            $this->fpdf->Output();
            exit;

    }

    public function index()
    {
        //
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
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
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }
    }
}
