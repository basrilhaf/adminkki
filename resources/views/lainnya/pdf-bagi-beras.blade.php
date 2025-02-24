<!DOCTYPE html>
<html lang="en">
<style>
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
.w-1{
    width: 200px;
    height: 35px;
    font-size:18px;
}
.w-4{
    width: 450px;
    height: 35px;
    font-size:17px;
}
.w-2{
   width: 100px;
    height: 35px; 
    font-size:18px;
}
.w-2s{
   width: 100px;
    height: 25px; 
    font-size:18px;
}
.w-2ss{
   width: 80px;
    height: 25px; 
    font-size:18px;
}
.w-3{
   width: 40px;
    height: 35px; 
    font-size:18px;
}
.w-3s{
   width: 40px;
    height: 25px; 
    font-size:18px;
}

.w-5{
   width: 150px;
    height: 35px; 
    font-size:18px;
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
   
  <title>Daftar Penerima Beras </title>

 


</head>

<body>
    
<?php if(!empty($list_data)){
    foreach($list_data as $row){
    ?>
    <div class="container-fluid">
          <!-- DataTales Example -->
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="color:black;">
                    
                    <div>
                        <h2 style="margin-block-start: 0.1em;margin-block-end: 1em;" class="tl"><b>Form Tanda Terima Anggota (TTA) - BERAS 2022</b></h2>
                        <table class="bn" style="margin-bottom:15px;">
                            <tbody>
                                <tr>
                                    <td class="bn w-2s tl">Tanggal:</td>
                                    <td class="w-2s tl" style="border-left: 0.01em solid #0a0808;border-top: 0.01em solid #0a0808; font-size:14px;"><?php echo date('d-m-Y',strtotime ($row[2]));?></td>
                                    <td class="bn w-2s tr">Gudang:</td>
                                    <td class="w-2s tl" style="border-left: 0.01em solid #0a0808;border-top: 0.01em solid #0a0808;  font-size:15px;"><?php echo $row[3];?></td>
                                    <!--<td class="bn w-2s tr">Mobil:</td>
                                    <td class="w-2s tl" style="border-left: 0.01em solid #0a0808;border-top: 0.01em solid #0a0808;  font-size:15px;"><?php echo $row[4];?></td>-->
                                    
                                </tr>
                                <tr>
                                    <td colspan="6" class="bn" style="height:10px;"></td>
                                </tr>
                                <tr>
                                    <td class="bn w-2s tl">Kelompok:</td>
                                    <td class="w-2s tl" colspan="2" style="border-left: 0.01em solid #0a0808;border-top: 0.01em solid #0a0808; font-size:15px;"><?php echo $row[0];?></td>
                                    
                                    <td class="w-2s tl bn">Cbg: <?php echo $row[3];?></td>
                                    <td class="bn w-2s tr"># Paket:</td>
                                    <td class="w-2s tl" style="border-left: 0.01em solid #0a0808;border-top: 0.01em solid #0a0808;  font-size:15px;"><?php echo $row[6];?></td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="tl" style="font-size:18px;margin-block-start: 0.1em;margin-block-end: 0.4em;">Saya yang bertanda tangan di bawah ini menyatakan bahwa <b>sudah menerima paket beras 5 kg </b>dari Koperasih Kasih Indonesia</p>
                       <div style="margin-top:10px; margin-bottom:20px;">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="w-3"><b>No.</b></td>
                                        <td class="w-2"><b>ID</b></td>
                                        <td class="w-4"><b>Nama</b></td>
                                        <td class="w-2ss"><b>Kabur ?</b></td>
                                        <td class="w-5"><b>TTD Penerima</b></td>
                                        <td class="w-1"><b>Nama Wakil</b></td>
                                    </tr>
                                    <?php
                                   
                                    
                                    $no=0;
                                    if(isset($row['additional_data'])){
                                    foreach($row['additional_data'] as $additional){
                                        $no++;
                                        
                                    ?>
                                    <tr>
                                        <td class="w-3"><?php echo $no;?></td>
                                        <td class="w-2 tl"><?php echo $additional->nasabah_id;?></td>
                                        <td class="w-4 tl"><?php echo $additional->NAMA_NASABAH;?></td>
                                        <td class="w-2ss"></td>
                                        <td class="w-5"></td>
                                        <td class="w-1 tl"></td>
                                    </tr>
                                    <?php }}
                                    if($no < 11):
                                        while($no < 11){
                                            $no++;
                                        
                                    ?>
                                    <tr>
                                        <td class="w-3"><?php echo $no;?></td>
                                        <td class="w-2 tl"></td>
                                        <td class="w-4 tl"></td>
                                        <td class="w-2ss tl"></td>
                                        <td class="w-5 tl"></td>
                                        <td class="w-1"></td>
                                    </tr>
                                    
                                    <?php } endif;?>
                                </tbody>
                            </table>
                             <p class="tl" style="font-size:18px;margin-block-start: 0.1em;margin-block-end: 0.4em;"><b>Ibu-Ibu, semoga berkah yang diterima bermanfaat untuk keluarga ya :)</b></p>
                            <!--<p class="tl" style="font-size:18px;margin-block-start: 0.1em;margin-block-end: 0.4em;">Mohon hal-hal berikut ini diingat dan dilakukan ya Bu:</p>-->
                            <p class="tl" style="font-size:18px;margin-block-start: 0.1em;margin-block-end: 0.4em;"><b></b>Penerima Sembako <b>TTD sesuai baris nama Anggota.</b> Bila tidak mengambil sendiri, tolong tuliskan juga <b>nama yang mewakilkan.</b></p>
                            <!--<p class="tl" style="font-size:18px;margin-block-start: 0.1em;margin-block-end: 0.4em;"><b>2.</b> Ibu-Ibu <b>tolong tunggu sampai Petugas datang.</b> Jangan pulang dulu dan jangan membawa pulang beras sampai Petugas hadir.</p>-->
                            
                            <table class="bn" style="margin-top:10px;">
                                <tbody>
                                    <tr>
                                        <td rowspan="4" style="width:300px; border-left: 0.01em solid #0a0808;border-top: 0.01em solid #0a0808; vertical-align: top; text-align: left;">Catatan:</td>
                                        <td class="w-2s tr bn" style="font-size:15px;">Nama Petugas:</td>
                                        <td class="w-1 tl" style="width:210px; border-left: 0.01em solid #0a0808;border-top: 0.01em solid #0a0808;"><?php echo $row[5];?></td>
                                    </tr>
                                    <tr>
                                        <td class="bn" colspan="2" style="height:10px;"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-2s tr bn" style="font-size:16px;">TTD Petugas:</td>
                                        <td class="w-1" rowspan="2" style="width:210px; border-left: 0.01em solid #0a0808;border-top: 0.01em solid #0a0808;"></td>
                                    </tr>
                                    <tr>
                                        <td class="bn" style="height:120px;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    
                        
                </div>
            </div>  
        </div>
    </div>
<?php }} ?>
</html>

   
   

</body>
