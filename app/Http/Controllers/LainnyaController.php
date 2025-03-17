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
use PhpOffice\PhpSpreadsheet\IOFactory;



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
        
        // $query = DB::connection('mysql_secondary')->table('tabtrans AS A')
        //         ->join('tabung as B','A.NO_REKENING', '=', 'B.no_rekening')
        //         ->join('kre_kode_group1 as AAA', 'A.kode_group1_trans','=','AAA.kode_group1')
        //         ->selectRaw('AAA.deskripsi_group1, SUM(A.POKOK) as btab_cair, COUNT(DISTINCT(A.NO_REKENING)) as jml_anggota,A.TGL_TRANS,A.kode_group1_trans')
        //         ->whereBetween('A.TGL_TRANS', [$awal, $akhir])
        //         ->where('A.kode_kantor', '!=', 00)
        //         ->where('B.kode_integrasi', 204)
        //         ->where('A.KODE_TRANS', 200);



        $data = DB::connection('mysql_secondary')
            ->table('kredit as A')
            ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')
            ->join('app_kode_kantor as C', 'C.KODE_KANTOR', '=', 'A.kode_kantor')
            ->join('kre_kode_group2 as D', 'D.kode_group2', '=', 'A.kode_group2')
            ->join('tabtrans as E', 'E.kode_group1_trans', '=', 'A.kode_group1')
            ->join('tabung as F', 'E.NO_REKENING', '=', 'F.no_rekening')
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
            ->where('E.kode_kantor', '!=', 00)
            ->where('F.kode_integrasi', 204)
            ->where('E.KODE_TRANS', 200)
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

    public function rat(Request $request): View
    {
        $menu_aktif = '/rat||/lainnya';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        $data = [
            'menu' => 'RAT',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('lainnya.rat', $data);
    }

    
    public function pdfHadirRat(): View
    {
        $hari = $_GET["hari"];
        $cabang = $_GET["cabang"];
        
        if($hari == '02'){
            $hari_bahasa = 'Senin';
        }else if($hari == '03'){
            $hari_bahasa = 'Selasa';
        }else if($hari == '04'){
            $hari_bahasa = 'Rabu';
        }else if($hari == '05'){
            $hari_bahasa = 'Kamis';
        }else if($hari == '06'){
            $hari_bahasa = 'Jumat';
        }else{
            $hari_bahasa = 'Minggu';
        }

        // Ambil data kelompok kredit (group1)
        $data_kelompok = DB::connection('mysql_secondary')->table('kredit AS A')
            ->select('B.deskripsi_group1', 'A.kode_group1', 'A.tgl_realisasi')
            ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')
            ->where('A.pokok_saldo_akhir', '>', 0)
            ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = ?', [$hari])
            ->where('A.kode_kantor', $cabang)
            ->groupBy('B.deskripsi_group1', 'A.kode_group1', 'A.tgl_realisasi')
            ->orderBy('B.deskripsi_group1', 'ASC')
            ->get();

        // Ambil daftar nasabah berdasarkan kode_group1 & tgl_realisasi
        $data_nasabah = DB::connection('mysql_secondary')->table('kredit AS A')
            ->select('A.kode_group1', 'A.tgl_realisasi', 'C.NAMA_NASABAH', 'C.nasabah_id','C.ALAMAT')
            ->join('nasabah AS C', 'A.nasabah_id', '=', 'C.nasabah_id')
            ->where('A.pokok_saldo_akhir', '>', 0)
            ->get()
            ->groupBy(function ($item) {
                return $item->kode_group1 . '_' . $item->tgl_realisasi; // Gabungkan kode_group1 & tgl_realisasi sebagai key unik
            });

        // Tambahkan sub-array 'nasabah_list' ke dalam $data_kelompok
        $data_kelompok = $data_kelompok->map(function ($item) use ($data_nasabah) {
        $key = $item->kode_group1 . '_' . $item->tgl_realisasi;
        $item->nasabah_list = $data_nasabah[$key] ?? []; // Ambil nasabah sesuai kode_group1 & tgl_realisasi
            return $item;
        });

        $data = [
            'data_kelompok' => $data_kelompok,
            'hari_bahasa' => $hari_bahasa,
            'cabang' => $cabang
        ];


        return view('lainnya.pdf-hadir-rat', $data);
    }

    public function pdfTanggapanRat(): View
    {
        $hari = $_GET["hari"];
        $cabang = $_GET["cabang"];
        
        if($hari == '02'){
            $hari_bahasa = 'Senin';
        }else if($hari == '03'){
            $hari_bahasa = 'Selasa';
        }else if($hari == '04'){
            $hari_bahasa = 'Rabu';
        }else if($hari == '05'){
            $hari_bahasa = 'Kamis';
        }else if($hari == '06'){
            $hari_bahasa = 'Jumat';
        }else{
            $hari_bahasa = 'Minggu';
        }

        // Ambil data kelompok kredit (group1)
        $data_kelompok = DB::connection('mysql_secondary')->table('kredit AS A')
            ->select('B.deskripsi_group1', 'A.kode_group1', 'A.tgl_realisasi')
            ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')
            ->where('A.pokok_saldo_akhir', '>', 0)
            ->whereRaw('DAYOFWEEK(A.tgl_realisasi) = ?', [$hari])
            ->where('A.kode_kantor', $cabang)
            ->groupBy('B.deskripsi_group1', 'A.kode_group1', 'A.tgl_realisasi')
            ->orderBy('B.deskripsi_group1', 'ASC')
            ->get();

        // Ambil daftar nasabah berdasarkan kode_group1 & tgl_realisasi
        $data_nasabah = DB::connection('mysql_secondary')->table('kredit AS A')
            ->select('A.kode_group1', 'A.tgl_realisasi', 'C.NAMA_NASABAH', 'C.nasabah_id','C.ALAMAT')
            ->join('nasabah AS C', 'A.nasabah_id', '=', 'C.nasabah_id')
            ->where('A.pokok_saldo_akhir', '>', 0)
            ->get()
            ->groupBy(function ($item) {
                return $item->kode_group1 . '_' . $item->tgl_realisasi; // Gabungkan kode_group1 & tgl_realisasi sebagai key unik
            });

        // Tambahkan sub-array 'nasabah_list' ke dalam $data_kelompok
        $data_kelompok = $data_kelompok->map(function ($item) use ($data_nasabah) {
        $key = $item->kode_group1 . '_' . $item->tgl_realisasi;
        $item->nasabah_list = $data_nasabah[$key] ?? []; // Ambil nasabah sesuai kode_group1 & tgl_realisasi
            return $item;
        });

        $data = [
            'data_kelompok' => $data_kelompok,
            'hari_bahasa' => $hari_bahasa,
            'cabang' => $cabang
        ];


        return view('lainnya.pdf-tanggapan-rat', $data);
    }

    public function bagiBeras(Request $request): View
    {
        $menu_aktif = '/bagiBeras||/lainnya';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        $data = [
            'menu' => 'Bagi Beras',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('lainnya.bagi-beras', $data);
    }

    public function importExcelBagiBeras(Request $request)
    {
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);

        $sheet = $spreadsheet->getActiveSheet();
        $data_excel = $sheet->toArray();

        $queryData = DB::connection('mysql_secondary')->table('kredit AS A')
            ->join('kre_kode_group1 as B', 'A.kode_group1', '=', 'B.kode_group1')
            ->join('nasabah as C', 'A.nasabah_id', '=', 'C.nasabah_id') 
            ->select('A.kode_group1', 'A.tgl_realisasi', 'C.NAMA_NASABAH', 'C.alamat', 'B.deskripsi_group1','A.nasabah_id') // Ambil data nasabah yang diinginkan
            ->where('A.pokok_saldo_akhir', '>', 0)
            ->get();

        // Memasukkan data query ke dalam setiap baris data_excel
        foreach (array_slice($data_excel, 1) as $key => $row) {
            // Misalkan 'KELOMPOK' adalah kolom pertama dalam array Excel
            $kode_group1 = $row[0]; // Sesuaikan dengan kolom yang tepat
            
            // Ambil semua data query yang sesuai berdasarkan kode_group1
            $additionalData = $queryData->where('deskripsi_group1', $kode_group1)->all(); // Mengambil semua data yang cocok
        
            // Jika ada data tambahan, tambahkan ke dalam baris Excel sebagai sub-array
            if ($additionalData) {
                $data_excel[$key]['additional_data'] = $additionalData; // Menambahkan semua data ke dalam array
            } else {
                $data_excel[$key]['additional_data'] = null; // Jika tidak ditemukan, beri nilai null
            }
        }
        $data_excel = array_slice($data_excel, 1);
        $data = [
            'list_data' => $data_excel
        ];

        // dd($data);

        return view('lainnya.pdf-bagi-beras', $data);

        // // Proses data Excel
        // foreach ($data as $row) {
        //     // Misalnya, simpan ke database
        //     DB::table('your_table')->insert([
        //         'column1' => $row[0],
        //         'column2' => $row[1],
        //     ]);
        // }

        // return back()->with('success', 'Data imported successfully!');
    }
   
}
