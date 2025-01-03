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



class PengecekanController extends Controller
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
        $menu_aktif = '/cekTabungan||/pengecekan';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Cek Tabungan',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('pengecekan.index', $data);
    }

    public function cekKelompok(): View
    {
        $menu_aktif = '/cekKelompok||/pengecekan';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Cek Kelompok',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('pengecekan.cek-kelompok', $data);
    }

    
    public function cekAnggota(): View
    {
        $menu_aktif = '/cekAnggota||/pengecekan';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Cek Anggota',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('pengecekan.cek-anggota', $data);
    }

    
    public function cekKtp(): View
    {
        $menu_aktif = '/cekKtp||/pengecekan';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Cek KTP',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('pengecekan.cek-ktp', $data);
    }
    
    
    public function cekTabunganAnggota($nasabah_id, Request $request)
    {
        $menu_aktif = '/cekTabungan||/pengecekan';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Detail Cek Anggota',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '',
            'nasabah_id' => $nasabah_id
        ];
        
        return view('pengecekan.detail-tabungan-anggota', $data);

    }

    public function getCekTabunganAnggota(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');

            $query = DB::connection('mysql_secondary')
                ->table('nasabah as A')
                ->join('tabung as B', 'B.nasabah_id', '=', 'A.nasabah_id')
                ->join('tabtrans as C', 'B.no_rekening', '=', 'C.NO_REKENING')
                ->select('A.*', 'C.KODE_TRANS','C.KETERANGAN as deskripsi_keterangan','C.POKOK','C.TGL_TRANS')
                ->where('A.nasabah_id', $request->input('nasabah_id'))
                ->whereIn('C.KODE_TRANS', ['100','200']);

            $query->orderBy('C.TGL_TRANS', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()  // This is for the row index numbering
                ->addColumn('action', function ($row) {
                    $infoUrl = route('user.infoUser', $row->nasabah_id);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->addColumn('TRANS_TYPE', function ($row) {
                    if($row->KODE_TRANS == '100'){
                        $kode = 'Tambah';
                    }else{
                        $kode = 'Tarik';
                    }
                    // $row->TRANS_TYPE = ($item->KODE_TRANS == '100') ? 'Tambah' : 'Tarik';
                    return $kode;
                })
                ->rawColumns(['action', 'TRANS_TYPE'])
                ->make(true);
        }
    }

    

    public function cariKelompok(): View
    {
        $menu_aktif = '/cariKelompok||/kelompok';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Cari Kelompok',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('kelompok.cari-kelompok', $data);
    }


    
   
}
