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

    

    
    public function getMasalahAnggota(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');
            $query = DB::table('anggota_bermasalah')
                ->select(
                    'nama_ab',
                    'kelompok_ab',
                    'id_anggota_ab',
                    'cabang_ab',
                    'id_sikki_ab',
                    DB::raw('COUNT(id_ab) AS jumlah'),
                    DB::raw('SUM(IF( kode_ab = "2", 1, 0)) AS kode2'),
                    DB::raw('SUM(IF( kode_ab = "4A", 1, 0)) AS kode4a'),
                    DB::raw('SUM(IF( kode_ab = "4B", 1, 0)) AS kode4b')
                );

            if(Session::get('is_kc') == "1"){
                $query->where('cabang_ab', $cabang);
            }else if(Session::get('is_kc') == "0"){
                $query->where('pkp_ab', $id_user);
            }else{
                if(Session::get('cabang') == "0"){
                }else{
                    $query->where('cabang_ab', $cabang);
                }
            }

            // Applying filters conditionally
            if ($request->filled('kelompok')) {
                $query->where('kelompok_kb', 'like', '%' . $request->input('kelompok') . '%');
            }
            if ($request->filled('pkp')) {
                $query->where('pkp_dkb', 'like', '%' . $request->input('pkp') . '%');
            }
            if ($request->filled('kc')) {
                $query->where('kc_dkb', 'like', '%' . $request->input('kc') . '%');
            }

            // Grouping by idsikkikb and ordering by id_kb
            $filteredData = $query->groupBy('nama_ab', 'kelompok_ab', 'id_anggota_ab', 'id_sikki_ab', 'cabang_ab')
                ->orderBy('id_ab', 'desc')
                ->get();
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->kelompok_ab);

                    $infoUrl = route('user.infoUser', $id_hash);
                    $editUrl = route('user.editUser', $id_hash);
                    
                    $btn = '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    $btn .= '<button title="HAPUS" class="btn btn-danger btn-delete-user btn-sm" data-id="' . $id_hash . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    
    public function chartAnggotaBermasalah(Request $request)
    {
        
        $cabang = $request->input('cabang');
        $filterBy = $request->input('filter_by');
        $tahun = $request->input('tahun');
        $tampil = $request->input('tampil_berdasarkan');
        $tanggal = $request->input('tanggal');

        $chart_ab = DB::table('anggota_bermasalah');

        

        if ($filterBy == 'thn') {
            if ($tampil == 'min') {
                $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(tanggal_ab), "-", YEAR(tanggal_ab)) as bulan'), DB::raw('count(id_ab) as jumlah'));
            }else{
                $chart_ab->select(DB::raw('DATE_FORMAT(tanggal_ab, "%b-%Y") as bulan'), DB::raw('count(id_ab) as jumlah'));
            }
            $chart_ab->whereYear('tanggal_ab', '=', $tahun);
        }else{
            if ($tanggal !="") {
                $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(tanggal_ab), "-", YEAR(tanggal_ab)) as bulan'), DB::raw('count(id_ab) as jumlah'));
                $decoded_date_range = urldecode($tanggal);

                // Memisahkan tanggal menjadi dua bagian: awal dan akhir
                [$awal, $akhir] = explode(' to ', $decoded_date_range);

                // Menambahkan filter berdasarkan rentang tanggal
                $chart_ab->where('tanggal_ab', '>=', $awal)
                    ->where('tanggal_ab', '<=', $akhir);
            }
            
        }

        if ($cabang != '') {
            $chart_ab->where('cabang_ab', $cabang);
        }

        $chart_ab->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();

        // $chart_ab = DB::table('anggota_bermasalah') 
        // ->select(DB::raw('DATE_FORMAT(tanggal_ab, "%b-%Y") as bulan'), DB::raw('count(id_ab) as jumlah'))
        //         ->groupBy(DB::raw('bulan'))
        //         ->orderBy(DB::raw('bulan'))
        //         ->get();

        // Kembalikan data dalam format JSON
        return response()->json([
            'bulan' => $chart_ab->pluck('bulan'),
            'jumlah' => $chart_ab->pluck('jumlah'),
        ]);
    }

    
    public function chartKelompokTelat(Request $request)
    {
        
        $cabang = $request->input('cabang');
        $filterBy = $request->input('filter_by');
        $tahun = $request->input('tahun');
        $tampil = $request->input('tampil_berdasarkan');
        $tanggal = $request->input('tanggal');
        $chart_ab = DB::table('kelompok_bermasalah');

        // $que=$mysqli->query("SELECT YEAR(tanggal_kb) as tahun, WEEK(tanggal_kb) as bulan,DATE_SUB(tanggal_kb,INTERVAL DAYOFWEEK(tanggal_kb)-1 DAY) as bln,count(id_kb) as jumlah FROM kelompok_bermasalah WHERE kode_kb = '3A'  AND YEAR(tanggal_kb) = '$tahun' GROUP BY YEAR(tanggal_kb),WEEK(tanggal_kb) order by tanggal_kb ASC");         

        if ($filterBy == 'thn') {
            if ($tampil == 'min') {
                $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(tanggal_kb), "-", YEAR(tanggal_kb)) as bulan'), DB::raw('count(id_kb) as jumlah'));
            }else{
                $chart_ab->select(DB::raw('DATE_FORMAT(tanggal_kb, "%b-%Y") as bulan'), DB::raw('count(id_kb) as jumlah'));
            }
            $chart_ab->whereYear('tanggal_kb', '=', $tahun);
        }else{
            if ($tanggal !="") {
                $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(tanggal_kb), "-", YEAR(tanggal_kb)) as bulan'), DB::raw('count(id_kb) as jumlah'));
                $decoded_date_range = urldecode($tanggal);

                // Memisahkan tanggal menjadi dua bagian: awal dan akhir
                [$awal, $akhir] = explode(' to ', $decoded_date_range);

                // Menambahkan filter berdasarkan rentang tanggal
                $chart_ab->where('tanggal_kb', '>=', $awal)
                    ->where('tanggal_kb', '<=', $akhir);
            }
            
        }

        if ($cabang != '') {
            $chart_ab->where('cabang_kb', $cabang);
        }

        $chart_ab->where('kode_kb', '3A');
        $chart_ab->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();

        // Kembalikan data dalam format JSON
        return response()->json([
            'bulan' => $chart_ab->pluck('bulan'),
            'jumlah' => $chart_ab->pluck('jumlah'),
        ]);
    }

    
    public function chartKelompokBerat(Request $request)
    {
        
        $cabang = $request->input('cabang');
        $filterBy = $request->input('filter_by');
        $tahun = $request->input('tahun');
        $tampil = $request->input('tampil_berdasarkan');
        $tanggal = $request->input('tanggal');
        $chart_ab = DB::table('kelompok_bermasalah');

        // $que=$mysqli->query("SELECT YEAR(tanggal_kb) as tahun, WEEK(tanggal_kb) as bulan,DATE_SUB(tanggal_kb,INTERVAL DAYOFWEEK(tanggal_kb)-1 DAY) as bln,count(id_kb) as jumlah FROM kelompok_bermasalah WHERE kode_kb = '3A'  AND YEAR(tanggal_kb) = '$tahun' GROUP BY YEAR(tanggal_kb),WEEK(tanggal_kb) order by tanggal_kb ASC");         

        if ($filterBy == 'thn') {
            if ($tampil == 'min') {
                $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(tanggal_kb), "-", YEAR(tanggal_kb)) as bulan'), DB::raw('count(id_kb) as jumlah'));
            }else{
                $chart_ab->select(DB::raw('DATE_FORMAT(tanggal_kb, "%b-%Y") as bulan'), DB::raw('count(id_kb) as jumlah'));
            }
            $chart_ab->whereYear('tanggal_kb', '=', $tahun);
        }else{
            if ($tanggal !="") {
                $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(tanggal_kb), "-", YEAR(tanggal_kb)) as bulan'), DB::raw('count(id_kb) as jumlah'));
                $decoded_date_range = urldecode($tanggal);

                // Memisahkan tanggal menjadi dua bagian: awal dan akhir
                [$awal, $akhir] = explode(' to ', $decoded_date_range);

                // Menambahkan filter berdasarkan rentang tanggal
                $chart_ab->where('tanggal_kb', '>=', $awal)
                    ->where('tanggal_kb', '<=', $akhir);
            }
            
        }

        if ($cabang != '') {
            $chart_ab->where('cabang_kb', $cabang);
        }

        $chart_ab->where('kode_kb', '3B');
        $chart_ab->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();

        // Kembalikan data dalam format JSON
        return response()->json([
            'bulan' => $chart_ab->pluck('bulan'),
            'jumlah' => $chart_ab->pluck('jumlah'),
        ]);
    }
   
}