<?php if($kabkkb == "KAB"){?>
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
    width: 180px;
    height: 18px;
    text-align: center;
    font-size:14px;
}
.w-111s{
    padding-right: 4px;
    width: 250px;
    height: 22px;
    text-align: center;
    font-size:14px;
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
.w-33{
     font-size:14px;
   width: 100px;
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

  <title>LPAB_Cabang<?php echo $cabang;?>_<?php echo date("d/m/Y", strtotime($awal));?></title>

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
                            <div style="margin-bottom:5px;">
                                <span style="font-size:18px; "><b>LPAB Belum Dikunjungi -  Cabang <?php echo $cabang;?> - <?php echo date("d M Y", strtotime($awal))." s/d ".date("d M Y", strtotime($akhir));?></b></span>
                            </div>               
                            
                            <div style="display:inline-block;">
                                <table class="table-bordered table-responsive-sm" style="margin-bottom:0px;">
                                    <tbody>
                                        <tr>
                                            <td class="w-221">No</td>
                                            <td class="w-111">PKP</td>
                                            <td class="w-111">Nama Ibu</td>
                                            <td class="w-111">Kelompok</td>
                                            <td class="w-3">Jml DTR</td>
                                            <td class="w-33">Tanggal Bermasalah</td>
                                            
                                        </tr>
                                        <?php
                                        // dd($results);
                                        $i=0;
                                        $no=0;
                                        $nama_pkp="";
                                            
                                        foreach ($results as $rowss) {
                                            $i++;
                                            $id_anggota = $rowss->id_anggota_ab;
                                            
                                            if($nama_pkp != $rowss->nama){
                                                $no = 0;
                                            }
                                            $no ++;
                                            $jum = count($results);
                                            $nama_pkp = $rowss->nama;
                                        ?>
                                        <tr>
                                            <td class="w-221"><?php echo $no;?></td>
                                            <td class="w-111 tl"><?php echo $rowss->nama;?></td>
                                            <td class="w-111 tl"><?php echo $rowss->nama_ab;?></td>
                                            <td class="w-111 tl"><?php echo $rowss->kelompok_ab;?></td>
                                            <td class="w-3"><?php echo $rowss->jumlah;?></td>
                                            <td class="w-33"><?php echo $rowss->tanggal_ab;?></td>
                                            
                                        </tr>
                                        
                                        <!--jika lebih dari 36 data-->
                                        <?php if($i==46):
                                        $i=0;
                                        ?>
                                        
                                        
                                        
                                                </tbody>  
                                            </table>
                                            
                                        </div>
                                            
                                                
                                        <div style="margin-bottom:5px;">
                                            <span style="font-size:18px; "><b>LPAB Belum Dikunjungi -  Cabang <?php echo $cabang;?> - <?php echo date("d M Y", strtotime($awal))." s/d ".date("d M Y", strtotime($akhir));?></b></span>
                                        </div>               
                                        
                                        <div style="display:inline-block;">
                                            <table class="table-bordered table-responsive-sm" style="margin-bottom:0px;">
                                                <tbody>
                                                    <tr>
                                                        <td class="w-221">No</td>
                                                        <td class="w-111">PKP</td>
                                                        <td class="w-111">Nama Ibu</td>
                                                        <td class="w-111">Kelompok</td>
                                                        <td class="w-3">Jml DTR</td>
                                                        <td class="w-33">Tanggal Bermasalah</td>
                                                    </tr>
                                        <?php endif;?>
                                        <?php }?>
                                        
                                        
                                        <!--jika data kurang dari 36-->
                                        <?php if($i<46):
                                        while($i<46){
                                            $i++;
                                        
                                        ?>
                                        <tr>
                                            <td class="w-221"></td>
                                            <td class="w-111"></td>
                                            <td class="w-111"></td>
                                            <td class="w-111"></td>
                                            <td class="w-3"></td>
                                            <td class="w-33"></td>
                                            
                                        </tr>
                                        
                                        <?php } endif;?>
                                        
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
<?php } else if($kabkkb == "KKB") {?>
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
    font-size:14px;
}
.w-111{
    padding-right: 4px;
    width: 100px;
    height: 22px;
    text-align: center;
    font-size:14px;
}
.w-1{
    padding-right: 4px;
    width: 160px;
    height: 22px;
    text-align: center;
    font-size:14px;
}
.w-12{
    padding-right: 4px;
    width: 140px;
    height: 22px;
    text-align: center;
    font-size:14px;
}
.w-2{
     font-size:14px;
   width: 50px;
    height: 22px; 
}
.w-22{
     font-size:14px;
   width: 60px;
    height: 22px; 
}
.w-220{
     font-size:14px;
   width: 500px;
    height: 22px; 
}

.w-221{
     font-size:14px;
   width: 30px;
    height: 62px; 
}
.w-3{
     font-size:14px;
   width: 70px;
    height: 22px; 
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

  <title>LPKB_Belum_dikumpulkan_Cabang<?php echo $_GET["cabang"];?>_<?php echo date("d/m/Y", strtotime($awal));?>_sd_<?php echo date("d/m/Y", strtotime($akhir));?></title>

 


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
                            <div>
                                <h3><b>LPKB belum dikumpulkan -  Cabang <?php echo $_GET["cabang"];?> - <?php echo date("d M Y", strtotime($awal))." s/d ".date("d M Y", strtotime($akhir));?></b></h2>
                            </div>                
                            
                            <div style="display:inline-block;">
                                <table class="table-bordered table-responsive-sm" style="margin-bottom:45px;">
                                    <tbody>
                                        <tr>
                                            <td>No</td>
                                            <td class="w-1">PKP</td>
                                            <td class="w-1">Nama Kelompok</td>
                                            <td class="w-22">Tanggal Bermasalah</td>
                                            <td class="w-3">Kasus Baru</td>
                                            <td class="w-3">Total mslh</td>
                                            
                                        </tr>
                                        <?php
                                        $i=0;
                                        $no = 0;    
                                        $nama_pkp="";
                                        foreach ($results as $rowss) {
                                            $i++;
                                            $nama_kelompok = $rowss->kelompok_kb;
                                            if($rowss->kode_kb=="3A"){
                                                $kode = "T";
                                            } else if($rowss->kode_kb=="3B"){
                                                $kode = "B";
                                            } else {
                                                $kode = "";
                                            }
                                            
                                            if($rowss->nama != $nama_pkp){
                                                $no=0;
                                            }
                                            $no++;
                                            $nama_pkp = $rowss->nama;
                                            
                                            // $queee2=$mysqli->query("SELECT kelompok_kb,
                                            // SUM(IF( kode_kb = '3A', 1, 0)) AS kode3a,
                                            // SUM(IF( kode_kb = '3B', 1, 0)) AS kode3b
                                            
                                            // FROM kelompok_bermasalah
                                            // WHERE kelompok_kb = '$nama_kelompok'
                                            // GROUP BY kelompok_kb");
                                            // $rowsss=mysqli_fetch_array($queee2);
                                           
                                        ?>
                                        <tr>
                                            <td><?php echo $no;?></td>
                                            <td class="w-1" style="text-align:left;"><?php echo $rowss->nama;?></td>
                                            <td class="w-1" style="text-align:left;"><?php echo $rowss->kelompok_kb;?></td>
                                            <td class="w-22"><?php echo date("d/m/Y", strtotime($rowss->tanggal_kb));?></td>
                                            <td class="w-3" style="text-align:left;"><?php echo $kode."-".$rowss->menit_kb." mnt";?></td>
                                            <td class="w-3">B<?php echo $rowss->kode3b;?> T<?php echo $rowss->kode3a;?></td>
                                            
                                        </tr>
                                        <?php
                                        if($i==36):
                                            $i=0;
                                        ?>
                                        </div>
                                            </table>
                                                </tbody>
                                       <div>
                                            <h3><b>LPKB belum dikumpulkan -  Cabang <?php echo $_GET["cabang"];?> - <?php echo date("d M Y", strtotime($awal))." s/d ".date("d M Y", strtotime($akhir));?></b></h2>
                                        </div>                
                                        
                                        <div style="display:inline-block;">
                                            <table class="table-bordered table-responsive-sm" style="margin-bottom:45px;">
                                                <tbody>
                                                    <tr>
                                                        <td>No</td>
                                                        <td class="w-1">PKP</td>
                                                        <td class="w-1">Nama Kelompok</td>
                                                        <td class="w-22">Tanggal Bermasalah</td>
                                                        <td class="w-3">Kasus Baru</td>
                                                        <td class="w-3">Total mslh</td>
                                                        
                                                    </tr>
                                        <?php endif;?>
                                        
                                        <?php }?>
                                        <?php if($i<36):
                                        while($i<36){
                                            $i++;
                                        
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td class="w-1"></td>
                                            <td class="w-1"></td>
                                            <td class="w-22"></td>
                                            <td class="w-3"></td>
                                            <td class="w-3"></td>
                                            
                                        </tr>
                                        
                                        <?php } endif;?>
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
  
<?php }?>
