<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    
    <?php if($cabang==0){?>
    <title>Laporan harian semua cabang <?php echo $tanggal;?></title>
    <?php } else {?>
    <title>Laporan harian cabang <?php echo $cabang;?> <?php echo $tanggal;?></title>
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
    height: 28px;
    font-size:18px;
    padding: 5px;
}
.w-2{
   width: 150px;
    height: 28px; 
    font-size:18px;
    padding: 5px;
}

.w-3{
   width: 300px;
    height: 28px; 
    font-size:18px;
    padding: 5px;
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
                        <td class="w-1 tl">Laporan Harian Cabang</td>
                        <?php if($cabang == 0){?>
                        <td class="w-3 tl">Semua Cabang</td>
                        <?php } else {?>
                        <td class="w-3 tl"><?php echo $cabang;?></td>
                        <?php }?>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Tanggal</td>
                        <td class="w-3 tl"><?php echo date('d-m-Y', strtotime($tanggal));?></td>
                    </tr>        
                </tbody>
            </table>
        </div>
        <div>
            <table>
                <tbody>
                    <tr>
                        <td class="w-1 tl">Laporan</td>
                        <td class="w-2">Jumlah</td>
                        <td class="w-2 tr">%</td>
                    </tr>
                    
                    <tr>
                        <td class="w-1 tl">Jumlah kumpulan aktif hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr" style="background-color:black;">/ / / / / / / / / / / / / / /</td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Jumlah kelompok aktif hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr" style="background-color:black;">/ / / / / / / / / / / / / / /</td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Jumlah kelompok setoran hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr">%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Jumlah kelompok gagal bayar</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr">%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Jumlah kelompok telat (<= 10 menit)</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr">%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Jumlah kelompok berat (> 10 menit)</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr">%</td>
                    </tr> 
                    <tr>
                        <td class="w-1" colspan="3" style="background-color:grey;"></td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Jumlah anggota aktif hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr" style="background-color:black;">/ / / / / / / / / / / / / / /</td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Rata-rata anggota per kelompok hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr" style="background-color:black;">/ / / / / / / / / / / / / / /</td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Rata-rata anggota per kumpulan hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr" style="background-color:black;">/ / / / / / / / / / / / / / /</td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Total anggota setoran hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr"></td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Total anggota gagal bayar hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr">%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Total anggota DTR hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr">%</td>
                    </tr> 
                    <tr>
                        <td class="w-1" colspan="3" style="background-color:grey;"></td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Total penabung pribadi hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr">%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Total tabungan pribadi hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr" style="background-color:black;">/ / / / / / / / / / / / / / /</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Rata2 tabungan per Ibu hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr" style="background-color:black;">/ / / / / / / / / / / / / / /</td>
                    </tr> 
                    <tr>
                        <td class="w-1" colspan="3" style="background-color:grey;"></td>
                    </tr>
                    <tr>
                        <td class="w-1 tl">Total kelompok pencairan hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr"style="background-color:black;">/ / / / / / / / / / / / / / /</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Jumlah anggota dicairkan hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr">%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Total jumlah uang utk PCR hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr" style="background-color:black;">/ / / / / / / / / / / / / / /</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Rata-rata pinjaman/ibu cair hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr" style="background-color:black;">/ / / / / / / / / / / / / / /</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Total kelompok BTK/BTAB hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr" style="background-color:black;">/ / / / / / / / / / / / / / /</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Jumlah anggota BTK/BTAB hari ini</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr">%</td>
                    </tr> 
                    <tr>
                        <td class="w-1 tl">Perubahan anggota hari ini (+/-)</td>
                        <td class="w-2 tr"></td>
                        <td class="w-2 tr">%</td>
                    </tr> 
                    
                </tbody>
            </table>
        </div>
    </div>
</body>
        <script>
        $("#PrintNow").on("click", function () {
                var divContents = $("#dvContainer").html();
                var printWindow = window.open('', '', 'height=400,width=800');
                printWindow.document.write('<html><head><title>Laporan harian cabang <?php echo $cabang;?> <?php echo $tanggal;?></title>');
                printWindow.document.write('</head><body >');
                printWindow.document.write(divContents);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            });
        </script>                    
                            

</html>

   
   

</body>
