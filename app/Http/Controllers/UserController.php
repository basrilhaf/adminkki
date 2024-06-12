<?php

namespace App\Http\Controllers;

use App\Services\DataService;
use Crypt;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
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
        $menu_aktif = '/user||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'User Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Refferance</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">User Aplikasi</li>
                            </ul>'
        ];
        //get posts

        //render view with posts
        return view('user.index', $data);
    }

    public function getUser(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('apps_user')->join('apps_role', 'apps_user.role_id', '=', 'apps_role.id_role')
                ->select('apps_user.*', 'apps_role.nama_role');

            if ($request->filled('nama_user')) {
                $query->where('apps_user.nama', 'like', '%' . $request->input('nama_user') . '%');
            }
            if ($request->filled('role_user')) {
                $query->where('apps_role.nama_role', 'like', '%' . $request->input('role_user') . '%');
            }
            if ($request->filled('email_user')) {
                $query->where('apps_user.email', 'like', '%' . $request->input('email_user') . '%');
            }

            $filteredData = $query->latest()->get();
            // dd($filteredData);
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_user);

                    $infoUrl = route('user.infoUser', $id_hash);
                    $editUrl = route('user.editUser', $id_hash);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-success btn-sm"><span class="fa fa-info"></span></a> ';
                    $btn .= '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    $btn .= '<button title="HAPUS" class="btn btn-danger btn-delete-user btn-sm" data-id="' . $id_hash . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "Y") {
                        $status = '<span class="badge badge-light-success">Aktif</span>';
                    } else {
                        $status = '<span class="badge badge-light-danger">Tidak Aktif</span>';
                    }


                    // Accessing value from $data
                    return $status;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function addUser(Request $request)
    {
        $menu_aktif = '/user||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Tambah User Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Refferance</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">User Aplikasi</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Tambah User Aplikasi</li>
                            </ul>'
        ];

        return view('user.add-user', $data);
    }
    public function getReffJenisKelaminUser()
    {
        $jenis_pertanyaan = DB::select('SELECT * FROM reff_kolom_table 
                                        WHERE reff_kolom_table.table = "apps_user" 
                                        AND reff_kolom_table.kolom ="jenis_kelamin" 
                                        ORDER BY id_reff ASC');
        return response()->json($jenis_pertanyaan);
    }

    public function getReffStatusUser()
    {
        $status = DB::select('SELECT * FROM reff_kolom_table 
                                        WHERE reff_kolom_table.table = "apps_user" 
                                        AND reff_kolom_table.kolom ="status" 
                                        ORDER BY id_reff ASC');
        return response()->json($status);
    }

    public function getRoleUser()
    {
        $role = DB::select('SELECT * FROM apps_role ORDER BY id_role ASC');
        return response()->json($role);
    }

    public function getProvinsi()
    {
        $data = DB::select('SELECT * FROM m_provinsi WHERE provinsi_aktif = "Y" ORDER BY provinsi_nama ASC');
        return response()->json($data);
    }

    public function getKotaByProvinsi(Request $request)
    {
        $provinsiKode = $request->input('provinsi_kode');
        $data = DB::select('SELECT * FROM m_kabkota WHERE kabkota_aktif = "Y" and provinsi_kode = "' . $provinsiKode . '" ORDER BY kabkota_nama ASC');
        return response()->json($data);
    }

    public function getKecamatanByKota(Request $request)
    {
        $kabkota_kode = $request->input('kabkota_kode');
        $data = DB::select('SELECT * FROM m_kecamatan WHERE kecamatan_aktif = "Y" and kabkota_kode = "' . $kabkota_kode . '" ORDER BY kecamatan_nama ASC');
        return response()->json($data);
    }

    public function getKelurahanByKecamatan(Request $request)
    {
        $kecamatan_kode = $request->input('kecamatan_kode');
        $data = DB::select('SELECT * FROM m_kelurahan WHERE kelurahan_aktif = "Y" and kecamatan_kode = "' . $kecamatan_kode . '" ORDER BY kelurahan_nama ASC');
        return response()->json($data);
    }

    public function getSurveyorByKelurahan(Request $request)
    {
        $kelurahan_kode = $request->input('kelurahan_kode');
        $data = DB::select('SELECT * FROM apps_user inner join apps_role ON apps_user.role_id = apps_role.id_role WHERE apps_user.status = "Y" and apps_role.kode_role = "70" and apps_user.kelurahan_id = "' . $kelurahan_kode . '" ORDER BY nama ASC');
        return response()->json($data);
    }

    public function addUserAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:200',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $hashedPassword = Hash::make($request->password);

        $save = DB::table('apps_user')->insert([
            'nama'        => $request->nama,
            'username'  => $request->username,
            'password' => $hashedPassword,
            'email'        => $request->email,
            'role_id'  => $request->role,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon'        => $request->telepon,
            'alamat'  => $request->alamat,
            'kelurahan_id' => $request->kelurahan,
            'status'        => $request->status,
            'created_at' => date("Y-m-d H:i:s")
        ]);



        return response()->json(['success' => true, 'message' => 'Pertanyaan saved successfully']);
    }

    public function editUser($id_user, Request $request)
    {
        $menu_aktif = '/user||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Edit User Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Refferance</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">User Aplikasi</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Edit User Aplikasi</li>
                            </ul>',
            'id_user' => $id_user
        ];

        return view('user.edit-user', $data);
    }

    public function profilUser($id_user, Request $request)
    {
        $menu_aktif = '/ ||/ ';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Profil Saya',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Profil Saya</li>
                            </ul>',
            'id_user' => $id_user
        ];

        return view('user.profil-user', $data);
    }



    public function showDetailUser($id_user)
    {
        $id_user = Crypt::decrypt($id_user);
        $data = DB::table('apps_user AS A')
            ->leftJoin('apps_role AS B', 'A.role_id', '=', 'B.id_role')
            ->leftJoin('reff_kolom_table AS C', function ($join) {
                $join->on('A.jenis_kelamin', '=', 'C.isi_kolom')
                    ->where('C.table', '=', 'apps_user')->where('C.kolom', '=', 'jenis_kelamin');
            })
            ->leftJoin('reff_kolom_table AS D', function ($join) {
                $join->on('A.status', '=', 'D.isi_kolom')
                    ->where('D.table', '=', 'apps_user')->where('D.kolom', '=', 'status');
            })
            ->leftJoin('m_kelurahan AS E', 'A.kelurahan_id', '=', 'E.kelurahan_kode')
            ->leftJoin('m_kecamatan AS F', 'E.kecamatan_kode', '=', 'F.kecamatan_kode')
            ->leftJoin('m_kabkota AS G', 'G.kabkota_kode', '=', 'F.kabkota_kode')
            ->leftJoin('m_provinsi AS H', 'H.provinsi_kode', '=', 'G.provinsi_kode')
            ->select(
                'A.*',
                'B.nama_role',
                'C.keterangan as jenis_kelamin_nama',
                'D.keterangan as status_nama',
                'E.kelurahan_nama',
                'E.kelurahan_kode',
                'F.kecamatan_nama',
                'F.kecamatan_kode',
                'G.kabkota_nama',
                'G.kabkota_kode',
                'H.provinsi_nama',
                'H.provinsi_kode'
            )
            ->where('A.id_user', $id_user)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

    public function updateUserAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'nama_user' => 'required',
            'email' => 'required',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $id_user = Crypt::decrypt($request->id_user);

        $user = DB::table('apps_user')
            ->where('id_user', $id_user)
            ->update([
                'nama'     => $request->nama_user,
                'username'        => $request->username,
                'email'  => $request->email,
                'role_id'        => $request->role_id,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'no_telepon'        => $request->no_telepon,
                'alamat'        => $request->alamat,
                'kelurahan_id'        => $request->kelurahan_id,
                'status'        => $request->status,
                'updated_at' => date("Y-m-d H:i:s")
            ]);

        if ($user) {
            return response()->json(['success' => true, 'message' => 'Berhasil update user']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update user']);
        }
    }


    public function updatePasswordAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'passwordnew' => 'required',
            'passwordkonf' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $id_user = Crypt::decrypt($request->id_user);
        $hashedPassword = Hash::make($request->passwordnew);

        $user = DB::table('apps_user')
            ->where('id_user', $id_user)
            ->update([
                'password'     => $hashedPassword,
                'updated_at' => date("Y-m-d H:i:s")
            ]);

        if ($user) {
            return response()->json(['success' => true, 'message' => 'Berhasil update password']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update password']);
        }
    }

    public function infoUser($id_user, Request $request)
    {
        $menu_aktif = '/user||/refference';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Edit User Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Refferance</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">User Aplikasi</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Detail User Aplikasi</li>
                            </ul>',
            'id_user' => $id_user
        ];

        return view('user.info-user', $data);
    }

    public function deleteUserAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_user' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $id_user = Crypt::decrypt($request->id_user);
        $deleted = DB::table('apps_user')->where('id_user', $id_user)->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus user']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus user']);
        }
    }
}
