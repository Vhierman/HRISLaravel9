<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Admin\RekapSalaries;
use App\Models\Admin\Employees;
use App\Models\Admin\Areas;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use App\Models\Admin\Golongans;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class RekapSalaryExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $awal,$roles;

    function __construct($awal,$roles) {
            $this->awal = $awal;
            $this->roles = $roles;
    }

    public function collection()
    {

        if ($this->roles == 'MANAGER HRD') {
            $rekapsalaries = 
            DB::table('rekap_salaries')
            ->join('employees', 'employees.nik_karyawan', '=', 'rekap_salaries.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('areas', 'areas.id', '=', 'employees.areas_id')
            ->join('golongans', 'golongans.id', '=', 'employees.golongans_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where('periode_awal','=', $this->awal)
            ->where('golongan', '=','II')
            ->where('rekap_salaries.deleted_at','=',null)
            ->get();
        }
        elseif ($this->roles == 'MANAGER ACCOUNTING') {
            $rekapsalaries = 
            DB::table('rekap_salaries')
            ->join('employees', 'employees.nik_karyawan', '=', 'rekap_salaries.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('areas', 'areas.id', '=', 'employees.areas_id')
            ->join('golongans', 'golongans.id', '=', 'employees.golongans_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where('periode_awal','=', $this->awal)
            ->where('golongan', '=','I')
            ->where('rekap_salaries.deleted_at','=',null)
            ->get();
        }
        elseif ($this->roles == 'ACCOUNTING') {
            $rekapsalaries = 
            DB::table('rekap_salaries')
            ->join('employees', 'employees.nik_karyawan', '=', 'rekap_salaries.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('areas', 'areas.id', '=', 'employees.areas_id')
            ->join('golongans', 'golongans.id', '=', 'employees.golongans_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where('periode_awal','=', $this->awal)
            ->where('golongan', '=','II')
            ->where('rekap_salaries.deleted_at','=',null)
            ->get();
        }
        elseif ($this->roles == 'ADMIN') {
            $rekapsalaries = 
            DB::table('rekap_salaries')
            ->join('employees', 'employees.nik_karyawan', '=', 'rekap_salaries.employees_id')
            ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            ->join('areas', 'areas.id', '=', 'employees.areas_id')
            ->join('golongans', 'golongans.id', '=', 'employees.golongans_id')
            ->join('positions', 'positions.id', '=', 'employees.positions_id')
            ->where('periode_awal','=', $this->awal)
            ->where('rekap_salaries.deleted_at','=',null)
            ->get();
        }
        else{

        }

        return $rekapsalaries ;
    }

    public function map($rekapsalaries): array
    {    
        $items = [];
        foreach($rekapsalaries as $item){
            array_push($items);
        }

        //Menambahkan ' di depan huruf agar ketika di export excell tidak berantakan
        $periode_awal               = $rekapsalaries->periode_awal;
        $periode_akhir              = $rekapsalaries->periode_akhir;
        $nik_karyawan               = "'".$rekapsalaries->nik_karyawan;
        $nama_karyawan              = $rekapsalaries->nama_karyawan;
        $area                       = $rekapsalaries->area;
        $jabatan                    = $rekapsalaries->jabatan;
        $penempatan                 = $rekapsalaries->penempatan;
        $gaji_pokok                 = $rekapsalaries->gaji_pokok;
        $uang_makan                 = $rekapsalaries->uang_makan;
        $uang_transport             = $rekapsalaries->uang_transport;
        $tunjangan_tugas            = $rekapsalaries->tunjangan_tugas;
        $tunjangan_pulsa            = $rekapsalaries->tunjangan_pulsa;
        $tunjangan_jabatan          = $rekapsalaries->tunjangan_jabatan;
        $jumlah_upah                = $rekapsalaries->jumlah_upah;
        $upah_lembur_perjam         = $rekapsalaries->upah_lembur_perjam;
        $potongan_bpjsks_perusahaan = $rekapsalaries->potongan_bpjsks_perusahaan;
        $potongan_jht_perusahaan    = $rekapsalaries->potongan_jht_perusahaan;
        $potongan_jp_perusahaan     = $rekapsalaries->potongan_jp_perusahaan;
        $potongan_jkm_perusahaan    = $rekapsalaries->potongan_jkm_perusahaan;
        $potongan_jkk_perusahaan    = $rekapsalaries->potongan_jkk_perusahaan;
        $jumlah_bpjstk_perusahaan   = $rekapsalaries->jumlah_bpjstk_perusahaan;
        $potongan_bpjsks_karyawan   = $rekapsalaries->potongan_bpjsks_karyawan;
        $potongan_jht_karyawan      = $rekapsalaries->potongan_jht_karyawan;
        $potongan_jp_karyawan       = $rekapsalaries->potongan_jp_karyawan;
        $jumlah_bpjstk_karyawan     = $rekapsalaries->jumlah_bpjstk_karyawan;
        $take_home_pay              = $rekapsalaries->take_home_pay;
        //Menambahkan ' di depan huruf agar ketika di export excell tidak berantakan
        
        return [
            [
                $periode_awal,
                $periode_akhir,
                $nik_karyawan,
                $nama_karyawan,
                $area,
                $jabatan,
                $penempatan,
                $gaji_pokok,
                $uang_makan,
                $uang_transport,
                $tunjangan_tugas,
                $tunjangan_pulsa,
                $tunjangan_jabatan,
                $jumlah_upah,
                $upah_lembur_perjam,
                $potongan_bpjsks_perusahaan,
                $potongan_jht_perusahaan,
                $potongan_jp_perusahaan,
                $potongan_jkm_perusahaan,
                $potongan_jkk_perusahaan,
                $jumlah_bpjstk_perusahaan,
                $potongan_bpjsks_karyawan,
                $potongan_jht_karyawan,
                $potongan_jp_karyawan,
                $jumlah_bpjstk_karyawan,
                $take_home_pay
            ],

        ];

    }

    //Pengaturan Heading/JUDUL Excell
    public function headings(): array
    {
        return [
            'Periode Awal',
            'Periode Akhir',
            'NIK',
            'Nama Karyawan',
            'Area',
            'Jabatan',
            'Penempatan',
            'Gaji Pokok',
            'Uang Makan',
            'Uang Transport',
            'Tunjangan Tugas',
            'Tunjangan Pulsa',
            'Tunjangan Jabatan',
            'Jumlah Upah',
            'Upah Lembur Perjam',
            'Pot.BPJSKS Perusahaan',
            'Pot.JHT Perusahaan',
            'Pot.JP Perusahaan',
            'Pot.JKM Perusahaan',
            'Pot.JKK Perusahaan',
            'Jumlah BPJSTK Perusahaan',
            'Pot.BPJSKS Karyawan',
            'Pot.JHT Karyawan',
            'Pot.JP Karyawan',
            'Jumlah BPJSTK Karyawan',
            'Take Home Pay'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('1')->getFont()->setSize(14);

                $event->sheet->getDelegate()->getStyle('A1:Z1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A1:Z1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('228B22');

                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(17);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(17);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(35);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(28);
                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('R')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('S')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('T')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('U')->setWidth(32);
                $event->sheet->getDelegate()->getColumnDimension('V')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('W')->setWidth(22);
                $event->sheet->getDelegate()->getColumnDimension('X')->setWidth(22);
                $event->sheet->getDelegate()->getColumnDimension('Y')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('Z')->setWidth(20);
               

                
     
            },
        ];
    }
}
