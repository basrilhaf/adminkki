<!DOCTYPE html>
<html lang="en">
<style>
body{
    font-family: Arial, Helvetica, sans-serif;
}
td{
    padding-left:3px;
}    
   table {
    border-left: 0.01em solid #0a0808;
    border-right: 0;
    border-top: 0.01em solid #0a0808;
    border-bottom: 0;
    border-collapse: collapse;
    border-spacing: 0;
}
table td,
table th {
    text-align: center;
    border-left: 0;
    border-right: 0.01em solid #0a0808;
    border-top: 0;
    border-bottom: 0.01em solid #0a0808;
    border-spacing: 0;
}
.tr-2{
    padding-left:23px;
    padding-right:30px;
}
.tr-3{
    padding-left:20px;
    padding-right:35px;
}
.tr-4{
    padding-left:20px;
    padding-right:40px;
}
.w-1{
    width: 290px;
    height: 27px;
    font-size:16px;
}
.w-4{
    width: 450px;
    height: 27px;
    font-size:16px;
}
.w-2{
   width: 95px;
    height: 27px; 
    font-size:16px;
}
.w-2a{
   width: 85px;
    height: 27px; 
    font-size:16px;
}
.w-2s{
   width: 95px;
    height: 27px; 
    font-size:16px;
}
.w-2ss{
   width: 140px;
    height: 27px; 
    font-size:16px;
}
.w-3{
   width: 40px;
    height: 27px; 
    font-size:16px;
}

.w-5{
   width: 200px;
    height: 27px; 
    font-size:16px;
}

.w-6{
   width: 75px;
    height: 27px; 
    font-size:16px;
}

.tl{
    text-align:left;
}

.tr{
    text-align:right;
}

.bn{
    border:none;
}
/* Dashed red border */
hr.new2 {
  border-top: 1px dashed black;
  padding-top:10px;
}
</style>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
   
  <title>Tanggapan untuk Materi Cab <?php echo $cabang;?> Hari <?php echo $hari_bahasa;?></title>

 


</head>

<body>
  
        <!-- Begin Page Content -->
    <div id="pdfdiv" class="container-fluid">
          <!-- DataTales Example -->
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="color:black;">
                    <?php foreach($data_kelompok as $data_kelompok){?>
                    <!--kehadiran-->
                    <div>
                        <table class="bn">
                            <tr>
                                <td class="bn" style="width:1080px;"><img src="{{ asset('assets/header.png') }}" style="height:60px; width:100%;" rowspan="2"></td>
                            </tr>
                            
                        </table>
                        <h3 style="margin-block-start: 0.1em;margin-block-end: 0.2em; font-size:1.3em;" class="tl"><b>Daftar Hadir, Tanda Terima & Tanggapan Materi RAT 2024 (<?php echo $data_kelompok->deskripsi_group1;?> / Cbg <?php echo $cabang;?> / <?php echo $hari_bahasa;?>)</b></h2>
                        <p style="margin-block-start: 0.1em;margin-block-end: 0.3em;font-size:16px; text-align:justify;">Saya yang bertanda tangan di bawah ini menyatakan: <b>a)</b> sudah menerima dan membaca materi RAT KKI Tahun Buku 2024; <b>b)</b> berpartisipasi dalam RAT KKI Tahun Buku 2024 secara tertulis; <b>c)</b> sudah memberi tanggapan sesuai isian di bawah ini; dan <b>d)</b> mengisi dan menandatangani secara sukarela dan tanpa paksaan pihak mana pun.</p>
                        <p style="margin-block-start: 0.1em;margin-block-end: 0.3em;font-size:16px; text-align:justify;"><b>WAJIB ISI SEMUA KOLOM. </b>Selain kolom TTD, isi dengan: <b>(V) = Setuju</b>, atau <b>(X) = Tidak setuju</b>. Bila kosong artinya tidak memberi pendapat.</p>
                        
                        <div>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="w-3" style="height:40px;"><b>No.</b></td>
                                        <td class="w-1" style="height:40px;"><b>Nama Anggota</b></td>
                                        <td class="w-6" style="height:40px;"><b>No Agt</b></td>
                                        <td class="w-2"><b>A.<br> Lap. Pengawas 2024</b></td>
                                        <td class="w-2"><b>B.<br> Lap. Pengurus 2024</b></td>
                                        <td class="w-2"><b>C.<br> Hasil Keuangan 2024</b></td>
                                        <td class="w-2"><b>D.<br> Penggu- naan SHU 2024</b></td>
                                        <td class="w-2"><b>E. Rencana Kerja & Anggaran 2025</b></td>
                                        <td class="w-2"><b>TTD (Wajib)</b></td>
                                    </tr>
                                    <?php
                                    $noh=0;
                                    foreach($data_kelompok->nasabah_list as $nasabah){
                                        $noh++;
                                    ?>
                                    <tr>
                                        <td class="w-3" style="height:29px;"><?php echo $noh;?></td>
                                        <td class="w-1 tl" style="height:29px;"><?php echo $nasabah->NAMA_NASABAH;?></td>
                                        <td class="w-6 tl" style="height:29px;"><?php echo $nasabah->nasabah_id;?></td>
                                        <td class="w-2 tl"></td>
                                        <td class="w-2 tl"></td>
                                        <td class="w-2 tl"></td>
                                        <td class="w-2 tl"></td>
                                        <td class="w-2 tl"></td>
                                        <!--<td class="w-4 tl" style="height:42px;"><?php echo $nasabah->ALAMAT;?>, rt </td>-->
                                        <td class="w-2 tl"></td>
                                    </tr>
                                    <?php }
                                    if($noh < 11):
                                        while($noh < 11){
                                            $noh++;
                                        
                                    ?>
                                    <tr>
                                        <td class="w-3" style="height:29px;"><?php echo $noh;?></td>
                                        <td class="w-1 tl" style="height:29px;"></td>
                                        <td class="w-6 tl"></td>
                                        <td class="w-2 tl"></td>
                                        <td class="w-2 tl"></td>
                                        <td class="w-2 tl"></td>
                                        <td class="w-2 tl"></td>
                                        <td class="w-2 tl"></td>
                                        <td class="w-2 tl"></td>
                                    </tr>
                                    
                                    <?php } endif;?>
                                </tbody>
                            </table>
                            
                            <p style="margin-block-start: 0.5em;margin-block-end: 0.6em;font-size:15px; text-align:left;">Bila ada masukan, silakan tulis masukan+nama Ibu di kotak di bawah ini atau di balik kertas ini agar KKI bisa semakin baik mendukung Ibu.</p>
                            <table>
                                <tr>
                                    <tbody>
                                        <td style="width:1080px;height:65px; border-top: 0.01em solid #0a0808;"></td>
                                    </tbody>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!--bagian 2-->
                    <?php }?>
                    
                        
                </div>
            </div>  
        </div>
    </div>
          

</html>

   
   

</body>
