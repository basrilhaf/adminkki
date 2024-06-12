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


class MenuController extends Controller
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
        $menu_aktif = '/menu||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Menu Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Refferance</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Menu Aplikasi</li>
                            </ul>'
        ];

        return view('menu.index', $data);
    }

    public function getMenu(Request $request)
    {
        if ($request->ajax()) {
            $query = Menu::query();
            // $query  = Menu::latest()->get();
            // dd($request->filled('nama_menu'));
            if ($request->filled('nama_menu')) {
                $query->where('nama_menu', 'like', '%' . $request->input('nama_menu') . '%');
            }
            if ($request->filled('url_menu')) {
                $query->where('url', 'like', '%' . $request->input('url_menu') . '%');
            }

            $filteredData = $query->latest()->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_menu);

                    $infoUrl = route('menu.infoMenu', $id_hash);
                    $editUrl = route('menu.editMenu', $id_hash);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-success btn-sm"><span class="fa fa-info"></span></a> ';
                    $btn .= '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    $btn .= '<button title="HAPUS" class="btn btn-danger btn-delete-menu btn-sm" data-id="' . $id_hash . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                ->addColumn('status_field', function ($row) {
                    if ($row->status_menu == 'Y') {
                        $status = '<span class="badge badge-light-success">Aktif</span>';
                    } else {
                        $status = '<span class="badge badge-light-danger">Tidak Aktif</span>';
                    }
                    // Accessing value from $data
                    return $status;
                })
                ->addColumn('is_master_field', function ($row) {
                    if ($row->is_master == 'Y' || $row->is_master == 'E') {
                        $is_master = 'Master Menu';
                    } else if ($row->is_master == 'N') {
                        $is_master = 'Sub Menu';
                    } else {
                        $is_master = '';
                    }
                    // Accessing value from $data
                    return $is_master;
                })
                ->rawColumns(['action', 'status_field', 'is_master_field'])
                ->make(true);
        }
    }

    public function addMenu(Request $request)
    {
        $menu_aktif = '/menu||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Tambah Menu Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Refferance</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Menu Aplikasi</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Tambah Menu Aplikasi</li>
                            </ul>'
        ];

        return view('menu.add-menu', $data);
    }

    public function getReffJenisMenu()
    {
        $jenis = DB::select('SELECT * FROM reff_kolom_table 
                                        WHERE reff_kolom_table.table = "apps_menu" 
                                        AND reff_kolom_table.kolom ="is_master" 
                                        AND reff_kolom_table.status_show = "Y"
                                        ORDER BY id_reff ASC');
        return response()->json($jenis);
    }

    public function getReffStatusMenu()
    {
        $jenis = DB::select('SELECT * FROM reff_kolom_table 
                                        WHERE reff_kolom_table.table = "apps_menu" 
                                        AND reff_kolom_table.kolom ="status_menu" 
                                        AND reff_kolom_table.status_show = "Y"
                                        ORDER BY id_reff ASC');
        return response()->json($jenis);
    }


    public function getMasterMenu()
    {
        $jenis = DB::select('SELECT * FROM apps_menu 
                                        WHERE apps_menu.is_master = "Y" 
                                        AND apps_menu.status_menu = "Y"
                                        ORDER BY id_menu ASC');
        return response()->json($jenis);
    }

    public function addMenuAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_menu' => 'required|string|max:300',
            'url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->is_master == 'N') {
            $master_menu = $request->master_menu;
        } else {
            $master_menu = 0;
        }

        $id_task = DB::table('apps_menu')->insertGetId([
            'nama_menu'        => $request->nama_menu,
            'url'        => $request->url,
            'is_master'  => $request->is_master,
            'master_menu'        => $master_menu,
            'status_menu'  => $request->status_menu,
            'icon'        => $request->icon,
            'urutan'        => $request->urutan,
            'keterangan'        => $request->keterangan,
            'created_at' => date("Y-m-d H:i:s")
        ]);

        return response()->json(['success' => true, 'message' => 'Menu saved successfully']);
    }

    public function infoMenu($id_menu, Request $request)
    {

        $menu_aktif = '/menu||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Detail Menu Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Refferance</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Menu Aplikasi</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Detail Menu Aplikasi</li>
                            </ul>,',
            'id_menu' => $id_menu
        ];

        return view('menu.info-menu', $data);
    }

    public function showDetailMenu($id_menu)
    {
        $id_menu = Crypt::decrypt($id_menu);
        $data = DB::table('apps_menu AS A')
            ->leftJoin('apps_menu AS B', 'A.master_menu', '=', 'B.id_menu')
            ->leftJoin('reff_kolom_table AS C', function ($join) {
                $join->on('A.is_master', '=', 'C.isi_kolom')
                    ->where('C.table', '=', 'apps_menu')->where('C.kolom', '=', 'is_master');
            })
            ->leftJoin('reff_kolom_table AS D', function ($join) {
                $join->on('A.status_menu', '=', 'D.isi_kolom')
                    ->where('D.table', '=', 'apps_menu')->where('D.kolom', '=', 'status_menu');
            })
            ->select(
                'A.*',
                'B.nama_menu as master_menu_nama',
                'C.keterangan as jenis_menu_nama',
                'D.keterangan as status_menu_nama'
            )
            ->where('A.id_menu', $id_menu)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

    public function editMenu($id_menu, Request $request)
    {

        $menu_aktif = '/menu||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Edit Menu Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Refferance</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Menu Aplikasi</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Edit Menu Aplikasi</li>
                            </ul>,',
            'id_menu' => $id_menu
        ];

        return view('menu.edit-menu', $data);
    }

    public function updateMenuAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_menu' => 'required|string|max:300',
            'url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->is_master == 'N') {
            $master_menu = $request->master_menu;
        } else {
            $master_menu = 0;
        }

        $id_menu = Crypt::decrypt($request->id_menu);

        $menu = DB::table('apps_menu')
            ->where('id_menu', $id_menu)
            ->update([
                'nama_menu'     => $request->nama_menu,
                'url'        => $request->url,
                'is_master'  => $request->is_master,
                'master_menu'        => $master_menu,
                'status_menu'  => $request->status_menu,
                'icon'        => $request->icon,
                'urutan'        => $request->urutan,
                'keterangan'        => $request->keterangan,
                'updated_at' => date("Y-m-d H:i:s")
            ]);

        if ($menu) {
            return response()->json(['success' => true, 'message' => 'Berhasil update menu']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update menu']);
        }
    }

    public function deleteMenuAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_menu' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $id_menu = Crypt::decrypt($request->id_menu);
        $deleted = DB::table('apps_menu')->where('id_menu', $id_menu)->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus menu']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus menu']);
        }
    }
}
