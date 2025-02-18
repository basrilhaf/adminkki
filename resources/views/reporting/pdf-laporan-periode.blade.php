<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
  
  <?php if($cabang=="0"){?>
  <title>Laporan semua cabang <?php echo date('d-m-Y', strtotime($awal));?> s/d <?php echo date('d-m-Y', strtotime($akhir));?></title>
  <?php } else {?>
  <title>Laporan cabang <?php echo $cabang;?> <?php echo date('d-m-Y', strtotime($awal));?> s/d <?php echo date('d-m-Y', strtotime($akhir));?></title>
  <?php }?>

</head>
<body>
    <div>
        <input type="button" value="download pdf" id="PrintNow" />
    </div>
    <br>
    <div id="dvContainer">
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
    width: 400px;
    height: 22px;
    font-size:18px;
    padding: 3px;
}
.w-2{
   width: 150px;
    height: 22px; 
    font-size:18px;
    padding: 3px;
}

.w-3{
   width: 300px;
    height: 22px; 
    font-size:18px;
    padding: 3px;
}

.tl{
    text-align: left;
}
.tr{
    text-align: right;
}
</style>
        <div style="margin-bottom:20px;">
            <table>
                <tbody>
                    <tr>
                        <td class="w-1 tl"><b>Laporan Cabang</b></td>
                        <?php if($cabang=="0"){?>
                        <td class="w-3 tl"><b>Semua Cabang</b></td>
                        <?php } else {?>
                        <td class="w-3 tl"><?php echo $cabang;?> </td>
                        <?php }?>
                    </tr>
                    <tr>
                        <td class="w-1 tl"><b>Tanggal</b></td>
                        <td class="w-3 tl"><?php echo date('d-m-Y', strtotime($awal));?> s/d <?php echo date('d-m-Y', strtotime($akhir));?></td>
                    </tr>        
                </tbody>
            </table>
        </div>
        <div>
            <table>
                <tbody>
                    <tr>
                        <td class="w-1 tl"><b>Laporan</b></td>
                        <td class="w-2"><b>Jumlah</b></td>
                        <td class="w-2 tr"><b>%</b></td>
                    </tr>
                    
                    <tr>
                        <td class="w-1 tl">Jumlah Kumpulan Aktif</td>
                        <td class="w-2 tr">{{$kumpulan_aktif}}</td>
                        <td class="w-2 tr" style="background-color:black;">- - - - - - - - - - - - - -</td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Jumlah Kelompok Aktif</td>
                        <td class="w-2 tr">{{$kelompok_aktif}}</td>
                        <td class="w-2 tr" style="background-color:black;">- - - - - - - - - - - - - -</td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Jumlah kelompok gagal bayar</td> 
                        <td class="w-2 tr">{{$kelompok_aktif - $kelompok_setoran}}</td>
                        <td class="w-2 tr">{{round(($kelompok_aktif - $kelompok_setoran)/$kelompok_aktif,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Jumlah kelompok telat (<= 10 menit)</td>
                        <td class="w-2 tr">{{$kelompok_telat}}</td>
                        <td class="w-2 tr">{{round(($kelompok_telat/$kelompok_aktif)*100,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Jumlah kelompok berat (> 10 menit)</td>
                        <td class="w-2 tr">{{$kelompok_berat}}</td>
                        <td class="w-2 tr">{{round(($kelompok_berat/$kelompok_aktif)*100,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1" colspan="3" style="background-color:grey;"></td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Total Anggota Aktif</td>
                        <td class="w-2 tr">{{$anggota_aktif}}</td>
                        <td class="w-2 tr" style="background-color:black;">- - - - - - - - - - - - - -</td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Rata-rata Anggota per Kelompok</td>
                        <td class="w-2 tr">{{round($anggota_aktif/$kelompok_aktif,2)}}</td>
                        <td class="w-2 tr" style="background-color:black;">- - - - - - - - - - - - - -</td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Rata-rata Anggota per Kumpulan</td>
                        <td class="w-2 tr">{{round($anggota_aktif/$kumpulan_aktif,2)}}</td>
                        <td class="w-2 tr" style="background-color:black;">- - - - - - - - - - - - - -</td>
                    </tr>
                    
                    <tr>
                        <td class="w-1 tl">Kasus gagal bayar</td>
                        <td class="w-2 tr">{{$anggota_aktif - $anggota_setoran}}</td>
                        <td class="w-2 tr">{{round(($anggota_aktif - $anggota_setoran)/$anggota_aktif,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Kasus DTR</td>
                        <td class="w-2 tr">{{$anggota_dtr}}</td>
                        <td class="w-2 tr">{{round($anggota_dtr/$anggota_aktif,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">DTR 1x</td>
                        <td class="w-2 tr">{{$dtr_1}}</td>
                        <td class="w-2 tr">{{round($dtr_1/$anggota_aktif,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">DTR 2-3x</td>
                        <td class="w-2 tr">{{$dtr_23}}</td>
                        <td class="w-2 tr">{{round($dtr_23/$anggota_aktif,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">DTR > 3x</td>
                        <td class="w-2 tr">{{$dtr_4}}</td>
                        <td class="w-2 tr">{{round($dtr_4/$anggota_aktif,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1" colspan="3" style="background-color:grey; color:white;"><b>Jml Anggota dgn DTR per akhir periode</b></td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Anggota dgn DTR 1x</td>
                        <td class="w-2 tr">{{$dtr_1_all}}</td>
                        <td class="w-2 tr">{{round($dtr_1_all/$anggota_aktif,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Anggota dgn DTR 2-3x</td>
                        <td class="w-2 tr">{{$dtr_23_all}}</td>
                        <td class="w-2 tr">{{round($dtr_23_all/$anggota_aktif,2)}}%</td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Anggota dgn DTR > 3x</td>
                        <td class="w-2 tr">{{$dtr_4_all}}</td>
                        <td class="w-2 tr">{{round($dtr_4_all/$anggota_aktif,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1" colspan="3" style="background-color:grey;"></td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Total transaksi tab pribadi</td>
                        <td class="w-2 tr">{{$penabung}}</td>
                        <td class="w-2 tr">{{round(($penabung/$anggota_aktif)*100,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Total tabungan pribadi</td>
                        <td class="w-2 tr">{{number_format($jumlah_tabungan,0,',','.')}}</td>
                        <td class="w-2 tr" style="background-color:black;">- - - - - - - - - - - - - -</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Rata2 tabungan per Ibu</td>
                        <td class="w-2 tr">{{ $penabung > 0 ? number_format($jumlah_tabungan / $penabung, 0, ',', '.') : '0' }}</td>
                        <td class="w-2 tr" style="background-color:black;">- - - - - - - - - - - - - -</td>
                    </tr> 
                    <tr>
                        <td class="w-1" colspan="3" style="background-color:grey;"></td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Total kelompok pencairan</td>
                        <td class="w-2 tr">{{$kelompok_cair}}</td>
                        <td class="w-2 tr">{{round($kelompok_cair/$kelompok_aktif,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Jumlah anggota dicairkan</td>
                        <td class="w-2 tr">{{$anggota_cair}}</td>
                        <td class="w-2 tr">{{round($anggota_cair/$anggota_aktif,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Total jumlah uang utk PCR</td>
                        <td class="w-2 tr">{{number_format($jumlah_cair,0,',','.')}}</td>
                        <td class="w-2 tr" style="background-color:black;">- - - - - - - - - - - - - -</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Rata-rata pinjaman/ibu cair</td>
                        <td class="w-2 tr">{{number_format($jumlah_cair/$anggota_cair,0,',','.')}}</td>
                        <td class="w-2 tr" style="background-color:black;">- - - - - - - - - - - - - -</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Total kelompok BTK/BTAB</td>
                        <td class="w-2 tr">{{$kelompok_btab}}</td>
                        <td class="w-2 tr">{{round(($kelompok_btab/$kelompok_aktif)*100,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Jumlah anggota BTK/BTAB</td>
                        <td class="w-2 tr">{{$anggota_btab}}</td>
                        <td class="w-2 tr">{{round(($anggota_btab/$anggota_aktif)*100,2)}}%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Perubahan anggota (+/-)</td>
                        <td class="w-2 tr">{{$anggota_cair - $anggota_btab}}</td>
                        <td class="w-2 tr">{{round((($anggota_cair-$anggota_btab)/$anggota_aktif)*100,2)}}%</td>
                    </tr> 
                    
                </tbody>
            </table>
        </div>
    </div>
</body>
    <?php 
    if($cabang=="0"){
        $cbg = "Semua Cabang";
    } else {
        $cbg = "Cabang ".$cabang;
    }
    ?>                    
     <script>
        $("#PrintNow").on("click", function () {
                var divContents = $("#dvContainer").html();
                var printWindow = window.open('', '', 'height=400,width=800');
                printWindow.document.write('<html><head><title>Laporan <?php echo $cabang;?> <?php echo date('d-m-Y', strtotime($awal));?> - <?php echo date('d-m-Y', strtotime($akhir));?></title>');
                printWindow.document.write('</head><body >');
                printWindow.document.write(divContents);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            });
        </script>                       

</html>
</body>