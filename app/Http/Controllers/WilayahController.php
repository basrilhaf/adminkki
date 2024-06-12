<?php

namespace App\Http\Controllers;

use App\Services\DataService;
use Crypt;
use App\Models\Wilayah;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;

class WilayahController extends Controller
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
        $menu_aktif = '/provinsi||/master';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Master Provinsi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Master</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Master Provinsi</li>
                            </ul>'
        ];
        //get posts

        //render view with posts
        return view('wilayah.provinsi', $data);
    }

    public function getProvinsi(Request $request)
    {
        if ($request->ajax()) {
            // $query = AksesMenu::query();
            $query = DB::table('m_provinsi')
                ->select('m_provinsi.*')->where('m_provinsi.provinsi_aktif', 'Y');

            if ($request->filled('nama_provinsi')) {
                $query->where('m_provinsi.provinsi_nama', 'like', '%' . $request->input('nama_provinsi') . '%');
            }

            $filteredData = $query->latest()->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->provinsi_kode);

                    $infoUrl = route('wilayah.infoProvinsi', $id_hash);
                    $editUrl = route('wilayah.editProvinsi', $id_hash);
                    $deleteUrl = route('wilayah.deleteProvinsi', $id_hash);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-success btn-sm"><span class="fa fa-info"></span></a> ';
                    $btn .= '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    $btn .= '<a href=' . $deleteUrl . ' class="btn btn-light-danger btn-sm"><span class="fa fa-trash"></span></a>';
                    return $btn;
                })
                ->addColumn('list_kabkota_field', function ($row) {
                    $id_hash = Crypt::encrypt($row->provinsi_kode);
                    $kabkotaUlr = route('wilayah.getKabkota', $id_hash);
                    $btnKabkota = '<a href=' . $kabkotaUlr . ' class="btn btn-light-info btn-sm">List Kota / Kabupaten</span></a> ';
                    // Accessing value from $data
                    return $btnKabkota;
                })
                ->rawColumns(['action', 'list_kabkota_field'])
                ->make(true);
        }
    }


    public function getKabkota(Request $request)
    {
        $menu_aktif = '/provinsi||/master';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $provinsi_kode = array_key_first($request->query());


        $data = [
            'menu' => 'Master Kota/Kabupaten',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Master</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Master Provinsi</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Master Kota/Kabupaten</li>
                            </ul>',
            'provinsi_kode' => $provinsi_kode
        ];
        //get posts

        //render view with posts
        return view('wilayah.kabkota', $data);
    }

    public function showKota($provinsi_kode, Request $request)
    {
        if ($request->ajax()) {

            // dd($provinsi_kode);
            // $query = AksesMenu::query();
            $provinsi_kode = Crypt::decrypt($provinsi_kode);
            $query = DB::table('m_kabkota')
                ->select('m_kabkota.*')->where('m_kabkota.kabkota_aktif', 'Y')->where('m_kabkota.provinsi_kode', $provinsi_kode);

            if ($request->filled('nama_kabkota')) {
                $query->where('m_kabkota.kabkota_nama', 'like', '%' . $request->input('nama_kabkota') . '%');
            }

            $filteredData = $query->latest()->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->kabkota_kode);

                    $infoUrl = route('wilayah.infoProvinsi', $id_hash);
                    $editUrl = route('wilayah.editProvinsi', $id_hash);
                    $deleteUrl = route('wilayah.deleteProvinsi', $id_hash);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-success btn-sm"><span class="fa fa-info"></span></a> ';
                    $btn .= '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    $btn .= '<a href=' . $deleteUrl . ' class="btn btn-light-danger btn-sm"><span class="fa fa-trash"></span></a>';
                    return $btn;
                })
                ->addColumn('list_kecamatan_field', function ($row) {
                    $id_hash = Crypt::encrypt($row->kabkota_kode);
                    $kecamatanUlr = route('wilayah.getKecamatan', $id_hash);
                    $btnKecamatan = '<a href=' . $kecamatanUlr . ' class="btn btn-light-info btn-sm">List Kecamatan</span></a> ';
                    // Accessing value from $data
                    return $btnKecamatan;
                })
                ->rawColumns(['action', 'list_kecamatan_field'])
                ->make(true);
        }
    }

    public function getKecamatan(Request $request)
    {
        $menu_aktif = '/provinsi||/master';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $kabkota_kode = array_key_first($request->query());

        // dd(Crypt::decrypt($kabkota_kode));

        $data = [
            'menu' => 'Master Kecamatan',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Master</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Master Provinsi</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Master Kota/Kabupaten</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Master Kecamatan</li>
                            </ul>',
            'kabkota_kode' => $kabkota_kode
        ];
        //get posts

        //render view with posts
        return view('wilayah.kecamatan', $data);
    }

    public function showKecamatan($kabkota_kode, Request $request)
    {
        if ($request->ajax()) {

            $kabkota_kode = Crypt::decrypt($kabkota_kode);
            $query = DB::table('m_kecamatan')
                ->select('m_kecamatan.*')->where('m_kecamatan.kecamatan_aktif', 'y')->where('m_kecamatan.kabkota_kode', $kabkota_kode);

            if ($request->filled('nama_kecamatan')) {
                $query->where('m_kecamatan.kecamatan_nama', 'like', '%' . $request->input('nama_kecamatan') . '%');
            }

            $filteredData = $query->latest()->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->kecamatan_kode);

                    $infoUrl = route('wilayah.infoProvinsi', $id_hash);
                    $editUrl = route('wilayah.editProvinsi', $id_hash);
                    $deleteUrl = route('wilayah.deleteProvinsi', $id_hash);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-success btn-sm"><span class="fa fa-info"></span></a> ';
                    $btn .= '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    $btn .= '<a href=' . $deleteUrl . ' class="btn btn-light-danger btn-sm"><span class="fa fa-trash"></span></a>';
                    return $btn;
                })
                ->addColumn('list_kelurahan_field', function ($row) {
                    $id_hash = Crypt::encrypt($row->kecamatan_kode);
                    $kelurahanUrl = route('wilayah.getKelurahan', $id_hash);
                    $btnKelurahan = '<a href=' . $kelurahanUrl . ' class="btn btn-light-info btn-sm">List Kelurahan</span></a> ';
                    // Accessing value from $data
                    return $btnKelurahan;
                })
                ->rawColumns(['action', 'list_kelurahan_field'])
                ->make(true);
        }
    }

    public function getKelurahan(Request $request)
    {
        $menu_aktif = '/provinsi||/master';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $kecamatan_kode = array_key_first($request->query());

        // dd(Crypt::decrypt($kabkota_kode));

        $data = [
            'menu' => 'Master Kelurahan',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Master</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Master Provinsi</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Master Kota/Kabupaten</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Master Kecamatan</li> </li><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Master Kelurahan</li>
                            </ul>',
            'kecamatan_kode' => $kecamatan_kode
        ];
        //get posts

        //render view with posts
        return view('wilayah.kelurahan', $data);
    }

    public function showKelurahan($kecamatan_kode, Request $request)
    {
        if ($request->ajax()) {
            // dd($kecamatan_kode);
            $kecamatan_kode = Crypt::decrypt($kecamatan_kode);
            $query = DB::table('m_kelurahan')
                ->select('m_kelurahan.*')->where('m_kelurahan.kelurahan_aktif', 'y')->where('m_kelurahan.kecamatan_kode', $kecamatan_kode);

            if ($request->filled('nama_kelurahan')) {
                $query->where('m_kelurahan.kelurahan_nama', 'like', '%' . $request->input('nama_kelurahan') . '%');
            }

            $filteredData = $query->latest()->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->kelurahan_kode);

                    $infoUrl = route('wilayah.infoProvinsi', $id_hash);
                    $editUrl = route('wilayah.editProvinsi', $id_hash);
                    $deleteUrl = route('wilayah.deleteProvinsi', $id_hash);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-success btn-sm"><span class="fa fa-info"></span></a> ';
                    $btn .= '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    $btn .= '<a href=' . $deleteUrl . ' class="btn btn-light-danger btn-sm"><span class="fa fa-trash"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
