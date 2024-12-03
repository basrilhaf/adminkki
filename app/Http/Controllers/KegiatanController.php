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

class KegiatanController extends Controller
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
        $menu_aktif = '/kegiatan||/master';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Kegiatan Task',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Master</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Kegiatan Task</li>
                            </ul>'
        ];

        return view('kegiatan.index', $data);
    }

    public function getKegiatan(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('reff_kolom_table AS A')
                ->where('table', 't_task')
                ->where('kolom', 'kegiatan_task')
                ->select('*');

            if ($request->filled('kegiatan')) {
                $query->where('keterangan', 'like', '%' . $request->input('kegiatan') . '%');
            }

            $filteredData = $query->latest()->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_reff);

                    $editUrl = route('kegiatan.editKegiatan', $id_hash);
                    $btn = '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    $btn .= '<button title="HAPUS" class="btn btn-danger btn-delete-kegiatan btn-sm" data-id="' . $id_hash . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                ->addColumn('status_kegiatan', function ($row) {
                    if ($row->status_show == 'Y') {
                        $status = '<span class="badge badge-light-success">Aktif</span>';
                    } else {
                        $status = '<span class="badge badge-light-danger">Tidak Aktif</span>';
                    }
                    return $status;
                })

                ->rawColumns(['action', 'status_kegiatan'])
                ->make(true);
        }
    }

    public function addKegiatan(Request $request)
    {
        $menu_aktif = '/kegiatan||/master';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Tambah Kegiatan Task',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Master</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Kegiatan Task</li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Master</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Tambah Kegiatan Task</li>
                            </ul>'
        ];

        return view('kegiatan.add-kegiatan', $data);
    }

    public function addKegiatanAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'status' => 'required',
            'kode' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $id_task = DB::table('reff_kolom_table')->insert([
            'table'        => 't_task',
            'kolom'        => 'kegiatan_task',
            'isi_kolom'  => $request->kode,
            'keterangan'        => $request->nama,
            'status_show'  => $request->status,
            'created_at' => date("Y-m-d H:i:s")
        ]);

        return response()->json(['success' => true, 'message' => 'Menu saved successfully']);
    }

    public function editKegiatan($id_kegiatan, Request $request)
    {

        $menu_aktif = '/menu||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Edit Kegiatan Task',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Master</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Kegiatan Task</li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Master</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Edit Kegiatan Task</li>
                            </ul>',
            'id_kegiatan' => $id_kegiatan
        ];

        return view('kegiatan.edit-kegiatan', $data);
    }

    public function showDetailKegiatan($id_kegiatan)
    {
        $id_kegiatan = Crypt::decrypt($id_kegiatan);
        $data = DB::table('reff_kolom_table')
            ->select('*')
            ->where('id_reff', $id_kegiatan)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

    public function updateKegiatanAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kode' => 'required',
            'status' => 'required',
            'id_kegiatan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }



        $id_kegiatan = Crypt::decrypt($request->id_kegiatan);

        $menu = DB::table('reff_kolom_table')
            ->where('id_reff', $id_kegiatan)
            ->update([
                'keterangan'     => $request->nama,
                'isi_kolom'        => $request->kode,
                'status_show'  => $request->status,
                'updated_at' => date("Y-m-d H:i:s")
            ]);

        if ($menu) {
            return response()->json(['success' => true, 'message' => 'Berhasil update kegiatan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update kegiatan']);
        }
    }

    public function deleteKegiatanAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_kegiatan' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $id_kegiatan = Crypt::decrypt($request->id_kegiatan);
        $deleted = DB::table('reff_kolom_table')->where('id_reff', $id_kegiatan)->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus kegiatan']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus kegiatan']);
        }
    }
}
