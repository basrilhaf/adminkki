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
    public function index(): View
    {

        return view('login.index');
    }

    public function loginAction(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->username;

        $cek_user = DB::select('SELECT A.*, B.nama_role FROM apps_user A inner join apps_role B on A.role_id = B.id_role
                WHERE (A.username = "' . $username . '" OR A.email = "' . $username . '" )
                AND A.status ="Y"');

        if (count($cek_user) > 0) {
            $password_db = $cek_user[0]->password;
            if (Hash::check($request->password, $password_db)) {

                $id_hash = Crypt::encrypt($cek_user[0]->id_user);
                $request->session()->put('id_user', $id_hash);
                $request->session()->put('nama_user', $cek_user[0]->nama);
                $request->session()->put('email_user', $cek_user[0]->email);
                $request->session()->put('role_user', $cek_user[0]->nama_role);
                $request->session()->put('kelurahan_user', $cek_user[0]->kelurahan_id);
                $request->session()->put('id_role', $cek_user[0]->role_id);

                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Password tidak valid']);
            }
        } else {
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
