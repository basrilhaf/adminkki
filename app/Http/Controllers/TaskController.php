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

class TaskController extends Controller
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
        $menu_aktif = '/task||/tasklist';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Task Survey',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Survey</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Task Survey</li>
                            </ul>'
        ];
        //get posts

        //render view with posts
        return view('task.index', $data);
    }

    public function getTask(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('t_task')
                ->join('apps_user', 't_task.user_id', '=', 'apps_user.id_user')
                ->select('t_task.*', 'apps_user.nama');

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

                    $infoUrl = route('task.infoTask', $id_hash);
                    $editUrl = route('task.editTask', $id_hash);
                    $deleteUrl = route('task.deleteTask', $id_hash);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-success btn-sm"><span class="fa fa-info"></span></a> ';
                    $btn .= '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    $btn .= '<button title="HAPUS" class="btn btn-danger btn-delete-task btn-sm" data-id="' . $id_hash . '"><span class="fa fa-trash"></span></button>';
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

    public function addTask(Request $request)
    {
        $menu_aktif = '/task||/tasklist';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Tambah Task Survey',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Survey</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Task Survey</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Tambah Task Survey</li>
                            </ul>'
        ];

        return view('task.add-task', $data);
    }

    public function infoTask($id_task, Request $request)
    {
        $menu_aktif = '/task||/tasklist';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        $data = [
            'menu' => 'Detail Task Survey',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Survey</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Task Survey</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Detail Task Survey</li>
                            </ul>',
            'id_task' => $id_task
        ];

        return view('task.info-task', $data);
    }

    public function showDetailTask($id_task)
    {
        $id_task = Crypt::decrypt($id_task);
        $data = DB::table('t_task AS A')
            ->leftJoin('apps_user AS B', 'A.user_id', '=', 'B.id_user')
            ->leftJoin('m_kelurahan AS C', 'A.kelurahan_id', '=', 'C.kelurahan_kode')
            ->leftJoin('m_kecamatan AS F', 'C.kecamatan_kode', '=', 'F.kecamatan_kode')
            ->leftJoin('m_kabkota AS G', 'F.kabkota_kode', '=', 'G.kabkota_kode')
            ->leftJoin('m_provinsi AS H', 'H.provinsi_kode', '=', 'G.provinsi_kode')
            ->leftJoin('reff_kolom_table AS D', function ($join) {
                $join->on('A.kegiatan_task', '=', 'D.isi_kolom')
                    ->where('D.table', '=', 't_task')
                    ->where('D.kolom', '=', 'kegiatan_task');
            })
            ->leftJoin('t_wakaf AS E', 'A.wakaf_id', '=', 'E.id_wakaf')

            ->select(
                'A.*',
                'B.nama as surveyor',
                'C.kelurahan_nama',
                'C.kelurahan_kode',
                'F.kecamatan_nama',
                'F.kecamatan_kode',
                'G.kabkota_nama',
                'G.kabkota_kode',
                'H.provinsi_nama',
                'H.provinsi_kode',
                'D.keterangan as kegiatan',
                DB::raw('CONCAT(E.guna, " - ", E.status) AS objek')
            )
            ->where('A.id_task', $id_task)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

    public function showDetailTaskPertanyaan($id_task_pertanyaan)
    {

        $data = DB::table('t_task_pertanyaan AS A')
            ->leftJoin('t_pertanyaan AS B', 'A.pertanyaan_id', '=', 'B.id_pertanyaan')
            ->select(
                'A.*',
                'B.pertanyaan',
                'B.jenis_pertanyaan'
            )
            ->where('A.id_task_pertanyaan', $id_task_pertanyaan)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

    public function editTask($id_task, Request $request)
    {
        $menu_aktif = '/task||/tasklist';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        $data = [
            'menu' => 'Detail Task List',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="#" class="text-gray-500 text-hover-primary"><i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i></a></li>
                                <li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Survey</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Task Survey</li><li class="breadcrumb-item"><i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i></li>
                                <li class="breadcrumb-item text-gray-700">Edit Task Survey</li>
                            </ul>',
            'id_task' => $id_task
        ];

        return view('task.edit-task', $data);
    }



    public function editTaskAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_task' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $id_task = Crypt::decrypt($request->id_task);

        $task = Task::find($id_task);
        $task->update([
            'nama_task' => $request->nama,
            'tanggal_task' => $request->tanggal,
            'kelurahan_id' => $request->kelurahan,
            'user_id' => $request->surveyor,
            'kegiatan_task' => $request->jenis,
            'wakaf_id' => $request->objek,
        ]);

        if ($task) {
            return response()->json(['success' => true, 'message' => 'Berhasil update task']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update task']);
        }
    }

    public function editTaskPertanyaanAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_task_pertanyaan' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // $id_task = Crypt::decrypt($request->id_task);

        $task = DB::table('t_task_pertanyaan')
            ->where('id_task_pertanyaan', $request->id_task_pertanyaan)
            ->update([
                'pertanyaan_id' => $request->pertanyaan_baru
            ]);

        if ($task) {
            return response()->json(['success' => true, 'message' => 'Berhasil update pertanyaan task']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update pertanyaan task']);
        }
    }

    public function publishTaskAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_task' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $id_task = Crypt::decrypt($request->id_task);
        $update = DB::update('update t_task set publish_task = ? where id_task = ?', ['Y', $id_task]);

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Berhasil publish task']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal publish task']);
        }
    }

    public function deleteTaskPertanyaanAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_task_pertanyaan' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $deleted = DB::table('t_task_pertanyaan')->where('id_task_pertanyaan', $request->id_task_pertanyaan)->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus pertanyaan task']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus pertanyaan task']);
        }
    }

    public function deleteTaskAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_task' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $id_task = Crypt::decrypt($request->id_task);
        $deleted = DB::table('t_task')->where('id_task', $id_task)->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus task']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus task']);
        }
    }


    public function detailTaskPertanyaan($id_task, Request $request)
    {
        if ($request->ajax()) {


            $id_task = Crypt::decrypt($id_task);
            $query = DB::table('t_task_pertanyaan AS A')->Join('t_pertanyaan AS B', 'A.pertanyaan_id', '=', 'B.id_pertanyaan')
                ->select('B.*', 'A.id_task_pertanyaan')->where('A.task_id', $id_task)->orderBy('id_task_pertanyaan', 'asc');

            $filteredData = $query->latest()->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()

                ->addColumn('list_pilihan_field', function ($row) {
                    if ($row->jenis_pertanyaan != '') {
                        if ($row->jenis_pertanyaan == 'F') {
                            $pilihanList = '<input type="text" class="form-control" disabled value="Jawaban merupakan free text"></input>';
                        } else {
                            $querypilihan = DB::table('t_pertanyaan_pilihan AS A')->select('A.*')->where('A.pertanyaan_id', $row->id_pertanyaan)->get();
                            $pilihanList = '';
                            foreach ($querypilihan as $pilihan) {
                                if ($row->jenis_pertanyaan == 'S') {
                                    $pilihanList .= '<input type="radio" name="radio_pilihan" value="' . $pilihan->id_pertanyaan_pilihan . '">
                                                        <label for="radio_' . $pilihan->id_pertanyaan_pilihan . '">' . $pilihan->pilihan . '</label><br>';
                                } else if ($row->jenis_pertanyaan == 'M') {
                                    $pilihanList .= '<input type="checkbox" id="checkbox_' . $pilihan->id_pertanyaan_pilihan . '" name="checkbox_pilihan[]" value="' . $pilihan->id_pertanyaan_pilihan . '">
                                    <label for="checkbox_' . $pilihan->id_pertanyaan_pilihan . '">' . $pilihan->pilihan . '</label><br>';
                                } else {
                                }
                            }
                        }
                    }


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

    public function getReffKegiatanTask()
    {
        $kegiatan = DB::select('SELECT * FROM reff_kolom_table 
                                        WHERE reff_kolom_table.table = "t_task" 
                                        AND reff_kolom_table.kolom ="kegiatan_task" 
                                        AND reff_kolom_table.status_show = "Y"
                                        ORDER BY id_reff ASC');
        return response()->json($kegiatan);
    }

    public function getObjekTask(Request $request)
    {
        $kecamatan_kode = $request->input('kecamatan_kode');
        $data = DB::select('SELECT * FROM t_wakaf WHERE kecamatan_id = "' . $kecamatan_kode . '" ORDER BY guna ASC');
        return response()->json($data);
    }

    public function getPertanyaanTask()
    {
        $pertanyaan = DB::select('SELECT *, CONCAT(id_pertanyaan, "||", jenis_pertanyaan) AS concat_id FROM t_pertanyaan  ORDER BY id_pertanyaan ASC');
        return response()->json($pertanyaan);
    }

    public function getPilihanPertanyaanTask(Request $request)
    {
        $pertanyaan_id = $request->input('id');
        $data = DB::select('SELECT * FROM t_pertanyaan_pilihan WHERE pertanyaan_id = "' . $pertanyaan_id . '" ORDER BY id_pertanyaan_pilihan ASC');
        return response()->json($data);
    }

    public function addTaskAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:300',
            'tanggal' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kode_task = date('ymdhis') . rand(10, 100);

        $id_task = DB::table('t_task')->insertGetId([
            'nama_task'        => $request->nama,
            'kode_task'        => $kode_task,
            'tanggal_task'  => $request->tanggal,
            'user_id'        => $request->surveyor,
            'kelurahan_id'  => $request->kelurahan,
            'kegiatan_task'        => $request->jenis,
            'wakaf_id'        => $request->objek,
            'created_task'  => '1',
            'finish_task' => 'N',
            'publish_task' => 'N',
            'created_at' => date("Y-m-d H:i:s")
        ]);

        if ($id_task != '') {
            foreach ($request->pertanyaan as $pilihan) {
                $pecah_pilihan = explode("||", $pilihan);
                $insert_pertanyaan_task = DB::table('t_task_pertanyaan')->insert([
                    'task_id'        => $id_task,
                    'pertanyaan_id'  => $pecah_pilihan[0],
                    'created_at' => date("Y-m-d H:i:s")
                ]);
            }
        }



        return response()->json(['success' => true, 'message' => 'Task saved successfully']);
    }

    public function addTaskPertanyaanAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
            'pertanyaan' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task_id =  Crypt::decrypt($request->task_id);

        foreach ($request->pertanyaan as $pilihan) {
            $pecah_pilihan = explode("||", $pilihan);
            $insert_pertanyaan_task = DB::table('t_task_pertanyaan')->insert([
                'task_id'        => $task_id,
                'pertanyaan_id'  => $pecah_pilihan[0],
                'created_at' => date("Y-m-d H:i:s")
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Task saved successfully']);
    }
}
