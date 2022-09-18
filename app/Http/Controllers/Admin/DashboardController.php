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
// use App\Http\Requests\Employees\OvertimesRequest;
// use App\Http\Requests\Employees\FotoKaryawanRequest;
// use App\Http\Requests\ChangePasswordRequest;
use App\Models\Admin\HistoryContracts;
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

    public function index(Request $request)
    {
        //
        toast('Hello ' . auth()->user()->name, 'success');
        $nik_karyawan = auth()->user()->nik;
        //

        //Halaman Admin HRD Accounting
        //Jumlah Karyawan
        $itembsd = Employees::with([
            'areas'
        ])->where('areas_id', 2)->whereIn('golongans_id', [1,2,4])->count();
        $itemaw = Employees::with([
            'areas'
        ])->whereIn('areas_id', [1,7])->whereIn('golongans_id', [1,2,4])->count();
        $itemsunter = Employees::with([
            'areas'
        ])->where('areas_id', 3)->whereIn('golongans_id', [1,2,4])->count();
        $itemcibinong = Employees::with([
            'areas'
        ])->where('areas_id', 4)->whereIn('golongans_id', [1,2,4])->count();
        $itemcibitung = Employees::with([
            'areas'
        ])->where('areas_id', 5)->whereIn('golongans_id', [1,2,4])->count();
        $itemkarawangtimur = Employees::with([
            'areas'
        ])->where('areas_id', 6)->whereIn('golongans_id', [1,2,4])->count();
        $itembl = Employees::with([
            'areas'
        ])->where('areas_id', 7)->whereIn('golongans_id', [1,2,4])->count();
        $itempdc = $itemsunter + $itemcibinong + $itemcibitung + $itemkarawangtimur;
        $itemall = $itembsd + $itempdc + $itemaw ;
        //Jumlah Karyawan
        // Chart Penempatan
        $itemaccounting = Employees::with([
            'divisions'
        ])->where('divisions_id', 1)->whereIn('golongans_id', [1,2,4])->count();
        $itemic = Employees::with([
            'divisions'
        ])->where('divisions_id', 2)->whereIn('golongans_id', [1,2,4])->count();
        $itemit = Employees::with([
            'divisions'
        ])->where('divisions_id', 3)->whereIn('golongans_id', [1,2,4])->count();
        $itemhrd = Employees::with([
            'divisions'
        ])->where('divisions_id', 4)->whereIn('golongans_id', [1,2,4])->count();
        $itemdoccontrol = Employees::with([
            'divisions'
        ])->where('divisions_id', 5)->whereIn('golongans_id', [1,2,4])->count();
        $itemmarketing = Employees::with([
            'divisions'
        ])->where('divisions_id', 6)->whereIn('golongans_id', [1,2,4])->count();
        $itemengineering = Employees::with([
            'divisions'
        ])->where('divisions_id', 7)->whereIn('golongans_id', [1,2,4])->count();
        $itemquality = Employees::with([
            'divisions'
        ])->where('divisions_id', 8)->whereIn('golongans_id', [1,2,4])->count();
        $itempurchasing = Employees::with([
            'divisions'
        ])->where('divisions_id', 9)->whereIn('golongans_id', [1,2,4])->count();
        $itemppc = Employees::with([
            'divisions'
        ])->where('divisions_id', 10)->whereIn('golongans_id', [1,2,4])->count();
        $itemproduksi = Employees::with([
            'divisions'
        ])->where('divisions_id', 11)->whereIn('golongans_id', [1,2,4])->count();
        $itemdeliveryproduksi = Employees::with([
            'divisions'
        ])->where('divisions_id', 12)->whereIn('golongans_id', [1,2,4])->count();
        $itemgudangrm = Employees::with([
            'divisions'
        ])->where('divisions_id', 13)->whereIn('golongans_id', [1,2,4])->count();
        $itemgudangfg = Employees::with([
            'divisions'
        ])->where('divisions_id', 14)->whereIn('golongans_id', [1,2,4])->count();
        $itemdelivery = Employees::with([
            'divisions'
        ])->where('divisions_id', 15)->whereIn('golongans_id', [1,2,4])->count();
        $itemsecurity = Employees::with([
            'divisions'
        ])->where('divisions_id', 16)->whereIn('golongans_id', [1,2,4])->count();
        $itemblokbl = Employees::with([
            'divisions'
        ])->where('divisions_id', 17)->whereIn('golongans_id', [1,2,4])->count();
        $itembloke = Employees::with([
            'divisions'
        ])->where('divisions_id', 18)->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsusunter = Employees::with([
            'divisions'
        ])->where('divisions_id', 19)->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsucibinong = Employees::with([
            'divisions'
        ])->where('divisions_id', 20)->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsucibitung = Employees::with([
            'divisions'
        ])->where('divisions_id', 21)->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsukarawangtimur = Employees::with([
            'divisions'
        ])->where('divisions_id', 22)->whereIn('golongans_id', [1,2,4])->count();
        $itemjumlahgreenville   = $itemaccounting + $itembl + $itemic + $itemit;
        $itemjumlahhrd          = $itemhrd + $itemsecurity;
        $itemjumlahppc          = $itemppc + $itemdelivery + $itemdeliveryproduksi + $itembloke + $itemgudangrm + $itemgudangfg;
        $itemjumlahproduksi     = $itemproduksi + $itempdcdaihatsusunter + $itempdcdaihatsucibinong + $itempdcdaihatsucibitung + $itempdcdaihatsukarawangtimur;
        // Chart Penempatan
        // Chart Status Kontrak
        $itemkontrak = Employees::all()
            ->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])
            ->count();
        $itemtetap = Employees::all()
            ->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])
            ->count();
        $itemharian = Employees::all()
            ->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])
            ->count();
        $itemoutsourcing = Employees::all()
            ->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])
            ->count();
        // Chart Status Kontrak

        // Chart Status Menikah
        $itemsingle = Employees::all()
            ->where('status_nikah', 'Single')->whereIn('golongans_id', [1,2,4])
            ->count();
        $itemmenikah = Employees::all()
            ->where('status_nikah', 'Menikah')->whereIn('golongans_id', [1,2,4])
            ->count();
        $itemjanda = Employees::all()
            ->where('status_nikah', 'Janda')->whereIn('golongans_id', [1,2,4])
            ->count();
        $itemduda = Employees::all()
            ->where('status_nikah', 'Duda')->whereIn('golongans_id', [1,2,4])
            ->count();
        // Chart Status Menikah
        // Chart Jenis Kelamin
        $itempria = Employees::all()
            ->where('jenis_kelamin', 'Pria')->whereIn('golongans_id', [1,2,4])
            ->count();
        $itemwanita = Employees::all()
            ->where('jenis_kelamin', 'Wanita')->whereIn('golongans_id', [1,2,4])
            ->count();
        // Chart Jenis Kelamin

        // Chart Agama
        $itemislam = Employees::all()
            ->where('agama', 'Islam')->whereIn('golongans_id', [1,2,4])
            ->count();
        $itemkristenprotestan = Employees::all()
            ->where('agama', 'Kristen Protestan')->whereIn('golongans_id', [1,2,4])
            ->count();
        $itemkristenkatholik = Employees::all()
            ->where('agama', 'Kristen Katholik')->whereIn('golongans_id', [1,2,4])
            ->count();
        $itemhindu = Employees::all()
            ->where('agama', 'Hindu')->whereIn('golongans_id', [1,2,4])
            ->count();
        $itembudha = Employees::all()
            ->where('agama', 'Budha')->whereIn('golongans_id', [1,2,4])
            ->count();
        // Chart Agama
        //  Chart Penempatan Detail
        $itemaccountingpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 1)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemaccountingpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 1)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemaccountingharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 1)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemaccountingoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 1)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        $itemicpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 2)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemicpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 2)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemicharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 2)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemicoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 2)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        $itemitpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 3)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemitpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 3)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemitharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 3)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemitoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 3)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        $itemhrdpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 4)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemhrdpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 4)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemhrdharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 4)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemhrdoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 4)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        $itemdoccontrolpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 5)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemdoccontrolpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 5)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemdoccontrolharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 5)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemdoccontroloutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 5)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();

        $itemmarketingpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 6)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemmarketingpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 6)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemmarketingharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 6)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemmarketingoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 6)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        $itemengineeringpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 7)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemengineeringpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 7)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemengineeringharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 7)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemengineeringoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 7)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        $itemqualitypkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 8)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemqualitypkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 8)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemqualityharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 8)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemqualityoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 8)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        $itempurchasingpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 9)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itempurchasingpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 9)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itempurchasingharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 9)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itempurchasingoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 9)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        $itemppcpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 10)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemppcpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 10)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemppcharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 10)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemppcoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 10)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        $itemproduksipkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 11)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemproduksipkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 11)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemproduksiharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 11)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemproduksioutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 11)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        $itemdeliveryproduksipkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 12)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemdeliveryproduksipkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 12)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemdeliveryproduksiharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 12)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemdeliveryproduksioutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 12)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        //
        $itemgudangrmpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 13)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemgudangrmpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 13)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemgudangrmharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 13)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemgudangrmoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 13)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        //
        $itemgudangfgpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 14)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemgudangfgpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 14)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemgudangfgharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 14)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemgudangfgoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 14)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        //
        $itemdeliverypkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 15)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemdeliverypkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 15)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemdeliveryharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 15)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemdeliveryoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 15)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        //
        $itemsecuritypkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 16)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemsecuritypkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 16)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemsecurityharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 16)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemsecurityoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 16)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        //
        $itemblokblpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 17)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemblokblpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 17)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemblokblharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 17)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemblokbloutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 17)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        //
        $itemblokepkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 18)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itemblokepkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 18)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itemblokeharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 18)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itemblokeoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 18)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        //
        $itempdcdaihatsusunterpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 19)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsusunterpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 19)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsusunterharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 19)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsusunteroutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 19)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        //
        $itempdcdaihatsucibinongpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 20)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsucibinongpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 20)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsucibinongharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 20)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsucibinongoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 20)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        //
        $itempdcdaihatsucibitungpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 21)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsucibitungpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 21)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsucibitungharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 21)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsucibitungoutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 21)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        //
        $itempdcdaihatsukarawangtimurpkwtt = Employees::with([
            'divisions'
        ])->where('divisions_id', 22)->where('status_kerja', 'PKWTT')->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsukarawangtimurpkwt = Employees::with([
            'divisions'
        ])->where('divisions_id', 22)->where('status_kerja', 'PKWT')->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsukarawangtimurharian = Employees::with([
            'divisions'
        ])->where('divisions_id', 22)->where('status_kerja', 'Harian')->whereIn('golongans_id', [1,2,4])->count();
        $itempdcdaihatsukarawangtimuroutsourcing = Employees::with([
            'divisions'
        ])->where('divisions_id', 22)->where('status_kerja', 'Outsourcing')->whereIn('golongans_id', [1,2,4])->count();
        // Chart  Penempatan Detail
        //Halaman Admin HRD Accounting

        return view('pages.admin.dashboard',[
            //Halaman HRD, ADMIN, Accounting TOP
            'itempdc'                       => $itempdc,
            'itemall'                       => $itemall,
            'itemaw'                        => $itemaw,
            'itembsd'                       => $itembsd,
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
            'itemsingle'                    => $itemsingle,
            'itemmenikah'                   => $itemmenikah,
            'itemjanda'                     => $itemjanda,
            'itemduda'                      => $itemduda,
            'itempria'                      => $itempria,
            'itemwanita'                    => $itemwanita,
            'itemislam'                     => $itemislam,
            'itemkristenprotestan'          => $itemkristenprotestan,
            'itemkristenkatholik'           => $itemkristenkatholik,
            'itemhindu'                     => $itemhindu,
            'itembudha'                     => $itembudha,
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
