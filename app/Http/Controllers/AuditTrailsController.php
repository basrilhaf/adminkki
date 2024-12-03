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

class AuditTrailsController extends Controller
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
        $menu_aktif = '/auditTrails||/settings';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Audit Trails',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];

        return view('auditTrails.index', $data);
    }

    public function getAuditTrails(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('audit_trail')
                
                ->select('*');

            if ($request->filled('keterangan')) {
                $query->where('keterangan', 'like', '%' . $request->input('keterangan') . '%');
            }
            if ($request->filled('nama')) {
                $query->where('user', 'like', '%' . $request->input('nama') . '%');
            }

            $filteredData = $query->orderBy('id_audit', 'desc')->take(1000)->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_audit);

                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-audit btn-sm" data-id="' . $id_hash . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                

                ->rawColumns(['action'])
                ->make(true);
        }
    }

}
