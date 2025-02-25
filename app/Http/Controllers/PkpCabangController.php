<?php

namespace App\Http\Controllers;

use App\Services\DataService;
use Crypt;
use App\Models\Menu;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PkpCabangController extends Controller
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
        $menu_aktif = '/pkpCabang||/settings';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'PKP / Cabang',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];

        return view('pkp_cabang.index', $data);
    }

    public function editPkp($id, Request $request)
    {

        $menu_aktif = '/pkpCabang||/settings';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Edit PKP',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '',
            'id_pkp' => $id
        ];

        return view('pkp_cabang.edit-pkp', $data);
    }
    public function editCabang($id, Request $request)
    {

        $menu_aktif = '/pkpCabang||/settings';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Edit Cabang',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '',
            'id_cabang' => $id
        ];

        return view('pkp_cabang.edit-cabang', $data);
    }

    
    public function gantiPassword(Request $request)
    {

        $menu_aktif = '/gantiPassword||/settings';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Fanti Password',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];

        return view('pkp_cabang.ganti-password', $data);
    }

    public function getPkp(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('pkp')->join('cabang', 'pkp.cabang', '=', 'cabang.id')
                
                ->select('pkp.*','cabang.nama as nama_cabang');

            if ($request->filled('nama')) {
                $query->where('pkp.nama', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('cabang')) {
                $query->where('cabang.nama', 'like', '%' . $request->input('cabang') . '%');
            }
            if ($request->filled('jenis')) {
                $query->where('pkp.is_kc',  $request->input('jenis'));
            }

            $filteredData = $query->orderBy('pkp.id', 'desc')->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id);
                    $editUrl = route('editPkp', $id_hash);
                    $btn = '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    $btn .= '<button title="HAPUS" class="btn btn-danger btn-delete-pkp btn-sm" data-id="' . $id_hash . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                ->addColumn('jenis', function ($row) {
                    if ($row->is_kc == "0") {
                        $status = '<span class="badge badge-light-success">PKP</span>';
                    } else {
                        $status = '<span class="badge badge-light-primary">KC</span>';
                    }


                    // Accessing value from $data
                    return $status;
                })
                

                ->rawColumns(['action','jenis'])
                ->make(true);
        }
    }

    
    public function getCabang(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('cabang')->leftJoin('pkp', 'cabang.kc', '=', 'pkp.id')
                
                ->select('cabang.*','pkp.nama as nama_kc');

           
            if ($request->filled('nama')) {
                $query->where('cabang.nama', 'like', '%' . $request->input('nama') . '%');
            }

            $filteredData = $query->orderBy('cabang.id', 'desc')->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id);
                    
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-cabang btn-sm" data-id="' . $id_hash . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    
    public function deletePkpAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_pkp' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $id = Crypt::decrypt($request->id_pkp);
        $deleted = DB::table('pkp')->where('id', $id)->delete();

        $this->dataService->createAuditTrail('Hapus PKP/KC');

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus pkp/kc']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus pkp/kc']);
        }
    }

    
    public function deleteCabangAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_cabang' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $id = Crypt::decrypt($request->id_cabang);
        $deleted = DB::table('cabang')->where('id', $id)->delete();

        $this->dataService->createAuditTrail('Hapus PKP/KC');

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus pkp/kc']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus pkp/kc']);
        }
    }

    
    public function getReffJenisUserOption()
    {
        $option = DB::select('SELECT * FROM reff_option WHERE kode="jenisUser" ORDER BY urutan ASC');
        return response()->json($option);
    }

    public function getCabangOption(Request $request)
    {
        if($request->session()->get('id_role2') == '2'){
            $status = DB::select('SELECT * FROM cabang ORDER BY nama ASC');
        }else{
            $status = DB::select('SELECT * FROM cabang WHERE nama = "'.$request->session()->get('cabang').'" ORDER BY nama ASC');
        }
        // dd($status);

        
        return response()->json($status);
    }

    public function getPkpOption()
    {
        $status = DB::select('SELECT * FROM pkp ORDER BY nik ASC');
        return response()->json($status);
    }

    public function getKcOption()
    {
        $kc = DB::select('SELECT * FROM pkp WHERE is_kc="1" ORDER BY nama ASC');
        return response()->json($kc);
    }
    
    
    public function addCabangAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:200',
            'kc' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $hashedPassword = Hash::make($request->password_pkp);

        $save = DB::table('cabang')->insert([
            'nama'        => $request->nama,
            'kc'  => $request->kc
            
        ]);

        $this->dataService->createAuditTrail('Tambah Data Cabang');

        return response()->json(['success' => true, 'message' => 'Cabang saved successfully']);
    }
    
    public function addPkpAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_pkp' => 'required|string|max:200',
            'nik_pkp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $hashedPassword = Hash::make($request->password_pkp);

        $save = DB::table('pkp')->insert([
            'nama'        => $request->nama_pkp,
            'nik'  => $request->nik_pkp,
            'cabang' => $request->cabang_pkp,
            'is_kc'  => $request->is_kc_pkp,
            'password_pkp' => $hashedPassword,
            'email_pkp'        => $request->email_pkp
            
        ]);

        // dd($save);
        $this->dataService->createAuditTrail('Tambah Data PKP/KC');

        return response()->json(['success' => true, 'message' => 'PKP saved successfully']);
    }

    
    public function showDetailPkp($id)
    {
        $id = Crypt::decrypt($id);
        $data = DB::table('pkp')
            ->select('pkp.*')
            ->where('pkp.id', $id)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

    
    public function updatePkpAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'nik' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $id = Crypt::decrypt($request->id);

        $hashedPassword = Hash::make($request->password);
        if ($request->password != '') {
            $pkp = DB::table('pkp')
            ->where('id', $id)
            ->update([
                'nama'     => $request->nama,
                'email_pkp'  => $request->email,
                'nik'        => $request->nik,
                'cabang'  => $request->cabang,
                'is_kc'        => $request->is_kc,
                'password_pkp' => $hashedPassword
            ]);
        }else{
            $pkp = DB::table('pkp')
            ->where('id', $id)
            ->update([
                'nama'     => $request->nama,
                'email_pkp'  => $request->email,
                'nik'        => $request->nik,
                'cabang'  => $request->cabang,
                'is_kc'        => $request->is_kc
            ]);
        }

        $this->dataService->createAuditTrail('Ubah Data PKP/KC');
        

        if ($pkp) {
            return response()->json(['success' => true, 'message' => 'Berhasil update PKP']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update PKP']);
        }
    }
}
