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
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>'
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
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                            </ul>'
        ];
        
        return view('kab_kkb.pengisian-kab', $data);
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
