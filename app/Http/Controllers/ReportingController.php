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
use Response;;



class ReportingController extends Controller
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
        $menu_aktif = '/laporanHarian||/reporting';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Laporan Harian',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('reporting.index', $data);
    }

    public function laporanPeriode(): View
    {
        $menu_aktif = '/laporanPeriode||/reporting';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Laporan Periode',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('reporting.laporan-periode', $data);
    }

    
    public function laporanKompilasi(): View
    {
        $menu_aktif = '/laporanKompilasi||/reporting';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Laporan Kompilasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('reporting.laporan-kompilasi', $data);
    }

    
    public function rangkumanMasalah(): View
    {
        $menu_aktif = '/rangkumanMasalah||/reporting';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Rangkuman Masalah',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('reporting.rangkuman-masalah', $data);
    }
    
    public function masalahPerCabang(): View
    {
        $menu_aktif = '/masalahPerCabang||/reporting';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());
        $data = [
            'menu' => 'Masalah Per Cabang',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('reporting.masalah-per-cabang', $data);
    }

    
    public function pdfLaporanHarian(): View
    {
        $cabang = "0".$_GET["cabang"];
        $tanggal = $_GET["tanggal"];
        $nomor_hari = date('N', strtotime($tanggal));
        // var_dump($nomor_hari);die();

        $query_kelompok_aktif = DB::connection('mysql_secondary')->table('kre_kode_group1 AS A')
                    ->selectRaw('COUNT(A.kode_group1) as total')
                    ->whereRaw('(select B.saldo_akhir from tabung B
                                inner join kredit C on C.kode_group1 = B.kode_group1
                                where A.kode_group1 = B.kode_group1 and B.kode_integrasi = 201 and DATE_FORMAT(C.tgl_realisasi, "%w") = '.$nomor_hari.' and C.tgl_realisasi < ? and C.tgl_jatuh_tempo >= ? limit 1) > 0', [$tanggal, $tanggal]);

        $query_kumpulan_aktif = DB::connection('mysql_secondary')->table('kre_kode_group3 AS A')
                    ->selectRaw('COUNT(A.kode_group3) as total')
                    ->whereRaw('(select B.saldo_akhir from kre_kode_group1 C
                        inner join tabung B on B.kode_group1 = C.kode_group1
                        inner join kredit D on D.kode_group1 = B.kode_group1
                        where A.kode_group3 = B.kode_group3 and B.kode_integrasi = 201 and DATE_FORMAT(D.tgl_realisasi, "%w") = '.$nomor_hari.' and D.tgl_realisasi < ? and D.tgl_jatuh_tempo >= ? limit 1) > 0', [$tanggal, $tanggal]);
                
        $query_kelompok_setoran = DB::connection('mysql_secondary')->table('kretrans AS A')
                    ->selectRaw('COUNT(A.kode_group1_trans) as total')
                    ->where('A.TGL_TRANS', $tanggal);
        
        $query_mk = DB::table('kelompok_bermasalah as A')
                    ->select('A.*')
                    ->where('A.tanggal_kb', $tanggal);

        $query_anggota_aktif = DB::connection('mysql_secondary')->table('kredit AS A')
                    ->selectRaw('COUNT(A.nasabah_id) as total')
                    ->join('tabung as B','B.nasabah_id', '=', 'A.nasabah_id')
                    ->where('B.kode_integrasi', 201)
                    ->where('A.tgl_realisasi', '<', $tanggal)
                    ->where('A.tgl_jatuh_tempo', '>=', $tanggal)
                    ->whereRaw('DAYOFWEEK(A.tgl_realisasi) - 1 = ?', [$nomor_hari]);
        
        $query_anggota_setoran = DB::connection('mysql_secondary')->table('kretrans AS A')
                    ->selectRaw('COUNT(A.KRETRANS_ID) as total')
                    ->where('A.KODE_TRANS', 201)
                    ->where('A.dtr', 'TIDAK')
                    ->where('A.TGL_TRANS', $tanggal);

        $query_anggota_dtr = DB::connection('mysql_secondary')->table('kretrans AS A')
                    ->selectRaw('COUNT(A.KRETRANS_ID) as total')
                    ->where('A.KODE_TRANS', 201)
                    ->where('A.dtr', 'YA')
                    ->where('A.TGL_TRANS', $tanggal);

        $query_tab_pribadi = DB::connection('mysql_secondary')->table('tabtrans AS A')
                    ->selectRaw('COUNT(A.TABTRANS_ID) as total, SUM(A.POKOK) as jumlah')
                    ->where('A.MY_KODE_TRANS', 100)
                    ->where('A.KODE_TRANS', 203)
                    ->where('A.TGL_TRANS', $tanggal);

        $query_kelompok_cair = DB::connection('mysql_secondary')->table('kredit AS A')
                    ->selectRaw('COUNT(A.kode_group1) as total')
                    ->where('A.tgl_realisasi', $tanggal);
        
        $query_anggota_cair = DB::connection('mysql_secondary')->table('kredit AS A')
                    ->selectRaw('COUNT(A.nasabah_id) as total, SUM(A.jml_pinjaman) as jumlah')
                    ->where('A.tgl_realisasi', $tanggal);

        $query_anggota_btab = DB::connection('mysql_secondary')->table('kredit AS A')
                    ->join('kretrans as B','B.NO_REKENING', '=', 'A.no_rekening')
                    ->selectRaw('COUNT(A.nasabah_id) as total')
                    ->where('B.TGL_TRANS', $tanggal)
                    ->whereColumn('A.jml_angsuran', 'B.ANGSURAN_KE');
        $query_kelompok_btab = DB::connection('mysql_secondary')->table('kredit AS A')
                    ->join('kretrans as B','B.NO_REKENING', '=', 'A.no_rekening')
                    ->selectRaw('COUNT(A.kode_group1) as total')
                    ->where('B.TGL_TRANS', $tanggal)
                    ->whereColumn('A.jml_angsuran', 'B.ANGSURAN_KE');
    

        if ($cabang != 0) {
            $query_kumpulan_aktif->where('A.kode_kantor', $cabang);
            $query_kelompok_aktif->where('A.kode_kantor', $cabang);
            $query_kelompok_setoran->where('A.kode_kantor', $cabang);
            $query_mk->where('A.cabang_kb', $cabang);
            $query_anggota_aktif->where('A.KODE_KANTOR', $cabang);
            $query_anggota_setoran->where('A.kode_kantor', $cabang);
            $query_anggota_dtr->where('A.kode_kantor', $cabang);
            $query_tab_pribadi->where('A.kode_kantor', $cabang);
            $query_kelompok_cair->where('A.KODE_KANTOR', $cabang);
            $query_anggota_cair->where('A.KODE_KANTOR', $cabang);
            $query_anggota_btab->where('A.KODE_KANTOR', $cabang);
            $query_kelompok_btab->where('A.KODE_KANTOR', $cabang);
        }
        
                
        $kumpulan_aktif = $query_kumpulan_aktif->get();
        $kelompok_aktif = $query_kelompok_aktif->get();
        $kelompok_setoran = $query_kelompok_setoran->groupBy('A.kode_group1_trans')->get();
        $masalah_kelompok = $query_mk->get();
        $anggota_aktif = $query_anggota_aktif->get();
        $anggota_setoran = $query_anggota_setoran->get();
        $anggota_dtr = $query_anggota_dtr->get();
        $tab_pribadi = $query_tab_pribadi->get();
        $kelompok_cair = $query_kelompok_cair->groupBy('A.kode_group1')->get();
        $anggota_cair = $query_anggota_cair->get();
        $kelompok_btab = $query_kelompok_btab->groupBy('A.kode_group1')->get();
        $anggota_btab = $query_anggota_btab->get();


        $mk_kurang_10menit = 0;
        $mk_lebih_10menit = 0;
        foreach($masalah_kelompok as $mk){
            if($mk->menit_kb > 10){
                $mk_lebih_10menit = $mk_lebih_10menit+1;
            }else{
                $mk_kurang_10menit = $mk_kurang_10menit+1;
            }
        }

        $data = [
            'menu' => 'Laporan Harian',
            'cabang' => $_GET["cabang"],
            'tanggal' => $tanggal,
            'kumpulan_aktif' => $kumpulan_aktif[0]->total,
            'kelompok_aktif' => $kelompok_aktif[0]->total,
            'kelompok_setoran' => COUNT($kelompok_setoran),
            'mk_kurang_10menit' => $mk_kurang_10menit,
            'mk_lebih_10menit' => $mk_lebih_10menit,
            'anggota_aktif' => $anggota_aktif[0]->total,
            'anggota_setoran' => $anggota_setoran[0]->total,
            'anggota_dtr' => $anggota_dtr[0]->total,
            'penabung' => $tab_pribadi[0]->total,
            'jumlah_tabungan' => $tab_pribadi[0]->jumlah,
            'kelompok_cair' => $kelompok_cair[0]->total,
            'anggota_cair' => $anggota_cair[0]->total,
            'jumlah_cair' => $anggota_cair[0]->jumlah,
            'kelompok_btab' => $kelompok_btab[0]->total,
            'anggota_btab' => $anggota_btab[0]->total
            
        ];
        
        return view('reporting.pdf-laporan-harian', $data);
    }

    
    public function pdfLaporanPeriode(): View
    {
        $cabang = $_GET["cabang"];
        $tanggal = $_GET["tanggal"];
        $p_tanggal = explode("to", $tanggal);
        $data = [
            'menu' => 'Laporan Periode',
            'cabang' => $cabang,
            'tanggal' => $tanggal,
            'awal' => $p_tanggal[0],
            'akhir' => $p_tanggal[1]
            
        ];
        
        return view('reporting.pdf-laporan-periode', $data);
    }

    public function getLaporanRangkumanAb(Request $request)
    {
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::table('anggota_bermasalah as A')
                ->select(
                    'A.cabang_ab',
                    DB::raw('COUNT(A.id_ab) as jumlah'),
                    DB::raw('SUM(IF(A.kode_ab = "2", 1, 0)) AS kode2'),
                    DB::raw('SUM(IF(A.kode_ab = "4A", 1, 0)) AS kode4a'),
                    DB::raw('SUM(IF(A.kode_ab = "4B", 1, 0)) AS kode4b')
                )
                ->whereBetween('A.tanggal_ab', [$awal, $akhir]);

            $filteredData = $query->groupBy('A.cabang_ab') 
                ->orderBy('A.cabang_ab', 'asc')
                ->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-history btn-sm" data-id="' . $row->cabang_ab . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getLaporanRangkumanKb(Request $request)
    {
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::table('kelompok_bermasalah as A')
                ->select(
                    'A.cabang_kb',
                    DB::raw('COUNT(A.id_kb) as jumlah'),
                    DB::raw('SUM(IF(A.kode_kb = "3A", 1, 0)) AS telat'),
                    DB::raw('SUM(IF(A.kode_kb = "3B", 1, 0)) AS berat')
                )
                ->whereBetween('A.tanggal_kb', [$awal, $akhir]);

            $filteredData = $query->groupBy('A.cabang_kb') 
                ->orderBy('A.cabang_kb', 'asc')
                ->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-history btn-sm" data-id="' . $row->cabang_kb . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function exportDownloadRangkumanMasalah(Request $request)
    {
        $daterange = $request->input('daterange');
        $p_date = explode("to", $daterange);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date

        $data = DB::table('kelompok_bermasalah as A')
        ->select(
            'A.cabang_kb',
            DB::raw('COUNT(A.id_kb) as jumlah'),
            DB::raw('SUM(IF(A.kode_kb = "3A", 1, 0)) AS telat'),
            DB::raw('SUM(IF(A.kode_kb = "3B", 1, 0)) AS berat')
        )
        ->whereBetween('A.tanggal_kb', [$awal, $akhir])
        ->groupBy('A.cabang_kb') 
        ->orderBy('A.cabang_kb', 'asc')
        ->get();

        $data2 = DB::table('anggota_bermasalah as A')
        ->select(
            'A.cabang_ab',
            DB::raw('COUNT(A.id_ab) as jumlah'),
            DB::raw('SUM(IF(A.kode_ab = "2", 1, 0)) AS kode2'),
            DB::raw('SUM(IF(A.kode_ab = "4A", 1, 0)) AS kode4a'),
            DB::raw('SUM(IF(A.kode_ab = "4B", 1, 0)) AS kode4b')
        )
        ->whereBetween('A.tanggal_ab', [$awal, $akhir])
        ->groupBy('A.cabang_ab') 
        ->orderBy('A.cabang_ab', 'asc')
        ->get();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header columns
        $sheet->setCellValue('A1', 'Cabang')
            ->setCellValue('B1', 'Jml Anggota DTR')
            ->setCellValue('C1', 'Kode 2')
            ->setCellValue('D1', 'Kode 4A')
            ->setCellValue('E1', 'Kode 4B');

        $row = 2; // Start from row 2 after the header
        $jumlah = 0;
        $jum_kode2 = 0;
        $jum_kode4a = 0;
        $jum_kode4b = 0;
        foreach ($data2 as $user) {
            
            $sheet->setCellValue('A' . $row, $user->cabang_ab)
                ->setCellValue('B' . $row, $user->jumlah ?? '')
                ->setCellValue('C' . $row, $user->kode2 ?? '')
                ->setCellValue('D' . $row, $user->kode4a ?? '' ?? '')
                ->setCellValue('E' . $row, $user->kode4b ?? '');

            $jumlah = $jumlah + $user->jumlah;
            $jum_kode2 = $jum_kode2 + $user->kode2;
            $jum_kode4a = $jum_kode4a + $user->kode4a;
            $jum_kode4b = $jum_kode4b + $user->kode4b;

            $row++;
        }

        $sheet->setCellValue('A' . $row, 'Total')
            ->setCellValue('B' . $row, $jumlah)
            ->setCellValue('C' . $row, $jum_kode2)
            ->setCellValue('D' . $row, $jum_kode4a)
            ->setCellValue('E' . $row, $jum_kode4b);

        $row2 = $row + 4;
        $sheet->setCellValue('A' . $row2, 'Cabang')
            ->setCellValue('B' . $row2, 'Jml Kelompok')
            ->setCellValue('C' . $row2, 'Telat')
            ->setCellValue('D' . $row2, 'Berat');

        $row2 = $row2 + 1;
        $jumlah2 = 0;
        $jum_telat = 0;
        $jum_berat = 0;
        foreach ($data as $d) {
            
            $sheet->setCellValue('A' . $row2, $d->cabang_kb)
                ->setCellValue('B' . $row2, $d->jumlah ?? '')
                ->setCellValue('C' . $row2, $d->telat ?? '')
                ->setCellValue('D' . $row2, $d->berat ?? '' ?? '');

            $jumlah2 = $jumlah2 + $d->jumlah;
            $jum_telat = $jum_telat + $d->telat;
            $jum_berat = $jum_berat + $d->berat;
            $row2++;
        }
        $sheet->setCellValue('A' . $row2, 'Total')
            ->setCellValue('B' . $row2, $jumlah2)
            ->setCellValue('C' . $row2, $jum_telat)
            ->setCellValue('D' . $row2, $jum_berat);

        $writer = new Xlsx($spreadsheet);

        $filename = 'Rangkuman_anggota_dan_kelompok_bermasalah.xlsx';
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
    
    public function pdfLaporanRangkuman(): View
    {
        $tanggal = $_GET["daterange"];
        $p_tanggal = explode("to", $tanggal);
        $list_ab = DB::table('anggota_bermasalah as A')
            ->select(
                'A.cabang_ab',
                DB::raw('COUNT(A.id_ab) as jumlah'),
                DB::raw('SUM(IF(A.kode_ab = "2", 1, 0)) AS kode2'),
                DB::raw('SUM(IF(A.kode_ab = "4A", 1, 0)) AS kode4a'),
                DB::raw('SUM(IF(A.kode_ab = "4B", 1, 0)) AS kode4b')
            )
            ->whereBetween('A.tanggal_ab', [$p_tanggal[0], $p_tanggal[1]])
            ->groupBy('A.cabang_ab') 
            ->orderBy('A.cabang_ab', 'asc')
            ->get();

        $list_kb = DB::table('kelompok_bermasalah as A')
            ->select(
                'A.cabang_kb',
                DB::raw('COUNT(A.id_kb) as jumlah'),
                DB::raw('SUM(IF(A.kode_kb = "3A", 1, 0)) AS telat'),
                DB::raw('SUM(IF(A.kode_kb = "3B", 1, 0)) AS berat')
            )
            ->whereBetween('A.tanggal_kb', [$p_tanggal[0], $p_tanggal[1]])
            ->groupBy('A.cabang_kb') 
            ->orderBy('A.cabang_kb', 'asc')
            ->get();


        $data = [
            'menu' => 'Laporan Periode',
            'tanggal' => $tanggal,
            'awal' => $p_tanggal[0],
            'akhir' => $p_tanggal[1],
            'list_ab' => $list_ab,
            'list_kb' => $list_kb
            
        ];
        
        return view('reporting.pdf-laporan-rangkuman', $data);
    }

    
    public function getMasalahCabangAb(Request $request)
    {
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $cabang = $request->input('cabang');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::table('anggota_bermasalah as A')
                ->select('A.*')
                ->whereBetween('A.tanggal_ab', [$awal, $akhir]);
            
            if($cabang != 0){
                $query->where('A.cabang_ab', $cabang);
            }

            $filteredData = $query->orderBy('A.cabang_ab', 'asc')
                ->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-history btn-sm" data-id="' . $row->cabang_ab . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                ->addColumn('dtr', function ($row) {
                    $data_dtr = DB::table('anggota_bermasalah as A')
                        ->select(
                            'A.id_anggota_ab',
                            DB::raw('COUNT(A.id_ab) as jumlah'),
                            DB::raw('SUM(IF(A.kode_ab = "2", 1, 0)) AS kode2'),
                            DB::raw('SUM(IF(A.kode_ab = "4A", 1, 0)) AS kode4a'),
                            DB::raw('SUM(IF(A.kode_ab = "4B", 1, 0)) AS kode4b')
                        )
                        ->where('A.id_anggota_ab', $row->id_anggota_ab)
                        ->groupBy('A.id_anggota_ab')
                        ->first();
                            

                    $dtr = '<span class="badge badge-success">Kode 2: '.$data_dtr->kode2.'</span><br>
                            <span class="badge badge-warning">Kode 4A: '.$data_dtr->kode4a.'</span><br>
                            <span class="badge badge-danger">Kode 4B: '.$data_dtr->kode4b.'</span>';
                    return $dtr;
                })
                

                ->rawColumns(['action','dtr'])
                ->make(true);
        }
    }

    
    public function getMasalahCabangKb(Request $request)
    {
        if ($request->ajax()) {
            $daterange = $request->input('daterange');
            $cabang = $request->input('cabang');
            $p_date = explode("to", $daterange);
            $awal = trim($p_date[0]); // Start date
            $akhir = trim($p_date[1]); // End date

            $query = DB::table('kelompok_bermasalah as A')
                ->join('data_kb as B', 'B.kelompok_dkb', '=', 'A.kelompok_kb')
                ->select('A.*','B.pkp_dkb','B.kc_dkb')
                ->whereBetween('A.tanggal_kb', [$awal, $akhir]);

            if($cabang != 0){
                $query->where('A.cabang_kb', $cabang);
            }

            $filteredData = $query->orderBy('A.cabang_kb', 'asc')
                ->get();

            return DataTables::of($filteredData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button title="HAPUS" class="btn btn-danger btn-delete-history btn-sm" data-id="' . $row->cabang_kb . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })
                ->addColumn('history', function ($row) {
                    $data_dtr = DB::table('kelompok_bermasalah as A')
                        ->select(
                            'A.kelompok_kb',
                            DB::raw('SUM(IF(A.kode_kb = "3A", 1, 0)) AS telat'),
                            DB::raw('SUM(IF(A.kode_kb = "4B", 1, 0)) AS berat')
                        )
                        ->where('A.kelompok_kb', $row->kelompok_kb)
                        ->groupBy('A.kelompok_kb')
                        ->first();
                            

                    $dtr = '<span class="badge badge-warning">Telat: '.$data_dtr->telat.'</span><br>
                            <span class="badge badge-danger">Berat: '.$data_dtr->berat.'</span>';
                    return $dtr;
                })
                

                ->rawColumns(['action','history'])
                ->make(true);
        }
    }

    
    public function exportDownloadMasalahPerCabang(Request $request)
    {
        $daterange = $request->input('daterange');
        $p_date = explode("to", $daterange);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date
        $cabang = $request->input('cabang');

        $data = DB::table('kelompok_bermasalah as A')
            ->join('data_kb as B', 'B.kelompok_dkb', '=', 'A.kelompok_kb')
            ->select('A.*','B.pkp_dkb','B.kc_dkb')
            ->whereBetween('A.tanggal_kb', [$awal, $akhir]);
        if($cabang != 0){
            $data->where('A.cabang_kb', $cabang);
        }
        $data = $data->orderBy('A.cabang_kb', 'asc')->get();

        
        $data2 = DB::table('anggota_bermasalah as A')
            ->select('A.*')
            ->whereBetween('A.tanggal_ab', [$awal, $akhir]);
        if($cabang != 0){
            $data2->where('A.cabang_ab', $cabang);
        }
        $data2 = $data2->orderBy('A.cabang_ab', 'asc')->get();

        


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header columns
        $sheet->setCellValue('A1', 'Tanggal')
            ->setCellValue('B1', 'Cabang')
            ->setCellValue('C1', 'Kelompok')
            ->setCellValue('D1', 'Set Ke-')
            ->setCellValue('E1', 'Kode')
            ->setCellValue('F1', 'Menit Telat')
            ->setCellValue('G1', 'PKP Proses')
            ->setCellValue('H1', 'KC Proses')
            ->setCellValue('I1', 'Telat')
            ->setCellValue('J1', 'Berat');

        $row = 2; // Start from row 2 after the header
       
        foreach ($data as $user) {
            
            $mk = DB::table('kelompok_bermasalah as A')->select(
                    DB::raw('SUM(IF(A.kode_kb = "3A", 1, 0)) AS telat'),
                    DB::raw('SUM(IF(A.kode_kb = "3B", 1, 0)) AS berat')
                )
            ->where('A.kelompok_kb', $user->kelompok_kb)
            ->first();


            $sheet->setCellValue('A' . $row, $user->tanggal_kb)
                ->setCellValue('B' . $row, $user->cabang_kb ?? '')
                ->setCellValue('C' . $row, $user->kelompok_kb ?? '')
                ->setCellValue('D' . $row, $user->setoran_kb ?? '' ?? '')
                ->setCellValue('E' . $row, $user->kode_kb ?? '')
                ->setCellValue('F' . $row, $user->menit_kb ?? '')
                ->setCellValue('G' . $row, $user->pkp_dkb ?? '')
                ->setCellValue('H' . $row, $user->kc_dkb ?? '')
                ->setCellValue('I' . $row, $mk->telat ?? '0')
                ->setCellValue('J' . $row, $mk->berat ?? '0');

            $row++;
        }

        $row2 = $row + 3;
        $sheet->setCellValue('A' . $row2, 'Tanggal')
            ->setCellValue('B' . $row2, 'ID')
            ->setCellValue('C' . $row2, 'Anggota')
            ->setCellValue('D' . $row2, 'Kelompok')
            ->setCellValue('E' . $row2, 'Cabang')
            ->setCellValue('F' . $row2, 'DTR')
            ->setCellValue('G' . $row2, 'Set Ke-')
            ->setCellValue('H' . $row2, 'Menit Telat')
            ->setCellValue('I' . $row2, '2')
            ->setCellValue('J' . $row2, '4A')
            ->setCellValue('K' . $row2, '4B');

        $row2 = $row2 + 1;
        
        foreach ($data2 as $d) {
            $ma = DB::table('anggota_bermasalah as A')
                ->select(
                    DB::raw('SUM(IF(A.kode_ab = "2", 1, 0)) AS kode2'),
                    DB::raw('SUM(IF(A.kode_ab = "4A", 1, 0)) AS kode4a'),
                    DB::raw('SUM(IF(A.kode_ab = "4B", 1, 0)) AS kode4b')
                )
                ->where('A.id_anggota_ab', $d->id_anggota_ab)
                ->first();
            
            $sheet->setCellValue('A' . $row2, $d->tanggal_ab)
                ->setCellValue('B' . $row2, $d->id_anggota_ab ?? '')
                ->setCellValue('C' . $row2, $d->nama_ab ?? '')
                ->setCellValue('D' . $row2, $d->kelompok_ab ?? '' ?? '')
                ->setCellValue('E' . $row2, $d->cabang_ab ?? '' ?? '')
                ->setCellValue('F' . $row2, $d->kode_ab ?? '' ?? '')
                ->setCellValue('G' . $row2, $d->setoran_ab ?? '' ?? '')
                ->setCellValue('H' . $row2, $d->menit_ab ?? '' ?? '')
                ->setCellValue('I' . $row2, $ma->kode2 ?? '' ?? '0')
                ->setCellValue('J' . $row2, $ma->kode4a ?? '' ?? '0')
                ->setCellValue('K' . $row2, $ma->kode4b ?? '' ?? '0');

            
            $row2++;
        }
        

        $writer = new Xlsx($spreadsheet);

        $filename = 'Masalah_per_cabang.xlsx';
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

    
    public function pdfMasalahPerCabangAction(): View
    {
        $tanggal = $_GET["daterange"];
        $cabang = $_GET["cabang"];
        $p_tanggal = explode("to", $tanggal);
        $list_ab = DB::table('anggota_bermasalah as A')
            ->leftJoin('pkp as B', 'B.id', '=', 'A.pkp_ab')
            ->select('A.*','B.nama')
            ->whereBetween('A.tanggal_ab', [$p_tanggal[0], $p_tanggal[1]]);
        if($cabang != 0){
            $list_ab->where('A.cabang_ab', $cabang);
        }
        $list_ab = $list_ab->orderBy('A.cabang_ab', 'asc')->get();

        foreach ($list_ab as $ab) {
            $detail_ab = DB::table('anggota_bermasalah as A')
                ->select(
                    DB::raw('SUM(IF(A.kode_ab = "2", 1, 0)) AS kode2'),
                    DB::raw('SUM(IF(A.kode_ab = "4A", 1, 0)) AS kode4a'),
                    DB::raw('SUM(IF(A.kode_ab = "4B", 1, 0)) AS kode4b')
                )
                ->where('A.id_anggota_ab', $ab->id_anggota_ab)
                ->first();
            
            if ($detail_ab) {
                $ab->kode2 = $detail_ab->kode2; 
                $ab->kode4a = $detail_ab->kode4a;
                $ab->kode4b = $detail_ab->kode4b;
            }
        }


        $list_kb = DB::table('kelompok_bermasalah as A')
            ->leftJoin('data_kb as B', 'B.kelompok_dkb', '=', 'A.kelompok_kb')
            ->leftJoin('pkp as C', 'C.id', '=', 'A.pkp_kb')
            ->select('A.*','B.pkp_dkb','B.kc_dkb','C.nama')
            ->whereBetween('A.tanggal_kb', [$p_tanggal[0], $p_tanggal[1]]);
        if($cabang != 0){
            $list_kb->where('A.cabang_kb', $cabang);
        }
        $list_kb = $list_kb->orderBy('A.cabang_kb', 'asc')->get();

        $jum_telat = 0;
        $jum_berat = 0;
        foreach ($list_kb as $kb) {
            $detail_kb =  DB::table('kelompok_bermasalah as A')->select(
                    DB::raw('SUM(IF(A.kode_kb = "3A", 1, 0)) AS telat'),
                    DB::raw('SUM(IF(A.kode_kb = "3B", 1, 0)) AS berat')
                )
                ->where('A.kelompok_kb', $kb->kelompok_kb)
                ->first();
            
            if ($detail_kb) {
                $kb->telat = $detail_kb->telat; 
                $kb->berat = $detail_kb->berat;
            }
            $jum_telat = $jum_telat+$detail_kb->telat;
            $jum_berat = $jum_berat+$detail_kb->berat;
        }


        if($cabang == 0){
            $cbg = 'SEMUA';
        }else{
            $cbg = $cabang;
        }

        $data = [
            'menu' => 'Laporan Periode',
            'tanggal' => $tanggal,
            'awal' => $p_tanggal[0],
            'akhir' => $p_tanggal[1],
            'list_ab' => $list_ab,
            'list_kb' => $list_kb,
            'total_ab' => COUNT($list_ab),
            'total_kb' => COUNT($list_kb),
            'cabang' => $cbg,
            'jum_telat' => $jum_telat,
            'jum_berat' => $jum_berat
            
        ];
        
        return view('reporting.pdf-laporan-masalah-cabang', $data);
    }
}
