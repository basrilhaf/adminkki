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



class SkorsingBlacklistController extends Controller
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
        $menu_aktif = '/skorsing||/skorsing_blacklist';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Skorsing',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('skorsing_blacklist.index', $data);
    }

    public function blacklist(Request $request): View
    {
        $menu_aktif = '/blacklist||/skorsing_blacklist';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        

        $data = [
            'menu' => 'Blacklist',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('skorsing_blacklist.blacklist', $data);
    }

    
    public function getAnggotaBlacklist(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('blacklist')
                ->select('*');

            
            if ($request->filled('nama')) {
                $query->where('anggota_bl', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('id')) {
                $query->where('id_anggota_bl', 'like', '%' . $request->input('id') . '%');
            }
            $filteredData = $query->orderBy('id_bl', 'desc')->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_bl);
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-bl btn-sm" data-id="' . $row->id_bl . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    
    public function getRekomendasiBlacklist(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('anggota_bermasalah')
                ->leftJoin('blacklist', 'blacklist.id_anggota_bl', '=', 'anggota_bermasalah.id_anggota_ab')
                ->select(
                    'anggota_bermasalah.id_anggota_ab',
                    'anggota_bermasalah.nama_ab',
                    'blacklist.id_anggota_bl',
                    DB::raw('MAX(anggota_bermasalah.setoran_ab) as max_set'),
                    'anggota_bermasalah.cabang_ab',
                    'anggota_bermasalah.kelompok_ab'
                )
                ->where('kabur_ab', '1')
                ->groupBy(
                    'anggota_bermasalah.id_anggota_ab',
                    'anggota_bermasalah.nama_ab',
                    'blacklist.id_anggota_bl',
                    'anggota_bermasalah.cabang_ab',
                    'anggota_bermasalah.kelompok_ab'
                )
                ->havingRaw('MAX(anggota_bermasalah.setoran_ab) >= 26');
            
            if ($request->filled('nama')) {
                $query->where('anggota_bermasalah.nama_ab', 'like', '%' . $request->input('nama') . '%');
            }
            
            if ($request->filled('id')) {
                $query->where('anggota_bermasalah.id_anggota_ab', 'like', '%' . $request->input('id') . '%');
            }
            
            $filteredData = $query->orderBy('anggota_bermasalah.id_anggota_ab', 'desc')->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_anggota_bl);
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-bl btn-sm" data-id="' . $row->id_anggota_bl . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    if(!empty($row->id_anggota_bl)){
                        $status="<span class='text-white badge badge-danger'>Blacklist</span>";
                    
                    } else {
                        $status="<span class='text-white badge badge-warning'>Rekomendasi</span>";
                    }


                    // Accessing value from $data
                    return $status;
                })
                
                ->rawColumns(['action','status'])
                ->make(true);
        }
    }

    public function deleteBlacklistAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $deleted = DB::table('blacklist')->where('id_bl', $request->id)->delete();

        $this->dataService->createAuditTrail('Hapus Anggota Blacklist');

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus blacklist']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus blacklist']);
        }
    }

    public function addBlacklistAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|string|max:200',
            'setoran' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $detail = DB::connection('mysql_secondary')
            ->table('nasabah as A')
            ->join('kredit as C', 'C.nasabah_id', '=', 'A.nasabah_id')
            ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'C.kode_group1')
            ->select('A.*', 'B.deskripsi_group1')
            ->where('A.nasabah_id', $request->id)
            ->orderBy('C.tgl_realisasi', 'desc')
            ->first();

        if($detail){
            $save = DB::table('blacklist')->insert([
                'id_anggota_bl'        => $request->id,
                'anggota_bl'  => $detail->NAMA_NASABAH,
                'kelompok_bl' => $detail->deskripsi_group1,
                'set_ke_bl'        => $request->setoran,
                'alasan_bl'  => $request->alasan
            ]);
            if($save){
                $this->dataService->createAuditTrail('Tambah Anggota Blacklist');
                return response()->json(['success' => true, 'message' => 'Berhasil Menambahkan Anggota Blacklist', 'icon' => 'success']);
            }else{
                return response()->json(['success' => false, 'message' => 'Gagal Menambahkan Anggota Blacklist', 'icon' => 'warning']);
            }
        }else{
            return response()->json(['success' => false, 'message' => 'ID Anggota tidak terdaftar', 'icon' => 'warning']);
        }
        
    }
    

    public function getAnggotaSkorsing(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('skorsing')
                ->select('*');
            if ($request->filled('nama')) {
                $query->where('nama_sk', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('id')) {
                $query->where('id_anggota_sk', 'like', '%' . $request->input('id') . '%');
            }
            $filteredData = $query->orderBy('id_sk', 'desc')->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-sk btn-sm" data-id="' . $row->id_sk . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    
    public function deleteSkorsingAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $deleted = DB::table('skorsing')->where('id_sk', $request->id)->delete();

        $this->dataService->createAuditTrail('Hapus Anggota Skorsing');

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus skorsing']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus skorsing']);
        }
    }

    
    public function getRekomendasiSkorsing(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('anggota_bermasalah')
                ->leftJoin('skorsing', 'skorsing.id_anggota_sk', '=', 'anggota_bermasalah.id_anggota_ab')
                ->select(
                    'anggota_bermasalah.id_anggota_ab',
                    'anggota_bermasalah.nama_ab',
                    'anggota_bermasalah.kelompok_ab',
                    DB::raw('MAX(anggota_bermasalah.setoran_ab) as max_set'),
                    DB::raw('MAX(anggota_bermasalah.tanggal_ab) as tanggal_max'),
                    DB::raw('COUNT(anggota_bermasalah.id_ab) as jumlah'),
                    DB::raw('SUM(IF(anggota_bermasalah.kode_ab = "2", 1, 0)) AS kode2'),
                    DB::raw('SUM(IF(anggota_bermasalah.kode_ab = "4A", 1, 0)) AS kode4a'),
                    DB::raw('SUM(IF(anggota_bermasalah.kode_ab = "4B", 1, 0)) AS kode4b')
                )
                ->groupBy(
                    'anggota_bermasalah.id_anggota_ab',
                    'anggota_bermasalah.nama_ab',
                    'anggota_bermasalah.kelompok_ab',
                    'skorsing.id_anggota_sk'
                )
                ->havingRaw('COUNT(anggota_bermasalah.id_ab) >= 4')
                ->orderByDesc('jumlah');

            if ($request->filled('nama')) {
                $query->where('anggota_bermasalah.nama_ab', 'like', '%' . $request->input('nama') . '%');
            }

            if ($request->filled('id')) {
                $query->where('anggota_bermasalah.id_anggota_ab', 'like', '%' . $request->input('id') . '%');
            }

            $filteredData = $query->get();
            return DataTables::of($filteredData)
                ->addIndexColumn()
                
                ->addColumn('status', function ($row) {
                    $status="<span class='text-white badge badge-warning'>Rekomendasi</span>";
                    
                    return $status;
                })
                ->addColumn('dtr', function ($row) {
                    $status="<span class='text-white badge badge-primary'>Kode2: ".$row->kode2."</span>
                            <br><span class='text-white badge badge-success'>kode4a: ".$row->kode4a."</span>
                            <br><span class='text-white badge badge-dark'>kode4b: ".$row->kode4b."</span>";
                    
                    return $status;
                })
                
                ->rawColumns(['dtr','status'])
                ->make(true);
        }
    }


    
    public function addSkorsingAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|string|max:200',
            'mulai' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $waktu = $request->lama." ".$request->satuan;
        $selesai = date('Y-m-d',strtotime ( $waktu , strtotime ( $request->mulai ) ));

        $detail = DB::connection('mysql_secondary')
            ->table('nasabah as A')
            ->leftJoin('kredit as C', 'C.nasabah_id', '=', 'A.nasabah_id')
            ->leftJoin('kre_kode_group1 as B', 'B.kode_group1', '=', 'C.kode_group1')
            ->select('A.*', 'B.deskripsi_group1')
            ->where('A.nasabah_id', $request->id)
            ->orderBy('C.tgl_realisasi', 'desc')
            ->first();

        if($detail){
            $save = DB::table('skorsing')->insert([
                'id_anggota_sk'        => $request->id,
                'nama_sk'  => $detail->NAMA_NASABAH,
                'ktp_sk' => $detail->no_id,
                'mulai_sk'        => $request->mulai,
                'selesai_sk'  => $selesai
            ]);
            if($save){
                $this->dataService->createAuditTrail('Tambah Anggota Skorsing');
                return response()->json(['success' => true, 'message' => 'Berhasil Menambahkan Anggota Skorsing', 'icon' => 'success']);
            }else{
                return response()->json(['success' => false, 'message' => 'Gagal Menambahkan Anggota Skorsing', 'icon' => 'warning']);
            }
        }else{
            return response()->json(['success' => false, 'message' => 'ID Anggota tidak terdaftar', 'icon' => 'warning']);
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
