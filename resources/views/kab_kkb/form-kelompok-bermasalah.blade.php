<?php if($kabkkb == "KAB"){

?>
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
                                <input type="hidden" value="{{$awal}}" id="kab-awal">
                                <input type="hidden" value="{{$akhir}}" id="kab-akhir">
                                <input type="hidden" value="{{$cabang}}" id="kab-cabang">
                                <span style="font-size:18px; "><b>B1. Laporan Nasabah/Kelompok Bermasalah Cabang <?php echo $cabang;?> <?php echo date("d M Y", strtotime($awal))." s/d ".date("d M Y", strtotime($akhir))?></b></span>
                            </div>               
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <div style="display:inline-block;">
                                <table class="table-bordered table-responsive-sm" style="margin-bottom:0px;" id="kelompokBermasalahKab">
                                    <thead>
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
                                    </thead>
                                    <tbody>
                                        <?php foreach($results as $row):
                                            $no = 1;?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $row->nama; ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        <?php endforeach;?>
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
{{-- <script type="text/javascript">
    $(document).ready(function () {
        // Trigger AJAX request to fetch the table data
        function fetchData() {
            $.ajax({
                url: "{{ route('getTableFormKelompokBermasalahKab') }}",
                method: "GET",
                data: {
                    awal: $('#kab-awal').val(),
                    akhir: $('#kab-akhir').val(),
                    cabang: $('#kab-cabang').val(),
                },
                success: function (response) {
                    let tableBody = $('#kelompokBermasalahKab tbody');
                    tableBody.empty(); // Clear the table body before inserting new data

                    $.each(response, function (index, row) {
                        let no = index + 1; // Row number
                        let nama = row.nama;
                        let total_ab = row.total_ab;
                        let total_kb = row.total_kb;
                        let dtr1 = row.dtr1;
                        let dtr2 = row.dtr2;
                        let dtr3 = row.dtr3;
                        let nama_ab = row.nama_ab;
                        let kel_ab = row.kel_ab;

                        // Construct the table row with the data
                        let tableRow = `
                            <tr>
                                <td class="w-33">${no}</td>
                                <td class="w-111">${nama}</td>
                                <td class="w-3">${total_ab}</td>
                                <td class="w-3">${total_kb}</td>
                                <td class="w-3">${dtr1}</td>
                                <td class="w-3">${dtr2}</td>
                                <td class="w-3">${dtr3}</td>
                                <td class="w-3">${total_ab}</td>
                                <td class="w-220">${nama_ab}</td>
                                <td class="w-220">${kel_ab}</td>
                            </tr>
                        `;
                        
                        // Append the new row to the table body
                        tableBody.append(tableRow);
                    });
                },
                error: function () {
                    alert("An error occurred while fetching data2.");
                }
            });
        }

        // Fetch data when the page loads
        fetchData();

        // You can also trigger fetchData when user changes the filter inputs
        $('#kab-awal, #kab-akhir, #kab-cabang').change(function () {
            fetchData();
        });
    });
</script> --}}

<?php } else {

$que2=$mysqli->query("SELECT pkp.nama,pkp.id,SUM(IF( kelompok_bermasalah.kode_kb = '3A', 1, 0)) AS telat,
    SUM(IF( kelompok_bermasalah.kode_kb = '3B', 1, 0)) AS berat FROM pkp
    LEFT JOIN kelompok_bermasalah
    ON kelompok_bermasalah.pkp_kb = pkp.id
    WHERE cabang_kb = '$cabang' AND kelompok_bermasalah.tanggal_kb >= '$awal' AND kelompok_bermasalah.tanggal_kb <= '$akhir'
    GROUP BY pkp.nama,pkp.id
    order by pkp.nama asc");

?>
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
                                           
                                        while ($row=mysqli_fetch_array($que2)){ 
                                            $i++;
                                            $pkp = $row["id"];
                                            // $quee=$mysqli->query("SELECT id_anggota_ab, count(id_ab) as total FROM anggota_bermasalah
                                            // WHERE pkp_ab = '$pkp' AND tanggal_ab >= '$awal' AND tanggal_ab <= '$akhir' AND cabang_ab = '$cabang'");
                                            // $rows=mysqli_fetch_array($quee);
                                            $quer=$mysqli->query("SELECT kelompok_kb,menit_kb,pembahasan_kb FROM kelompok_bermasalah
                                                WHERE pkp_kb = '$pkp' AND cabang_kb = '$cabang' AND tanggal_kb >= '$awal' AND tanggal_kb <= '$akhir' AND kode_kb = '3A'");
                                                $kel_t="";
                                                $hasil_t="";
                                                $kel_b="";
                                                $hasil_b="";
                                                $noxx=1; 
                                                
                                                while($rowr=mysqli_fetch_array($quer)){ 
                                                    if(!empty($rowr["kelompok_kb"])){
                                                    $kel_t = $kel_t." [".$noxx."]".$rowr["kelompok_kb"]."-".$rowr["menit_kb"]." menit, ";
                                                    $hasil_t = $hasil_t."[".$noxx."]".$rowr["pembahasan_kb"].". <br>";
                                                    $noxx = $noxx+1;
                                                    }
                                                }
                                            $querr=$mysqli->query("SELECT kelompok_kb,menit_kb,pembahasan_kb FROM kelompok_bermasalah
                                                WHERE pkp_kb = '$pkp' AND cabang_kb = '$cabang' AND tanggal_kb >= '$awal' AND tanggal_kb <= '$akhir' AND kode_kb = '3B'");
                                                $noxxx=1; 
                                                
                                                while($rowrr=mysqli_fetch_array($querr)){ 
                                                    if(!empty($rowrr["kelompok_kb"])){
                                                    $kel_b = $kel_b." [".$noxxx."]".$rowrr["kelompok_kb"]."-".$rowrr["menit_kb"]." menit, ";
                                                    $hasil_b = $hasil_b."[".$noxxx."]".$rowrr["pembahasan_kb"].". <br>";
                                                 $noxxx = $noxxx+1;
                                                }
                                                }
                                                
                                        ?>
                                        <tr>
                                            <td class="w-33"><?php echo $i;?></td>
                                            <td class="w-111 tl"><?php echo $row["nama"];?></td>
                                            <td class="w-3"><?php echo $row["telat"];?></td>
                                            <td class="w-3"><?php echo $row["berat"];?></td>
                                            <td class="w-3 tl" style="vertical-align: text-top;"><?php echo $kel_t;?></td>
                                            <td class="w-220 tl" style="vertical-align: text-top;"><?php echo $hasil_t;?></td>
                                            <td class="w-3 tl" style="vertical-align: text-top;"><?php echo $kel_b;?></td>
                                            <td class="w-220 tl" style="vertical-align: text-top;"><?php echo $hasil_b;?></td>
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
