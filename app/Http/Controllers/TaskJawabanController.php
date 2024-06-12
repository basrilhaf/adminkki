<?php

namespace App\Http\Controllers;

use App\Services\DataService;
use Crypt;
use App\Models\Role;
use App\Models\Task;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TaskJawabanController extends Controller
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
        $menu_aktif = '/task||/taskJawaban';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Jawaban Survey',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Survey</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Jawaban Survey</li>
                            </ul>'
        ];

        return view('task_jawaban.index', $data);
    }

    public function getTaskJawaban(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('t_task')
                ->join('apps_user', 't_task.user_id', '=', 'apps_user.id_user')
                ->select('t_task.*', 'apps_user.nama')->where('t_task.finish_task', 'Y');

            if ($request->filled('nama_task')) {
                $query->where('t_task.nama_task', 'like', '%' . $request->input('nama_task') . '%');
            }

            if ($request->filled('tanggal_task')) {
                $query->where('t_task.tanggal_task', $request->input('tanggal_task'));
            }

            if ($request->filled('surveyor')) {
                $query->where('apps_user.nama', 'like', '%' . $request->input('surveyor') . '%');
            }

            $filteredData = $query->latest()->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->id_task);

                    $infoUrl = route('taskjawaban.infoTaskJawaban', $id_hash);
                    $editUrl = route('task.editTask', $id_hash);
                    $deleteUrl = route('task.deleteTask', $id_hash);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-success btn-sm"><span class="fa fa-info"></span></a> ';
                    return $btn;
                })


                ->addColumn('is_finish', function ($row) {
                    if ($row->finish_task == 'Y') {
                        $is_finish = '<span class="btn btn-light-success">Sudah Survey</span>';
                    } else {
                        $is_finish = '<span class="btn btn-light-warning">Belum Survey</span>';
                    }

                    return $is_finish;
                })
                ->addColumn('status_publish', function ($row) {
                    if ($row->publish_task == 'Y') {
                        $is_finish = '<span class="btn btn-light-success">Publish</span>';
                    } else {
                        $is_finish = '<span class="btn btn-light-warning">Draft</span>';
                    }

                    return $is_finish;
                })
                ->rawColumns(['action', 'is_finish', 'status_publish'])
                ->make(true);
        }
    }

    public function detailTaskJawaban($id_task, Request $request)
    {
        if ($request->ajax()) {


            $id_task = Crypt::decrypt($id_task);
            $query = DB::table('t_task_pertanyaan AS A')->Join('t_pertanyaan AS B', 'A.pertanyaan_id', '=', 'B.id_pertanyaan')->Join('t_task_jawaban AS C', 'A.id_task_pertanyaan', '=', 'C.task_pertanyaan_id')
                ->select('B.*', 'A.id_task_pertanyaan', 'C.jawaban')->where('A.task_id', $id_task)->orderBy('id_task_pertanyaan', 'asc');

            $filteredData = $query->latest()->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()

                ->addColumn('list_pilihan_field', function ($row) {
                    if ($row->jenis_pertanyaan == 'M') {
                        $pecah_jawaban = explode("|||", $row->jawaban);
                        $pilihanList = '<ul>';
                        foreach ($pecah_jawaban  as $jawaban) {
                            $pilihanList .= '<li class="mb-2"><textarea class="form-control" disabled>' . $jawaban . '</textarea></li>';
                        }
                        $pilihanList .= '</ul';
                    } else {
                        $pilihanList = '<textarea class="form-control" disabled>' . $row->jawaban . '</textarea>';
                    }

                    // $querypilihan = DB::table('t_task_jawaban AS A')->select('A.*')->where('A.task_pertanyaan_id', $row->id_task_pertanyaan)->get();

                    // if ($row->jenis_pertanyaan != '') {
                    //     if ($row->jenis_pertanyaan == 'F') {
                    //         $pilihanList = '<input type="text" class="form-control" disabled value="Jawaban merupakan free text"></input>';
                    //     } else {
                    //         $querypilihan = DB::table('t_pertanyaan_pilihan AS A')->select('A.*')->where('A.pertanyaan_id', $row->id_pertanyaan)->get();
                    //         $pilihanList = '';
                    //         foreach ($querypilihan as $pilihan) {
                    //             if ($row->jenis_pertanyaan == 'S') {
                    //                 $pilihanList .= '<input type="radio" name="radio_pilihan" value="' . $pilihan->id_pertanyaan_pilihan . '">
                    //                                     <label for="radio_' . $pilihan->id_pertanyaan_pilihan . '">' . $pilihan->pilihan . '</label><br>';
                    //             } else if ($row->jenis_pertanyaan == 'M') {
                    //                 $pilihanList .= '<input type="checkbox" id="checkbox_' . $pilihan->id_pertanyaan_pilihan . '" name="checkbox_pilihan[]" value="' . $pilihan->id_pertanyaan_pilihan . '">
                    //                 <label for="checkbox_' . $pilihan->id_pertanyaan_pilihan . '">' . $pilihan->pilihan . '</label><br>';
                    //             } else {
                    //             }
                    //         }
                    //     }
                    // }


                    return $pilihanList;
                })
                ->addColumn('view_detail', function ($row) {
                    return '<button title="EDIT" class="btn btn-light-warning btn-sm btn-view-detail" data-id="' . $row->id_task_pertanyaan . '"><i class="fa fa-pencil"></i></button> 
                            <button title="HAPUS" class="btn btn-danger btn-delete btn-sm" data-id="' . $row->id_task_pertanyaan . '"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['list_pilihan_field', 'view_detail'])
                ->make(true);
        }
    }

    public function showDetailTaskJawaban($id_task_pertanyaan)
    {

        $data = DB::table('t_task_pertanyaan AS A')
            ->Join('t_pertanyaan AS B', 'A.pertanyaan_id', '=', 'B.id_pertanyaan')
            ->leftJoin('t_task_jawaban AS C', 'A.id_task_pertanyaan', '=', 'C.task_pertanyaan_id')
            ->select(
                'A.*',
                'B.pertanyaan',
                'B.jenis_pertanyaan',
                'C.jawaban'
            )
            ->where('A.id_task_pertanyaan', $id_task_pertanyaan)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

    public function infoTaskJawaban($id_task, Request $request)
    {
        $menu_aktif = '/task||/taskJawaban';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        $data = [
            'menu' => 'Detail Jawaban Survey',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li><li class="breadcrumb-item text-gray-700 fw-bold lh-1">Survey</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Jawaban Survey</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Detail Jawaban Survey</li>
                            </ul>',
            'id_task' => $id_task
        ];

        return view('task_jawaban.info-taskjawaban', $data);
    }
}
