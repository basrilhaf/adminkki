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

                if ($tipe != 0) {
                    $query->where('A.MY_KODE_TRANS', $tipe);
                }
                if ($kode != 0) {
                    $query->where('A.KODE_TRANS', $kode);
                }else{
                    $query->whereIn('A.KODE_TRANS', ['200','201','203']);
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
                    if($row->MY_KODE_TRANS = 200){
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

        if ($tipe != 0) {
            $data->where('A.MY_KODE_TRANS', $tipe);
        }

        if ($kode != 0) {
            $data->where('A.KODE_TRANS', $kode);
        } else {
            $data->whereIn('A.KODE_TRANS', ['200', '201', '203']);
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


    
    public function cekAnggota(): View
    {
        $menu_aktif = '/cekAnggota||/pengecekan';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Cek Anggota',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('pengecekan.cek-anggota', $data);
    }

    
    public function cekKtp(): View
    {
        $menu_aktif = '/cekKtp||/pengecekan';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Cek KTP',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('pengecekan.cek-ktp', $data);
    }
    
    
    public function cekTabunganAnggota($nasabah_id, Request $request)
    {
        $menu_aktif = '/cekTabungan||/pengecekan';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Detail Cek Anggota',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '',
            'nasabah_id' => $nasabah_id
        ];
        
        return view('pengecekan.detail-tabungan-anggota', $data);

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


    
   
}
