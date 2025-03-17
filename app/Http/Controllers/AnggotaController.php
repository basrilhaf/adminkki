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



class AnggotaController extends Controller
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
        $menu_aktif = '/anggotaAktif||/anggota';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Anggota Aktif',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('anggota.index', $data);
    }

    public function exportAnggota()
    {
        
        // Ambil data dari database
        $data = \DB::connection('mysql_secondary')
            ->table('nasabah as B')
            ->join('kredit as C', 'C.nasabah_id', '=', 'B.nasabah_id')
            ->join('kre_kode_group1 as D', 'D.kode_group1', '=', 'C.kode_group1')
            ->select('B.nasabah_id', 'B.NAMA_NASABAH', 'D.DESKRIPSI_GROUP1', 'C.jml_pinjaman', 'B.no_id')
            ->where('C.pokok_saldo_akhir', '>', 0);

        if (Session::get('id_role2') != '2') {
            $data = $data->where('C.kode_kantor', "0".Session::get('cabang'));
        }
        $data = $data->get();

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'ID Nasabah')
              ->setCellValue('B1', 'Nama Nasabah')
              ->setCellValue('C1', 'Kelompok')
              ->setCellValue('D1', 'Jumlah Pinjaman')
              ->setCellValue('E1', 'No. KTP');

        // Isi data ke dalam spreadsheet
        $row = 2; // Mulai dari baris 2 setelah header
        foreach ($data as $user) {
            $sheet->setCellValue('A' . $row, $user->nasabah_id)
                  ->setCellValue('B' . $row, $user->NAMA_NASABAH)
                  ->setCellValue('C' . $row, $user->DESKRIPSI_GROUP1)
                  ->setCellValue('D' . $row, $user->jml_pinjaman)
                  ->setCellValue('E' . $row, $user->no_id);
            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output file Excel ke browser
        $filename = 'anggota_aktif.xlsx';
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

  
    public function masalahAnggota(): View
    {
        $menu_aktif = '/masalahAnggota||/anggota';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Masalah Anggota',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('anggota.masalah-anggota', $data);
    }

    public function getDetailMA($id_ma, Request $request)
    {
        $menu_aktif = '/masalahAnggota||/anggota';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Detail Masalah Anggota',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '',
            'id_ma' => $id_ma
        ];
        
        return view('anggota.detail-masalah-anggota', $data);
    }

    
    public function cariAnggota(): View
    {
        $menu_aktif = '/cariAnggota||/anggota';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Cari Anggota',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('anggota.cari-anggota', $data);
    }

    public function detailAnggota($nasabah_id, Request $request)
    {
        $menu_aktif = '/cariAnggota||/anggota';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Detail Anggota',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '',
            'nasabah_id' => $nasabah_id
        ];
        
        return view('anggota.detail-anggota', $data);

    }

    
    public function historyAnggota(): View
    {
        $menu_aktif = '/historyAnggota||/anggota';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'History Anggota',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('anggota.history-anggota', $data);
    }

    public function downloadAnggotaAktif(): View
    {
        $menu_aktif = '/downloadAnggotaAktif||/anggota';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Download Anggota Aktif',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('anggota.download-anggota-aktif', $data);
    }

    public function downloadAnggota(): View
    {
        $menu_aktif = '/downloadAnggota||/anggota';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Download Semua Anggota',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('anggota.download-semua-anggota', $data);
    }
    
    
    public function getSemuaAnggota(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');

            $query = DB::connection('mysql_secondary')
                ->table('tabung as A')
                ->join('nasabah as B', 'B.nasabah_id', '=', 'A.nasabah_id')
                ->join('kredit as C', 'C.nasabah_id', '=', 'B.nasabah_id')
                ->join('kre_kode_group1 as D', 'D.kode_group1', '=', 'C.kode_group1')
                ->select('B.*', 'D.DESKRIPSI_GROUP1', 'C.jml_pinjaman', 'C.jml_angsuran', 'C.periode_angsuran')
                ->where('A.kode_integrasi', 201);
            
            if (Session::get('id_role2') != '2') {
                $query->where('C.kode_kantor', "0".Session::get('cabang'));
            }
    

            if ($request->filled('kelompok')) {
                $query->where('D.DESKRIPSI_GROUP1', 'like', '%' . $request->input('kelompok') . '%');
            }
            if ($request->filled('nama')) {
                $query->where('B.NAMA_NASABAH', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('ktp')) {
                $query->where('B.no_id', 'like', '%' . $request->input('ktp') . '%');
            }

            if ($request->has('order')) {
                $orderColumn = $request->input('order.0.column'); 
                $orderDirection = $request->input('order.0.dir'); 

                $columns = [
                    'NAMA_NASABAH', // Column 1
                    'nasabah_id',   // Column 2
                    'kode_kantor',  // Column 3
                    'jml_pinjaman', // Column 4
                    'no_id'         // Column 5
                ];

                // Order by the appropriate column
                if (isset($columns[$orderColumn])) {
                    $query->orderBy($columns[$orderColumn], $orderDirection);
                }
            }

            return DataTables::of($query)
                ->addIndexColumn()  // This is for the row index numbering
                ->addColumn('action', function ($row) {
                    $infoUrl = route('user.infoUser', $row->nasabah_id);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    
    public function getHistoryMasalahAnggota(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');

            $query = DB::table('anggota_bermasalah')
                ->select('*')
                ->where('id_anggota_ab', $request->input('nasabah_id'))
                ->orderBy('tanggal_ab','DESC');
            
           

            return DataTables::of($query)
                ->addIndexColumn()  // This is for the row index numbering
                ->addColumn('action', function ($row) {
                    $infoUrl = route('user.infoUser', $row->id_anggota_ab);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    
    public function exportSemuaAnggota()
    {
        // Ambil data dari database
        $data = \DB::connection('mysql_secondary')
            ->table('tabung as A')
            ->join('nasabah as B', 'B.nasabah_id', '=', 'A.nasabah_id')
            ->join('kredit as C', 'C.nasabah_id', '=', 'B.nasabah_id')
            ->join('kre_kode_group1 as D', 'D.kode_group1', '=', 'C.kode_group1')
            ->select('B.nasabah_id', 'B.NAMA_NASABAH', 'D.DESKRIPSI_GROUP1', 'C.jml_pinjaman', 'B.no_id')
            ->where('A.kode_integrasi', 201);
            if (Session::get('id_role2') != '2') {
                $data = $data->where('C.kode_kantor', "0".Session::get('cabang'));
            }

            $data = $data->get();

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'ID Nasabah')
              ->setCellValue('B1', 'Nama Nasabah')
              ->setCellValue('C1', 'Kelompok')
              ->setCellValue('D1', 'Jumlah Pinjaman')
              ->setCellValue('E1', 'No. KTP');

        // Isi data ke dalam spreadsheet
        $row = 2; // Mulai dari baris 2 setelah header
        foreach ($data as $user) {
            $sheet->setCellValue('A' . $row, $user->nasabah_id)
                  ->setCellValue('B' . $row, $user->NAMA_NASABAH)
                  ->setCellValue('C' . $row, $user->DESKRIPSI_GROUP1)
                  ->setCellValue('D' . $row, $user->jml_pinjaman)
                  ->setCellValue('E' . $row, $user->no_id);
            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output file Excel ke browser
        $filename = 'anggota_aktif.xlsx';
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

    public function getCariAnggota(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');

            // Determine which column to search based on the 'cari' parameter
            $cari = $request->input('cari');
            $kolom = '';
            switch ($cari) {
                case '3':
                    $kolom = 'B.nasabah_id';
                    break;
                case '1':
                    $kolom = 'B.NAMA_NASABAH';
                    break;
                case '2':
                    $kolom = 'B.no_id';
                    break;
                case '4':
                    $kolom = 'D.DESKRIPSI_GROUP1';
                    break;
                default:
                    $kolom = 'B.nasabah_id'; // Default column for safety
                    break;
            }

            // Get the keyword for search
            $keyword = $request->input('keyword');

            // Start building the query
            $query = DB::connection('mysql_secondary')
                ->table('tabung as A')
                ->join('nasabah as B', 'B.nasabah_id', '=', 'A.nasabah_id')
                ->join('kredit as C', 'C.nasabah_id', '=', 'B.nasabah_id')
                ->join('kre_kode_group1 as D', 'D.kode_group1', '=', 'C.kode_group1')
                ->select('B.nasabah_id', 'B.NAMA_NASABAH', 'D.DESKRIPSI_GROUP1', 'B.no_id')
                ->where('A.kode_integrasi', 201)
                ->where($kolom, 'like', '%' . $keyword . '%'); // Apply the keyword filter

            // Additional filters
            if ($request->filled('kelompok')) {
                $query->where('D.DESKRIPSI_GROUP1', 'like', '%' . $request->input('kelompok') . '%');
            }
            if ($request->filled('nama')) {
                $query->where('B.NAMA_NASABAH', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('ktp')) {
                $query->where('B.no_id', 'like', '%' . $request->input('ktp') . '%');
            }
            $query->groupBy('B.nasabah_id', 'B.NAMA_NASABAH', 'D.DESKRIPSI_GROUP1', 'B.no_id');
            // Handle sorting
            if ($request->has('order')) {
                $orderColumn = $request->input('order.0.column');
                $orderDirection = $request->input('order.0.dir');
                
                // Define the columns that can be sorted
                $columns = [
                    0 => 'B.nasabah_id',
                    1 => 'B.NAMA_NASABAH',
                    2 => 'D.DESKRIPSI_GROUP1',
                    3 => 'B.no_id',
                    4 => 'C.jml_pinjaman'
                ];

                // Apply ordering if valid
                if (isset($columns[$orderColumn])) {
                    $query->orderBy($columns[$orderColumn], $orderDirection);
                }
            }

            // Return the result as a DataTables response
            return DataTables::of($query)
                ->addIndexColumn()  // Adds row index
                ->addColumn('action', function ($row) {
                    $infoUrl = route('detailAnggota', $row->nasabah_id);
                    return '<a href="' . $infoUrl . '" class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a>';
                })
                ->addColumn('cek_tabungan', function ($row) {
                    $cekTabunganUrl = route('cekTabunganAnggota', $row->nasabah_id);
                    return '<a href="' . $cekTabunganUrl . '" class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a>';
                })
                ->addColumn('cek_tabungan_view', function ($row) {
                    return 'Nama Anggota: '.$row->NAMA_NASABAH.'<br> ID: '.$row->nasabah_id.'<br> KLPK Terakhir: '.$row->DESKRIPSI_GROUP1.'<br>KTP: '.$row->no_id;

                })
                ->rawColumns(['action','cek_tabungan','cek_tabungan_view'])  // Allow HTML rendering in the action column
                ->make(true);  // Return the response in DataTables format
        }
    }

    public function getCekAnggota(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');

            $cari = $request->input('cari');
            $kolom = '';
            switch ($cari) {
                case '3':
                    $kolom = 'B.nasabah_id';
                    break;
                case '1':
                    $kolom = 'B.NAMA_NASABAH';
                    break;
                case '2':
                    $kolom = 'B.no_id';
                    break;
                case '4':
                    $kolom = 'D.DESKRIPSI_GROUP1';
                    break;
                default:
                    $kolom = 'B.nasabah_id'; 
                    break;
            }

            $keyword = $request->input('keyword');
            $query = DB::connection('mysql_secondary')
                ->table('tabung as A')
                ->join('nasabah as B', 'B.nasabah_id', '=', 'A.nasabah_id')
                ->join('kredit as C', 'C.nasabah_id', '=', 'B.nasabah_id')
                ->join('kre_kode_group1 as D', 'D.kode_group1', '=', 'C.kode_group1')
                ->select('B.nasabah_id', 'B.NAMA_NASABAH', 'D.DESKRIPSI_GROUP1', 'B.no_id','C.jml_pinjaman')
                ->where('A.kode_integrasi', 201)
                ->where($kolom, 'like', '%' . $keyword . '%'); // Apply the keyword filter

            // Additional filters
            if ($request->filled('kelompok')) {
                $query->where('D.DESKRIPSI_GROUP1', 'like', '%' . $request->input('kelompok') . '%');
            }
            if ($request->filled('nama')) {
                $query->where('B.NAMA_NASABAH', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('ktp')) {
                $query->where('B.no_id', 'like', '%' . $request->input('ktp') . '%');
            }
            $query->groupBy('B.nasabah_id', 'B.NAMA_NASABAH', 'D.DESKRIPSI_GROUP1', 'B.no_id','C.jml_pinjaman');
            // Handle sorting
            if ($request->has('order')) {
                $orderColumn = $request->input('order.0.column');
                $orderDirection = $request->input('order.0.dir');
                
                // Define the columns that can be sorted
                $columns = [
                    0 => 'B.nasabah_id',
                    1 => 'B.NAMA_NASABAH',
                    2 => 'D.DESKRIPSI_GROUP1',
                    3 => 'B.no_id',
                    4 => 'C.jml_pinjaman'
                ];

                // Apply ordering if valid
                if (isset($columns[$orderColumn])) {
                    $query->orderBy($columns[$orderColumn], $orderDirection);
                }
            }

            return DataTables::of($query)
                ->addIndexColumn()  // Adds row index
                ->addColumn('action', function ($row) {
                    $infoUrl = route('detailAnggota', $row->nasabah_id);
                    return '<a href="' . $infoUrl . '" class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a>';
                })
                ->addColumn('cek_tabungan', function ($row) {
                    $cekTabunganUrl = route('cekTabunganAnggota', $row->nasabah_id);
                    return '<a href="' . $cekTabunganUrl . '" class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a>';
                })
                ->addColumn('cek_tabungan_view', function ($row) {
                    return 'Nama Anggota: '.$row->NAMA_NASABAH.'<br> ID: '.$row->nasabah_id.'<br> KLPK Terakhir: '.$row->DESKRIPSI_GROUP1.'<br>KTP: '.$row->no_id;

                })
                ->addColumn('dtr', function ($row) {
                    $nasabah_id_ussi = $row->nasabah_id;
                    $nasabah_id = str_pad($nasabah_id_ussi, 5, '0', STR_PAD_LEFT);
                    $kelompok = $row->DESKRIPSI_GROUP1;
                    // var_dump($nasabah_id,$kelompok);die();


                    $data_dtr = DB::table('anggota_bermasalah')
                    ->select(
                        'kelompok_ab',
                        'id_anggota_ab',
                        DB::raw('COUNT(id_ab) AS jumlah'),
                        DB::raw('SUM(IF( kode_ab = "2", 1, 0)) AS kode2'),
                        DB::raw('SUM(IF( kode_ab = "4A", 1, 0)) AS kode4a'),
                        DB::raw('SUM(IF( kode_ab = "4B", 1, 0)) AS kode4b')
                    )
                    ->where('kelompok_ab', $kelompok)
                    ->where('id_anggota_ab', $nasabah_id)
                    ->groupBy('kelompok_ab', 'id_anggota_ab')
                    ->first();

                
                // return 'DTR 2: '.$data_dtr->kode2.'<br> DTR 4A: '.$data_dtr->kode4a.'<br> DTR 4B: '.$data_dtr->kode4b;
                if ($data_dtr) {
                    return 'DTR : ' . $data_dtr->kode2 + $data_dtr->kode4a + $data_dtr->kode4b;
                } else {
                    // Jika tidak ada data, tampilkan pesan default atau nilai 0
                    return 'DTR : 0';
                }

                })

                ->rawColumns(['action','cek_tabungan','cek_tabungan_view','dtr'])  // Allow HTML rendering in the action column
                ->make(true);  // Return the response in DataTables format
        }
    }

    
    public function getCekKtp(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');

            // Initialize the query
            $query = DB::connection('mysql_secondary')
                ->table('nasabah as B')
                ->select('B.nasabah_id', 'B.NAMA_NASABAH', 'B.no_id')
                ->where(function($query) use ($request) {
                    // Apply 'orWhere' for each ktp field if it's filled
                    if ($request->filled('ktp1')) {
                        $query->orWhere('B.no_id', $request->input('ktp1'));
                    }
                    if ($request->filled('ktp2')) {
                        $query->orWhere('B.no_id', $request->input('ktp2'));
                    }
                    if ($request->filled('ktp3')) {
                        $query->orWhere('B.no_id', $request->input('ktp3'));
                    }
                    if ($request->filled('ktp4')) {
                        $query->orWhere('B.no_id', $request->input('ktp4'));
                    }
                    if ($request->filled('ktp5')) {
                        $query->orWhere('B.no_id', $request->input('ktp5'));
                    }
                    if ($request->filled('ktp6')) {
                        $query->orWhere('B.no_id', $request->input('ktp6'));
                    }
                    if ($request->filled('ktp7')) {
                        $query->orWhere('B.no_id', $request->input('ktp7'));
                    }
                    if ($request->filled('ktp8')) {
                        $query->orWhere('B.no_id', $request->input('ktp8'));
                    }
                    if ($request->filled('ktp9')) {
                        $query->orWhere('B.no_id', $request->input('ktp9'));
                    }
                    if ($request->filled('ktp10')) {
                        $query->orWhere('B.no_id', $request->input('ktp10'));
                    }
                    if ($request->filled('ktp11')) {
                        $query->orWhere('B.no_id', $request->input('ktp11'));
                    }
                });

            // Apply dynamic ordering
            if ($request->filled('ktp1')) {
                $query->orderByRaw('FIELD(B.no_id, ?) DESC', [$request->input('ktp1')]);
            }
            if ($request->filled('ktp2')) {
                $query->orderByRaw('FIELD(B.no_id, ?) DESC', [$request->input('ktp2')]);
            }
            if ($request->filled('ktp3')) {
                $query->orderByRaw('FIELD(B.no_id, ?) DESC', [$request->input('ktp3')]);
            }
            if ($request->filled('ktp4')) {
                $query->orderByRaw('FIELD(B.no_id, ?) DESC', [$request->input('ktp4')]);
            }
            if ($request->filled('ktp5')) {
                $query->orderByRaw('FIELD(B.no_id, ?) DESC', [$request->input('ktp5')]);
            }
            if ($request->filled('ktp6')) {
                $query->orderByRaw('FIELD(B.no_id, ?) DESC', [$request->input('ktp6')]);
            }
            if ($request->filled('ktp7')) {
                $query->orderByRaw('FIELD(B.no_id, ?) DESC', [$request->input('ktp7')]);
            }
            if ($request->filled('ktp8')) {
                $query->orderByRaw('FIELD(B.no_id, ?) DESC', [$request->input('ktp8')]);
            }
            if ($request->filled('ktp9')) {
                $query->orderByRaw('FIELD(B.no_id, ?) DESC', [$request->input('ktp9')]);
            }
            if ($request->filled('ktp10')) {
                $query->orderByRaw('FIELD(B.no_id, ?) DESC', [$request->input('ktp10')]);
            }
            if ($request->filled('ktp11')) {
                $query->orderByRaw('FIELD(B.no_id, ?) DESC', [$request->input('ktp11')]);
            }

            // Execute the query
            $data = $query->get();

            // Ensure all ktp values are displayed, even if not found in the database
            $ktp_values = [
                $request->input('ktp1'),
                $request->input('ktp2'),
                $request->input('ktp3'),
                $request->input('ktp4'),
                $request->input('ktp5'),
                $request->input('ktp6'),
                $request->input('ktp7'),
                $request->input('ktp8'),
                $request->input('ktp9'),
                $request->input('ktp10'),
                $request->input('ktp11'),
            ];

            // Merge the ktp values with the query results
            foreach ($ktp_values as $ktp) {
                if (!$data->contains('no_id', $ktp)) {
                    $data->push((object)[
                        'no_id' => $ktp,
                        'NAMA_NASABAH' => '',
                        'nasabah_id' => null
                    ]);
                }
            }

            // Return DataTable response
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // Only show the action button if the ktp is found (nasabah_id exists)
                    if (isset($row->nasabah_id) && $row->nasabah_id !== null) {
                        $infoUrl = route('detailAnggota', $row->nasabah_id);
                        return '<a href="' . $infoUrl . '" class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a>';
                    }
                    return '';  // Return empty if no action button should be shown
                })
                ->addColumn('kelompok', function ($row) {
                    $nasabah_id = $row->nasabah_id;

                    if (!$nasabah_id) {
                        // If nasabah_id doesn't exist (ktp not found), display a message
                        return '';
                    }

                    $data_kelompok = DB::connection('mysql_secondary')
                        ->table('kredit as A')
                        ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'A.kode_group1')
                        ->select('B.DESKRIPSI_GROUP1', 'A.jml_pinjaman', 'A.tgl_jatuh_tempo')
                        ->where('A.nasabah_id', $nasabah_id)
                        ->orderBy('A.tgl_realisasi', 'desc')
                        ->limit(1)
                        ->first();

                    if ($data_kelompok) {
                        // Determine the status based on the tgl_jatuh_tempo
                        $status = ($data_kelompok->tgl_jatuh_tempo >= date('Y-m-d')) ? 'Aktif' : 'Tidak Aktif';
                        $class = ($status == 'Aktif') ? 'text-success' : 'text-danger';

                        return '<p class="' . $class . '">Nama: ' . $data_kelompok->DESKRIPSI_GROUP1 . '<br> Pinjaman: ' . $data_kelompok->jml_pinjaman . '<br> Status: ' . $status . '</p>';
                    } else {
                        return '<p class="text-danger">Kelompok Tidak Ditemukan</p>';
                    }
                })
                ->addColumn('dtr', function ($row) {
                    if (isset($row->nasabah_id) && $row->nasabah_id !== null) {
                        $nasabah_id_ussi = $row->nasabah_id;
                        $nasabah_id = str_pad($nasabah_id_ussi, 5, '0', STR_PAD_LEFT);

                        $data_dtr = DB::table('anggota_bermasalah')
                            ->select(
                                'kelompok_ab',
                                'id_anggota_ab',
                                DB::raw('COUNT(id_ab) AS jumlah'),
                                DB::raw('SUM(IF( kode_ab = "2", 1, 0)) AS kode2'),
                                DB::raw('SUM(IF( kode_ab = "4A", 1, 0)) AS kode4a'),
                                DB::raw('SUM(IF( kode_ab = "4B", 1, 0)) AS kode4b')
                            )
                            ->where('id_anggota_ab', $nasabah_id)
                            ->groupBy('kelompok_ab', 'id_anggota_ab')
                            ->first();

                        if ($data_dtr) {
                            return 'DTR 2: ' . $data_dtr->kode2 . '<br> DTR 4A: ' . $data_dtr->kode4a . '<br> DTR 4B: ' . $data_dtr->kode4b;
                        } else {
                            return 'DTR 2: 0<br> DTR 4A: 0<br> DTR 4B: 0';
                        }
                    }
                    return '<p class="text-danger">KTP Tidak Ditemukan</p>'; 

                    
                })
                ->addColumn('sanksi', function ($row) {
                    if (isset($row->nasabah_id) && $row->nasabah_id !== null) {
                        $ktp = $row->no_id;
                        $nasabah_id_ussi = $row->nasabah_id;
                        $nasabah_id = str_pad($nasabah_id_ussi, 5, '0', STR_PAD_LEFT);

                        $data_skorsing = DB::table('skorsing')
                            ->select('*')
                            ->where('ktp_sk', $ktp)
                            ->where('selesai_sk', '>=', date('Y-m-d'))
                            ->first();

                        $data_blacklist = DB::table('blacklist')
                            ->select('*')
                            ->where('id_anggota_bl', $row->nasabah_id)
                            ->first();

                        if ($data_skorsing && $data_blacklist) {
                            return '<span class="badge badge-danger">Skorsing & Blacklist</span>';

                        } else if (!$data_skorsing && $data_blacklist) {
                            return '<span class="badge badge-danger">Blacklist</span>';
                        } else if ($data_skorsing && !$data_blacklist) {
                            return '<span class="badge badge-warning">Skorsing</span>';
                        } else {
                            return '<span class="badge badge-success">-</span>';
                        }
                    }
                    return ''; 

                    
                })
                ->rawColumns(['action', 'kelompok', 'dtr', 'sanksi'])  // Allow HTML rendering in the action column
                ->make(true);
        }
    }


    public function getAnggotaAktif(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');

            $query = DB::connection('mysql_secondary')
                ->table('nasabah as B')
                ->join('kredit as C', 'C.nasabah_id', '=', 'B.nasabah_id')
                ->join('kre_kode_group1 as D', 'D.kode_group1', '=', 'C.kode_group1')
                ->select('B.*', 'D.DESKRIPSI_GROUP1', 'C.jml_pinjaman', 'C.jml_angsuran', 'C.periode_angsuran')
                ->where('C.pokok_saldo_akhir', '>', 0);

            if (Session::get('id_role2') != '2') {
                $query = $query->where('C.kode_kantor', "0".Session::get('cabang'));
            }
    

            if ($request->filled('kelompok')) {
                $query->where('D.DESKRIPSI_GROUP1', 'like', '%' . $request->input('kelompok') . '%');
            }
            if ($request->filled('nama')) {
                $query->where('B.NAMA_NASABAH', 'like', '%' . $request->input('nama') . '%');
            }
            if ($request->filled('ktp')) {
                $query->where('B.no_id', 'like', '%' . $request->input('ktp') . '%');
            }

            if ($request->has('order')) {
                $orderColumn = $request->input('order.0.column'); 
                $orderDirection = $request->input('order.0.dir'); 

                $columns = [
                    'NAMA_NASABAH', // Column 1
                    'nasabah_id',   // Column 2
                    'kode_kantor',  // Column 3
                    'jml_pinjaman', // Column 4
                    'no_id'         // Column 5
                ];

                // Order by the appropriate column
                if (isset($columns[$orderColumn])) {
                    $query->orderBy($columns[$orderColumn], $orderDirection);
                }
            }

            return DataTables::of($query)
                ->addIndexColumn()  // This is for the row index numbering
                ->addColumn('action', function ($row) {
                    $infoUrl = route('user.infoUser', $row->nasabah_id);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    
    public function getHistoryAnggota(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');

            $query = DB::connection('mysql_secondary')
                ->table('kredit as A')
                ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'A.kode_group1')
                ->select('A.*', 'B.deskripsi_group1')
                ->where('A.nasabah_id', $request->input('nasabah_id'));

            $query->orderBy('A.tgl_realisasi', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()  // This is for the row index numbering
                ->addColumn('action', function ($row) {
                    $infoUrl = route('user.infoUser', $row->nasabah_id);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
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
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function exportDownloadHistoryAnggota(Request $request)
    {
        $nasabah_id = $request->input('nasabah_id');
        $data = DB::connection('mysql_secondary')
                ->table('kredit as A')
                ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'A.kode_group1')
                ->select('A.*', 'B.deskripsi_group1')
                ->where('A.nasabah_id', $request->input('nasabah_id'))
                ->orderBy('A.tgl_realisasi', 'asc')
                ->get();

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // Set header kolom
        $sheet->setCellValue('A1', 'Nama Kelompok')
              ->setCellValue('B1', 'Jumlah Pinjaman')
              ->setCellValue('C1', 'Tanggal Cair')
              ->setCellValue('D1', 'Periode')
              ->setCellValue('E1', 'Status');

              
        $row = 2; // Mulai dari baris 2 setelah header
        foreach ($data as $user) {
            if($user->tgl_jatuh_tempo >= date('Y-m-d')){
                $status = 'Aktif';
            }else{
                $status = 'Tidak Aktif';
            }
            $sheet->setCellValue('A' . $row, $user->deskripsi_group1)
                  ->setCellValue('B' . $row, $user->jml_pinjaman)
                  ->setCellValue('C' . $row, $user->tgl_realisasi)
                  ->setCellValue('D' . $row, $user->jml_angsuran)
                  ->setCellValue('E' . $row, $status);

                  
            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output file Excel ke browser
        $filename = 'history_anggota.xlsx';
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

    public function getDetailAnggota($nasabah_id)
    {
        $data = DB::connection('mysql_secondary')
            ->table('nasabah as A')
            ->join('kredit as C', 'C.nasabah_id', '=', 'A.nasabah_id')
            ->join('kre_kode_group1 as B', 'B.kode_group1', '=', 'C.kode_group1')
            ->select('A.*', 'B.deskripsi_group1','C.jml_pinjaman','C.tgl_realisasi')
            ->where('A.nasabah_id', $nasabah_id)
            ->orderBy('C.tgl_realisasi', 'desc')
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }


        return response()->json($data);
    }

    public function getCekAnggotaValue(Request $request)
    {
        $validated = $request->validate([
            'id_anggota' => 'required|string'
        ]);

        $anggotaDetails = DB::connection('mysql_secondary')
            ->table('nasabah as A')
            ->select(
                'C.deskripsi_group1',
                'A.nasabah_id',
                'A.NAMA_NASABAH',
                'B.tgl_realisasi'
            )
            ->join('kredit as B', 'B.nasabah_id', '=', 'A.nasabah_id')
            ->join('kre_kode_group1 as C', 'B.kode_group1', '=', 'C.kode_group1')
            ->where('A.nasabah_id', $request->id_anggota)
            ->orderBy('B.tgl_realisasi', 'desc')
            ->first();  // Assign the result to $kelompokList here

        if ($anggotaDetails) {
            return response()->json([
                'success' => true,
                'data' => $anggotaDetails
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }


    public function addMasalahAnggotaAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'id_anggota' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        
        $save = DB::table('anggota_bermasalah')->insert([
            'nama_ab'        => $request->nama,
            'cabang_ab'  => $request->cabang,
            'kelompok_ab' => $request->kelompok,
            'tanggal_cair_ab' => $request->tgl_cair,
            'id_anggota_ab'        => $request->id_anggota,
            'setoran_ab'  => $request->setoran_ke,
            'tanggal_ab'  => $request->tanggal,
            'kode_ab' => $request->kode,
            'menit_ab'        => $request->menit,
            'pkp_ab'  => $request->pkp
        ]);
        // var_dump($save);die();
        if($save){
            $this->dataService->createAuditTrail('Tambah Masalah Anggota');
            return response()->json(['success' => true, 'message' => 'Berhasil Menambahkan Masalah Anggota', 'icon' => 'success']);
        }else{
            return response()->json(['success' => false, 'message' => 'Gagal Menambahkan Masalah Anggota', 'icon' => 'warning']);
        }
       
        
    }
    
    public function getMasalahAnggota(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');
            $query = DB::table('anggota_bermasalah')
                ->select(
                    'nama_ab',
                    'kelompok_ab',
                    'tanggal_cair_ab',
                    'id_anggota_ab',
                    'cabang_ab',
                    'id_sikki_ab',
                    DB::raw('COUNT(id_ab) AS jumlah'),
                    DB::raw('SUM(IF( kode_ab = "2", 1, 0)) AS kode2'),
                    DB::raw('SUM(IF( kode_ab = "4A", 1, 0)) AS kode4a'),
                    DB::raw('SUM(IF( kode_ab = "4B", 1, 0)) AS kode4b')
                );

            

            if (Session::get('id_role2') != '2') {
                $query->where('cabang_ab', Session::get('cabang'));
            }


            // Applying filters conditionally
            if ($request->filled('kelompok')) {
                $query->where('kelompok_ab', 'like', '%' . $request->input('kelompok') . '%');
            }
            if ($request->filled('anggota')) {
                $query->where('nama_ab', 'like', '%' . $request->input('anggota') . '%');
            }
          

            // Grouping by idsikkikb and ordering by id_kb
            $filteredData = $query->groupBy('nama_ab', 'kelompok_ab', 'id_anggota_ab','tanggal_cair_ab', 'id_sikki_ab', 'cabang_ab')
                ->orderBy('id_sikki_ab', 'desc')
                ->get();
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $param = $row->id_anggota_ab."~".$row->id_sikki_ab;
                    $infoUrl = route('getDetailMA', $param);
                    
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    $btn .= '<button title="HAPUS" class="btn btn-danger btn-delete-ma btn-sm" data-id="' . $row->id_anggota_ab . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    
    public function getDetailMasalahAnggota(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');
            // dd($request->input('id_ma'));
            $p_param = explode("~",$request->input('id_ma'));
            $query = DB::table('anggota_bermasalah as A')
                ->leftJoin('pkp as B', 'B.id', '=', 'A.pkp_ab')
                ->select(
                    'A.*',
                    DB::raw('COALESCE(B.nama, A.pkp_nama_ab) as nama')
                )
                ->where('id_sikki_ab', $p_param[1])
                ->where('id_anggota_ab', $p_param[0]);

            
            $filteredData = $query->orderBy('A.id_ab', 'desc')
                ->get();
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {                    
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-detail-ma btn-sm" data-id="' . $row->id_ab . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function deleteDetailMaAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_ab' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $deleted = DB::table('anggota_bermasalah')->where('id_ab', $request->id_ab)->delete();

        $this->dataService->createAuditTrail('Hapus Masalah Anggota');

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus masalah anggota']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus masalah anggota']);
        }
    }

    public function deleteMaAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_anggota_ab' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $deleted = DB::table('anggota_bermasalah')->where('id_anggota_ab', $request->id_anggota_ab)->delete();

        $this->dataService->createAuditTrail('Hapus Masalah Anggota');

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus masalah anggota']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus masalah anggota']);
        }
    }

    
    
    public function exportRangkumanAb()
    {
        $data = DB::table('anggota_bermasalah as A')
            ->join('cabang as B', 'B.id', '=', 'A.cabang_ab')
            ->select(
                'A.nama_ab',
                'A.kelompok_ab',
                'A.tanggal_cair_ab',
                'A.id_anggota_ab',
                'B.nama',
                'A.id_sikki_ab',
                DB::raw('COUNT(A.id_ab) AS jumlah'),
                DB::raw('SUM(IF( A.kode_ab = "2", 1, 0)) AS kode2'),
                DB::raw('SUM(IF( A.kode_ab = "4A", 1, 0)) AS kode4a'),
                DB::raw('SUM(IF( A.kode_ab = "4B", 1, 0)) AS kode4b')
            );

        if (Session::get('id_role2') != '2') {
            $data = $data->where('A.cabang_ab', Session::get('cabang'));
        }

        $data = $data->groupBy('A.nama_ab', 'A.kelompok_ab', 'A.id_anggota_ab', 'A.id_sikki_ab', 'B.nama','A.tanggal_cair_ab')
            ->orderBy('id_sikki_ab', 'desc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'ID Anggota')
              ->setCellValue('B1', 'Nama Anggota')
              ->setCellValue('C1', 'Kelompok')
              ->setCellValue('D1', 'Cabang')
              ->setCellValue('E1', 'Jumlah Bermasalah')
              ->setCellValue('F1', 'Kasus 2')
              ->setCellValue('G1', 'Kasus 4A')
              ->setCellValue('H1', 'Kasus 4B')
              ->setCellValue('I1', 'Tanggal Cair');

        $row = 2; // Mulai dari baris 2 setelah header
        foreach ($data as $user) {

            $sheet->setCellValue('A' . $row, $user->id_anggota_ab)
                  ->setCellValue('B' . $row, $user->nama_ab)
                  ->setCellValue('C' . $row, $user->kelompok_ab)
                  ->setCellValue('D' . $row, $user->nama)
                  ->setCellValue('E' . $row, $user->jumlah)
                  ->setCellValue('F' . $row, $user->kode2)
                  ->setCellValue('G' . $row, $user->kode4a)
                  ->setCellValue('H' . $row, $user->kode4b)
                  ->setCellValue('I' . $row, $user->tanggal_cair_ab);
            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output file Excel ke browser
        $filename = 'Rangkuman_anggota_bermasalah.xlsx';
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

    
    public function exportHistoryAb()
    {
        ini_set('memory_limit', '512M');   
        $data = DB::table('anggota_bermasalah as A')
            ->join('cabang as B', 'B.id', '=', 'A.cabang_ab')
            ->join('pkp as C', 'C.id', '=', 'A.pkp_ab')
            ->select(
                'A.*',
                'B.nama as nama_cabang',
                'C.nama as nama_pkp'
            );
            if (Session::get('id_role2') != '2') {
                $data = $data->where('A.cabang_ab', Session::get('cabang'));
            }

        $data = $data->orderBy('id_sikki_ab', 'desc')
            ->get();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'Nama Anggota')
              ->setCellValue('B1', 'ID Anggota')
              ->setCellValue('C1', 'Kelompok')
              ->setCellValue('D1', 'Tanggal Bermasalah')
              ->setCellValue('E1', 'Setoran Ke')
              ->setCellValue('F1', 'Kode')
              ->setCellValue('G1', 'Cabang')
              ->setCellValue('H1', 'PKP FSK')
              ->setCellValue('I1', 'Tanggal Cair');

        $row = 2; 
        
        foreach ($data as $user) {

            $sheet->setCellValue('A' . $row, $user->nama_ab)
                  ->setCellValue('B' . $row, $user->id_anggota_ab)
                  ->setCellValue('C' . $row, $user->kelompok_ab)
                  ->setCellValue('D' . $row, $user->tanggal_ab)
                  ->setCellValue('E' . $row, $user->setoran_ab)
                  ->setCellValue('F' . $row, $user->kode_ab)
                  ->setCellValue('G' . $row, $user->nama_cabang)
                  ->setCellValue('H' . $row, $user->nama_pkp)
                  ->setCellValue('I' . $row, $user->tanggal_cair_ab);
            $row++;
        }
        // dd($data);
        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output file Excel ke browser
        $filename = 'History_anggota_bermasalah.xlsx';
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
