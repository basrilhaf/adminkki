<?php

namespace App\Http\Controllers;

use App\Services\DataService;
use Illuminate\Support\Facades\DB;
use Crypt;
use App\Models\Menu;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Response;;



class ReportingController extends Controller
{
    protected $dataService;

    public function __construct(DataService $dataService, Request $request)
    {

        $this->middleware(function ($request, $next) {
            if ($request->session()->get('id_user') == '') {
                return Redirect::to('/login')->send();
            }

            return $next($request);
        });

        $this->dataService = $dataService;
    }

    public function index(): View
    {
        $menu_aktif = '/laporanHarian||/reporting';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Laporan Harian',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('reporting.index', $data);
    }

    public function laporanPeriode(): View
    {
        $menu_aktif = '/laporanPeriode||/reporting';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Laporan Periode',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('reporting.laporan-periode', $data);
    }

    
    public function laporanKompilasi(): View
    {
        $menu_aktif = '/laporanKompilasi||/reporting';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Laporan Kompilasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('reporting.laporan-kompilasi', $data);
    }

    
    public function rangkumanMasalah(): View
    {
        $menu_aktif = '/rangkumanMasalah||/reporting';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Rangkuman Masalah',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('reporting.rangkuman-masalah', $data);
    }
    
    public function masalahPerCabang(): View
    {
        $menu_aktif = '/masalahPerCabang||/reporting';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Masalah Per Cabang',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('reporting.masalah-per-cabang', $data);
    }

    
    public function jpk(): View
    {
        $menu_aktif = '/jpk||/reporting';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $pkp = DB::connection('mysql_secondary')->table('kre_kode_group2 AS A')
                    ->select('kode_group2','deskripsi_group2','kode_kantor')
                    ->get();
        $data = [
            'menu' => 'JPK',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '',
            'pkp' => $pkp
        ];
        
        return view('reporting.jpk', $data);
    }

    
    public function pdfJpk(): View
    {
        $pkp = $_GET["pkp"];
        $senin_830 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '08:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 2') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();
        
        $senin_900 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '09:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 2') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $senin_930 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '09:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 2') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();
        
        $senin_1000 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '10:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 2') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $senin_1030 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '10:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 2') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $senin_1100 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '11:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 2') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $senin_1130 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '11:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 2') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $senin_1300 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '13:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 2') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $senin_1330 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '13:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 2') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $senin_1400 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '14:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 2') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $senin_1430 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '14:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 2') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $senin_1500 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '15:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 2') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        // selasa
        $selasa_830 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '08:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 3') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();
        
        $selasa_900 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '09:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 3') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $selasa_930 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '09:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 3') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();
        
        $selasa_1000 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '10:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 3') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $selasa_1030 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '10:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 3') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $selasa_1100 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '11:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 3') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $selasa_1130 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '11:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 3') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $selasa_1300 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '13:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 3') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $selasa_1330 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '13:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 3') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $selasa_1400 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '14:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 3') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $selasa_1430 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '14:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 3') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $selasa_1500 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '15:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 3') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        // rabu
        $rabu_830 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '08:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 4') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();
        
        $rabu_900 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '09:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 4') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $rabu_930 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '09:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 4') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();
        
        $rabu_1000 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '10:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 4') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $rabu_1030 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '10:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 4') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $rabu_1100 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '11:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 4') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $rabu_1130 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '11:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 4') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $rabu_1300 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '13:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 4') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $rabu_1330 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '13:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 4') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $rabu_1400 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '14:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 4') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $rabu_1430 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '14:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 4') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $rabu_1500 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '15:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 4') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();


        // kamis 
        $kamis_830 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '08:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 5') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();
        
        $kamis_900 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '09:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 5') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $kamis_930 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '09:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 5') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();
        
        $kamis_1000 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '10:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 5') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $kamis_1030 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '10:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 5') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $kamis_1100 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '11:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 5') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $kamis_1130 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '11:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 5') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $kamis_1300 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '13:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 5') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $kamis_1330 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '13:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 5') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $kamis_1400 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '14:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 5') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $kamis_1430 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '14:30')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 5') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        $kamis_1500 = DB::connection('mysql_secondary')->table('kredit AS A')->select('B.deskripsi_group1',DB::raw('COUNT(A.nasabah_id) as total'),'A.tgl_realisasi','B.Jam_Setoran')
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->where('B.Jam_Setoran', '15:00')
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 5') 
                ->groupBy('B.deskripsi_group1', 'A.tgl_realisasi', 'B.Jam_Setoran')->orderBy('B.deskripsi_group1', 'ASC')->get();

        // total 
        $total_senin = DB::connection('mysql_secondary')->table('kredit AS A')->select(DB::raw('COUNT(distinct(A.nasabah_id)) as anggota'),DB::raw('COUNT(distinct(A.kode_group1)) as kelompok'),DB::raw('COUNT(distinct(A.kode_group3)) as kumpulan'))
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 2')->first();

        $total_selasa = DB::connection('mysql_secondary')->table('kredit AS A')->select(DB::raw('COUNT(distinct(A.nasabah_id)) as anggota'),DB::raw('COUNT(distinct(A.kode_group1)) as kelompok'),DB::raw('COUNT(distinct(A.kode_group3)) as kumpulan'))
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 3')->first();

        $total_rabu = DB::connection('mysql_secondary')->table('kredit AS A')->select(DB::raw('COUNT(distinct(A.nasabah_id)) as anggota'),DB::raw('COUNT(distinct(A.kode_group1)) as kelompok'),DB::raw('COUNT(distinct(A.kode_group3)) as kumpulan'))
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 4')->first();
            
        $total_kamis = DB::connection('mysql_secondary')->table('kredit AS A')->select(DB::raw('COUNT(distinct(A.nasabah_id)) as anggota'),DB::raw('COUNT(distinct(A.kode_group1)) as kelompok'),DB::raw('COUNT(distinct(A.kode_group3)) as kumpulan'))
                ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')->where('A.kode_group2', $pkp)->where('A.pokok_saldo_akhir', '>', 0)
                ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = 5')->first();
        
        $total_anggota = $total_senin->anggota + $total_selasa->anggota + $total_rabu->anggota + $total_kamis->anggota;
        $total_kelompok = $total_senin->kelompok + $total_selasa->kelompok + $total_rabu->kelompok + $total_kamis->kelompok;
        $total_kumpulan = $total_senin->kumpulan + $total_selasa->kumpulan + $total_rabu->kumpulan + $total_kamis->kumpulan;

        // pkp 
        $detail_pkp = DB::connection('mysql_secondary')->table('kre_kode_group2')->select('*')
                ->where('kode_group2', $pkp)->first();


        $data = [
            'senin_830' => $senin_830,
            'senin_900' => $senin_900,
            'senin_930' => $senin_930,
            'senin_1000' => $senin_1000,
            'senin_1030' => $senin_1030,
            'senin_1100' => $senin_1100,
            'senin_1130' => $senin_1130,
            'senin_1300' => $senin_1300,
            'senin_1330' => $senin_1330,
            'senin_1400' => $senin_1400,
            'senin_1430' => $senin_1430,
            'senin_1500' => $senin_1500,

            'selasa_830' => $selasa_830,
            'selasa_900' => $selasa_900,
            'selasa_930' => $selasa_930,
            'selasa_1000' => $selasa_1000,
            'selasa_1030' => $selasa_1030,
            'selasa_1100' => $selasa_1100,
            'selasa_1130' => $selasa_1130,
            'selasa_1300' => $selasa_1300,
            'selasa_1330' => $selasa_1330,
            'selasa_1400' => $selasa_1400,
            'selasa_1430' => $selasa_1430,
            'selasa_1500' => $selasa_1500,

            'rabu_830' => $rabu_830,
            'rabu_900' => $rabu_900,
            'rabu_930' => $rabu_930,
            'rabu_1000' => $rabu_1000,
            'rabu_1030' => $rabu_1030,
            'rabu_1100' => $rabu_1100,
            'rabu_1130' => $rabu_1130,
            'rabu_1300' => $rabu_1300,
            'rabu_1330' => $rabu_1330,
            'rabu_1400' => $rabu_1400,
            'rabu_1430' => $rabu_1430,
            'rabu_1500' => $rabu_1500,

            'kamis_830' => $kamis_830,
            'kamis_900' => $kamis_900,
            'kamis_930' => $kamis_930,
            'kamis_1000' => $kamis_1000,
            'kamis_1030' => $kamis_1030,
            'kamis_1100' => $kamis_1100,
            'kamis_1130' => $kamis_1130,
            'kamis_1300' => $kamis_1300,
            'kamis_1330' => $kamis_1330,
            'kamis_1400' => $kamis_1400,
            'kamis_1430' => $kamis_1430,
            'kamis_1500' => $kamis_1500,

            'total_senin' => $total_senin->anggota."/".$total_senin->kelompok,
            'total_selasa' => $total_selasa->anggota."/".$total_selasa->kelompok,
            'total_rabu' => $total_rabu->anggota."/".$total_rabu->kelompok,
            'total_kamis' => $total_kamis->anggota."/".$total_kamis->kelompok,

            'total_anggota' => $total_anggota,
            'total_kelompok' => $total_kelompok."/".$total_kumpulan,
            'nama_pkp' => $detail_pkp->deskripsi_group2
        ];

        return view('reporting.pdf-jpk', $data);
    }

    public function migrasiLapPeriode(Request $request)
    {
        $cabang = "0".$_GET["cabang"];
        $tanggal = $_GET["tanggal"];
        // query setoran 
        $perkiraanQuery = DB::connection('mysql_secondary')->table('kretrans as kt')
            ->selectRaw('k.kode_group1, COUNT(DISTINCT kt.NO_REKENING) AS jumlah_perkiraan')
            ->join('kredit as k', 'kt.NO_REKENING', '=', 'k.NO_REKENING')
            ->where('kt.MY_KODE_TRANS', 200);
            if ($cabang != 0) {
                $perkiraanQuery->where('k.kode_kantor', $cabang);
            }
            $perkiraanQuery = $perkiraanQuery->where('kt.TGL_TRANS', $tanggal)
            ->where(function ($query) use ($tanggal) { // Tambahkan 'use ($tanggal)'
                $query->where('k.pokok_saldo_akhir', '>', 0)
                    ->orWhereExists(function ($subquery) use ($tanggal) { // Tambahkan 'use ($tanggal)'
                        $subquery->select(DB::raw(1))
                            ->from('kretrans as kt2')
                            ->whereRaw('kt2.NO_REKENING = k.NO_REKENING')
                            ->where('kt2.TGL_TRANS', $tanggal)
                            ->where('kt2.MY_KODE_TRANS', 300);
                    });
            })
            ->groupBy('k.kode_group1');

        $pembayaranQuery = DB::connection('mysql_secondary')->table('kretrans as kt')
            ->selectRaw('k.kode_group1, COUNT(DISTINCT kt.NO_REKENING) AS jumlah_pembayaran')
            ->join('kredit as k', 'kt.NO_REKENING', '=', 'k.NO_REKENING')
            ->where('kt.MY_KODE_TRANS', 300);
            if ($cabang != 0) {
                $pembayaranQuery->where('k.kode_kantor', $cabang);
            }
            $pembayaranQuery = $pembayaranQuery->where('kt.TGL_TRANS', $tanggal)
            ->groupBy('k.kode_group1');

        $finalQuery = DB::connection('mysql_secondary')->query()->fromSub($perkiraanQuery, 'p')
            ->leftJoinSub($pembayaranQuery, 'b', 'p.kode_group1', '=', 'b.kode_group1')
            ->leftJoin('kre_kode_group1 as g', DB::raw('COALESCE(p.kode_group1, b.kode_group1)'), '=', 'g.kode_group1')
            ->selectRaw('g.deskripsi_group1, COALESCE(p.jumlah_perkiraan, 0) AS Jumlah_kelompok_aktif_hari_ini, COALESCE(b.jumlah_pembayaran, 0) AS Jumlah_kelompok_setoran_hari_ini, CASE WHEN COALESCE(p.jumlah_perkiraan, 0) > COALESCE(b.jumlah_pembayaran, 0) THEN 1 ELSE 0 END AS gagal_bayar, CASE WHEN COALESCE(p.jumlah_perkiraan, 0) < COALESCE(b.jumlah_pembayaran, 0) THEN 1 ELSE 0 END AS bayar_di_luar_jadwal')
            ->get();


            // dd($finalQuery);
            
            $kelompok_setoran = 0;
            $anggota_setoran = 0;
            $anggota_gagal_bayar = 0;
            $kelompok_gagal_bayar = 0;
            $anggota_setoran_diluar = 0;
            $kelompok_setoran_diluar = 0;
            $kelompok_aktif = 0;
            $anggota_aktif = 0;

            foreach($finalQuery as $set){
                $anggota_aktif = $anggota_aktif + $set->Jumlah_kelompok_aktif_hari_ini;
                $kelompok_aktif = $kelompok_aktif + 1;

                if($set->gagal_bayar > 0){
                    // $kelompok_setoran = $kelompok_setoran + 0;
                    $kelompok_setoran = $kelompok_setoran + 1;
                    $anggota_gagal_bayar = $anggota_gagal_bayar + ($set->Jumlah_kelompok_aktif_hari_ini - $set->Jumlah_kelompok_setoran_hari_ini);
                    $kelompok_gagal_bayar = $kelompok_gagal_bayar + 1;
                    // $anggota_setoran = $anggota_setoran + 0;
                    $anggota_setoran = $anggota_setoran + $set->Jumlah_kelompok_setoran_hari_ini;
                }else{
                    $kelompok_setoran = $kelompok_setoran + 1;
                    $anggota_gagal_bayar = $anggota_gagal_bayar + 0;
                    $kelompok_gagal_bayar = $kelompok_gagal_bayar + 0;
                    $anggota_setoran = $anggota_setoran + $set->Jumlah_kelompok_setoran_hari_ini;
                }
                
                if($set->bayar_di_luar_jadwal > 0){
                    $anggota_setoran_diluar = $anggota_setoran_diluar + $set->Jumlah_kelompok_aktif_hari_ini;
                    $kelompok_setoran_diluar = $kelompok_setoran_diluar + 1;
                }else{
                    $anggota_setoran_diluar = $anggota_setoran_diluar + 0;
                    $kelompok_setoran_diluar = $kelompok_setoran_diluar + 0;
                }

               
            }

            // $kelompok_setoran = 0;
            // $anggota_setoran = 0;
            // $anggota_gagal_bayar = 0;
            // $kelompok_gagal_bayar = 0;
            // $anggota_setoran_diluar = 0;
            // $kelompok_setoran_diluar = 0;
            // $kelompok_aktif = 0;
            // $anggota_aktif = 0;

            $cek = DB::table('lap_periode')->select('*')
            ->where('cabang', $cabang)
            ->where('tanggal', $tanggal)->get();

            if(count($cek) > 0){
                echo "update";
                $save = DB::table('lap_periode')
                ->where('cabang', $cabang)
                ->where('tanggal', $tanggal)
                ->update([
                    'kelompok_setoran' => $kelompok_setoran,
                    'anggota_setoran'        => $anggota_setoran,
                    'anggota_gagal_bayar'  => $anggota_gagal_bayar,
                    'kelompok_gagal_bayar' => $kelompok_gagal_bayar,
                    'anggota_setoran_diluar'        => $anggota_setoran_diluar,
                    'kelompok_setoran_diluar'  => $kelompok_setoran_diluar,
                    'kelompok_aktif' => $kelompok_aktif,
                    'anggota_aktif'  => $anggota_aktif
                ]);
            }else{
                echo "insert";
                $save = DB::table('lap_periode')->insert([
                    'cabang'        => $cabang,
                    'tanggal'  => $tanggal,
                    'kelompok_setoran' => $kelompok_setoran,
                    'anggota_setoran'        => $anggota_setoran,
                    'anggota_gagal_bayar'  => $anggota_gagal_bayar,
                    'kelompok_gagal_bayar' => $kelompok_gagal_bayar,
                    'anggota_setoran_diluar'        => $anggota_setoran_diluar,
                    'kelompok_setoran_diluar'  => $kelompok_setoran_diluar,
                    'kelompok_aktif' => $kelompok_aktif,
                    'anggota_aktif'  => $anggota_aktif
                ]);
            }
            

            
        // end query setoran 
    }
    
    public function pdfLaporanHarian(): View
    {
        $cabang = "0".$_GET["cabang"];
        $tanggal = $_GET["tanggal"];
        $nomor_hari = date('N', strtotime($tanggal));
        
        // query setoran 
        $perkiraanQuery = DB::connection('mysql_secondary')->table('kretrans as kt')
            ->selectRaw('k.kode_group1, COUNT(DISTINCT kt.NO_REKENING) AS jumlah_perkiraan')
            ->join('kredit as k', 'kt.NO_REKENING', '=', 'k.NO_REKENING')
            ->where('kt.MY_KODE_TRANS', 200);
            if ($cabang != 0) {
                $perkiraanQuery->where('k.kode_kantor', $cabang);
            }
            $perkiraanQuery = $perkiraanQuery->where('kt.TGL_TRANS', $tanggal)
            ->where(function ($query) use ($tanggal) { // Tambahkan 'use ($tanggal)'
                $query->where('k.pokok_saldo_akhir', '>', 0)
                    ->orWhereExists(function ($subquery) use ($tanggal) { // Tambahkan 'use ($tanggal)'
                        $subquery->select(DB::raw(1))
                            ->from('kretrans as kt2')
                            ->whereRaw('kt2.NO_REKENING = k.NO_REKENING')
                            ->where('kt2.TGL_TRANS', $tanggal)
                            ->where('kt2.MY_KODE_TRANS', 300);
                    });
            })
            ->groupBy('k.kode_group1');

        $pembayaranQuery = DB::connection('mysql_secondary')->table('kretrans as kt')
            ->selectRaw('k.kode_group1, COUNT(DISTINCT kt.NO_REKENING) AS jumlah_pembayaran')
            ->join('kredit as k', 'kt.NO_REKENING', '=', 'k.NO_REKENING')
            ->where('kt.MY_KODE_TRANS', 300);
            if ($cabang != 0) {
                $pembayaranQuery->where('k.kode_kantor', $cabang);
            }
            $pembayaranQuery = $pembayaranQuery->where('kt.TGL_TRANS', $tanggal)
            ->groupBy('k.kode_group1');

        $finalQuery = DB::connection('mysql_secondary')->query()->fromSub($perkiraanQuery, 'p')
            ->leftJoinSub($pembayaranQuery, 'b', 'p.kode_group1', '=', 'b.kode_group1')
            ->leftJoin('kre_kode_group1 as g', DB::raw('COALESCE(p.kode_group1, b.kode_group1)'), '=', 'g.kode_group1')
            ->selectRaw('g.deskripsi_group1, COALESCE(p.jumlah_perkiraan, 0) AS Jumlah_kelompok_aktif_hari_ini, COALESCE(b.jumlah_pembayaran, 0) AS Jumlah_kelompok_setoran_hari_ini, CASE WHEN COALESCE(p.jumlah_perkiraan, 0) > COALESCE(b.jumlah_pembayaran, 0) THEN 1 ELSE 0 END AS gagal_bayar, CASE WHEN COALESCE(p.jumlah_perkiraan, 0) < COALESCE(b.jumlah_pembayaran, 0) THEN 1 ELSE 0 END AS bayar_di_luar_jadwal')
            ->get();


            // dd($finalQuery);
            
            $kelompok_setoran = 0;
            $anggota_setoran = 0;
            $anggota_gagal_bayar = 0;
            $kelompok_gagal_bayar = 0;
            $anggota_setoran_diluar = 0;
            $kelompok_setoran_diluar = 0;
            $kelompok_aktif = 0;
            $anggota_aktif = 0;

            foreach($finalQuery as $set){
                $anggota_aktif = $anggota_aktif + $set->Jumlah_kelompok_aktif_hari_ini;
                $kelompok_aktif = $kelompok_aktif + 1;

                if($set->gagal_bayar > 0){
                    // $kelompok_setoran = $kelompok_setoran + 0;
                    $kelompok_setoran = $kelompok_setoran + 1;
                    $anggota_gagal_bayar = $anggota_gagal_bayar + ($set->Jumlah_kelompok_aktif_hari_ini - $set->Jumlah_kelompok_setoran_hari_ini);
                    $kelompok_gagal_bayar = $kelompok_gagal_bayar + 1;
                    // $anggota_setoran = $anggota_setoran + 0;
                    $anggota_setoran = $anggota_setoran + $set->Jumlah_kelompok_setoran_hari_ini;
                }else{
                    $kelompok_setoran = $kelompok_setoran + 1;
                    $anggota_gagal_bayar = $anggota_gagal_bayar + 0;
                    $kelompok_gagal_bayar = $kelompok_gagal_bayar + 0;
                    $anggota_setoran = $anggota_setoran + $set->Jumlah_kelompok_setoran_hari_ini;
                }
                
                if($set->bayar_di_luar_jadwal > 0){
                    $anggota_setoran_diluar = $anggota_setoran_diluar + $set->Jumlah_kelompok_aktif_hari_ini;
                    $kelompok_setoran_diluar = $kelompok_setoran_diluar + 1;
                }else{
                    $anggota_setoran_diluar = $anggota_setoran_diluar + 0;
                    $kelompok_setoran_diluar = $kelompok_setoran_diluar + 0;
                }

               
            }
        // end query setoran 

        $query_kumpulan_aktif = DB::connection('mysql_secondary')->table('kredit AS A')
                    ->selectRaw('COUNT(DISTINCT(A.kode_group3)) as total')
                    ->leftJoinSub(
                        DB::connection('mysql_secondary')
                            ->table('kretrans')
                            ->selectRaw('NO_REKENING, SUM(POKOK) AS total_pokok_terbayar')
                            ->where('MY_KODE_TRANS', 300)
                            ->where('TGL_TRANS', '<=', $tanggal)
                            ->groupBy('NO_REKENING'),
                        'pembayaran',
                        'A.NO_REKENING',
                        '=',
                        'pembayaran.NO_REKENING'
                    )
                    ->where('A.tgl_realisasi', '<=', $tanggal)
                    ->whereRaw('(A.jml_pinjaman - COALESCE(pembayaran.total_pokok_terbayar, 0)) > 0')
                    ->whereRaw('DAYOFWEEK(A.tgl_realisasi) - 1 = ?', [$nomor_hari]);
        
        $query_mk = DB::table('kelompok_bermasalah as A')
                    ->select('A.*')
                    ->where('A.tanggal_kb', $tanggal);

        $query_telat = DB::connection('mysql_secondary')->table('kretrans AS A')
                    ->selectRaw('COUNT(DISTINCT(A.kode_group1_trans)) as total')
                    ->where('A.KODE_TRANS', 300)
                    ->where('A.telat_per_berat', 1)
                    ->where('A.TGL_TRANS', $tanggal);

        $query_berat = DB::connection('mysql_secondary')->table('kretrans AS A')
                    ->selectRaw('COUNT(DISTINCT(A.kode_group1_trans)) as total')
                    ->where('A.KODE_TRANS', 300)
                    ->where('A.telat_per_berat', 2)
                    ->where('A.TGL_TRANS', $tanggal);


        $query_anggota_dtr = DB::connection('mysql_secondary')->table('kretrans AS A')
                    ->selectRaw('COUNT(A.KRETRANS_ID) as total')
                    ->where('A.KODE_TRANS', 300)
                    ->where('A.dtr', 'YA')
                    ->where('A.TGL_TRANS', $tanggal);

        $query_tab_pribadi = DB::connection('mysql_secondary')->table('kretrans AS A')
                    ->selectRaw('COUNT(A.KRETRANS_ID) as total, SUM(A.nominal_sukarela) as jumlah')
                    // ->where('A.MY_KODE_TRANS', 100)
                    ->whereIn('A.MY_KODE_TRANS', [300])
                    ->where('A.nominal_sukarela', '>', 0)
                    ->where('A.TGL_TRANS', $tanggal);

        $query_kelompok_cair = DB::connection('mysql_secondary')->table('kredit AS A')
                    ->selectRaw('COUNT(A.kode_group1) as total')
                    ->where('A.tgl_realisasi', $tanggal);
        
        $query_anggota_cair = DB::connection('mysql_secondary')->table('kredit AS A')
                    ->selectRaw('COUNT(A.nasabah_id) as total, SUM(A.jml_pinjaman) as jumlah')
                    ->where('A.tgl_realisasi', $tanggal);

        
        $query_anggota_btab = DB::connection('mysql_secondary')->table('tabtrans AS A')
                    ->join('tabung as B','A.NO_REKENING', '=', 'B.no_rekening')
                    ->selectRaw('COUNT(DISTINCT(A.NO_REKENING)) as total')
                    ->where('A.TGL_TRANS', $tanggal)
                    ->where('B.kode_integrasi', 204)
                    ->where('A.KODE_TRANS', 200);
                    
        
        $query_kelompok_btab = DB::connection('mysql_secondary')->table('tabtrans AS A')
                    ->join('tabung as B','A.NO_REKENING', '=', 'B.no_rekening')
                    ->selectRaw('COUNT(DISTINCT(A.kode_group1_trans)) as total')
                    ->where('A.TGL_TRANS', $tanggal)
                    ->where('B.kode_integrasi', 204)
                    ->where('A.KODE_TRANS', 200);

        $perkiraanQueryBaru = DB::connection('mysql_secondary')->table('kretrans as kt')
            ->distinct()
            ->select('kt.NO_REKENING', 'k.nasabah_id', 'k.kode_group1')
            ->join('kredit as k', 'kt.NO_REKENING', '=', 'k.NO_REKENING')
            ->where('kt.MY_KODE_TRANS', 200);
            if ($cabang != 0) {
                $perkiraanQueryBaru->where('k.kode_kantor', $cabang);
            }
            $perkiraanQueryBaru = $perkiraanQueryBaru->where('kt.TGL_TRANS', $tanggal)
            ->where(function ($query) use ($tanggal) {
                $query->where('k.pokok_saldo_akhir', '>', 0)
                    ->orWhereExists(function ($subquery) use ($tanggal) {
                        $subquery->select(DB::raw(1))
                            ->from('kretrans as kt2')
                            ->whereRaw('kt2.NO_REKENING = k.NO_REKENING')
                            ->where('kt2.MY_KODE_TRANS', 300)
                            ->where('kt2.TGL_TRANS', '>=', $tanggal);
                    });
            });
        $pembayaranQueryBaru = DB::connection('mysql_secondary')->table('kretrans as kt')
            ->distinct()
            ->select('kt.NO_REKENING', 'k.nasabah_id', 'k.kode_group1')
            ->join('kredit as k', 'kt.NO_REKENING', '=', 'k.NO_REKENING')
            ->where('kt.MY_KODE_TRANS', 300);
            if ($cabang != 0) {
                $pembayaranQueryBaru->where('k.kode_kantor', $cabang);
            }
            $pembayaranQueryBaru = $pembayaranQueryBaru->where('kt.TGL_TRANS', $tanggal);

        $cekMeninggalGagalBayarBaru = DB::connection('mysql_secondary')->query()->fromSub($perkiraanQueryBaru, 'p')
            ->join('kredit as k', 'p.NO_REKENING', '=', 'k.NO_REKENING')
            ->join('nasabah as n', 'k.nasabah_id', '=', 'n.nasabah_id')
            ->join('kre_kode_group1 as kg', 'k.kode_group1', '=', 'kg.kode_group1')
            ->leftJoinSub($pembayaranQueryBaru, 'b', 'p.NO_REKENING', '=', 'b.NO_REKENING')
            ->whereNull('b.NO_REKENING')
            ->selectRaw("p.NO_REKENING, k.nasabah_id, n.NAMA_NASABAH, kg.deskripsi_group1, 'Cek Meninggal/Gagal Bayar' AS Status");

        $bayarDiLuarJadwalBaru = DB::connection('mysql_secondary')->query()->fromSub($pembayaranQueryBaru, 'b')
            ->join('kredit as k', 'b.NO_REKENING', '=', 'k.NO_REKENING')
            ->join('nasabah as n', 'k.nasabah_id', '=', 'n.nasabah_id')
            ->join('kre_kode_group1 as kg', 'k.kode_group1', '=', 'kg.kode_group1')
            ->leftJoinSub($perkiraanQueryBaru, 'p', 'b.NO_REKENING', '=', 'p.NO_REKENING')
            ->whereNull('p.NO_REKENING')
            ->selectRaw("b.NO_REKENING, k.nasabah_id, n.NAMA_NASABAH, kg.deskripsi_group1, 'Bayar di luar jadwal' AS Status");
        $finalQueryBaru = $cekMeninggalGagalBayarBaru->union($bayarDiLuarJadwalBaru)->get();
        // dd($finalQueryBaru);

        if ($cabang != 0) {
            $query_kumpulan_aktif->where('A.kode_kantor', $cabang);
            // $query_kelompok_aktif->where('A.kode_kantor', $cabang);
            $query_mk->where('A.cabang_kb', $cabang);
            // $query_anggota_aktif->where('A.KODE_KANTOR', $cabang);
            $query_anggota_dtr->where('A.kode_kantor', $cabang);
            $query_tab_pribadi->where('A.kode_kantor', $cabang);
            $query_kelompok_cair->where('A.KODE_KANTOR', $cabang);
            $query_anggota_cair->where('A.KODE_KANTOR', $cabang);
            $query_anggota_btab->where('A.kode_kantor', $cabang);
            $query_kelompok_btab->where('A.kode_kantor', $cabang);
            $query_telat->where('A.kode_kantor', $cabang);
            $query_berat->where('A.kode_kantor', $cabang);
        }
        
                
        $kumpulan_aktif = $query_kumpulan_aktif->get();
        // $kelompok_aktif = $query_kelompok_aktif->get();
        $masalah_kelompok = $query_mk->get();
        // $anggota_aktif = $query_anggota_aktif->get();
        $anggota_dtr = $query_anggota_dtr->get();
        $tab_pribadi = $query_tab_pribadi->get();
        $kelompok_cair = $query_kelompok_cair->groupBy('A.kode_group1')->get();
        $anggota_cair = $query_anggota_cair->get();
        $kelompok_btab = $query_kelompok_btab->get();
        $anggota_btab = $query_anggota_btab->get();

        $anggota_telat = $query_telat->get();
        $anggota_berat = $query_berat->get();
        // dd(count($kelompok_cair));

        $mk_kurang_10menit = 0;
        $mk_lebih_10menit = 0;
       

        
        $data = [
            'menu' => 'Laporan Harian',
            'cabang' => $_GET["cabang"],
            'tanggal' => $tanggal,
            'anggota_gagal_bayar' => $anggota_gagal_bayar ?? 0,
            'kelompok_gagal_bayar' => $kelompok_gagal_bayar ?? 0,
            'anggota_setoran_diluar' => $anggota_setoran_diluar ?? 0,
            'kelompok_setoran_diluar' => $kelompok_setoran_diluar ?? 0,
            'kumpulan_aktif' => optional($kumpulan_aktif->first())->total ?? 0,
            'kelompok_aktif' => $kelompok_aktif ?? 0,
            'kelompok_setoran' => $kelompok_setoran ?? 0,
            'mk_kurang_10menit' => optional($anggota_telat->first())->total ?? 0,
            'mk_lebih_10menit' => optional($anggota_berat->first())->total ?? 0,
            'anggota_aktif' => $anggota_aktif ?? 0,
            'anggota_setoran' => $anggota_setoran ?? 0,
            'anggota_dtr' => optional($anggota_dtr->first())->total ?? 0,
            'penabung' => optional($tab_pribadi->first())->total ?? 0,
            'jumlah_tabungan' => optional($tab_pribadi->first())->jumlah ?? 0,
            'kelompok_cair' => count($kelompok_cair) ?? 0,
            'anggota_cair' => optional($anggota_cair->first())->total ?? 0,
            'jumlah_cair' => optional($anggota_cair->first())->jumlah ?? 0,
            'kelompok_btab' => optional($kelompok_btab->first())->total ?? 0,
            'anggota_btab' => optional($anggota_btab->first())->total ?? 0,
            'query_baru' => $finalQueryBaru
        ];

        return view('reporting.pdf-laporan-harian', $data);
    }

    
    public function pdfLaporanPeriode(): View
    {
        ini_set('max_execution_time', 300); // 5 menit
        $cabang = "0".$_GET["cabang"];
        $tanggal = $_GET["tanggal"];
        $p_tanggal = explode("to", $tanggal);
        

        // paling new 
        $data_lap = DB::table('lap_periode')->select('*');
        if ($cabang != 0) {
            $data_lap->where('cabang', $cabang);
        }
        $data_lap = $data_lap->whereBetween('tanggal', [$p_tanggal[0],$p_tanggal[1]])->get();
        // dd($data_lap);
        $kelompok_setoran = 0;
        $anggota_setoran = 0;
        $anggota_gagal_bayar = 0;
        $kelompok_gagal_bayar = 0;
        $anggota_setoran_diluar = 0;
        $kelompok_setoran_diluar = 0;
        foreach($data_lap as $lap)
        {
            $kelompok_setoran = $kelompok_setoran + $lap->kelompok_setoran;
            $anggota_setoran = $anggota_setoran + $lap->anggota_setoran;
            $anggota_gagal_bayar = $anggota_gagal_bayar + $lap->anggota_gagal_bayar;
            $kelompok_gagal_bayar = $kelompok_gagal_bayar + $lap->kelompok_gagal_bayar;
            $anggota_setoran_diluar = $anggota_setoran_diluar + $lap->anggota_setoran_diluar;
            $kelompok_setoran_diluar = $kelompok_setoran_diluar + $lap->kelompok_setoran_diluar;
        }
        // end paling new 


        

        
        $query_kelompok_aktif = DB::connection('mysql_secondary')->table('kredit AS A')
                    ->selectRaw('COUNT(DISTINCT(A.kode_group1)) as total')
                    ->leftJoinSub(
                        DB::connection('mysql_secondary')
                            ->table('kretrans')
                            ->selectRaw('NO_REKENING, SUM(POKOK) AS total_pokok_terbayar')
                            ->where('MY_KODE_TRANS', 300)
                            ->where('TGL_TRANS', '<=', $p_tanggal[1])
                            ->groupBy('NO_REKENING'),
                        'pembayaran',
                        'A.NO_REKENING',
                        '=',
                        'pembayaran.NO_REKENING'
                    )
                    ->where('A.tgl_realisasi', '<=', $p_tanggal[1])
                    ->whereRaw('(A.jml_pinjaman - COALESCE(pembayaran.total_pokok_terbayar, 0)) > 0');

        $query_kumpulan_aktif = DB::connection('mysql_secondary')->table('kredit AS A')
                    ->selectRaw('COUNT(DISTINCT(A.kode_group3)) as total')
                    ->leftJoinSub(
                        DB::connection('mysql_secondary')
                            ->table('kretrans')
                            ->selectRaw('NO_REKENING, SUM(POKOK) AS total_pokok_terbayar')
                            ->where('MY_KODE_TRANS', 300)
                            ->where('TGL_TRANS', '<=', $p_tanggal[1])
                            ->groupBy('NO_REKENING'),
                        'pembayaran',
                        'A.NO_REKENING',
                        '=',
                        'pembayaran.NO_REKENING'
                    )
                    ->where('A.tgl_realisasi', '<=', $p_tanggal[1])
                    ->whereRaw('(A.jml_pinjaman - COALESCE(pembayaran.total_pokok_terbayar, 0)) > 0');
        
        $query_mk = DB::table('kelompok_bermasalah as A')
            ->select('A.*')
            ->whereBetween('A.tanggal_kb', [$p_tanggal[0], $p_tanggal[1]]);

        $query_anggota_dtr = DB::connection('mysql_secondary')->table('kretrans AS A')
            ->selectRaw('COUNT(A.KRETRANS_ID) as total')
            ->where('A.KODE_TRANS', 300)
            ->where('A.dtr', 'YA')
            ->whereBetween('A.TGL_TRANS', [$p_tanggal[0], $p_tanggal[1]]);


        $query_jumlah_anggota_dtr_all = DB::connection('mysql_secondary')->table('kretrans AS A')
            ->selectRaw('COUNT(A.KRETRANS_ID) as total, A.NO_REKENING')
            ->where('A.KODE_TRANS', 300)
            ->where('A.dtr', 'YA')
            ->where('A.TGL_TRANS','<=', $p_tanggal[1]);
        
        $query_anggota_aktif = DB::connection('mysql_secondary')->table('kredit AS A')
            ->selectRaw('COUNT(DISTINCT(A.nasabah_id)) as total')
            ->leftJoinSub(
                DB::connection('mysql_secondary')
                    ->table('kretrans')
                    ->selectRaw('NO_REKENING, SUM(POKOK) AS total_pokok_terbayar')
                    ->where('MY_KODE_TRANS', 300)
                    ->where('TGL_TRANS', '<=', $p_tanggal[1])
                    ->groupBy('NO_REKENING'),
                'pembayaran',
                'A.NO_REKENING',
                '=',
                'pembayaran.NO_REKENING'
            )
            ->where('A.tgl_realisasi', '<=', $p_tanggal[1])
            ->whereRaw('(A.jml_pinjaman - COALESCE(pembayaran.total_pokok_terbayar, 0)) > 0');
        
        

        $query_kelompok_cair = DB::connection('mysql_secondary')->table('kredit AS A')
            ->selectRaw('COUNT(distinct(A.kode_group1)) as total')
            ->whereBetween('A.tgl_realisasi', [$p_tanggal[0], $p_tanggal[1]]);

        // $query_anggota_cair = DB::connection('mysql_secondary')->table('kredit AS A')
        //     ->selectRaw('COUNT(A.nasabah_id) as total, SUM(A.jml_pinjaman) as jumlah')
        //     ->whereBetween('A.tgl_realisasi', [$p_tanggal[0], $p_tanggal[1]]);

        $query_anggota_cair = DB::connection('mysql_secondary')->table(DB::raw('(
            SELECT nasabah_id, MAX(jml_pinjaman) AS jml_pinjaman, kode_kantor
            FROM kredit 
            WHERE tgl_realisasi BETWEEN ? AND ? 
            GROUP BY nasabah_id, kode_kantor
        ) AS distinct_kredit'))
        ->selectRaw('COUNT(nasabah_id) as total, SUM(jml_pinjaman) as jumlah')
        ->setBindings([$p_tanggal[0], $p_tanggal[1]]);

        $query_anggota_btab = DB::connection('mysql_secondary')->table('tabtrans AS A')
            ->join('tabung as B','A.NO_REKENING', '=', 'B.no_rekening')
            ->selectRaw('COUNT(DISTINCT(A.NO_REKENING)) as total')
            ->whereBetween('A.TGL_TRANS', [$p_tanggal[0], $p_tanggal[1]])
            ->where('B.kode_integrasi', 204)
            ->where('A.KODE_TRANS', 200);
            

        $query_kelompok_btab = DB::connection('mysql_secondary')->table('tabtrans AS A')
            ->join('tabung as B','A.NO_REKENING', '=', 'B.no_rekening')
            ->selectRaw('COUNT(DISTINCT(A.kode_group1_trans)) as total')
            ->whereBetween('A.TGL_TRANS', [$p_tanggal[0], $p_tanggal[1]])
            ->where('B.kode_integrasi', 204)
            ->where('A.KODE_TRANS', 200);
        
        $query_tab_pribadi = DB::connection('mysql_secondary')->table('kretrans AS A')
            ->selectRaw('COUNT(A.KRETRANS_ID) as total, SUM(A.nominal_sukarela) as jumlah')
            // ->where('A.MY_KODE_TRANS', 100)
            ->whereIn('A.MY_KODE_TRANS', [300])
            ->where('A.nominal_sukarela', '>', 0)
            ->whereBetween('A.TGL_TRANS', [$p_tanggal[0], $p_tanggal[1]]);


        $query_telat = DB::connection('mysql_secondary')->table('kretrans AS A')
            ->selectRaw('COUNT(DISTINCT(A.kode_group1_trans)) as total')
            ->where('A.KODE_TRANS', 300)
            ->where('A.telat_per_berat', 1)
            ->whereBetween('A.TGL_TRANS', [$p_tanggal[0], $p_tanggal[1]]);

        $query_berat = DB::connection('mysql_secondary')->table('kretrans AS A')
            ->selectRaw('COUNT(DISTINCT(A.kode_group1_trans)) as total')
            ->where('A.KODE_TRANS', 300)
            ->where('A.telat_per_berat', 2)
            ->whereBetween('A.TGL_TRANS', [$p_tanggal[0], $p_tanggal[1]]);

        

        if ($cabang != 0) {
            $query_kumpulan_aktif->where('A.kode_kantor', $cabang);
            $query_kelompok_aktif->where('A.kode_kantor', $cabang);
            // $query_kelompok_setoran->where('A.kode_kantor', $cabang);
            $query_mk->where('A.cabang_kb', $cabang);
            $query_anggota_aktif->where('A.KODE_KANTOR', $cabang);
            // $query_anggota_setoran->where('A.kode_kantor', $cabang);
            
            // $query_jumlah_anggota_dtr->where('A.kode_kantor', $cabang);
            $query_jumlah_anggota_dtr_all->where('A.kode_kantor', $cabang);
            $query_anggota_dtr->where('A.kode_kantor', $cabang);
            $query_tab_pribadi->where('A.kode_kantor', $cabang);
            $query_kelompok_cair->where('A.KODE_KANTOR', $cabang);
            $query_anggota_cair->where('KODE_KANTOR', $cabang);
            $query_anggota_btab->where('A.kode_kantor', $cabang);
            $query_kelompok_btab->where('A.kode_kantor', $cabang);
            $query_telat->where('A.kode_kantor', $cabang);
            $query_berat->where('A.kode_kantor', $cabang);
        }

        $kumpulan_aktif = $query_kumpulan_aktif->get();
        $kelompok_aktif = $query_kelompok_aktif->get();
        // $jumlah_anggota_dtr = $query_jumlah_anggota_dtr->groupBy('A.NO_REKENING')->get();
        $jumlah_anggota_dtr_all =  $query_jumlah_anggota_dtr_all->groupBy('A.NO_REKENING')->get();
        
        $masalah_kelompok = $query_mk->get();
        $anggota_aktif = $query_anggota_aktif->get();
        // $anggota_setoran = $query_anggota_setoran->get();
        $anggota_dtr = $query_anggota_dtr->get();
        $tab_pribadi = $query_tab_pribadi->get();
        $kelompok_cair = $query_kelompok_cair->get();
        $anggota_cair = $query_anggota_cair->get();
        $kelompok_btab = $query_kelompok_btab->get();
        $anggota_btab = $query_anggota_btab->get();
        $kelompok_telat = $query_telat->get();
        $kelompok_berat = $query_berat->get();
        $mk_kurang_10menit = 0;
        $mk_lebih_10menit = 0;
        foreach($masalah_kelompok as $mk){
            if($mk->menit_kb > 10){
                $mk_lebih_10menit = $mk_lebih_10menit+1;
            }else{
                $mk_kurang_10menit = $mk_kurang_10menit+1;
            }
        }

      

        $dtr_1_all = 0;
        $dtr_23_all = 0;
        $dtr_4_all = 0;

        foreach($jumlah_anggota_dtr_all as $dtr_all){
            if($dtr_all->total = 1){
                $dtr_1_all = $dtr_1_all+1;
            }else if($dtr_all->total > 1 && $dtr_all->total < 4){
                $dtr_23_all = $dtr_23_all+1;
            }else{
                $dtr_4_all = $dtr_4_all+1;
            }
        }

        $query_dtr = DB::connection('mysql_secondary')->table('kretrans as A')
                ->select('D.deskripsi_group2', 'C.NAMA_NASABAH', 'A.NO_REKENING')
                ->join('kredit as B', 'A.NO_REKENING', '=', 'B.no_rekening')
                ->join('nasabah as C', 'C.nasabah_id', '=', 'B.nasabah_id')
                ->join('kre_kode_group2 as D', 'A.kode_group2_trans', '=', 'D.kode_group2')
                ->where('A.KODE_TRANS', 300)
                ->where('A.dtr', 'Ya')
                ->whereBetween('A.TGL_TRANS', [$p_tanggal[0], $p_tanggal[1]])
                ->where('A.kode_kantor', '!=', 00);

            if ($cabang != 0) {
                $query_dtr->where('A.kode_kantor', $cabang);
            }

            $filteredData = $query_dtr->get();

            // Hitung jumlah dtr_ke di seluruh dataset
            $totalDtr1 = 0;
            $totalDtr23 = 0;
            $totalDtr4 = 0;

            foreach ($filteredData as $row) {
                $total_dtr = DB::connection('mysql_secondary')->table('kretrans as A')
                    ->where('A.KODE_TRANS', 300)
                    ->where('A.dtr', 'Ya')
                    ->where('A.NO_REKENING', $row->NO_REKENING)
                    ->count();

                if ($total_dtr == 1) {
                    $totalDtr1++;
                } elseif ($total_dtr > 1 && $total_dtr < 4) {
                    $totalDtr23++;
                } elseif ($total_dtr > 3) {
                    $totalDtr4++;
                }
            }


        

        $data = [
            'menu' => 'Laporan Periode',
            'cabang' => $cabang,
            'tanggal' => $tanggal,
            'awal' => $p_tanggal[0],
            'akhir' => $p_tanggal[1],
            'anggota_gagal_bayar' => $anggota_gagal_bayar ?? 0,
            'kelompok_gagal_bayar' => $kelompok_gagal_bayar ?? 0,
            'anggota_setoran_diluar' => $anggota_setoran_diluar ?? 0,
            'kelompok_setoran_diluar' => $kelompok_setoran_diluar ?? 0,
            'kelompok_aktif' => $kelompok_aktif[0]->total,
            'kumpulan_aktif' => $kumpulan_aktif[0]->total,
            'mk_kurang_10menit' => $mk_kurang_10menit,
            'mk_lebih_10menit' => $mk_lebih_10menit,
            'anggota_dtr' => $anggota_dtr[0]->total,
            'anggota_aktif' => $anggota_aktif[0]->total,
            'kelompok_cair' => $kelompok_cair[0]->total,
            'anggota_cair' => $anggota_cair[0]->total,
            'jumlah_cair' => $anggota_cair[0]->jumlah,
            'kelompok_btab' => $kelompok_btab[0]->total,
            'anggota_btab' => $anggota_btab[0]->total,
            'penabung' => $tab_pribadi[0]->total,
            'jumlah_tabungan' => $tab_pribadi[0]->jumlah,
            'anggota_setoran' => $anggota_setoran ?? 0,
            'kelompok_setoran' => $kelompok_setoran ?? 0,
            'kelompok_telat' => $kelompok_telat[0]->total,
            'kelompok_berat' => $kelompok_berat[0]->total,
            'dtr_1' => $totalDtr1,
            'dtr_23' => $totalDtr23,
            'dtr_4' => $totalDtr4,
            'dtr_1_all' => $dtr_1_all,
            'dtr_23_all' => $dtr_23_all,
            'dtr_4_all' => $dtr_4_all,
            
        ];
        
        return view('reporting.pdf-laporan-periode', $data);
    }

    public function getLaporanRangkumanAb(Request $request)
    {
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::table('anggota_bermasalah as A')
                ->select(
                    'A.cabang_ab',
                    DB::raw('COUNT(A.id_ab) as jumlah'),
                    DB::raw('SUM(IF(A.kode_ab = "2", 1, 0)) AS kode2'),
                    DB::raw('SUM(IF(A.kode_ab = "4A", 1, 0)) AS kode4a'),
                    DB::raw('SUM(IF(A.kode_ab = "4B", 1, 0)) AS kode4b')
                )
                ->whereBetween('A.tanggal_ab', [$awal, $akhir]);

            $filteredData = $query->groupBy('A.cabang_ab') 
                ->orderBy('A.cabang_ab', 'asc')
                ->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-history btn-sm" data-id="' . $row->cabang_ab . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getLaporanRangkumanKb(Request $request)
    {
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::table('kelompok_bermasalah as A')
                ->select(
                    'A.cabang_kb',
                    DB::raw('COUNT(A.id_kb) as jumlah'),
                    DB::raw('SUM(IF(A.kode_kb = "3A", 1, 0)) AS telat'),
                    DB::raw('SUM(IF(A.kode_kb = "3B", 1, 0)) AS berat')
                )
                ->whereBetween('A.tanggal_kb', [$awal, $akhir]);

            $filteredData = $query->groupBy('A.cabang_kb') 
                ->orderBy('A.cabang_kb', 'asc')
                ->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-history btn-sm" data-id="' . $row->cabang_kb . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function exportDownloadRangkumanMasalah(Request $request)
    {
        $daterange = $request->input('daterange');
        $p_date = explode("to", $daterange);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date

        $data = DB::table('kelompok_bermasalah as A')
        ->select(
            'A.cabang_kb',
            DB::raw('COUNT(A.id_kb) as jumlah'),
            DB::raw('SUM(IF(A.kode_kb = "3A", 1, 0)) AS telat'),
            DB::raw('SUM(IF(A.kode_kb = "3B", 1, 0)) AS berat')
        )
        ->whereBetween('A.tanggal_kb', [$awal, $akhir])
        ->groupBy('A.cabang_kb') 
        ->orderBy('A.cabang_kb', 'asc')
        ->get();

        $data2 = DB::table('anggota_bermasalah as A')
        ->select(
            'A.cabang_ab',
            DB::raw('COUNT(A.id_ab) as jumlah'),
            DB::raw('SUM(IF(A.kode_ab = "2", 1, 0)) AS kode2'),
            DB::raw('SUM(IF(A.kode_ab = "4A", 1, 0)) AS kode4a'),
            DB::raw('SUM(IF(A.kode_ab = "4B", 1, 0)) AS kode4b')
        )
        ->whereBetween('A.tanggal_ab', [$awal, $akhir])
        ->groupBy('A.cabang_ab') 
        ->orderBy('A.cabang_ab', 'asc')
        ->get();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header columns
        $sheet->setCellValue('A1', 'Cabang')
            ->setCellValue('B1', 'Jml Anggota DTR')
            ->setCellValue('C1', 'Kode 2')
            ->setCellValue('D1', 'Kode 4A')
            ->setCellValue('E1', 'Kode 4B');

        $row = 2; // Start from row 2 after the header
        $jumlah = 0;
        $jum_kode2 = 0;
        $jum_kode4a = 0;
        $jum_kode4b = 0;
        foreach ($data2 as $user) {
            
            $sheet->setCellValue('A' . $row, $user->cabang_ab)
                ->setCellValue('B' . $row, $user->jumlah ?? '')
                ->setCellValue('C' . $row, $user->kode2 ?? '')
                ->setCellValue('D' . $row, $user->kode4a ?? '' ?? '')
                ->setCellValue('E' . $row, $user->kode4b ?? '');

            $jumlah = $jumlah + $user->jumlah;
            $jum_kode2 = $jum_kode2 + $user->kode2;
            $jum_kode4a = $jum_kode4a + $user->kode4a;
            $jum_kode4b = $jum_kode4b + $user->kode4b;

            $row++;
        }

        $sheet->setCellValue('A' . $row, 'Total')
            ->setCellValue('B' . $row, $jumlah)
            ->setCellValue('C' . $row, $jum_kode2)
            ->setCellValue('D' . $row, $jum_kode4a)
            ->setCellValue('E' . $row, $jum_kode4b);

        $row2 = $row + 4;
        $sheet->setCellValue('A' . $row2, 'Cabang')
            ->setCellValue('B' . $row2, 'Jml Kelompok')
            ->setCellValue('C' . $row2, 'Telat')
            ->setCellValue('D' . $row2, 'Berat');

        $row2 = $row2 + 1;
        $jumlah2 = 0;
        $jum_telat = 0;
        $jum_berat = 0;
        foreach ($data as $d) {
            
            $sheet->setCellValue('A' . $row2, $d->cabang_kb)
                ->setCellValue('B' . $row2, $d->jumlah ?? '')
                ->setCellValue('C' . $row2, $d->telat ?? '')
                ->setCellValue('D' . $row2, $d->berat ?? '' ?? '');

            $jumlah2 = $jumlah2 + $d->jumlah;
            $jum_telat = $jum_telat + $d->telat;
            $jum_berat = $jum_berat + $d->berat;
            $row2++;
        }
        $sheet->setCellValue('A' . $row2, 'Total')
            ->setCellValue('B' . $row2, $jumlah2)
            ->setCellValue('C' . $row2, $jum_telat)
            ->setCellValue('D' . $row2, $jum_berat);

        $writer = new Xlsx($spreadsheet);

        $filename = 'Rangkuman_anggota_dan_kelompok_bermasalah.xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }
    
    public function pdfLaporanRangkuman(): View
    {
        $tanggal = $_GET["daterange"];
        $p_tanggal = explode("to", $tanggal);
        $list_ab = DB::table('anggota_bermasalah as A')
            ->select(
                'A.cabang_ab',
                DB::raw('COUNT(A.id_ab) as jumlah'),
                DB::raw('SUM(IF(A.kode_ab = "2", 1, 0)) AS kode2'),
                DB::raw('SUM(IF(A.kode_ab = "4A", 1, 0)) AS kode4a'),
                DB::raw('SUM(IF(A.kode_ab = "4B", 1, 0)) AS kode4b')
            )
            ->whereBetween('A.tanggal_ab', [$p_tanggal[0], $p_tanggal[1]])
            ->groupBy('A.cabang_ab') 
            ->orderBy('A.cabang_ab', 'asc')
            ->get();

        $list_kb = DB::table('kelompok_bermasalah as A')
            ->select(
                'A.cabang_kb',
                DB::raw('COUNT(A.id_kb) as jumlah'),
                DB::raw('SUM(IF(A.kode_kb = "3A", 1, 0)) AS telat'),
                DB::raw('SUM(IF(A.kode_kb = "3B", 1, 0)) AS berat')
            )
            ->whereBetween('A.tanggal_kb', [$p_tanggal[0], $p_tanggal[1]])
            ->groupBy('A.cabang_kb') 
            ->orderBy('A.cabang_kb', 'asc')
            ->get();


        $data = [
            'menu' => 'Laporan Periode',
            'tanggal' => $tanggal,
            'awal' => $p_tanggal[0],
            'akhir' => $p_tanggal[1],
            'list_ab' => $list_ab,
            'list_kb' => $list_kb
            
        ];
        
        return view('reporting.pdf-laporan-rangkuman', $data);
    }

    
    public function getMasalahCabangAb(Request $request)
    {
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $cabang = $request->input('cabang');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::table('anggota_bermasalah as A')
                ->select('A.*')
                ->whereBetween('A.tanggal_ab', [$awal, $akhir]);
            
            if($cabang != 0){
                $query->where('A.cabang_ab', $cabang);
            }

            $filteredData = $query->orderBy('A.cabang_ab', 'asc')
                ->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-history btn-sm" data-id="' . $row->cabang_ab . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                ->addColumn('dtr', function ($row) {
                    $data_dtr = DB::table('anggota_bermasalah as A')
                        ->select(
                            'A.id_anggota_ab',
                            DB::raw('COUNT(A.id_ab) as jumlah'),
                            DB::raw('SUM(IF(A.kode_ab = "2", 1, 0)) AS kode2'),
                            DB::raw('SUM(IF(A.kode_ab = "4A", 1, 0)) AS kode4a'),
                            DB::raw('SUM(IF(A.kode_ab = "4B", 1, 0)) AS kode4b')
                        )
                        ->where('A.id_anggota_ab', $row->id_anggota_ab)
                        ->groupBy('A.id_anggota_ab')
                        ->first();
                            

                    $dtr = '<span class="badge badge-success">Kode 2: '.$data_dtr->kode2.'</span><br>
                            <span class="badge badge-warning">Kode 4A: '.$data_dtr->kode4a.'</span><br>
                            <span class="badge badge-danger">Kode 4B: '.$data_dtr->kode4b.'</span>';
                    return $dtr;
                })
                

                ->rawColumns(['action','dtr'])
                ->make(true);
        }
    }

    
    public function getMasalahCabangKb(Request $request)
    {
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $cabang = $request->input('cabang');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::table('kelompok_bermasalah as A')
                ->join('data_kb as B', 'B.kelompok_dkb', '=', 'A.kelompok_kb')
                ->select('A.*','B.pkp_dkb','B.kc_dkb')
                ->whereBetween('A.tanggal_kb', [$awal, $akhir]);

            if($cabang != 0){
                $query->where('A.cabang_kb', $cabang);
            }

            $filteredData = $query->orderBy('A.cabang_kb', 'asc')
                ->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-history btn-sm" data-id="' . $row->cabang_kb . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                ->addColumn('history', function ($row) {
                    $data_dtr = DB::table('kelompok_bermasalah as A')
                        ->select(
                            'A.kelompok_kb',
                            DB::raw('SUM(IF(A.kode_kb = "3A", 1, 0)) AS telat'),
                            DB::raw('SUM(IF(A.kode_kb = "4B", 1, 0)) AS berat')
                        )
                        ->where('A.kelompok_kb', $row->kelompok_kb)
                        ->groupBy('A.kelompok_kb')
                        ->first();
                            

                    $dtr = '<span class="badge badge-warning">Telat: '.$data_dtr->telat.'</span><br>
                            <span class="badge badge-danger">Berat: '.$data_dtr->berat.'</span>';
                    return $dtr;
                })
                

                ->rawColumns(['action','history'])
                ->make(true);
        }
    }

    
    public function exportDownloadMasalahPerCabang(Request $request)
    {
        $daterange = $request->input('daterange');
        $p_date = explode("to", $daterange);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date
        $cabang = $request->input('cabang');

        $data = DB::table('kelompok_bermasalah as A')
            ->join('data_kb as B', 'B.kelompok_dkb', '=', 'A.kelompok_kb')
            ->select('A.*','B.pkp_dkb','B.kc_dkb')
            ->whereBetween('A.tanggal_kb', [$awal, $akhir]);
        if($cabang != 0){
            $data->where('A.cabang_kb', $cabang);
        }
        $data = $data->orderBy('A.cabang_kb', 'asc')->get();

        
        $data2 = DB::table('anggota_bermasalah as A')
            ->select('A.*')
            ->whereBetween('A.tanggal_ab', [$awal, $akhir]);
        if($cabang != 0){
            $data2->where('A.cabang_ab', $cabang);
        }
        $data2 = $data2->orderBy('A.cabang_ab', 'asc')->get();

        


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header columns
        $sheet->setCellValue('A1', 'Tanggal')
            ->setCellValue('B1', 'Cabang')
            ->setCellValue('C1', 'Kelompok')
            ->setCellValue('D1', 'Set Ke-')
            ->setCellValue('E1', 'Kode')
            ->setCellValue('F1', 'Menit Telat')
            ->setCellValue('G1', 'PKP Proses')
            ->setCellValue('H1', 'KC Proses')
            ->setCellValue('I1', 'Telat')
            ->setCellValue('J1', 'Berat');

        $row = 2; // Start from row 2 after the header
       
        foreach ($data as $user) {
            
            $mk = DB::table('kelompok_bermasalah as A')->select(
                    DB::raw('SUM(IF(A.kode_kb = "3A", 1, 0)) AS telat'),
                    DB::raw('SUM(IF(A.kode_kb = "3B", 1, 0)) AS berat')
                )
            ->where('A.kelompok_kb', $user->kelompok_kb)
            ->first();


            $sheet->setCellValue('A' . $row, $user->tanggal_kb)
                ->setCellValue('B' . $row, $user->cabang_kb ?? '')
                ->setCellValue('C' . $row, $user->kelompok_kb ?? '')
                ->setCellValue('D' . $row, $user->setoran_kb ?? '' ?? '')
                ->setCellValue('E' . $row, $user->kode_kb ?? '')
                ->setCellValue('F' . $row, $user->menit_kb ?? '')
                ->setCellValue('G' . $row, $user->pkp_dkb ?? '')
                ->setCellValue('H' . $row, $user->kc_dkb ?? '')
                ->setCellValue('I' . $row, $mk->telat ?? '0')
                ->setCellValue('J' . $row, $mk->berat ?? '0');

            $row++;
        }

        $row2 = $row + 3;
        $sheet->setCellValue('A' . $row2, 'Tanggal')
            ->setCellValue('B' . $row2, 'ID')
            ->setCellValue('C' . $row2, 'Anggota')
            ->setCellValue('D' . $row2, 'Kelompok')
            ->setCellValue('E' . $row2, 'Cabang')
            ->setCellValue('F' . $row2, 'DTR')
            ->setCellValue('G' . $row2, 'Set Ke-')
            ->setCellValue('H' . $row2, 'Menit Telat')
            ->setCellValue('I' . $row2, '2')
            ->setCellValue('J' . $row2, '4A')
            ->setCellValue('K' . $row2, '4B');

        $row2 = $row2 + 1;
        
        foreach ($data2 as $d) {
            $ma = DB::table('anggota_bermasalah as A')
                ->select(
                    DB::raw('SUM(IF(A.kode_ab = "2", 1, 0)) AS kode2'),
                    DB::raw('SUM(IF(A.kode_ab = "4A", 1, 0)) AS kode4a'),
                    DB::raw('SUM(IF(A.kode_ab = "4B", 1, 0)) AS kode4b')
                )
                ->where('A.id_anggota_ab', $d->id_anggota_ab)
                ->first();
            
            $sheet->setCellValue('A' . $row2, $d->tanggal_ab)
                ->setCellValue('B' . $row2, $d->id_anggota_ab ?? '')
                ->setCellValue('C' . $row2, $d->nama_ab ?? '')
                ->setCellValue('D' . $row2, $d->kelompok_ab ?? '' ?? '')
                ->setCellValue('E' . $row2, $d->cabang_ab ?? '' ?? '')
                ->setCellValue('F' . $row2, $d->kode_ab ?? '' ?? '')
                ->setCellValue('G' . $row2, $d->setoran_ab ?? '' ?? '')
                ->setCellValue('H' . $row2, $d->menit_ab ?? '' ?? '')
                ->setCellValue('I' . $row2, $ma->kode2 ?? '' ?? '0')
                ->setCellValue('J' . $row2, $ma->kode4a ?? '' ?? '0')
                ->setCellValue('K' . $row2, $ma->kode4b ?? '' ?? '0');

            
            $row2++;
        }
        

        $writer = new Xlsx($spreadsheet);

        $filename = 'Masalah_per_cabang.xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }

    
    public function pdfMasalahPerCabangAction(): View
    {
        $tanggal = $_GET["daterange"];
        $cabang = $_GET["cabang"];
        $p_tanggal = explode("to", $tanggal);
        $list_ab = DB::table('anggota_bermasalah as A')
            ->leftJoin('pkp as B', 'B.id', '=', 'A.pkp_ab')
            ->select('A.*','B.nama')
            ->whereBetween('A.tanggal_ab', [$p_tanggal[0], $p_tanggal[1]]);
        if($cabang != 0){
            $list_ab->where('A.cabang_ab', $cabang);
        }
        $list_ab = $list_ab->orderBy('A.cabang_ab', 'asc')->get();

        foreach ($list_ab as $ab) {
            $detail_ab = DB::table('anggota_bermasalah as A')
                ->select(
                    DB::raw('SUM(IF(A.kode_ab = "2", 1, 0)) AS kode2'),
                    DB::raw('SUM(IF(A.kode_ab = "4A", 1, 0)) AS kode4a'),
                    DB::raw('SUM(IF(A.kode_ab = "4B", 1, 0)) AS kode4b')
                )
                ->where('A.id_anggota_ab', $ab->id_anggota_ab)
                ->first();
            
            if ($detail_ab) {
                $ab->kode2 = $detail_ab->kode2; 
                $ab->kode4a = $detail_ab->kode4a;
                $ab->kode4b = $detail_ab->kode4b;
            }
        }


        $list_kb = DB::table('kelompok_bermasalah as A')
            ->leftJoin('data_kb as B', 'B.kelompok_dkb', '=', 'A.kelompok_kb')
            ->leftJoin('pkp as C', 'C.id', '=', 'A.pkp_kb')
            ->select('A.*','B.pkp_dkb','B.kc_dkb','C.nama')
            ->whereBetween('A.tanggal_kb', [$p_tanggal[0], $p_tanggal[1]]);
        if($cabang != 0){
            $list_kb->where('A.cabang_kb', $cabang);
        }
        $list_kb = $list_kb->orderBy('A.cabang_kb', 'asc')->get();

        $jum_telat = 0;
        $jum_berat = 0;
        foreach ($list_kb as $kb) {
            $detail_kb =  DB::table('kelompok_bermasalah as A')->select(
                    DB::raw('SUM(IF(A.kode_kb = "3A", 1, 0)) AS telat'),
                    DB::raw('SUM(IF(A.kode_kb = "3B", 1, 0)) AS berat')
                )
                ->where('A.kelompok_kb', $kb->kelompok_kb)
                ->first();
            
            if ($detail_kb) {
                $kb->telat = $detail_kb->telat; 
                $kb->berat = $detail_kb->berat;
            }
            $jum_telat = $jum_telat+$detail_kb->telat;
            $jum_berat = $jum_berat+$detail_kb->berat;
        }


        if($cabang == 0){
            $cbg = 'SEMUA';
        }else{
            $cbg = $cabang;
        }

        $data = [
            'menu' => 'Laporan Periode',
            'tanggal' => $tanggal,
            'awal' => $p_tanggal[0],
            'akhir' => $p_tanggal[1],
            'list_ab' => $list_ab,
            'list_kb' => $list_kb,
            'total_ab' => COUNT($list_ab),
            'total_kb' => COUNT($list_kb),
            'cabang' => $cbg,
            'jum_telat' => $jum_telat,
            'jum_berat' => $jum_berat
            
        ];
        
        return view('reporting.pdf-laporan-masalah-cabang', $data);
    }

    
    public function getDataTableKompilasi(Request $request)
    {
        ini_set('max_execution_time', 300); // 5 menit
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $cabang = "0".$request->input('cabang');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            

            $query = DB::connection('mysql_secondary')->table('kredit as A')
                ->select(
                    'A.KODE_KANTOR',
                    DB::raw('(SELECT COUNT(DISTINCT B.kode_group1) FROM kredit B WHERE B.KODE_KANTOR = A.KODE_KANTOR AND B.tgl_realisasi BETWEEN "'.$awal.'" AND "'.$akhir.'" ) as kelompok_cair'),
                    DB::raw('(select COUNT(distinct(kode_group1)) from kredit B inner join kretrans C on C.NO_REKENING = B.no_rekening where B.KODE_KANTOR = A.KODE_KANTOR and C.TGL_TRANS BETWEEN "'.$awal.'" AND "'.$akhir.'" and C.ANGSURAN_KE = B.jml_angsuran and C.KODE_TRANS = 300) as kelompok_btab'),
                    DB::raw('(select count(TABTRANS_ID) from tabtrans B where B.KODE_TRANS = 113 and B.kode_kantor = A.KODE_KANTOR and B.TGL_TRANS between "'.$awal.'" AND "'.$akhir.'" and B.KETERANGAN like "%Setor Tab. Sukarela%") as tab_lapangan'),
                    DB::raw('(select count(TABTRANS_ID) from tabtrans B where B.KODE_TRANS in ("200") and B.kode_kantor = A.KODE_KANTOR and TGL_TRANS between "'.$awal.'" AND "'.$akhir.'" and MY_KODE_TRANS = 100) as tab_kantor'),
                    DB::raw('(select count(TABTRANS_ID) from tabtrans B where B.KODE_TRANS in ("200") and B.kode_kantor = A.KODE_KANTOR and TGL_TRANS between "'.$awal.'" AND "'.$akhir.'" and MY_KODE_TRANS = 200) as ambil_tab'),
                    DB::raw('(SELECT count(C.nasabah_id) FROM kredit AS AA
                            LEFT JOIN (
                                SELECT 
                                    NO_REKENING, 
                                    SUM(POKOK) AS total_pokok_terbayar
                                FROM kretrans
                                WHERE MY_KODE_TRANS = 300 
                                AND TGL_TRANS <= "'.$akhir.'"
                                GROUP BY NO_REKENING
                            ) AS pembayaran ON AA.NO_REKENING = pembayaran.NO_REKENING
                            JOIN kre_kode_group1 AS B ON B.kode_group1 = AA.kode_group1
                            JOIN nasabah AS C ON C.nasabah_id = AA.nasabah_id
                            WHERE AA.tgl_realisasi <= "'.$akhir.'"
                            AND AA.KODE_KANTOR = A.KODE_KANTOR
                            AND (AA.jml_pinjaman - COALESCE(pembayaran.total_pokok_terbayar, 0)) > 0) as anggota_aktif'),
                    DB::raw('(select count(B.KRETRANS_ID) from kretrans B where B.KODE_KANTOR = A.KODE_KANTOR and B.KODE_TRANS = 300 and B.dtr = "Ya" and B.TGL_TRANS between "'.$awal.'" AND "'.$akhir.'") as dtr'),
                    DB::raw('(select count(distinct(B.kode_group1_trans)) from kretrans B where B.KODE_KANTOR = A.KODE_KANTOR and B.KODE_TRANS = 300 and B.telat_per_berat = 1 and B.TGL_TRANS between "'.$awal.'" AND "'.$akhir.'") as kel_telat'),
                    DB::raw('(select count(distinct(B.kode_group1_trans)) from kretrans B where B.KODE_KANTOR = A.KODE_KANTOR and B.KODE_TRANS = 300 and B.telat_per_berat = 2 and B.TGL_TRANS between "'.$awal.'" AND "'.$akhir.'") as kel_berat')
                )
                ->where('A.KODE_KANTOR', '!=', 00);
                // telat_per_berat
            if($cabang != 0){
                $query->where('A.KODE_KANTOR', $cabang);
            }
            $filteredData = $query->groupBy('A.KODE_KANTOR') 
                ->orderBy('A.KODE_KANTOR', 'asc')
                ->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('kel_telat_old', function ($row) use ($awal, $akhir) {
                    $cbg = substr($row->KODE_KANTOR, -1);

                    $telat = DB::table('kelompok_bermasalah as A')
                            ->select(DB::raw('COUNT(A.id_kb) as jumlah'))
                            ->whereBetween('A.tanggal_kb', [$awal, $akhir])
                            ->where('A.cabang_kb', $cbg)
                            ->where('A.kode_kb', '3A')
                            ->first();
                    return $telat->jumlah;
                })
                ->addColumn('kel_berat_old', function ($row) use ($awal, $akhir) {
                    $cbg = substr($row->KODE_KANTOR, -1);

                    $berat = DB::table('kelompok_bermasalah as A')
                            ->select(DB::raw('COUNT(A.id_kb) as jumlah'))
                            ->whereBetween('A.tanggal_kb', [$awal, $akhir])
                            ->where('A.cabang_kb', $cbg)
                            ->where('A.kode_kb', '3B')
                            ->first();
                    return $berat->jumlah;
                })
                

                ->rawColumns(['kel_telat_old','kel_berat_old'])
                ->make(true);
        }
    }

    
    public function getDataTableRAKompilasi(Request $request)
    {
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $cabang = "0".$request->input('cabang');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::connection('mysql_secondary')->table('kredit as A')
                ->selectraw('AA.deskripsi_group2, count(A.nasabah_id) as anggota_aktif, count(distinct(A.kode_group3)) as kumpulan_aktif, count(distinct(A.kode_group1)) as kelompok_aktif')
                ->join('kre_kode_group2 as AA', 'A.kode_group2','=','AA.kode_group2')
                ->join('kre_kode_group1 as B', 'A.kode_group2','=','B.kode_group1')
                ->leftJoinSub(
                    DB::connection('mysql_secondary')
                        ->table('kretrans')
                        ->selectRaw('NO_REKENING, SUM(POKOK) AS total_pokok_terbayar')
                        ->where('MY_KODE_TRANS', 300)
                        ->where('TGL_TRANS', '<=', $akhir)
                        ->groupBy('NO_REKENING'),
                    'pembayaran',
                    'A.NO_REKENING',
                    '=',
                    'pembayaran.NO_REKENING'
                )
                ->whereRaw('(A.jml_pinjaman - COALESCE(pembayaran.total_pokok_terbayar, 0)) > 0')
                ->where('A.tgl_realisasi', '<=', $akhir)
                ->where('A.KODE_KANTOR', '!=', 00);

                if($cabang != 0){
                    $query->where('A.KODE_KANTOR', $cabang);
                }
                $filteredData = $query->groupBy('AA.deskripsi_group2', 'A.kode_group2') 
                    ->orderBy('AA.deskripsi_group2', 'asc')
                    ->get();
                // dd($filteredData);
            

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('kel_telat', function ($row) use ($awal, $akhir) {
                    
                    return 'h';
                })
                
                

                ->rawColumns(['kel_telat'])
                ->make(true);
        }
    }

    
    public function getDataTableRTKompilasi(Request $request)
    {
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $cabang = "0".$request->input('cabang');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::connection('mysql_secondary')->table('kre_kode_group2 as A')
            ->select(
                'A.deskripsi_group2',
                DB::raw('(select COUNT(B.KRETRANS_ID) from kretrans B where B.kode_group2_trans = A.kode_group2 and B.KODE_TRANS = "300" AND B.nominal_sukarela > 0 AND B.TGL_TRANS BETWEEN "'.$awal.'" and "'.$akhir.'") as anggota_tabung'),
                DB::raw('(select SUM(B.nominal_sukarela) from kretrans B where B.kode_group2_trans = A.kode_group2 and B.KODE_TRANS = "300" AND B.nominal_sukarela > 0 AND B.TGL_TRANS BETWEEN "'.$awal.'" and "'.$akhir.'") as total_tabung')
            )
            ->where('A.kode_kantor', '!=', 00);
        
            if ($cabang != 0) {
                $query->where('A.kode_kantor', $cabang);
            }
            
            $filteredData = $query->get();


            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('kel_telat', function ($row) use ($awal, $akhir) {
                    
                    return 'h';
                })
                
                

                ->rawColumns(['kel_telat'])
                ->make(true);
        }
    }

    
    public function getDataTableRMasalahKelompok(Request $request)
    {
        ini_set('max_execution_time', 300); // 5 menit
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $cabang = "0".$request->input('cabang');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::connection('mysql_secondary')->table('kretrans as A')
                ->select('B.deskripsi_group2','C.deskripsi_group1','A.telat_per_berat','A.menit_telat_per_berat','A.kode_group1_trans')
                ->join('kre_kode_group2 as B', 'A.kode_group2_trans','=','B.kode_group2')
                ->join('kre_kode_group1 as C', 'A.kode_group1_trans','=','C.kode_group1')
                ->where('A.kode_kantor', '!=', 00)
                ->where('A.telat_per_berat','>',0)
                ->whereBetween('A.TGL_TRANS', [$awal,$akhir]);

        if ($cabang != 0) {
            $query->where('A.kode_kantor', $cabang);
        }

        $filteredData = $query->groupBy('B.deskripsi_group2','C.deskripsi_group1','A.telat_per_berat','A.menit_telat_per_berat','A.kode_group1_trans')->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('kasus', function ($row) use ($awal, $akhir) {
                    if($row->telat_per_berat == 1){
                        $kasus = 'Telat';
                    }else{
                        $kasus = 'Berat';
                    }
                    return $kasus;
                })
                ->addColumn('total_masalah', function ($row) use ($awal, $akhir) {
                    $data = DB::connection('mysql_secondary')->table('kretrans as A')
                        ->selectRaw('COUNT(A.KRETRANS_ID) as total')
                        ->where('A.kode_group1_trans', $row->kode_group1_trans)
                        ->where('A.telat_per_berat','>',0)->first();
                    return $data->total;
                })
                ->addColumn('total_telat', function ($row) use ($awal, $akhir) {
                    $data = DB::connection('mysql_secondary')->table('kretrans as A')
                        ->selectRaw('COUNT(A.KRETRANS_ID) as total')
                        ->where('A.kode_group1_trans', $row->kode_group1_trans)
                        ->where('A.telat_per_berat',1)->first();
                    return $data->total;
                })
                ->addColumn('total_berat', function ($row) use ($awal, $akhir) {
                    $data = DB::connection('mysql_secondary')->table('kretrans as A')
                        ->selectRaw('COUNT(A.KRETRANS_ID) as total')
                        ->where('A.kode_group1_trans', $row->kode_group1_trans)
                        ->where('A.telat_per_berat',2)->first();
                    return $data->total;
                })
                

                ->rawColumns(['kasus','total_masalah','total_telat','total_berat'])
                ->make(true);
        }
    }
    
   


    public function getDataTableRDTRKompilasi(Request $request)
    {
        ini_set('max_execution_time', 300); // 5 menit
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $cabang = "0" . $request->input('cabang');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::connection('mysql_secondary')->table('kretrans as A')
                ->select('D.deskripsi_group2', 'C.NAMA_NASABAH', 'A.NO_REKENING')
                ->join('kredit as B', 'A.NO_REKENING', '=', 'B.no_rekening')
                ->join('nasabah as C', 'C.nasabah_id', '=', 'B.nasabah_id')
                ->join('kre_kode_group2 as D', 'A.kode_group2_trans', '=', 'D.kode_group2')
                ->where('A.KODE_TRANS', 300)
                ->where('A.dtr', 'Ya')
                ->whereBetween('A.TGL_TRANS', [$awal, $akhir])
                ->where('A.kode_kantor', '!=', 00);

            if ($cabang != 0) {
                $query->where('A.kode_kantor', $cabang);
            }

            $filteredData = $query->get();

            // Hitung jumlah dtr_ke di seluruh dataset
            $totalDtr1 = 0;
            $totalDtr23 = 0;
            $totalDtr4 = 0;

            foreach ($filteredData as $row) {
                $total_dtr = DB::connection('mysql_secondary')->table('kretrans as A')
                    ->where('A.KODE_TRANS', 300)
                    ->where('A.dtr', 'Ya')
                    ->where('A.NO_REKENING', $row->NO_REKENING)
                    ->count();

                if ($total_dtr == 1) {
                    $totalDtr1++;
                } elseif ($total_dtr > 1 && $total_dtr < 4) {
                    $totalDtr23++;
                } elseif ($total_dtr > 3) {
                    $totalDtr4++;
                }
            }

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('dtr_ke', function ($row) use ($awal, $akhir) {
                    return DB::connection('mysql_secondary')->table('kretrans as A')
                        ->where('A.KODE_TRANS', 300)
                        ->where('A.dtr', 'Ya')
                        ->where('A.NO_REKENING', $row->NO_REKENING)
                        ->count();
                })
                ->with([
                    'totalDtr1' => $totalDtr1,
                    'totalDtr23' => $totalDtr23,
                    'totalDtr4' => $totalDtr4
                ])
                ->rawColumns(['dtr_ke'])
                ->make(true);
        }
    }
    
    public function getDataTableRCairKompilasi(Request $request)
    {
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $cabang = "0".$request->input('cabang');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::connection('mysql_secondary')->table('kredit as A')
            ->select(
                'AA.deskripsi_group1','AAA.deskripsi_group2','A.tgl_realisasi',
                DB::raw('(select COUNT(B.nasabah_id) from kredit B where B.kode_group1 = A.kode_group1 and B.tgl_realisasi = A.tgl_realisasi) as jumlah_anggota'),
                DB::raw('(select SUM(B.jml_pinjaman) from kredit B where B.kode_group1 = A.kode_group1 and B.tgl_realisasi = A.tgl_realisasi) as jumlah_cair'),
            )
            ->join('kre_kode_group1 as AA', 'A.kode_group1','=','AA.kode_group1')
            ->join('kre_kode_group2 as AAA', 'A.kode_group2','=','AAA.kode_group2')
            ->where('A.kode_kantor', '!=', 00)
            ->whereBetween('A.tgl_realisasi', [$awal, $akhir]);;

        if ($cabang != 0) {
            $query->where('A.kode_kantor', $cabang);
        }

        $filteredData = $query->groupBy('AA.deskripsi_group1','AAA.deskripsi_group2','A.kode_group1', 'A.tgl_realisasi') 
                ->orderBy('AA.deskripsi_group1', 'asc')
                ->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('kel_telat', function ($row) use ($awal, $akhir) {
                    return 'h';
                })
                
                ->rawColumns(['kel_telat'])
                ->make(true);
        }
    }

    
    public function getDataTableRBtabKompilasi(Request $request)
    {
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $cabang = "0".$request->input('cabang');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::connection('mysql_secondary')->table('tabtrans AS A')
                ->join('tabung as B','A.NO_REKENING', '=', 'B.no_rekening')
                ->join('kre_kode_group1 as AAA', 'A.kode_group1_trans','=','AAA.kode_group1')
                ->selectRaw('AAA.deskripsi_group1, SUM(A.POKOK) as btab_cair, COUNT(DISTINCT(A.NO_REKENING)) as jml_anggota,A.TGL_TRANS,A.kode_group1_trans')
                ->whereBetween('A.TGL_TRANS', [$awal, $akhir])
                ->where('A.kode_kantor', '!=', 00)
                ->where('B.kode_integrasi', 204)
                ->where('A.KODE_TRANS', 200);

            if ($cabang != 0) {
                $query->where('A.kode_kantor', $cabang);
            }

            $filteredData = $query->groupBy('AAA.deskripsi_group1','A.TGL_TRANS','A.kode_group1_trans') 
            ->orderBy('AAA.deskripsi_group1', 'asc')
            ->get();


            // dd($filteredData);

            // $query = DB::connection('mysql_secondary')->table('tabtrans as A')
            // ->selectRaw(
            //     'AAA.deskripsi_group1, SUM(A.POKOK) as btab_cair,A.TGL_TRANS,A.kode_group1_trans'
            // )
            // ->join('kre_kode_group1 as AAA', 'A.kode_group1_trans','=','AAA.kode_group1')
            // ->where('A.kode_kantor', '!=', 00)
            // ->where('A.keterangan', 'like', '%BTAB%')
            // ->whereBetween('A.TGL_TRANS', [$awal, $akhir]);

            // if ($cabang != 0) {
            //     $query->where('A.kode_kantor', $cabang);
            // }

           

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('jml_anggota2', function ($row) use ($awal, $akhir) {
                    // $jum_anggota = DB::connection('mysql_secondary')->table('tabtrans as A')
                    //     ->selectRaw(
                    //         'COUNT(A.TABTRANS_ID) as jumlah'
                    //     )
                    //     ->where('A.TGL_TRANS', $row->TGL_TRANS)
                    //     ->where('A.kode_group1_trans', $row->kode_group1_trans)
                    //     ->where('A.keterangan', 'like', '%BTAB%')->first();
                    return '-';
                })
                
                ->rawColumns(['jml_anggota2'])
                ->make(true);
        }
    }

    
    public function getRAsumData(Request $request)
    {
        ini_set('max_execution_time', 300); // 5 menit
        $daterange = $request->input('daterange');
        $cabang = "0".$request->input('cabang');
        $p_date = explode("to", $daterange);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date
        
        $data_anggota = DB::connection('mysql_secondary')->table('kredit as A')
                ->selectraw('count(distinct(A.nasabah_id)) as total, count(distinct(A.kode_group3)) as total_kumpulan, count(distinct(A.kode_group1)) as total_kelompok, count(distinct(A.kode_group2)) as total_pkp')
                ->join('kre_kode_group2 as AA', 'A.kode_group2','=','AA.kode_group2')
                ->join('kre_kode_group1 as B', 'A.kode_group2','=','B.kode_group1')
                ->leftJoinSub(
                    DB::connection('mysql_secondary')
                        ->table('kretrans')
                        ->selectRaw('NO_REKENING, SUM(POKOK) AS total_pokok_terbayar')
                        ->where('MY_KODE_TRANS', 300)
                        ->where('TGL_TRANS', '<=', $akhir)
                        ->groupBy('NO_REKENING'),
                    'pembayaran',
                    'A.NO_REKENING',
                    '=',
                    'pembayaran.NO_REKENING'
                )
                ->whereRaw('(A.jml_pinjaman - COALESCE(pembayaran.total_pokok_terbayar, 0)) > 0')
                ->where('A.tgl_realisasi', '<=', $akhir)
                ->where('A.KODE_KANTOR', '!=', 00);

        if ($cabang != 0) { $data_anggota->where('A.KODE_KANTOR', $cabang); }
        $data_anggota = $data_anggota->first();
        // dd($data_anggota);
        $total_anggota = $data_anggota && isset($data_anggota->total) ? $data_anggota->total : 0;
        $total_kelompok = $data_anggota && isset($data_anggota->total_kelompok) ? $data_anggota->total_kelompok : 0;
        $total_pkp = $data_anggota && isset($data_anggota->total_pkp) ? $data_anggota->total_pkp : 0;
        $total_kumpulan = $data_anggota && isset($data_anggota->total_kumpulan) ? $data_anggota->total_kumpulan : 0;
        $agt_per_pkp = round($total_anggota/$total_pkp,2);
        $agt_per_kelompok = round($total_anggota/$total_kelompok,2);
        $agt_per_kumpulan = round($total_anggota/$total_kumpulan,2);

        $data_tabungan = DB::connection('mysql_secondary')->table('kretrans as A')
            ->selectRaw('COUNT(A.KRETRANS_ID) as total, COUNT(distinct(A.NO_REKENING)) as anggota_menabung, SUM(A.nominal_sukarela) as total_menabung')
            ->where('A.KODE_TRANS', 300)
            ->where('A.nominal_sukarela','>', 0)
            ->whereBetween('A.TGL_TRANS', [$awal, $akhir])
            ->where('A.kode_kantor', '!=', 00);
        
        if ($cabang != 0) { $data_tabungan->where('A.kode_kantor', $cabang); }
        $data_tabungan = $data_tabungan->first();
        $total_tabungan = $data_tabungan && isset($data_tabungan->total) ? $data_tabungan->total : 0;
        $anggota_menabung = $data_tabungan && isset($data_tabungan->anggota_menabung) ? $data_tabungan->anggota_menabung : 0;
        $total_menabung = $data_tabungan && isset($data_tabungan->total_menabung) ? $data_tabungan->total_menabung : 0;
        $rata_tabungan_anggota = round($total_menabung/$anggota_menabung,2);

        $data_dtr = DB::connection('mysql_secondary')->table('kretrans as A')
            ->selectRaw('COUNT(A.KRETRANS_ID) as total')
            ->whereBetween('A.TGL_TRANS', [$awal, $akhir])
            ->where('A.KODE_TRANS', 300)
            ->where('A.dtr', "Ya")
            ->where('A.ANGSURAN_KE',">=", 1)
            ->where('A.kode_kantor', '!=', 00);

        if ($cabang != 0) {$data_dtr->where('A.kode_kantor', $cabang);}
        $data_dtr = $data_dtr->first();
        $total_dtr = $data_dtr && isset($data_dtr->total) ? $data_dtr->total : 0;

        $data_setoran = DB::connection('mysql_secondary')->table('kretrans as A')
            ->selectRaw('COUNT(A.KRETRANS_ID) as total')
            ->whereBetween('A.TGL_TRANS', [$awal, $akhir])
            ->where('A.KODE_TRANS', 300)
            ->where('A.ANGSURAN_KE',">=", 1)
            ->where('A.kode_kantor', '!=', 00);

        if ($cabang != 0) {$data_setoran->where('A.kode_kantor', $cabang);}
        $data_setoran = $data_setoran->first();
        $total_setoran = $data_setoran && isset($data_setoran->total) ? $data_setoran->total : 0;
        $percent_dtr = round(($total_dtr/$total_setoran)*100,2);

        $data_cair = DB::connection('mysql_secondary')->table('kredit as A')
            ->selectRaw('COUNT(distinct(A.nasabah_id)) as total, COUNT(distinct(A.kode_group1)) as kelompok, SUM(A.jml_pinjaman) as nominal')
            ->whereBetween('A.tgl_realisasi', [$awal, $akhir]);
        if ($cabang != 0) {$data_cair->where('A.KODE_KANTOR', $cabang);}
        $data_cair = $data_cair->first();
        $anggota_cair = $data_cair && isset($data_cair->total) ? $data_cair->total : 0;
        $kelompok_cair = $data_cair && isset($data_cair->kelompok) ? $data_cair->kelompok : 0;
        $nominal_cair = $data_cair && isset($data_cair->nominal) ? $data_cair->nominal : 0;
        $rata_cair = $nominal_cair/$anggota_cair;
        
        $data_cair2 = DB::connection('mysql_secondary')->table('kredit as A')
            ->selectRaw('A.nasabah_id')
            ->whereBetween('A.tgl_realisasi', [$awal, $akhir]);
        if ($cabang != 0) {$data_cair2->where('A.KODE_KANTOR', $cabang);}
        $data_cair2 = $data_cair2->get();
        $anggota_lama = 0;
        $anggota_baru = 0;
        $pinjaman_lama = 0;
        $pinjaman_baru = 0;
        foreach($data_cair2 as $list){
            $data_cair3 = DB::connection('mysql_secondary')->table('kredit as A')
                ->selectRaw('COUNT(A.nasabah_id) as total, SUM(A.jml_pinjaman) as nominal')
                ->where('A.nasabah_id', $list->nasabah_id)
                ->first();
            if($data_cair3->total > 1){
                $anggota_lama = $anggota_lama + 1;
                $pinjaman_lama = $pinjaman_lama + $data_cair3->nominal;
            }else{
                $anggota_baru = $anggota_baru + 1;
                $pinjaman_baru = $pinjaman_baru + $data_cair3->nominal;
            }
        }

        $data_btab = DB::connection('mysql_secondary')->table('tabtrans AS A')
                ->join('tabung as B','A.NO_REKENING', '=', 'B.no_rekening')
                ->selectRaw('COUNT(distinct(A.NO_REKENING)) as total, COUNT(distinct(A.kode_group1_trans)) as kelompok, SUM(A.POKOK) as nominal')
                ->whereBetween('A.TGL_TRANS', [$awal, $akhir])
                ->where('A.kode_kantor', '!=', 00)
                ->where('B.kode_integrasi', 204)
                ->where('A.KODE_TRANS', 200);

        // $data_btab = DB::connection('mysql_secondary')->table('tabtrans as A')
        //     ->selectRaw('COUNT(distinct(A.NO_REKENING)) as total, COUNT(distinct(A.kode_group1_trans)) as kelompok, SUM(A.POKOK) as nominal')
        //     ->whereBetween('A.TGL_TRANS', [$awal, $akhir])
        //     ->where('A.KETERANGAN', 'like', '%BTAB%')
        //     ->where('A.kode_kantor', '!=', 00);

        if ($cabang != 0) {$data_btab->where('A.kode_kantor', $cabang);}
        $data_btab = $data_btab->first();
        $anggota_btab = $data_btab && isset($data_btab->total) ? $data_btab->total : 0;
        $kelompok_btab = $data_btab && isset($data_btab->kelompok) ? $data_btab->kelompok : 0;
        $nominal_btab = $data_btab && isset($data_btab->nominal) ? $data_btab->nominal : 0;

        $data_telat = DB::connection('mysql_secondary')->table('kretrans as A')
            ->selectRaw('COUNT(distinct(A.kode_group1_trans)) as total')
            ->whereBetween('A.TGL_TRANS', [$awal, $akhir])
            ->where('A.telat_per_berat',1);
        if ($cabang != 0) {$data_telat->where('A.kode_kantor', $cabang);}
        $data_telat = $data_telat->first();
        $total_telat = $data_telat && isset($data_telat->total) ? $data_telat->total : 0;

        $data_berat = DB::connection('mysql_secondary')->table('kretrans as A')
        ->selectRaw('COUNT(distinct(A.kode_group1_trans)) as total')
            ->whereBetween('A.TGL_TRANS', [$awal, $akhir])
            ->where('A.telat_per_berat',2);
        if ($cabang != 0) {$data_berat->where('A.kode_kantor', $cabang);}
        $data_berat = $data_berat->first();
        $total_berat = $data_berat && isset($data_berat->total) ? $data_berat->total : 0;

        return response()->json([
            'success' => true,
            'anggota_aktif' => $total_anggota ?? 0,
            'kelompok_aktif' => $total_kelompok ?? 0,
            'kumpulan_aktif' => $total_kumpulan ?? 0,
            'pkp' => $total_pkp ?? 0,
            'agt_per_pkp' => $agt_per_pkp ?? 0,
            'agt_per_kelompok' => $agt_per_kelompok ?? 0,
            'agt_per_kumpulan' => $agt_per_kumpulan ?? 0,

            'trx_menabung' => $total_tabungan ?? 0,
            'agt_menabung' => $anggota_menabung ?? 0,
            'nominal_menabung' => $total_menabung ?? 0,
            'rata_agt_menabung' => $rata_tabungan_anggota ?? 0,

            'jumlah_dtr' => $total_dtr ?? 0,
            'jumlah_trx' => $total_setoran ?? 0,
            'percent_dtr' => $percent_dtr ?? 0,

            'kelompok_cair' => $kelompok_cair ?? 0,
            'anggota_cair' => $anggota_cair ?? 0,
            'nominal_cair' => $nominal_cair ?? 0,
            'rata_cair' => $rata_cair ?? 0,
            'anggota_lama' => $anggota_lama ?? 0,
            'anggota_baru' => $anggota_baru ?? 0,
            'pinjaman_lama' => $pinjaman_lama ?? 0,
            'pinjaman_baru' => $pinjaman_baru?? 0,

            'anggota_btab' => $anggota_btab ?? 0,
            'kelompok_btab' => $kelompok_btab ?? 0,
            'nominal_btab' => $nominal_btab ?? 0,

            'total_masalah' => $total_telat + $total_berat ?? 0,
            'total_telat' => $total_telat ?? 0,
            'total_berat' => $total_berat ?? 0,
        ]);
    }


}
