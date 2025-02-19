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



class DashboardController extends Controller
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
        $menu_aktif = '/dashboard||/dashboard2';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Dashboard',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>'
        ];

        
        
        return view('dashboard.index', $data);
    }

    public function dashboardAnggota(): View
    {
        $menu_aktif = '/dashboardAnggota||/dashboard2';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Dashboard Anggota',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>'
        ];
        
        return view('dashboard.anggota', $data);
    }

    
    public function getDataTotalDashboard()
    {
        $anggota_aktif_dgn_md = DB::connection('mysql_secondary')->select('SELECT count(kredit.nasabah_id) as total FROM kredit INNER JOIN nasabah ON kredit.nasabah_id = nasabah.nasabah_id INNER JOIN kre_kode_group1 ON kredit.kode_group1 = kre_kode_group1.kode_group1 WHERE kredit.pokok_saldo_akhir > 0');
        $kelompok_aktif = DB::connection('mysql_secondary')->select('SELECT count(distinct(kredit.kode_group1)) as total FROM kredit INNER JOIN nasabah ON kredit.nasabah_id = nasabah.nasabah_id INNER JOIN kre_kode_group1 ON kredit.kode_group1 = kre_kode_group1.kode_group1 WHERE kredit.pokok_saldo_akhir > 0');
        $kumpulan_aktif = DB::connection('mysql_secondary')->select('SELECT count(distinct(kredit.kode_group3)) as total FROM kredit INNER JOIN nasabah ON kredit.nasabah_id = nasabah.nasabah_id INNER JOIN kre_kode_group1 ON kredit.kode_group1 = kre_kode_group1.kode_group1 WHERE kredit.pokok_saldo_akhir > 0');
        $tabungan_anggota_aktif = DB::connection('mysql_secondary')->select("SELECT SUM(A.saldo_akhir) AS total
            FROM tabung A
            WHERE A.nasabah_id IN (
                SELECT DISTINCT X.nasabah_id
                FROM tabung X
                WHERE X.kode_integrasi = 202
                AND X.saldo_akhir >= 10000
            ) and A.kode_integrasi = 203");
        $tabungan_semua_anggota = DB::connection('mysql_secondary')->select("SELECT SUM(A.saldo_akhir) as total FROM tabung A where A.kode_integrasi = '203'");


        $data = [
            'anggota_aktif_dgn_md' => $anggota_aktif_dgn_md[0]->total,
            'anggota_aktif_tanpa_md' => 0,
            'kelompok_aktif' => $kelompok_aktif[0]->total,
            'kumpulan_aktif' => $kumpulan_aktif[0]->total,
            'tabungan_anggota_aktif' => $tabungan_anggota_aktif[0]->total,
            'tabungan_semua_anggota' => $tabungan_semua_anggota[0]->total,
        ];
        // var_dump($data);die();
        
        return response()->json($data); // Mengirimkan nilai total_quantity
    }

    
    public function chartPencairanAnggota(Request $request)
    {
        $tahun = $request->input('tahun');

        $chart_pa = DB::connection('mysql_secondary')
                ->table('kredit')
                ->select(DB::raw('DATE_FORMAT(tgl_realisasi, "%b-%Y") as bulan'), DB::raw('count(nasabah_id) as jumlah'))
                ->whereYear('tgl_realisasi', '=', $tahun)
                ->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();

        return response()->json([
            'bulan' => $chart_pa->pluck('bulan'),
            'jumlah' => $chart_pa->pluck('jumlah'),
        ]);
    }

    public function chartPencairanKelompok(Request $request)
    {
        $tahun = $request->input('tahun');

        $chart_pa = DB::connection('mysql_secondary')
                ->table('kredit')
                ->select(DB::raw('DATE_FORMAT(tgl_realisasi, "%b-%Y") as bulan'), DB::raw('count(DISTINCT kode_group1) as jumlah'))
                ->whereYear('tgl_realisasi', '=', $tahun)
                ->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();

        return response()->json([
            'bulan' => $chart_pa->pluck('bulan'),
            'jumlah' => $chart_pa->pluck('jumlah'),
        ]);
    }

    public function chartCabangAnggota(Request $request)
    {

        $chart_ca = DB::connection('mysql_secondary')
                ->table('kredit')
                ->select('app_kode_kantor.NAMA_KANTOR as bulan', DB::raw('count(kredit.nasabah_id) as jumlah'))
                ->join('app_kode_kantor', 'app_kode_kantor.KODE_KANTOR', '=', 'kredit.KODE_KANTOR')
                ->join('tabung', 'tabung.nasabah_id', '=', 'kredit.nasabah_id')
                ->where('tabung.kode_integrasi', '=', '201')
                ->where('tabung.saldo_akhir', '>=', 10000)
                ->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();

        return response()->json([
            'bulan' => $chart_ca->pluck('bulan'),
            'jumlah' => $chart_ca->pluck('jumlah'),
        ]);
    }

    public function chartCabangKelompok(Request $request)
    {

        $chart_ca = DB::connection('mysql_secondary')
                ->table('kredit')
                ->select('app_kode_kantor.NAMA_KANTOR as bulan', DB::raw('count(DISTINCT kredit.kode_group1) as jumlah'))
                ->join('app_kode_kantor', 'app_kode_kantor.KODE_KANTOR', '=', 'kredit.KODE_KANTOR')
                ->join('tabung', 'tabung.nasabah_id', '=', 'kredit.nasabah_id')
                ->where('tabung.kode_integrasi', '=', '201')
                ->where('tabung.saldo_akhir', '>=', 10000)
                ->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();

        return response()->json([
            'bulan' => $chart_ca->pluck('bulan'),
            'jumlah' => $chart_ca->pluck('jumlah'),
        ]);
    }

    
    public function chartAnggotaBermasalah(Request $request)
    {
        
        $cabang = $request->input('cabang');
        $filterBy = $request->input('filter_by');
        $tahun = $request->input('tahun');
        $tampil = $request->input('tampil_berdasarkan');
        $tanggal = $request->input('tanggal');
        $decoded_date_range = urldecode($tanggal);
        $pecah_date_ranges = explode(' to ', $decoded_date_range);
        if(($filterBy == 'thn' && $tahun < 2025) || ($filterBy == 'tgl' && $pecah_date_ranges[0] < '2025-01-01')){
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
                    [$awal, $akhir] = explode(' to ', $decoded_date_range);
                    $chart_ab->where('tanggal_ab', '>=', $awal)
                        ->where('tanggal_ab', '<=', $akhir);
                }
                
            }

            if ($cabang != '') {
                $chart_ab->where('cabang_ab', $cabang);
            }
            $chart_ab->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();

        }else{
            $chart_ab = DB::connection('mysql_secondary')->table('kretrans');

            if ($filterBy == 'thn') {
                if ($tampil == 'min') {
                    $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(TGL_TRANS), "-", YEAR(TGL_TRANS)) as bulan'), DB::raw('count(KRETRANS_ID) as jumlah'));
                }else{
                    $chart_ab->select(DB::raw('DATE_FORMAT(TGL_TRANS, "%b-%Y") as bulan'), DB::raw('count(KRETRANS_ID) as jumlah'));
                }
                $chart_ab->whereYear('TGL_TRANS', '=', $tahun);
            }else{
                if ($tanggal !="") {
                    $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(TGL_TRANS), "-", YEAR(TGL_TRANS)) as bulan'), DB::raw('count(KRETRANS_ID) as jumlah'));
                    $decoded_date_range = urldecode($tanggal);
                    [$awal, $akhir] = explode(' to ', $decoded_date_range);
                    $chart_ab->where('TGL_TRANS', '>=', $awal)
                        ->where('TGL_TRANS', '<=', $akhir);
                }
                
            }

            if ($cabang != '') {
                $chart_ab->where('kode_kantor', "0".$cabang);
            }
            $chart_ab->where('dtr', 'Ya')->where('KODE_TRANS', 300)->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();
        }

        
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
        $decoded_date_range = urldecode($tanggal);
        $pecah_date_ranges = explode(' to ', $decoded_date_range);
        if(($filterBy == 'thn' && $tahun < 2025) || ($filterBy == 'tgl' && $pecah_date_ranges[0] < '2025-01-01')){
            $chart_ab = DB::table('kelompok_bermasalah');

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
        }else{
            $chart_ab = DB::connection('mysql_secondary')->table('kretrans');

            if ($filterBy == 'thn') {
                if ($tampil == 'min') {
                    $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(TGL_TRANS), "-", YEAR(TGL_TRANS)) as bulan'), DB::raw('count(distinct(kode_group1_trans)) as jumlah'));
                }else{
                    $chart_ab->select(DB::raw('DATE_FORMAT(TGL_TRANS, "%b-%Y") as bulan'), DB::raw('count(distinct(kode_group1_trans)) as jumlah'));
                }
                $chart_ab->whereYear('TGL_TRANS', '=', $tahun);
            }else{
                if ($tanggal !="") {
                    $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(TGL_TRANS), "-", YEAR(TGL_TRANS)) as bulan'), DB::raw('count(distinct(kode_group1_trans)) as jumlah'));
                    $decoded_date_range = urldecode($tanggal);
                    [$awal, $akhir] = explode(' to ', $decoded_date_range);
                    $chart_ab->where('TGL_TRANS', '>=', $awal)
                        ->where('TGL_TRANS', '<=', $akhir);
                }
                
            }

            if ($cabang != '') {
                $chart_ab->where('kode_kantor', "0".$cabang);
            }
            $chart_ab->where('telat_per_berat', '=', 1)->where('KODE_TRANS', 300)->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();
        }
        

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
        $decoded_date_range = urldecode($tanggal);
        $pecah_date_ranges = explode(' to ', $decoded_date_range);
        if(($filterBy == 'thn' && $tahun < 2025) || ($filterBy == 'tgl' && $pecah_date_ranges[0] < '2025-01-01')){
            $chart_ab = DB::table('kelompok_bermasalah');
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
        }else{
            $chart_ab = DB::connection('mysql_secondary')->table('kretrans');

            if ($filterBy == 'thn') {
                if ($tampil == 'min') {
                    $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(TGL_TRANS), "-", YEAR(TGL_TRANS)) as bulan'), DB::raw('count(distinct(kode_group1_trans)) as jumlah'));
                }else{
                    $chart_ab->select(DB::raw('DATE_FORMAT(TGL_TRANS, "%b-%Y") as bulan'), DB::raw('count(distinct(kode_group1_trans)) as jumlah'));
                }
                $chart_ab->whereYear('TGL_TRANS', '=', $tahun);
            }else{
                if ($tanggal !="") {
                    $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(TGL_TRANS), "-", YEAR(TGL_TRANS)) as bulan'), DB::raw('count(distinct(kode_group1_trans)) as jumlah'));
                    $decoded_date_range = urldecode($tanggal);
                    [$awal, $akhir] = explode(' to ', $decoded_date_range);
                    $chart_ab->where('TGL_TRANS', '>=', $awal)
                        ->where('TGL_TRANS', '<=', $akhir);
                }
                
            }

            if ($cabang != '') {
                $chart_ab->where('kode_kantor', "0".$cabang);
            }
            $chart_ab->where('telat_per_berat', 2)->where('KODE_TRANS', 300)->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();

        }
        

        // Kembalikan data dalam format JSON
        return response()->json([
            'bulan' => $chart_ab->pluck('bulan'),
            'jumlah' => $chart_ab->pluck('jumlah'),
        ]);
    }
   
}
