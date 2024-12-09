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
   
}
