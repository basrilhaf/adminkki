<!DOCTYPE html>
<html lang="en">
<style>
    td{
        padding-left:3px;
    }
   table {
    border-left: 0.1em solid #0a0808;
    border-right: 0;
    border-top: 0.1em solid #0a0808;
    border-bottom: 0;
    /*border-collapse: collapse;*/
    border-color: black;
    border-spacing: 0;
}
table td,
table th {
    text-align: center;
    border-left: 0;
    border-right: 0.1em solid #0a0808;
    border-top: 0;
    border-bottom: 0.1em solid #0a0808;
    border-spacing: 0;
}
.w-11{
    padding-right: 4px;
    width: 160px;
    height: 20px;
    text-align: center;
    font-size:14px;
}
.w-111{
    padding-right: 4px;
    width: 100px;
    height: 20px;
    text-align: center;
    font-size:14px;
}
.w-100{
    padding-right: 4px;
    width: 110;
    height: 20px;
    text-align: center;
    font-size:14px;
}
.w-1{
    padding-right: 4px;
    width: 160px;
    height: 20px;
    text-align: center;
    font-size:14px;
}
.w-12{
    padding-right: 4px;
    width: 150px;
    height: 20px;
    text-align: center;
    font-size:14px;
}
.w-2{
     font-size:14px;
   width: 70px;
    height: 20px; 
}
.w-60{
     font-size:14px;
   width: 60px;
    height: 20px; 
}
.w-22{
     font-size:14px;
   width: 50px;
    height: 20px; 
}

.w-221{
     font-size:14px;
   width: 30px;
    height: 20px; 
}
.w-3{
     font-size:14px;
   width: 70px;
    height: 20px; 
}
.tr{
    text-align:right;
}
.tl{
    text-align:left;
}
</style>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Masalah Per Cabang</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
       
    <style>
        body{
            color:black;
        }
            .by{
                font-size:12px;
            }
        </style>
        
        <!-- Begin Page Content -->
        <div id="pdfdiv" class="container-fluid">
            <!-- DataTales Example -->
            <div class="row" style="display:inline-block;">
                <div class="col-md-12">
                    <div class="card" style="color:black;">
                        <div class="card-body">
                            <div class="form-group">
                               <h4 style="text-align:center; margin-block-start: 0.3em;margin-block-end: 0.5em;">DETAILS ANGGOTA-KELOMPOK BERMASALAH</h4>
                               <h4 style="text-align:center; margin-block-start: 0.5em;margin-block-end: 1em;">CABANG <?php echo $cabang;?> - <?php echo date("d-m-Y", strtotime($awal)) ;?> S/D <?php echo date("d-m-Y", strtotime($akhir)) ?></h4>
                            </div>
                            
                            <div style="display:inline-block;">
                                <table class="table-bordered table-responsive-sm" style="margin-top:1px;border-top:none; border-left:none;" >
                                    <tbody style="">
                                        <tr>
                                            <td colspan="9" style="border-top:none; border-left:none" class="tl"><b>Jumlah Anggota DTR: <?php echo $total_ab;?></b></td>
                                            <td colspan="3" style="background-color:#c3ebb2; border-top: 0.1em solid #0a0808;">History</td>
                                            <td colspan="9" style="border-top:none; border-left:none; border-right:none;" class="tl"></td>
                                        </tr>
                                        <tr style="background-color:#c3ebb2;">
                                            <td class="w-22" style="border-left: 0.1em solid #0a0808;">No</td>
                                            <td class="w-100">Tanggal</td>
                                            <td class="w-2">ID</td>
                                            <td class="w-12">Anggota</td>
                                            <td class="w-12">Kelompok</td>
                                            <td class="w-22">DTR</td>
                                            <td class="w-22">Set Ke-</td>
                                            <td class="w-60">Mnt Telat</td>
                                            <td class="w-2">PKP FSsK</td>
                                            <td class="w-221">2</td>
                                            <td class="w-221">4A</td>
                                            <td class="w-221">4B</td>
                                            <td class="w-22">Kunjungan</td>
                                        </tr>
                                        
                                        <?php
                                        $no = 0;
                                        foreach($list_ab as $la){
                                            $no++;
                                            if($la->dikunjungi_ab=="1"){
                                                $kunjung = "Sudah";
                                            } else {
                                                $kunjung = "Belum";
                                            }
                                            ?>
                                            <tr>
                                                <td style="border-left: 0.1em solid #0a0808;" class="w-22">{{$no}}</td>
                                                <td class="tr w-100"><?php echo date("j M", strtotime($la->tanggal_ab));?></td>
                                                <td class="tr w-2">{{$la->id_anggota_ab}}</td>
                                                <td class="tl w-12" style="font-size:12px;">{{$la->nama_ab}}</td>
                                                <td class="tl w-12" style="font-size:12px;">{{$la->kelompok_ab}}</td>
                                                <td class="tr w-22">{{$la->kode_ab}}</td>
                                                <td class="tr w-22">{{$la->setoran_ab}}</td>
                                                <td class="w-60">{{$la->menit_ab}}</td>
                                                <td class="tl w-2" style="font-size:12px;"><?php echo substr($la->nama, 0, 10);?></td>
                                                <td class="tr w-221">{{$la->kode2}}</td>
                                                <td class="tr w-221">{{$la->kode4a}}</td>
                                                <td class="tr w-221">{{$la->kode4b}}</td>
                                                <td class="w-22">{{$kunjung}}</td>
                                            </tr>
                                        <?php }?>
                                       
                                    </tbody>
                                </table>
                                
                                <table class="table-bordered table-responsive-sm" style="margin-top:20px; border-top:none; border-left:none;" >
                                    <tbody>
                                        <tr>
                                            <td colspan="13" style="border:none;" class="tl"><b>JUMLAH KELOMPOK TELAT: <?php echo $jum_telat;?></b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="13" style="border-top:none; border-left:none;border-right:none" class="tl"><b>JUMLAH KELOMPOK BERAT: <?php echo $jum_berat;?></b></td>
                                        </tr>
                                        <tr style="background-color:#c3ebb2;">
                                            <td style="border-left: 0.1em solid #0a0808;" class="w-22">No</td>
                                            <td class="w-100">Tanggal</td>
                                            <td class="w-22">Cabang</td>
                                            <td class="w-1">Kelompok</td>
                                            <td class="w-22">Set Ke</td>
                                            <td class="w-22">Kode</td>
                                            <td class="w-100">Mnt Telat</td>
                                            <td class="w-22">Tlt</td>
                                            <td class="w-22">Brt</td>
                                            <td class="w-111">PKP proses</td>
                                            <td class="w-111">KC proses</td>
                                            <td class="w-111">PKP FSK</td>
                                            <td class="w-100">Dikumpulkan</td>
                                        </tr>
                                        <?php
                                        $no=0;
                                        foreach($list_kb as $lk){
                                            if($lk->dikumpulkan_kb=="1"){
                                                $kumpul = "Sudah";
                                            } else {
                                                $kumpul = "Belum";
                                            }
                                        $no++;
                                        ?>
                                            <tr>
                                                <td style="border-left: 0.1em solid #0a0808;" class="w-22">{{$no;}}</td>
                                                <td class="w-100 tr"><?php echo date("j M", strtotime($lk->tanggal_kb));?></td>
                                                <td class="w-22">{{$lk->cabang_kb}}</td>
                                                <td class="w-1 tl">{{$lk->kelompok_kb}}</td>
                                                <td class="w-22">{{$lk->setoran_kb}}</td>
                                                <td class="w-22">{{$lk->kode_kb}}</td>
                                                <td class="w-100 tr">{{$lk->menit_kb}}</td>
                                                <td class="w-22">{{$lk->telat}}</td>
                                                <td class="w-22">{{$lk->berat}}</td>
                                                <td class="w-111 tl">{{$lk->pkp_dkb}}</td>
                                                <td class="w-111 tl">{{$lk->kc_dkb}}</td>
                                                <td class="w-111 tl">{{$lk->nama}}</td>
                                                <td class="w-100">{{$kumpul}}</td>
                                            </tr>
                                        <?php }?>
                                       
                                    </tbody>
                                </table>
                            </div>
                            
                            
                            
                            
                            
                        </div>  
                    </div>
                </div>
            </div>
        <!-- /.container-fluid -->

        </div>
      <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


</html>

   
   
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    
</body>
