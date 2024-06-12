<?php

namespace App\Http\Controllers;

use App\Services\DataService;
use Crypt;
use App\Models\AksesMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AksesMenuController extends Controller
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
        $menu_aktif = '/aksesmenu||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Akses Menu Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Refferance</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Akses Menu</li>
                            </ul>'
        ];
        //get posts

        //render view with posts
        return view('aksesmenu.index', $data);
    }

    public function getAksesMenu(Request $request)
    {
        if ($request->ajax()) {
            // $query = AksesMenu::query();
            $query = DB::table('apps_akses_menu')
                ->join('apps_menu', 'apps_akses_menu.menu_id', '=', 'apps_menu.id_menu')
                ->join('apps_role', 'apps_akses_menu.role_id', '=', 'apps_role.id_role')
                ->select('apps_akses_menu.*', 'apps_menu.nama_menu', 'apps_role.nama_role');

            if ($request->filled('nama_menu')) {
                $query->where('apps_menu.nama_menu', 'like', '%' . $request->input('nama_menu') . '%');
            }
            if ($request->filled('nama_role')) {
                $query->where('apps_role.nama_role', 'like', '%' . $request->input('nama_role') . '%');
            }

            $filteredData = $query->latest()->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_akses_menu);

                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-aksesmenu btn-sm" data-id="' . $id_hash . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function addAksesMenu(Request $request)
    {
        $menu_aktif = '/aksesmenu||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Tambah Akses Menu Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i>><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Refferance</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Akses Menu</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Tambah Akses Menu</li>
                            </ul>'
        ];
        //get posts

        //render view with posts
        return view('aksesmenu.add-aksesmenu', $data);
    }

    public function getRoleAksesMenu()
    {
        $role = DB::select('SELECT * FROM apps_role ORDER BY id_role ASC');
        return response()->json($role);
    }

    public function getMenu($id_role)
    {

        $data = DB::table('apps_menu')
            ->whereNotIn('id_menu', function ($query) use ($id_role) {
                $query->select('menu_id')
                    ->from('apps_akses_menu')
                    ->where('role_id', $id_role);
            })
            ->get();

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($data);
    }



    public function addAksesMenuAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'role_id' => 'required|string|max:300',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        foreach ($request->menu_id as $menu_id) {
            $insert_pertanyaan_task = DB::table('apps_akses_menu')->insert([
                'role_id'        => $request->role_id,
                'menu_id'  => $menu_id,
                'created_at' => date("Y-m-d H:i:s")
            ]);
        }


        return response()->json(['success' => true, 'message' => 'Akses Menu saved successfully']);
    }

    public function deleteAksesMenuAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_akses_menu' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $id_akses_menu = Crypt::decrypt($request->id_akses_menu);
        $deleted = DB::table('apps_akses_menu')->where('id_akses_menu', $id_akses_menu)->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus akses menu']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus akses menu']);
        }
    }
}
