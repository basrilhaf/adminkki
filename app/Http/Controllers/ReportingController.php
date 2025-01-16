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
        $cabang = $_GET["cabang"];
        $tanggal = $_GET["tanggal"];
        $data = [
            'menu' => 'Laporan Harian',
            'cabang' => $cabang,
            'tanggal' => $tanggal
            
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
}
