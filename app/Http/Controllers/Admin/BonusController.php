<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BonusRequest;
use App\Models\Admin\Divisions;
use App\Models\Admin\Employees;
use Carbon\Carbon;
use Storage;
use Alert;

class BonusController extends Controller
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

        $divisions      = Divisions::all();

        return view('pages.admin.bonus.index',[
            'divisions'     => $divisions
        ]);
    }

    public function cetak_form_penilaian(BonusRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD') {
            abort(403);
        }

        $divisions   = $request->input('divisions_id');

        $penilaiankaryawans = Employees::with([
            'divisions',
            'positions'
            ])->where('divisions_id', $divisions)->where('golongans_id', 2)->get();
        
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

                if ($penilaiankaryawan->status_kerja == "PKWTT") {
                    $this->fpdf->Cell(50, 5, '-', 0, 0, 'L');
                } else {
                    $this->fpdf->Cell(50, 5, \Carbon\Carbon::parse($penilaiankaryawan->tanggal_akhir_kerja)->isoformat('dddd, D MMMM Y') . '', 0, 0, 'L');
                }

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
                $this->fpdf->Cell(104, 6, '[ A = 3 - 4 ] [ B = 2 - 2,99 ] [ C = 1 - 1,99 ] [ D = 0 - 0,99 ]', 0, 0, 'L');

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

                $this->fpdf->Cell(48, 6, 'Kepala Unit / Manager', 0, 0, 'C');

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
