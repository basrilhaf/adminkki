<?php

namespace App\Http\Controllers;

use App\Services\DataService;
use Crypt;
use App\Models\Role;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
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
        $menu_aktif = '/role||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Role Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Refferance</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Role Aplikasi</li>
                            </ul>'
        ];

        return view('role.index', $data);
    }

    public function getRole(Request $request)
    {
        if ($request->ajax()) {
            $query = Role::query();

            if ($request->filled('nama_role')) {
                $query->where('nama_role', 'like', '%' . $request->input('nama_role') . '%');
            }
            if ($request->filled('kode_role')) {
                $query->where('kode_role', 'like', '%' . $request->input('kode_role') . '%');
            }

            $filteredData = $query->latest()->get();
            // dd($filteredData);
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_role);

                    $editUrl = route('role.editRole', $id_hash);
                    $btn = '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    $btn .= '<button title="HAPUS" class="btn btn-danger btn-delete-role btn-sm" data-id="' . $id_hash . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                ->addColumn('kode_field', function ($row) {

                    $kode = '<span class="badge badge-light-success">' . $row->kode_role . '</span>';

                    // Accessing value from $data
                    return $kode;
                })

                ->rawColumns(['action', 'kode_field'])
                ->make(true);
        }
    }
    public function addRole(Request $request)
    {
        $menu_aktif = '/role||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Role Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Refferance</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Role Aplikasi</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Tambah Role Aplikasi</li>
                            </ul>'
        ];

        return view('role.add-role', $data);
    }

    public function addRoleAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_role' => 'required|string|max:300',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $role = DB::table('apps_role')->insert([
            'nama_role'        => $request->nama_role,
            'kode_role'        => $request->kode_role,
            'keterangan_role'  => $request->keterangan_role,
            'created_at' => date("Y-m-d H:i:s")
        ]);

        return response()->json(['success' => true, 'message' => 'Menu saved successfully']);
    }

    public function editRole($id_role, Request $request)
    {

        $menu_aktif = '/menu||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Edit Role Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Refferance</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Role Aplikasi</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Edit Role Aplikasi</li>
                            </ul>',
            'id_role' => $id_role
        ];


        return view('role.edit-role', $data);
    }

    public function showDetailRole($id_role)
    {
        $id_role = Crypt::decrypt($id_role);
        $data = DB::table('apps_role AS A')
            ->select('A.*')
            ->where('A.id_role', $id_role)
            ->first();


        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

    public function updateRoleAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_role' => 'required|string|max:300',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $id_role = Crypt::decrypt($request->id_role);

        $role = DB::table('apps_role')
            ->where('id_role', $id_role)
            ->update([
                'nama_role'     => $request->nama_role,
                'kode_role'        => $request->kode_role,
                'keterangan_role'  => $request->keterangan_role,
                'updated_at' => date("Y-m-d H:i:s")
            ]);

        if ($role) {
            return response()->json(['success' => true, 'message' => 'Berhasil update role']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update role']);
        }
    }

    public function deleteRoleAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_role' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $id_role = Crypt::decrypt($request->id_role);
        $deleted = DB::table('apps_role')->where('id_role', $id_role)->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus role']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus role']);
        }
    }
}
