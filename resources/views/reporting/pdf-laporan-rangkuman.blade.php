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
    font-size:16px;
}
.w-111{
    padding-right: 4px;
    width: 120px;
    height: 22px;
    text-align: center;
    font-size:16px;
}
.w-1{
    padding-right: 4px;
    width: 160px;
    height: 22px;
    text-align: center;
    font-size:16px;
}
.w-12{
    padding-right: 4px;
    width: 140px;
    height: 22px;
    text-align: center;
    font-size:16px;
}
.w-2{
     font-size:16px;
   width: 75px;
    height: 22px; 
}
.w-22{
     font-size:16px;
   width: 50px;
    height: 22px; 
}

.w-221{
     font-size:16px;
   width: 30px;
    height: 22px; 
}
.w-3{
     font-size:16px;
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

  <title>Laporan Rangkuman</title>


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
                               <h3 style="text-align:center; margin-block-start: 0.5em;margin-block-end: 0.5em;">SUMMARY ANGGOTA-KELOMPOK BERMASALAH</h3>
                               <h3 style="text-align:center; margin-block-start: 0.5em;margin-block-end: 0.5em;"><?php echo $awal;?> sampai <?php echo $akhir?></h3>
                            </div>
                            
                            <table style="border:none; margin-top:20px;">
                                <tbody>
                                    {{-- <tr>
                                        <td style="border:none; text-align:left;">Jumlah Kelompok saat ini: <b></td>
                                        <td style="border:none;width:150px;"></td>
                                        <td style="border:none; text-align:left;">% Kelompok Masalah: <b>%</b></td>
                                    </tr>
                                    <tr>
                                        <td style="border:none; text-align:left;">Jumlah Anggota saat ini: <b></td>
                                        <td style="border:none;width:150px;"></td>
                                        <td style="border:none; text-align:left;">% DTR: <b>%</b></td>
                                    </tr> --}}
                                </tbody>
                            </table>
                            
                            <div style="display:inline-block;">
                                <table class="table-bordered table-responsive-sm" style="margin-top:1px;" >
                                    <tbody>
                                        <tr style="background-color:#c3ebb2;">
                                            <td class="w-111">Cabang</td>
                                            <td class="w-1">Jml Anggota DTR</td>
                                            <td class="w-111">Kode 2</td>
                                            <td class="w-111">Kode 4A</td>
                                            <td class="w-111">Kode 4B</td>
                                            
                                        </tr>
                                        
                                        <?php 
                                        $jum_ab = 0;
                                        $kode2 = 0;
                                        $kode4a = 0;
                                        $kode4b = 0;
                                        foreach ($list_ab as $ab) { 
                                        $jum_ab = $jum_ab + $ab->jumlah;
                                        $kode2 = $kode2 + $ab->kode2;
                                        $kode4a = $kode4a + $ab->kode4a;
                                        $kode4b = $kode4b + $ab->kode4b;    
                                        ?>
                                        
                                            <tr>
                                                <td class="w-111 tr">{{ $ab->cabang_ab}}</td>
                                                <td class="w-1 tr">{{ $ab->jumlah}}</td>
                                                <td class="w-111 tr">{{ $ab->kode2}}</td>
                                                <td class="w-111 tr">{{ $ab->kode4a}}</td>
                                                <td class="w-111 tr">{{ $ab->kode4b}}</td>
                                            </tr>
                                        <?php }?>
                                            <tr>
                                                <td class="w-111">Total:</td>
                                                <td class="w-1 tr"><b>{{$jum_ab}}</b></td>
                                                <td class="w-111 tr"><b>{{$kode2}}</b></td>
                                                <td class="w-111 tr"><b>{{$kode4a}}</b></td>
                                                <td class="w-111 tr"><b>{{$kode4b}}</b></td>
                                            </tr>
                                       
                                    </tbody>
                                </table>
                                
                                <table class="table-bordered table-responsive-sm" style="margin-top:20px;" >
                                    <tbody>
                                        <tr style="background-color:#c3ebb2;">
                                            <td class="w-111">Cabang</td>
                                            <td class="w-1">Jml Kelompok</td>
                                            <td class="w-111">Telat</td>
                                            <td class="w-111">Berat</td>

                                        </tr>
                                        <?php 
                                        $jum_kb = 0;
                                        $telat = 0;
                                        $berat = 0;
                                        foreach ($list_kb as $kb) { 
                                        $jum_kb = $jum_kb + $kb->jumlah;
                                        $telat = $telat + $kb->telat;
                                        $berat = $berat + $kb->berat;
                                        ?>
                                         
                                            <tr>
                                                <td class="w-111 tr">{{$kb->cabang_kb}}</td>
                                                <td class="w-1 tr">{{$kb->jumlah}}</td>
                                                <td class="w-111 tr">{{$kb->telat}}</td>
                                                <td class="w-111 tr">{{$kb->berat}}</td>
                                            </tr>
                                        <?php }?>
                                            <tr>
                                                <td class="w-111">Total:</td>
                                                <td class="w-1 tr"><b>{{$jum_kb}}</b></td>
                                                <td class="w-111 tr"><b>{{$telat}}</b></td>
                                                <td class="w-111 tr"><b>{{$berat}}</b></td>
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
 
</html>

   
   
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    
</body>
