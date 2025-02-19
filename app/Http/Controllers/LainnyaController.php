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


class LainnyaController extends Controller
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
       
    }

    public function kompilasi(Request $request): View
    {
        $menu_aktif = '/kompilasi||/lainnya';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        $data = [
            'menu' => 'Kompilasi',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('lainnya.kompilasi', $data);
    }

    public function exportDownloadPencairan(Request $request)
    {
        $daterange = $request->input('tanggal');
        $p_date = explode("to", $daterange);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date
        
        $data = DB::connection('mysql_secondary')
            ->table('kredit as A')
            ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')
            ->join('app_kode_kantor as C', 'C.KODE_KANTOR', '=', 'A.kode_kantor')
            ->join('kre_kode_group2 as D', 'D.kode_group2', '=', 'A.kode_group2')
            ->selectRaw('
                A.tgl_realisasi, 
                A.kode_group1,
                B.deskripsi_group1, 
                D.deskripsi_group2, 
                COUNT(A.nasabah_id) AS jml_anggota, 
                SUM(A.jml_pinjaman) AS total_pinjaman,
                SUM(A.pokok_saldo_akhir) AS total_pokok,
                A.tgl_lunas,  
                C.NAMA_KANTOR
            ')
            ->whereBetween('A.tgl_realisasi', [$awal, $akhir])
            ->groupBy([
                'A.tgl_realisasi', 
                'A.kode_group1',
                'B.deskripsi_group1', 
                'D.deskripsi_group2', 
                'A.tgl_lunas',
                'C.NAMA_KANTOR'
            ])
            ->orderBy('A.tgl_realisasi', 'asc')
            ->get();
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header columns
        $sheet->setCellValue('A1', 'TANGGAL PENCAIRAN')
            ->setCellValue('B1', 'NAMA KELOMPOK')
            ->setCellValue('C1', 'PKP')
            ->setCellValue('D1', 'JUMLAH ANGGOTA')
            ->setCellValue('E1', 'ANGGOTA BARU')
            ->setCellValue('F1', 'JUMLAH PINJAMAN KELOMPOK')
            ->setCellValue('G1', 'TANGGAL SETORAN TERAKHIR')
            ->setCellValue('H1', 'SUDAH SELESAI?')
            ->setCellValue('I1', 'CABANG');

        $row = 2; // Start from row 2 after the header
        foreach ($data as $user) {

            if($user->total_pokok > 0){
                $selesai = 'Belum';
            }else{
                $selesai = 'Sudah';
            }

            // // $get_kelompok = DB::connection('mysql_secondary')
            // //     ->table('kredit')
            // //     ->select('nasabah_id')
            // //     ->where('kode_group1', $user->kode_group1)
            // //     ->get();

            // // $baru = 0;
            // // foreach($get_kelompok as $cek){
            // //     $get_baru = DB::connection('mysql_secondary')
            // //         ->table('kredit as A')
            // //         ->selectRaw('A.nasabah_id')
            // //         ->where('A.nasabah_id', $cek->nasabah_id)
            // //         ->where('A.tgl_realisasi','<',$user->tgl_realisasi)
            // //         ->first();
            //     // dd($get_baru);

            //     if (empty($get_baru)) {
            //         $baru = $baru + 1;
            //     }
                
            // }

            // Write data to the spreadsheet
            $sheet->setCellValue('A' . $row, $user->tgl_realisasi)
                ->setCellValue('B' . $row, $user->deskripsi_group1 ?? '')
                ->setCellValue('C' . $row, $user->deskripsi_group2 ?? '')
                ->setCellValue('D' . $row, $user->jml_anggota ?? '')
                ->setCellValue('E' . $row,  '' ?? '')
                ->setCellValue('F' . $row, $user->total_pinjaman ?? '')
                ->setCellValue('G' . $row, $user->tgl_lunas ?? '')
                ->setCellValue('H' . $row, $selesai ?? '')
                ->setCellValue('I' . $row, $user->NAMA_KANTOR);

            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output Excel file to the browser
        $filename = 'Data_kompilasi_pencairan.xlsx';
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

    public function exportDownloadSelesai(Request $request)
    {
        $daterange = $request->input('tanggal');
        $p_date = explode("to", $daterange);
        $awal = trim($p_date[0]); // Start date
        $akhir = trim($p_date[1]); // End date
        
        $data = DB::connection('mysql_secondary')
            ->table('kredit as A')
            ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')
            ->join('app_kode_kantor as C', 'C.KODE_KANTOR', '=', 'A.kode_kantor')
            ->join('kre_kode_group2 as D', 'D.kode_group2', '=', 'A.kode_group2')
            ->join('tabtrans as E', 'E.kode_group1_trans', '=', 'A.kode_group1')
            ->selectRaw('
                A.tgl_realisasi, 
                A.kode_group1,
                B.deskripsi_group1, 
                D.deskripsi_group2, 
                COUNT(A.nasabah_id) AS jml_anggota, 
                SUM(A.jml_pinjaman) AS total_pinjaman,
                SUM(A.pokok_saldo_akhir) AS total_pokok,
                E.TGL_TRANS,  
                C.NAMA_KANTOR
            ')
            ->whereBetween('E.TGL_TRANS', [$awal, $akhir])
            ->where('E.KETERANGAN','like','%BTAB%')
            ->groupBy([
                'A.tgl_realisasi', 
                'A.kode_group1',
                'B.deskripsi_group1', 
                'D.deskripsi_group2', 
                'E.TGL_TRANS',
                'C.NAMA_KANTOR'
            ])
            ->orderBy('A.tgl_realisasi', 'asc')
            ->get();
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header columns
        $sheet->setCellValue('A1', 'TANGGAL PENCAIRAN')
            ->setCellValue('B1', 'NAMA KELOMPOK')
            ->setCellValue('C1', 'PKP')
            ->setCellValue('D1', 'JUMLAH ANGGOTA')
            ->setCellValue('E1', 'ANGGOTA BARU')
            ->setCellValue('F1', 'JUMLAH PINJAMAN KELOMPOK')
            ->setCellValue('G1', 'TANGGAL SETORAN TERAKHIR')
            ->setCellValue('H1', 'SUDAH SELESAI?')
            ->setCellValue('I1', 'CABANG');

        $row = 2; // Start from row 2 after the header
        foreach ($data as $user) {
            $get_anggota = DB::connection('mysql_secondary')
                    ->table('kredit as A')
                    ->selectRaw('COUNT(distinct(A.nasabah_id)) as jumlah')
                    ->where('A.kode_group1', $user->kode_group1)
                    ->where('A.tgl_realisasi', $user->tgl_realisasi)
                    ->first();
                    // dd($get_anggota->toSql());
                    // dd(vsprintf(str_replace("?", "%s", $get_anggota->toSql()), $get_anggota->getBindings()));

            

            // $get_kelompok = DB::connection('mysql_secondary')
            //     ->table('kredit')
            //     ->select('nasabah_id')
            //     ->where('kode_group1', $user->kode_group1)
            //     ->get();

            // $baru = 0;
            // foreach($get_kelompok as $cek){
            //     $get_baru = DB::connection('mysql_secondary')
            //         ->table('kredit as A')
            //         ->selectRaw('A.nasabah_id')
            //         ->where('A.nasabah_id', $cek->nasabah_id)
            //         ->where('A.tgl_realisasi','<',$user->tgl_realisasi)
            //         ->first();
            //     // dd($get_baru);

            //     if (empty($get_baru)) {
            //         $baru = $baru + 1;
            //     }
                
            // }

            // Write data to the spreadsheet
            $sheet->setCellValue('A' . $row, $user->tgl_realisasi)
                ->setCellValue('B' . $row, $user->deskripsi_group1 ?? '')
                ->setCellValue('C' . $row, $user->deskripsi_group2 ?? '')
                ->setCellValue('D' . $row, $get_anggota->jumlah ?? '')
                ->setCellValue('E' . $row,  '' ?? '')
                ->setCellValue('F' . $row, $user->total_pinjaman ?? '')
                ->setCellValue('G' . $row, $user->TGL_TRANS ?? '')
                ->setCellValue('H' . $row, 'Sudah' ?? '')
                ->setCellValue('I' . $row, $user->NAMA_KANTOR);

            $row++;
        }

        // Set file writer
        $writer = new Xlsx($spreadsheet);

        // Output Excel file to the browser
        $filename = 'Data_kompilasi_selesai.xlsx';
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
