<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Admin\Employees;
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

class EmployeesExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $employees = Employees::with([
            'companies',
            'golongans',
            'areas',
            'divisions',
            'positions'
            ])->orderBy('divisions_id')->get();
        return $employees ;
    }
    public function map($employees): array
    {    
        $items = [];
        foreach($employees as $item){
            array_push($items);

            //Rumus Mengambil status PTKP (tk,k/0,k1,k/2,k3)
            $hitungkeluarga = HistoryFamilies::with([
                'employees'
                ])->where('employees_id', $employees->nik_karyawan)->count();
            if ($hitungkeluarga == null) {
                $jumlahkeluarga = 0;
            }
            else{
                $jumlahkeluarga = $hitungkeluarga-1;
            }

            if ($employees->status_nikah == "Single") {
                $statuspajak = "tk/";
            }
            else{
                $statuspajak = "k/";
            }
            $statusptkp = $statuspajak.$jumlahkeluarga;
            //Rumus Mengambil status PTKP (tk,k/0,k1,k/2,k3)

        }

        //Menambahkan ' di depan huruf agar ketika di export excell tidak berantakan
        $nik_karyawan           = "'".$employees->nik_karyawan;
        $nomor_kartu_keluarga   = "'".$employees->nomor_kartu_keluarga;
        $nomor_bpjskesehatan    = "'".$employees->nomor_bpjskesehatan;
        $nomor_bpjsketenagakerjaan  = "'".$employees->nomor_bpjsketenagakerjaan;
        $rt                     = "'".$employees->rt;
        $rw                     = "'".$employees->rw;
        $nomor_npwp             = "'".$employees->nomor_npwp;
        $nomor_rekening         = "'".$employees->nomor_rekening;
        $nomor_handphone        = "'".$employees->nomor_handphone;
        $nomor_absen            = "'".$employees->nomor_absen;
        //Menambahkan ' di depan huruf agar ketika di export excell tidak berantakan

        //Status jika Karyawan Tetap Maka Tanggal Akhir Kerja = PKWTT
        $tanggal_akhir_kerja = $employees->tanggal_akhir_kerja;
        if ($employees->status_kerja == "PKWTT") {
            $tanggalakhirkerja = "PKWTT";
        } else {
            $tanggalakhirkerja = \Carbon\Carbon::parse($tanggal_akhir_kerja)->isoformat('DD-MM-Y');
        }
        //Status jika Karyawan Tetap Maka Tanggal Akhir Kerja = PKWTT
        
        return [
            [
                $statusptkp,
                $employees->golongans->golongan,
                $employees->companies->nama_perusahaan,
                $employees->areas->area,
                $employees->divisions->penempatan,
                $employees->positions->jabatan,
                $nik_karyawan,
                $employees->nama_karyawan,
                $employees->email_karyawan,
                $nomor_handphone,
                $nomor_absen,
                $nomor_npwp,
                $employees->tempat_lahir,
                \Carbon\Carbon::parse($employees->tanggal_lahir)->isoformat('DD-MM-Y'),
                $employees->agama,
                $employees->jenis_kelamin,
                $employees->pendidikan_terakhir,
                $employees->golongan_darah,
                $employees->status_kerja,
                \Carbon\Carbon::parse($employees->tanggal_mulai_kerja)->isoformat('DD-MM-Y'),
                $tanggalakhirkerja,
                $nomor_rekening,
                $nomor_kartu_keluarga,
                $employees->status_nikah,
                $employees->nama_ayah,
                $employees->nama_ibu,
                $nomor_bpjskesehatan,
                $nomor_bpjsketenagakerjaan,
                $employees->alamat,
                $employees->rt,
                $employees->rw,
                $employees->kelurahan,
                $employees->kecamatan,
                $employees->kota,
                $employees->provinsi,
                $employees->kode_pos,
                $items
            ],

        ];

    }

    //Pengaturan Heading/JUDUL Excell
    public function headings(): array
    {
        return [
            'Status PTKP',
            'Golongan',
            'Perusahaan',
            'Area',
            'Penempatan',
            'Jabatan',
            'NIK Karyawan',
            'Nama Karyawan',
            'Email',
            'No Handphone',
            'No Absen',
            'No NPWP',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'Jenis Kelamin',
            'Pendidikan Terakhir',
            'Golongan Darah',
            'Status Kerja',
            'Tanggal Mulai Kerja',
            'Tanggal Akhir Kerja',
            'No Rekening',
            'Nomor KK',
            'Status Nikah',
            'Nama Ayah',
            'Nama Ibu',
            'No JKN',
            'No JHT',
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

                $event->sheet->getDelegate()->getStyle('A1:AJ1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A1:AJ1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('228B22');

                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(14);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(17);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(17);
                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('R')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('S')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('T')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('U')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('V')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('W')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('X')->setWidth(16);
                $event->sheet->getDelegate()->getColumnDimension('Y')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('Z')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AA')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('AB')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('AC')->setWidth(45);
                $event->sheet->getDelegate()->getColumnDimension('AC')->setWidth(45);
                $event->sheet->getDelegate()->getColumnDimension('AD')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('AE')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('AF')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AG')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AH')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AI')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AJ')->setWidth(15);

                
     
            },
        ];
    }
}
