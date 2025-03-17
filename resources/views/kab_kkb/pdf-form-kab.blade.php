<?php if($kab_kkb == "KAB"){?>
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
    height: 18px;
    text-align: center;
    font-size:14px;
}
.w-111{
    padding-right: 4px;
    width: 80px;
    height: 18px;
    text-align: center;
    font-size:14px;
}
.w-111a{
    padding-right: 4px;
    width: 100px;
    height: 18px;
    text-align: center;
    font-size:14px;
}
.w-111s{
    padding-right: 4px;
    width: 150px;
    height: 12px;
    text-align: center;
    font-size:12px;
}
.w-111ss{
    padding-right: 4px;
    width: 180px;
    height: 12px;
    text-align: center;
    font-size:12px;
}
.w-111ss2{
    padding-right: 4px;
    width: 310px;
    height: 12px;
    text-align: center;
    font-size:12px;
}
.w-111sss{
    padding-right: 4px;
    width: 300px;
    height: 12px;
    text-align: center;
    font-size:12px;
}

.w-1{
    padding-right: 4px;
    width: 160px;
    height: 18px;
    text-align: center;
    font-size:14px;
}
.w-12{
    padding-right: 4px;
    width: 140px;
    height: 18px;
    text-align: center;
    font-size:14px;
}
.w-2{
     font-size:14px;
   width: 50px;
    height: 18px; 
}
.w-2s{
     font-size:14px;
   width: 60px;
    height: 18px; 
}
.w-22{
     font-size:14px;
   width: 60px;
    height: 18px; 
}
.w-220{
     font-size:14px;
   width: 340px;
    height: 18px; 
}

.w-220s{
     font-size:13px;
   width: 290px;
    height: 13px;
}

.w-221{
     font-size:14px;
   width: 30px;
    height: 18px; 
}
.w-3{
     font-size:14px;
   width: 60px;
    height: 18px; 
}
.w-3s{
     font-size:14px;
   width: 30px;
    height: 18px; 
}
.w-33{
     font-size:14px;
   width: 20px;
    height: 18px; 
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

  <title>LPAB_Cabang<?php echo $cabang;?>_<?php echo date("d/m/Y", strtotime($tanggal));?></title>

 


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
        
        $page_kab = 1;
        
        if($jum_kab <= 8){
            $page_total = 1;
        } else if(($jum_kab > 8) && ($jum_kab <=16)){
            $page_total = 2;
        } else if(($jum_kab > 16) && ($jum_kab <=24)){
            $page_total = 3;
        } else if(($jum_kab > 24) && ($jum_kab <=32)){    
            $page_total = 4;
        } else {
            $page_total ="";
        }
            
        ?>
        <!-- Begin Page Content -->
        <div id="pdfdiv" class="container-fluid">
            <!-- DataTales Example -->
            <div class="row" style="display:inline-block;">
                <div class="col-md-12">
                    <div class="card" style="color:black;">
                        <div class="card-body">
                            <div style="margin-bottom:13px;">
                                <span style="font-size:18px; "><b>Laporan Penanganan Anggota Bermasalah (LPAB) -  Cabang <?php echo $cabang;?> - <?php echo $hari." ".date("d M Y", strtotime($tanggal));?> (<?php echo $page_kab;?>/<?php echo $page_total;?>)</b></span>
                            </div>               
                            
                            <div style="display:inline-block;">
                                <table class="table-bordered table-responsive-sm" style="margin-bottom:0px;">
                                    <tbody>
                                        <tr>
                                            <td rowspan="2" class="w-33">No</td>
                                            <td rowspan="2" class="w-111">PKP</td>
                                            <td rowspan="2" class="w-111">Nama Ibu</td>
                                            <td rowspan="2" class="w-111">Kelompok</td>
                                            <td rowspan="2" class="w-3s">DTR</td>
                                            <td rowspan="2" class="w-2" style="font-size:13px;">Kunj Ke</td>
                                            <td rowspan="2" class="w-3">Tanggal</td>
                                            <td rowspan="2" class="w-2">Ketemu?</td>
                                            <td rowspan="2" class="w-111a">Penyebab DTR</td>
                                            <td rowspan="2" class="w-220">Hasil Edukasi</td>
                                            <td colspan="2" class="w-111a">Isi Hanya Bila Kabur</td>
                                        </tr>
                                        <tr>
                                            <td class="w-2s">Lancar?</td>
                                            <td class="w-2s" style="font-size:10px;">Kump. Awal(KC)?</td>
                                        </tr>
                                        <?php
                                        $i=0;
                                        $no=0;
                                        $nama_pkp="";
                                        foreach($data_list as $rowss){
                                            $i++;
                                            $id_anggota = $rowss->id_anggota_ab;
                                
                                            if($nama_pkp != $rowss->nama && $nama_pkp != $rowss->pkp_nama_ab){
                                                $no = 0;
                                            }
                                            $no ++;
                                            $jum = count($data_list);
                                            if($rowss->nama == ''){
                                                $nama_pkp = $rowss->pkp_nama_ab;
                                            }else{
                                                $nama_pkp = $rowss->nama;
                                            }
                                            
                                        ?>
                                        <tr>
                                            <td class="w-33" rowspan="3"><?php echo $no;?></td>
                                            <td class="w-111 tl" rowspan="3"><?php echo $nama_pkp;?></td>
                                            <td class="w-111 tl" rowspan="3"><?php echo $rowss->nama_ab;?></td>
                                            <td class="w-111 tl" rowspan="3"><?php echo $rowss->kelompok_ab;?></td>
                                            <td class="w-3s" rowspan="3"><?php echo $rowss->total;?></td>
                                            <td class="w-2">1</td>
                                            <td class="w-3"></td>
                                            <td class="w-2"></td>
                                            <td class="w-111a" rowspan="3"></td>
                                            <td class="w-220" rowspan="3"></td>
                                            <td class="w-2s" rowspan="3"></td>
                                            <td class="w-2s" rowspan="3"></td>
                                        </tr>
                                        <tr>
                                            
                                            <td class="w-2">2</td>
                                            <td class="w-3"></td>
                                            <td class="w-2"></td>
                                            
                                        </tr>
                                        <tr>
                                            
                                            <td class="w-2">3</td>
                                            <td class="w-3"></td>
                                            <td class="w(-2"></td>                           
                                        </tr>
                                        <!--jika lebih dari 8 data-->
                                        <?php if($i == 8):
                                        $i=0;
                                        ?>
                                        
                                        
                                        
                                                </tbody>  
                                            </table>
                                            <table style="margin-top:13px; margin-bottom:2px; border:none";>
                                                <tbody>
                                                    <tr>
                                                        <td style="border:none;" class="w-111s tl" colspan="3"><b>Kode Penyebab DTR: </b><span style="font-size:13px;">Kode 1-7: tulis angka. kode 8, wajib tulis apa penyebab lainnya(mis: lahiran, banyak utang, lupa, dll.), tidak boleh tulis "tidak di rumah / pergi / kerja"</span></td>
                                                        <td style="border:none; text-align:justify; padding-right:20px;" class="w-220s tl" colspan="2">Kolom <b>"Hasil Edukasi"</b> diisi dengan kode angka. kode 6 wajib dituliskan keterangan hasil edukasi lainnya(mis: menemui RT/RW, mencari anggota kabur di akhir pekan, dll)</td>
                                                        <td style="border:none;" class="w-220s tl">Kolom <b>"Isi hanya bila kabur"</b> Lancar? = diisi "V" / kasus telat/berat. ct: T10m / B20m</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border:none;" class="w-111ss tl">1. Kabur</td>
                                                        <td style="border:none;" class="w-111s tl">2. Ibu Sakit</td>
                                                        <td style="border:none;" class="w-111ss tl">3. Keluarga Sakit</td>
                                                       
                                                        <td style="border:none;" class="w-111sss tl">1. Tanya kenapa DTR & Ingatkan aturan</td>
                                                        <td style="border:none;" class="w-111ss2 tl">2. Semangati & berikan solusi</td>
                                                       
                                                        <td style="border:none;" class="w-220s tl">Kump. Awal (KC) = diisi "V" / "X"</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border:none;" class="w-111ss tl">4. Ibu Pulkam</td>
                                                        <td style="border:none;" class="w-111s tl">5. Ibu Pindah Rumah</td>
                                                        <td style="border:none;" class="w-111ss tl">6. Usaha Ibu Stop/Sepi</td>
                                                        
                                                        <td style="border:none;" class="w-111sss tl">3. Buat surat peringatan pelunasan</td>
                                                        <td style="border:none;" class="w-111ss2 tl">4. Akan pelunasan segera</td>
                                                        
                                                        <td style="border:none;" class="w-220s tl"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border:none;" class="w-111ss tl">7. Belum Ada Penjelasan</td>
                                                        <td style="border:none;" class="w-111s tl">8. Lainnya</td>
                                                        <td style="border:none;" class="w-111ss tl"></td>
                                                        
                                                        <td style="border:none;" class="w-111sss tl">5. FU penganggung jawab/keluarga</td>
                                                        <td style="border:none;" class="w-111ss2 tl">6. lainnya</td>
                                                        
                                                        <td style="border:none;" class="w-220s tl"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                            
                                        <?php $page_kab++;?>        
                                        <div style="margin-bottom:21px;">
                                            <span style="font-size:18px; "><b>Laporan Penanganan Anggota Bermasalah (LPAB) -  Cabang <?php echo $cabang;?> - <?php echo $hari." ".date("d M Y", strtotime($tanggal));?> (<?php echo $page_kab;?>/<?php echo $page_total;?>)</b></span>
                                        </div>               
                                        
                                        <div style="display:inline-block;">
                                            <table class="table-bordered table-responsive-sm" style="margin-bottom:0px;">
                                                <tbody>
                                                    <tr>
                                                        <td rowspan="2" class="w-33">No</td>
                                                        <td rowspan="2" class="w-111">PKP</td>
                                                        <td rowspan="2" class="w-111">Nama Ibu</td>
                                                        <td rowspan="2" class="w-111">Kelompok</td>
                                                        <td rowspan="2" class="w-3s">DTR</td>
                                                        <td rowspan="2" class="w-2" style="font-size:13px;">Kunj Ke</td>
                                                        <td rowspan="2" class="w-3">Tanggal</td>
                                                        <td rowspan="2" class="w-2">Ketemu?</td>
                                                        <td rowspan="2" class="w-111a">Penyebab DTR</td>
                                                        <td rowspan="2s" class="w-220">Hasil Edukasi</td>
                                                        <td colspan="2s" class="w-111a">Isi Hanya Bila Kabur</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-2s">Lancar?</td>
                                                        <td class="w-2s" style="font-size:10px;">Kump. Awal(KC)?</td>
                                                    </tr>
                                        <?php endif;?>
                                        <?php }?>
                                        
                                        
                                        <!--jika data kurang dari 9-->
                                        <?php if($i<8):
                                        while($i<8){
                                            $i++;
                                        
                                        ?>
                                        <tr>
                                            <td class="w-33" rowspan="3"></td>
                                            <td class="w-111" rowspan="3"></td>
                                            <td class="w-111" rowspan="3"></td>
                                            <td class="w-111" rowspan="3"></td>
                                            <td class="w-3s" rowspan="3"></td>
                                            <td class="w-2">1</td>
                                            <td class="w-3"></td>
                                            <td class="w-2"></td>
                                            <td class="w-111a" rowspan="3"></td>
                                            <td class="w-220" rowspan="3"></td>
                                            <td class="w-2s" rowspan="3"></td>
                                            <td class="w-2s" rowspan="3"></td>
                                        </tr>
                                        <tr>
                                            
                                            <td class="w-2">2</td>
                                            <td class="w-3"></td>
                                            <td class="w-2"></td>
                                            
                                        </tr>
                                        <tr>
                                            
                                            <td class="w-2">3</td>
                                            <td class="w-3"></td>
                                            <td class="w-2"></td>
                                            
                                        </tr>
                                        <?php } endif;?>
                                        
                                    </tbody>
                                </table>
                               <table style="margin-top:13px; margin-bottom:2px; border:none";>
                                                <tbody>
                                                    <tr>
                                                        <td style="border:none;" class="w-111s tl" colspan="3"><b>Kode Penyebab DTR: </b><span style="font-size:13px;">Kode 1-7: tulis angka. kode 8, wajib tulis apa penyebab lainnya(mis: lahiran, banyak utang, lupa, dll.), tidak boleh tulis "tidak di rumah / pergi / kerja"</span></td>
                                                        <td style="border:none; text-align:justify; padding-right:20px;" class="w-220s tl" colspan="2">Kolom <b>"Hasil Edukasi"</b> diisi dengan kode angka. kode 6 wajib dituliskan keterangan hasil edukasi lainnya(mis: menemui RT/RW, mencari anggota kabur di akhir pekan, dll)</td>
                                                        <td style="border:none;" class="w-220s tl">Kolom <b>"Isi hanya bila kabur"</b> Lancar? = diisi "V" / kasus telat/berat. ct: T10m / B20m</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border:none;" class="w-111ss tl">1. Kabur</td>
                                                        <td style="border:none;" class="w-111s tl">2. Ibu Sakit</td>
                                                        <td style="border:none;" class="w-111ss tl">3. Keluarga Sakit</td>
                                                       
                                                        <td style="border:none;" class="w-111sss tl">1. Tanya kenapa DTR & Ingatkan aturan</td>
                                                        <td style="border:none;" class="w-111ss2 tl">2. Semangati & berikan solusi</td>
                                                       
                                                        <td style="border:none;" class="w-220s tl">Kump. Awal (KC) = diisi "V" / "X"</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border:none;" class="w-111ss tl">4. Ibu Pulkam</td>
                                                        <td style="border:none;" class="w-111s tl">5. Ibu Pindah Rumah</td>
                                                        <td style="border:none;" class="w-111ss tl">6. Usaha Ibu Stop/Sepi</td>
                                                        
                                                        <td style="border:none;" class="w-111sss tl">3. Buat surat peringatan pelunasan</td>
                                                        <td style="border:none;" class="w-111ss2 tl">4. Akan pelunasan segera</td>
                                                        
                                                        <td style="border:none;" class="w-220s tl"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border:none;" class="w-111ss tl">7. Belum Ada Penjelasan</td>
                                                        <td style="border:none;" class="w-111s tl">8. Lainnya</td>
                                                        <td style="border:none;" class="w-111ss tl"></td>
                                                        
                                                        <td style="border:none;" class="w-111sss tl">5. FU penganggung jawab/keluarga</td>
                                                        <td style="border:none;" class="w-111ss2 tl">6. lainnya</td>
                                                        
                                                        <td style="border:none;" class="w-220s tl"></td>
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

  
</html>


</body>
<?php } else if($kab_kkb == "KKB") {?>
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
    height: 62px;
    text-align: center;
    font-size:16px;
}
.w-111{
    padding-right: 4px;
    width: 100px;
    height: 62px;
    text-align: center;
    font-size:16px;
}
.w-1{
    padding-right: 4px;
    width: 160px;
    height: 62px;
    text-align: center;
    font-size:16px;
}
.w-1x{
    padding-right: 4px;
    width: 260px;
    height: 14px;
    text-align: left;
    font-size:14px;
}
.w-1xx{
    padding-right: 4px;
    width: 160px;
    height: 14px;
    text-align: left;
    font-size:14px;
}
.w-12{
    padding-right: 4px;
    width: 140px;
    height: 62px;
    text-align: center;
    font-size:16px;
}
.w-2{
     font-size:16px;
   width: 50px;
    height: 62px; 
}
.w-22{
     font-size:16px;
   width: 60px;
    height: 62px; 
}
.w-220{
     font-size:16px;
   width: 500px;
    height: 62px; 
}
.w-220x{
     font-size:14px;
   width: 500px;
    height: 14px; 
    text-align:left;
}

.w-221{
     font-size:16px;
   width: 30px;
    height: 62px; 
}
.w-3{
     font-size:16px;
   width: 70px;
    height: 62px; 
}
.tr{
    text-align:right;
}
</style>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>LPKB_Cabang<?php echo $cabang;?>_<?php echo date("d/m/Y", strtotime($tanggal));?></title>

 


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
        
        $page_kkb = 1;
        
        if($jum_kab <= 7){
            $page_total = 1;
        } else if(($jum_kab > 7) && ($jum_kab <=14)){
            $page_total = 2;
        } else if(($jum_kab > 14) && ($jum_kab <=21)){
            $page_total = 3;
        } else if(($jum_kab > 21) && ($jum_kab <=28)){    
            $page_total = 4;
        } else {
            $page_total ="";
        }
            
        ?>
        <!-- Begin Page Content -->
        <div id="pdfdiv" class="container-fluid">
            <!-- DataTales Example -->
            <div class="row" style="display:inline-block;">
                <div class="col-md-12">
                    <div class="card" style="color:black;">
                        <div class="card-body">
                            <div>
                                <h2><b>Laporan Penanganan Kelompok Bermasalah (LPKB) -  Cabang <?php echo $cabang;?> - <?php echo $hari." ".date("d M Y", strtotime($tanggal));?> (<?php echo $page_kkb;?>/<?php echo $page_total;?>)</b></h2>
                            </div>                
                            
                            <div style="display:inline-block;">
                                <table class="table-bordered table-responsive-sm" style="margin-bottom:30px;">
                                    <tbody>
                                        <tr>
                                            <td>No</td>
                                            <td class="w-1">PKP</td>
                                            <td class="w-1">Nama Kelompok</td>
                                            <td class="w-22">Jml Anggota</td>
                                            <td class="w-3">Kasus Baru</td>
                                            <td class="w-3">Total mslh</td>
                                            <td class="w-111">Tgl Dikumpulkan?</td>
                                            <td class="w-22">Jml Anggota Kumpul</td>
                                            <td class="w-220">Hasil Pembahasan</td>
                                        </tr>
                                        <?php
                                        $i=0;
                                        $no = 0;    
                                        $nama_pkp="";
                                        foreach($data_list as $rowss){
                                            $i++;
                                            $id_kelompok = $rowss->id_sikki_kb;

                                            if($rowss->kode_kb=="3A"){
                                                $kode = "T";
                                            } else if($rowss->kode_kb=="3B"){
                                                $kode = "B";
                                            } else {
                                                $kode = "";
                                            }
                                            if($nama_pkp != $rowss->nama && $nama_pkp != $rowss->pkp_nama){
                                                $no = 0;
                                            }

                                            
                                            $no++;
                                            if($rowss->nama == ''){
                                                $nama_pkp = $rowss->pkp_nama;
                                            }else{
                                                $nama_pkp = $rowss->nama;
                                            }
                                            
                                            
                                            
                                        ?>
                                        <tr>
                                            <td><?php echo $no;?></td>
                                            <td class="w-1" style="text-align:left;"><?php echo $nama_pkp;?></td>
                                            <td class="w-1" style="text-align:left;"><?php echo $rowss->kelompok_kb;?></td>
                                            <td class="w-22"><?php echo $rowss->total_anggota;?></td>
                                            <td class="w-3" style="text-align:left;"><?php echo $kode."-".$rowss->menit_kb." mnt";?></td>
                                            <td class="w-3">B<?php echo $rowss->total3b;?> T<?php echo $rowss->total3a;?></td>
                                            <td class="w-111"></td>
                                            <td class="w-22"></td>
                                            <td class="w-220"></td>
                                        </tr>
                                        <?php
                                        if($i==7):
                                            $i=0;
                                            $page_kkb++;
                                        ?>
                                        </div>
                                            </tbody>
                                                </table>
                                                <table style="border:none;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="border:none;" class="w-220x" colspan="3">Kode <b>Hasil Pembahasan</b>: kode 1-5 ditulis angka, kode 6 wajib tulis keterangan hasil edukasi lainnya(mis: menemui RT/RW, membuat jadwal saksi agar bergantian, dll.)</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border:none;" class="w-1x">1. Dalami masalah & ingatkan aturan</td>
                                                            <td style="border:none;" class="w-1xx">2. Semangati & berikan solusi</td>
                                                            <td style="border:none;" class="w-1x">3. Buat surat peringatan pelunasan</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td style="border:none;" class="w-1x">4. Akan pelunasan minggu depan</td>
                                                            <td style="border:none;" class="w-1x">5. Datangi yang belum kumpul</td>
                                                            <td style="border:none;" class="w-1xx">6. Lainnya</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                       <div>
                                            <h2 style="margin-top:50px;"><b>Laporan Penanganan Kelompok Bermasalah (LPKB) -  Cabang <?php echo $cabang;?> - <?php echo $hari." ".date("d M Y", strtotime($tanggal));?> (<?php echo $page_kkb;?>/<?php echo $page_total;?>)</b></h2>
                                        </div>                
                                        
                                        <div style="display:inline-block;">
                                            <table class="table-bordered table-responsive-sm" style="margin-bottom:30px;">
                                                <tbody>
                                                    <tr>
                                                        <td>No</td>
                                                        <td class="w-1">PKP</td>
                                                        <td class="w-1">Nama Kelompok</td>
                                                        <td class="w-22">Jml Anggota</td>
                                                        <td class="w-3">Kasus Baru</td>
                                                        <td class="w-3">Total mslh</td>
                                                        <td class="w-111">Tgl Dikumpulkan?</td>
                                                        <td class="w-22">Jml Anggota Kumpul</td>
                                                        <td class="w-220">Hasil Pembahasan</td>
                                                    </tr>
                                        <?php endif;?>
                                        
                                        <?php }?>
                                        <?php if($i<7):
                                        while($i<7){
                                            $i++;
                                        
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td class="w-1"></td>
                                            <td class="w-1"></td>
                                            <td class="w-22"></td>
                                            <td class="w-3"></td>
                                            <td class="w-3"></td>
                                            <td class="w-111"></td>
                                            <td class="w-22"></td>
                                            <td class="w-220"></td>
                                        </tr>
                                        
                                        <?php } endif;?>
                                    </tbody>
                                </table>
                                <table style="border:none;">
                                    <tbody>
                                        <tr>
                                            <td style="border:none;" class="w-220x" colspan="3">Kode <b>Hasil Pembahasan</b>: kode 1-5 ditulis angka, kode 6 wajib tulis keterangan hasil edukasi lainnya(mis: menemui RT/RW, membuat jadwal saksi agar bergantian, dll.)</td>
                                        </tr>
                                        <tr>
                                            <td style="border:none;" class="w-1x">1. Dalami masalah & ingatkan aturan</td>
                                            <td style="border:none;" class="w-1xx">2. Semangati & berikan solusi</td>
                                            <td style="border:none;" class="w-1x">3. Buat surat peringatan pelunasan</td>
                                        </tr>
                                        <tr>
                                            <td style="border:none;" class="w-1x">4. Akan pelunasan minggu depan</td>
                                            <td style="border:none;" class="w-1x">5. Datangi yang belum kumpul</td>
                                            <td style="border:none;" class="w-1xx">6. Lainnya</td>
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

  
</html>
</body>

<!--rekap-->
<?php } else { ?>
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
    height: 24px;
    text-align: center;
    font-size:14px;
}
.w-111{
    padding-right: 4px;
    width: 100px;
    height: 24px;
    text-align: center;
    font-size:14px;
}
.w-1{
    padding-right: 4px;
    width: 160px;
    height: 24px;
    text-align: center;
    font-size:14px;
}
.w-12{
    padding-right: 4px;
    width: 140px;
    height: 24px;
    text-align: center;
    font-size:14px;
}
.w-2{
     font-size:14px;
   width: 35px;
    height: 24px; 
}
.w-22{
     font-size:14px;
   width: 80px;
    height: 20px; 
}
.w-220{
     font-size:14px;
   width: 500px;
    height: 24px; 
}

.w-221{
     font-size:14px;
   width: 60px;
    height: 24px; 
}
.w-3{
     font-size:14px;
   width: 110px;
    height: 24px; 
}
.tr{
    text-align:right;
}
</style>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Rekap_cbg<?php echo $cabang;?>_mngg_<?php echo date("d/m/Y", strtotime($awal));?></title>

 


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
                            <?php
                            if($cabang=="2"){
                                $cbg = "2 Koja";
                            } else if($cabang=="1"){
                                $cbg = "1 Marunda Cilincing";
                            } else if($cabang=="3"){
                                $cbg = "3 Tipar";
                            } else if($cabang=="4"){
                                $cbg = "4 Priok";
                            } else if($cabang=="5"){
                                $cbg = "5 Cakung";
                            } else if($cabang=="6"){
                                $cbg = "6";
                            } else if($cabang=="7"){
                                $cbg = "7";
                            } else {
                                $cbg = "";
                            }
                            ?>
                            <div>
                                <table style="border:none;">
                                    <tbody>
                                        <tr>
                                            <td style="border:none; text-align:left;" class="w-220"><h2><b>Form Rekap Penanganan Anggota & Kelompok Bermasalah</b></h2></td>
                                            <td style="border:none;">cbg</td>
                                            <td class="w-12" style="border:none; text-align:left;"><div style="height:20px;border: 0.1em solid #0a0808; padding:4px;"><?php echo $cbg;?></div></td>
                                            <td class="w-11" style="border:none; text-align:right;">Tanggal Awal Minggu:</td>
                                            <td class="w-111" style="border:none; text-align:left;"><div style="height:20px;border: 0.1em solid #0a0808;padding:4px;"><?php echo date("d/m/Y", strtotime($awal));?></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                
                            
                            <div style="display:inline-block;">
                                <table style="margin-bottom:45px; border:none;">
                                    <tbody>
                                        <tr>
                                            <td rowspan="2" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808; border-left: 0.1em solid #0a0808;">No</td>
                                            <td rowspan="2" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808;" class="w-11">Nama PKP</td>
                                            <td class="w-2" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808;"># DTR</td>
                                            <td class="w-2" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808;"># Agt Sdh Ditemui</td>
                                            <td class="w-2" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808;"># Klpk Telat</td>
                                            <td class="w-2" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808;"># Klpk Berat</td>
                                            <td class="w-2" style="border-right: 0.3em solid #0a0808; background-color:#c9c8bd; border-top: 0.1em solid #0a0808;"># Klpk Berat Sdh Dikumpulkan</td>
                                            <td class="w-2" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808;"># Agt Kabur</td>
                                            <td class="w-221" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808;"># Klpk Ada Agt Kabur</td>
                                            <td class="w-3" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808;"># Klpk Kabur Sdh Dikumpulkan (Awal Kabur)</td>
                                            <td class="w-22" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808;"># Klpk Kabur Kasus Telat/Berat</td>
                                            <td class="w-3" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808;"># Klpk Kabur Telat/Berat Sdh Dikumpulkan lagi</td>
                                            <td class="w-221" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808;"># Agt Aktif per PKP</td>
                                        </tr>
                                        <tr>
                                            <td class="w-2" style="background-color:#c9c8bd;">A</td>
                                            <td class="w-2" style="background-color:#c9c8bd;">B</td>
                                            <td class="w-2" style="background-color:#c9c8bd;">C</td>
                                            <td class="w-2" style="background-color:#c9c8bd;">D</td>
                                            <td class="w-2" style="border-right: 0.3em solid #0a0808; background-color:#c9c8bd;">E</td>
                                            <td class="w-2" style="background-color:#c9c8bd;">F</td>
                                            <td class="w-221" style="background-color:#c9c8bd;">G</td>
                                            <td class="w-3" style="background-color:#c9c8bd;">H</td>
                                            <td class="w-22" style="background-color:#c9c8bd;">I</td>
                                            <td class="w-3" style="background-color:#c9c8bd;">J</td>
                                            <td class="w-221" style="background-color:#c9c8bd;">K</td>
                                        </tr>
                                        <?php
                                        $i=0;
                                        $t_dtr=0;
                                        $t_telat=0;
                                        $t_berat=0;
                                        foreach($data_list as $rows){
                                            $pkp = $rows->id;
                                            $i++;
                                           
                                            $t_dtr = $t_dtr+$rows->dtr;
                                            $t_telat = $t_telat+$rows->kode3a;
                                            $t_berat = $t_berat+$rows->kode3b;
                                        ?>
                                        <tr>
                                            <td style="background-color:#c9c8bd; border-left: 0.1em solid #0a0808;"><?php echo $i;?></td>
                                            <td class="w-11" style="text-align:left;"><?php echo $rows->nama;?></td>
                                            <td class="w-2"><?php echo $rows->dtr;?></td>
                                            <td class="w-2"></td>
                                            <td class="w-2"><?php if(!empty($rows->kode3a)){ echo $rows->kode3a; } else { echo 0;}?></td>
                                            <td class="w-2"><?php if(!empty($rows->kode3b)){ echo $rows->kode3b; } else { echo 0;}?></td>
                                            <td class="w-2" style="border-right: 0.3em solid #0a0808;"></td>
                                            <td class="w-2"></td>
                                            <td class="w-221"></td>
                                            <td class="w-3"></td>
                                            <td class="w-22"></td>
                                            <td class="w-3"></td>
                                            <td class="w-221"></td>
                                        </tr>
                                         <?php }?>
                                        <?php if($i<8):
                                        while($i<8){
                                            $i++;
                                        
                                        ?>
                                        <tr>
                                            <td style="background-color:#c9c8bd; border-left: 0.1em solid #0a0808;"><?php echo $i;?></td>
                                            <td class="w-11"></td>
                                            <td class="w-2"></td>
                                            <td class="w-2"></td>
                                            <td class="w-2"></td>
                                            <td class="w-2"></td>
                                            <td class="w-2" style="border-right: 0.3em solid #0a0808;"></td>
                                            <td class="w-2"></td>
                                            <td class="w-221"></td>
                                            <td class="w-3"></td>
                                            <td class="w-22"></td>
                                            <td class="w-3"></td>
                                            <td class="w-221"></td>
                                        </tr>
                                        
                                        <?php } endif;?>
                                        <tr>
                                            <td class="w-11" colspan="2" style="background-color:#c9c8bd; border-left: 0.1em solid #0a0808;">TOTAL</td>
                                            <td class="w-2"><?php echo $t_dtr;?></td>
                                            <td class="w-2"></td>
                                            <td class="w-2"><?php echo $t_telat;?></td>
                                            <td class="w-2"><?php echo $t_berat;?></td>
                                            <td class="w-2" style="border-right: 0.3em solid #0a0808;"></td>
                                            <td class="w-2"></td>
                                            <td class="w-221"></td>
                                            <td class="w-3"></td>
                                            <td class="w-22"></td>
                                            <td class="w-3"></td>
                                            <td class="w-221"></td>
                                        </tr>
                                        
                                        <tr>
                                            <td class="w-11" colspan="13" style="border:none; height:5px;"></td>
                                        </tr>
                                        <tr>
                                            <td class="w-11" colspan="2" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808; border-left: 0.1em solid #0a0808; border-bottom:none;">%</td>
                                            <td class="w-2" colspan="3" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808; border-bottom:none;"># DTR</td>
                                            <td class="w-2" colspan="2" style="background-color:#c9c8bd; border-right: 0.3em solid #0a0808; border-top: 0.1em solid #0a0808; border-bottom:none;">% Agt Sdh</td>
                                            <td class="w-2" colspan="2" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808; border-bottom:none;">%</td>
                                            <td class="w-2" colspan="2" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808; border-bottom:none;">% Klpk Kabur Sdh</td>
                                            <td class="w-2" colspan="2" style="background-color:#c9c8bd; border-top: 0.1em solid #0a0808; border-bottom:none;">% Klpk Kabur</td>
                                        </tr>
                                        <tr>
                                            <td class="w-11" colspan="2" style="background-color:#c9c8bd; border-left: 0.1em solid #0a0808;">DTR</td>
                                            <td class="w-2" colspan="3" style="background-color:#c9c8bd; ">Non Kabur</td>
                                            <td class="w-2" colspan="2" style="background-color:#c9c8bd; border-right: 0.3em solid #0a0808; ">Ditemui</td>
                                            <td class="w-2" colspan="2" style="background-color:#c9c8bd;">Kabur</td>
                                            <td class="w-2" colspan="2" style="background-color:#c9c8bd;">Dikumpulkan (Awal Kabur)</td>
                                            <td class="w-2" colspan="2" style="background-color:#c9c8bd;">Tepat Waktu</td>
                                        </tr>
                                        <tr>
                                            <td class="w-11" colspan="2" style="background-color:#c9c8bd; border-left: 0.1em solid #0a0808;">L</td>
                                            <td class="w-2" colspan="3" style="background-color:#c9c8bd; ">M</td>
                                            <td class="w-2" colspan="2" style="background-color:#c9c8bd; border-right: 0.3em solid #0a0808; ">N</td>
                                            <td class="w-2" colspan="2" style="background-color:#c9c8bd;">O</td>
                                            <td class="w-2" colspan="2" style="background-color:#c9c8bd;">P</td>
                                            <td class="w-2" colspan="2" style="background-color:#c9c8bd;">Q</td>
                                        </tr>
                                        <tr>
                                            <td class="w-11" colspan="2" style="border-left: 0.1em solid #0a0808; height:65px;"><img style="max-height:56px; max-width:90%;" src="{{ asset('assets/L.png') }}"></td>
                                            <td class="w-2" colspan="3" style="height:65px;"><img style="max-height:56px; max-width:90%;" src="{{ asset('assets/M.png') }}"></td>
                                            <td class="w-2" colspan="2" style="border-right: 0.3em solid #0a0808; height:65px;"><img style="max-height:56px; max-width:90%;" src="{{ asset('assets/N.png') }}"></td>
                                            <td class="w-2" colspan="2" style="height:65px;"><img style="max-height:56px; max-width:90%;" src="{{ asset('assets/O.png') }}"></td>
                                            <td class="w-2" colspan="2" style="height:65px;"><img style="max-height:56px; max-width:90%;" src="{{ asset('assets/P.png') }}"></td>
                                            <td class="w-2" colspan="2" style="height:65px;"><img style="max-height:56px; max-width:90%;" src="{{ asset('assets/Q.png') }}"></td>
                                        </tr>
                                        <tr>
                                            <td class="w-11" colspan="13" style="border:none; height:5px;"></td>
                                        </tr>
                                        <tr>
                                            <td class="w-11" colspan="13" style="border-top: 0.1em solid #0a0808; text-align:left; border-bottom:none;">Catatan:</td>
                                        </tr>
                                        <tr>
                                            <td class="w-11" colspan="13" style="border-left: 0.1em solid #0a0808; text-align:left; height:70px; "></td>
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

  
</html>

   
   

</body>
<?php }?>


