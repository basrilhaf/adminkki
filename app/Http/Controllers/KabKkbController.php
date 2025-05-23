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
use Response;


class KabKkbController extends Controller
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
            'breadcrumb' => ''
        ];
        
        return view('dashboard.index', $data);
    }

    public function pengisianKab(Request $request): View
    {
        $menu_aktif = '/pengisianKab||/kabkkb';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        

        $data = [
            'menu' => 'KAB',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('kab_kkb.pengisian-kab', $data);
    }

    public function pengisianKkb(Request $request): View
    {
        $menu_aktif = '/pengisiankkb||/kabkkb';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        

        $data = [
            'menu' => 'KKB',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('kab_kkb.pengisian-kkb', $data);
    }

    
    public function daftarKkb(Request $request): View
    {
        $menu_aktif = '/daftarKkb||/kabkkb';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        

        $data = [
            'menu' => 'KKB USSI',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('kab_kkb.daftar-kkb', $data);
    }

    
    public function daftarKab(Request $request): View
    {
        $menu_aktif = '/daftarKab||/kabkkb';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        $data = [
            'menu' => 'KAB USSI',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('kab_kkb.daftar-kab', $data);
    }


    public function statusKabKkb(Request $request): View
    {
        $menu_aktif = '/statusKabKkb||/kabkkb';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        

        $data = [
            'menu' => 'Status',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('kab_kkb.status', $data);
    }

    
    public function rangkumanDtr(Request $request): View
    {
        $menu_aktif = '/rangkumanDtr||/kabkkb';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        

        $data = [
            'menu' => 'Rangkuman Penyebab DTR',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('kab_kkb.rangkuman-dtr', $data);
    }
    
    public function formBelumDikunjungiDikumpulkan(Request $request)
    {
        $kabkkb = $request->input('kabkkb');
        $date_range = $request->input('daterange');
        $cabang = $request->input('cabang');

        $p_date = explode("to", $date_range);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date

        $results = [];

        if ($kabkkb == "KAB") {
            $query = "
                SELECT 
                    B.nama, 
                    A.pkp_ab,
                    A.nama_ab,
                    A.kelompok_ab,
                    A.id_anggota_ab,
                    A.tanggal_ab,
                    (SELECT COUNT(id_ab) FROM anggota_bermasalah X WHERE A.id_anggota_ab = X.id_anggota_ab) as jumlah
                FROM 
                    anggota_bermasalah  A
                LEFT JOIN 
                    pkp B ON B.id = A.pkp_ab
                WHERE 
                    A.cabang_ab = :cabang
                    AND A.tanggal_ab >= :awal
                    AND A.tanggal_ab <= :akhir
                    AND (A.dikunjungi_ab IS NULL OR A.dikunjungi_ab = '0')
                ORDER BY 
                    B.nama ASC
            ";

            $results = DB::select($query, [
                'cabang' => $cabang,
                'awal' => $awal,
                'akhir' => $akhir
            ]);
        } else {
            $query = "
                SELECT 
                B.nama,
                A.pkp_kb,
                A.kelompok_kb,
                A.kode_kb,
                A.menit_kb,
                A.tanggal_kb,
                (
                    SELECT SUM(IF(X.kode_kb = '3A', 1, 0))
                    FROM kelompok_bermasalah X
                    WHERE A.kelompok_kb = X.kelompok_kb
                ) AS kode3a,
                (
                    SELECT SUM(IF(XX.kode_kb = '3B', 1, 0))
                    FROM kelompok_bermasalah XX
                    WHERE A.kelompok_kb = XX.kelompok_kb
                ) AS kode3b
            FROM 
                kelompok_bermasalah A
            LEFT JOIN pkp B ON B.id = A.pkp_kb
            WHERE 
                cabang_kb = :cabang 
                AND tanggal_kb >= :awal 
                AND tanggal_kb <= :akhir 
                AND (dikumpulkan_kb IS NULL OR dikumpulkan_kb = '0')
            ORDER BY 
                B.nama ASC
            ";

            $results = DB::select($query, [
                'cabang' => $cabang,
                'awal' => $awal,
                'akhir' => $akhir
            ]);
        }

       
        $data = [
            'kabkkb' => $kabkkb,  
            'cabang' => $cabang,
            'awal' => $awal,
            'akhir' => $akhir,
            'results' => $results
        ];

        return view('kab_kkb.form-belum-dikunjungi-dikumpulkan', $data);
    }

    
    public function formNasabahKelompokBermasalah(Request $request)
    {
        $kabkkb = $request->input('kabkkb');
        $date_range = $request->input('daterange');
        $cabang = $request->input('cabang');

        $p_date = explode("to", $date_range);
        $awal  = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date

        $results = [];

        if ($kabkkb == "KAB") {
            $query = "
                SELECT pkp.nama, pkp.id 
                FROM pkp
                LEFT JOIN anggota_bermasalah ON pkp.id = anggota_bermasalah.pkp_ab
                LEFT JOIN kelompok_bermasalah ON kelompok_bermasalah.pkp_kb = pkp.id
                WHERE 
                    (cabang_ab = :cabang OR cabang_kb = :cabang2)
                    AND (
                        (anggota_bermasalah.tanggal_ab >= :awal AND anggota_bermasalah.tanggal_ab <= :akhir)
                        AND (kelompok_bermasalah.tanggal_kb >= :awal2 AND kelompok_bermasalah.tanggal_kb <= :akhir2)
                    )
                GROUP BY pkp.nama, pkp.id
                ORDER BY pkp.nama ASC
            ";

            $results = DB::select($query, [
                'cabang' => $cabang,
                'cabang2' => $cabang,
                'awal'   => $awal,
                'akhir'  => $akhir,
                'awal2'   => $awal,
                'akhir2'  => $akhir
            ]);

            foreach ($results as $row) {
                $pkp = $row->id;
            
                $anggotaSummary = DB::table('anggota_bermasalah')
                    ->select('id_anggota_ab', DB::raw('COUNT(id_ab) as total'))
                    ->where('pkp_ab', $pkp)
                    ->whereBetween('tanggal_ab', [$awal, $akhir])
                    ->where('cabang_ab', $cabang)
                    ->groupBy('id_anggota_ab')
                    ->first();
            
                $kelompokSummary = DB::table('kelompok_bermasalah')
                    ->select('kelompok_kb', DB::raw('COUNT(id_kb) as total'))
                    ->where('pkp_kb', $pkp)
                    ->whereBetween('tanggal_kb', [$awal, $akhir])
                    ->where('cabang_kb', $cabang)
                    ->groupBy('kelompok_kb')
                    ->first();
            
                $anggotaIds = DB::table('anggota_bermasalah')
                    ->select('id_anggota_ab')
                    ->where('pkp_ab', $pkp)
                    ->whereBetween('tanggal_ab', [$awal, $akhir])
                    ->where('cabang_ab', $cabang)
                    ->get();
            
                $row->anggota_summary  = $anggotaSummary;
                $row->kelompok_summary = $kelompokSummary;
                $row->anggota_ids      = $anggotaIds;

                foreach($anggotaIds as $rowx){
                    $totalAnggotaIds = DB::table('anggota_bermasalah')
                        ->selectRaw('count(id_ab) as total, nama_ab, kelompok_ab')
                        ->where('id_anggota_ab', $rowx->id_anggota_ab)
                        ->groupBy('nama_ab', 'kelompok_ab')
                        ->get();

                    $totalKabur = DB::table('anggota_bermasalah')
                        ->selectRaw('id_anggota_ab, count(id_ab) as total')
                        ->where('pkp_ab', $pkp)
                        ->where('tanggal_ab', '>=', $awal)
                        ->where('tanggal_ab', '<=', $akhir)
                        ->where('cabang_ab', $cabang)
                        ->where('kabur_ab', '1')
                        ->groupBy('id_anggota_ab')
                        ->first();

                    $listAnggotaKelompok = DB::table('anggota_bermasalah')
                        ->selectRaw('count(id_ab) as total,nama_ab,kelompok_ab')
                        ->where('id_anggota_ab', $rowx->id_anggota_ab)
                        ->groupBy('nama_ab','kelompok_ab')
                        ->get();

                    $dtr1=0;
                    $dtr2=0;
                    $dtr3=0;
                    $nama_ab = "";
                    $kel_ab ="";
                    $nox=1;
                    foreach($listAnggotaKelompok as $list){
                        $nama_ab = $nama_ab."<p> [".$nox."]".$list->nama_ab.",</p>";
                        $kel_ab = $kel_ab."<p> [".$nox."]".$list->kelompok_ab.",</p>";
                        if($list->total > 0 && $list->total <= 1){
                            $dtr1 = $dtr1+1;
                            $dtr2 = $dtr2+0;
                            $dtr3 = $dtr3+0;
                        } else if($list->total >= 2 && $list->total <= 3){
                            $dtr1 = $dtr1+0;
                            $dtr2 = $dtr2+1;
                            $dtr3 = $dtr3+0;    
                        } else {
                            $dtr1 = $dtr1+0;
                            $dtr2 = $dtr2+0;
                            $dtr3 = $dtr3+1;
                        }
                        $nox = $nox+1;
                    }
                    
                    $rowx->totalAnggotaIds = $totalAnggotaIds;
                    $rowx->totalKabur = $totalKabur->total ?? 0;
                    $rowx->dtr1 = $dtr1 ?? 0;
                    $rowx->dtr2 = $dtr2 ?? 0;
                    $rowx->dtr3 = $dtr3 ?? 0;
                    $rowx->nama_ab = $nama_ab ?? 0;
                    $rowx->kel_ab = $kel_ab ?? 0;

                }
            }
        } else {
            $query = "
                SELECT pkp.nama,pkp.id,SUM(IF( kelompok_bermasalah.kode_kb = '3A', 1, 0)) AS telat,
                SUM(IF( kelompok_bermasalah.kode_kb = '3B', 1, 0)) AS berat FROM pkp
                LEFT JOIN kelompok_bermasalah
                ON kelompok_bermasalah.pkp_kb = pkp.id
                WHERE cabang_kb = :cabang AND kelompok_bermasalah.tanggal_kb >= :awal AND kelompok_bermasalah.tanggal_kb <= :akhir
                GROUP BY pkp.nama,pkp.id
                ORDER BY pkp.nama asc
            ";

            $results = DB::select($query, [
                'cabang' => $cabang,
                'awal'   => $awal,
                'akhir'  => $akhir
            ]);

            foreach ($results as $row) {
                $pkp = $row->id;
            
                $kel_telat = DB::table('kelompok_bermasalah')
                    ->selectRaw('kelompok_kb,menit_kb,pembahasan_kb')
                    ->where('pkp_kb', $pkp)
                    ->whereBetween('tanggal_kb', [$awal, $akhir])
                    ->where('cabang_kb', $cabang)
                    ->where('kode_kb', '3A')
                    ->get();
            
                $kel_t="";
                $hasil_t="";
                $kel_b="";
                $hasil_b="";
                $noxx=1;
                foreach($kel_telat as $rowr){
                    if(!empty($rowr->kelompok_kb)){
                        $kel_t = $kel_t." [".$noxx."]".$rowr->kelompok_kb."-".$rowr->menit_kb." menit, ";
                        $hasil_t = $hasil_t."[".$noxx."]".$rowr->pembahasan_kb.". <br>";
                        $noxx = $noxx+1;
                    }
                }
                $row->kel_t  = $kel_t;
                $row->hasil_t = $hasil_t;
                
                $kel_berat = DB::table('kelompok_bermasalah')
                    ->selectRaw('kelompok_kb,menit_kb,pembahasan_kb')
                    ->where('pkp_kb', $pkp)
                    ->whereBetween('tanggal_kb', [$awal, $akhir])
                    ->where('cabang_kb', $cabang)
                    ->where('kode_kb', '3B')
                    ->get();

                $noxxx=1; 
                                                
                foreach($kel_berat as $rowrr){
                    if(!empty($rowrr->kelompok_kb)){
                    $kel_b = $kel_b." [".$noxxx."]".$rowrr->kelompok_kb."-".$rowrr->menit_kb." menit, ";
                    $hasil_b = $hasil_b."[".$noxxx."]".$rowrr->pembahasan_kb.". <br>";
                    $noxxx = $noxxx+1;
                    }
                }
                $row->kel_b  = $kel_b;
                $row->hasil_b = $hasil_b;
            }
            
        
        }
        $data = [
            'kab_kkb' => $kabkkb,
            'cabang'  => $cabang,
            'awal'    => $awal,
            'akhir'   => $akhir,
            'results' => $results,
        ];

        // dd($data);

        return view('kab_kkb.form-nasabah-kelompok-bermasalah', $data);
    }


    
    public function formKelompokBermasalah(Request $request)
    {
        $kabkkb = $request->input('kabkkb');
        $date_range = $request->input('daterange');
        $cabang = $request->input('cabang');

        $p_date = explode("to", $date_range);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date
        // dd($cabang, $awal, $akhir);       

        $results = DB::select("
            SELECT pkp.nama, pkp.id
            FROM pkp
            LEFT JOIN anggota_bermasalah ON pkp.id = anggota_bermasalah.pkp_ab
            LEFT JOIN kelompok_bermasalah ON kelompok_bermasalah.pkp_kb = pkp.id
            WHERE 
                (cabang_ab = $cabang OR cabang_kb = $cabang)
                AND ((anggota_bermasalah.tanggal_ab >= '$awal' AND anggota_bermasalah.tanggal_ab <= '$akhir') 
                OR (kelompok_bermasalah.tanggal_kb >= '$awal' AND kelompok_bermasalah.tanggal_kb <= '$akhir'))
                GROUP BY pkp.nama, pkp.id
            ");

        $data = [
            'kabkkb' => $kabkkb,  
            'cabang' => $cabang,
            'awal' => $awal,
            'akhir' => $akhir,
            'results' => $results
        ];

        return view('kab_kkb.form-kelompok-bermasalah', $data);
    }
    
    
    // public function getTableFormKelompokBermasalahKab(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $awal = $request->input('awal');
    //         $akhir = $request->input('akhir');
    //         $cabang = $request->input('cabang');

    //         $query = DB::select("
    //             SELECT pkp.nama, pkp.id
    //                 FROM pkp
    //                 LEFT JOIN anggota_bermasalah ON pkp.id = anggota_bermasalah.pkp_ab
    //                 LEFT JOIN kelompok_bermasalah ON kelompok_bermasalah.pkp_kb = pkp.id
    //                 WHERE 
    //                     (cabang_ab = $cabang OR cabang_kb = $cabang)
    //                     AND ((anggota_bermasalah.tanggal_ab >= $awal AND anggota_bermasalah.tanggal_ab <= $akhir) OR (kelompok_bermasalah.tanggal_kb >= $awal AND kelompok_bermasalah.tanggal_kb <= $akhir))
    //                 GROUP BY pkp.nama, pkp.id
    //         ");
            
    //         $filteredData = $query->orderBy('pkp.nama', 'asc')->get();
            
    //         $query2 = DB::select("
    //             SELECT id_anggota_ab FROM anggota_bermasalah
    //             WHERE pkp_ab = '$pkp' AND tanggal_ab >= '$awal' AND tanggal_ab <= '$akhir' AND cabang_ab = '$cabang'
    //         ");

    //         $dtr1=0;
    //         $dtr2=0;
    //         $dtr3=0;
    //         $nama_ab = "";
    //         $kel_ab ="";
    //         $nox=1;

    //         foreach($query2 as $rowx){
    //             $id_anggota = $rowx->id_anggota_ab;

    //             $query3 = DB::select("
    //                 SELECT count(id_ab) as total,nama_ab,kelompok_ab FROM anggota_bermasalah
    //                 WHERE id_anggota_ab = '$id_anggota'
    //             ");

    //             foreach($query3 as $rowr){
    //                 $nama_ab = $nama_ab."<p> [".$nox."]".$rowr->nama_ab.",</p>";
    //                 $kel_ab = $kel_ab."<p> [".$nox."]".$rowr->kelompok_ab.",</p>";
    //                 if($rowr->total > 0 && $rowr->total <= 1){
    //                     $dtr1 = $dtr1+1;
    //                     $dtr2 = $dtr2+0;
    //                     $dtr3 = $dtr3+0;
    //                  } else if($rowr->total >= 2 && $rowr->total <= 3){
    //                      $dtr1 = $dtr1+0;
    //                      $dtr2 = $dtr2+1;
    //                      $dtr3 = $dtr3+0;    
    //                  } else {
    //                      $dtr1 = $dtr1+0;
    //                      $dtr2 = $dtr2+0;
    //                      $dtr3 = $dtr3+1;
    //                  }
    //             }
    //             $nox = $nox+1;
    //         }

    //         return DataTables::of($filteredData)
    //             ->addIndexColumn()
                
    //             ->addColumn('total_ab', function ($row) {
    //                 $pkp_ab = $row->id;
    //                 $quee = DB::select("
    //                     SELECT count(id_ab) as total 
    //                     FROM anggota_bermasalah
    //                     WHERE pkp_ab = '$pkp_ab' AND tanggal_ab >= '$awal' AND tanggal_ab <= '$akhir' AND cabang_ab = '$cabang'
    //                 ");
                    
    //                 $total = $quee->total;
    //                 return $total;
    //             })
    //             ->addColumn('total_kb', function ($row) {
    //                 $pkp_kb = $row->id;
    //                 $queee = DB::select("
    //                     SELECT kelompok_kb, count(id_kb) as total FROM kelompok_bermasalah
    //                     WHERE pkp_kb = '$pkp_kb' AND tanggal_kb >= '$awal' AND tanggal_kb <= '$akhir' AND cabang_kb = '$cabang'
    //                 ");
                    
    //                 $total = $queee->total;
    //                 return $total;
    //             })
    //             ->addColumn('dtr_1', function ($row) {
    //                 $pkp_kb = $row->id;
    //                 $queee = DB::select("
    //                     SELECT kelompok_kb, count(id_kb) as total FROM kelompok_bermasalah
    //                     WHERE pkp_kb = '$pkp_kb' AND tanggal_kb >= '$awal' AND tanggal_kb <= '$akhir' AND cabang_kb = '$cabang'
    //                 ");
                    
    //                 $total = $queee->total;
    //                 return $total;
    //             })
                
    //             ->rawColumns(['total_ab','total_kb'])
    //             ->make(true);
    //     }
    // }
    public function getTableFormKelompokBermasalahKab(Request $request)
    {
        try {
            if ($request->ajax()) {
                $awal = $request->input('awal');
                $akhir = $request->input('akhir');
                $cabang = $request->input('cabang');

                // Validate the input data
                if (!$awal || !$akhir || !$cabang) {
                    return response()->json(['error' => 'Invalid input data.'], 400);
                }
    
                $query = DB::select("
                    SELECT pkp.nama, pkp.id
                    FROM pkp
                    LEFT JOIN anggota_bermasalah ON pkp.id = anggota_bermasalah.pkp_ab
                    LEFT JOIN kelompok_bermasalah ON kelompok_bermasalah.pkp_kb = pkp.id
                    WHERE 
                        (cabang_ab = $cabang OR cabang_kb = $cabang)
                        AND ((anggota_bermasalah.tanggal_ab >= '$awal' AND anggota_bermasalah.tanggal_ab <= '$akhir') 
                        OR (kelompok_bermasalah.tanggal_kb >= '$awal' AND kelompok_bermasalah.tanggal_kb <= '$akhir'))
                    GROUP BY pkp.nama, pkp.id
                ");
                
                // Data processing for dtr1, dtr2, dtr3
                $data = [];
                foreach ($query as $row) {
                    $pkp = $row->id;
                    // Initialize counts
                    $dtr1 = 0;
                    $dtr2 = 0;
                    $dtr3 = 0;
                    $nama_ab = "";
                    $kel_ab = "";
                    $nox = 1;
    
                    // Get anggota_bermasalah for this pkp
                    $query2 = DB::select("
                        SELECT id_anggota_ab FROM anggota_bermasalah
                        WHERE pkp_ab = $pkp AND tanggal_ab >= '$awal' AND tanggal_ab <= '$akhir' AND cabang_ab = $cabang
                    ");
    
                    foreach ($query2 as $rowx) {
                        $id_anggota = $rowx->id_anggota_ab;
    
                        $query3 = DB::select("
                            SELECT count(id_ab) as total, nama_ab, kelompok_ab 
                            FROM anggota_bermasalah
                            WHERE id_anggota_ab = $id_anggota
                        ");
    
                        foreach ($query3 as $rowr) {
                            $nama_ab .= "<p> [{$nox}] {$rowr->nama_ab},</p>";
                            $kel_ab .= "<p> [{$nox}] {$rowr->kelompok_ab},</p>";
    
                            if ($rowr->total > 0 && $rowr->total <= 1) {
                                $dtr1 += 1;
                            } elseif ($rowr->total >= 2 && $rowr->total <= 3) {
                                $dtr2 += 1;
                            } else {
                                $dtr3 += 1;
                            }
                            $nox++;
                        }
                    }
    
                    $data[] = [
                        'nama' => $row->nama,
                        'total_ab' => $this->getTotalAb($pkp, $awal, $akhir, $cabang),
                        'total_kb' => $this->getTotalKb($pkp, $awal, $akhir, $cabang),
                        'nama_ab' => $nama_ab,
                        'kel_ab' => $kel_ab,
                        'dtr1' => $dtr1,
                        'dtr2' => $dtr2,
                        'dtr3' => $dtr3,
                    ];
                }
    
                return response()->json($data); // Send the response if everything is okay
    
            }
        } catch (\Exception $e) {
            // Catch and log errors
            \Log::error('Error fetching data: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
        }
    }

    // Helper functions for total_ab and total_kb
    private function getTotalAb($pkp_ab, $awal, $akhir, $cabang)
    {
        $result = DB::select("
            SELECT count(id_ab) as total 
            FROM anggota_bermasalah
            WHERE pkp_ab = $pkp_ab AND tanggal_ab >= $awal AND tanggal_ab <= $akhir AND cabang_ab = $cabang
        ");

        return $result[0]->total ?? 0;
    }

    private function getTotalKb($pkp_kb, $awal, $akhir, $cabang)
    {
        $result = DB::select("
            SELECT count(id_kb) as total 
            FROM kelompok_bermasalah
            WHERE pkp_kb = $pkp_kb AND tanggal_kb >= $awal AND tanggal_kb <= $akhir AND cabang_kb = $cabang
        ");

        return $result[0]->total ?? 0;
    }

    
    public function getTableRangkumanDtr(Request $request)
    {
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::table('anggota_bermasalah')
                ->select('penyebab_ab', DB::raw('COUNT(id_ab) as jumlah'))
                ->where('tanggal_ab','>=', $awal)
                ->where('tanggal_ab','<=', $akhir);
               

            if ($request->input('cabang') != '0') {
                $query->where('cabang_ab',  $request->input('cabang') );
            }

            $filteredData = $query->groupBy('penyebab_ab')
                ->orderBy('penyebab_ab', 'ASC')
                ->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-history btn-sm" data-id="' . $row->penyebab_ab . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function historyKunjunganKab(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('kunjungan_ab')
                ->where('id_ab_kunjungan', $request->input('id_ab'))
                ->select('*');

            

            $filteredData = $query->orderBy('id_ab_kunjungan', 'desc')->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_kunjungan);
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-history btn-sm" data-id="' . $row->id_kunjungan . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                ->addColumn('status_bertemu', function ($row) {
                    if ($row->bertemu_kunjungan == '1') {
                        $status = '<span class="badge badge-light-success">' . $row->tanggal_kunjungan . '</span>';
                    } else {
                        $status = '<span class="badge badge-light-danger">' . $row->tanggal_kunjungan . '</span>';
                    }
                    return $status;
                })

                ->rawColumns(['action','status_bertemu'])
                ->make(true);
        }
    }

    public function deleteHistorynAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_kunjungan' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $deleted = DB::table('kunjungan_ab')->where('id_kunjungan', $request->id_kunjungan)->delete();

        $this->dataService->createAuditTrail('Hapus History Kunjungan');

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus history']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus history']);
        }
    }

    
    public function getTableKab(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $pkp = Session::get('id_user2');
            $query = DB::table('anggota_bermasalah')
                ->select('anggota_bermasalah.*');

            if ($request->filled('daterange')) {
                $date_range = $request->input('daterange');
                $decoded_date_range = urldecode($date_range);
                if (str_contains($decoded_date_range, ' to ')) {
                    [$awal, $akhir] = explode(' to ', $decoded_date_range);
                    if(Session::get('id_role2') == "3"){
                        if(Session::get('is_kc') == "1"){
                            $query->where('tanggal_ab', '>=', $awal)
                                ->where('tanggal_ab', '<=', $akhir)
                                ->where('cabang_ab', $cabang)
                                ->where(function ($query) {
                                    $query->whereNull('dikunjungi_ab')
                                        ->orWhere('dikunjungi_ab', '0')
                                        ->orWhere('dikunjungi_ab', '2');
                                });
                        }else{
                            $query->where('tanggal_ab', '>=', $awal)
                                ->where('tanggal_ab', '<=', $akhir)
                                ->where('pkp_ab', $pkp)
                                ->where(function ($query) {
                                    $query->whereNull('dikunjungi_ab')
                                        ->orWhere('dikunjungi_ab', '0')
                                        ->orWhere('dikunjungi_ab', '2');
                                });
                        }
        
                    
                    }else if(Session::get('id_role2') == "0"){
                        $query->where('tanggal_ab', '>=', $awal)
                            ->where('tanggal_ab', '<=', $akhir)
                            ->where('cabang_ab', $cabang)
                            ->where(function ($query) {
                                $query->whereNull('dikunjungi_ab')
                                    ->orWhere('dikunjungi_ab', '0')
                                    ->orWhere('dikunjungi_ab', '2');
                            });
                    }else{
                        $query->where('tanggal_ab', '>=', $awal)
                            ->where('tanggal_ab', '<=', $akhir)
                            ->where(function ($query) {
                                $query->whereNull('dikunjungi_ab')
                                    ->orWhere('dikunjungi_ab', '0')
                                    ->orWhere('dikunjungi_ab', '2');
                            });
                    }

                }else{
                    $awal = '';
                    $akhir = '';
                }
            }else{

            }
            

            if ($request->filled('anggota')) {
                $query->where('anggota_bermasalah.nama_ab', 'like', '%' . $request->input('anggota') . '%');
            }
            if ($request->filled('kelompok')) {
                $query->where('anggota_bermasalah.kelompok_ab', 'like', '%' . $request->input('kelompok') . '%');
            }
          

            $filteredData = $query->orderBy('id_ab', 'desc')->get();
            // dd($filteredData);
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_ab);

                   
                    
                    $btn = '<button title="EDIT" class="btn btn-warning btn-edit-kab btn-sm" data-id="' . $row->id_ab . '"><span class="fa fa-pencil"></span></button>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    if($row->dikunjungi_ab == '1'){
                        if($row->bertemu_ibu_ab == '1'){
                            if($row->uang_dikembalikan_ab == '1'){
                                $status="<span class='text-white badge badge-success'>Selesai</span>";
                            } else {
                                $status="<span class='text-white badge badge-warning'>sudah dikunjungi tapi belum balik uang</span>";
                            }
                        } else {
                            if($row->kabur_ab == '1'){
                                $status="<span class='text-white badge badge-danger'>Anggota kabur</span>";
                            } else {
                                $status="<span class='text-white badge badge-danger'>Sudah dikunjungi tapi tidak ketemu</span>";
                            }
                        }
                        
                    }else if($row->dikunjungi_ab=='2'){
                        if($row->kabur_ab=='1'){
                            $status="<span class='text-white badge badge-danger'>Anggota Kabur || Tidak Bisa Dikunjungi</span>";
                        } else {
                            $status="<span class='text-white badge badge-danger'>Tidak Bisa Dikunjungi</span>";
                        }
                    } else {
                        $status="<span class='text-white badge badge-danger'>Belum Dikunjungi</span>";
                    }


                    // Accessing value from $data
                    return $status;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    
    public function getTableKkb(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $pkp = Session::get('id_user2');
            $query = DB::table('kelompok_bermasalah')
                ->select('kelompok_bermasalah.*');

            if ($request->filled('daterange')) {
                $date_range = $request->input('daterange');
                $decoded_date_range = urldecode($date_range);
                if (str_contains($decoded_date_range, ' to ')) {
                    [$awal, $akhir] = explode(' to ', $decoded_date_range);
                    if(Session::get('id_role2') == "3"){
                        if(Session::get('is_kc') == "1"){
                            $query->where('tanggal_kb', '>=', $awal)
                                ->where('tanggal_kb', '<=', $akhir)
                                ->where('cabang_kb', $cabang)
                                ->where(function ($query) {
                                    $query->whereNull('dikumpulkan_kb')
                                        ->orWhere('dikumpulkan_kb', '0')
                                        ->orWhere('dikumpulkan_kb', '2');
                                });
                        }else{
                            $query->where('tanggal_kb', '>=', $awal)
                                ->where('tanggal_kb', '<=', $akhir)
                                ->where('pkp_kb', $pkp)
                                ->where(function ($query) {
                                    $query->whereNull('dikumpulkan_kb')
                                        ->orWhere('dikumpulkan_kb', '0')
                                        ->orWhere('dikumpulkan_kb', '2');
                                });
                        }
        
                    
                    }else if(Session::get('id_role2') == "0"){
                        $query->where('tanggal_kb', '>=', $awal)
                            ->where('tanggal_kb', '<=', $akhir)
                            ->where('cabang_kb', $cabang)
                            ->where(function ($query) {
                                $query->whereNull('dikumpulkan_kb')
                                    ->orWhere('dikumpulkan_kb', '0')
                                    ->orWhere('dikumpulkan_kb', '2');
                            });
                    }else{
                        $query->where('tanggal_kb', '>=', $awal)
                            ->where('tanggal_kb', '<=', $akhir)
                            ->where(function ($query) {
                                $query->whereNull('dikumpulkan_kb')
                                    ->orWhere('dikumpulkan_kb', '0')
                                    ->orWhere('dikumpulkan_kb', '2');
                            });
                    }

                }else{
                    $awal = '';
                    $akhir = '';
                }
            }else{

            }
            

            if ($request->filled('kelompok')) {
                $query->where('kelompok_bermasalah.kelompok_kb', 'like', '%' . $request->input('kelompok') . '%');
            }
          

            $filteredData = $query->orderBy('id_kb', 'desc')->get();
            // dd($filteredData);
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_kb);

                   
                    
                    $btn = '<button title="EDIT" class="btn btn-warning btn-edit-kab btn-sm" data-id="' . $row->id_kb . '"><span class="fa fa-pencil"></span></button>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    if($row->dikumpulkan_kb == '1'){
                        $status="<span class='text-white badge badge-success'>Sudah Dikumpulkan</span>";
                    
                    } else {
                        $status="<span class='text-white badge badge-danger'>Belum Dikumpulkan</span>";
                    }


                    // Accessing value from $data
                    return $status;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function editABDikunjungi($id_ab, Request $request)
    {

        $menu_aktif = '/pengisianKab||/kabkkb';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Edit Pengisian KAB',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>',
            'id_ab' => $id_ab
        ];

        return view('kab_kkb.edit-kab', $data);
    }

    
    public function getTableKabDikunjungi(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $pkp = Session::get('id_user2');
            $query = DB::table('anggota_bermasalah')
                ->select('anggota_bermasalah.*');

            if ($request->filled('daterange')) {
                $date_range = $request->input('daterange');
                $decoded_date_range = urldecode($date_range);
                if (str_contains($decoded_date_range, ' to ')) {
                    [$awal, $akhir] = explode(' to ', $decoded_date_range);
                    if(Session::get('id_role2') == "3"){
                        if(Session::get('is_kc') == "1"){
                            $query->where('tanggal_ab', '>=', $awal)
                                ->where('tanggal_ab', '<=', $akhir)
                                ->where('cabang_ab', $cabang)
                                ->where(function ($query) {
                                    $query->Where('dikunjungi_ab', '1')
                                        ->orWhere('penyebab_ab', 'Kabur');
                                });
                        }else{
                            $query->where('tanggal_ab', '>=', $awal)
                                ->where('tanggal_ab', '<=', $akhir)
                                ->where('pkp_ab', $pkp)
                                ->where(function ($query) {
                                    $query->Where('dikunjungi_ab', '1')
                                        ->orWhere('penyebab_ab', 'Kabur');
                                });
                        }
        
                    
                    }else if(Session::get('id_role2') == "0"){
                        $query->where('tanggal_ab', '>=', $awal)
                            ->where('tanggal_ab', '<=', $akhir)
                            ->where('cabang_ab', $cabang)
                            ->where(function ($query) {
                                $query->Where('dikunjungi_ab', '1')
                                    ->orWhere('penyebab_ab', 'Kabur');
                            });
                    }else{
                        $query->where('tanggal_ab', '>=', $awal)
                            ->where('tanggal_ab', '<=', $akhir)
                            ->where(function ($query) {
                                $query->Where('dikunjungi_ab', '1')
                                    ->orWhere('penyebab_ab', 'Kabur');
                            });
                    }

                }else{
                    $awal = '';
                    $akhir = '';
                }
            }else{
            }
            
            if ($request->filled('anggota')) {
                $query->where('anggota_bermasalah.nama_ab', 'like', '%' . $request->input('anggota') . '%');
            }
            if ($request->filled('kelompok')) {
                $query->where('anggota_bermasalah.kelompok_ab', 'like', '%' . $request->input('kelompok') . '%');
            }

            $filteredData = $query->orderBy('id_ab', 'desc')->get();
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_ab);

                    $editUrl = route('editABDikunjungi', $row->id_ab);
                    $btn = '<a target=_blank href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    if($row->dikunjungi_ab == '1'){
                        if($row->bertemu_ibu_ab == '1'){
                            if($row->uang_dikembalikan_ab == '1'){
                                $status="<span class='text-white badge badge-success'>Selesai</span>";
                            } else {
                                $status="<span class='text-white badge badge-warning'>sudah dikunjungi tapi belum balik uang</span>";
                            }
                        } else {
                            if($row->kabur_ab == '1'){
                                $status="<span class='text-white badge badge-danger'>Anggota kabur</span>";
                            } else {
                                $status="<span class='text-white badge badge-danger'>Sudah dikunjungi tapi tidak ketemu</span>";
                            }
                        }
                        
                    }else if($row->dikunjungi_ab=='2'){
                        if($row->kabur_ab=='1'){
                            $status="<span class='text-white badge badge-danger'>Anggota Kabur || Tidak Bisa Dikunjungi</span>";
                        } else {
                            $status="<span class='text-white badge badge-danger'>Tidak Bisa Dikunjungi</span>";
                        }
                    } else {
                        $status="<span class='text-white badge badge-danger'>Belum Dikunjungi</span>";
                    }
                    return $status;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    
    public function getTableKkbDikunjungi(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $pkp = Session::get('id_user2');
            $query = DB::table('kelompok_bermasalah')
                ->select('kelompok_bermasalah.*');

            if ($request->filled('daterange')) {
                $date_range = $request->input('daterange');
                $decoded_date_range = urldecode($date_range);
                if (str_contains($decoded_date_range, ' to ')) {
                    [$awal, $akhir] = explode(' to ', $decoded_date_range);
                    if(Session::get('id_role2') == "3"){
                        if(Session::get('is_kc') == "1"){
                            $query->where('tanggal_kb', '>=', $awal)
                                ->where('tanggal_kb', '<=', $akhir)
                                ->where('cabang_kb', $cabang)
                                ->where('dikumpulkan_kb', '1');
                        }else{
                            $query->where('tanggal_kb', '>=', $awal)
                                ->where('tanggal_kb', '<=', $akhir)
                                ->where('pkp_kb', $pkp)
                                ->where('dikumpulkan_kb', '1');
                        }
        
                    
                    }else if(Session::get('id_role2') == "0"){
                        $query->where('tanggal_kb', '>=', $awal)
                            ->where('tanggal_kb', '<=', $akhir)
                            ->where('cabang_kb', $cabang)
                            ->where('dikumpulkan_kb', '1');
                    }else{
                        $query->where('tanggal_kb', '>=', $awal)
                            ->where('tanggal_kb', '<=', $akhir)
                            ->where('dikumpulkan_kb', '1');
                    }

                }else{
                    $awal = '';
                    $akhir = '';
                }
            }else{
            }
            
            
            if ($request->filled('kelompok')) {
                $query->where('kelompok_bermasalah.kelompok_kb', 'like', '%' . $request->input('kelompok') . '%');
            }
            // dd($query->toSql(), $query->getBindings());


            $filteredData = $query->orderBy('id_kb', 'desc')->get();
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_kb);

                    // $editUrl = route('editABDikunjungi', $row->id_kb);
                    // $btn = '<a target=_blank href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';

                    $btn = '<button title="EDIT" class="btn btn-warning btn-edit-kab btn-sm" data-id="' . $row->id_kb . '"><span class="fa fa-pencil"></span></button>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    if($row->dikumpulkan_kb == '1'){
                        $status="<span class='text-white badge badge-success'>Sudah Dikumpulkan</span>";
                    
                    } else {
                        $status="<span class='text-white badge badge-danger'>Belum Dikumpulkan</span>";
                    }
                    return $status;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }
    

    public function getDetailAb($id)
    {
        $data = DB::table('anggota_bermasalah')
            ->select('anggota_bermasalah.*')
            ->where('anggota_bermasalah.id_ab', $id)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }


        return response()->json($data);
    }

    public function getDetailKb($id)
    {
        $data = DB::table('kelompok_bermasalah')
            ->select('kelompok_bermasalah.*')
            ->where('kelompok_bermasalah.id_kb', $id)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }


        return response()->json($data);
    }

    public function updatePengisianAb(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $himbau = $request->himbauan_ab;
        if($himbau !=""){
            $himbau1 = implode(",",$himbau);
            if($request->himbauan_ab2!=""){
                $himbauan = $himbau1.", ".$request->himbauan_ab2;
            } else {
                $himbauan = $himbau1;
            }    
        } else  {
            $himbauan = $request->himbauan_ab2;
        }

        if($request->penyebab_ab=="lainnya"){
            $penyebab = "8. ".$request->penyebab2;
            $kabur = '0';
        } else if($request->penyebab_ab=="skt"){
            $penyebab = "2. Ibu tsb sakit";
            $kabur = '0';
        } else if($request->penyebab_ab=="Kabur"){
            $penyebab = "1. Kabur";
            $kabur = '1';
        } else if($request->penyebab_ab=="Pulkam"){
            $penyebab = "4. Pulkam";
            $kabur = '0';
        } else if($request->penyebab_ab=="kel-skt"){
            $penyebab = "3. Keluarga ibu sakit";
            $kabur = '0';
        } else if($request->penyebab_ab=="pindah"){
            $penyebab = "5. Pindah rumah";
            $kabur = '0';
        } else if($request->penyebab_ab=="usaha"){
            $penyebab = "6. Usaha tidak jalan / sepi";
            $kabur = '0';
        } else if($request->penyebab_ab=="blm"){
            $penyebab = "7. Belum ada penjelasan";
            $kabur = '0';
        }else {
            $penyebab = $request->penyebab_ab;
            $kabur = '0';
        }
       

        $dikunjung = $request->dikunjungi_ab;
        $tanggal = $request->tanggal_dikunjungi_ab;

        if($dikunjung=="00"){
            $dikunjungi="0";
        } else if($dikunjung=="11"){
            $dikunjungi="1";
        } else if($dikunjung=="22"){
            $dikunjungi="2"; 
        } else{
            if($tanggal==""){
                $dikunjungi="0";
            } else {
                $dikunjungi="1";
            }
        }


        $ab = DB::table('anggota_bermasalah')
            ->where('id_ab', $request->id)
            ->update([
                'dikunjungi_ab'     => $dikunjungi,
                'tanggal_dikunjungi_ab'  => $tanggal,
                'bertemu_ibu_ab'        => $request->bertemu_ibu_ab,
                'uang_dikembalikan_ab'  => $request->uang,
                'penyebab_ab'        => $request->penyebab_ab,
                'kabur_ab'        => $kabur,
                'himbauan_ab'        => $himbauan,
                'setoran_lancar_ab'  => $request->setoran_lancar,
                'penyebab_ab'        => $penyebab,
                'motivasi_kc_ab'        => $request->motivasi,
                'update_at_ab' => date("Y-m-d H:i:s")
            ]);

        $kunjungan = DB::table('kunjungan_ab')->insert([
                'id_ab_kunjungan'   => $request->id,
                'bertemu_kunjungan'  => $request->bertemu_ibu_ab,
                'tanggal_kunjungan' => $tanggal
            ]);

        if ($ab) {
            return response()->json(['success' => true, 'message' => 'Berhasil update kunjungan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update kunjungan']);
        }

    }

    public function updatePengisianKb(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if($request->pembahasan_kb != ""){
            $pembahasan1 = $request->pembahasan_kb;
            if($request->pembahasan_lainnya_kb != ""){
                $isi_pembahasan = $pembahasan1.",".$request->pembahasan_lainnya_kb;
            }else{
                $isi_pembahasan = $pembahasan1;
            }
        }else{
            $isi_pembahasan = $request->pembahasan_lainnya_kb;
        }

        if($request->dikumpulkan_kb == ""){
            if($request->tanggal_dikumpulkan_kb != ""){
                $dikumpulkan = 1;
            }else{
                $dikumpulkan = 0;
            }
        }else{
            $dikumpulkan = $request->dikumpulkan_kb;
        }

        $kb = DB::table('kelompok_bermasalah')
            ->where('id_kb', $request->id)
            ->update([
                'dikumpulkan_kb'     => $dikumpulkan,
                'tanggal_dikumpulkan_kb'  => $request->tanggal_dikumpulkan_kb,
                'jumlah_dikumpulkan_kb'        => $request->jumlah_dikumpulkan_kb,
                'pembahasan_kb'  => $isi_pembahasan,
                'update_at_kb'        => date("Y-m-d H:i:s")
                
            ]);
            // dd($kb);
       

        if ($kb) {
            $this->dataService->createAuditTrail('Pengisian Kelompok Bermasalah');
            return response()->json(['success' => true, 'message' => 'Berhasil update kunjungan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update kunjungan']);
        }

    }

    
    public function gettableKKBUssi(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');
            $tanggal = $request->input('tanggal');

            $query = DB::connection('mysql_secondary')
                ->table('kretrans as A')
                ->join('kre_kode_group1 as B', 'A.kode_group1_trans', '=', 'B.kode_group1')
                ->join('app_kode_kantor as C', 'C.KODE_KANTOR', '=', 'A.kode_kantor')
                ->join('kre_kode_group2 as D', 'D.kode_group2', '=', 'A.kode_group2_trans')
                ->select('A.ANGSURAN_KE','telat_per_berat','A.menit_telat_per_berat','B.deskripsi_group1', 'C.NAMA_KANTOR','D.deskripsi_group2')

                ->where('A.TGL_TRANS', $tanggal)
                ->where('A.telat_per_berat','>', 0)
                ->where('A.KODE_TRANS',  300);

                

            $query->groupBy('A.ANGSURAN_KE','telat_per_berat','A.menit_telat_per_berat','B.deskripsi_group1', 'C.NAMA_KANTOR','D.deskripsi_group2')->orderBy('A.TGL_TRANS', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()  // This is for the row index numbering
                ->addColumn('action', function ($row) {
                    $infoUrl = route('user.infoUser', $row->ANGSURAN_KE);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })

                ->addColumn('kasus', function ($row) {
                    if($row->telat_per_berat == 1){
                        $kasus = '<span class="badge badge-warning">Telat</span>';
                    }else{
                        $kasus = '<span class="badge badge-danger">Berat</span>';
                    }
                    return $kasus;
                })
               
                ->rawColumns(['action','kasus'])
                ->make(true);
        }
    }

    
    public function migrasiKkb(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $kkb_ussi = DB::connection('mysql_secondary')
                ->table('kretrans as A')
                ->join('kre_kode_group1 as B', 'A.kode_group1_trans', '=', 'B.kode_group1')
                ->join('app_kode_kantor as C', 'C.KODE_KANTOR', '=', 'A.kode_kantor')
                ->join('kre_kode_group2 as D', 'D.kode_group2', '=', 'A.kode_group2_trans')
                ->join('kredit as E', 'E.kode_group1', '=', 'B.kode_group1')
                ->select('D.deskripsi_group2','A.ANGSURAN_KE','telat_per_berat','A.menit_telat_per_berat','B.deskripsi_group1', 'C.NAMA_KANTOR','D.deskripsi_group2','E.tgl_realisasi','A.TGL_TRANS','A.kode_kantor','B.kode_group1')
                ->where('A.TGL_TRANS', $tanggal)
                ->where('A.telat_per_berat','>', 0)
                ->where('A.KODE_TRANS',  300)
                ->groupBy('D.deskripsi_group2','A.ANGSURAN_KE','telat_per_berat','A.menit_telat_per_berat','B.deskripsi_group1', 'C.NAMA_KANTOR','D.deskripsi_group2','E.tgl_realisasi','A.TGL_TRANS','A.kode_kantor','B.kode_group1')
                ->orderBy('A.TGL_TRANS', 'asc')->get();
        // dd($kkb_ussi);
        foreach($kkb_ussi as $data){
            $tanggal_pencairan_kb = $data->tgl_realisasi." 00:00:00";
            if($data->telat_per_berat == 1){
                $kode = '3A';
            }else{
                $kode = '3B';
            }
            $kode_kantor = ltrim($data->kode_kantor, '0');

            $cek_exist = DB::table('kelompok_bermasalah')->select('id_kb')
                    ->where('kelompok_kb', $data->deskripsi_group1)
                    ->where('tanggal_kb', $data->TGL_TRANS)
                    ->where('tanggal_pencairan_kb', $tanggal_pencairan_kb)
                    ->where('cabang_kb', $kode_kantor)
                    ->where('setoran_kb', $data->ANGSURAN_KE)->first();

            if(!$cek_exist){
                echo "insert"."<br>";
                $kb = DB::table('kelompok_bermasalah')->insert([
                    'kelompok_kb'   => $data->deskripsi_group1,
                    'tanggal_pencairan_kb'  => $tanggal_pencairan_kb,
                    'tanggal_kb' => $data->TGL_TRANS,
                    'menit_kb' => round($data->menit_telat_per_berat),
                    'kode_kb' => $kode,
                    'setoran_kb' => $data->ANGSURAN_KE,
                    'cabang_kb' => $kode_kantor,
                    'id_sikki_kb' => $data->kode_group1,
                    'pkp_nama' => $data->deskripsi_group2
                ]);
            }else{
                echo "exist"."<br>";
            }

        }


    }

    
    public function migrasiKab(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $kab_ussi = DB::connection('mysql_secondary')
                ->table('kretrans as A')
                ->join('kre_kode_group1 as B', 'A.kode_group1_trans', '=', 'B.kode_group1')
                ->join('app_kode_kantor as C', 'C.KODE_KANTOR', '=', 'A.kode_kantor')
                ->join('kre_kode_group2 as D', 'D.kode_group2', '=', 'A.kode_group2_trans')
                ->join('kredit as E', 'E.no_rekening', '=', 'A.NO_REKENING')
                ->join('nasabah as F','F.nasabah_id', '=', 'E.nasabah_id')
                ->select('D.deskripsi_group2','E.no_rekening','E.tgl_realisasi', 'A.TGL_TRANS','F.NAMA_NASABAH','E.nasabah_id','A.ANGSURAN_KE','telat_per_berat','A.menit_telat_per_berat','B.deskripsi_group1', 'C.NAMA_KANTOR','D.deskripsi_group2','A.kode_kantor')
                ->where('A.TGL_TRANS', $tanggal)
                ->where('A.dtr','Ya')
                ->where('A.KODE_TRANS',  300)
                ->orderBy('A.TGL_TRANS', 'asc')->get();
        // dd($kab_ussi);
        foreach($kab_ussi as $data){
            // $tanggal_pencairan_kb = $data->tgl_realisasi." 00:00:00";
            // if($data->telat_per_berat == 1){
            //     $kode = '3A';
            // }else{
            //     $kode = '3B';
            // }
            $kode_kantor = ltrim($data->kode_kantor, '0');

            $cek_exist = DB::table('anggota_bermasalah')->select('id_ab')
                    ->where('nama_ab', $data->NAMA_NASABAH)
                    ->where('cabang_ab', $kode_kantor)
                    ->where('kelompok_ab', $data->deskripsi_group1)
                    ->where('tanggal_cair_ab', $data->tgl_realisasi)
                    ->where('id_anggota_ab', $data->nasabah_id)
                    ->where('setoran_ab', $data->ANGSURAN_KE)
                    ->where('tanggal_ab', $data->TGL_TRANS)
                    ->first();

            if(!$cek_exist){
                echo "insert"."<br>";
                $kb = DB::table('anggota_bermasalah')->insert([
                    'nama_ab'   => $data->NAMA_NASABAH,
                    'cabang_ab'  => $kode_kantor,
                    'kelompok_ab' => $data->deskripsi_group1,
                    'id_anggota_ab' => $data->nasabah_id,
                    'setoran_ab' => $data->ANGSURAN_KE,
                    'tanggal_ab' => $data->TGL_TRANS,
                    'kode_ab' => 2,
                    'id_sikki_ab' => $data->no_rekening,
                    'tanggal_cair_ab' => $data->tgl_realisasi,
                    'pkp_nama_ab' => $data->deskripsi_group2
                ]);
            }else{
                echo "exist"."<br>";
            }

        }


    }

    public function gettableKABUssi(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');
            $tanggal = $request->input('tanggal');

            $query = DB::connection('mysql_secondary')
                ->table('kretrans as A')
                ->join('kre_kode_group1 as B', 'A.kode_group1_trans', '=', 'B.kode_group1')
                ->join('app_kode_kantor as C', 'C.KODE_KANTOR', '=', 'A.kode_kantor')
                ->join('kre_kode_group2 as D', 'D.kode_group2', '=', 'A.kode_group2_trans')
                ->join('kredit as E', 'E.no_rekening', '=', 'A.NO_REKENING')
                ->join('nasabah as F', 'F.nasabah_id', '=', 'E.nasabah_id')
                ->select('F.NAMA_NASABAH','E.nasabah_id','A.ANGSURAN_KE','telat_per_berat','A.menit_telat_per_berat','B.deskripsi_group1', 'C.NAMA_KANTOR','D.deskripsi_group2')
                ->where('A.TGL_TRANS', $tanggal)
                ->where('A.dtr','Ya')
                ->where('A.KODE_TRANS',  300);
            $query->orderBy('A.TGL_TRANS', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()  // This is for the row index numbering
                ->addColumn('action', function ($row) {
                    $infoUrl = route('user.infoUser', $row->ANGSURAN_KE);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })

                ->addColumn('kasus', function ($row) {
                    if($row->telat_per_berat == 1){
                        $kasus = '<span class="badge badge-warning">1</span>';
                    }else{
                        $kasus = '<span class="badge badge-danger">2</span>';
                    }
                    return $kasus;
                })
               
                ->rawColumns(['action','kasus'])
                ->make(true);
        }
    }

    
    public function exportDownloadKabUssi(Request $request)
    {
        $tanggal = $request->input('tanggal');
        
        $data = DB::connection('mysql_secondary')
            ->table('kretrans as A')
            ->join('kre_kode_group1 as B', 'A.kode_group1_trans', '=', 'B.kode_group1')
            ->join('app_kode_kantor as C', 'C.KODE_KANTOR', '=', 'A.kode_kantor')
            ->join('kre_kode_group2 as D', 'D.kode_group2', '=', 'A.kode_group2_trans')
            ->join('kredit as E', 'E.no_rekening', '=', 'A.NO_REKENING')
            ->join('nasabah as F', 'F.nasabah_id', '=', 'E.nasabah_id')
            ->select(
                'A.TGL_TRANS', 
                'A.ANGSURAN_KE', 
                'A.telat_per_berat', 
                'A.menit_telat_per_berat', 
                'B.deskripsi_group1', 
                'C.NAMA_KANTOR', 
                'D.deskripsi_group2', 
                'E.tgl_realisasi',
                'F.NAMA_NASABAH',
                'E.nasabah_id'
            )
            ->where('A.TGL_TRANS', $tanggal)
            ->where('A.telat_per_berat', '>', 0)
            ->where('A.KODE_TRANS',  300)
            ->orderBy('A.TGL_TRANS', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header columns
        $sheet->setCellValue('A1', 'KELOMPOK')
            ->setCellValue('B1', 'ID')
            ->setCellValue('C1', 'ANGGOTA')
            ->setCellValue('D1', 'SETORAN KE')
            ->setCellValue('E1', 'TANGGAL MASALAH')
            ->setCellValue('F1', 'GROUP CASE')
            ->setCellValue('G1', 'MENIT')
            ->setCellValue('H1', 'PKP')
            ->setCellValue('I1', 'CABANG');

        $row = 2; // Start from row 2 after the header
        foreach ($data as $user) {

            // Write data to the spreadsheet
            $sheet->setCellValue('A' . $row, $user->deskripsi_group1)
                ->setCellValue('B' . $row, $user->nasabah_id ?? '')
                ->setCellValue('C' . $row, $user->NAMA_NASABAH ?? '')
                ->setCellValue('D' . $row, $user->ANGSURAN_KE ?? '')
                ->setCellValue('E' . $row, $user->TGL_TRANS ?? '')
                ->setCellValue('F' . $row, $user->telat_per_berat ?? '')
                ->setCellValue('G' . $row, $user->menit_telat_per_berat ?? '')
                ->setCellValue('H' . $row, $user->deskripsi_group2 ?? '')
                ->setCellValue('I' . $row, $user->NAMA_KANTOR);

            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output Excel file to the browser
        $filename = 'kab_USSI.xlsx';
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

    public function exportDownloadKkbUssi(Request $request)
    {
        $tanggal = $request->input('tanggal');
        
        $data = DB::connection('mysql_secondary')
            ->table('kretrans as A')
            ->join('kre_kode_group1 as B', 'A.kode_group1_trans', '=', 'B.kode_group1')
            ->join('app_kode_kantor as C', 'C.KODE_KANTOR', '=', 'A.kode_kantor')
            ->join('kre_kode_group2 as D', 'D.kode_group2', '=', 'A.kode_group2_trans')
            ->join('kredit as E', 'E.kode_group1', '=', 'A.kode_group1_trans')
            ->select(
                'A.TGL_TRANS', 
                'A.ANGSURAN_KE', 
                'A.telat_per_berat', 
                'A.menit_telat_per_berat', 
                'B.deskripsi_group1', 
                'C.NAMA_KANTOR', 
                'D.deskripsi_group2', 
                'E.tgl_realisasi'
            )
            ->where('A.TGL_TRANS', $tanggal)
            ->where('A.telat_per_berat', '>', 0)
            ->where('A.KODE_TRANS',  300)
            ->groupBy(
                'A.TGL_TRANS', 
                'A.ANGSURAN_KE', 
                'A.telat_per_berat', 
                'A.menit_telat_per_berat', 
                'B.deskripsi_group1', 
                'C.NAMA_KANTOR', 
                'D.deskripsi_group2', 
                'E.tgl_realisasi'
            )
            ->orderBy('A.TGL_TRANS', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header columns
        $sheet->setCellValue('A1', 'KELOMPOK')
            ->setCellValue('B1', 'SETORAN KE')
            ->setCellValue('C1', 'TANGGAL MASALAH')
            ->setCellValue('D1', 'KODE')
            ->setCellValue('E1', 'MENIT')
            ->setCellValue('F1', 'PKP')
            ->setCellValue('G1', 'TANGGAL CAIR')
            ->setCellValue('H1', 'CABANG');

        $row = 2; // Start from row 2 after the header
        foreach ($data as $user) {
            // Check the transaction type
            if ($user->telat_per_berat == 1) {
                $KODE = '3A';
            } else {
                $KODE = '3B';
            }

            // Write data to the spreadsheet
            $sheet->setCellValue('A' . $row, $user->deskripsi_group1)
                ->setCellValue('B' . $row, $user->ANGSURAN_KE ?? '')
                ->setCellValue('C' . $row, $user->TGL_TRANS ?? '')
                ->setCellValue('D' . $row, $KODE)
                ->setCellValue('E' . $row, $user->menit_telat_per_berat ?? '')
                ->setCellValue('F' . $row, $user->deskripsi_group2 ?? '')
                ->setCellValue('G' . $row, $user->tgl_realisasi)
                ->setCellValue('H' . $row, $user->NAMA_KANTOR);

            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output Excel file to the browser
        $filename = 'kkb_USSI.xlsx';
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

    
    public function pdfFormKab(): View
    {
        $tanggal = $_GET["tanggal"];
        $cabang = $_GET["cabang"];
        $kab_kkb = $_GET["jenis"];
        $har = date('l', strtotime($tanggal));
        $p_date = explode("to", $_GET["daterange"]);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date

        $hariIndonesia = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu'
        ];

        $hari = $hariIndonesia[$har];

        if($kab_kkb == 'KAB'){
            
            $query = DB::table('anggota_bermasalah')
                ->selectRaw('pkp.nama, anggota_bermasalah.pkp_ab,anggota_bermasalah.pkp_nama_ab, anggota_bermasalah.nama_ab, anggota_bermasalah.kelompok_ab, anggota_bermasalah.id_anggota_ab')
                ->leftJoin('pkp', 'pkp.id', '=', 'anggota_bermasalah.pkp_ab')
                ->where('tanggal_ab', $tanggal)
                ->where('cabang_ab', $cabang)
                ->orderBy('pkp.nama', 'ASC');
            
            $data_list = $query->get();
            
            foreach ($data_list as $data) {
                $additionalData = DB::table('anggota_bermasalah')
                    ->selectRaw('count(id_ab) as total')
                    ->where('id_anggota_ab', $data->id_anggota_ab)
                    ->first();            
                $data->total = $additionalData ? $additionalData->total : 0;
            }

            $jum_kab = $query->count();            

        }else if($kab_kkb == 'KKB'){
            

            $query = DB::table('kelompok_bermasalah')
                ->selectRaw('pkp.nama, kelompok_bermasalah.pkp_kb, kelompok_bermasalah.tanggal_pencairan_kb, kelompok_bermasalah.pkp_nama,
                            kelompok_bermasalah.kelompok_kb, kelompok_bermasalah.kode_kb, 
                            kelompok_bermasalah.menit_kb, kelompok_bermasalah.id_sikki_kb')
                ->leftJoin('pkp', 'pkp.id', '=', 'kelompok_bermasalah.pkp_kb')
                ->where('tanggal_kb', $tanggal)
                ->where('cabang_kb', $cabang)
                ->orderBy('pkp.nama', 'ASC');

            $data_list = $query->get();

            // Loop untuk menambahkan data tambahan
            foreach ($data_list as $data) {
                // Query tambahan untuk total3a dan total3b
                $additionalData = DB::table('kelompok_bermasalah')
                    ->selectRaw('kelompok_kb, 
                                SUM(IF(kode_kb = "3A", 1, 0)) AS kode3a, 
                                SUM(IF(kode_kb = "3B", 1, 0)) AS kode3b, 
                                id_sikki_kb')
                    ->where('id_sikki_kb', $data->id_sikki_kb)
                    ->groupBy('id_sikki_kb', 'kelompok_kb')
                    ->first();            

                $data->total3a = $additionalData->kode3a ?? 0;
                $data->total3b = $additionalData->kode3b ?? 0;

                // Konversi tanggal untuk query selanjutnya
                $p_tgl_realisasi = explode(" ", $data->tanggal_pencairan_kb);
                
                // Query tambahan untuk total anggota
                $additionalData2 = DB::connection('mysql_secondary')
                    ->table('kredit as A')
                    ->selectRaw('COUNT(A.kode_group1) AS total')
                    ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'A.kode_group1')
                    ->where('B.deskripsi_group1', $data->kelompok_kb)
                    ->where('A.tgl_realisasi', $p_tgl_realisasi[0])
                    ->groupBy('A.kode_group1')
                    ->first();    

                $data->total_anggota = $additionalData2->total ?? 0;
            }
            // dd($data_list);
            $jum_kab = $query->count();


        }else{

            $query = DB::table('pkp')
                ->selectRaw('pkp.id,pkp.nama')
                ->where('pkp.is_kc', '0')
                ->where('pkp.cabang', $cabang)
                ->orderBy('pkp.id', 'ASC');

            $data_list = $query->get();

            foreach ($data_list as $data) {
                $additionalData = DB::table('anggota_bermasalah')
                    ->selectRaw('count(id_ab) as dtr ')
                    ->where('pkp_nama_ab', $data->nama)
                    ->where('tanggal_ab','>=', $awal)
                    ->where('tanggal_ab', '<=', $akhir)
                    ->groupBy('id_ab')
                    ->first();            

                $data->dtr = $additionalData->dtr ?? 0;

                $additionalData2 = DB::table('kelompok_bermasalah')
                    ->selectRaw('SUM(IF( kode_kb = "3A", 1, 0)) AS kode3a, SUM(IF( kode_kb = "3B", 1, 0)) AS kode3b')
                    ->where('pkp_nama', $data->nama)
                    ->where('tanggal_kb','>=', $awal)
                    ->where('tanggal_kb', '<=', $akhir)
                    ->groupBy('pkp_kb')
                    ->first();    

                $data->kode3a = $additionalData2->kode3a ?? 0;
                $data->kode3b = $additionalData2->kode3b ?? 0;
            }
            // dd($data_list);
            $jum_kab = 0;
        }

        
        $data = [
            'hari_bahasa' => $hari,
            'cabang' => $cabang,
            'hari' => $hari,
            'tanggal' => $tanggal,
            'kab_kkb' => $kab_kkb,
            'data_list' => $data_list,
            'jum_kab' => $jum_kab,
            'awal' => $awal,
            'akhir' => $akhir
        ];


        return view('kab_kkb.pdf-form-kab', $data);
    }
    
    
    public function excelDetailPenyebabDtr(Request $request)
    {
        $kabkkb = $request->input('kabkkb');
        $daterange = $request->input('daterange');
        $p_tanggal = explode(" to ",$daterange);
        if($kabkkb == 'KKB'){

            $data = DB::table('kelompok_bermasalah')
                ->leftJoin('pkp', 'kelompok_bermasalah.pkp_kb', '=', 'pkp.id')
                ->select(
                    'kelompok_bermasalah.*', 
                    'pkp.*'
                )
                ->where('kelompok_bermasalah.tanggal_kb','>=' , $p_tanggal[0])
                ->where('kelompok_bermasalah.tanggal_kb','<=' , $p_tanggal[1])
                ->orderBy('kelompok_kb', 'asc')
                ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set the header columns
            $sheet->setCellValue('A1', 'Kelompok')
                ->setCellValue('B1', 'Tanggal Bermasalah')
                ->setCellValue('C1', 'Setoran Ke')
                ->setCellValue('D1', 'Kode')
                ->setCellValue('E1', 'Menit Telat')
                ->setCellValue('F1', 'Cabang')
                ->setCellValue('G1', 'PKP FSK')
                ->setCellValue('H1', 'Hasil Pembahasan');

            $row = 2; // Start from row 2 after the header
            foreach ($data as $user) {

                // Write data to the spreadsheet
                $sheet->setCellValue('A' . $row, $user->kelompok_kb)
                    ->setCellValue('B' . $row, $user->tanggal_kb ?? '')
                    ->setCellValue('C' . $row, $user->setoran_kb ?? '')
                    ->setCellValue('D' . $row, $user->kode_kb ?? '')
                    ->setCellValue('E' . $row, $user->menit_kb ?? '')
                    ->setCellValue('F' . $row, $user->cabang_kb ?? '')
                    ->setCellValue('G' . $row, $user->nama ?? '')
                    ->setCellValue('H' . $row, $user->pembahasan_kb ?? '');

                $row++;
            }

            // Set file writer
            $writer = new Xlsx($spreadsheet);

            // Output Excel file to the browser
            $filename = 'Pembahasan_LPKB.xlsx';
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
        }else{

            $data = DB::table('anggota_bermasalah')
                ->leftJoin('pkp', 'anggota_bermasalah.pkp_ab', '=', 'pkp.id')
                ->select(
                    'anggota_bermasalah.*', 
                    'pkp.*'
                )
                ->where('anggota_bermasalah.tanggal_ab','>=' , $p_tanggal[0])
                ->where('anggota_bermasalah.tanggal_ab','<=' , $p_tanggal[1])
                ->orderBy('id_anggota_ab', 'asc')
                ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set the header columns
            $sheet->setCellValue('A1', 'Nama Anggota')
                ->setCellValue('B1', 'ID Anggota')
                ->setCellValue('C1', 'Nama Kelompok')
                ->setCellValue('D1', 'Tanggal Bermasalah')
                ->setCellValue('E1', 'Setoran Ke')
                ->setCellValue('F1', 'Kode')
                ->setCellValue('G1', 'Menit TelaT')
                ->setCellValue('H1', 'Cabang')
                ->setCellValue('I1', 'PKP FSK')
                ->setCellValue('J1', 'Penyebab DTR')
                ->setCellValue('K1', 'Himbauan');

            $row = 2; // Start from row 2 after the header
            foreach ($data as $user) {

                // Write data to the spreadsheet
                $sheet->setCellValue('A' . $row, $user->nama_ab)
                    ->setCellValue('B' . $row, $user->id_anggota_ab ?? '')
                    ->setCellValue('C' . $row, $user->kelompok_ab ?? '')
                    ->setCellValue('D' . $row, $user->tanggal_ab ?? '')
                    ->setCellValue('E' . $row, $user->setoran_ab ?? '')
                    ->setCellValue('F' . $row, $user->kode_ab ?? '')
                    ->setCellValue('G' . $row, $user->menit_ab ?? '')
                    ->setCellValue('H' . $row, $user->cabang_ab ?? '')
                    ->setCellValue('I' . $row, $user->nama ?? '')
                    ->setCellValue('J' . $row, $user->penyebab_ab ?? '')
                    ->setCellValue('K' . $row, $user->himbauan_ab ?? '');

                $row++;
            }

            // Set file writer
            $writer = new Xlsx($spreadsheet);

            // Output Excel file to the browser
            $filename = 'Penyebab_dtr_LPAB.xlsx';
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
        
    }
   

    
    public function excelTransaksiSetoran(Request $request)
    {
        $kabkkb = $request->input('kabkkb');
        $daterange = $request->input('daterange');
        $p_tanggal = explode(" to ",$daterange);
        
        
            $data =DB::connection('mysql_secondary')
                ->table('kretrans as A')
                ->Join('kredit as B', 'A.NO_REKENING', '=', 'B.no_rekening')
                ->select(
                    'A.TGL_TRANS',
                    'A.jam_trans', 
                    'B.nasabah_id'
                )
                ->where('A.TGL_TRANS','>=' , $p_tanggal[0])
                ->where('A.TGL_TRANS','<=' , $p_tanggal[1])
                ->where('A.KODE_TRANS', 300)
                ->orderBy('A.KRETRANS_ID', 'asc')
                ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set the header columns
            $sheet->setCellValue('A1', 'ID Anggota')
                ->setCellValue('B1', 'Tgl Setoran');

            $row = 2; // Start from row 2 after the header
            foreach ($data as $user) {

                // Write data to the spreadsheet
                $sheet->setCellValue('A' . $row, $user->nasabah_id)
                    ->setCellValue('B' . $row, $user->jam_trans ?? '');

                $row++;
            }

            // Set file writer
            $writer = new Xlsx($spreadsheet);

            // Output Excel file to the browser
            $filename = 'jml_trx.xlsx';
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

    
    public function excelPenyebabDtr(Request $request)
    {
        $cabang = $request->input('cabang');
        $daterange = $request->input('daterange');
        $p_tanggal = explode(" to ",$daterange);
        
        
            $data =DB::table('anggota_bermasalah')
                ->selectRaw('penyebab_ab,COUNT(id_ab) as jumlah')
                ->where('tanggal_ab','>=' , $p_tanggal[0])
                ->where('tanggal_ab','<=' , $p_tanggal[1])
                ->whereNotNull('penyebab_ab')
                ->where('penyebab_ab', '!=', '')
                ->groupBy('penyebab_ab')
                ->orderBy('penyebab_ab', 'asc')
                ->get();

            $data2 =DB::table('anggota_bermasalah')
                ->selectRaw('penyebab_ab,COUNT(id_ab) as jumlah')
                ->where('tanggal_ab','>=' , $p_tanggal[0])
                ->where('tanggal_ab','<=' , $p_tanggal[1])
                ->whereNull('penyebab_ab')
                ->groupBy('penyebab_ab')
                ->orderBy('penyebab_ab', 'asc')
                ->get();

            $data3 =DB::table('anggota_bermasalah')
                ->selectRaw('penyebab_ab,COUNT(id_ab) as jumlah')
                ->where('tanggal_ab','>=' , $p_tanggal[0])
                ->where('tanggal_ab','<=' , $p_tanggal[1])
                ->where('penyebab_ab', '')
                ->groupBy('penyebab_ab')
                ->orderBy('penyebab_ab', 'asc')
                ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set the header columns
            $sheet->setCellValue('A1', 'Penyebab DTR')
                ->setCellValue('B1', 'Jumlah');

            $row = 2; // Start from row 2 after the header
            foreach ($data2 as $user) {

                // Write data to the spreadsheet
                $sheet->setCellValue('A' . $row, 'Belum diisi')
                    ->setCellValue('B' . $row, $user->jumlah ?? '0');

                $row++;
            }
            foreach ($data3 as $user) {

                // Write data to the spreadsheet
                $sheet->setCellValue('A' . $row, 'Tidak ada penyebab')
                    ->setCellValue('B' . $row, $user->jumlah ?? '0');

                $row++;
            }

            foreach ($data as $user) {

                // Write data to the spreadsheet
                $sheet->setCellValue('A' . $row, $user->penyebab_ab)
                    ->setCellValue('B' . $row, $user->jumlah ?? '');

                $row++;
            }
            // Set file writer
            $writer = new Xlsx($spreadsheet);

            // Output Excel file to the browser
            $filename = 'Rangkuman_penyebab_dtr.xlsx';
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

}
