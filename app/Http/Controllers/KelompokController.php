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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Response;



class KelompokController extends Controller
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
        $menu_aktif = '/kelompokAktif||/kelompok';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Kelompok Aktif',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('kelompok.index', $data);
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

    public function downloadKelompok(): View
    {
        $menu_aktif = '/downloadKelompok||/kelompok';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Download Kelompok',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('kelompok.download-kelompok', $data);
    }

    public function dataKelompok(): View
    {
        $menu_aktif = '/dataKelompok||/kelompok';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Data Kelompok',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('kelompok.data-kelompok', $data);
    }

    

    public function masalahKelompok(): View
    {
        $menu_aktif = '/masalahKelompok||/kelompok';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Masalah Kelompok',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('kelompok.masalah-kelompok', $data);
    }

    public function getSemuaKelompok(Request $request)
    {
        if ($request->ajax()) {
    
            $query = DB::connection('mysql_secondary')
                ->table('kredit as A')
                ->select(
                    'B.deskripsi_group1',
                    'B.kode_group1',
                    'A.tgl_realisasi',
                    'A.tgl_jatuh_tempo'  
                )
                ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'A.kode_group1')
                ->join('kre_kode_group2 as C', 'C.kode_group2', '=', 'A.kode_group2');
    
            if ($request->filled('nama')) {
                $query->where('B.deskripsi_group1', 'like', '%' . $request->input('nama') . '%');
            }
    
            if ($request->filled('id')) {
                $query->where('B.kode_group1', 'like', '%' . $request->input('id') . '%');
            }
    
            if ($request->filled('status')) {
                if($request->input('status') == 1){
                    $query->where('A.tgl_jatuh_tempo', '>=', date('Y-m-d'));
                }else if($request->input('status') == 2){
                    $query->where('A.tgl_jatuh_tempo', '<', date('Y-m-d'));
                }else{

                }
                
            }
    
            $filteredData = $query->groupBy(
                    'B.deskripsi_group1',
                    'B.kode_group1',
                    'A.tgl_realisasi',
                    'A.tgl_jatuh_tempo'
                )
                ->orderBy('B.kode_group1', 'desc')
                ->get();
    
            return DataTables::of($filteredData)
                ->addIndexColumn() 
                ->addColumn('action', function ($row) {
                    $infoUrl = route('user.infoUser', $row->kode_group1);
                    $btn = '<a href="' . $infoUrl . '" class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    if($row->tgl_jatuh_tempo >= date('Y-m-d')){
                        $status = '<span class="btn btn-light-success btn-sm">Aktif</span>';
                    }else{
                        $status = '<span class="btn btn-light-danger btn-sm">Tidak Aktif</span>';
                    }
                    
                    return $status;
                })
                ->rawColumns(['action','status']) 
                ->make(true);
        }
    }

    public function getKelompokAktif(Request $request)
    {
        if ($request->ajax()) {
    
            $query = DB::connection('mysql_secondary')
                ->table('kredit as A')
                ->select(
                    'B.deskripsi_group1',
                    'B.kode_group1',
                    'D.NAMA_KANTOR',
                    'A.tgl_realisasi',
                    'A.tgl_jatuh_tempo',
                    'C.deskripsi_group2',
                    'A.jml_angsuran',
                    'A.tgl_jatuh_tempo',
                    DB::raw('SUM(A.jml_pinjaman) AS jumlah_pinjaman')
                )
                ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'A.kode_group1')
                ->join('kre_kode_group2 as C', 'C.kode_group2', '=', 'A.kode_group2')
                ->join('app_kode_kantor as D', 'B.kode_kantor', '=', 'D.KODE_KANTOR')
                ->where('A.pokok_saldo_akhir', '>', 0);
    
            // Filter by "nama" if present
            if ($request->filled('nama')) {
                $query->where('B.kode_group1', 'like', '%' . $request->input('nama') . '%');
            }
    
            // Filter by "cabang" if present
            if ($request->filled('cabang')) {
                $query->where('D.NAMA_KANTOR', 'like', '%' . $request->input('cabang') . '%');
            }
    
            // Filter by "pkp" if present (using the correct column alias for deskripsi_group2)
            if ($request->filled('pkp')) {
                $query->where('C.deskripsi_group2', 'like', '%' . $request->input('pkp') . '%');
            }
    
            // Grouping the results and applying the order
            $filteredData = $query->groupBy(
                    'B.deskripsi_group1', 
                    'B.kode_group1', 
                    'D.NAMA_KANTOR', 
                    'A.tgl_realisasi', 
                    'A.tgl_jatuh_tempo', 
                    'C.deskripsi_group2', 
                    'A.jml_angsuran', 
                    'A.tgl_jatuh_tempo'
                )
                ->orderBy('B.kode_group1', 'desc')
                ->get();
    
            // Returning the results for DataTables with action buttons
            return DataTables::of($filteredData)
                ->addIndexColumn()  // Adds the index column
                ->addColumn('action', function ($row) {
                    // URL for the action button
                    $infoUrl = route('user.infoUser', $row->kode_group1);
                    // Creating the action button
                    $btn = '<a href="' . $infoUrl . '" class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action'])  // Ensures the action button is rendered as HTML
                ->make(true);
        }
    }

    public function getCariKelompok(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');

            $keyword = $request->input('keyword');

            $query = DB::connection('mysql_secondary')
                ->table('kredit as A')
                ->select(
                    'B.deskripsi_group1',
                    'B.kode_group1',
                    'A.tgl_realisasi',
                    'A.jml_angsuran',
                    'A.tgl_jatuh_tempo'
                )
                ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'A.kode_group1')
                ->where('B.deskripsi_group1', 'like', '%' . $keyword . '%');
              
            $query->groupBy('B.deskripsi_group1',
                    'B.kode_group1',
                    'A.tgl_realisasi',
                    'A.jml_angsuran',
                    'A.tgl_jatuh_tempo')
                    ->orderBy('B.kode_group1', 'desc')
                    ->get();

            // var_dump($query);die();

            return DataTables::of($query)
                ->addIndexColumn()  // Adds row index
                ->addColumn('action', function ($row) {
                    
                    $infoUrl = route('detailKelompok', $row->kode_group1);
                    return '<a href="' . $infoUrl . '" class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a>';
                })
                ->rawColumns(['action'])  // Allow HTML rendering in the action column
                ->make(true);  // Return the response in DataTables format
        }
    }

    
    public function getCariDownloadKelompok(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');

            $tanggal = $request->input('tanggal');

            $query = DB::connection('mysql_secondary')
                ->table('kredit as A')
                ->select(
                    'B.deskripsi_group1',
                    'B.kode_group1',
                    'C.nasabah_id',
                    'C.NAMA_NASABAH',
                    'A.jml_pinjaman',
                    'A.jml_angsuran',
                    'A.tgl_realisasi'
                )
                ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'A.kode_group1')
                ->join('nasabah as C', 'C.nasabah_id', '=', 'A.nasabah_id')
                ->where('A.tgl_realisasi', '<=',  $tanggal)
                ->where('A.tgl_jatuh_tempo', '>=',  $tanggal)
                ->orderBy('C.nasabah_id', 'asc')
                ->get();
              
            
            // var_dump($query);die();

            return DataTables::of($query)
                ->addIndexColumn()  // Adds row index
                ->addColumn('action', function ($row) {
                    
                    $infoUrl = route('detailKelompok', $row->nasabah_id);
                    return '<a href="' . $infoUrl . '" class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a>';
                })
                ->rawColumns(['action'])  // Allow HTML rendering in the action column
                ->make(true);  // Return the response in DataTables format
        }
    }
    
    public function getAnggotaKelompok(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');

            $kode_group1 = $request->input('kode_group1');

            $query = DB::connection('mysql_secondary')
                ->table('kredit as A')
                ->select(
                    'B.NAMA_NASABAH',
                    'A.jml_pinjaman',
                    'B.nasabah_id',
                    'A.jml_angsuran',
                    'A.tgl_jatuh_tempo'
                )
                ->join('nasabah as B', 'B.nasabah_id', '=', 'A.nasabah_id')
                ->where('A.kode_group1', $kode_group1)
                ->orderBy('A.nasabah_id', 'asc')
                ->get();
           
            return DataTables::of($query)
                ->addIndexColumn()  // Adds row index
                ->addColumn('action', function ($row) {
                    
                    $infoUrl = route('detailAnggota', $row->nasabah_id);
                    return '<a href="' . $infoUrl . '" class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a>';
                })
                ->rawColumns(['action'])  // Allow HTML rendering in the action column
                ->make(true);  // Return the response in DataTables format
        }
    }

    public function detailKelompok($kode_group1, Request $request): View
    {
        $menu_aktif = '/cariKelompok||/kelompok';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Detail Kelompok',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '',
            'kode_group1' => $kode_group1
        ];
        
        return view('kelompok.detail-kelompok', $data);
    }

    public function getDetailKelompok($kode_group1)
    {
        $data = DB::connection('mysql_secondary')
                ->table('kredit as A')
                ->select(
                    'B.deskripsi_group1',
                    'C.deskripsi_group2',
                    'B.kode_group1',
                    'A.tgl_realisasi',
                    'A.tgl_jatuh_tempo',
                    'A.jml_angsuran',
                    'A.tgl_jatuh_tempo',
                    DB::raw('SUM(A.jml_pinjaman) AS jumlah_pinjaman'),
                    DB::raw('COUNT(A.jml_pinjaman) AS jumlah_anggota')
                )
                ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'A.kode_group1')
                ->join('kre_kode_group2 as C', 'C.kode_group2', '=', 'A.kode_group2')
                ->where('B.kode_group1', $kode_group1)
                ->groupBy(
                    'B.deskripsi_group1',
                    'C.deskripsi_group2',
                    'B.kode_group1',
                    'A.tgl_realisasi',
                    'A.tgl_jatuh_tempo',
                    'A.jml_angsuran',
                    'A.tgl_jatuh_tempo'
                )->first();

         

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }


        return response()->json($data);
    }

    
    public function exportDownloadKelompok(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $data = DB::connection('mysql_secondary')
                ->table('kredit as A')
                ->select(
                    'B.deskripsi_group1',
                    'B.kode_group1',
                    'C.nasabah_id',
                    'C.NAMA_NASABAH',
                    'A.jml_pinjaman',
                    'A.jml_angsuran',
                    'A.tgl_realisasi',
                    'D.saldo_akhir',
                    'E.NAMA_KANTOR'
                )
                ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'A.kode_group1')
                ->join('nasabah as C', 'C.nasabah_id', '=', 'A.nasabah_id')
                ->join('tabung as D', function($join) {
                    $join->on('A.nasabah_id', '=', 'D.nasabah_id')
                         ->where('D.kode_integrasi', 204);
                })
                ->join('app_kode_kantor as E', 'B.kode_kantor', '=', 'E.KODE_KANTOR')
                ->where('A.tgl_realisasi', '<=',  $tanggal)
                ->where('A.tgl_jatuh_tempo', '>=',  $tanggal)
                ->orderBy('C.nasabah_id', 'asc')
                ->get();


        // $data = DB::connection('mysql_secondary')
        //     ->table('kredit as A')
        //     ->select('B.deskripsi_group1','B.kode_group1','D.NAMA_KANTOR', 'A.tgl_realisasi','A.tgl_jatuh_tempo','C.deskripsi_group2','A.jml_angsuran','A.tgl_jatuh_tempo','E.kode_group3','E.deskripsi_group3'
        //         ,DB::raw('SUM(A.jml_pinjaman) AS jumlah_pinjaman'))
        //     ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'A.kode_group1')
        //     ->join('kre_kode_group2 as C', 'C.kode_group2', '=', 'A.kode_group2')
        //     ->join('kre_kode_group3 as E', 'E.kode_group3', '=', 'A.kode_group3')
        //     ->join('app_kode_kantor as D', 'B.kode_kantor', '=', 'D.KODE_KANTOR')
        //     ->where('A.pokok_saldo_akhir', '>', 0)
        //     ->groupBy('B.deskripsi_group1','B.kode_group1','D.NAMA_KANTOR', 'A.tgl_realisasi','A.tgl_jatuh_tempo','C.deskripsi_group2','A.jml_angsuran','A.tgl_jatuh_tempo','E.kode_group3','E.deskripsi_group3')
        //     ->orderBy('B.kode_group1', 'desc')
        //     ->get();
            

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // Set header kolom
        $sheet->setCellValue('A1', 'Nama Kelompok')
              ->setCellValue('B1', 'ID Anggota')
              ->setCellValue('C1', 'Nama Anggota')
              ->setCellValue('D1', 'Pinjaman')
              ->setCellValue('E1', 'Tabungan Pribadi')
              ->setCellValue('F1', 'Cabang')
              ->setCellValue('G1', 'Durasi');

              
        $row = 2; // Mulai dari baris 2 setelah header
        foreach ($data as $user) {
            $sheet->setCellValue('A' . $row, $user->deskripsi_group1)
                  ->setCellValue('B' . $row, $user->nasabah_id)
                  ->setCellValue('C' . $row, $user->NAMA_NASABAH)
                  ->setCellValue('D' . $row, $user->jml_pinjaman)
                  ->setCellValue('E' . $row, $user->saldo_akhir)
                  ->setCellValue('F' . $row, $user->NAMA_KANTOR)
                  ->setCellValue('G' . $row, $user->jml_angsuran);

                  
            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output file Excel ke browser
        $filename = 'anggota_kelompok_aktif.xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }
    
    public function exportKelompok()
    {
       
        $data = DB::connection('mysql_secondary')
            ->table('kredit as A')
            ->select('B.deskripsi_group1','B.kode_group1','D.NAMA_KANTOR', 'A.tgl_realisasi','A.tgl_jatuh_tempo','C.deskripsi_group2','A.jml_angsuran','A.tgl_jatuh_tempo','E.kode_group3','E.deskripsi_group3'
                ,DB::raw('SUM(A.jml_pinjaman) AS jumlah_pinjaman'))
            ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'A.kode_group1')
            ->join('kre_kode_group2 as C', 'C.kode_group2', '=', 'A.kode_group2')
            ->join('kre_kode_group3 as E', 'E.kode_group3', '=', 'A.kode_group3')
            ->join('app_kode_kantor as D', 'B.kode_kantor', '=', 'D.KODE_KANTOR')
            ->where('A.pokok_saldo_akhir', '>', 0)
            ->groupBy('B.deskripsi_group1','B.kode_group1','D.NAMA_KANTOR', 'A.tgl_realisasi','A.tgl_jatuh_tempo','C.deskripsi_group2','A.jml_angsuran','A.tgl_jatuh_tempo','E.kode_group3','E.deskripsi_group3')
            ->orderBy('B.kode_group1', 'desc')
            ->get();
            

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // Set header kolom
        $sheet->setCellValue('A1', 'Nama Kelompok')
              ->setCellValue('B1', 'Tanggal Cair')
              ->setCellValue('C1', 'Cabang')
              ->setCellValue('D1', 'PKP')
              ->setCellValue('E1', 'Jumlah Pinjaman')
              ->setCellValue('F1', 'Durasi')
              ->setCellValue('G1', 'Tanggal Closed')
              ->setCellValue('H1', 'Kumpulan')
              ->setCellValue('I1', 'ID Kumpulan DB');

         
        $row = 2; // Mulai dari baris 2 setelah header
        foreach ($data as $user) {
            $sheet->setCellValue('A' . $row, $user->deskripsi_group1)
                  ->setCellValue('B' . $row, $user->tgl_realisasi)
                  ->setCellValue('C' . $row, $user->NAMA_KANTOR)
                  ->setCellValue('D' . $row, $user->deskripsi_group2)
                  ->setCellValue('E' . $row, $user->jumlah_pinjaman)
                  ->setCellValue('F' . $row, $user->jml_angsuran)
                  ->setCellValue('G' . $row, $user->tgl_jatuh_tempo)
                  ->setCellValue('H' . $row, $user->deskripsi_group3)
                  ->setCellValue('I' . $row, $user->kode_group3);

                  
            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output file Excel ke browser
        $filename = 'kelompok_aktif.xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }
    

    public function getMasalahKelompok(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('kelompok_bermasalah')
                ->select(
                    'kelompok_kb',
                    'cabang_kb',
                    'pkp_dkb',
                    'kc_dkb',
                    'nama',
                    DB::raw('kelompok_bermasalah.id_sikki_kb AS idsikkikb'),
                    DB::raw('COUNT(id_kb) AS jumlah'),
                    DB::raw('SUM(IF(kode_kb = "3A", 1, 0)) AS kode3a'),
                    DB::raw('SUM(IF(kode_kb = "3B", 1, 0)) AS kode3b')
                )
                ->leftJoin('data_kb', 'kelompok_bermasalah.kelompok_kb', '=', 'data_kb.kelompok_dkb')
                ->leftJoin('pkp', 'kelompok_bermasalah.pkp_kb', '=', 'pkp.id');

            // Applying filters conditionally
            if ($request->filled('kelompok')) {
                $query->where('kelompok_kb', 'like', '%' . $request->input('kelompok') . '%');
            }
            if ($request->filled('pkp')) {
                $query->where('pkp_dkb', 'like', '%' . $request->input('pkp') . '%');
            }
            if ($request->filled('kc')) {
                $query->where('kc_dkb', 'like', '%' . $request->input('kc') . '%');
            }

            // Grouping by idsikkikb and ordering by id_kb
            $filteredData = $query->groupBy('kelompok_kb', 'cabang_kb', 'pkp_dkb', 'kc_dkb', 'nama', 'kelompok_bermasalah.id_sikki_kb')
                ->orderBy('kelompok_bermasalah.id_sikki_kb', 'desc')
                ->get();
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->kelompok_kb);

                    $infoUrl = route('user.infoUser', $id_hash);
                    $editUrl = route('user.editUser', $id_hash);
                    
                    $btn = '<a href=' . $editUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    $btn .= '<button title="HAPUS" class="btn btn-danger btn-delete-user btn-sm" data-id="' . $id_hash . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    
    public function chartAnggotaBermasalah(Request $request)
    {
        
        $cabang = $request->input('cabang');
        $filterBy = $request->input('filter_by');
        $tahun = $request->input('tahun');
        $tampil = $request->input('tampil_berdasarkan');
        $tanggal = $request->input('tanggal');

        $chart_ab = DB::table('anggota_bermasalah');

        

        if ($filterBy == 'thn') {
            if ($tampil == 'min') {
                $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(tanggal_ab), "-", YEAR(tanggal_ab)) as bulan'), DB::raw('count(id_ab) as jumlah'));
            }else{
                $chart_ab->select(DB::raw('DATE_FORMAT(tanggal_ab, "%b-%Y") as bulan'), DB::raw('count(id_ab) as jumlah'));
            }
            $chart_ab->whereYear('tanggal_ab', '=', $tahun);
        }else{
            if ($tanggal !="") {
                $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(tanggal_ab), "-", YEAR(tanggal_ab)) as bulan'), DB::raw('count(id_ab) as jumlah'));
                $decoded_date_range = urldecode($tanggal);

                // Memisahkan tanggal menjadi dua bagian: awal dan akhir
                [$awal, $akhir] = explode(' to ', $decoded_date_range);

                // Menambahkan filter berdasarkan rentang tanggal
                $chart_ab->where('tanggal_ab', '>=', $awal)
                    ->where('tanggal_ab', '<=', $akhir);
            }
            
        }

        if ($cabang != '') {
            $chart_ab->where('cabang_ab', $cabang);
        }

        $chart_ab->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();

        // $chart_ab = DB::table('anggota_bermasalah') 
        // ->select(DB::raw('DATE_FORMAT(tanggal_ab, "%b-%Y") as bulan'), DB::raw('count(id_ab) as jumlah'))
        //         ->groupBy(DB::raw('bulan'))
        //         ->orderBy(DB::raw('bulan'))
        //         ->get();

        // Kembalikan data dalam format JSON
        return response()->json([
            'bulan' => $chart_ab->pluck('bulan'),
            'jumlah' => $chart_ab->pluck('jumlah'),
        ]);
    }

    
    public function chartKelompokTelat(Request $request)
    {
        
        $cabang = $request->input('cabang');
        $filterBy = $request->input('filter_by');
        $tahun = $request->input('tahun');
        $tampil = $request->input('tampil_berdasarkan');
        $tanggal = $request->input('tanggal');
        $chart_ab = DB::table('kelompok_bermasalah');

        // $que=$mysqli->query("SELECT YEAR(tanggal_kb) as tahun, WEEK(tanggal_kb) as bulan,DATE_SUB(tanggal_kb,INTERVAL DAYOFWEEK(tanggal_kb)-1 DAY) as bln,count(id_kb) as jumlah FROM kelompok_bermasalah WHERE kode_kb = '3A'  AND YEAR(tanggal_kb) = '$tahun' GROUP BY YEAR(tanggal_kb),WEEK(tanggal_kb) order by tanggal_kb ASC");         

        if ($filterBy == 'thn') {
            if ($tampil == 'min') {
                $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(tanggal_kb), "-", YEAR(tanggal_kb)) as bulan'), DB::raw('count(id_kb) as jumlah'));
            }else{
                $chart_ab->select(DB::raw('DATE_FORMAT(tanggal_kb, "%b-%Y") as bulan'), DB::raw('count(id_kb) as jumlah'));
            }
            $chart_ab->whereYear('tanggal_kb', '=', $tahun);
        }else{
            if ($tanggal !="") {
                $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(tanggal_kb), "-", YEAR(tanggal_kb)) as bulan'), DB::raw('count(id_kb) as jumlah'));
                $decoded_date_range = urldecode($tanggal);

                // Memisahkan tanggal menjadi dua bagian: awal dan akhir
                [$awal, $akhir] = explode(' to ', $decoded_date_range);

                // Menambahkan filter berdasarkan rentang tanggal
                $chart_ab->where('tanggal_kb', '>=', $awal)
                    ->where('tanggal_kb', '<=', $akhir);
            }
            
        }

        if ($cabang != '') {
            $chart_ab->where('cabang_kb', $cabang);
        }

        $chart_ab->where('kode_kb', '3A');
        $chart_ab->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();

        // Kembalikan data dalam format JSON
        return response()->json([
            'bulan' => $chart_ab->pluck('bulan'),
            'jumlah' => $chart_ab->pluck('jumlah'),
        ]);
    }

    
    public function chartKelompokBerat(Request $request)
    {
        
        $cabang = $request->input('cabang');
        $filterBy = $request->input('filter_by');
        $tahun = $request->input('tahun');
        $tampil = $request->input('tampil_berdasarkan');
        $tanggal = $request->input('tanggal');
        $chart_ab = DB::table('kelompok_bermasalah');

        // $que=$mysqli->query("SELECT YEAR(tanggal_kb) as tahun, WEEK(tanggal_kb) as bulan,DATE_SUB(tanggal_kb,INTERVAL DAYOFWEEK(tanggal_kb)-1 DAY) as bln,count(id_kb) as jumlah FROM kelompok_bermasalah WHERE kode_kb = '3A'  AND YEAR(tanggal_kb) = '$tahun' GROUP BY YEAR(tanggal_kb),WEEK(tanggal_kb) order by tanggal_kb ASC");         

        if ($filterBy == 'thn') {
            if ($tampil == 'min') {
                $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(tanggal_kb), "-", YEAR(tanggal_kb)) as bulan'), DB::raw('count(id_kb) as jumlah'));
            }else{
                $chart_ab->select(DB::raw('DATE_FORMAT(tanggal_kb, "%b-%Y") as bulan'), DB::raw('count(id_kb) as jumlah'));
            }
            $chart_ab->whereYear('tanggal_kb', '=', $tahun);
        }else{
            if ($tanggal !="") {
                $chart_ab->select(DB::raw('CONCAT("minggu ", WEEK(tanggal_kb), "-", YEAR(tanggal_kb)) as bulan'), DB::raw('count(id_kb) as jumlah'));
                $decoded_date_range = urldecode($tanggal);

                // Memisahkan tanggal menjadi dua bagian: awal dan akhir
                [$awal, $akhir] = explode(' to ', $decoded_date_range);

                // Menambahkan filter berdasarkan rentang tanggal
                $chart_ab->where('tanggal_kb', '>=', $awal)
                    ->where('tanggal_kb', '<=', $akhir);
            }
            
        }

        if ($cabang != '') {
            $chart_ab->where('cabang_kb', $cabang);
        }

        $chart_ab->where('kode_kb', '3B');
        $chart_ab->groupBy(DB::raw('bulan'))->orderBy(DB::raw('bulan'))->get();

        // Kembalikan data dalam format JSON
        return response()->json([
            'bulan' => $chart_ab->pluck('bulan'),
            'jumlah' => $chart_ab->pluck('jumlah'),
        ]);
    }
   
}
