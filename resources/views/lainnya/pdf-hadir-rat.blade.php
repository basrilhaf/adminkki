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
    width: 300px;
    height: 42px;
    font-size:19px;
}
.w-4{
    width: 450px;
    height: 42px;
    font-size:18px;
}
.w-2{
   width: 100px;
    height: 42px; 
    font-size:19px;
}
.w-3{
   width: 40px;
    height: 42px; 
    font-size:18px;
}

.w-5{
   width: 150px;
    height: 42px; 
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
    
  <title>Daftar Hadir Cab  Hari </title>

 


</head>

<body>
    <?php foreach($data_kelompok as $data_kelompok){?>
      
        <!-- Begin Page Content -->
    <div id="pdfdiv" class="container-fluid">
          <!-- DataTales Example -->
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="color:black;">
                    
                    <div>
                        <table class="bn">
                            <tr>
                                <td class="bn" style="width:1080px;"><img src="{{ asset('assets/header.png') }}" style="height:70px; width:100%;" rowspan="2"></td>
                            </tr>
                            
                        </table>
                        <h2 style="margin-block-start: 0.1em;margin-block-end: 0.2em;" class="tl"><b>Daftar Hadir & Tanda Terima ( {{$data_kelompok->deskripsi_group1}}/ cbg {{$cabang}} / {{$hari_bahasa}})</b></h2>
                        <p style="margin-block-start: 0.1em;margin-block-end: 0.3em;font-size:18px; text-align:justify;">Saya yang bertanda tangan di bawah ini menyatakan: <b>a)</b> sudah menerima materi RAT KKI Tahun Buku 2022; <b>b)</b> berpartisipasi dalam RAT KKI Tahun Buku 2022 secara tertulis; dan <b>c)</b> menandatangani secara sukarela dan tanpa paksaan pihak mana pun.</p>
                        <div>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="w-3"><b>No.</b></td>
                                        <td class="w-1"><b>Nama Anggota</b></td>
                                        <td class="w-2"><b>Nomor Anggota</b></td>
                                        <td class="w-4"><b>Alamat Anggota</b></td>
                                        <td class="w-5"><b>TTD (Wajib)</b></td>
                                    </tr>
                                    <?php 
                                    $no = 0;
                                    foreach($data_kelompok->nasabah_list as $nasabah){
                                        $no++;
                                        ?>
                                    <tr>
                                        <td class="w-3">{{$no}}</td>
                                        <td class="w-1 tl">{{$nasabah->NAMA_NASABAH}}</td>
                                        <td class="w-2 tl">{{$nasabah->nasabah_id}}</td>
                                        <td class="w-4 tl">{{$nasabah->ALAMAT}}</td>
                                        <td class="w-5"></td>
                                    </tr>
                                    <?php }
                                    if($no < 11):
                                        while($no < 11){
                                            $no++;
                                        
                                    ?>
                                    
                                    <tr>
                                        <td class="w-3">{{$no}}</td>
                                        <td class="w-1 tl"></td>
                                        <td class="w-2 tl"></td>
                                        <td class="w-4 tl"></td>
                                        <td class="w-5"></td>
                                    </tr>
                                    <?php } endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    
                        
                </div>
            </div>  
        </div>
    </div>
    <?php } ?>
</html>

   
   

</body>
