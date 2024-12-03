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



class HomeController extends Controller
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
        $menu_aktif = '/home||';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $alur = DB::select('SELECT * FROM t_alur WHERE status = "Y" ORDER BY urutan ASC');
        $data = [
            'menu' => 'Home Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>',
            'alur' => $alur
        ];
        
        return view('home.index', $data);
    }

    public function progresProposal(): View
    {
        $menu_aktif = '/home||';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user_id = Session::getFacadeRoot()->get('id_user2');
        $alur = DB::select('SELECT A.*, B.status AS status_progress FROM reff_progress A LEFT JOIN t_progress B ON A.id = B.reff_id AND B.user_id = ' .$user_id. ' WHERE A.kode = "proposal" ORDER BY A.urutan ASC');
        $user = DB::table('apps_user')
                ->where('id_user', $user_id)
                ->first();

        $data = [
            'menu' => 'Progres Proposal',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>',
            'alur' => $alur,
            'user' => $user
        ];
        
        return view('home.progres-proposal', $data);
    }


    public function progresRevisiProposal(): View
    {
        $menu_aktif = '/home||';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user_id = Session::getFacadeRoot()->get('id_user2');
        $alur = DB::select('SELECT A.*, B.status AS status_progress FROM reff_progress A LEFT JOIN t_progress B ON A.id = B.reff_id AND B.fl_revisi = "Y" AND B.user_id = ' .$user_id. ' WHERE A.kode = "revisiproposal" ORDER BY A.urutan ASC');
        $user = DB::table('apps_user')
                ->where('id_user', $user_id)
                ->first();

        $data = [
            'menu' => 'Progres Revisi Proposal',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>',
            'alur' => $alur,
            'user' => $user
        ];
        
        return view('home.progres-revisi-proposal', $data);
    }

    public function progresTa(): View
    {
        $menu_aktif = '/home||';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user_id = Session::getFacadeRoot()->get('id_user2');
        $alur = DB::select('SELECT A.*, B.status AS status_progress FROM reff_progress A LEFT JOIN t_progress_ta B ON A.id = B.reff_id AND B.user_id = ' .$user_id. ' WHERE A.kode = "ta" ORDER BY A.urutan ASC');
        $user = DB::table('apps_user')
                ->where('id_user', $user_id)
                ->first();

        $data = [
            'menu' => 'Progres TA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>',
            'alur' => $alur,
            'user' => $user
        ];
        
        return view('home.progres-ta', $data);
    }

    public function ajukanSelesaiRevisi(Request $request)
    {
        // Validasi request
        $request->validate([
            'id' => 'required|integer',
            'id_user' => 'required|integer'
        ]);

        $user_id = Session::getFacadeRoot()->get('id_user2');

        $userdetail = DB::table('apps_user')
            ->where('id_user', $user_id)
            ->first();

        if($request->dosen_pa !=""){
            $dosen = $request->dosen_pa;
        }else if($request->dosen_penguji != ""){
            $dosen = $request->dosen_penguji;
        }else if($request->dosen_penguji2 != ""){
            $dosen = $request->dosen_penguji2;
        }

        $existingData = DB::table('t_progress')
            ->where('user_id', $user_id)
            ->where('reff_id', $request->id )
            ->where('fl_revisi', 'Y')
            ->first();

        if ($existingData) {
            $progress = DB::table('t_progress')
                ->where('id', $existingData->id)
                ->update([
                    'status' => 'N',
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
        }else{
            $progress = DB::table('t_progress')->insert([
                'user_id' => $user_id,
                'dosen_id' => $dosen,
                'reff_id' => $request->id,
                'status' => 'N',
                'fl_revisi' => 'Y',
                'created_at' => now()
            ]);
        }

        if ($progress) {
            return response()->json(['success' => true, 'message' => 'Berhasil update data']);
        }else{
            return response()->json(['success' => false, 'message' => 'Gagal update data']);
        }
        

    }

    public function ajukanSelesai(Request $request)
    {
        // Validasi request
        $request->validate([
            'id' => 'required|integer',
            'id_user' => 'required|integer'
        ]);

        $user_id = Session::getFacadeRoot()->get('id_user2');

        $userdetail = DB::table('apps_user')
            ->where('id_user', $user_id)
            ->first();

        $existingData = DB::table('t_progress')
            ->where('user_id', $user_id)
            ->where('reff_id', $request->id )
            ->first();

        if ($existingData) {
            $progress = DB::table('t_progress')
                ->where('id', $existingData->id)
                ->update([
                    'status' => 'N',
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
        }else{
            $progress = DB::table('t_progress')->insert([
                'user_id' => $user_id,
                'dosen_id' => $userdetail->dosen_pa,
                'reff_id' => $request->id,
                'status' => 'N',
                'created_at' => now()
            ]);
        }

        if ($progress) {
            return response()->json(['success' => true, 'message' => 'Berhasil update data']);
        }else{
            return response()->json(['success' => false, 'message' => 'Gagal update data']);
        }
        

    }

    public function ajukanSelesaiTa(Request $request)
    {
        // Validasi request
        $request->validate([
            'id' => 'required|integer',
            'id_user' => 'required|integer'
        ]);

        $user_id = Session::getFacadeRoot()->get('id_user2');

        $userdetail = DB::table('apps_user')
            ->where('id_user', $user_id)
            ->first();

        $existingData = DB::table('t_progress_ta')
            ->where('user_id', $user_id)
            ->where('reff_id', $request->id )
            ->first();

        if ($existingData) {
            $progress = DB::table('t_progress_ta')
                ->where('id', $existingData->id)
                ->update([
                    'status' => 'N',
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
        }else{
            $progress = DB::table('t_progress_ta')->insert([
                'user_id' => $user_id,
                'dosen_id' => $userdetail->dosen_pa,
                'reff_id' => $request->id,
                'status' => 'N',
                'created_at' => now()
            ]);
        }

        if ($progress) {
            return response()->json(['success' => true, 'message' => 'Berhasil update data']);
        }else{
            return response()->json(['success' => false, 'message' => 'Gagal update data']);
        }
        

    }

    public function ajukanDiterima(Request $request)
    {
        // Validasi request
        $request->validate([
            'id' => 'required|integer',
        ]);

        $progress = DB::table('t_progress')
                ->where('id', $request->id)
                ->update([
                    'status' => 'Y',
                    'updated_at' => date("Y-m-d H:i:s")
                ]);


        if ($progress) {
            return response()->json(['success' => true, 'message' => 'Berhasil update data']);
        }else{
            return response()->json(['success' => false, 'message' => 'Gagal update data']);
        }
        

    }

    public function ajukanDiterimaTa(Request $request)
    {
        // Validasi request
        $request->validate([
            'id' => 'required|integer',
        ]);

        $progress = DB::table('t_progress_ta')
                ->where('id', $request->id)
                ->update([
                    'status' => 'Y',
                    'updated_at' => date("Y-m-d H:i:s")
                ]);


        if ($progress) {
            return response()->json(['success' => true, 'message' => 'Berhasil update data']);
        }else{
            return response()->json(['success' => false, 'message' => 'Gagal update data']);
        }
        

    }

    public function ajukanDitolak(Request $request)
    {
        // Validasi request
        $request->validate([
            'id' => 'required|integer',
        ]);

        $progress = DB::table('t_progress')
                ->where('id', $request->id)
                ->update([
                    'status' => 'T',
                    'updated_at' => date("Y-m-d H:i:s")
                ]);


        if ($progress) {
            return response()->json(['success' => true, 'message' => 'Berhasil update data']);
        }else{
            return response()->json(['success' => false, 'message' => 'Gagal update data']);
        }
        

    }

    public function ajukanDitolakTa(Request $request)
    {
        // Validasi request
        $request->validate([
            'id' => 'required|integer',
        ]);

        $progress = DB::table('t_progress_ta')
                ->where('id', $request->id)
                ->update([
                    'status' => 'T',
                    'updated_at' => date("Y-m-d H:i:s")
                ]);


        if ($progress) {
            return response()->json(['success' => true, 'message' => 'Berhasil update data']);
        }else{
            return response()->json(['success' => false, 'message' => 'Gagal update data']);
        }
        

    }

    public function workshopTa(): View
    {
        $menu_aktif = '/home||';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user_id = Session::getFacadeRoot()->get('id_user2');
        // var_dump($user_id);
        // die();
        $alur = DB::table('t_workshop_ta')
                ->where('user_id', $user_id)
                ->first();
        $data = [
            'menu' => 'Workshop Penulisan Proposal & TA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>',
            'alur' => $alur
        ];
        return view('home.workshop-ta', $data);
    }

    public function workshopMendeley(): View
    {
        $menu_aktif = '/home||';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user_id = Session::getFacadeRoot()->get('id_user2');
        // var_dump($user_id);
        // die();
        $alur = DB::table('t_workshop_mendeley')
                ->where('user_id', $user_id)
                ->first();
        $data = [
            'menu' => 'Workshop Mendeley',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>',
            'alur' => $alur
        ];
        return view('home.workshop-mendeley', $data);
    }

    public function pengumpulanProposal($priode, Request $request)
    {
        $menu_aktif = '/home||';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user_id = Session::getFacadeRoot()->get('id_user2');
        // var_dump($user_id);
        // die();
        $alur = DB::table('t_daftar_proposal')
                ->where('user_id', $user_id)
                ->first();
        $data = [
            'menu' => 'Pengumpulan & Pendaftaran Ujian Proposal',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>',
            'alur' => $alur,
            'priode' => $priode
        ];
        return view('home.pengumpulan-proposal', $data);
    }

    public function pengumpulanTa($priode, Request $request)
    {
        $menu_aktif = '/home||';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user_id = Session::getFacadeRoot()->get('id_user2');
        // var_dump($user_id);
        // die();
        $alur = DB::table('t_daftar_ta')
                ->where('user_id', $user_id)
                ->first();
        $data = [
            'menu' => 'Pengumpulan & Pendaftaran TA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>',
            'alur' => $alur,
            'priode' => $priode
        ];
        return view('home.pengumpulan-ta', $data);
    }

    public function dosenPaMhs(): View
    {
        $menu_aktif = '/dosenPaMhs||/dosen';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user_id = Session::getFacadeRoot()->get('id_user2');
        $dosen = DB::select('SELECT A.*,B.nama as nama_dosen FROM apps_user A  INNER JOIN apps_user B ON A.dosen_pa = B.id_user WHERE A.id_user = '.$user_id.' ORDER BY A.id_user ASC');
        $data = [
            'menu' => 'Dosen PA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dosen</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dosen PA</li>
                            </ul>',
            'dosen' => $dosen
        ];

        return view('home.dosen-pa-mhs', $data);
    }

    public function dosenPengujiMhs(): View
    {
        $menu_aktif = '/dosenPengujiMhs||/dosen';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user_id = Session::getFacadeRoot()->get('id_user2');
        $dosen = DB::select('SELECT A.*,B.nama as nama_dosen, C.nama as nama_dosen2 FROM apps_user A  LEFT JOIN apps_user B ON A.dosen_penguji = B.id_user LEFT JOIN apps_user C ON A.dosen_penguji2 = C.id_user WHERE A.id_user = '.$user_id.' ORDER BY A.id_user ASC');
        $data = [
            'menu' => 'Dosen Penguji',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dosen</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dosen Penguji</li>
                            </ul>',
            'dosen' => $dosen
        ];

        return view('home.dosen-penguji-mhs', $data);
    }

    public function jadwalProposal(): View
    {
        $menu_aktif = '/jadwalProposal||/home';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user_id = Session::getFacadeRoot()->get('id_user2');
        $jadwal = DB::select('SELECT * FROM t_daftar_proposal WHERE user_id = '.$user_id.' ORDER BY id ASC');
        $data = [
            'menu' => 'Jadwal Ujian Proposal',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dosen</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Jadwal Ujian Proposal</li>
                            </ul>',
            'jadwal' => $jadwal
        ];

        return view('home.jadwal-ujian-proposal', $data);
    }

    public function jadwalTa(): View
    {
        $menu_aktif = '/jadwalTa||/home';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user_id = Session::getFacadeRoot()->get('id_user2');
        $jadwal = DB::select('SELECT * FROM t_daftar_ta WHERE user_id = '.$user_id.' ORDER BY id ASC');
        $data = [
            'menu' => 'Jadwal Ujian TA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dosen</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Jadwal Ujian TA</li>
                            </ul>',
            'jadwal' => $jadwal
        ];

        return view('home.jadwal-ujian-ta', $data);
    }

    public function dosenPA(): View
    {
        $menu_aktif = '/dosenPA||/dosen';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Dosen PA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dosen</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dosen PA</li>
                            </ul>'
        ];

        return view('home.dosen-pa', $data);
    }

    public function dosenUji(): View
    {
        $menu_aktif = '/dosenUji||/dosen';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Dosen Penguji',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dosen</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dosen Penguji</li>
                            </ul>'
        ];

        return view('home.dosen-uji', $data);
    }

    public function wta(): View
    {
        $menu_aktif = '/wta||/pendaftaran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Pendaftaran WTA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Pendaftaran</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">WTA</li>
                            </ul>'
        ];

        return view('home.wta', $data);
    }

    public function workshopTaAdm(): View
    {
        $menu_aktif = '/workshopTaAdm||/pendaftaran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Workshop Penulisan Proposal & TA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Pendaftaran</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Workshop Penulisan Proposal & TA</li>
                            </ul>'
        ];

        return view('home.workshop-ta-adm', $data);
    }

    public function workshopMendeleyAdm(): View
    {
        $menu_aktif = '/workshopMendeleyAdm||/pendaftaran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Workshop Mendeley',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Pendaftaran</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Workshop Mendeley</li>
                            </ul>'
        ];

        return view('home.workshop-mendeley-adm', $data);
    }

    public function ujianProposalAdm(): View
    {
        $menu_aktif = '/ujianProposalAdm||/pendaftaran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Ujian Proposal',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Pendaftaran</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Ujian Proposal</li>
                            </ul>'
        ];

        return view('home.ujian-proposal-adm', $data);
    }

    public function ujianTaAdm(): View
    {
        $menu_aktif = '/ujianTaAdm||/pendaftaran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Ujian TA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Pendaftaran</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Ujian TA</li>
                            </ul>'
        ];

        return view('home.ujian-ta-adm', $data);
    }

    public function progressProposalAdm(): View
    {
        $menu_aktif = '/progressProposalAdm||/progress';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Progress Proposal',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Pendaftaran</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Progress Proposa;l</li>
                            </ul>'
        ];

        return view('home.progress-proposal-adm', $data);
    }

    public function progressTaAdm(): View
    {
        $menu_aktif = '/progressTaAdm||/progress';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Progress TA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Pendaftaran</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Progress TA</li>
                            </ul>'
        ];

        return view('home.progress-ta-adm', $data);
    }

    public function getMhs(Request $request)
    {
        
        if ($request->ajax()) {
            $query = DB::table('apps_user')
                ->join('reff_fakultas', 'apps_user.fakultas', '=', 'reff_fakultas.id')
                ->join('reff_prodi', 'apps_user.prodi', '=', 'reff_prodi.id')
                ->select('apps_user.*','reff_fakultas.fakultas as nama_fakultas','reff_prodi.prodi as nama_prodi');

            if ($request->filled('nama')) {
                $query->where('apps_user.nama', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('nim')) {
                $query->where('apps_user.nim', 'like', '%' . $request->input('nim') . '%');
            }
            if ($request->filled('fakultas')) {
                $query->where('reff_fakultas.fakultas', 'like', '%' . $request->input('fakultas') . '%');
            }

            $filteredData = $query->latest()->get();
            // dd($filteredData);
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $id_hash = Crypt::encrypt($row->id);

                    $editUrl = route('pilihDosen', $row->id_user);
                    $btn = '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->addColumn('action2', function ($row) {
                    // $id_hash = Crypt::encrypt($row->id);

                    $editUrl2 = route('pilihDosenUji', $row->id_user);
                    $btn = '<a href=' . $editUrl2 . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                
                ->addColumn('status', function ($row) {
                    if ($row->dosen_pa != "") {
                        $status = '<span class="badge badge-light-success">Sudah Ditetapkan</span>';
                    }else {
                        $status = '<span class="badge badge-light-warning">Belum Ditetapkan</span>';
                    }

                    return $status;
                })

                ->addColumn('status2', function ($row) {
                    if ($row->dosen_penguji != "" && $row->dosen_penguji2 != "") {
                        $status = '<span class="badge badge-light-success">Sudah Ditetapkan Semua</span>';
                    } elseif ($row->dosen_penguji != "" && $row->dosen_penguji2 == "") {
                        $status = '<span class="badge badge-light-success">Penguji 1 Sudah Ditetapkan</span>';
                    } elseif ($row->dosen_penguji == "" && $row->dosen_penguji2 != "") {
                        $status = '<span class="badge badge-light-success">Penguji 2 Sudah Ditetapkan</span>';
                    } else {
                        $status = '<span class="badge badge-light-warning">Belum Ditetapkan</span>';
                    }
                
                    return $status;
                })

                ->rawColumns(['action','status','action2','status2'])
                ->make(true);
        }
    }

    public function pilihDosen($id, Request $request)
    {
        $menu_aktif = '/dosenPA||/dosen';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user = DB::table('apps_user')
                ->where('id_user', $id)
                ->first();
        $dosen = DB::select('SELECT * FROM apps_user WHERE role_id = "5" ORDER BY id_user ASC');
        $data = [
            $menu_aktif = '/wta||/pendaftaran',
            'menu' => 'Pilih Dosen PA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dosen</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Dosen PA</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Pilih Dosen PA</li>
                            </ul>',
            'user' => $user,
            'dosen' => $dosen
        ];

        return view('home.pilih-dosen-pa', $data);
    }

    public function pilihDosenUji($id, Request $request)
    {
        $menu_aktif = '/dosenUji||/dosen';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user = DB::table('apps_user')
                ->where('id_user', $id)
                ->first();
        $dosen = DB::select('SELECT * FROM apps_user WHERE role_id = "5" ORDER BY id_user ASC');
        $data = [
            $menu_aktif = '/wta||/pendaftaran',
            'menu' => 'Pilih Dosen PA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dosen</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Dosen PA</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Pilih Dosen Penguji</li>
                            </ul>',
            'user' => $user,
            'dosen' => $dosen,
            'dosen2' =>$dosen
        ];

        return view('home.pilih-dosen-uji', $data);
    }

    

    public function pilihDosenAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'dosen' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        // $id_user = Crypt::decrypt($request->id_user);

        $user = DB::table('apps_user')
            ->where('id_user', $request->id)
            ->update([
                $request->jenis     => $request->dosen,
                'updated_at' => date("Y-m-d H:i:s")
            ]);

        if ($user) {
            return response()->json(['success' => true, 'message' => 'Berhasil update user']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update user']);
        }
    }

    public function getProgressProposal(Request $request)
    {
        if ($request->ajax()) {
            $user_id = Session::getFacadeRoot()->get('id_user2');

            $query = DB::table('apps_user')->join('t_progress', 'apps_user.id_user', '=', 't_progress.user_id')->join('reff_progress', 'reff_progress.id', '=', 't_progress.reff_id')
                ->select('apps_user.nama','apps_user.nim','apps_user.email', 'reff_progress.progress','t_progress.status','t_progress.id','t_progress.fl_revisi')->where('t_progress.dosen_id','=', $user_id);

            if ($request->filled('nama')) {
                $query->where('apps_user.nama', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('nim')) {
                $query->where('apps_user.nim', 'like', '%' . $request->input('nim') . '%');
            }
            if ($request->filled('email')) {
                $query->where('apps_user.email', 'like', '%' . $request->input('email') . '%');
            }

            $filteredData = $query->orderBy('t_progress.created_at', 'desc')->get();
            // dd($filteredData);
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $id_hash = Crypt::encrypt($row->id);

                    

                    $editUrl = route('editWorkshopMendeley', $row->id);
                    $btn ='<button class="btn btn-success ajukan-diterima" data-id="'.$row->id.'">Diterima</button> ';
                    $btn .='<button class="btn btn-danger ajukan-ditolak" data-id="'.$row->id.'">Ditolak</button>';
                    return $btn;
                })
                ->addColumn('revisi', function ($row) {
                    if ($row->fl_revisi == "Y") {
                        $status = '<span class="badge badge-light-dark">Revisi Proposal</span>';
                    } else {
                        $status = '<span class="badge badge-light-white">Penulisan Proposal</span>';
                    }


                    // Accessing value from $data
                    return $status;
                })

                ->addColumn('status', function ($row) {
                    if ($row->status == "Y") {
                        $status = '<span class="badge badge-light-success">Terverifikasi</span>';
                    }else if ($row->status == "T") {
                        $status = '<span class="badge badge-light-danger">Verifikasi Ditolak</span>';
                    } else {
                        $status = '<span class="badge badge-light-warning">Menunggu Verifikasi</span>';
                    }


                    // Accessing value from $data
                    return $status;
                })

                ->rawColumns(['action', 'status','revisi'])
                ->make(true);
        }
    }

    public function getProgressTa(Request $request)
    {
        if ($request->ajax()) {
            $user_id = Session::getFacadeRoot()->get('id_user2');

            $query = DB::table('apps_user')->join('t_progress_ta', 'apps_user.id_user', '=', 't_progress_ta.user_id')->join('reff_progress', 'reff_progress.id', '=', 't_progress_ta.reff_id')
                ->select('apps_user.nama','apps_user.nim','apps_user.email', 'reff_progress.progress','t_progress_ta.status','t_progress_ta.id','t_progress_ta.fl_revisi')->where('t_progress_ta.dosen_id','=', $user_id);

            if ($request->filled('nama')) {
                $query->where('apps_user.nama', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('nim')) {
                $query->where('apps_user.nim', 'like', '%' . $request->input('nim') . '%');
            }
            if ($request->filled('email')) {
                $query->where('apps_user.email', 'like', '%' . $request->input('email') . '%');
            }

            $filteredData = $query->orderBy('t_progress_ta.created_at', 'desc')->get();
            // dd($filteredData);
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $id_hash = Crypt::encrypt($row->id);

                    

                    $editUrl = route('editWorkshopMendeley', $row->id);
                    $btn ='<button class="btn btn-success ajukan-diterima" data-id="'.$row->id.'">Diterima</button> ';
                    $btn .='<button class="btn btn-danger ajukan-ditolak" data-id="'.$row->id.'">Ditolak</button>';
                    return $btn;
                })
                ->addColumn('revisi', function ($row) {
                    if ($row->fl_revisi == "Y") {
                        $status = '<span class="badge badge-light-dark">Revisi Proposal</span>';
                    } else {
                        $status = '<span class="badge badge-light-white">Penulisan Proposal</span>';
                    }


                    // Accessing value from $data
                    return $status;
                })

                ->addColumn('status', function ($row) {
                    if ($row->status == "Y") {
                        $status = '<span class="badge badge-light-success">Terverifikasi</span>';
                    }else if ($row->status == "T") {
                        $status = '<span class="badge badge-light-danger">Verifikasi Ditolak</span>';
                    } else {
                        $status = '<span class="badge badge-light-warning">Menunggu Verifikasi</span>';
                    }


                    // Accessing value from $data
                    return $status;
                })

                ->rawColumns(['action', 'status','revisi'])
                ->make(true);
        }
    }

    public function getUjianTa(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('apps_user')->join('t_daftar_ta', 'apps_user.id_user', '=', 't_daftar_ta.user_id')
                ->select('apps_user.nama','apps_user.nim','apps_user.email', 't_daftar_ta.*');

            if ($request->filled('nama')) {
                $query->where('apps_user.nama', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('nim')) {
                $query->where('apps_user.nim', 'like', '%' . $request->input('nim') . '%');
            }
            if ($request->filled('email')) {
                $query->where('apps_user.email', 'like', '%' . $request->input('email') . '%');
            }

            $filteredData = $query->latest()->get();
            // dd($filteredData);
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $id_hash = Crypt::encrypt($row->id);

                    $editUrl = route('editDaftarUjianTa', $row->id);
                    $btn = '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "Y") {
                        $status = '<span class="badge badge-light-success">Terverifikasi</span>';
                    }else if ($row->status == "T") {
                        $status = '<span class="badge badge-light-danger">Verifikasi Ditolak</span>';
                    } else {
                        $status = '<span class="badge badge-light-warning">Menunggu Verifikasi</span>';
                    }


                    // Accessing value from $data
                    return $status;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function getUjianProposal(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('apps_user')->join('t_daftar_proposal', 'apps_user.id_user', '=', 't_daftar_proposal.user_id')
                ->select('apps_user.nama','apps_user.nim','apps_user.email', 't_daftar_proposal.*');

            if ($request->filled('nama')) {
                $query->where('apps_user.nama', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('nim')) {
                $query->where('apps_user.nim', 'like', '%' . $request->input('nim') . '%');
            }
            if ($request->filled('email')) {
                $query->where('apps_user.email', 'like', '%' . $request->input('email') . '%');
            }

            $filteredData = $query->latest()->get();
            // dd($filteredData);
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $id_hash = Crypt::encrypt($row->id);

                    $editUrl = route('editDaftarUjian', $row->id);
                    $btn = '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "Y") {
                        $status = '<span class="badge badge-light-success">Terverifikasi</span>';
                    }else if ($row->status == "T") {
                        $status = '<span class="badge badge-light-danger">Verifikasi Ditolak</span>';
                    } else {
                        $status = '<span class="badge badge-light-warning">Menunggu Verifikasi</span>';
                    }


                    // Accessing value from $data
                    return $status;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function getWorkshopMendeley(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('apps_user')->join('t_workshop_mendeley', 'apps_user.id_user', '=', 't_workshop_mendeley.user_id')
                ->select('apps_user.nama','apps_user.nim','apps_user.email', 't_workshop_mendeley.*');

            if ($request->filled('nama')) {
                $query->where('apps_user.nama', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('nim')) {
                $query->where('apps_user.nim', 'like', '%' . $request->input('nim') . '%');
            }
            if ($request->filled('email')) {
                $query->where('apps_user.email', 'like', '%' . $request->input('email') . '%');
            }

            $filteredData = $query->latest()->get();
            // dd($filteredData);
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $id_hash = Crypt::encrypt($row->id);

                    $editUrl = route('editWorkshopMendeley', $row->id);
                    $btn = '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "Y") {
                        $status = '<span class="badge badge-light-success">Terverifikasi</span>';
                    }else if ($row->status == "T") {
                        $status = '<span class="badge badge-light-danger">Verifikasi Ditolak</span>';
                    } else {
                        $status = '<span class="badge badge-light-warning">Menunggu Verifikasi</span>';
                    }


                    // Accessing value from $data
                    return $status;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function getWorkshopTa(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('apps_user')->join('t_workshop_ta', 'apps_user.id_user', '=', 't_workshop_ta.user_id')
                ->select('apps_user.nama','apps_user.nim','apps_user.email', 't_workshop_ta.*');

            if ($request->filled('nama')) {
                $query->where('apps_user.nama', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('nim')) {
                $query->where('apps_user.nim', 'like', '%' . $request->input('nim') . '%');
            }
            if ($request->filled('email')) {
                $query->where('apps_user.email', 'like', '%' . $request->input('email') . '%');
            }

            $filteredData = $query->latest()->get();
            // dd($filteredData);
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $id_hash = Crypt::encrypt($row->id);

                    $editUrl = route('editWorkshopTa', $row->id);
                    $btn = '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "Y") {
                        $status = '<span class="badge badge-light-success">Terverifikasi</span>';
                    }else if ($row->status == "T") {
                        $status = '<span class="badge badge-light-danger">Verifikasi Ditolak</span>';
                    } else {
                        $status = '<span class="badge badge-light-warning">Menunggu Verifikasi</span>';
                    }


                    // Accessing value from $data
                    return $status;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function getWta(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('apps_user')->join('t_wta', 'apps_user.id_user', '=', 't_wta.user_id')
                ->select('apps_user.nama','apps_user.nim','apps_user.email', 't_wta.*');

            if ($request->filled('nama')) {
                $query->where('apps_user.nama', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('nim')) {
                $query->where('apps_user.nim', 'like', '%' . $request->input('nim') . '%');
            }
            if ($request->filled('email')) {
                $query->where('apps_user.email', 'like', '%' . $request->input('email') . '%');
            }

            $filteredData = $query->latest()->get();
            // dd($filteredData);
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $id_hash = Crypt::encrypt($row->id);

                    $editUrl = route('editWta', $row->id);
                    $btn = '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "Y") {
                        $status = '<span class="badge badge-light-success">Terverifikasi</span>';
                    }else if ($row->status == "T") {
                        $status = '<span class="badge badge-light-danger">Verifikasi Ditolak</span>';
                    } else {
                        $status = '<span class="badge badge-light-warning">Menunggu Verifikasi</span>';
                    }


                    // Accessing value from $data
                    return $status;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function editWta($id, Request $request)
    {
        $menu_aktif = '/editWta||/pendaftaran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $wta = DB::table('t_wta')
                ->where('id', $id)
                ->first();
        $data = [
            $menu_aktif = '/wta||/pendaftaran',
            'menu' => 'Verifikasi WTA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Pendaftaran</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">WTA</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Edit WTA</li>
                            </ul>',
            'wta' => $wta
        ];

        return view('home.edit-wta', $data);
    }

    public function editWorkshopTa($id, Request $request)
    {
        $menu_aktif = '/editWorkshopTa||/pendaftaran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $wta = DB::table('t_workshop_ta')
                ->where('id', $id)
                ->first();
        $data = [
            $menu_aktif = '/wta||/pendaftaran',
            'menu' => 'Verifikasi WTA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Pendaftaran</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">WTA</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Edit Workshop Penulisan Proposal & TA</li>
                            </ul>',
            'wta' => $wta
        ];

        return view('home.edit-workshop-ta', $data);
    }

    public function editWorkshopMendeley($id, Request $request)
    {
        $menu_aktif = '/editWorkshopMendeley||/pendaftaran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $wta = DB::table('t_workshop_mendeley')
                ->where('id', $id)
                ->first();
        $data = [
            'menu' => 'Verifikasi WTA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Pendaftaran</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">WTA</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Edit Workshop Mendeley</li>
                            </ul>',
            'wta' => $wta
        ];

        return view('home.edit-workshop-mendeley', $data);
    }

    public function editDaftarUjianTa($id, Request $request)
    {
        $menu_aktif = '/editDaftarUjian||/pendaftaran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $wta = DB::table('t_daftar_ta')
                ->where('id', $id)
                ->first();
        $data = [
            'menu' => 'Verifikasi Daftar Ujian TA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Pendaftaran</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">WTA</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Edit Daftar Ujian Proposal</li>
                            </ul>',
            'wta' => $wta
        ];

        return view('home.edit-ujian-ta-adm', $data);
    }
    
    public function editDaftarUjian($id, Request $request)
    {
        $menu_aktif = '/editDaftarUjian||/pendaftaran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $wta = DB::table('t_daftar_proposal')
                ->where('id', $id)
                ->first();
        $data = [
            'menu' => 'Verifikasi Daftar Ujian Proposal',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Pendaftaran</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">WTA</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Edit Daftar Ujian Proposal</li>
                            </ul>',
            'wta' => $wta
        ];

        return view('home.edit-ujian-proposal-adm', $data);
    }

    public function verifikasiWorkshopMendeleyAction(Request $request)
    {
        $wtaId = $request->input('id');
        
        // Validasi data
        $request->validate([
            'workshop' => 'in:Y,T', // Y untuk Diverifikasi, T untuk Ditolak
        ]);

        if ($request->input('workshop')=="T") {
            $status = "T";
        }else{
            $status = "Y";
        }

        // Update data menggunakan query manual
        $update = DB::table('t_workshop_mendeley')->where('id', $wtaId)->update([
                'v_workshop' => $request->input('workshop'),
                'status' => $status
            ]);

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        }else{
            return response()->json(['success' => false, 'message' => 'Data gagal diperbarui.']);
        }
    }

    public function verifikasiUjianTaAction(Request $request)
    {
        $wtaId = $request->input('id');
        
        // Validasi data
        $request->validate([
            'workshop' => 'in:Y,T', // Y untuk Diverifikasi, T untuk Ditolak
        ]);

        if ($request->input('workshop')=="T") {
            $status = "T";
        }else{
            $status = "Y";
        }

        // Update data menggunakan query manual
        $update = DB::table('t_daftar_ta')->where('id', $wtaId)->update([
                'v_berkas' => $request->input('workshop'),
                'status' => $status,
                'jadwal' => $request->input('jadwal')
            ]);

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        }else{
            return response()->json(['success' => false, 'message' => 'Data gagal diperbarui.']);
        }
    }

    public function verifikasiUjianProposalAction(Request $request)
    {
        $wtaId = $request->input('id');
        
        // Validasi data
        $request->validate([
            'workshop' => 'in:Y,T', // Y untuk Diverifikasi, T untuk Ditolak
        ]);

        if ($request->input('workshop')=="T") {
            $status = "T";
        }else{
            $status = "Y";
        }

        // Update data menggunakan query manual
        $update = DB::table('t_daftar_proposal')->where('id', $wtaId)->update([
                'v_berkas' => $request->input('workshop'),
                'status' => $status,
                'jadwal' => $request->input('jadwal')
            ]);

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        }else{
            return response()->json(['success' => false, 'message' => 'Data gagal diperbarui.']);
        }
    }


    public function verifikasiWorkshopTaAction(Request $request)
    {
        $wtaId = $request->input('id');
        
        // Validasi data
        $request->validate([
            'workshop' => 'in:Y,T', // Y untuk Diverifikasi, T untuk Ditolak
        ]);

        if ($request->input('workshop')=="T") {
            $status = "T";
        }else{
            $status = "Y";
        }

        // Update data menggunakan query manual
        $update = DB::table('t_workshop_ta')->where('id', $wtaId)->update([
                'v_workshop' => $request->input('workshop'),
                'status' => $status
            ]);

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        }else{
            return response()->json(['success' => false, 'message' => 'Data gagal diperbarui.']);
        }
    }

    public function verifikasiWtaAction(Request $request)
    {
        $wtaId = $request->input('id');
        
        // Validasi data
        $request->validate([
            'transkrip' => 'in:Y,T', // Y untuk Diverifikasi, T untuk Ditolak
            'seminar' => 'in:Y,T',
            'pkm' => 'in:Y,T',
            'pembayaran' => 'in:Y,T',
        ]);

        if ($request->input('transkrip')=="T" || $request->input('seminar') == "T" || $request->input('pkm') == "T" || $request->input('pembayaran') == "T") {
            $status = "T";
        }else{
            $status = "Y";
        }

        // Update data menggunakan query manual
        $update = DB::table('t_wta')->where('id', $wtaId)->update([
                'v_transkrip' => $request->input('transkrip'),
                'v_seminar' => $request->input('seminar'),
                'v_pkm' => $request->input('pkm'),
                'v_pembayaran' => $request->input('pembayaran'),
                'status' => $status
            ]);

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        }else{
            return response()->json(['success' => false, 'message' => 'Data gagal diperbarui.']);
        }
    }

    public function homeAdm(): View
    {
        $menu_aktif = '/home||';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $alur = DB::select('SELECT * FROM t_alur WHERE status = "Y" ORDER BY urutan ASC');
        $data = [
            'menu' => 'Home Aplikasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>',
            'alur' => $alur
        ];
        
        return view('home.home-adm', $data);
    }

    public function daftarWTA(): View
    {
        $menu_aktif = '/home||';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $user_id = Session::getFacadeRoot()->get('id_user2');
        // var_dump($user_id);
        // die();
        $alur = DB::table('t_wta')
                ->where('user_id', $user_id)
                ->first();
        $data = [
            'menu' => 'Daftar WTA',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                
                            </ul>',
            'alur' => $alur
        ];
        return view('home.daftar-wta', $data);
    }

    public function uploadTaAction(Request $request)
    {
        $request->validate([
            
            'workshop' => 'required|file|mimes:pdf',
        ]);

        $user_id = Session::getFacadeRoot()->get('id_user2');

        $existingData = DB::table('t_daftar_ta')
            ->where('user_id', $user_id)
            ->first();

        // Simpan file ke storage dan dapatkan path-nya
        $workshopPath = $request->file('workshop')->store('uploads/ta', 'public');
        

        if ($existingData) {
            $update = DB::table('t_daftar_ta')
                    ->where('id', $existingData->id)
                    ->update([
                        'berkas' => $workshopPath,
                        'v_berkas' => 'N',
                        'status' => 'N'
                    ]);
            if ($update) {
                return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
            }else{
                return response()->json(['success' => false, 'message' => 'Data gagal diperbarui.']);
            }

        }else{
            $insert = DB::table('t_daftar_ta')->insert([
                    'user_id' => $user_id,
                    'berkas' => $workshopPath,
                    'v_berkas' => 'N',
                    'status' => 'N',
                    'created_at' => now()
                ]);

                if ($insert) {
                    return response()->json(['success' => true, 'message' => 'Berkas berhasil diupload dan disimpan.']);
                }else{
                    return response()->json(['success' => false, 'message' => 'Berkas gagal diupload.']);
                }
        }

        
    }

    
    public function uploadProposalpAction(Request $request)
    {
        $request->validate([
            
            'workshop' => 'required|file|mimes:pdf',
        ]);

        $user_id = Session::getFacadeRoot()->get('id_user2');

        $existingData = DB::table('t_daftar_proposal')
            ->where('user_id', $user_id)
            ->first();

        // Simpan file ke storage dan dapatkan path-nya
        $workshopPath = $request->file('workshop')->store('uploads/proposal', 'public');
        

        if ($existingData) {
            $update = DB::table('t_daftar_proposal')
                    ->where('id', $existingData->id)
                    ->update([
                        'berkas' => $workshopPath,
                        'v_berkas' => 'N',
                        'status' => 'N'
                    ]);
            if ($update) {
                return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
            }else{
                return response()->json(['success' => false, 'message' => 'Data gagal diperbarui.']);
            }

        }else{
            $insert = DB::table('t_daftar_proposal')->insert([
                    'user_id' => $user_id,
                    'berkas' => $workshopPath,
                    'v_berkas' => 'N',
                    'status' => 'N',
                    'created_at' => now()
                ]);

                if ($insert) {
                    return response()->json(['success' => true, 'message' => 'Berkas berhasil diupload dan disimpan.']);
                }else{
                    return response()->json(['success' => false, 'message' => 'Berkas gagal diupload.']);
                }
        }

        
    }

    public function uploadMendeleypAction(Request $request)
    {
        $request->validate([
            
            'workshop' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        $user_id = Session::getFacadeRoot()->get('id_user2');

        $existingData = DB::table('t_workshop_mendeley')
            ->where('user_id', $user_id)
            ->first();

        // Simpan file ke storage dan dapatkan path-nya
        $workshopPath = $request->file('workshop')->store('uploads/mendeley', 'public');
        

        if ($existingData) {
            $update = DB::table('t_workshop_mendeley')
                    ->where('id', $existingData->id)
                    ->update([
                        'workshop' => $workshopPath,
                        'v_workshop' => 'N',
                        'status' => 'N'
                    ]);
            if ($update) {
                return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
            }else{
                return response()->json(['success' => false, 'message' => 'Data gagal diperbarui.']);
            }

        }else{
            $insert = DB::table('t_workshop_mendeley')->insert([
                    'user_id' => $user_id,
                    'workshop' => $workshopPath,
                    'v_workshop' => 'N',
                    'status' => 'N',
                    'created_at' => now()
                ]);

                if ($insert) {
                    return response()->json(['success' => true, 'message' => 'Berkas berhasil diupload dan disimpan.']);
                }else{
                    return response()->json(['success' => false, 'message' => 'Berkas gagal diupload.']);
                }
        }

        
    }

    public function uploadWorkshopAction(Request $request)
    {
        $request->validate([
            
            'workshop' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        $user_id = Session::getFacadeRoot()->get('id_user2');

        $existingData = DB::table('t_workshop_ta')
            ->where('user_id', $user_id)
            ->first();

        // Simpan file ke storage dan dapatkan path-nya
        $workshopPath = $request->file('workshop')->store('uploads/workshop', 'public');
        

        if ($existingData) {
            $update = DB::table('t_workshop_ta')
                    ->where('id', $existingData->id)
                    ->update([
                        'workshop' => $workshopPath,
                        'v_workshop' => 'N',
                        'status' => 'N'
                    ]);
            if ($update) {
                return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
            }else{
                return response()->json(['success' => false, 'message' => 'Data gagal diperbarui.']);
            }

        }else{
            $insert = DB::table('t_workshop_ta')->insert([
                    'user_id' => $user_id,
                    'workshop' => $workshopPath,
                    'v_workshop' => 'N',
                    'status' => 'N',
                    'created_at' => now()
                ]);

                if ($insert) {
                    return response()->json(['success' => true, 'message' => 'Berkas berhasil diupload dan disimpan.']);
                }else{
                    return response()->json(['success' => false, 'message' => 'Berkas gagal diupload.']);
                }
        }

        
    }

    public function daftarWTAAction(Request $request)
    {
        $request->validate([
            'transkrip' => 'required|file|mimes:pdf',
            'seminar' => 'required|file|mimes:pdf',
            'pkm' => 'required|file|mimes:pdf',
            'pembayaran' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        $user_id = Session::getFacadeRoot()->get('id_user2');

        $existingData = DB::table('t_wta')
            ->where('user_id', $user_id)
            ->first();

        // Simpan file ke storage dan dapatkan path-nya
        $transkripPath = $request->file('transkrip')->store('uploads/wta/transkrip', 'public');
        $seminarPath = $request->file('seminar')->store('uploads/wta/seminar', 'public');
        $pkmPath = $request->file('pkm')->store('uploads/wta/pkm', 'public');
        $pembayaranPath = $request->file('pembayaran')->store('uploads/wta/pembayaran', 'public');

        if ($existingData) {
            $update = DB::table('t_wta')
                    ->where('id', $existingData->id)
                    ->update([
                        'transkrip' => $transkripPath,
                        'seminar' => $seminarPath,
                        'pkm' => $pkmPath,
                        'pembayaran' => $pembayaranPath
                    ]);
            if ($update) {
                return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
            }else{
                return response()->json(['success' => false, 'message' => 'Data gagal diperbarui.']);
            }

        }else{
            $insert = DB::table('t_wta')->insert([
                    'user_id' => $user_id,
                    'transkrip' => $transkripPath,
                    'v_transkrip' => 'N',
                    'seminar' => $seminarPath,
                    'v_seminar' => 'N',
                    'pkm' => $pkmPath,
                    'v_pkm' => 'N',
                    'pembayaran' => $pembayaranPath,
                    'v_pembayaran' => 'N',
                    'status' => 'N',
                    'created_at' => now()
                ]);

                if ($insert) {
                    return response()->json(['success' => true, 'message' => 'Berkas berhasil diupload dan disimpan.']);
                }else{
                    return response()->json(['success' => false, 'message' => 'Berkas gagal diupload.']);
                }
    
            
        }

        
    }

    
    public function daftarWTAUlangAction(Request $request)
    {
        
        $user_id = Session::getFacadeRoot()->get('id_user2');

        $existingData = DB::table('t_wta')
            ->where('user_id', $user_id)
            ->first();

        $transkripPath = $existingData->transkrip ?? null;
        $seminarPath = $existingData->seminar ?? null;
        $pkmPath = $existingData->pkm ?? null;
        $pembayaranPath = $existingData->pembayaran ?? null;
        if ($existingData->v_transkrip == "T") {
            $v_transkrip = "N";
        }else{
            $v_transkrip = $existingData->v_transkrip;
        }
        if ($existingData->v_seminar == "T") {
            $v_seminar = "N";
        }else{
            $v_seminar = $existingData->v_seminar;
        }
        if ($existingData->v_pkm == "T") {
            $v_pkm = "N";
        }else{
            $v_pkm = $existingData->v_pkm;
        }
        if ($existingData->v_pembayaran == "T") {
            $v_pembayaran = "N";
        }else{
            $v_pembayaran = $existingData->v_pembayaran;
        }


        if ($request->hasFile('transkrip')) {
            $transkripPath = $request->file('transkrip')->store('uploads/wta/transkrip', 'public');
        }
        if ($request->hasFile('seminar')) {
            $seminarPath = $request->file('seminar')->store('uploads/wta/seminar', 'public');
        }
        if ($request->hasFile('pkm')) {
            $pkmPath = $request->file('pkm')->store('uploads/wta/pkm', 'public');
        }
        if ($request->hasFile('pembayaran')) {
            $pembayaranPath = $request->file('pembayaran')->store('uploads/wta/pembayaran', 'public');
        }

        $update = DB::table('t_wta')
                    ->where('id', $existingData->id)
                    ->update([
                        'transkrip' => $transkripPath,
                        'v_transkrip' => $v_transkrip,
                        'seminar' => $seminarPath,
                        'v_seminar' => $v_seminar,
                        'pkm' => $pkmPath,
                        'v_pkm' => $v_pkm,
                        'pembayaran' => $pembayaranPath,
                        'v_pembayaran' => $v_pembayaran,
                        'status' => 'N'
                    ]);
            if ($update) {
                return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
            }else{
                return response()->json(['success' => false, 'message' => 'Data gagal diperbarui.']);
            }

       
        
    }

    
    public function getDosen()
    {
        $data = DB::select('SELECT * FROM apps_user WHERE role_id = 5 ORDER BY id_user ASC');
        return response()->json($data);
    }
    public function getFakultas()
    {
        $data = DB::select('SELECT * FROM reff_fakultas ORDER BY fakultas ASC');
        return response()->json($data);
    }

    public function getProdiByFakultas(Request $request)
    {
        $fakultas = $request->input('fakultas');
        $data = DB::select('SELECT * FROM reff_prodi WHERE fakultas_id = "' . $fakultas . '" ORDER BY prodi ASC');
        return response()->json($data);
    }

    public function getAngkatan()
    {
        $data = DB::select('SELECT * FROM reff_angkatan ORDER BY angkatan ASC');
        return response()->json($data);
    }
}
