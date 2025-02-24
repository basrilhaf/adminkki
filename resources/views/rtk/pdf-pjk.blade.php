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
    width: 220px;
    height: 25px;
    text-align: center;
    font-size:12px;
}
.w-111{
    padding-right: 4px;
    width: 120px;
    height: 25px;
    text-align: center;
    font-size:12px;
}
.w-1{
    padding-right: 4px;
    width: 150px;
    height: 25px;
    text-align: center;
    font-size:12px;
}
.w-12{
    padding-right: 4px;
    width: 140px;
    height: 25px;
    text-align: center;
    font-size:12px;
}
.w-2{
     font-size:12px;
   width: 65px;
    height: 25px; 
}
.w-22{
     font-size:12px;
   width: 50px;
    height: 25px; 
}

.w-221{
     font-size:12px;
   width: 30px;
    height: 25px; 
}
.w-3{
     font-size:12px;
   width: 70px;
    height: 25px; 
}

.w-300{
     font-size:12px;
   width: 500px;
    height: 25px; 
}
</style>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
    
    <?php $p_t = explode("-",$tanggal);?>
  <title>PJK_cabang<?php echo $cabang;?>_<?php echo $p_t[2].$p_t[1].$p_t[0]?>.</title>

 


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
                font-size:14px;
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
                               <h3 style="text-align:center;">Pengingat Jadwal Kelompok (PJK)</h3>
                            </div>
                            <div style="display:block; margin-bottom:20px;">
                                <table style="border:none; font-size:13px;">
                                    <tbody>
                                    <tr style="height:25px;">
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">No Cabang:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $cabang;?></td>
                                        <td style="border:none; width:20px;" rowspan="2"></td>
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">Hari:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $hari;?></td>
                                        
                                        
                                    </tr>
                                    <?php
                                    
                                    $t = explode("-",$tanggal);
                                    $new_tanggal = $t[2]."-".$t[1]."-".$t[0];
                                    
                                    ?>
                                    
                                    <tr style="height:25px;">
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">Nama Cabang:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left; font-size:12px;"><?php echo $nama_c;?></td>
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">Setroan Tanggal:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $new_tanggal;?></td>
                                        
                                        
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php 
                                            $i = 0;
                                            $total = 0;
                                            $total2= 0;
                                            $total3 = 0;
                                            $bst=0;
                                            $pu2=0;
                                            $pu4=0;
                                            $pu6=0;
                                            $pu8=0;
                                            $pu10=0;
                                            $md_btk=0;
                                            $btab_k_sekarang=0;
                                            $btab_k_lewat=0;
                                            $jadwal_sm=0;
                                            $siapkan_btab=0;
                                            $sisahan = 0;
                                            
                                            foreach($pjk as $rows){ 
                                            $i++;
                                            
                                            $set_next = $rows->set_ke_rtk;
                                            
                                            if($set_next=='1'){
                                                $pengingat = "Pastikan BST Lengkap";
                                                $bst = $bst+1;
                                            } else if((($rows->durasi_rtk=="25") && ($set_next>"10") && ($set_next<="11"))||(($rows->durasi_rtk=="40")&&(($set_next>"16") && ($set_next<="17")))||(($rows->durasi_rtk=="50")&&($set_next=="26"))||(($rows->durasi_rtk=="80")&&($set_next=="51"))){
                                                $pengingat = "Mulai PU 2 orang";
                                                $pu2 = $pu2+1;
                                            } else if((($rows->durasi_rtk=="25") && ($set_next>"11") && ($set_next<="12"))||(($rows->durasi_rtk=="40")&&(($set_next>"17") && ($set_next<="18")))||(($rows->durasi_rtk=="50")&&($set_next=="27"))||(($rows->durasi_rtk=="80")&&($set_next=="52"))){
                                                $pengingat = "PU sudah harus 4 orang";
                                                $pu4 = $pu4+1;
                                                
                                            } else if((($rows->durasi_rtk=="25") && ($set_next>"12") && ($set_next<="13"))||(($rows->durasi_rtk=="40")&&(($set_next>"18") && ($set_next<="19")))||(($rows->durasi_rtk=="50")&&($set_next=="28"))||(($rows->durasi_rtk=="80")&&($set_next=="53"))){
                                                $pengingat = "PU sudah harus 6 orang";
                                                $pu6 = $pu6+1;
                                            
                                            } else if((($rows->durasi_rtk=="25") && ($set_next>"13") && ($set_next<="14"))||(($rows->durasi_rtk=="40")&&(($set_next>"19") && ($set_next<="20")))||(($rows->durasi_rtk=="50")&&($set_next=="29"))||(($rows->durasi_rtk=="80")&&($set_next=="54"))){
                                                $pengingat = "PU sudah harus 8 orang";
                                                $pu8 = $pu8+1;
                                            
                                            } else if((($rows->durasi_rtk=="25") && ($set_next>"14") && ($set_next<="15"))||(($rows->durasi_rtk=="40")&&(($set_next>"20") && ($set_next<="21")))||(($rows->durasi_rtk=="50")&&($set_next=="30"))||(($rows->durasi_rtk=="80")&&($set_next=="55"))){
                                                $pengingat = "PU sudah harus 10 orang";
                                                $pu10 = $pu10+1;
                                            
                                            } else if((($rows->durasi_rtk=="40") && ($set_next>"24") && ($set_next<="25")) || (($rows->durasi_rtk=="50")&&($set_next=="35")) || (($rows->durasi_rtk=="80")&&($set_next=="59"))){
                                                $pengingat = "Mggu dpn deadline PU";
                                            
                                            } else if(($rows->durasi_rtk=="25")&&($set_next>"15")&&($set_next<="16")){
                                                $pengingat = "Mggu dpn deadline PU | Jadwalkan SM";
                                                $jadwal_sm=$jadwal_sm+1;
                                            
                                            } else if(($rows->durasi_rtk=="25")&&($set_next>"16")&&($set_next<="17")){
                                                $pengingat = "Deadline PU  |  Sudah bisa SM";
                                                $jadwal_sm=$jadwal_sm+1;
                                            
                                            } else if((($rows->durasi_rtk=="40") && ($set_next>"25") && ($set_next<="26")) || (($rows->durasi_rtk=="50")&&($set_next=="36")) || (($rows->durasi_rtk=="80")&&($set_next=="60"))){
                                                $pengingat = "Deadline PU  |  Jadwalkan SM";
                                                $jadwal_sm=$jadwal_sm+1;
                                            
                                            } else if((($rows->durasi_rtk=="40")&&($set_next>"25")&&($set_next<="27")) || (($rows->durasi_rtk=="50")&&($set_next=="37")) || (($rows->durasi_rtk=="80")&&($set_next>60)&&($set_next<="62"))){
                                                $pengingat = "Sudah bisa SM";
                                                $jadwal_sm=$jadwal_sm+1;
                                                
                                            } else if((($rows->durasi_rtk=="25")&&($set_next>"17")&&($set_next<="18")) || (($rows->durasi_rtk=="40")&&($set_next>"27")&&($set_next<="28")) || (($rows->durasi_rtk=="50")&&($set_next=="38")) || (($rows->durasi_rtk=="80")&&($set_next=="63"))){
                                                $pengingat = "Sudah bisa SM  |  Mggu dpn Deadline SM";
                                                $jadwal_sm=$jadwal_sm+1;
                                            
                                            } else if((($rows->btab_btk=="BTAB")&&($rows->durasi_rtk=="25")&&($set_next>"18")&&($set_next<="19")) || (($rows->btab_btk=="BTAB")&&($rows->durasi_rtk=="40")&&($set_next>="28")&&($set_next<"29"))){
                                                $pengingat = "Deadline SM";
                                                $jadwal_sm=$jadwal_sm+1;
                                            
                                            } else if((($rows->btab_btk=="BTK")&&($rows->durasi_rtk=="25")&&($set_next>"18")&&($set_next<="19")) || (($rows->durasi_rtk=="40")&&($set_next>="29")&&($set_next<"30")) || (($rows->btab_btk=="BTK")&&($rows->durasi_rtk=="50")&&($set_next=="39")) || (($rows->btab_btk=="BTK")&&($rows->durasi_rtk=="80")&&($set_next=="64"))){
                                                $pengingat = "Deadline SM  |  Mggu dpn BTAB khusus";
                                                $md_btk = $md_btk+1;
                                                $jadwal_sm=$jadwal_sm+1;
                                            
                                            } else if((($rows->btab_btk=="BTK")&&($rows->durasi_rtk=="25")&&($set_next=="19.2")) || (($rows->durasi_rtk=="40")&&($set_next>="30") &&($set_next < "40")) || (($rows->btab_btk=="BTK")&&($rows->durasi_rtk=="50")&&($set_next=="39.4")) || (($rows->btab_btk=="BTK")&&($rows->durasi_rtk=="80")&&($set_next=="64.4"))){
                                                $pengingat = "Lakukan BTAB KHUSUS";
                                                $btab_k_sekarang = $btab_k_sekarang+1;
                                            
                                            } else if((($rows->btab_btk=="BTAB")&&($rows->durasi_rtk=="25")&&($set_next=="24")) || (($rows->btab_btk=="BTAB")&&($rows->durasi_rtk=="40")&&($set_next=="39"))){
                                                $pengingat = "Mggu dpn BTAB NORMAL";
                                                $siapkan_btab = $siapkan_btab+1;
                                            
                                            } else if((($rows->btab_btk=="BTAB")&&($rows->durasi_rtk=="25")&&($set_next=="25")) || (($rows->btab_btk=="BTAB")&&($rows->durasi_rtk=="40")&&($set_next=="40"))){
                                                $pengingat = "Lakukan BTAB NORMAL";
                                                $btab_k_sekarang = $btab_k_sekarang+1;
                                            
                                            } else if($set_next=="-"){
                                                $pengingat = "Seharusnya sudah BTAB. Kenapa belum?";
                                                $btab_k_lewat = $btab_k_lewat+1;
                                                     
                                            } else {
                                                $pengingat = "";
                                                $sisahan = $sisahan+1;
                                            }
                                            
                                            
                                            }
                                            
                                            //  = $i-($bst+$pu2+$pu4+$pu6+$pu8+$pu10+$md_btk+$btab_k_sekarang+$btab_k_lewat+$jadwal_sm+$siapkan_btab);
                                            
                                            ?> 
                            
                            <div style="display:block; margin-bottom:5px;">
                                <table style="border:none; font-size:13px; height:25px;">
                                    <tbody>
                                    <tr style="height:28px;">
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">Pastikan BST Lengkap:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $bst;?></td>
                                        <td style="border:none; width:20px;" rowspan="6"></td>
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">Minggu depan BTK:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $md_btk;?></td>
                                        
                                        
                                    </tr>
                                    <tr style="height:28px;">
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">Mulai PU 2 orang:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $pu2;?></td>
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">BTAB Khusus Sekarang:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $btab_k_sekarang;?></td>
                                        
                                    </tr>
                                    <tr style="height:28px;">
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">PU sudah harus 4 orang:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $pu4;?></td>
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">BTAB Khusus Terlewat:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $btab_k_lewat;?></td>
                                        
                                    </tr>
                                    <tr style="height:28px;">
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">PU sudah harus 6 orang:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $pu6;?></td>
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">Jadwalkan SM || Cek MD + F-BTAB:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $jadwal_sm;?></td>
                                        
                                    </tr>
                                    <tr style="height:28px;">
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">PU sudah harus 8 orang:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $pu8;?></td>
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">Siapkan BTAB:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $siapkan_btab;?></td>
                                        
                                    </tr>
                                    <tr style="height:26px;">
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">PU sudah harus 10 orang:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $pu10;?></td>
                                        <td style="border-left: 0.1em solid #0a0808;border-top: 0.1em solid #0a0808; background-color:#c3ebb2; width:250px; text-align:left;">No Action:</td>
                                        <td style="border-top: 0.1em solid #0a0808; width:120px; text-align:left;"><?php echo $sisahan;?></td>
                                        
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--baru-->
                            
                            <div style="display:inline-block;">
                                <table class="table-bordered table-responsive-sm" style="font-size:12px; border-left:none;" >
                                    <tbody>
                                        <tr style="background-color:#c3ebb2;">
                                            <td  style="border-left: 0.1em solid #0a0808;">No</td>
                                            <td class="w-22">No Kel.</td>
                                            <td class="w-1">Nama Kelompok</td>
                                            <td>Jangka Waktu</td>
                                            <td >Set Ke-</td>
                                            <td class="w-2">Jml Set/mgg</td>
                                            <td class="w-11">Pengingat</td>
                                            <td>Pilihan</td>
                                            <td class="w-22">Kasus</td>

                                        </tr>
                                        <?php 
                                            $i = 0;
                                            $total = 0;
                                            $total2= 0;
                                            $total3 = 0;
                                            foreach($pjk as $rows){ 
                                            $i++;
                                             // BTK
                                            if($rows->btab_btk=="BTK"){
                                                if($rows->durasi_rtk=="25"){
                                                    if($rows->setsus=="50"){
                                                        if($rows->set_ke_rtk>=19){
                                                           $set_next = "19.2"; 
                                                           $acuan = ((($rows->set_mingguan_rtk*20)/100)*2)/1000;
                                                        } else {
                                                           $set_next = $rows->set_ke_rtk; 
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
                                                            $set_next = $rows->set_ke_rtk; 
                                                            $acuan = $rows->set_mingguan_rtk/1000;
                                                        }
                                                        
                                                    }   
                                                } else if($rows->durasi_rtk=="80"){
                                                    if($rows->setsus=="50"){
                                                        if($rows->set_ke_rtk>=64){
                                                           $set_next = "64.4"; 
                                                           $acuan = ((($rows->set_mingguan_rtk*40)/100)*2)/1000;
                                                        } else {
                                                           $set_next = $rows->set_ke_rtk; 
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
                                                        $set_next = $rows->set_ke_rtk;
                                                        $acuan = (($rows->set_mingguan_rtk*57.5)/100)/1000;
                                                    } else if($rows->setsus=="25"){
                                                        $set_next = $rows->set_ke_rtk;
                                                        $acuan = (($rows->set_mingguan_rtk*32.5)/100)/1000;
                                                    } else {
                                                        
                                                    
                                                    
                                                    $set_next = $rows->set_ke_rtk; 
                                                    $acuan = $rows->set_mingguan_rtk/1000; 
                                                        
                                                    }
                                                }
                                                                                                
                                            } else {
                                                // BTAB
                                                $set_next = $rows->set_ke_rtk;
                                                if($rows->durasi_rtk=="25"){
                                                    if($rows->setsus=="25"){
                                                        $acuan = (($rows->set_mingguan_rtk*30)/100)/1000;
                                                    } else if($rows->setsus=="50"){
                                                        $acuan = (($rows->set_mingguan_rtk*55)/100)/1000;
                                                    } else {
                                                        $acuan = (($rows->set_mingguan_rtk*100)/100)/1000;
                                                    }
                                                    
                                                    
                                                } else if($rows->durasi_rtk=="40"){
                                                   if($rows->setsus=="25"){
                                                        $acuan = (($rows->set_mingguan_rtk*32.5)/100)/1000;
                                                    } else if($rows->setsus=="50"){
                                                        $acuan = (($rows->set_mingguan_rtk*57.5)/100)/1000;
                                                    } else {
                                                        $acuan = (($rows->set_mingguan_rtk*100)/100)/1000;
                                                    } 
                                                    
                                                } else if($rows->durasi_rtk=="80"){
                                                    if($rows->setsus=="50"){
                                                        $acuan = (($rows->set_mingguan_rtk*60.8695652173913)/100)/1000;
                                                    
                                                    } else {
                                                        $acuan = (($rows->set_mingguan_rtk*100)/100)/1000;
                                                    } 
                                                } else {
                                                    $acuan = $rows->set_mingguan_rtk/1000;
                                                }
                                            }
                                            
                                            $acuan = $rows->set_mingguan_rtk/1000;
                                            $total = $total + $acuan;
                                            if(($i>32) &&($i<65)){
                                                $total2 = $total2 + $acuan;
                                            } else if(($i>64) && ($i<97)){
                                                $total3 = $total3 + $acuan;
                                            }
                                            // $set_next = $rows->set_ke_rtk + ($rows->setsus/100);
                                            
                                            if($set_next=='1'){
                                                $pengingat = "Pastikan BST Lengkap";
                                            
                                            } else if((($rows->durasi_rtk=="25") && ($set_next>"10") && ($set_next<="11"))||(($rows->durasi_rtk=="40")&&(($set_next>"16") && ($set_next<="17")))||(($rows->durasi_rtk=="50")&&($set_next=="26"))||(($rows->durasi_rtk=="80")&&($set_next=="51"))){
                                                $pengingat = "Mulai PU 2 orang";
                                            
                                            } else if((($rows->durasi_rtk=="25") && ($set_next>"11") && ($set_next<="12"))||(($rows->durasi_rtk=="40")&&(($set_next>"17") && ($set_next<="18")))||(($rows->durasi_rtk=="50")&&($set_next=="27"))||(($rows->durasi_rtk=="80")&&($set_next=="52"))){
                                                $pengingat = "PU sudah harus 4 orang";
                                                
                                            } else if((($rows->durasi_rtk=="25") && ($set_next>"12") && ($set_next<="13"))||(($rows->durasi_rtk=="40")&&(($set_next>"18") && ($set_next<="19")))||(($rows->durasi_rtk=="50")&&($set_next=="28"))||(($rows->durasi_rtk=="80")&&($set_next=="53"))){
                                                $pengingat = "PU sudah harus 6 orang";
                                            
                                            } else if((($rows->durasi_rtk=="25") && ($set_next>"13") && ($set_next<="14"))||(($rows->durasi_rtk=="40")&&(($set_next>"19") && ($set_next<="20")))||(($rows->durasi_rtk=="50")&&($set_next=="29"))||(($rows->durasi_rtk=="80")&&($set_next=="54"))){
                                                $pengingat = "PU sudah harus 8 orang";
                                            
                                            } else if((($rows->durasi_rtk=="25") && ($set_next>"14") && ($set_next<="15"))||(($rows->durasi_rtk=="40")&&(($set_next>"20") && ($set_next<="21")))||(($rows->durasi_rtk=="50")&&($set_next=="30"))||(($rows->durasi_rtk=="80")&&($set_next=="55"))){
                                                $pengingat = "PU sudah harus 10 orang";
                                            
                                            } else if((($rows->durasi_rtk=="40") && ($set_next>"24") && ($set_next<="25")) || (($rows->durasi_rtk=="50")&&($set_next=="35")) || (($rows->durasi_rtk=="80")&&($set_next=="59"))){
                                                $pengingat = "Mggu dpn deadline PU";
                                            
                                            } else if(($rows->durasi_rtk=="25")&&($set_next>"15")&&($set_next<="16")){
                                                $pengingat = "Mggu dpn deadline PU | Jadwalkan SM";
                                            
                                            } else if(($rows->durasi_rtk=="25")&&($set_next>"16")&&($set_next<="17")){
                                                $pengingat = "Deadline PU  |  Sudah bisa SM";
                                            
                                            } else if((($rows->durasi_rtk=="40") && ($set_next>"25") && ($set_next<="26")) || (($rows->durasi_rtk=="50")&&($set_next=="36")) || (($rows->durasi_rtk=="80")&&($set_next=="60"))){
                                                $pengingat = "Deadline PU  |  Jadwalkan SM";
                                            
                                            } else if((($rows->durasi_rtk=="40")&&($set_next>"26")&&($set_next<="28")) || (($rows->durasi_rtk=="50")&&($set_next=="37")) || (($rows->durasi_rtk=="80")&&($set_next>60)&&($set_next<="62"))){
                                                $pengingat = "Sudah bisa SM";
                                                
                                            } else if((($rows->durasi_rtk=="25")&&($set_next>"17")&&($set_next<="18")) || (($rows->durasi_rtk=="40")&&($set_next>"27")&&($set_next<="28")) || (($rows->durasi_rtk=="50")&&($set_next=="38")) || (($rows->durasi_rtk=="80")&&($set_next=="63"))){
                                                $pengingat = "Sudah bisa SM  |  Mggu dpn Deadline SM";
                                            
                                            } else if((($rows->btab_btk=="BTAB")&&($rows->durasi_rtk=="25")&&($set_next>"18")&&($set_next<="19")) || (($rows->btab_btk=="BTAB")&&($rows->durasi_rtk=="40")&&($set_next>="28")&&($set_next<"29"))){
                                                $pengingat = "Deadline SM";
                                            
                                            } else if((($rows->btab_btk=="BTK")&&($rows->durasi_rtk=="25")&&($set_next>"18")&&($set_next<="19")) || (($rows->durasi_rtk=="40")&&($set_next>="29")&&($set_next<"30")) || (($rows->btab_btk=="BTK")&&($rows->durasi_rtk=="50")&&($set_next=="39")) || (($rows->btab_btk=="BTK")&&($rows->durasi_rtk=="80")&&($set_next=="64"))){
                                                $pengingat = "Deadline SM  |  Mggu dpn BTAB khusus";
                                            
                                            } else if((($rows->btab_btk=="BTK")&&($rows->durasi_rtk=="25")&&($set_next=="19.2")) || (($rows->durasi_rtk=="40")&&($set_next>="30") &&($set_next < "40")) || (($rows->btab_btk=="BTK")&&($rows->durasi_rtk=="50")&&($set_next=="39.4")) || (($rows->btab_btk=="BTK")&&($rows->durasi_rtk=="80")&&($set_next=="64.4"))){
                                                $pengingat = "Lakukan BTAB KHUSUS";
                                            
                                            } else if((($rows->btab_btk=="BTAB")&&($rows->durasi_rtk=="25")&&($set_next=="24")) || (($rows->btab_btk=="BTAB")&&($rows->durasi_rtk=="40")&&($set_next=="39"))){
                                                $pengingat = "Mggu dpn BTAB NORMAL";
                                            
                                            } else if((($rows->btab_btk=="BTAB")&&($rows->durasi_rtk=="25")&&($set_next=="25")) || (($rows->btab_btk=="BTAB")&&($rows->durasi_rtk=="40")&&($set_next=="40"))){
                                                $pengingat = "Lakukan BTAB NORMAL";
                                            
                                            } else if($set_next=="-"){
                                                $pengingat = "Seharusnya sudah BTAB. Kenapa belum?";
                                                     
                                            } else {
                                                $pengingat = "";
                                            }
                                            
                                            
                                            // $jml_set = $acuan*1000;
                                            $jml_set = $rows->set_mingguan_rtk;
                                            
                                            $nama_kel = $rows->nama_kelompok;
                                           
                                            
                                            ?>  
                                        <tr style="height:22px;">
                                            <td style="border-left: 0.1em solid #0a0808;"><?php echo $i;?></td>
                                            <td style="text-align:left;"><?php echo $rows->no_kelompok;?></td>
                                            <td style="text-align:left;"><?php echo $rows->nama_kelompok_rtk;?></td>
                                            <td style="text-align:right; padding-right:5px;"><?php echo $rows->durasi_rtk;?></td>
                                            <td style="text-align:right; padding-right:5px;"><?php echo $rows->set_ke_rtk;?></td>
                                            <td style="text-align:right; padding-right:5px;"><?php echo number_format($jml_set,0,',','.');?></td>
                                            <td style="text-align:left; font-size:11px;"><?php echo $pengingat;?></td>
                                            <td style="text-align:left;"><?php echo $rows->btab_btk;?></td>
                                            <td style="text-align:left;"><?php echo $rows->kas;?></td>
                                        </tr>
                                        <?php if($i==79):?>
                                        <tr style="height:15px;">
                                            <td style="border-bottom: 0.1em solid #0a0808; border-right:none;"></td>
                                            <td style="border-bottom: 0.1em solid #0a0808; border-right:none;"></td>
                                            <td style="border-bottom: 0.1em solid #0a0808; border-right:none;"></td>
                                            <td style="border-bottom: 0.1em solid #0a0808; border-right:none;"></td>
                                            <td style="border-bottom: 0.1em solid #0a0808; border-right:none;"></td>
                                            <td style="border-bottom: 0.1em solid #0a0808; border-right:none;"></td>
                                            <td style="border-bottom: 0.1em solid #0a0808; border-right:none;"></td>
                                            <td style="border-bottom: 0.1em solid #0a0808; border-right:none;"></td>
                                            <td style="border-bottom: 0.1em solid #0a0808; border-right:none;"></td>
                                            
                                            
                                        </tr>
                                        <?php endif;?>
                                        <?php }?>
                                        <tr>
                                            <td colspan="4" style="border:none;"></td>
                                            <td style="border-left: 0.1em solid #0a0808;">Total </td>
                                            <?php if($total==0){?>
                                            <td></td>
                                            <?php } else {?>
                                            <td><b><?php echo number_format($total*1000,0,',','.');?></b></td>
                                            <?php }?>
                                            <td colspan="2" style="border:none;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php if(count($catatan) > 0):?>
                                <table style="margin-top:10px;">
                                    <tbody>
                                        <tr>
                                            <td style="background-color:#c3ebb2;">No</td>
                                            <td style="background-color:#c3ebb2;" class="w-22">No Kel.</td>
                                            <td style="background-color:#c3ebb2;"class="w-1">Nama Kelompok</td>
                                            <td style="background-color:#c3ebb2;" class="w-300">Catatan</td>
                                        </tr>
                                        <?php 
                                            $i = 0;

                                            foreach($catatan as $rowc)
                                            { 
                                            $i++;
                                        ?>
                                        <tr>
                                            <td ><?php echo $i;?></td>
                                            <td class="w-22"><?php echo $rowc->no_kelompok_c;?></td>
                                            <td class="w-1"><?php echo $rowc->kelompok_c;?></td>
                                            <td class="w-300"><?php echo $rowc->catatan_c;?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <?php endif;?>
                            </div>
                            <!--end baru-->
                            
                            
                            
                            
                            
                            
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
