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

.w-111{
    padding-right: 4px;
    width: 180px;
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
   width: 260px;
    height: 18px; 
}

.w-3{
     font-size:14px;
   width: 45px;
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

  <title>Laporan Nasabah/Kelompok Bermasalah</title>

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
            p {
                display: block;
                margin-block-start: 0.1em;
                margin-block-end: 0.1em;
                margin-inline-start: 0px;
                margin-inline-end: 0px;
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
                                <span style="font-size:18px; "><b>B1. Laporan Nasabah/Kelompok Bermasalah Cabang <?php echo $cabang;?> <?php echo date("d M Y", strtotime($awal))." s/d ".date("d M Y", strtotime($akhir))?></b></span>
                            </div>               
                            
                            <div style="display:inline-block;">
                                <table class="table-bordered table-responsive-sm" style="margin-bottom:0px;">
                                    <tbody>
                                        <tr>
                                            <td class="w-33">No</td>
                                            <td class="w-111">Kode Nama Tim</td>
                                            <td class="w-3">&#931; Agt DTR</td>
                                            <td class="w-3">&#931; Kel DTR</td>
                                            <td class="w-3">&#931; DTR 1x</td>
                                            <td class="w-3">&#931; DTR 2-3x</td>
                                            <td class="w-3">&#931; DTR >3x</td>
                                            <td class="w-3">&#931; Agt Kabur</td>
                                            <td class="w-220">Nama Anggota Kabur</td>
                                            <td class="w-220">No Kel Anggota Kabur</td>
                                        </tr>
                                        <?php
                                        $i=0;
                                        $no=0;
                                            foreach($results as $row){ 
                                            $i++;
                                            
                                            $dtr1=0;
                                            $dtr2=0;
                                            $dtr3=0;
                                            $nama_ab = "";
                                            $kel_ab ="";
                                            $nox=1;
                                            $kabur = 0;
                                            foreach($row->anggota_ids as $rowx){
                                                $kabur = $kabur + $rowx->totalKabur;
                                                $dtr1 = $dtr1 + $rowx->dtr1;
                                                $dtr2 = $dtr2 + $rowx->dtr2;
                                                $dtr3 = $dtr3 + $rowx->dtr3;

                                                $nama_ab = $rowx->nama_ab;
                                                $kel_ab = $rowx->kel_ab;
                                            }
                                            
                                            
                                            $anggota_dtr = $row->anggota_summary;
                                            $total_anggota_dtr = $anggota_dtr->total;

                                            $kelompok_dtr = $row->kelompok_summary;
                                            $total_kelompok_dtr = $kelompok_dtr->total;

                                           
                                        ?>
                                        <tr>
                                            <td class="w-33"><?php echo $i;?></td>
                                            <td class="w-111 tl"><?php echo $row->nama;?></td>
                                            <td class="w-3">{{$total_anggota_dtr}}</td>
                                            <td class="w-3">{{$total_kelompok_dtr}}</td>
                                            <td class="w-3"><?php echo $dtr1;?></td>
                                            <td class="w-3"><?php echo $dtr2;?></td>
                                            <td class="w-3"><?php echo $dtr3;?></td>
                                            <td class="w-3">{{$kabur}}</td>
                                            <td class="w-220 tl" style="vertical-align: text-top;">{!! $nama_ab !!}</td>
                                            <td class="w-220 tl" style="vertical-align: text-top;">{!! $kel_ab !!}</td>
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
</html>
</body>
<?php } else {?>
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

.w-111{
    padding-right: 4px;
    width: 180px;
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
   width: 200px;
    height: 18px; 
}

.w-3{
     font-size:14px;
   width: 60px;
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

  <title>Laporan Kelompok Telat Berat</title>
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
                                <span style="font-size:18px; "><b>B2. Laporan Kelompok Telat Berat Cabang <?php echo $cabang;?> <?php echo date("d M Y", strtotime($awal))." s/d ".date("d M Y", strtotime($akhir))?></b></span>
                            </div>               
                            
                            <div style="display:inline-block;">
                                <table class="table-bordered table-responsive-sm" style="margin-bottom:0px;">
                                    <tbody>
                                        <tr>
                                            <td class="w-33">No</td>
                                            <td class="w-111">Kode Nama Tim</td>
                                            <td class="w-3">&#931; Kel Telat</td>
                                            <td class="w-3">&#931; Kel Berat</td>
                                            <td class="w-111">Kel Telat</td>
                                            <td class="w-220">Hasil Edukasi</td>
                                            <td class="w-111">Kel Berat</td>
                                            <td class="w-220">Hasil edukasi</td>
                                        </tr>
                                        <?php
                                        $i=0;
                                        $no=0;
                                        foreach($results as $row){ 
                                            $i++;
                                          
                                                
                                        ?>
                                        <tr>
                                            <td class="w-33"><?php echo $i;?></td>
                                            <td class="w-111 tl"><?php echo $row->nama;?></td>
                                            <td class="w-3"><?php echo $row->telat;?></td>
                                            <td class="w-3"><?php echo $row->berat;?></td>
                                            <td class="w-3 tl" style="vertical-align: text-top;"><?php echo $row->kel_t;?></td>
                                            <td class="w-220 tl" style="vertical-align: text-top;"><?php echo $row->hasil_t;?></td>
                                            <td class="w-3 tl" style="vertical-align: text-top;"><?php echo $row->kel_b;?></td>
                                            <td class="w-220 tl" style="vertical-align: text-top;"><?php echo $row->hasil_b;?></td>
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
</html>
</body>

<?php }?>
