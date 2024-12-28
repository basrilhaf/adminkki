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
            ->table('tabung as A')
            ->join('nasabah as B', 'B.nasabah_id', '=', 'A.nasabah_id')
            ->join('kredit as C', 'C.nasabah_id', '=', 'B.nasabah_id')
            ->join('kre_kode_group1 as D', 'D.kode_group1', '=', 'C.kode_group1')
            ->select('B.nasabah_id', 'B.NAMA_NASABAH', 'D.DESKRIPSI_GROUP1', 'C.jml_pinjaman', 'B.no_id')
            ->where('A.kode_integrasi', 201)
            ->where('A.saldo_akhir', '>=', 10000)
            ->get();

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
                ->select('B.nasabah_id', 'B.NAMA_NASABAH', 'D.DESKRIPSI_GROUP1', 'C.jml_pinjaman', 'B.no_id')
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
                    // Define the URL for the action buttons
                    $infoUrl = route('user.infoUser', $row->nasabah_id);
                    // Return a button with the URL
                    return '<a href="' . $infoUrl . '" class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a>';
                })
                ->rawColumns(['action'])  // Allow HTML rendering in the action column
                ->make(true);  // Return the response in DataTables format
        }
    }
    
    public function getAnggotaAktif(Request $request)
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
                ->where('A.kode_integrasi', 201)
                ->where('A.saldo_akhir', '>=', 10000);

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
    
    public function getMasalahAnggota(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');
            $query = DB::table('anggota_bermasalah')
                ->select(
                    'nama_ab',
                    'kelompok_ab',
                    'id_anggota_ab',
                    'cabang_ab',
                    'id_sikki_ab',
                    DB::raw('COUNT(id_ab) AS jumlah'),
                    DB::raw('SUM(IF( kode_ab = "2", 1, 0)) AS kode2'),
                    DB::raw('SUM(IF( kode_ab = "4A", 1, 0)) AS kode4a'),
                    DB::raw('SUM(IF( kode_ab = "4B", 1, 0)) AS kode4b')
                );

            if(Session::get('is_kc') == "1"){
                $query->where('cabang_ab', $cabang);
            }else if(Session::get('is_kc') == "0"){
                $query->where('pkp_ab', $id_user);
            }else{
                if(Session::get('cabang') == "0"){
                }else{
                    $query->where('cabang_ab', $cabang);
                }
            }

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
            $filteredData = $query->groupBy('nama_ab', 'kelompok_ab', 'id_anggota_ab', 'id_sikki_ab', 'cabang_ab')
                ->orderBy('id_sikki_ab', 'desc')
                ->get();
            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id_hash = Crypt::encrypt($row->kelompok_ab);

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
