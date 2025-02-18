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
    height: 40px;
    font-size:12px;
}
.w-12{
    width: 175px;
    font-size:11px;
}
.w-122{
    width: 25px;
    font-size:11px;
}
.w-1s{
    width: 200px;
    height: 25px;
    font-size:16px;
}
.w-4{
    width: 240px;
    height: 25px;
    font-size:16px;
}
.w-44{
    width: 390px;
    height: 25px;
    font-size:16px;
}
.w-2{
   width: 100px;
    height: 35px; 
    font-size:16px;
}
.w-2s{
   width: 100px;
    height: 25px; 
    font-size:16px;
}
.w-3{
   width: 40px;
    height: 40px; 
    font-size:16px;
}
.w-3s{
   width: 40px;
    height: 25px; 
    font-size:16px;
}

.w-5{
   width: 150px;
    height: 35px; 
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
  
  <title>JPK</title>

 


</head>

<body>
 
    
        <!-- Begin Page Content -->
    <div id="pdfdiv" class="container-fluid">
          <!-- DataTales Example -->
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="color:black;">
                    
                    <div>
                        <h2 style="margin-block-start: 0.1em;margin-block-end: 1em;" class="tl"><b>FORM JADWAL PENYETORAN KELOMPOK (JPK)</b></h2>
                        
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="w-4 tl">Nama PKP</td>
                                        <td class="w-44 tl">{{$nama_pkp}}</td>
                                        <td class="w-1s">Update: <?php echo date('d/m/y');?></td> 
                                    </tr>
                                </tbody>
                            </table>
                            
                            <table style="margin-top:5px;">
                                <tbody>
                                    <tr>
                                        <td class="w-3s">Waktu</td>
                                        <td class="w-1s">SENIN</td>
                                        <td class="w-1s">SELASA</td>
                                        <td class="w-1s">RABU</td>
                                        <td class="w-1s">KAMIS</td>
                                        <td class="w-1s">KETERANGAN</td>
                                        
                                    </tr>
                                    
                                    <tr>
                                        <td class="w-3">08.30</td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($senin_830 as $senin_830){?><tr><td class="w-12 tl bn">{{$senin_830->deskripsi_group1}}</td><td class="w-122 bn">{{$senin_830->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($selasa_830 as $selasa_830){?><tr><td class="w-12 tl bn">{{$selasa_830->deskripsi_group1}}</td><td class="w-122 bn">{{$selasa_830->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($rabu_830 as $rabu_830){?><tr><td class="w-12 tl bn">{{$rabu_830->deskripsi_group1}}</td><td class="w-122 bn">{{$rabu_830->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($kamis_830 as $kamis_830){?><tr><td class="w-12 tl bn">{{$kamis_830->deskripsi_group1}}</td><td class="w-122 bn">{{$kamis_830->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1" rowspan="13" style="vertical-align: top; text-align:left;"><p>TA = {{$total_anggota}}</p><p>TK = {{$total_kelompok}}</p></td>
                                    </tr>
                                    
                                    
                                    <tr>
                                        <td class="w-3">09.00</td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($senin_900 as $senin_900){?><tr><td class="w-12 tl bn">{{$senin_900->deskripsi_group1}}</td><td class="w-122 bn">{{$senin_900->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($selasa_900 as $selasa_900){?><tr><td class="w-12 tl bn">{{$selasa_900->deskripsi_group1}}</td><td class="w-122 bn">{{$selasa_900->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($rabu_900 as $rabu_900){?><tr><td class="w-12 tl bn">{{$rabu_900->deskripsi_group1}}</td><td class="w-122 bn">{{$rabu_900->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($kamis_900 as $kamis_900){?><tr><td class="w-12 tl bn">{{$kamis_900->deskripsi_group1}}</td><td class="w-122 bn">{{$kamis_900->total}}</td></tr><?php }?></tbody></table></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="w-3">09.30</td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($senin_930 as $senin_930){?><tr><td class="w-12 tl bn">{{$senin_930->deskripsi_group1}}</td><td class="w-122 bn">{{$senin_930->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($selasa_930 as $selasa_930){?><tr><td class="w-12 tl bn">{{$selasa_930->deskripsi_group1}}</td><td class="w-122 bn">{{$selasa_930->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($rabu_930 as $rabu_930){?><tr><td class="w-12 tl bn">{{$rabu_930->deskripsi_group1}}</td><td class="w-122 bn">{{$rabu_930->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($kamis_930 as $kamis_930){?><tr><td class="w-12 tl bn">{{$kamis_930->deskripsi_group1}}</td><td class="w-122 bn">{{$kamis_930->total}}</td></tr><?php }?></tbody></table></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="w-3">10.00</td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($senin_1000 as $senin_1000){?><tr><td class="w-12 tl bn">{{$senin_1000->deskripsi_group1}}</td><td class="w-122 bn">{{$senin_1000->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($selasa_1000 as $selasa_1000){?><tr><td class="w-12 tl bn">{{$selasa_1000->deskripsi_group1}}</td><td class="w-122 bn">{{$selasa_1000->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($rabu_1000 as $rabu_1000){?><tr><td class="w-12 tl bn">{{$rabu_1000->deskripsi_group1}}</td><td class="w-122 bn">{{$rabu_1000->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($kamis_1000 as $kamis_1000){?><tr><td class="w-12 tl bn">{{$kamis_1000->deskripsi_group1}}</td><td class="w-122 bn">{{$kamis_1000->total}}</td></tr><?php }?></tbody></table></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="w-3">10.30</td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($senin_1030 as $senin_1030){?><tr><td class="w-12 tl bn">{{$senin_1030->deskripsi_group1}}</td><td class="w-122 bn">{{$senin_1030->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($selasa_1030 as $selasa_1030){?><tr><td class="w-12 tl bn">{{$selasa_1030->deskripsi_group1}}</td><td class="w-122 bn">{{$selasa_1030->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($rabu_1030 as $rabu_1030){?><tr><td class="w-12 tl bn">{{$rabu_1030->deskripsi_group1}}</td><td class="w-122 bn">{{$rabu_1030->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($kamis_1030 as $kamis_1030){?><tr><td class="w-12 tl bn">{{$kamis_1030->deskripsi_group1}}</td><td class="w-122 bn">{{$kamis_1030->total}}</td></tr><?php }?></tbody></table></td>
                                    </tr>

                                    <tr>
                                        <td class="w-3">11.00</td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($senin_1100 as $senin_1100){?><tr><td class="w-12 tl bn">{{$senin_1100->deskripsi_group1}}</td><td class="w-122 bn">{{$senin_1100->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($selasa_1100 as $selasa_1100){?><tr><td class="w-12 tl bn">{{$selasa_1100->deskripsi_group1}}</td><td class="w-122 bn">{{$selasa_1100->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($rabu_1100 as $rabu_1100){?><tr><td class="w-12 tl bn">{{$rabu_1100->deskripsi_group1}}</td><td class="w-122 bn">{{$rabu_1100->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($kamis_1100 as $kamis_1100){?><tr><td class="w-12 tl bn">{{$kamis_1100->deskripsi_group1}}</td><td class="w-122 bn">{{$kamis_1100->total}}</td></tr><?php }?></tbody></table></td>
                                    </tr>

                                    <tr>
                                        <td class="w-3">11.30</td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($senin_1130 as $senin_1130){?><tr><td class="w-12 tl bn">{{$senin_1130->deskripsi_group1}}</td><td class="w-122 bn">{{$senin_1130->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($selasa_1130 as $selasa_1130){?><tr><td class="w-12 tl bn">{{$selasa_1130->deskripsi_group1}}</td><td class="w-122 bn">{{$selasa_1130->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($rabu_1130 as $rabu_1130){?><tr><td class="w-12 tl bn">{{$rabu_1130->deskripsi_group1}}</td><td class="w-122 bn">{{$rabu_1130->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($kamis_1130 as $kamis_1130){?><tr><td class="w-12 tl bn">{{$kamis_1130->deskripsi_group1}}</td><td class="w-122 bn">{{$kamis_1130->total}}</td></tr><?php }?></tbody></table></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="w-3 bn" style="height:20px;"></td>
                                        <td class="w-1 bn tr" style="height:20px;">{{$total_senin}}</td>
                                        <td class="w-1 bn tr" style="height:20px;">{{$total_selasa}}</td>
                                        <td class="w-1 bn" style="height:20px;"><span style="text-align:center; font-size:16px;">ISTIRAHAT </span><span style="padding-left:55px;text-align:right;"></span>{{$total_rabu}}</td>
                                        <td class="w-1 bn tr" style="height:20px;border-right: 0.01em solid #0a0808;">{{$total_kamis}}</td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="w-3" style="border-top: 0.01em solid #0a0808;">13.00</td>
                                        <td class="w-1" style="border-top: 0.01em solid #0a0808;"><table class="bn"><tbody><?php foreach($senin_1300 as $senin_1300){?><tr><td class="w-12 tl bn">{{$senin_1300->deskripsi_group1}}</td><td class="w-122 bn">{{$senin_1300->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1" style="border-top: 0.01em solid #0a0808;"><table class="bn"><tbody><?php foreach($selasa_1300 as $selasa_1300){?><tr><td class="w-12 tl bn">{{$selasa_1300->deskripsi_group1}}</td><td class="w-122 bn">{{$selasa_1300->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1" style="border-top: 0.01em solid #0a0808;"><table class="bn"><tbody><?php foreach($rabu_1300 as $rabu_1300){?><tr><td class="w-12 tl bn">{{$rabu_1300->deskripsi_group1}}</td><td class="w-122 bn">{{$rabu_1300->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1" style="border-top: 0.01em solid #0a0808;"><table class="bn"><tbody><?php foreach($kamis_1300 as $kamis_1300){?><tr><td class="w-12 tl bn">{{$kamis_1300->deskripsi_group1}}</td><td class="w-122 bn">{{$kamis_1300->total}}</td></tr><?php }?></tbody></table></td>
                                    </tr>
                                   
                                    <tr>
                                        <td class="w-3">13.30</td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($senin_1330 as $senin_1330){?><tr><td class="w-12 tl bn">{{$senin_1330->deskripsi_group1}}</td><td class="w-122 bn">{{$senin_1330->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($selasa_1330 as $selasa_1330){?><tr><td class="w-12 tl bn">{{$selasa_1330->deskripsi_group1}}</td><td class="w-122 bn">{{$selasa_1330->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($rabu_1330 as $rabu_1330){?><tr><td class="w-12 tl bn">{{$rabu_1330->deskripsi_group1}}</td><td class="w-122 bn">{{$rabu_1330->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($kamis_1330 as $kamis_1330){?><tr><td class="w-12 tl bn">{{$kamis_1330->deskripsi_group1}}</td><td class="w-122 bn">{{$kamis_1330->total}}</td></tr><?php }?></tbody></table></td>
                                    </tr>

                                    <tr>
                                        <td class="w-3">14.00</td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($senin_1400 as $senin_1400){?><tr><td class="w-12 tl bn">{{$senin_1400->deskripsi_group1}}</td><td class="w-122 bn">{{$senin_1400->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($selasa_1400 as $selasa_1400){?><tr><td class="w-12 tl bn">{{$selasa_1400->deskripsi_group1}}</td><td class="w-122 bn">{{$selasa_1400->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($rabu_1400 as $rabu_1400){?><tr><td class="w-12 tl bn">{{$rabu_1400->deskripsi_group1}}</td><td class="w-122 bn">{{$rabu_1400->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($kamis_1400 as $kamis_1400){?><tr><td class="w-12 tl bn">{{$kamis_1400->deskripsi_group1}}</td><td class="w-122 bn">{{$kamis_1400->total}}</td></tr><?php }?></tbody></table></td>
                                    </tr>

                                    <tr>
                                        <td class="w-3">14.30</td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($senin_1430 as $senin_1430){?><tr><td class="w-12 tl bn">{{$senin_1430->deskripsi_group1}}</td><td class="w-122 bn">{{$senin_1430->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($selasa_1430 as $selasa_1430){?><tr><td class="w-12 tl bn">{{$selasa_1430->deskripsi_group1}}</td><td class="w-122 bn">{{$selasa_1430->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($rabu_1430 as $rabu_1430){?><tr><td class="w-12 tl bn">{{$rabu_1430->deskripsi_group1}}</td><td class="w-122 bn">{{$rabu_1430->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($kamis_1430 as $kamis_1430){?><tr><td class="w-12 tl bn">{{$kamis_1430->deskripsi_group1}}</td><td class="w-122 bn">{{$kamis_1430->total}}</td></tr><?php }?></tbody></table></td>
                                    </tr>

                                    <tr>
                                        <td class="w-3">15.00</td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($senin_1500 as $senin_1500){?><tr><td class="w-12 tl bn">{{$senin_1500->deskripsi_group1}}</td><td class="w-122 bn">{{$senin_1500->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($selasa_1500 as $selasa_1500){?><tr><td class="w-12 tl bn">{{$selasa_1500->deskripsi_group1}}</td><td class="w-122 bn">{{$selasa_1500->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($rabu_1500 as $rabu_1500){?><tr><td class="w-12 tl bn">{{$rabu_1500->deskripsi_group1}}</td><td class="w-122 bn">{{$rabu_1500->total}}</td></tr><?php }?></tbody></table></td>
                                        <td class="w-1"><table class="bn"><tbody><?php foreach($kamis_1500 as $kamis_1500){?><tr><td class="w-12 tl bn">{{$kamis_1500->deskripsi_group1}}</td><td class="w-122 bn">{{$kamis_1500->total}}</td></tr><?php }?></tbody></table></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                    
                    
                        
                </div>
            </div>  
        </div>
    </div>

</html>

   
   

</body>
