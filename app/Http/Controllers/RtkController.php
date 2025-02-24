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



class RtkController extends Controller
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

    public function tarikRtk(Request $request): View
    {
        $menu_aktif = '/tarikRtk||/rtk';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        $data = [
            'menu' => 'Tarik RTK',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => ''
        ];
        
        return view('rtk.tarik-rtk', $data);
    }

    
    public function detailRtk(Request $request)
    {
        $menu_aktif = '/tarikRtk||/rtk';
        $navbar = $this->dataService->getMenuHTML($menu_aktif, Session::getFacadeRoot());

        $id = $_GET['id'];
        $detail = DB::table('rtk_master')
                ->select('*')
                ->where('id', $id)
                ->first();

        $data = [
            'menu' => 'Detail RTK',
            'menu_aktif' => $menu_aktif,
            'navbar' => $navbar,
            'breadcrumb' => '',
            'detail' => $detail,
            'id' => $id
        ];
        
        return view('rtk.detail-rtk', $data);
    }

    
    public function updateRtkAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'no_kelompok' => 'required',
            'id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $update = DB::table('rtk_master')
                        ->where('id', $request->id)
                        ->update([
                                'no_kelompok'     => $request->no_kelompok,
                                'nama_kelompok'  => $request->nama_kelompok,
                                'nama_kelompok_rtk'     => $request->nama_kelompok_rtk,
                                'jumlah_anggota'  => $request->jumlah_anggota,
                                'setsus'     => $request->cicilan_setsus,
                                'cabang'  => $request->cabang,
                                'hari'     => $request->hari,
                                'btab_btk'  => $request->btab_btk,
                                'durasi'     => $request->durasi,
                                'set_mingguan_rtk'  => $request->setoran_mingguan_rtk,
                                'set_khusus'     => $request->setoran_khusus,
                                'set_ke_rtk'  => $request->setoran_ke_rtk,
                                'set_mingguan_sikki'     => $request->setoran_mingguan_sikki,
                                'set_ke_sikki'  => $request->setoran_ke_sikki
                        ]);


        $this->dataService->createAuditTrail('Edit Data RTK');

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Berhasil update RTK']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update RTK']);
        }
    }
    
    
    public function deleteRtkAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $deleted = DB::table('rtk_master')->where('id', $request->id)->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Berhasil hapus rtk']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal hapus rtk']);
        }
    }

    public function getTableRtk(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Session::get('cabang');
            $id_user = Session::get('id_user2');
            $tanggal = $request->input('tanggal');
            $hari = $request->input('hari');
            $cabang = $request->input('cabang');

            $query = DB::table('rtk_master')
                ->select('*')
                ->where('hari', $hari)
                ->where('cabang',$cabang)
                ->orderBy('id', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()  // This is for the row index numbering
                ->addColumn('action', function ($row) {
                    $infoUrl = route('user.infoUser', $row->id);
                    $editUrl = route('detailRtk');

                    $btn = "<a href=" . $editUrl ."?id=".$row->id." class='btn btn-light-warning btn-sm'><span class='fa fa-pencil'></span></a> ";
                    $btn .= '<button title="HAPUS" class="btn btn-danger btn-delete-rtk btn-sm" data-id="' . $row->id . '"><span class="fa fa-trash"></span></button>';
                    return $btn;
                })

                ->addColumn('acuan', function ($row) {
                    // BTK
                    if($row->btab_btk=="BTK"){
                        if($row->durasi=="25"){
                            if($row->setsus=="50"){
                                if($row->set_ke_rtk>=19){
                                   $set_next = "19.2"; 
                                   $acuan = ((($row->set_mingguan_rtk*20)/100)*2)/1000;
                                } else {
                                   $set_next = $row->set_ke_rtk + ($row->setsus/100); 
                                   $acuan = (($row->set_mingguan_rtk*55)/100)/1000;
                                }
                            } else {
                                if($row->set_ke_rtk==18.5){
                                    $set_next = "19.2";
                                    $acuan = (($row->set_mingguan_rtk*70)/100)/1000;
                                } else if($row->set_ke_rtk==19){
                                    $set_next = "19.2";
                                    $acuan = (($row->set_mingguan_rtk*20)/100)/1000;
                                } else {
                                    $set_next = $row->set_ke_rtk + ($row->setsus/100); 
                                    $acuan = $row->set_mingguan_rtk/1000;
                                }
                                
                            }   
                        } else if($row->durasi=="80"){
                            if($row->setsus=="50"){
                                if($row->set_ke_rtk>=64){
                                   $set_next = "64.4"; 
                                   $acuan = ((($row->set_mingguan_rtk*40)/100)*2)/1000;
                                } else {
                                   $set_next = $row->set_ke_rtk + ($row->setsus/100); 
                                   $acuan = (($row->set_mingguan_rtk*60.8695652173913)/100)/1000;
                                }
                            } else {
                                if($row->set_ke_rtk==64){
                                    $set_next = "64.4";
                                    $acuan = (($row->set_mingguan_rtk*40)/100)/1000;
                                } else if($row->set_ke_rtk==63.5){
                                    $set_next = "64.4";
                                    $acuan = (($row->set_mingguan_rtk*90)/100)/1000;
                                } else {
                                    $set_next = $row->set_ke_rtk + ($row->setsus/100); 
                                    $acuan = $row->set_mingguan_rtk/1000;
                                }
                                
                            }
                            // BTK 40 minggu
                        } else {
                            if($row->setsus=="50"){
                                $set_next = $row->set_ke_rtk + ($row->setsus/100);
                                $acuan = (($row->set_mingguan_rtk*57.5)/100)/1000;
                            } else if($row->setsus=="25"){
                                $set_next = $row->set_ke_rtk + ($row->setsus/100);
                                $acuan = (($row->set_mingguan_rtk*32.5)/100)/1000;
                            } else {
                                
                            
                            
                            $set_next = $row->set_ke_rtk + ($row->setsus/100); 
                            $acuan = $row->set_mingguan_rtk/1000; 
                                
                            }
                        }
                                                                        
                    } else {
                        // BTAB
                        $set_next = $row->set_ke_rtk + ($row->setsus/100);
                        if($row->durasi=="25"){
                            if($row->setsus=="25"){
                                $acuan = (($row->set_mingguan_rtk*30)/100)/1000;
                            } else if($row->setsus=="50"){
                                $acuan = (($row->set_mingguan_rtk*55)/100)/1000;
                            } else {
                                $acuan = (($row->set_mingguan_rtk*100)/100)/1000;
                            }
                            
                            
                        } else if($row->durasi=="40"){
                           if($row->setsus=="25"){
                                $acuan = (($row->set_mingguan_rtk*32.5)/100)/1000;
                            } else if($row->setsus=="50"){
                                $acuan = (($row->set_mingguan_rtk*57.5)/100)/1000;
                            } else {
                                $acuan = (($row->set_mingguan_rtk*100)/100)/1000;
                            } 
                            
                        } else if($row->durasi=="80"){
                            if($row->setsus=="50"){
                                $acuan = (($row->set_mingguan_rtk*60.8695652173913)/100)/1000;
                            
                            } else {
                                $acuan = (($row->set_mingguan_rtk*100)/100)/1000;
                            } 
                        } else {
                            $acuan = $row->set_mingguan_rtk/1000;
                        }
                    }
                    $acuan = $acuan*1000;
                    $html = 'Acuan: '.$acuan.'<br> Set Ke- Minggu Depan: '.$set_next;

                    return $html;
                })

                ->addColumn('kelompk_html', function ($row) {
                    $html = 'Nomor: '.$row->no_kelompok.'<br>Kelompok RTK: '.$row->nama_kelompok_rtk.'<br> Kelompok USSI: '.$row->nama_kelompok.'<br> Jumlah Anggota: '.$row->jumlah_anggota;
                    
                    return $html;
                })
                ->addColumn('cabang_hari', function ($row) {
                    $html = 'Cabang: '.$row->cabang.'<br>Hari: '.$row->hari;

                    return $html;
                })

                ->addColumn('setoran_mingguan', function ($row) {
                    $html = 'Set Mingguan RTK: '.$row->set_mingguan_rtk.'<br>Set Khusus RTK: '.$row->set_khusus.'<br>Set Ke RTK: '.$row->set_ke_rtk.'<br>Cicilan Setsus: '.$row->setsus;

                    return $html;
                })
               
                ->rawColumns(['action','acuan','kelompk_html','cabang_hari','setoran_mingguan'])
                ->make(true);
        }
    }

    public function pdfRtk(): View
    {
        $tanggal = $_GET["tanggal"];
        $hari = $_GET["hari"];
        $cabang = $_GET["cabang"];

        $rtk = DB::table('rtk_master')
            ->select('*')
            ->where('hari', $hari)
            ->where('cabang',$cabang)
            ->orderBy('no_kelompok', 'asc')->get();

        if($cabang=='1'){
            $nama_c = 'Cilincing Marunda';
        } else if($cabang=='2'){
            $nama_c = 'Koja';
        } else if($cabang=='3'){
            $nama_c = 'Tipar';
        } else if($cabang=='4'){
            $nama_c = 'Priok';
        } else if($cabang=='5'){
            $nama_c = 'Cakung';
        } else if($cabang=='7'){
            $nama_c = 'Sukapura';
        } else {
            $nama_c = '';
        }
        
        $data = [
            'tanggal' =>$tanggal,
            'hari' => $hari,
            'cabang' => $cabang,
            'rtk' => $rtk,
            'nama_c' => $nama_c
        ];

        return view('rtk.pdf-rtk', $data);
    }

    
    public function pdfPjk(): View
    {
        $tanggal = $_GET["tanggal"];
        $hari = $_GET["hari"];
        $cabang = $_GET["cabang"];

        // Ambil data RTK dari database
        $rtk = DB::table('rtk_master')
            ->select('*')
            ->where('hari', $hari)
            ->where('cabang', $cabang)
            ->orderBy('urutan', 'asc')
            ->get();

        // Proses data untuk mendapatkan nilai kas
        $rtk = $rtk->map(function ($item) {
            $nama_kel = $item->no_kelompok." ".$item->nama_kelompok_rtk;
            // dd($nama_kel);
            // Query ke kelompok_bermasalah berdasarkan nama_kelompok
            $data_mas = DB::table('kelompok_bermasalah')
                ->selectRaw("
                    kelompok_kb,
                    COUNT(id_kb) as jumlah,
                    IFNULL(SUM(IF(kode_kb = '3A', 1, 0)), 0) AS kode3a,
                    IFNULL(SUM(IF(kode_kb = '3B', 1, 0)), 0) AS kode3b
                ")
                ->where('kelompok_kb', $nama_kel)
                ->groupBy('kelompok_kb')
                ->first(); // Ambil satu hasil
        
            // Jika data kosong, set default ke 0
            $brt = $data_mas->kode3b ?? 0;
            $tlt = $data_mas->kode3a ?? 0;
        
            // Tentukan nilai kas
            $kas = "B{$brt} / T{$tlt}"; // Menampilkan B0 / T0 jika nilai 0
        
            // Tambahkan nilai kas ke dalam objek RTK
            $item->kas = $kas;
        
            return $item;
        });

        // Ambil catatan PJK
        $catatan = DB::table('catatan_pjk')
            ->select('*')
            ->where('hari_c', $hari)
            ->where('cabang_c', $cabang)
            ->orderBy('id_c', 'asc')
            ->get();

        // Menentukan nama cabang berdasarkan kode cabang
        $cabang_map = [
            '1' => 'Cilincing Marunda',
            '2' => 'Koja',
            '3' => 'Tipar',
            '4' => 'Priok',
            '5' => 'Cakung',
            '7' => 'Sukapura',
        ];

        $nama_c = $cabang_map[$cabang] ?? '';

        // Data yang akan dikirim ke view
        $data = [
            'tanggal' => $tanggal,
            'hari' => $hari,
            'cabang' => $cabang,
            'pjk' => $rtk,
            'nama_c' => $nama_c,
            'catatan' => $catatan
        ];

        return view('rtk.pdf-pjk', $data);
    }


    
    public function pdfSetsus(): View
    {
        $tanggal = $_GET["tanggal"];
        $hari = $_GET["hari"];
        $cabang = $_GET["cabang"];

        $rtk = DB::table('rtk_master')
            ->select('*')
            ->where('hari', $hari)
            ->where('cabang',$cabang)
            ->orderBy('no_kelompok', 'asc')->get();

        if($cabang=='1'){
            $nama_c = 'Cilincing Marunda';
        } else if($cabang=='2'){
            $nama_c = 'Koja';
        } else if($cabang=='3'){
            $nama_c = 'Tipar';
        } else if($cabang=='4'){
            $nama_c = 'Priok';
        } else if($cabang=='5'){
            $nama_c = 'Cakung';
        } else if($cabang=='7'){
            $nama_c = 'Sukapura';
        } else {
            $nama_c = '';
        }
        
        $data = [
            'tanggal' =>$tanggal,
            'hari' => $hari,
            'cabang' => $cabang,
            'setsus' => $rtk,
            'nama_c' => $nama_c
        ];

        return view('rtk.pdf-setsus', $data);
    }

    
    public function setoranKeAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'hari' => 'required',
            'cabang' => 'required',
        ]);
        $hari = $request->hari;
        $cabang = $request->cabang;

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $rtk = DB::table('rtk_master')
            ->select('*')
            ->where('hari', $hari)
            ->where('cabang',$cabang)
            ->orderBy('no_kelompok', 'asc')->get();

        foreach($rtk as $rows){
            
            $id_rtk = $rows->id;
            $setsus = $rows->setsus / 100;
            $set_ke = $rows->set_ke_rtk + $setsus;
            
            // BTK
            if($rows->btab_btk=="BTK"){
                if($rows->durasi=="25"){
                    if($rows->setsus=="50"){
                        if($rows->set_ke_rtk>=19){
                            $set_next = "19.2"; 
                        } else {
                            $set_next = $rows->set_ke_rtk + ($rows->setsus/100); 
                        }
                    } else {
                        if($rows->set_ke_rtk==18.5){
                            $set_next = "19.2";
                        } else if($rows->set_ke_rtk==19){
                            $set_next = "19.2";
                        } else {
                            $set_next = $rows->set_ke_rtk + ($rows->setsus/100); 
                        }
                                                            
                    }   
                } else if($rows->durasi=="80"){
                    if($rows->setsus=="50"){
                        if($rows->set_ke_rtk>=64){
                            $set_next = "64.4"; 
                        } else {
                            $set_next = $rows->set_ke_rtk + ($rows->setsus/100); 
                        }
                    } else {
                        if($rows->set_ke_rtk==64){
                            $set_next = "64.4";
                        } else if($rows->set_ke_rtk==63.5){
                            $set_next = "64.4";
                        } else {
                            $set_next = $rows->set_ke_rtk + ($rows->setsus/100); 
                        }    
                    }
                } else {
                    $set_next = $rows->set_ke_rtk + ($rows->setsus/100); 
                }
            } else {
                $set_next = $rows->set_ke_rtk + ($rows->setsus/100);
            }
            
            $update = DB::table('rtk_master')
                        ->where('id', $id_rtk)
                        ->update([
                                'set_ke_rtk'     => $set_next,
                                'set_ke_sikki'  => $set_next
                        ]);
        
        }


        $this->dataService->createAuditTrail('Ubah Setoran + 1');

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Berhasil update set ke +1']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update set ke +1']);
        }
    }


    
    public function setoranKeMinusAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'hari' => 'required',
            'cabang' => 'required',
        ]);
        $hari = $request->hari;
        $cabang = $request->cabang;

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $rtk = DB::table('rtk_master')
            ->select('*')
            ->where('hari', $hari)
            ->where('cabang',$cabang)
            ->orderBy('no_kelompok', 'asc')->get();

        foreach($rtk as $rows){
            
            $id_rtk = $rows->id;
            $setsus = $rows->setsus / 100;
            $set_ke = $rows->set_ke_rtk - $setsus;
            
            $update = DB::table('rtk_master')
                        ->where('id', $id_rtk)
                        ->update([
                                'set_ke_rtk'     => $set_ke,
                                'set_ke_sikki'  => $set_ke
                        ]);
        
        }

        $this->dataService->createAuditTrail('Ubah Setoran - 1');

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Berhasil update set ke -1']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal update set ke -1']);
        }
    }

    
    public function importExcelRtk(Request $request)
    {
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);

        $sheet = $spreadsheet->getActiveSheet();
        $data_excel = $sheet->toArray();
        
        foreach (array_slice($data_excel, 1) as $key => $row) {

            $no_kelompok = $row[3];
            $nama_kelompok = $row[4];
            $cabang = $row[2];
            $hari = $row[1];
            $cicilan_setsus = $row[9];
            $setoran_mingguan_rtk = $row[7];
            $setoran_ke = $row[6];
            $btab_btk = $row[8];
            $durasi = $row[5];
        
            $set_khusus = ($setoran_mingguan_rtk * $cicilan_setsus) / 100;

            $save = DB::table('rtk_master')->insert([
                'no_kelompok'        => $no_kelompok,
                'nama_kelompok_rtk'  => $nama_kelompok,
                'cabang' => $cabang,
                'hari'        => $hari,
                'btab_btk'  => $btab_btk,
                'setsus'  => $cicilan_setsus,
                'set_mingguan_rtk'  => $setoran_mingguan_rtk,
                'set_ke_rtk'  => $setoran_ke,
                'set_khusus'  => $set_khusus,
                'durasi_rtk'  => $durasi,
                'urutan'  => $setoran_ke
            ]);
        }

        $this->dataService->createAuditTrail('Upload rtk');
        if($save){
            return redirect()->route('tarikRtk')->with('success', 'RTK berhasil diimport');
        }else{
            return redirect()->route('tarikRtk')->with('error', 'RTK gagal diimport');
        }
        
    }

    
    public function importExcelRtkUssi(Request $request)
    {
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);

        $sheet = $spreadsheet->getActiveSheet();
        $data_excel = $sheet->toArray();
        
        foreach (array_slice($data_excel, 1) as $key => $row) {

            $no_kelompok     = $row[1];
            $nama_kelompok   = $row[2];
            $jumlah_anggota  = $row[3];
            $durasi  = $row[4];
            $setoran_mingguan_sikki  = $row[5];
            $set_ke_sikki = $row[5];

            $save = DB::table('rtk_master')
            ->where('no_kelompok', $no_kelompok)
            ->update([
                'nama_kelompok'     => $nama_kelompok,
                'jumlah_anggota'  => $jumlah_anggota,
                'durasi'        => $durasi,
                'set_mingguan_sikki'  => $setoran_mingguan_sikki,
                'set_ke_sikki'  => $set_ke_sikki
            ]);

        }

        $this->dataService->createAuditTrail('Upload rtk dari ussi');
        if($save){
            return redirect()->route('tarikRtk')->with('success', 'RTK USSI berhasil diimport');
        }else{
            return redirect()->route('tarikRtk')->with('error', 'RTK USSI gagal diimport');
        }
        
    }




   
}
