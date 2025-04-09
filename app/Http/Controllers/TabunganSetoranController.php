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




class TabunganSetoranController extends Controller
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
        $menu_aktif = '/tabunganLapangan||/tabunganSetoran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Tabungan Lapangan',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('tabungan_setoran.index', $data);
    }

    public function getTableTabLapangan(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');
            $date_range = $request->input('daterange');

            $p_date = explode("to", $date_range);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::connection('mysql_secondary')
                ->table('tabtrans as A')
                ->join('tabung as B', function($join) {
                    $join->on('B.no_rekening', '=', 'A.NO_REKENING')
                         ->on('B.kode_integrasi', '=', DB::raw('203'));
                })
                ->join('nasabah as C', 'B.nasabah_id', '=', 'C.nasabah_id')
                ->join('kre_kode_group1 as D', 'A.kode_group1_trans', '=', 'D.kode_group1')
                ->select('A.*', 'C.NAMA_NASABAH','C.nasabah_id','B.saldo_akhir','D.deskripsi_group1')
                ->where('A.KODE_TRANS', 113)
                ->where('A.TGL_TRANS', '>=', $awal)
                ->where('A.TGL_TRANS', '<=', $akhir);

                $query->orderBy('A.TGL_TRANS', 'asc');
                // ->orderBy('A.TGL_TRANS', 'asc');

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

    
    public function exportDownloadTabunganLapangan(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $daterange = $request->input('daterange');
        $p_date = explode("to", $daterange);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date
        $data = DB::connection('mysql_secondary')
                ->table('tabtrans as A')
                ->join('tabung as B', function($join) {
                    $join->on('B.no_rekening', '=', 'A.NO_REKENING')
                        ->on('B.kode_integrasi', '=', DB::raw('203'));
                })
                ->join('nasabah as C', 'B.nasabah_id', '=', 'C.nasabah_id')
                ->join('kre_kode_group1 as D', 'A.kode_group1_trans', '=', 'D.kode_group1')
                ->select('A.*', 'C.NAMA_NASABAH','C.nasabah_id','B.saldo_akhir','D.deskripsi_group1')
                ->where('A.KODE_TRANS', 113)
                ->where('A.TGL_TRANS', '>=', $awal)
                ->where('A.TGL_TRANS', '<=', $akhir)
                ->orderBy('A.TGL_TRANS', 'asc')
                ->get();

                

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // Set header kolom
        $sheet->setCellValue('A1', 'ID Anggota')
              ->setCellValue('B1', 'Nama Anggota')
              ->setCellValue('C1', 'Amount')
              ->setCellValue('D1', 'Kelompok')
              ->setCellValue('E1', 'Created At')
              ->setCellValue('F1', 'Total Tabungan');

              
        $row = 2; // Mulai dari baris 2 setelah header
        foreach ($data as $user) {
            
            $sheet->setCellValue('A' . $row, $user->nasabah_id)
                  ->setCellValue('B' . $row, $user->NAMA_NASABAH)
                  ->setCellValue('C' . $row, $user->POKOK)
                  ->setCellValue('D' . $row, $user->deskripsi_group1)
                  ->setCellValue('E' . $row, $user->jam_trans)
                  ->setCellValue('F' . $row, $user->saldo_akhir);

                  
                  
            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output file Excel ke browser
        $filename = 'Tabungan_lapangan.xlsx';
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



    public function tabunganKantor(): View
    {
        $menu_aktif = '/tabunganKantor||/tabunganSetoran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Tabungan Kantor',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('tabungan_setoran.tabungan-kantor', $data);
    }


    
    public function getTableTabKantor(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');
            $date_range = $request->input('daterange');

            $p_date = explode("to", $date_range);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $tipe = $request->input('tipe');
            $kode = $request->input('kode');

            $query = DB::connection('mysql_secondary')
                ->table('tabtrans as A')
                ->join('tabung as B', function($join) {
                    $join->on('B.no_rekening', '=', 'A.NO_REKENING')
                         ->on('B.kode_integrasi', '=', DB::raw('203'));
                })
                ->join('nasabah as C', 'B.nasabah_id', '=', 'C.nasabah_id')
                ->join('kre_kode_group1 as D', 'A.kode_group1_trans', '=', 'D.kode_group1')
                ->select('A.*', 'C.NAMA_NASABAH','C.nasabah_id','B.saldo_akhir','D.deskripsi_group1')
                ->where('A.TGL_TRANS', '>=', $awal)
                ->where('A.TGL_TRANS', '<=', $akhir);

                if ($tipe == 200) {
                    // Mengambil data dengan MY_KODE_TRANS = 200
                    
                    if ($kode != 0) {
                        $query->where('A.KODE_TRANS', $kode);
                    } else {
                        $query->whereIn('A.KODE_TRANS', ['200', '201', '203']);
                    }
                
                } elseif ($tipe == 100) {
                    // Menambah data dengan KODE_TRANS = 100
                    $query->where('A.KODE_TRANS', 100);
                
                } else {
                    $query->whereIn('A.KODE_TRANS', ['200', '201', '203','100']);
                    // Menambah dan Mengambil dengan grup kondisi yang benar
                    
                }

                $query->orderBy('A.TGL_TRANS', 'asc');
                // ->orderBy('A.TGL_TRANS', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()  // This is for the row index numbering
                ->addColumn('action', function ($row) {
                    $infoUrl = route('user.infoUser', $row->nasabah_id);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->addColumn('tipe_trans', function ($row) {
                    if($row->MY_KODE_TRANS == 200){
                        $tipe_trans = 'Tarik (200)';
                    }else{
                        $tipe_trans = 'Tambah (100)';
                    }

                    return $tipe_trans;
                })
                
                ->rawColumns(['action','tipe_trans'])
                ->make(true);
        }
    }

    public function exportDownloadTabunganKantor(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);
        
        $daterange = $request->input('daterange');
        $p_date = explode("to", $daterange);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date
        $tipe = $request->input('tipe');
        $kode = $request->input('kode');

        $data = DB::connection('mysql_secondary')
            ->table('tabtrans as A')
            ->join('tabung as B', function($join) {
                $join->on('B.no_rekening', '=', 'A.NO_REKENING')
                    ->on('B.kode_integrasi', '=', DB::raw('203'));
            })
            ->join('nasabah as C', 'B.nasabah_id', '=', 'C.nasabah_id')
            ->join('kre_kode_group1 as D', 'A.kode_group1_trans', '=', 'D.kode_group1')
            ->select('A.*', 'C.NAMA_NASABAH', 'C.nasabah_id', 'B.saldo_akhir', 'D.deskripsi_group1')
            ->where('A.TGL_TRANS', '>=', $awal)
            ->where('A.TGL_TRANS', '<=', $akhir);

            if ($tipe == 200) {
                // mengambil 
                if ($kode != 0) {
                    $data->where('A.KODE_TRANS', $kode);
                }else{
                    $data->whereIn('A.KODE_TRANS', ['200','201','203']);
                }

            }else if($tipe == 100){
                // mengambil 
                $data->where('A.KODE_TRANS', 100);
            }else{
                // menambah dan mengambil
                $data->whereIn('A.KODE_TRANS', ['100','200','201','203']);
            }

       

        // Execute the query and get the results
        $data = $data->orderBy('A.TGL_TRANS', 'asc')->get();

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header columns
        $sheet->setCellValue('A1', 'TGL_TRANS')
            ->setCellValue('B1', 'JAM_TRANS')
            ->setCellValue('C1', 'TRANS_ID_SOURCE')
            ->setCellValue('D1', 'KETERANGAN')
            ->setCellValue('E1', 'AMOUNT')
            ->setCellValue('F1', 'KODE')
            ->setCellValue('G1', 'DIRECTION')
            ->setCellValue('H1', 'ID ANGGOTA')
            ->setCellValue('I1', 'NAMA ANGGOTA')
            ->setCellValue('J1', 'TOTAL TABUNGAN');

        $row = 2; // Start from row 2 after the header
        foreach ($data as $user) {
            // Check the transaction type
            if ($user->MY_KODE_TRANS == 200) {
                $tipe_trans = 'Tarik (200)';
            } else {
                $tipe_trans = 'Tambah (100)';
            }

            // Write data to the spreadsheet
            $sheet->setCellValue('A' . $row, $user->TGL_TRANS)
                ->setCellValue('B' . $row, $user->jam_trans ?? '')
                ->setCellValue('C' . $row, $user->TRANS_ID_SOURCE ?? '')
                ->setCellValue('D' . $row, $user->KETERANGAN ?? '')
                ->setCellValue('E' . $row, $user->POKOK ?? '')
                ->setCellValue('F' . $row, $user->KODE_TRANS ?? '')
                ->setCellValue('G' . $row, $tipe_trans)
                ->setCellValue('H' . $row, $user->nasabah_id)
                ->setCellValue('I' . $row, $user->NAMA_NASABAH)
                ->setCellValue('J' . $row, $user->saldo_akhir);

            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output Excel file to the browser
        $filename = 'Tabungan_kantor.xlsx';
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

    
    public function setoranTabungan(): View
    {
        $menu_aktif = '/setoranTabungan||/tabunganSetoran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Setoran & Tabungan',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('tabungan_setoran.setoran-tabungan', $data);
    }
    
    public function getTableSetTab(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');
            $date_range = $request->input('daterange');

            $p_date = explode("to", $date_range);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::connection('mysql_secondary')
                ->table('kretrans as A')
                ->join('kredit as B', 'B.no_rekening', '=', 'A.NO_REKENING')
                ->join('nasabah as C', 'B.nasabah_id', '=', 'C.nasabah_id')
                ->join('app_kode_kantor as D', 'D.KODE_KANTOR', '=', 'C.kode_kantor')
                ->join('kre_kode_group1 as E', 'E.kode_group1', '=', 'B.kode_group1')
                ->join('tabung as F', function($join) {
                    $join->on('F.nasabah_id', '=', 'C.nasabah_id')
                         ->on('F.kode_integrasi', '=', DB::raw('203'));
                })
                ->select('A.*', 'C.nasabah_id','C.NAMA_NASABAH','D.NAMA_KANTOR','E.deskripsi_group1','B.jml_angsuran', 'B.tgl_realisasi','B.tgl_jatuh_tempo','F.saldo_akhir')
                ->where('A.KODE_TRANS', 300)
                ->where('A.TGL_TRANS', '>=', $awal)
                ->where('A.TGL_TRANS', '<=', $akhir);

                $query->orderBy('A.TGL_TRANS', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()  // This is for the row index numbering
                ->addColumn('action', function ($row) {
                    $infoUrl = route('user.infoUser', $row->nasabah_id);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->addColumn('date_trans', function ($row) {
                    $tgl_trans = $row->TGL_TRANS;
                    $timestamp = strtotime($tgl_trans);
                    $hari_english = date('l', $timestamp);
                    $hari_indonesia = [
                        'Sunday' => 'Minggu',
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa',
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu'
                    ];

                    $hari = $hari_indonesia[$hari_english];

                    return 'Tanggal: '.$row->TGL_TRANS.'<br> Hari: '.$hari;
                })
                ->addColumn('data_kelompok', function ($row) {
                    return 'Nama : '.$row->deskripsi_group1.'<br> Durasi: '.$row->jml_angsuran.'<br> Tgl Cair: '.$row->tgl_realisasi.'<br> Tgl BTAB: '.$row->tgl_jatuh_tempo;
                })
                ->addColumn('data_setoran', function ($row) {
                    return 'Setoran Ke-: '.$row->ANGSURAN_KE.'<br> Pokok: '.$row->POKOK.'<br> Bagi Hasil: '.$row->BUNGA.'<br> Tab Wajib: '.$row->TABUNGAN;
                })
                ->addColumn('data_tabungan', function ($row) {
                    return 'Tab Lapangan: '.$row->nominal_sukarela.'<br> Saldo Tab: '.$row->saldo_akhir;
                })
                ->addColumn('data_anggota', function ($row) {
                    return 'Nama: '.$row->NAMA_NASABAH.'<br> ID: '.$row->nasabah_id;
                })
                
                ->rawColumns(['action','date_trans','data_kelompok','data_setoran','data_tabungan','data_anggota'])
                ->make(true);
        }
    }

    public function exportDownloadSetoranTabungan(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);    

        $daterange = $request->input('daterange');
        $p_date = explode("to", $daterange);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date

        $data = DB::connection('mysql_secondary')
        ->table('kretrans as A')
        ->join('kredit as B', 'B.no_rekening', '=', 'A.NO_REKENING')
        ->join('nasabah as C', 'B.nasabah_id', '=', 'C.nasabah_id')
        ->join('app_kode_kantor as D', 'D.KODE_KANTOR', '=', 'C.kode_kantor')
        ->join('kre_kode_group1 as E', 'E.kode_group1', '=', 'B.kode_group1')
        ->join('tabung as F', function($join) {
            $join->on('F.nasabah_id', '=', 'C.nasabah_id')
                 ->on('F.kode_integrasi', '=', DB::raw('203'));
        })
        ->select('A.*', 'C.nasabah_id','B.kode_produk','C.NAMA_NASABAH','D.NAMA_KANTOR','E.deskripsi_group1','B.jml_angsuran', 'B.tgl_realisasi','B.tgl_jatuh_tempo','F.saldo_akhir')
        ->where('A.KODE_TRANS', 300)
        ->where('A.TGL_TRANS', '>=', $awal)
        ->where('A.TGL_TRANS', '<=', $akhir);


        // Execute the query and get the results
        $data = $data->orderBy('A.TGL_TRANS', 'asc')->get();

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header columns
        $sheet->setCellValue('A1', 'ID ANGGOTA')
            ->setCellValue('B1', 'NAMA ANGGOTA')
            ->setCellValue('C1', 'CABANG')
            ->setCellValue('D1', 'NAMA KELOMPOK')
            ->setCellValue('E1', 'PERIODE')
            ->setCellValue('F1', 'TANGGAL CAIR')
            ->setCellValue('G1', 'SUDAH TUTUP?')
            ->setCellValue('H1', 'TUTUP PADA')
            ->setCellValue('I1', 'SUDAH SETOR')
            ->setCellValue('J1', 'SETOR PADA')
            ->setCellValue('K1', 'PRODUK')
            ->setCellValue('L1', 'POKOK')
            ->setCellValue('M1', 'BAGI HASIL')
            ->setCellValue('N1', 'TAB. WAJIB')
            ->setCellValue('O1', 'SETORAN')
            ->setCellValue('P1', 'HARI')
            ->setCellValue('Q1', 'SET KE-')
            ->setCellValue('R1', 'TAB. LAPANGAN')
            ->setCellValue('S1', 'SALDO TAB');

        $row = 2; // Start from row 2 after the header
        foreach ($data as $user) {
            // Check the transaction type
            if ($user->tgl_jatuh_tempo > date('Y-m-d')) {
                $tutup = 'f';
            } else {
                $tutup = 't';
            }

            $wk_trans = $user->TGL_TRANS." ".$user->jam;
            $setoran = $user->POKOK + $user->BUNGA + $user->TABUNGAN;
            $tgl_trans = $user->TGL_TRANS;
            $timestamp = strtotime($tgl_trans);
            $hari_english = date('l', $timestamp);
            $hari_indonesia = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu'
            ];
            $hari = $hari_indonesia[$hari_english];

            // Write data to the spreadsheet
            $sheet->setCellValue('A' . $row, $user->nasabah_id)
                ->setCellValue('B' . $row, $user->NAMA_NASABAH ?? '')
                ->setCellValue('C' . $row, $user->NAMA_KANTOR ?? '')
                ->setCellValue('D' . $row, $user->deskripsi_group1 ?? '')
                ->setCellValue('E' . $row, $user->jml_angsuran ?? '')
                ->setCellValue('F' . $row, $user->tgl_realisasi ?? '')
                ->setCellValue('G' . $row, $tutup)
                ->setCellValue('H' . $row, $user->tgl_jatuh_tempo)
                ->setCellValue('I' . $row, 't')
                ->setCellValue('J' . $row, $wk_trans)
                
                ->setCellValue('K' . $row, $user->kode_produk ?? '')
                ->setCellValue('L' . $row, $user->POKOK ?? '')
                ->setCellValue('M' . $row, $user->BUNGA ?? '')
                ->setCellValue('N' . $row, $user->TABUNGAN ?? '')

                ->setCellValue('O' . $row, $setoran)
                ->setCellValue('P' . $row, $hari)
                ->setCellValue('Q' . $row, $user->ANGSURAN_KE ?? '')
                ->setCellValue('R' . $row, $user->nominal_sukarela ?? '')
                ->setCellValue('S' . $row, $user->saldo_akhir ?? '');

            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output Excel file to the browser
        $filename = 'Data_Setoran_Tabungan.xlsx';
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

    public function setoran(): View
    {
        $menu_aktif = '/setoran||/tabunganSetoran';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Setoran',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('tabungan_setoran.setoran', $data);
    }

    
    public function getTableSet(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');
            $date_range = $request->input('daterange');

            $p_date = explode("to", $date_range);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::connection('mysql_secondary')
                ->table('kretrans as A')
                ->join('kredit as B', 'B.no_rekening', '=', 'A.NO_REKENING')
                ->join('nasabah as C', 'B.nasabah_id', '=', 'C.nasabah_id')
                ->join('app_kode_kantor as D', 'D.KODE_KANTOR', '=', 'C.kode_kantor')
                ->join('kre_kode_group1 as E', 'E.kode_group1', '=', 'B.kode_group1')
                ->join('tabung as F', function($join) {
                    $join->on('F.nasabah_id', '=', 'C.nasabah_id')
                         ->on('F.kode_integrasi', '=', DB::raw('203'));
                })
                ->select('A.*', 'C.nasabah_id','C.NAMA_NASABAH','D.NAMA_KANTOR','E.deskripsi_group1','B.jml_angsuran', 'B.tgl_realisasi','B.tgl_jatuh_tempo','F.saldo_akhir')
                ->where('A.KODE_TRANS', 300)
                ->where('A.TGL_TRANS', '>=', $awal)
                ->where('A.TGL_TRANS', '<=', $akhir);

                $query->orderBy('A.TGL_TRANS', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()  // This is for the row index numbering
                ->addColumn('action', function ($row) {
                    $infoUrl = route('user.infoUser', $row->nasabah_id);
                    $btn = '<a href=' . $infoUrl . ' class="btn btn-light-warning btn-sm"><span class="fa fa-pencil"></span></a> ';
                    return $btn;
                })
                ->addColumn('date_trans', function ($row) {
                    $tgl_trans = $row->TGL_TRANS;
                    $timestamp = strtotime($tgl_trans);
                    $hari_english = date('l', $timestamp);
                    $hari_indonesia = [
                        'Sunday' => 'Minggu',
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa',
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu'
                    ];

                    $hari = $hari_indonesia[$hari_english];

                    return 'Tanggal: '.$row->TGL_TRANS.'<br> Hari: '.$hari;
                }) 
                ->addColumn('data_tabungan', function ($row) {
                    return 'Tab Lapangan: '.$row->nominal_sukarela.'<br> Saldo Tab: '.$row->saldo_akhir;
                })
                ->addColumn('data_anggota', function ($row) {
                    return 'Nama: '.$row->NAMA_NASABAH.'<br> ID: '.$row->nasabah_id;
                })
                ->addColumn('data_setoran', function ($row) {
                    $sisa_setoran = $row->jml_angsuran - $row->ANGSURAN_KE;
                    return 'ID-: '.$row->KRETRANS_ID.'<br>Setoran Ke-: '.$row->ANGSURAN_KE.'<br> Pokok: '.$row->POKOK.'<br> Bagi Hasil: '.$row->BUNGA.'<br> Tab Wajib: '.$row->TABUNGAN;
                })
                ->addColumn('data_lainnya', function ($row) {
                    $sisa_setoran = $row->jml_angsuran - $row->ANGSURAN_KE;
                    $sisa_kewajiban = ($row->POKOK + $row->BUNGA + $row->TABUNGAN)*$sisa_setoran;
                    $tgl_trans = $row->TGL_TRANS;
                    $timestamp = strtotime($tgl_trans);
                    $hari_english = date('l', $timestamp);
                    $hari_indonesia = [
                        'Sunday' => 'Minggu',
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa',
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu'
                    ];

                    $hari = $hari_indonesia[$hari_english];

                    return 'Sisa Minggu: '.$sisa_setoran.'<br> Sisa Kewajiban: '.$sisa_kewajiban.'<br> Hari Setoran: '.$hari.'<br> Tgl Setoran: '.$row->TGL_TRANS;
                })
                ->addColumn('data_kelompok', function ($row) {
                    return 'Nama : '.$row->deskripsi_group1.'<br> Durasi: '.$row->jml_angsuran.'<br> Tgl Cair: '.$row->tgl_realisasi.'<br> Tgl BTAB: '.$row->tgl_jatuh_tempo;
                })
                
                ->rawColumns(['action','data_anggota','data_kelompok','data_setoran','data_tabungan','data_lainnya'])
                ->make(true);
        }
    }

    
    public function exportDownloadSetoran(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $daterange = $request->input('daterange');
        $p_date = explode("to", $daterange);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date

        $data = DB::connection('mysql_secondary')
        ->table('kretrans as A')
        ->join('kredit as B', 'B.no_rekening', '=', 'A.NO_REKENING')
        ->join('nasabah as C', 'B.nasabah_id', '=', 'C.nasabah_id')
        ->join('app_kode_kantor as D', 'D.KODE_KANTOR', '=', 'C.kode_kantor')
        ->join('kre_kode_group1 as E', 'E.kode_group1', '=', 'B.kode_group1')
        ->join('tabung as F', function($join) {
            $join->on('F.nasabah_id', '=', 'C.nasabah_id')
                 ->on('F.kode_integrasi', '=', DB::raw('203'));
        })
        ->select('A.KRETRANS_ID',
            'A.TGL_TRANS','A.jam','A.ANGSURAN_KE','A.POKOK','A.BUNGA','A.TABUNGAN',    
            'C.nasabah_id','B.kode_produk','C.NAMA_NASABAH','D.NAMA_KANTOR','E.deskripsi_group1','B.jml_angsuran', 'B.tgl_realisasi','B.tgl_jatuh_tempo','F.saldo_akhir')
        ->where('A.KODE_TRANS', 300)
        ->where('A.TGL_TRANS', '>=', $awal)
        ->where('A.TGL_TRANS', '<=', $akhir)
        ->orderBy('A.TGL_TRANS', 'asc')->get();


        // dd($data);
        // dd($data->first());  // Menampilkan elemen pertama dari koleksi

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header columns
        $sheet->setCellValue('A1', 'ID ANGGOTA')
            ->setCellValue('B1', 'ID')
            ->setCellValue('C1', 'IS COLLECT')
            ->setCellValue('D1', 'COLLECT AT')
            ->setCellValue('E1', 'WEEK')
            ->setCellValue('F1', 'JUMLAH MINGGU')
            ->setCellValue('G1', 'NAMA KELOMPOK')
            ->setCellValue('H1', 'CABANG')
            ->setCellValue('I1', 'NAMA ANGGOTA')
            ->setCellValue('J1', 'MINGGU SUDAH BAYAR')
            ->setCellValue('K1', 'NAMA PRODUK')
            ->setCellValue('L1', 'POKOK')
            ->setCellValue('M1', 'BAGI HASIL')
            ->setCellValue('N1', 'TAB. WAJIB')
            ->setCellValue('O1', 'SISA KEWAJIBAN')
            ->setCellValue('P1', 'HARI')
            ->setCellValue('Q1', 'SALDO TAB')
            ->setCellValue('R1', 'SISA MINGGU');

        $row = 2; // Start from row 2 after the header
        foreach ($data as $user) {
            // Check the transaction type
            if ($user->tgl_jatuh_tempo > date('Y-m-d')) {
                $tutup = 'f';
            } else {
                $tutup = 't';
            }

            $wk_trans = $user->TGL_TRANS." ".$user->jam;
            $setoran = $user->POKOK + $user->BUNGA + $user->TABUNGAN;
            $tgl_trans = $user->TGL_TRANS;
            $timestamp = strtotime($tgl_trans);
            $hari_english = date('l', $timestamp);
            $hari_indonesia = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu'
            ];
            $hari = $hari_indonesia[$hari_english];

            $sisa_setoran = $user->jml_angsuran - $user->ANGSURAN_KE;
            $sisa_kewajiban = ($user->POKOK + $user->BUNGA + $user->TABUNGAN)*$sisa_setoran;

            // Write data to the spreadsheet
            $sheet->setCellValue('A' . $row, $user->nasabah_id)
                ->setCellValue('B' . $row, $user->KRETRANS_ID ?? '')
                ->setCellValue('C' . $row, 't')
                ->setCellValue('D' . $row, $wk_trans ?? '')
                ->setCellValue('E' . $row, $user->ANGSURAN_KE ?? '')
                ->setCellValue('F' . $row, $user->jml_angsuran ?? '')
                ->setCellValue('G' . $row, $user->deskripsi_group1 ?? '')
                ->setCellValue('H' . $row, $user->NAMA_KANTOR ?? '')
                ->setCellValue('I' . $row, $user->NAMA_NASABAH ?? '')
                ->setCellValue('J' . $row, $user->ANGSURAN_KE ?? '')
                ->setCellValue('K' . $row, $user->kode_produk ?? '')
                ->setCellValue('L' . $row, $user->POKOK ?? '')
                ->setCellValue('M' . $row, $user->BUNGA ?? '')
                ->setCellValue('N' . $row, $user->TABUNGAN ?? '')
                ->setCellValue('O' . $row, $sisa_kewajiban)
                ->setCellValue('P' . $row, $hari)
                ->setCellValue('Q' . $row, $user->saldo_akhir ?? '')
                ->setCellValue('R' . $row, $sisa_setoran);

            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output Excel file to the browser
        $filename = 'Data_Setoran.xlsx';
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

    


    
   
}
