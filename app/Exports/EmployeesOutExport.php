<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Admin\Employees;
use App\Models\Admin\EmployeesOuts;
use App\Models\Admin\Companies;
use App\Models\Admin\HistoryFamilies;
use App\Models\Admin\Areas;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class EmployeesOutExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $employeesouts = EmployeesOuts::with([
            'companies',
            'areas',
            'divisions',
            'positions'
            ])->orderBy('divisions_id')->orderBy('nama_karyawan_keluar')->get();

        return $employeesouts ;
    }

    public function map($employeesouts): array
    {
        
        $items = [];
        foreach($employeesouts as $item){
            array_push($items);
        }

        //Menambahkan ' di depan huruf agar ketika di export tidak berantakan
        $employees_id                           = "'".$employeesouts->employees_id;
        $nomor_kartu_keluarga_karyawan_keluar   = "'".$employeesouts->nomor_kartu_keluarga_karyawan_keluar;
        $nomor_bpjskesehatan_karyawan_keluar    = "'".$employeesouts->nomor_bpjskesehatan_karyawan_keluar;
        $nomor_bpjsketenagakerjaan_karyawan_keluar  = "'".$employeesouts->nomor_bpjsketenagakerjaan_karyawan_keluar;
        $rt_karyawan_keluar                     = "'".$employeesouts->rt_karyawan_keluar;
        $rw_karyawan_keluar                     = "'".$employeesouts->rw_karyawan_keluar;
        $nomor_npwp_karyawan_keluar             = "'".$employeesouts->nomor_npwp_karyawan_keluar;
        $nomor_rekening_karyawan_keluar         = "'".$employeesouts->nomor_rekening_karyawan_keluar;
        $nomor_handphone_karyawan_keluar        = "'".$employeesouts->nomor_handphone_karyawan_keluar;
        $nomor_absen_karyawan_keluar            = "'".$employeesouts->nomor_absen_karyawan_keluar;
        //Menambahkan ' di depan huruf agar ketika di export tidak berantakan

        return [
            [
                $employeesouts->companies->nama_perusahaan,
                $employeesouts->areas->area,
                $employeesouts->divisions->penempatan,
                $employeesouts->positions->jabatan,
                $employees_id,
                $employeesouts->nama_karyawan_keluar,
                $nomor_npwp_karyawan_keluar,
                $nomor_handphone_karyawan_keluar,
                $employeesouts->email_karyawan_keluar,
                $employeesouts->tempat_lahir_karyawan_keluar,
                \Carbon\Carbon::parse($employeesouts->tanggal_lahir_karyawan_keluar)->isoformat('DD-MM-Y'),
                $employeesouts->jenis_kelamin_karyawan_keluar,
                $employeesouts->pendidikan_terakhir_karyawan_keluar,
                $employeesouts->agama_karyawan_keluar,
                $employeesouts->golongan_darah_karyawan_keluar,
                $nomor_rekening_karyawan_keluar,
                $nomor_bpjsketenagakerjaan_karyawan_keluar,
                $nomor_bpjskesehatan_karyawan_keluar,
                $nomor_absen_karyawan_keluar,
                $nomor_kartu_keluarga_karyawan_keluar,
                $employeesouts->status_nikah_karyawan_keluar,
                $employeesouts->nama_ayah_karyawan_keluar,
                $employeesouts->nama_ibu_karyawan_keluar,
                $employeesouts->status_kerja_karyawan_keluar,
                \Carbon\Carbon::parse($employeesouts->tanggal_masuk_karyawan_keluar)->isoformat('DD-MM-Y'),
                \Carbon\Carbon::parse($employeesouts->tanggal_keluar_karyawan_keluar)->isoformat('DD-MM-Y'),
                $employeesouts->keterangan_keluar,
                $employeesouts->alamat_karyawan_keluar,
                $employeesouts->rt_karyawan_keluar,
                $employeesouts->rw_karyawan_keluar,
                $employeesouts->kelurahan_karyawan_keluar,
                $employeesouts->kecamatan_karyawan_keluar,
                $employeesouts->kota_karyawan_keluar,
                $employeesouts->provinsi_karyawan_keluar,
                $employeesouts->kode_pos_karyawan_keluar,
                $items
            ],

        ];

    }
    
    //Heading/JUDUL Excell
    public function headings(): array
    {
        return [
            'Perusahaan',
            'Area',
            'Divisi',
            'Jabatan',
            'NIK Karyawan',
            'Nama Karyawan',
            'Nomor NPWP',
            'Nomor Handphone',
            'Email',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Pendidikan Terakhir',
            'Agama',
            'Golongan Darah',
            'Nomor Rekening',
            'Nomor JHT',
            'Nomor JKN',
            'Nomor Absen',
            'Nomor KK',
            'Status Nikah',
            'Nama Ayah',
            'Nama Ibu',
            'Status Kerja',
            'Tanggal Masuk',
            'Tanggal Keluar',
            'Keterangan Keluar',
            'Alamat',
            'RT',
            'RW',
            'Kelurahan',
            'Kecamatan',
            'Kabupaten/Kota',
            'Provinsi',
            'Kode POS'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('1')->getFont()->setSize(14);

                $event->sheet->getDelegate()->getStyle('A1:AI1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A1:AI1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('228B22');

                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('R')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('S')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('T')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('U')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('V')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('W')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('X')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('Y')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('Z')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AA')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('AB')->setWidth(45);
                $event->sheet->getDelegate()->getColumnDimension('AC')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('AC')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('AD')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('AE')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AF')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AG')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AH')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AI')->setWidth(15);

                
     
            },
        ];
    }
}
