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

    
    public function pdfLaporanHarian(): View
    {
        $cabang = $_GET["cabang"];
        $tanggal = $_GET["tanggal"];
        $data = [
            'menu' => 'Laporan Harian',
            'cabang' => $cabang,
            'tanggal' => $tanggal
            
        ];
        
        return view('reporting.pdf-laporan-harian', $data);
    }

    
    public function pdfLaporanPeriode(): View
    {
        $cabang = $_GET["cabang"];
        $tanggal = $_GET["tanggal"];
        $p_tanggal = explode("to", $tanggal);
        $data = [
            'menu' => 'Laporan Periode',
            'cabang' => $cabang,
            'tanggal' => $tanggal,
            'awal' => $p_tanggal[0],
            'akhir' => $p_tanggal[1]
            
        ];
        
        return view('reporting.pdf-laporan-periode', $data);
    }
   
}
