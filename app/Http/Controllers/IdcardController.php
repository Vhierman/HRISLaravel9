<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Employees;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use App\Models\Admin\Golongans;
use App\Models\Admin\Areas;
use Codedge\Fpdf\Fpdf\Fpdf;
use Carbon\Carbon;
use File;
use Storage;
use Alert;

class IdcardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        //
        $id = $request->route('id');
        $item = Employees::with([
            'areas',
            'golongans',
            'divisions',
            'positions'
            ])->where('nik_karyawan', $id)->first();

            $nikkaryawan    = $item->nik_karyawan;

        $path = base_path('public/storage/'.$item->foto_karyawan);

        $this->fpdf = new FPDF('P', 'mm', [70,50]);
        $this->fpdf->setTopMargin(2);
        $this->fpdf->setLeftMargin(2);
        $this->fpdf->SetAutoPageBreak(false);
        $this->fpdf->AddPage();

        $this->fpdf->Cell(205, 293, '', 0, 0, 'C');
        $this->fpdf->SetFont('Arial', 'B', '8');

        //BG
        $this->fpdf->Cell(-200);
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(5);
        $this->fpdf->Image('backend/assets/idcard/TemplateIdCard.png' , 0,0,50);
        //BG

        //FOTO KARYAWAN
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(5);
        $this->fpdf->Image($path, 16,15,17);
        //FOTO KARYAWAN
        

        $jumlahnama = strlen($item->nama_karyawan);
        if ($jumlahnama<=15)
        {
        $this->fpdf->Ln(30);
        $this->fpdf->SetFont('Arial', 'B', '15');
        $this->fpdf->Cell(-2);
        $this->fpdf->Cell(50, 5, strtoupper($item->nama_karyawan), 0, 1, 'C');
        }
        else
        {
        $this->fpdf->Ln(30);
        $this->fpdf->SetFont('Arial', 'B', '9');
        $this->fpdf->Cell(-2);
        $this->fpdf->Cell(50, 5, strtoupper($item->nama_karyawan), 0, 1, 'C');
        }

        $jumlahjabatan = strlen($item->positions->jabatan);
        if ($jumlahjabatan<=20)
        {
        $this->fpdf->Ln(-1);
        $this->fpdf->SetFont('Arial', 'B', '10');
        $this->fpdf->Cell(-2);
        $this->fpdf->Cell(50, 5, strtoupper($item->positions->jabatan), 0, 1, 'C');
        }
        else{
        $this->fpdf->Ln(-1);
        $this->fpdf->SetFont('Arial', 'B', '5');
        $this->fpdf->Cell(-2);
        $this->fpdf->Cell(50, 5, strtoupper($item->positions->jabatan), 0, 1, 'C');
        }


        $jumlahposition = strlen($item->divisions->penempatan);
        if ($jumlahposition<=15)
        {
        $this->fpdf->Ln(-1);
        $this->fpdf->SetFont('Arial', 'B', '10');
        $this->fpdf->Cell(-2);
        $this->fpdf->Cell(50, 5, strtoupper($item->divisions->penempatan), 0, 1, 'C');
        }
        else{
        $this->fpdf->Ln(-1);
        $this->fpdf->SetFont('Arial', 'B', '5');
        $this->fpdf->Cell(-2);
        $this->fpdf->Cell(50, 5, strtoupper($item->divisions->penempatan), 0, 1, 'C');
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
    }
}
