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
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $dataService;

    public function __construct(DataService $dataService, Request $request)
    {

        
        $this->dataService = $dataService;
    }
    
    public function index(): View
    {

        return view('login.index');
    }


    public function loginAction(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->username;

        
        
        $cek_user = DB::select('SELECT A.*, B.nama_role, B.redirect_login,B.id_role,B.id_role2 FROM user A inner join apps_role B on A.jenis = B.id_role2
                WHERE A.email = "' . $username . '"');
        
        if (count($cek_user) > 0) {
            $password_db = $cek_user[0]->password;
            if (Hash::check($request->password, $password_db)) {
                

                $id_hash = Crypt::encrypt($cek_user[0]->id);
                $request->session()->put('id_user', $id_hash);
                $request->session()->put('id_user2', $cek_user[0]->id);
                $request->session()->put('nama_user', $cek_user[0]->nama);
                $request->session()->put('email_user', $cek_user[0]->email);
                $request->session()->put('role_user', $cek_user[0]->nama_role);
                $request->session()->put('id_role', $cek_user[0]->id_role);
                $request->session()->put('id_role2', $cek_user[0]->id_role2);
                $request->session()->put('cabang', $cek_user[0]->cabang);
                $request->session()->put('is_kc', 0);
                $request->session()->put('is_wkc', 0);

                $this->dataService->createAuditTrail('Login Sistem');
                return response()->json(['success' => true, 'message' =>$cek_user[0]->redirect_login]);
            } else {
                return response()->json(['success' => false, 'message' => 'Password tidak valid']);
            }
        } else {
            $cek_pkp = DB::select('SELECT A.*, B.nama_role, B.redirect_login,B.id_role,B.id_role2 FROM pkp A inner join apps_role B on B.id_role2 = 3
                WHERE A.nik = "' . $username . '"');

            if (count($cek_pkp) > 0) {
                $password_db = $cek_pkp[0]->password;
                if (Hash::check($request->password, $password_db)) {

                    $id_hash = Crypt::encrypt($cek_user[0]->id);
                    $request->session()->put('id_user', $id_hash);
                    $request->session()->put('id_user2', $cek_pkp[0]->id);
                    $request->session()->put('nama_user', $cek_pkp[0]->nama);
                    $request->session()->put('email_user', $cek_pkp[0]->email_pkp);
                    $request->session()->put('role_user', $cek_pkp[0]->nama_role);
                    $request->session()->put('id_role', $cek_pkp[0]->id_role);
                    $request->session()->put('id_role2', $cek_pkp[0]->id_role2);
                    $request->session()->put('is_kc', $cek_pkp[0]->is_kc);
                    $request->session()->put('is_wkc', $cek_pkp[0]->is_wkc);
                    $request->session()->put('cabang', $cek_user[0]->cabang);
                    
                    $this->dataService->createAuditTrail('Login Sistem');
                    return response()->json(['success' => true, 'message' =>$cek_pkp[0]->redirect_login]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Password tidak valid']);
                }
            }else{
                return response()->json(['success' => false, 'message' => 'Username atau email tidak terdaftar']);
            }

            return response()->json(['success' => false, 'message' => 'Username atau email tidak terdaftar']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
