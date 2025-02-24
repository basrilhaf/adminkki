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
    height: 22px;
    text-align: center;
    font-size:12px;
}
.w-111{
    padding-right: 4px;
    width: 120px;
    height: 22px;
    text-align: center;
    font-size:22px;
}
.w-1{
    padding-right: 4px;
    width: 180px;
    height: 22px;
    text-align: center;
    font-size:12px;
}
.w-12{
    padding-right: 4px;
    width: 140px;
    height: 22px;
    text-align: center;
    font-size:12px;
}
.w-2{
     font-size:12px;
   width: 75px;
    height: 22px; 
}
.w-22{
     font-size:12px;
   width: 35px;
    height: 22px; 
}

.w-221{
     font-size:12px;
   width: 30px;
    height: 22px; 
}
.w-3{
     font-size:12px;
   width: 70px;
    height: 22px; 
}
</style>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>KKI</title>

 


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
        <?php
        
        $t=explode("-",$tanggal);
        if($t[1]=="01"){
            $bln="Jan";
        } else if($t[1]=="02"){
            $bln="Feb";
        } else if($t[1]=="03"){
            $bln="Mar";
        } else if($t[1]=="04"){
            $bln="Apr";
        } else if($t[1]=="05"){
            $bln="Mei";
        } else if($t[1]=="06"){
            $bln="Jun";
        } else if($t[1]=="07"){
            $bln="Jul";
        } else if($t[1]=="08"){
            $bln="Ags";
        } else if($t[1]=="09"){
            $bln="Sep";
        } else if($t[1]=="10"){
            $bln="Okt";
        } else if($t[1]=="11"){
            $bln="Nov";
        } else if($t[1]=="12"){
            $bln="Des";
        } else {
            $bln="";
        }
        
        ?>
        <!-- Begin Page Content -->
        <div id="pdfdiv" class="container-fluid">
            <!-- DataTales Example -->
            <div class="row" style="display:inline-block;">
                <div class="col-md-12">
                    <div class="card" style="color:black;">
                        <div class="card-body">
                            <div class="form-group">
                               <h3 style="text-align:center; ">RTK SetSus - Lembar 1</h3>
                            </div>
                            <div style="display:block; margin-bottom:0px;">
                                <table style="border:none; font-size:13px;">
                                    <tbody style="margin-top:-5px;">
                                    <tr style="height:16px;">
                                        <td style="border:none;">Cabang:</td>
                                        <td style="border:none; width:100px;"><?php echo $cabang;?> - <?php echo $nama_c;?></td>
                                        <td style="border:none; width:20px;"></td>
                                        <td style="border:none;">Tanggal:</td>
                                        <td style="border:none; width:100px;"><?php echo $t[2];?>-<?php echo $bln;?>-<?php echo $t[0];?></td>
                                        <td style="border:none; width:20px;"></td>
                                        <td style="border:none;">Hari:</td>
                                        <td style="border:none; width:100px;"><?php echo $hari;?></td>
                                        <td style="border:none; width:95px;"></td>
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808;"><b>Angka dlm 000 Rp</b></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="display:inline-block;">
                                <table class="table-bordered table-responsive-sm" style="font-size:12px; margin-top:1px;" >
                                    <tbody>
                                        <tr style="background-color:#c3ebb2;">
                                            <td class="w-221" rowspan="2">Urut</td>
                                            <td class="w-11" colspan="2">Kumpulan</td>
                                            <td class="w-22" rowspan="2">Nama PKP</td>
                                            <td class="w-1" colspan="5">Setoran Mingguan</td>
                                            <td class="w-22" rowspan="2">Kd Byr Khusus</td>
                                            <td class="w-22" rowspan="2" style="border: 0.2em solid #0a0808;">Jml Uang ke kasir</td>
                                            <td class="w-2" colspan="6" style="border-left: 0.2em solid #0a0808;">Pencairan & BTAB</td>
                                        </tr>
                                        <tr style="background-color:#c3ebb2;">
                                            <td>No</td>
                                            <td class="w-1">Nama</td>
                                            <td>Set ke-</td>
                                            <td>% pilih</td>
                                            <td>Acuan</td>
                                            <td class="w-22" >Jumlah Cicilan</td>
                                            <td class="w-22" >Keteran gan</td>
                                            <td class="w-22"  style="border-left: 0.2em solid #0a0808;">Pinjaman Dicairkan</td>
                                            <td>TSA</td>
                                            <td>Simjib</td>
                                            <td class="w-22">T. Wajib Cair</td>
                                            <td class="w-22">Paraf PCR</td>
                                            <td class="w-22">Paraf BTAB</td>
                                        </tr>
                                         <?php 
                                            $i = 0;
                                            $total = 0;
                                            $total2= 0;
                                            $total3 = 0;
                                            foreach($setsus as $rows)
                                            { 
                                            $i++;
                                             // BTK
                                            if($rows->btab_btk=="BTK"){
                                                if($rows->durasi=="25"){
                                                    if($rows->setsus=="50"){
                                                        if($rows->set_ke_rtk>=19){
                                                           $set_next = "19.2"; 
                                                           $acuan = ((($rows->set_mingguan_rtk*20)/100)*2)/1000;
                                                        } else {
                                                           $set_next = $rows->set_ke_rtk + ($rows->setsus/100); 
                                                           $acuan = (($rows->set_mingguan_rtk*55)/100)/1000;
                                                        }
                                                    } else {
                                                        if($rows->set_ke_rtk==18.5){
                                                            $set_next = "19.2";
                                                            $acuan = (($rows->set_mingguan_rtk*70)/100)/1000;
                                                        } else if($rows->set_ke_rtk==19){
                                                            $set_next = "19.2";
                                                            $acuan = (($rows->set_mingguan_rtk*20)/100)/1000;
                                                        } else {
                                                            $set_next = $rows->set_ke_rtk + ($rows->setsus/100); 
                                                            $acuan = $rows->set_mingguan_rtk/1000;
                                                        }
                                                        
                                                    }   
                                                } else if($rows->durasi=="80"){
                                                    if($rows->setsus=="50"){
                                                        if($rows->set_ke_rtk>=64){
                                                           $set_next = "64.4"; 
                                                           $acuan = ((($rows->set_mingguan_rtk*40)/100)*2)/1000;
                                                        } else {
                                                           $set_next = $rows->set_ke_rtk + ($rows->setsus/100); 
                                                           $acuan = (($rows->set_mingguan_rtk*60.8695652173913)/100)/1000;
                                                        }
                                                    } else {
                                                        if($rows->set_ke_rtk==64){
                                                            $set_next = "64.4";
                                                            $acuan = (($rows->set_mingguan_rtk*40)/100)/1000;
                                                        } else if($rows->set_ke_rtk==63.5){
                                                            $set_next = "64.4";
                                                            $acuan = (($rows->set_mingguan_rtk*90)/100)/1000;
                                                        } else {
                                                            $set_next = $rows->set_ke_rtk + ($rows->setsus/100); 
                                                            $acuan = $rows->set_mingguan_rtk/1000;
                                                        }
                                                        
                                                    }
                                                    // BTK 40 minggu
                                                } else {
                                                    if($rows->setsus=="50"){
                                                        $set_next = $rows->set_ke_rtk + ($rows->setsus/100);
                                                        $acuan = (($rows->set_mingguan_rtk*57.5)/100)/1000;
                                                    } else if($rows->setsus=="25"){
                                                        $set_next = $rows->set_ke_rtk + ($rows->setsus/100);
                                                        $acuan = (($rows->set_mingguan_rtk*32.5)/100)/1000;
                                                    } else {
                                                        
                                                    
                                                    
                                                    $set_next = $rows->set_ke_rtk + ($rows->setsus/100); 
                                                    $acuan = $rows->set_mingguan_rtk/1000; 
                                                        
                                                    }
                                                }
                                                                                                
                                            } else {
                                                // BTAB
                                                $set_next = $rows->set_ke_rtk + ($rows->setsus/100);
                                                if($rows->durasi=="25"){
                                                    if($rows->setsus=="25"){
                                                        $acuan = (($rows->set_mingguan_rtk*30)/100)/1000;
                                                    } else if($rows->setsus=="50"){
                                                        $acuan = (($rows->set_mingguan_rtk*55)/100)/1000;
                                                    } else {
                                                        $acuan = (($rows->set_mingguan_rtk*100)/100)/1000;
                                                    }
                                                    
                                                    
                                                } else if($rows->durasi=="40"){
                                                   if($rows->setsus=="25"){
                                                        $acuan = (($rows->set_mingguan_rtk*32.5)/100)/1000;
                                                    } else if($rows->setsus=="50"){
                                                        $acuan = (($rows->set_mingguan_rtk*57.5)/100)/1000;
                                                    } else {
                                                        $acuan = (($rows->set_mingguan_rtk*100)/100)/1000;
                                                    } 
                                                    
                                                } else if($rows->durasi=="80"){
                                                    if($rows->setsus=="50"){
                                                        $acuan = (($rows->set_mingguan_rtk*60.8695652173913)/100)/1000;
                                                    
                                                    } else {
                                                        $acuan = (($rows->set_mingguan_rtk*100)/100)/1000;
                                                    } 
                                                } else {
                                                    $acuan = $rows->set_mingguan_rtk/1000;
                                                }
                                            }
                                            
                                            if($rows->btab_btk=="BTK"){
                                                if($rows->durasi=="40"){
                                                    if($set_next>="31"){
                                                        $kd_byr = "BTK";
                                                    } else {
                                                        $kd_byr = "";
                                                    }
                                                } else if($rows->durasi=="25"){
                                                    if($set_next>="19.2"){
                                                        $kd_byr = "BTK";
                                                    } else {
                                                        $kd_byr = "";
                                                    }
                                                } else if($rows->durasi=="80"){
                                                    if($set_next>="64.4"){
                                                        $kd_byr = "BTK";
                                                    } else {
                                                        $kd_byr = "";
                                                    }
                                                } else {
                                                    $kd_byr = "";
                                                }
                                                
                                            } else {
                                              if($rows->durasi=="40"){
                                                    if($set_next>="40"){
                                                        $kd_byr = "BTAB";
                                                    } else {
                                                        $kd_byr = "";
                                                    }
                                              } else if($rows->durasi=="25"){
                                                    if($set_next>="25"){
                                                        $kd_byr = "BTAB";
                                                    } else {
                                                        $kd_byr = "";
                                                    }
                                                  
                                              } else if($rows->durasi=="80"){
                                                    if($set_next>="80"){
                                                        $kd_byr = "BTAB";
                                                    } else {
                                                        $kd_byr = "";
                                                    }
                                              } else {
                                                  $kd_byr = "";
                                              }    
                                              
                                            }
                                            
                                            
                                            
                                            $total = $total + $acuan;
                                            
                                            
                                            
                                            
                                            
                                            ?>  
                                        <tr style="height:22px;">
                                            <td><?php echo $i;?></td>
                                            <td style="text-align:left;"><?php echo $rows->no_kelompok;?></td>
                                            <td style="text-align:left;"><?php echo $rows->nama_kelompok_rtk;?></td>
                                            <td></td>
                                            <td><?php echo $set_next;?></td>
                                            <td style="text-align:right;"><?php echo $rows->setsus?>%</td>
                                            <td style="text-align:right;"><?php echo $acuan;?></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo $kd_byr;?></td>
                                            <td style="border-left: 0.2em solid #0a0808;"></td>
                                            <td style="border-left: 0.2em solid #0a0808;"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <!--kondisi header-->
                                        <?php
                                        if($i==35 || $i==70):
                                        if($i==35){
                                            $tot = $total;
                                        } else if($i==70){
                                            $tot = $total2+$total;
                                        } else if($i==105){
                                            $tot = $total3+$total2;
                                        }
                                        
                                        ?>
                                        
                                        <tr>
                                            <td colspan="6">Total (selesai/dipindahkan)</td>
                                            <?php if($tot==0){?>
                                            <td></td>
                                            <?php } else {?>
                                            <td><b><?php echo $tot;?></b></td>
                                            <?php }?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="border-left: 0.2em solid #0a0808;"></td>
                                            <td style="border-left: 0.2em solid #0a0808;"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table style="border:none; margin-top:5px; font-size:13px;">
                                    <tbody>
                                        <tr>
                                            <td style="border-right:none; border-bottom:none; text-align:left;">Dibuat oleh:</td>
                                            <td style="width:70px; border-right:none; "></td>
                                            <!--pemisah table-->
                                            <td rowspan="4" style="width:50px; border-bottom:none; border-right:none;"></td>
                                            <!--pemisah-->
                                            <td style="border-right:none; border-bottom:none; text-align:left;">Disetujui Oleh:</td>
                                            <td style="width:70px; border-right:none;"></td>
                                            
                                            <!--pemisah table-->
                                            <td rowspan="4" style="width:50px; border:none;"></td>
                                            <!--pemisah-->
                                            
                                            <td colspan="3" style="border:none; text-align:left; width:200px;">Pemeriksa/Supervisor/Kantor Pusat:</td>
                                            <td style="width:70px; border:none;"></td>
                                        </tr>
                                        <tr>
                                            <td style="border:none; text-align:left;">Kasir</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Kepala Cbg</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Nama 1</td>
                                            <td style="text-align:left; width:70px; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Nama 2</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                        </tr>
                                        <tr>
                                            <td style="border:none; text-align:left;">TTD</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">TTD</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">TTD 1</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">TTD 2</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="border:none; text-align:left;">Tanggal</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Tanggal</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Tgl 1</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Tgl 2</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                        </tr>
                                        <tr>
                                            <td style="border:none; text-align:left; font-size:10px;" colspan="16">Bila ada >1 halaman, tanda tangan langsung dihalaman terakhir.</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php if($i==35){
                                    $lembar_ke = '2';
                                } else if($i==70){
                                    $lembar_ke = '3';
                                }
                                
                                ?>
                                <div class="form-group">
                                   <h3 style="text-align:center; margin-top:40px;">RTK SetSus - Lembar <?php echo $lembar_ke;?></h3>
                                </div>
                            
                                <table class="table-bordered table-responsive-sm" style="font-size:12px; margin-top:20px;" >
                                    <tbody>
                                        <tr style="background-color:#c3ebb2;">
                                            <td class="w-221" rowspan="2">Urut</td>
                                            <td class="w-11" colspan="2">Kumpulan</td>
                                            <td class="w-22" rowspan="2">Nama PKP</td>
                                            <td class="w-1" colspan="5">Setoran Mingguan</td>
                                            <td class="w-22" rowspan="2">Kd Byr Khusus</td>
                                            <td class="w-22" rowspan="2" style="border: 0.2em solid #0a0808;">Jml Uang ke kasir</td>
                                            <td class="w-2" colspan="6" style="border-left: 0.2em solid #0a0808;">Pencairan & BTAB</td>
                                        </tr>
                                        <tr style="background-color:#c3ebb2;">
                                            <td>No</td>
                                            <td class="w-1">Nama</td>
                                            <td>Set ke-</td>
                                            <td>% pilih</td>
                                            <td>Acuan</td>
                                            <td class="w-22" >Jumlah Cicilan</td>
                                            <td class="w-22" >Keteran gan</td>
                                            <td class="w-22"  style="border-left: 0.2em solid #0a0808;">Pinjaman Dicairkan</td>
                                            <td>TSA</td>
                                            <td>Simjib</td>
                                            <td class="w-22">T. Wajib Cair</td>
                                            <td class="w-22">Paraf PCR</td>
                                            <td class="w-22">Paraf BTAB</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Pindahan Halaman <?php echo $lembar_ke-1;?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            
                                            <?php if($i==35){?>
                                            <td><?php echo $total;?></td>
                                            <?php } else if($i==70){ ?>
                                            <td><?php echo $total2;?></td>
                                            <?php
                                            }
                                            ?>
                                            <td></td>
                                            
                                            <td></td>
                                            <td></td>
                                            <td style="border-left: 0.2em solid #0a0808;"></td>
                                            <td style="border-left: 0.2em solid #0a0808;"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            
                                        </tr>
                                        
                                        <?php endif;?>
                                        <!--end kondisi header-->
                                        
                                        <?php }
                                        if ($i<105):
                                        $k = $i;
                                        while($k<105){
                                        $k++;
                                        ?>
                                        <tr style="height:20px;">
                                            <td><?php echo $k;?></td>
                                            <td></td>
                                            <td style="text-align:left;"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="border-left: 0.2em solid #0a0808;"></td>
                                            <td style="border-left: 0.2em solid #0a0808;"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <!--kondisi header-->
                                        <?php
                                        if($k==35 || $k==70):
                                            if($k==35){
                                            $tot = $total;
                                        } else if($k==70){
                                            $tot = $total2+$total;
                                        } else if($k==105){
                                            $tot = $total3+$total2+$total;
                                        }
                                        ?>
                                        
                                        <tr>
                                            <td colspan="6">Total (selesai/dipindahkan)</td>
                                            <?php if($tot==0){?>
                                            <td></td>
                                            <?php } else {?>
                                            <td><b><?php echo $tot;?></b></td>
                                            <?php }?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td  style="border-left: 0.2em solid #0a0808;"></td>
                                            <td style="border-left: 0.2em solid #0a0808;"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table style="border:none; margin-top:5px;font-size:13px;">
                                    <tbody>
                                        <tr>
                                            <td style="border-right:none; border-bottom:none; text-align:left;">Dibuat oleh:</td>
                                            <td style="width:70px; border-right:none; "></td>
                                            <!--pemisah table-->
                                            <td rowspan="4" style="width:50px; border-bottom:none; border-right:none;"></td>
                                            <!--pemisah-->
                                            <td style="border-right:none; border-bottom:none; text-align:left;">Disetujui Oleh:</td>
                                            <td style="width:70px; border-right:none;"></td>
                                            
                                            <!--pemisah table-->
                                            <td rowspan="4" style="width:50px; border:none;"></td>
                                            <!--pemisah-->
                                            
                                            <td colspan="3" style="border:none; text-align:left; width:200px;">Pemeriksa/Supervisor/Kantor Pusat:</td>
                                            <td style="width:70px; border:none;"></td>
                                        </tr>
                                        <tr>
                                            <td style="border:none; text-align:left;">Kasir</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Kepala Cbg</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Nama 1</td>
                                            <td style="text-align:left; width:70px; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Nama 2</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                        </tr>
                                        <tr>
                                            <td style="border:none; text-align:left;">TTD</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">TTD</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">TTD 1</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">TTD 2</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="border:none; text-align:left;">Tanggal</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Tanggal</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Tgl 1</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Tgl 2</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                        </tr>
                                        <tr>
                                            <td style="border:none; text-align:left; font-size:10px;" colspan="16">Bila ada >1 halaman, tanda tangan langsung dihalaman terakhir.</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php if($k==35){
                                    $lembar_ke = '2';
                                } else if($k==70){
                                    $lembar_ke = '3';
                                }
                                
                                ?>
                                <div class="form-group">
                                   <h3 style="text-align:center; margin-top:100px;">RTK SetSus - Lembar <?php echo $lembar_ke;?></h3>
                                </div>
                                <table class="table-bordered table-responsive-sm" style="font-size:12px; margin-top:5px;" >
                                    <tbody>
                                        <tr style="background-color:#c3ebb2;">
                                            <td class="w-221" rowspan="2">Urut</td>
                                            <td class="w-11" colspan="2">Kumpulan</td>
                                            <td class="w-22" rowspan="2">Nama PKP</td>
                                            <td class="w-1" colspan="5">Setoran Mingguan</td>
                                            <td class="w-22" rowspan="2">Kd Byr Khusus</td>
                                            <td class="w-22" rowspan="2" style="border: 0.2em solid #0a0808;">Jml Uang ke kasir</td>
                                            <td class="w-2" colspan="6" style="border-left: 0.2em solid #0a0808;">Pencairan & BTAB</td>
                                        </tr>
                                        <tr style="background-color:#c3ebb2;">
                                            <td>No</td>
                                            <td class="w-1">Nama</td>
                                            <td>Set ke-</td>
                                            <td>% pilih</td>
                                            <td>Acuan</td>
                                            <td class="w-22" >Jumlah Cicilan</td>
                                            <td class="w-22" >Keteran gan</td>
                                            <td class="w-22"  style="border-left: 0.2em solid #0a0808;">Pinjaman Dicairkan</td>
                                            <td>TSA</td>
                                            <td>Simjib</td>
                                            <td class="w-22">T. Wajib Cair</td>
                                            <td class="w-22">Paraf PCR</td>
                                            <td class="w-22">Paraf BTAB</td>
                                        </tr>
                                        
                                        <?php endif;?>
                                        <!--end kondisi header-->
                                        <?php
                                        }
                                        endif;?>
                                        <tr>
                                        <?php
                                        if($i==105){
                                            $tot = $total3;
                                        }
                                        if($k==105){
                                            $tot = $total3;
                                        }
                                        ?>    
                                        </tr>
                                        <tr>
                                            <td colspan="6">Total (selesai/dipindahkan)</td>
                                            <?php if($tot==0){?>
                                            <td></td>
                                            <?php } else {?>
                                            <td><b><?php echo $tot;?></b></td>
                                            <?php }?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="border-left: 0.2em solid #0a0808;"></td>
                                            <td style="border-left: 0.2em solid #0a0808;"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table style="border:none; margin-top:10px; font-size:13px;">
                                    <tbody>
                                        <tr>
                                            <td style="border-right:none; border-bottom:none; text-align:left;">Dibuat oleh:</td>
                                            <td style="width:70px; border-right:none; "></td>
                                            <!--pemisah table-->
                                            <td rowspan="4" style="width:50px; border-bottom:none; border-right:none;"></td>
                                            <!--pemisah-->
                                            <td style="border-right:none; border-bottom:none; text-align:left;">Disetujui Oleh:</td>
                                            <td style="width:70px; border-right:none;"></td>
                                            
                                            <!--pemisah table-->
                                            <td rowspan="4" style="width:50px; border:none;"></td>
                                            <!--pemisah-->
                                            
                                            <td colspan="3" style="border:none; text-align:left; width:200px;">Pemeriksa/Supervisor/Kantor Pusat:</td>
                                            <td style="width:70px; border:none;"></td>
                                        </tr>
                                        <tr>
                                            <td style="border:none; text-align:left;">Kasir</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Kepala Cbg</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Nama 1</td>
                                            <td style="text-align:left; width:70px; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Nama 2</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                        </tr>
                                        <tr>
                                            <td style="border:none; text-align:left;">TTD</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">TTD</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">TTD 1</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">TTD 2</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="border:none; text-align:left;">Tanggal</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Tanggal</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Tgl 1</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                            
                                            <td style="border:none; text-align:left;">Tgl 2</td>
                                            <td style="text-align:left; border-right:none;">:</td>
                                        </tr>
                                        <tr>
                                            <td style="border:none; text-align:left; font-size:10px;" colspan="16">Bila ada >1 halaman, tanda tangan langsung dihalaman terakhir.</td>
                                        </tr>
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
