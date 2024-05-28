<div class="container-fluid p-0">
	
    <?php if($login): ?>

        <h1 class="h3 mb-3 text-center"><b><?php echo $word['mulklerim'];?></b></h1>
        <div class="row">
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th class="d-xl-table-cell"><?php echo $word['mulk_turu'];?></th>
                                <th class="d-xl-table-cell"><?php echo $word['adres'];?></th>
                                <th class="d-xl-table-cell"><?php echo $word['yuzolcumu'];?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sorgu = "SELECT ilce.Ilce_Ad, mahalle.Mahalle_Ad, sokak.Sokak_Ad, mulk.Mulk_Kapi_No, mulk.Mulk_ID, mulk.Mulk_M2, tip.Tip_Ad FROM Mulkler mulk INNER JOIN Mahalle mahalle ON mulk.Mulk_Mahalle_ID = mahalle.Mahalle_ID INNER JOIN Sokaklar sokak ON mulk.Mulk_Sokak_ID = sokak.Sokak_ID INNER JOIN Ilce ilce ON mahalle.Mahalle_Ilce_ID = ilce.Ilce_ID INNER JOIN Mulk_Tipleri tip ON mulk.Mulk_Tip_ID = tip.Tip_ID WHERE mulk.Mulk_Sahibi_Sicil_No='$uye[Uye_Sicil_No]' ORDER BY mulk.Mulk_ID ASC";
                            $mulkler = mysqli_query($mysqli, $sorgu);
                            $i = 0;
                            while($mulk = mysqli_fetch_assoc($mulkler)){
                            ?>
                            <tr>
                                <td class="d-xl-table-cell"><?php echo $mulk['Tip_Ad'];?></td>
                                <td class="d-xl-table-cell"><?php echo $mulk['Mahalle_Ad'].", ".$mulk['Sokak_Ad'].", ".$word['kapi_no'].": ".$mulk['Mulk_Kapi_No'].", ".$mulk['Ilce_Ad']."/".$belediye['Belediye_Sehir'];?></td>
                                <td class="d-xl-table-cell"><?php echo Number($mulk['Mulk_M2'])." ".$word['mt2'];?></td>
                            </tr>
                            <?php $i++;}?>
                            <tr>
                                <td colspan="4" class="text-center"><b><?php echo $word['toplam_mulk'].": ".$i;?></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php else: ?>
		
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="alert alert-warning" role="alert">
                <?php echo $word['bu_modul_icin_giris_yapilmalidir'];?><br><br>
                <a href="index.php?page=login&ref=<?php echo $_GET['page'];?>" class="btn btn-lg btn-danger"><?php echo $word['giris_yap'];?></a>
            </div>
        </div>

    <?php endif; ?>

</div>