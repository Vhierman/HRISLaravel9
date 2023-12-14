<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Employees;
use App\Models\Admin\Companies;
use App\Models\Admin\Areas;
use App\Models\Admin\Golongans;
use App\Models\User;
use App\Models\Admin\Divisions;
use App\Models\Admin\Positions;
use App\Models\Admin\Overtimes;
use App\Models\Admin\Attendances;
use App\Models\Admin\HistorySalaries;
use App\Models\Admin\RekapSalaries;
use App\Http\Requests\Employees\OvertimeRequest;
use App\Http\Requests\Employees\FotoKaryawanRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Admin\HistoryContracts;
use App\Models\Admin\HistoryTrainingInternals;
use App\Models\Admin\HistoryTrainingEksternals;
use App\Models\Admin\HistoryFamilies;
use Carbon\Carbon;
use File;
use Storage;
use Codedge\Fpdf\Fpdf\Fpdf;
use DB;
use Alert;
use Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(){
        Auth::logout();
        return redirect('/'); // ini untuk redirect setelah logout
    }

    public function training_internal()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER' && auth()->user()->roles != 'KARYAWAN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        $nik_karyawan   = auth()->user()->nik;

        
        //History Training Internal
        $items = HistoryTrainingInternals::with([
            'employees'
            ])->where('employees_id', $nik_karyawan)->get();
            
        return view ('pages.employees.training_internal.index',[
            'items'  => $items
        ]);
    }

    public function training_eksternal()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER' && auth()->user()->roles != 'KARYAWAN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        $nik_karyawan   = auth()->user()->nik;

        
        //History Training Eksternals
        $items = HistoryTrainingEksternals::with([
            'employees'
            ])->where('employees_id', $nik_karyawan)->get();
            
        return view ('pages.employees.training_eksternal.index',[
            'items'  => $items
        ]);
    }

    public function index(Request $request)
    {
        //
        toast('Hello ' . auth()->user()->name, 'success');
        $nik_karyawan = auth()->user()->nik;
        //

        $nik            = auth()->user()->nik;
        $caridivisi     = Employees::all()->where('nik_karyawan', $nik)->first();
        $divisi         = $caridivisi->divisions_id;

        //Halaman Karyawan
        $datakaryawan = Employees::with([
            'companies',
            'areas',
            'divisions',
            'positions'
        ])->where('nik_karyawan', $nik_karyawan)->first();

        foreach($datakaryawan as $item){
        

            //Rumus Mengambil status PTKP (tk,k/0,k1,k/2,k3)
            $hitungkeluarga = HistoryFamilies::with([
                'employees'
                ])->where('employees_id', $datakaryawan->nik_karyawan)->count();

            if ($hitungkeluarga == null) {
                $jumlahkeluarga = 0;
            }
            else{
                $jumlahkeluarga = $hitungkeluarga-1;
            }

            if ($datakaryawan->status_nikah == "Single") {
                $statuspajak = "tk/";
            }
            else{
                $statuspajak = "k/";
            }
            $statusptkp = $statuspajak.$jumlahkeluarga;
            //Rumus Mengambil status PTKP (tk,k/0,k1,k/2,k3)

        }

        $datahistorykontraks = HistoryContracts::with([
            'employees'
        ])->where('employees_id', $nik_karyawan)->get();
        $datahistorykeluargas = HistoryFamilies::with([
            'employees'
        ])->where('employees_id', $nik_karyawan)->get();
        $historykontrak = HistoryContracts::with([
            'employees'
        ])->where('employees_id', $nik_karyawan)->first();
        $historykeluarga = HistoryFamilies::with([
            'employees'
        ])->where('employees_id', $nik_karyawan)->first();
        //Halaman Karyawan

        //Halaman Admin HRD Accounting
        //Jumlah Karyawan
        $itembsd = Employees::with([
            'areas'
        ])->where('areas_id', 2)->count();
        $itemaw = Employees::with([
            'areas'
        ])->whereIn('areas_id', [1,7])->count();
        $itemsunter = Employees::with([
            'areas'
        ])->where('areas_id', 3)->count();
        $itemcibinong = Employees::with([
            'areas'
        ])->where('areas_id', 4)->count();
        $itemcibitung = Employees::with([
            'areas'
        ])->where('areas_id', 5)->count();
        $itemkarawangtimur = Employees::with([
            'areas'
        ])->where('areas_id', 6)->count();
        $itembl = Employees::with([
            'areas'
        ])->where('areas_id', 7)->count();
        $itempdc = $itemsunter + $itemcibinong + $itemcibitung + $itemkarawangtimur;
        $itemall = $itembsd + $itempdc + $itemaw ;
        //Jumlah Karyawan
        // Chart Penempatan
        $itemaccounting = Employees::with([
            'divisions'
        ])->where('divisions_id', 1)->count();
        $itemic = Employees::with([
            'divisions'
        ])->where('divisions_id', 2)->count();
        $itemit = Employees::with([
            'divisions'
        ])->where('divisions_id', 3)->count();
        $itemhrd = Employees::with([
            'divisions'
        ])->where('divisions_id', 4)->count();
        $itemdoccontrol = Employees::with([
            'divisions'
        ])->where('divisions_id', 5)->count();
        $itemmarketing = Employees::with([
            'divisions'
        ])->where('divisions_id', 6)->count();
        $itemengineering = Employees::with([
            'divisions'
        ])->where('divisions_id', 7)->count();
        $itemquality = Employees::with([
            'divisions'
        ])->where('divisions_id', 8)->count();
        $itempurchasing = Employees::with([
            'divisions'
        ])->where('divisions_id', 9)->count();
        $itemppc = Employees::with([
            'divisions'
        ])->where('divisions_id', 10)->count();
        $itemproduksi = Employees::with([
            'divisions'
        ])->where('divisions_id', 11)->count();
        $itemdeliveryproduksi = Employees::with([
            'divisions'
        ])->where('divisions_id', 12)->count();
        $itemgudangrm = Employees::with([
            'divisions'
        ])->where('divisions_id', 13)->count();
        $itemgudangfg = Employees::with([
            'divisions'
        ])->where('divisions_id', 14)->count();
        $itemdelivery = Employees::with([
            'divisions'
        ])->where('divisions_id', 15)->count();
        $itemsecurity = Employees::with([
            'divisions'
        ])->where('divisions_id', 16)->count();
        $itemblokbl = Employees::with([
            'divisions'
        ])->where('divisions_id', 17)->count();
        $itembloke = Employees::with([
            'divisions'
        ])->where('divisions_id', 18)->count();
        $itempdcdaihatsusunter = Employees::with([
            'divisions'
        ])->where('divisions_id', 19)->count();
        $itempdcdaihatsucibinong = Employees::with([
            'divisions'
        ])->where('divisions_id', 20)->count();
        $itempdcdaihatsucibitung = Employees::with([
            'divisions'
        ])->where('divisions_id', 21)->count();
        $itempdcdaihatsukarawangtimur = Employees::with([
            'divisions'
        ])->where('divisions_id', 22)->count();
        $itemjumlahgreenville   = $itemaccounting + $itembl + $itemic + $itemit;
        $itemjumlahhrd          = $itemhrd + $itemsecurity;
        $itemjumlahppc          = $itemppc + $itemdelivery + $itemdeliveryproduksi + $itembloke + $itemgudangrm + $itemgudangfg;
        $itemjumlahproduksi     = $itemproduksi + $itempdcdaihatsusunter + $itempdcdaihatsucibinong + $itempdcdaihatsucibitung + $itempdcdaihatsukarawangtimur;
        // Chart Penempatan

        // Chart Status Kontrak
        $itemkontrak = Employees::all()
            ->where('status_kerja', 'PKWT')
            ->count();
        $itemtetap = Employees::all()
            ->where('status_kerja', 'PKWTT')
            ->count();
        $itemharian = Employees::all()
            ->where('status_kerja', 'Harian')
            ->count();
        $itemoutsourcing = Employees::all()
            ->where('status_kerja', 'Outsourcing')
            ->count();
        // Chart Status Kontrak

        // Chart Status Kontrak Produksi
        $itemkontrakproduksi = Employees::all()
            ->where('status_kerja', 'PKWT')->where('divisions_id', 11)
            ->count();
        $itemtetapproduksi = Employees::all()
            ->where('status_kerja', 'PKWTT')->where('divisions_id', 11)
            ->count();
        $itemharianproduksi = Employees::all()
            ->where('status_kerja', 'Harian')->where('divisions_id', 11)
            ->count();
        // Chart Status Kontrak Produksi


        // Chart Status Kontrak PDC
        $itemkontrakpdc = Employees::all()
            ->where('status_kerja', 'PKWT')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        $itemtetappdc = Employees::all()
            ->where('status_kerja', 'PKWTT')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        $itemharianpdc = Employees::all()
            ->where('status_kerja', 'Harian')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        // Chart Status Kontrak PDC

        // Chart Status Menikah
        $itemsingle = Employees::all()
            ->where('status_nikah', 'Single')
            ->count();
        $itemmenikah = Employees::all()
            ->where('status_nikah', 'Menikah')
            ->count();
        $itemjanda = Employees::all()
            ->where('status_nikah', 'Janda')
            ->count();
        $itemduda = Employees::all()
            ->where('status_nikah', 'Duda')
            ->count();
        // Chart Status Menikah

        // Chart Status Menikah Produksi
        $itemsingleproduksi = Employees::all()
            ->where('status_nikah', 'Single')->where('divisions_id', 11)
            ->count();
        $itemmenikahproduksi = Employees::all()
            ->where('status_nikah', 'Menikah')->where('divisions_id', 11)
            ->count();
        $itemjandaproduksi = Employees::all()
            ->where('status_nikah', 'Janda')->where('divisions_id', 11)
            ->count();
        $itemdudaproduksi = Employees::all()
            ->where('status_nikah', 'Duda')->where('divisions_id', 11)
            ->count();
        // Chart Status Menikah Produksi

        // Chart Status Menikah PDC
        $itemsinglepdc = Employees::all()
            ->where('status_nikah', 'Single')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        $itemmenikahpdc = Employees::all()
            ->where('status_nikah', 'Menikah')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        $itemjandapdc = Employees::all()
            ->where('status_nikah', 'Janda')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        $itemdudapdc = Employees::all()
            ->where('status_nikah', 'Duda')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        // Chart Status Menikah PDC


        // Chart Jenis Kelamin
        $itempria = Employees::all()
            ->where('jenis_kelamin', 'Pria')
            ->count();
        $itemwanita = Employees::all()
            ->where('jenis_kelamin', 'Wanita')
            ->count();
        // Chart Jenis Kelamin


        // Chart Jenis Kelamin Produksi
        $itempriaproduksi = Employees::all()
            ->where('jenis_kelamin', 'Pria')->where('divisions_id', 11)
            ->count();
        $itemwanitaproduksi = Employees::all()
            ->where('jenis_kelamin', 'Wanita')->where('divisions_id', 11)
            ->count();
        // Chart Jenis Kelamin Produksi 

        // Chart Jenis Kelamin PDC
        $itempriapdc = Employees::all()
            ->where('jenis_kelamin', 'Pria')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        $itemwanitapdc = Employees::all()
            ->where('jenis_kelamin', 'Wanita')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        // Chart Jenis Kelamin PDC

        // Chart Agama
        $itemislam = Employees::all()
            ->where('agama', 'Islam')
            ->count();
        $itemkristenprotestan = Employees::all()
            ->where('agama', 'Kristen Protestan')
            ->count();
        $itemkristenkatholik = Employees::all()
            ->where('agama', 'Kristen Katholik')
            ->count();
        $itemhindu = Employees::all()
            ->where('agama', 'Hindu')
            ->count();
        $itembudha = Employees::all()
            ->where('agama', 'Budha')
            ->count();
        // Chart Agama


        // Chart Agama Produksi
        $itemislamproduksi = Employees::all()
            ->where('agama', 'Islam')->where('divisions_id', 11)
            ->count();
        $itemkristenprotestanproduksi = Employees::all()
            ->where('agama', 'Kristen Protestan')->where('divisions_id', 11)
            ->count();
        $itemkristenkatholikproduksi = Employees::all()
            ->where('agama', 'Kristen Katholik')->where('divisions_id', 11)
            ->count();
        $itemhinduproduksi = Employees::all()
            ->where('agama', 'Hindu')->where('divisions_id', 11)
            ->count();
        $itembudhaproduksi = Employees::all()
            ->where('agama', 'Budha')->where('divisions_id', 11)
            ->count();
        // Chart Agama Produksi

        // Chart Agama PDC
        $itemislampdc = Employees::all()
            ->where('agama', 'Islam')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        $itemkristenprotestanpdc = Employees::all()
            ->where('agama', 'Kristen Protestan')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        $itemkristenkatholikpdc = Employees::all()
            ->where('agama', 'Kristen Katholik')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        $itemhindupdc = Employees::all()
            ->where('agama', 'Hindu')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        $itembudhapdc = Employees::all()
            ->where('agama', 'Budha')->whereIn('divisions_id', [19,20,21,22])
            ->count();
        // Chart Agama PDC



        //  Chart Penempatan Detail
        $itemaccountingpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 1)->where('status_kerja', 'PKWTT')->count();
        $itemaccountingpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 1)->where('status_kerja', 'PKWT')->count();
        $itemaccountingharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 1)->where('status_kerja', 'Harian')->count();
        $itemaccountingoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 1)->where('status_kerja', 'Outsourcing')->count();
        $itemicpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 2)->where('status_kerja', 'PKWTT')->count();
        $itemicpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 2)->where('status_kerja', 'PKWT')->count();
        $itemicharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 2)->where('status_kerja', 'Harian')->count();
        $itemicoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 2)->where('status_kerja', 'Outsourcing')->count();
        $itemitpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 3)->where('status_kerja', 'PKWTT')->count();
        $itemitpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 3)->where('status_kerja', 'PKWT')->count();
        $itemitharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 3)->where('status_kerja', 'Harian')->count();
        $itemitoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 3)->where('status_kerja', 'Outsourcing')->count();
        $itemhrdpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 4)->where('status_kerja', 'PKWTT')->count();
        $itemhrdpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 4)->where('status_kerja', 'PKWT')->count();
        $itemhrdharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 4)->where('status_kerja', 'Harian')->count();
        $itemhrdoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 4)->where('status_kerja', 'Outsourcing')->count();
        $itemdoccontrolpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 5)->where('status_kerja', 'PKWTT')->count();
        $itemdoccontrolpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 5)->where('status_kerja', 'PKWT')->count();
        $itemdoccontrolharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 5)->where('status_kerja', 'Harian')->count();
        $itemdoccontroloutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 5)->where('status_kerja', 'Outsourcing')->count();

        $itemmarketingpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 6)->where('status_kerja', 'PKWTT')->count();
        $itemmarketingpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 6)->where('status_kerja', 'PKWT')->count();
        $itemmarketingharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 6)->where('status_kerja', 'Harian')->count();
        $itemmarketingoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 6)->where('status_kerja', 'Outsourcing')->count();
        $itemengineeringpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 7)->where('status_kerja', 'PKWTT')->count();
        $itemengineeringpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 7)->where('status_kerja', 'PKWT')->count();
        $itemengineeringharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 7)->where('status_kerja', 'Harian')->count();
        $itemengineeringoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 7)->where('status_kerja', 'Outsourcing')->count();
        $itemqualitypkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 8)->where('status_kerja', 'PKWTT')->count();
        $itemqualitypkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 8)->where('status_kerja', 'PKWT')->count();
        $itemqualityharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 8)->where('status_kerja', 'Harian')->count();
        $itemqualityoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 8)->where('status_kerja', 'Outsourcing')->count();
        $itempurchasingpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 9)->where('status_kerja', 'PKWTT')->count();
        $itempurchasingpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 9)->where('status_kerja', 'PKWT')->count();
        $itempurchasingharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 9)->where('status_kerja', 'Harian')->count();
        $itempurchasingoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 9)->where('status_kerja', 'Outsourcing')->count();
        $itemppcpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 10)->where('status_kerja', 'PKWTT')->count();
        $itemppcpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 10)->where('status_kerja', 'PKWT')->count();
        $itemppcharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 10)->where('status_kerja', 'Harian')->count();
        $itemppcoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 10)->where('status_kerja', 'Outsourcing')->count();
        $itemproduksipkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 11)->where('status_kerja', 'PKWTT')->count();
        $itemproduksipkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 11)->where('status_kerja', 'PKWT')->count();
        $itemproduksiharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 11)->where('status_kerja', 'Harian')->count();
        $itemproduksioutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 11)->where('status_kerja', 'Outsourcing')->count();
        $itemdeliveryproduksipkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 12)->where('status_kerja', 'PKWTT')->count();
        $itemdeliveryproduksipkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 12)->where('status_kerja', 'PKWT')->count();
        $itemdeliveryproduksiharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 12)->where('status_kerja', 'Harian')->count();
        $itemdeliveryproduksioutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 12)->where('status_kerja', 'Outsourcing')->count();
        //
        $itemgudangrmpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 13)->where('status_kerja', 'PKWTT')->count();
        $itemgudangrmpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 13)->where('status_kerja', 'PKWT')->count();
        $itemgudangrmharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 13)->where('status_kerja', 'Harian')->count();
        $itemgudangrmoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 13)->where('status_kerja', 'Outsourcing')->count();
        //
        $itemgudangfgpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 14)->where('status_kerja', 'PKWTT')->count();
        $itemgudangfgpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 14)->where('status_kerja', 'PKWT')->count();
        $itemgudangfgharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 14)->where('status_kerja', 'Harian')->count();
        $itemgudangfgoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 14)->where('status_kerja', 'Outsourcing')->count();
        //
        $itemdeliverypkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 15)->where('status_kerja', 'PKWTT')->count();
        $itemdeliverypkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 15)->where('status_kerja', 'PKWT')->count();
        $itemdeliveryharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 15)->where('status_kerja', 'Harian')->count();
        $itemdeliveryoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 15)->where('status_kerja', 'Outsourcing')->count();
        //
        $itemsecuritypkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 16)->where('status_kerja', 'PKWTT')->count();
        $itemsecuritypkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 16)->where('status_kerja', 'PKWT')->count();
        $itemsecurityharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 16)->where('status_kerja', 'Harian')->count();
        $itemsecurityoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 16)->where('status_kerja', 'Outsourcing')->count();
        //
        $itemblokblpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 17)->where('status_kerja', 'PKWTT')->count();
        $itemblokblpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 17)->where('status_kerja', 'PKWT')->count();
        $itemblokblharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 17)->where('status_kerja', 'Harian')->count();
        $itemblokbloutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 17)->where('status_kerja', 'Outsourcing')->count();
        //
        $itemblokepkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 18)->where('status_kerja', 'PKWTT')->count();
        $itemblokepkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 18)->where('status_kerja', 'PKWT')->count();
        $itemblokeharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 18)->where('status_kerja', 'Harian')->count();
        $itemblokeoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 18)->where('status_kerja', 'Outsourcing')->count();
        //
        $itempdcdaihatsusunterpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 19)->where('status_kerja', 'PKWTT')->count();
        $itempdcdaihatsusunterpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 19)->where('status_kerja', 'PKWT')->count();
        $itempdcdaihatsusunterharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 19)->where('status_kerja', 'Harian')->count();
        $itempdcdaihatsusunteroutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 19)->where('status_kerja', 'Outsourcing')->count();
        //
        $itempdcdaihatsucibinongpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 20)->where('status_kerja', 'PKWTT')->count();
        $itempdcdaihatsucibinongpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 20)->where('status_kerja', 'PKWT')->count();
        $itempdcdaihatsucibinongharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 20)->where('status_kerja', 'Harian')->count();
        $itempdcdaihatsucibinongoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 20)->where('status_kerja', 'Outsourcing')->count();
        //
        $itempdcdaihatsucibitungpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 21)->where('status_kerja', 'PKWTT')->count();
        $itempdcdaihatsucibitungpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 21)->where('status_kerja', 'PKWT')->count();
        $itempdcdaihatsucibitungharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 21)->where('status_kerja', 'Harian')->count();
        $itempdcdaihatsucibitungoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 21)->where('status_kerja', 'Outsourcing')->count();
        //
        $itempdcdaihatsukarawangtimurpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 22)->where('status_kerja', 'PKWTT')->count();
        $itempdcdaihatsukarawangtimurpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 22)->where('status_kerja', 'PKWT')->count();
        $itempdcdaihatsukarawangtimurharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 22)->where('status_kerja', 'Harian')->count();
        $itempdcdaihatsukarawangtimuroutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 22)->where('status_kerja', 'Outsourcing')->count();
        // Chart  Penempatan Detail
        //Halaman Admin HRD Accounting

        return view('pages.admin.dashboard',[
            //Halaman Karyawan
            'divisi'                        => $divisi,
            'datakaryawan'                  => $datakaryawan,
            'statusptkp'                    => $statusptkp,
            'datahistorykontraks'           => $datahistorykontraks,
            'datahistorykeluargas'          => $datahistorykeluargas,
            'historykontrak'                => $historykontrak,
            'historykeluarga'               => $historykeluarga,
            //Halaman Karyawan
            //Halaman HRD, ADMIN, Accounting TOP
            'itempdc'                       => $itempdc,
            'itemall'                       => $itemall,
            'itemaw'                        => $itemaw,
            'itembsd'                       => $itembsd,
            'itemproduksi'                  => $itemproduksi,
            //Halaman HRD, ADMIN, Accounting TOP
            //Halaman HRD, ADMIN, Accounting 
            'itemaccounting'                => $itemaccounting,
            'itemic'                        => $itemic,
            'itemit'                        => $itemit,
            'itemhrd'                       => $itemhrd,
            'itemdoccontrol'                => $itemdoccontrol,
            'itemmarketing'                 => $itemmarketing,
            'itemengineering'               => $itemengineering,
            'itemquality'                   => $itemquality,
            'itempurchasing'                => $itempurchasing,
            'itemppc'                       => $itemppc,
            'itemproduksi'                  => $itemproduksi,
            'itemdeliveryproduksi'          => $itemdeliveryproduksi,
            'itemgudangrm'                  => $itemgudangrm,
            'itemgudangfg'                  => $itemgudangfg,
            'itemdelivery'                  => $itemdelivery,
            'itemsecurity'                  => $itemsecurity,
            'itemblokbl'                    => $itemblokbl,
            'itembloke'                     => $itembloke,
            'itempdcdaihatsusunter'         => $itempdcdaihatsusunter,
            'itempdcdaihatsucibinong'       => $itempdcdaihatsucibinong,
            'itempdcdaihatsucibitung'       => $itempdcdaihatsucibitung,
            'itempdcdaihatsukarawangtimur'  => $itempdcdaihatsukarawangtimur,
            'itemjumlahgreenville'          => $itemjumlahgreenville,
            'itemjumlahhrd'                 => $itemjumlahhrd,
            'itemjumlahppc'                 => $itemjumlahppc,
            'itemjumlahproduksi'            => $itemjumlahproduksi,

            'itemkontrak'                   => $itemkontrak,
            'itemtetap'                     => $itemtetap,
            'itemharian'                    => $itemharian,
            'itemoutsourcing'               => $itemoutsourcing,

            'itemkontrakproduksi'           => $itemkontrakproduksi,
            'itemtetapproduksi'             => $itemtetapproduksi,
            'itemharianproduksi'            => $itemharianproduksi,

            'itemkontrakpdc'                => $itemkontrakpdc,
            'itemtetappdc'                  => $itemtetappdc,
            'itemharianpdc'                 => $itemharianpdc,

            'itemsingle'                    => $itemsingle,
            'itemmenikah'                   => $itemmenikah,
            'itemjanda'                     => $itemjanda,
            'itemduda'                      => $itemduda,

            'itemsingleproduksi'            => $itemsingleproduksi,
            'itemmenikahproduksi'           => $itemmenikahproduksi,
            'itemjandaproduksi'             => $itemjandaproduksi,
            'itemdudaproduksi'              => $itemdudaproduksi,

            'itemsinglepdc'                 => $itemsinglepdc,
            'itemmenikahpdc'                => $itemmenikahpdc,
            'itemjandapdc'                  => $itemjandapdc,
            'itemdudapdc'                   => $itemdudapdc,

            'itempria'                      => $itempria,
            'itemwanita'                    => $itemwanita,

            'itempriaproduksi'              => $itempriaproduksi,
            'itemwanitaproduksi'            => $itemwanitaproduksi,

            'itempriapdc'                   => $itempriapdc,
            'itemwanitapdc'                 => $itemwanitapdc,

            'itemislam'                     => $itemislam,
            'itemkristenprotestan'          => $itemkristenprotestan,
            'itemkristenkatholik'           => $itemkristenkatholik,
            'itemhindu'                     => $itemhindu,
            'itembudha'                     => $itembudha,

            'itemislamproduksi'             => $itemislamproduksi,
            'itemkristenprotestanproduksi'  => $itemkristenprotestanproduksi,
            'itemkristenkatholikproduksi'   => $itemkristenkatholikproduksi,
            'itemhinduproduksi'             => $itemhinduproduksi,
            'itembudhaproduksi'             => $itembudhaproduksi,

            'itemislampdc'                  => $itemislampdc,
            'itemkristenprotestanpdc'       => $itemkristenprotestanpdc,
            'itemkristenkatholikpdc'        => $itemkristenkatholikpdc,
            'itemhindupdc'                  => $itemhindupdc,
            'itembudhapdc'                  => $itembudhapdc,

            'itemaccountingpkwtt'           => $itemaccountingpkwtt,
            'itemaccountingpkwt'            => $itemaccountingpkwt,
            'itemaccountingharian'          => $itemaccountingharian,
            'itemaccountingoutsourcing'     => $itemaccountingoutsourcing,
            'itemicpkwtt'                   => $itemicpkwtt,
            'itemicpkwt'                    => $itemicpkwt,
            'itemicharian'                  => $itemicharian,
            'itemicoutsourcing'             => $itemicoutsourcing,
            'itemitpkwtt'                   => $itemitpkwtt,
            'itemitpkwt'                    => $itemitpkwt,
            'itemitharian'                  => $itemitharian,
            'itemitoutsourcing'             => $itemitoutsourcing,
            'itemhrdpkwtt'                  => $itemhrdpkwtt,
            'itemhrdpkwt' => $itemhrdpkwt,
            'itemhrdharian' => $itemhrdharian,
            'itemhrdoutsourcing' => $itemhrdoutsourcing,
            'itemdoccontrolpkwtt' => $itemdoccontrolpkwtt,
            'itemdoccontrolpkwt' => $itemdoccontrolpkwt,
            'itemdoccontrolharian' => $itemdoccontrolharian,
            'itemdoccontroloutsourcing' => $itemdoccontroloutsourcing,
            'itemmarketingpkwtt' => $itemmarketingpkwtt,
            'itemmarketingpkwt' => $itemmarketingpkwt,
            'itemmarketingharian' => $itemmarketingharian,
            'itemmarketingoutsourcing' => $itemmarketingoutsourcing,
            'itemengineeringpkwtt' => $itemengineeringpkwtt,
            'itemengineeringpkwt' => $itemengineeringpkwt,
            'itemengineeringharian' => $itemengineeringharian,
            'itemengineeringoutsourcing' => $itemengineeringoutsourcing,
            'itemqualitypkwtt' => $itemqualitypkwtt,
            'itemqualitypkwt' => $itemqualitypkwt,
            'itemqualityharian' => $itemqualityharian,
            'itemqualityoutsourcing' => $itemqualityoutsourcing,
            'itempurchasingpkwtt' => $itempurchasingpkwtt,
            'itempurchasingpkwt' => $itempurchasingpkwt,
            'itempurchasingharian' => $itempurchasingharian,
            'itempurchasingoutsourcing' => $itempurchasingoutsourcing,
            'itemppcpkwtt' => $itemppcpkwtt,
            'itemppcpkwt' => $itemppcpkwt,
            'itemppcharian' => $itemppcharian,
            'itemppcoutsourcing' => $itemppcoutsourcing,
            'itemproduksipkwtt' => $itemproduksipkwtt,
            'itemproduksipkwt' => $itemproduksipkwt,
            'itemproduksiharian' => $itemproduksiharian,
            'itemproduksioutsourcing' => $itemproduksioutsourcing,
            'itemdeliveryproduksipkwtt' => $itemdeliveryproduksipkwtt,
            'itemdeliveryproduksipkwt' => $itemdeliveryproduksipkwt,
            'itemdeliveryproduksiharian' => $itemdeliveryproduksiharian,
            'itemdeliveryproduksioutsourcing' => $itemdeliveryproduksioutsourcing,
            'itemdeliveryproduksipkwtt' => $itemdeliveryproduksipkwtt,
            'itemdeliveryproduksipkwt' => $itemdeliveryproduksipkwt,
            'itemdeliveryproduksiharian' => $itemdeliveryproduksiharian,
            'itemdeliveryproduksioutsourcing' => $itemdeliveryproduksioutsourcing,
            'itemgudangrmpkwtt' => $itemgudangrmpkwtt,
            'itemgudangrmpkwt' => $itemgudangrmpkwt,
            'itemgudangrmharian' => $itemgudangrmharian,
            'itemgudangrmoutsourcing' => $itemgudangrmoutsourcing,
            'itemgudangfgpkwtt' => $itemgudangfgpkwtt,
            'itemgudangfgpkwt' => $itemgudangfgpkwt,
            'itemgudangfgharian' => $itemgudangfgharian,
            'itemgudangfgoutsourcing' => $itemgudangfgoutsourcing,
            'itemdeliverypkwtt' => $itemdeliverypkwtt,
            'itemdeliverypkwt' => $itemdeliverypkwt,
            'itemdeliveryharian' => $itemdeliveryharian,
            'itemdeliveryoutsourcing' => $itemdeliveryoutsourcing,
            'itemsecuritypkwtt' => $itemsecuritypkwtt,
            'itemsecuritypkwt' => $itemsecuritypkwt,
            'itemdeliveryharian' => $itemdeliveryharian,
            'itemsecurityoutsourcing' => $itemsecurityoutsourcing,
            'itemblokblpkwtt' => $itemblokblpkwtt,
            'itemblokblpkwt' => $itemblokblpkwt,
            'itemblokblharian' => $itemblokblharian,
            'itemblokbloutsourcing' => $itemblokbloutsourcing,
            'itemblokepkwtt' => $itemblokepkwtt,
            'itemblokepkwt' => $itemblokepkwt,
            'itemblokeharian' => $itemblokeharian,
            'itemblokeoutsourcing' => $itemblokeoutsourcing,
            'itempdcdaihatsusunterpkwtt' => $itempdcdaihatsusunterpkwtt,
            'itempdcdaihatsusunterpkwt' => $itempdcdaihatsusunterpkwt,
            'itempdcdaihatsusunterharian' => $itempdcdaihatsusunterharian,
            'itempdcdaihatsusunteroutsourcing' => $itempdcdaihatsusunteroutsourcing,
            'itempdcdaihatsucibinongpkwtt' => $itempdcdaihatsucibinongpkwtt,
            'itempdcdaihatsucibinongpkwt' => $itempdcdaihatsucibinongpkwt,
            'itempdcdaihatsucibinongharian' => $itempdcdaihatsucibinongharian,
            'itempdcdaihatsucibinongoutsourcing' => $itempdcdaihatsucibinongoutsourcing,
            'itempdcdaihatsucibitungpkwtt' => $itempdcdaihatsucibitungpkwtt,
            'itempdcdaihatsucibitungpkwt' => $itempdcdaihatsucibitungpkwt,
            'itempdcdaihatsucibitungharian' => $itempdcdaihatsucibitungharian,
            'itempdcdaihatsucibitungoutsourcing' => $itempdcdaihatsucibitungoutsourcing,
            'itempdcdaihatsukarawangtimurpkwtt' => $itempdcdaihatsukarawangtimurpkwtt,
            'itempdcdaihatsukarawangtimurpkwt' => $itempdcdaihatsukarawangtimurpkwt,
            'itempdcdaihatsukarawangtimurharian' => $itempdcdaihatsukarawangtimurharian,
            'itempdcdaihatsukarawangtimuroutsourcing' => $itempdcdaihatsukarawangtimuroutsourcing
            //Halaman HRD, ADMIN, Accounting 
           
            
        ]);
    }

    public function ubah_password()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER' && auth()->user()->roles != 'KARYAWAN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }
        return view('pages.changepassword.index');
    }

    public function hasil_ubah_password(ChangePasswordRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'HRD' && auth()->user()->roles != 'LEADER' && auth()->user()->roles != 'KARYAWAN' && auth()->user()->roles != 'MANAGER HRD' && auth()->user()->roles != 'MANAGER ACCOUNTING' && auth()->user()->roles != 'ACCOUNTING') {
            abort(403);
        }

        $id                 = auth()->user()->id;
        $password           = $request->input('password');

        $updatepassword     = User::where('id', $id)->first();

        $updatepassword->update([
            'password'      => Hash::make($password)
        ]);
        Alert::success('Success Update Password');
        Auth::logout();
        return redirect('/login');
    }

    public function form_ganti_foto_karyawan()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'KARYAWAN') {
            abort(403);
        }
        return view('pages.employees.foto.form_foto_karyawan');
    }

    public function hasil_ganti_foto_karyawan(FotoKaryawanRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'KARYAWAN') {
            abort(403);
        }

        $data           = $request->all();
        $nik_karyawan   = auth()->user()->nik;
        $fotokaryawan   = Employees::where('nik_karyawan', $nik_karyawan)->first();

        $karyawan       = $fotokaryawan->foto_karyawan;
        $foto_karyawan  = $request->file('foto_karyawan');

        if (Storage::exists('public/' . $karyawan) && $foto_karyawan <> null) {
            Storage::delete('public/' . $karyawan);
            $data['foto_karyawan'] = $request->file('foto_karyawan')->store(
                'assets/foto/karyawan',
                'public'
            );
        } elseif (Storage::exists('public/' . $karyawan) && $foto_karyawan == null) {
            $data['foto_karyawan'] = $karyawan;
        } else {
            dd('File does not exists.');
        }

        $fotokaryawan->update($data);
        Alert::info('Success Update Foto Karyawan', 'Oleh ' . auth()->user()->name);
        return redirect()->route('dashboard');
    }

    public function form_slip_lembur_karyawan()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'KARYAWAN') {
            abort(403);
        }
        return view('pages.employees.overtime.form_lembur_karyawan');
    }

    public function cetak_slip_lembur_karyawan(OvertimeRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'KARYAWAN') {
            abort(403);
        }

        $nik_karyawan   = auth()->user()->nik;

       

        $awal           = $request->input('awal');
        $akhir          = $request->input('akhir');

        $itemcover      =   Employees::with([
            'areas',
            'divisions',
            'positions',
        ])->where('nik_karyawan', $nik_karyawan)->first();

        $itemcoverdua   =   Overtimes::with([
            'employees',
        ])
            ->where('acc_hrd', '<>', NULL)
            ->where('employees_id', $nik_karyawan)
            ->where('deleted_at', NULL)
            ->whereBetween('tanggal_lembur', [$awal, $akhir])
            ->first();

        $bulanawal   = Carbon::parse($awal)->isoformat('MM');
        $bulanakhir  = Carbon::parse($akhir)->isoformat('MM');
        $tahunawal   = Carbon::parse($awal)->isoformat('YYYY');
        $tahunakhir  = Carbon::parse($akhir)->isoformat('YYYY');

        // dd($tahunakhir);
        $itemcoversatu =
        RekapSalaries::with([
            'employees'
        ])->where('employees_id', $nik_karyawan)->whereMonth('periode_awal', $bulanawal)->whereMonth('periode_akhir', $bulanakhir)->whereYear('periode_awal', $tahunawal)->whereYear('periode_akhir', $tahunakhir)->first();



            // DB::table('overtimes')
            // ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
            // ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            // ->join('areas', 'areas.id', '=', 'employees.areas_id')
            // ->join('positions', 'positions.id', '=', 'employees.positions_id')
            // ->join('rekap_salaries', 'rekap_salaries.employees_id', '=', 'employees.nik_karyawan')
            // ->where('overtimes.acc_hrd', '<>', NULL)
            // ->where('overtimes.employees_id', $nik_karyawan)
            // ->where('overtimes.deleted_at', NULL)
            // ->whereBetween('tanggal_lembur', [$awal, $akhir])
            // ->whereMonth('rekap_salaries.periode_awal', $bulanawal)
            // ->whereMonth('rekap_salaries.periode_akhir', $bulanakhir)
            // ->whereYear('rekap_salaries.periode_awal', $tahunawal)
            // ->whereYear('rekap_salaries.periode_akhir', $tahunakhir)
            // ->first();

        if ($itemcover == null) {
            Alert::error('Data Tidak Ditemukan');
            return redirect()->route('dashboard.form_slip_lembur_karyawan');
        } else {

            // $items =
            //     DB::table('overtimes')
            //     ->join('employees', 'employees.nik_karyawan', '=', 'overtimes.employees_id')
            //     ->join('divisions', 'divisions.id', '=', 'employees.divisions_id')
            //     ->join('areas', 'areas.id', '=', 'employees.areas_id')
            //     ->where('overtimes.acc_hrd', '<>', NULL)
            //     ->where('overtimes.employees_id', $nik_karyawan)
            //     ->where('overtimes.deleted_at', NULL)
            //     ->whereBetween('tanggal_lembur', [$awal, $akhir])
            //     ->orderBy('tanggal_lembur')
            //     ->get();

                $items =     Overtimes::with([
                    'employees',
                ])
                    ->where('acc_hrd', '<>', NULL)
                    ->where('employees_id', $nik_karyawan)
                    ->where('deleted_at', NULL)
                    ->whereBetween('tanggal_lembur', [$awal, $akhir])
                    ->orderBy('tanggal_lembur')
                    ->get();

            $this->fpdf = new FPDF('P', 'cm', array(21, 28));
            $this->fpdf->setTopMargin(0.2);
            $this->fpdf->setLeftMargin(0.6);
            $this->fpdf->AddPage();
            $this->fpdf->SetAutoPageBreak(true);

            $this->fpdf->SetFont('Arial', 'B', '8');
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(10, 1, "PT PRIMA KOMPONEN INDONESIA", 0, 0, 'L');
            $this->fpdf->Ln(0.4);
            $this->fpdf->SetFont('Arial', '', '9');
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(10, 1, $itemcover->areas->area . " - " . $itemcover->divisions->penempatan . "", 0, 0, 'L');

            $this->fpdf->SetFont('Arial', 'B', '10');
            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(20, 1, "Bukti Tanda Terima Slip Lembur", 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(20, 1, "Periode " . \Carbon\Carbon::parse($awal)->isoformat('D MMMM Y') . " s/d " . \Carbon\Carbon::parse($akhir)->isoformat('D MMMM Y') . "", 0, 0, 'C');

            $this->fpdf->Ln(0.6);

            $this->fpdf->SetFont('Arial', '', '8');
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(7, 0.5, "Nama     : " . $itemcover->nama_karyawan . "", 0, 0, 'L');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(7, 0.5, "Bagian   : " . $itemcover->positions->jabatan . " / " . $itemcover->divisions->penempatan . "", 0, 0, 'L');

            $this->fpdf->Ln(0.5);

            $this->fpdf->Cell(0.1);
            $this->fpdf->SetFont('Arial', '', '8');
            $this->fpdf->SetFillColor(255, 255, 255); // Warna sel tabel header
            $this->fpdf->Cell(1, 0.8, 'No', 1, 0, 'C', 1);
            $this->fpdf->Cell(2, 0.8, 'Hari', 1, 0, 'C', 1);
            $this->fpdf->Cell(2, 0.8, 'Tanggal', 1, 0, 'C', 1);

            $this->fpdf->Cell(4.5, 0.4, 'Jam Lembur ( Dlm Jam )', 1, 0, 'C', 1);
            $this->fpdf->Cell(1.5, 0.8, '', 1, 0, 'C', 1);

            $this->fpdf->Cell(4, 0.4, 'Perhitungan Jam Lembur', 1, 0, 'C', 1);
            $this->fpdf->Cell(2.2, 0.8, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(2.2, 0.8, '', 1, 0, 'C', 1);

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(5.1);
            $this->fpdf->Cell(1.5, 0.4, 'Masuk', 1, 0, 'C', 1);
            $this->fpdf->Cell(1.5, 0.4, 'Istirahat', 1, 0, 'C', 1);
            $this->fpdf->Cell(1.5, 0.4, 'Pulang', 1, 0, 'C', 1);

            $this->fpdf->Cell(1.5);
            $this->fpdf->Cell(1, 0.4, '1,5', 1, 0, 'C', 1);
            $this->fpdf->Cell(1, 0.4, '2', 1, 0, 'C', 1);
            $this->fpdf->Cell(1, 0.4, '3', 1, 0, 'C', 1);
            $this->fpdf->Cell(1, 0.4, '4', 1, 0, 'C', 1);

            $this->fpdf->Ln(-0.4);
            $this->fpdf->Cell(9.6);
            $this->fpdf->Cell(1.5, 0.4, 'Jam', 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(9.6);
            $this->fpdf->Cell(1.5, 0.4, 'Lembur', 0, 0, 'C');


            $this->fpdf->Ln(-0.4);
            $this->fpdf->Cell(15.4);
            $this->fpdf->Cell(1.5, 0.4, 'Uang Makan', 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(15.4);
            $this->fpdf->Cell(1.5, 0.4, 'perhari ( Rp )', 0, 0, 'C');

            $this->fpdf->Ln(-0.4);
            $this->fpdf->Cell(17.6);
            $this->fpdf->Cell(1.5, 0.4, 'U. Transport', 0, 0, 'C');

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(17.6);
            $this->fpdf->Cell(1.5, 0.4, 'perhari ( Rp )', 0, 0, 'C');

            $no = 1;
            $jumlahjampertama = 0;
            $jumlahjamkedua = 0;
            $jumlahjamketiga = 0;
            $jumlahjamkeempat = 0;
            $jumlahuangmakanlembur = 0;
            $total = 0;

            foreach ($items as $item) {

                $harilembur         = \Carbon\Carbon::parse($item->tanggal_lembur)->isoformat('dddd');
                $tanggallembur      = \Carbon\Carbon::parse($item->tanggal_lembur)->isoformat('DD-MM-Y');
                $tahunlembur        = \Carbon\Carbon::parse($awal)->isoformat('YYYY');

                $this->fpdf->Ln(0.4);
                $this->fpdf->Cell(0.1);
                $this->fpdf->Cell(1, 0.4, $no, 1, 0, 'C');
                $this->fpdf->Cell(2, 0.4, $harilembur, 1, 0, 'C');
                $this->fpdf->Cell(2, 0.4, $tanggallembur, 1, 0, 'C');

                $this->fpdf->Cell(1.5, 0.4, $item->jam_masuk, 1, 0, 'C');
                $this->fpdf->Cell(1.5, 0.4, $item->jam_istirahat, 1, 0, 'C');
                $this->fpdf->Cell(1.5, 0.4, $item->jam_pulang, 1, 0, 'C');
                $this->fpdf->Cell(1.5, 0.4, $item->jam_lembur, 1, 0, 'C');

                $this->fpdf->Cell(1, 0.4, $item->jam_pertama, 1, 0, 'C');
                $this->fpdf->Cell(1, 0.4, $item->jam_kedua, 1, 0, 'C');
                $this->fpdf->Cell(1, 0.4, $item->jam_ketiga, 1, 0, 'C');
                $this->fpdf->Cell(1, 0.4, $item->jam_keempat, 1, 0, 'C');

                $this->fpdf->Cell(2.2, 0.4, number_format($item->uang_makan_lembur), 1, 0, 'C');
                $this->fpdf->Cell(2.2, 0.4, ' - ', 1, 0, 'C');

                $no++;
                $jumlahjampertama += $item->jumlah_jam_pertama;
                $jumlahjamkedua += $item->jumlah_jam_kedua;
                $jumlahjamketiga += $item->jumlah_jam_ketiga;
                $jumlahjamkeempat += $item->jumlah_jam_keempat;
                $jumlahuangmakanlembur += $item->uang_makan_lembur;
            }

            $jumlahjamlembur        = $jumlahjampertama + $jumlahjamkedua + $jumlahjamketiga + $jumlahjamkeempat;
            $jumlahuanglembur       = $jumlahjamlembur * $itemcoversatu->upah_lembur_perjam;
            $jumlahuangditerima     = $jumlahuanglembur + $jumlahuangmakanlembur;

            $this->fpdf->Ln(0.4);
            $this->fpdf->Cell(9.4);
            $this->fpdf->Cell(1.7, 0.4, 'Jumlah Jam', 0, 0, 'L');

            $this->fpdf->Cell(1, 0.4, $jumlahjampertama, 1, 0, 'C');
            $this->fpdf->Cell(1, 0.4, $jumlahjamkedua, 1, 0, 'C');
            $this->fpdf->Cell(1, 0.4, $jumlahjamketiga, 1, 0, 'C');
            $this->fpdf->Cell(1, 0.4, $jumlahjamkeempat, 1, 0, 'C');
            $this->fpdf->Cell(2.2, 0.4, $jumlahuangmakanlembur, 1, 0, 'C');
            $this->fpdf->Cell(2.2, 0.4, " - ", 1, 0, 'C');


            $this->fpdf->Ln(0.2);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, 'Jumlah Jam Lembur', 0, 0, 'L');

            $this->fpdf->Cell(1.5);
            $this->fpdf->Cell(3, 0.2, $jumlahjamlembur, 0, 0, 'C');

            $this->fpdf->Ln(0.3);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, 'Upah Lembur Perjam', 0, 0, 'L');
            $this->fpdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
            $this->fpdf->Cell(3, 0.2, number_format($itemcoversatu->upah_lembur_perjam), 0, 0, 'R');

            $this->fpdf->SetFont('Arial', 'B', '7');
            $this->fpdf->Cell(1.5);
            $this->fpdf->Cell(5, 0.2, 'Note : 0.5 Dlm angka = 30 menit dlm jam ( Jam Istirahat Lembur )', 0, 0, 'L');

            $this->fpdf->Ln(0.3);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(9.5, 0, '', 1, 0, 'L', 1);

            $this->fpdf->SetFont('Arial', '', '8');
            $this->fpdf->Ln(0.1);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, 'Jumlah Uang Lembur', 0, 0, 'L');
            $this->fpdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
            $this->fpdf->Cell(3, 0.2, number_format($jumlahuanglembur), 0, 0, 'R');

            $this->fpdf->Ln(0.3);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, 'Jumlah Uang Makan Lembur', 0, 0, 'L');
            $this->fpdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
            $this->fpdf->Cell(3, 0.2, number_format($jumlahuangmakanlembur), 0, 0, 'R');


            $this->fpdf->Ln(0.3);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, 'Jumlah Uang Transport Lembur', 0, 0, 'L');
            $this->fpdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
            $this->fpdf->Cell(3, 0.2, " - ", 0, 0, 'R');


            $this->fpdf->Ln(0.3);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(9.5, 0, '', 1, 0, 'L', 1);

            $this->fpdf->Ln(0.1);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, 'Jumlah Uang Yang Diterima', 0, 0, 'L');
            $this->fpdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
            $this->fpdf->Cell(3, 0.2, number_format($jumlahuangditerima), 0, 0, 'R');


            $this->fpdf->Ln(1);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, 'Mengetahui', 0, 0, 'L');

            $this->fpdf->Cell(6, 0.2, 'Tangerang Selatan, ............................,' . $tahunlembur, 0, 0, 'L');

            $this->fpdf->Cell(3);
            $this->fpdf->Cell(5.4, 0.2, 'Yang Menerima', 0, 0, 'L');


            $this->fpdf->Ln(2);
            $this->fpdf->Cell(0.1);
            $this->fpdf->Cell(5, 0.2, '(Rudiyanto)', 0, 0, 'L');


            $this->fpdf->Cell(9);
            $this->fpdf->Cell(5.4, 0.2, '(' . $itemcover->nama_karyawan . ')', 0, 0, 'L');


            $this->fpdf->Ln(60);

            $this->fpdf->Output();
            exit;
        }
    }

    public function form_absensi_karyawan()
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'KARYAWAN') {
            abort(403);
        }
        return view('pages.employees.absensi.form_absen_karyawan');
    }

    public function cetak_absensi_karyawan(OvertimeRequest $request)
    {
        if (auth()->user()->roles != 'ADMIN' && auth()->user()->roles != 'KARYAWAN') {
            abort(403);
        }

        $employees_id   = auth()->user()->nik;
        $awal           = $request->input('awal');
        $akhir          = $request->input('akhir');

        $item = Attendances::with([
            'employees'
        ])
            ->where('employees_id', $employees_id)
            ->first();

        if ($item == null) {
            Alert::error('Data yang anda cari tidak ada');
            return redirect()->route('dashboard.form_absensi_karyawan');
        } else {

            $absens = Attendances::with([
                'employees'
            ])
                ->where('employees_id', $employees_id)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->get();

            $cutitahunan = DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->groupBy('keterangan_absen', 'lama_absen', 'employees_id')
                ->select('keterangan_absen', 'employees_id', 'lama_absen', DB::raw('sum(lama_absen) as lama_absen'))
                ->where('employees_id', $employees_id)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->where('attendances.deleted_at', NULL)
                ->where('keterangan_absen', 'Cuti Tahunan')
                ->count();
            $cutikhusus = DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->groupBy('keterangan_absen', 'lama_absen', 'employees_id')
                ->select('keterangan_absen', 'employees_id', 'lama_absen', DB::raw('sum(lama_absen) as lama_absen'))
                ->where('employees_id', $employees_id)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->where('attendances.deleted_at', NULL)
                ->where('keterangan_absen', 'Cuti Khusus')
                ->count();
            $sakit = DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->groupBy('keterangan_absen', 'lama_absen', 'employees_id')
                ->select('keterangan_absen', 'employees_id', 'lama_absen', DB::raw('sum(lama_absen) as lama_absen'))
                ->where('employees_id', $employees_id)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->where('attendances.deleted_at', NULL)
                ->where('keterangan_absen', 'Sakit')
                ->count();
            $ijin = DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->groupBy('keterangan_absen', 'lama_absen', 'employees_id')
                ->select('keterangan_absen', 'employees_id', 'lama_absen', DB::raw('sum(lama_absen) as lama_absen'))
                ->where('employees_id', $employees_id)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->where('attendances.deleted_at', NULL)
                ->where('keterangan_absen', 'Ijin')
                ->count();
            $alpa = DB::table('attendances')
                ->join('employees', 'employees.nik_karyawan', '=', 'attendances.employees_id')
                ->groupBy('keterangan_absen', 'lama_absen', 'employees_id')
                ->select('keterangan_absen', 'employees_id', 'lama_absen', DB::raw('sum(lama_absen) as lama_absen'))
                ->where('employees_id', $employees_id)
                ->whereBetween('tanggal_absen', [$awal, $akhir])
                ->where('attendances.deleted_at', NULL)
                ->where('keterangan_absen', 'Alpa')
                ->count();

            $this->fpdf = new FPDF('P', 'mm', 'A4');
            $this->fpdf->AddPage();

            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', 'B', '18');
            $this->fpdf->Cell(190, 5, 'DATA ABSENSI', 0, 1, 'C');
            $this->fpdf->Ln(5);

            $this->fpdf->Cell(190, 5, $item->employees->nama_karyawan, 0, 1, 'C');
            $this->fpdf->Ln(5);

            $this->fpdf->Cell(190, 5, \Carbon\Carbon::parse($awal)->isoformat('D MMMM Y') . ' s/d ' . \Carbon\Carbon::parse($akhir)->isoformat('D MMMM Y') . '', 0, 1, 'C');

            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(25, 10, 'Sakit', 0, 0, 'L');
            $this->fpdf->Cell(5, 10, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(60, 10, $sakit . ' Hari', 0, 0, 'L');

            $this->fpdf->Cell(25, 10, 'Cuti Tahunan', 0, 0, 'L');
            $this->fpdf->Cell(5, 10, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(15, 10, $cutitahunan . ' Hari', 0, 0, 'L');
            $this->fpdf->Ln();

            $this->fpdf->Cell(25, 10, 'Ijin', 0, 0, 'L');
            $this->fpdf->Cell(5, 10, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(60, 10, $ijin . ' Hari', 0, 0, 'L');

            $this->fpdf->Cell(25, 10, 'Cuti Khusus', 0, 0, 'L');
            $this->fpdf->Cell(5, 10, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(15, 10, $cutikhusus . ' Hari', 0, 0, 'L');
            $this->fpdf->Ln();

            $this->fpdf->Cell(25, 10, 'Alpa', 0, 0, 'L');
            $this->fpdf->Cell(5, 10, ' : ', 0, 0, 'C');
            $this->fpdf->Cell(15, 10, $alpa . ' Hari', 0, 0, 'L');
            $this->fpdf->Ln();

            $this->fpdf->Cell(1);
            $this->fpdf->SetFont('Arial', 'B', '12');
            $this->fpdf->SetFillColor(192, 192, 192); // Warna sel tabel header
            $this->fpdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
            $this->fpdf->Cell(60, 10, 'Tanggal Absen', 1, 0, 'C', 1);
            $this->fpdf->Cell(60, 10, 'Jenis', 1, 0, 'C', 1);
            $this->fpdf->Cell(60, 10, 'Keterangan', 1, 0, 'C', 1);

            $no = 1;

            foreach ($absens as $absen) {
                $this->fpdf->Ln();
                $this->fpdf->Cell(1);
                $this->fpdf->SetFont('Arial', '', '11');
                $this->fpdf->Cell(10, 8, $no, 1, 0, 'C');
                $this->fpdf->Cell(60, 8, \Carbon\Carbon::parse($absen->tanggal_absen)->isoformat(' D MMMM Y'), 1, 0, 'C');
                $this->fpdf->Cell(60, 8, $absen->keterangan_absen, 1, 0, 'C');
                $this->fpdf->Cell(60, 8, $absen->keterangan_cuti_khusus, 1, 0, 'C');
                $no++;
            }

            $this->fpdf->Output();
            exit;
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
