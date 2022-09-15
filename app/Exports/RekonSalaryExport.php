<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Admin\HistorySalaries;
use App\Models\Admin\Employees;
use App\Models\Admin\Areas;
use App\Models\Admin\Divisions;
use App\Models\Admin\Golongans;
use App\Models\Admin\Positions;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class RekonSalaryExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $rekonsalaries = 
        DB::table('history_salaries')
        ->join('employees', 'employees.nik_karyawan', '=', 'history_salaries.employees_id')
        ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
        ->join('golongans', 'golongans.id', '=', 'employees.golongans_id')
        ->join('areas', 'areas.id', '=', 'employees.areas_id')
        ->join('positions', 'positions.id', '=', 'employees.positions_id')
        ->where('history_salaries.deleted_at','=',null)
        ->get();
        return $rekonsalaries ;
    }

    public function map($rekonsalaries): array
    {    
        $items = [];
        foreach($rekonsalaries as $item){
            array_push($items);
        }

        //Menambahkan ' di depan huruf agar ketika di export excell tidak berantakan
        $nik_karyawan               = "'".$rekonsalaries->nik_karyawan;
        $nama_karyawan              = $rekonsalaries->nama_karyawan;
        $golongan                   = $rekonsalaries->golongan;
        $area                       = $rekonsalaries->area;
        $jabatan                    = $rekonsalaries->jabatan;
        $penempatan                 = $rekonsalaries->penempatan;
        $gaji_pokok                 = $rekonsalaries->gaji_pokok;
        $uang_makan                 = $rekonsalaries->uang_makan;
        $uang_transport             = $rekonsalaries->uang_transport;
        $tunjangan_tugas            = $rekonsalaries->tunjangan_tugas;
        $tunjangan_pulsa            = $rekonsalaries->tunjangan_pulsa;
        $tunjangan_jabatan          = $rekonsalaries->tunjangan_jabatan;
        $jumlah_upah                = $rekonsalaries->jumlah_upah;
        $upah_lembur_perjam         = $rekonsalaries->upah_lembur_perjam;
        $potongan_bpjsks_perusahaan = $rekonsalaries->potongan_bpjsks_perusahaan;
        $potongan_jht_perusahaan    = $rekonsalaries->potongan_jht_perusahaan;
        $potongan_jp_perusahaan     = $rekonsalaries->potongan_jp_perusahaan;
        $potongan_jkm_perusahaan    = $rekonsalaries->potongan_jkm_perusahaan;
        $potongan_jkk_perusahaan    = $rekonsalaries->potongan_jkk_perusahaan;
        $jumlah_bpjstk_perusahaan   = $rekonsalaries->jumlah_bpjstk_perusahaan;
        $potongan_bpjsks_karyawan   = $rekonsalaries->potongan_bpjsks_karyawan;
        $potongan_jht_karyawan      = $rekonsalaries->potongan_jht_karyawan;
        $potongan_jp_karyawan       = $rekonsalaries->potongan_jp_karyawan;
        $jumlah_bpjstk_karyawan     = $rekonsalaries->jumlah_bpjstk_karyawan;
        $take_home_pay              = $rekonsalaries->take_home_pay;
        //Menambahkan ' di depan huruf agar ketika di export excell tidak berantakan
        
        return [
            [
                $nik_karyawan,
                $nama_karyawan,
                $golongan,
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
            'NIK',
            'Nama Karyawan',
            'Golongan',
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

                $event->sheet->getDelegate()->getStyle('A1:Y1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A1:Y1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('228B22');

                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(35);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(28);
                $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('R')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('S')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('T')->setWidth(32);
                $event->sheet->getDelegate()->getColumnDimension('U')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('V')->setWidth(22);
                $event->sheet->getDelegate()->getColumnDimension('W')->setWidth(22);
                $event->sheet->getDelegate()->getColumnDimension('X')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('Y')->setWidth(20);
               

                
     
            },
        ];
    }
}
