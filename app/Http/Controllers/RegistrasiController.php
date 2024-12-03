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

class RegistrasiController extends Controller
{
    public function index(): View
    {

        return view('registrasi.index');
    }

    public function registrasiAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:200',
            'email' => 'required',
            'nim' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
       
        $hashedPassword = Hash::make($request->password);

        $save = DB::table('apps_user')->insert([
            'nama'        => $request->nama,
            'nim'  => $request->nim,
            'password' => $hashedPassword,
            'email'        => $request->email,
            'role_id'  => 3,
            'created_at' => date("Y-m-d H:i:s")
        ]);



        return response()->json(['success' => true, 'message' => 'Berhasil Daftar']);
    }

    
}
