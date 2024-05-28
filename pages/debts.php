<div class="container-fluid p-0">

<?php if($login){
    
$sql = "SELECT SUM(CASE WHEN B.Borc_Tip_ID = 1 THEN B.Borc_Tutari ELSE B.Borc_Tutari END) AS Borc, SUM(CASE WHEN B.Borc_Tip_ID = 1 THEN B.Borc_Ceza ELSE B.Borc_Ceza END) AS Ceza FROM Borclar B LEFT JOIN Su_Abonelikler SA ON B.Borclu_Bilgisi = SA.Abone_ID AND B.Borc_Tip_ID = 1 LEFT JOIN Uyeler U ON B.Borclu_Bilgisi = U.Uye_Sicil_No AND B.Borc_Tip_ID <> 1 WHERE ((B.Borc_Durum = 'Odenmedi') AND (B.Borc_Tip_ID = 1) AND (SA.Abone_Sicil_No = '$uye[Uye_Sicil_No]')) OR ((B.Borc_Durum = 'Odenmedi') AND (B.Borc_Tip_ID <> 1) AND (U.Uye_Sicil_No = '$uye[Uye_Sicil_No]'));";
$toplamBorc = mysqli_fetch_assoc(mysqli_query($mysqli, $sql));

$sql = "SELECT SUM(CASE WHEN B.Borc_Tip_ID = 1 THEN B.Borc_Tutari ELSE B.Borc_Tutari END) AS Borc, SUM(CASE WHEN B.Borc_Tip_ID = 1 THEN B.Borc_Ceza ELSE B.Borc_Ceza END) AS Ceza FROM Borclar B LEFT JOIN Su_Abonelikler SA ON B.Borclu_Bilgisi = SA.Abone_ID AND B.Borc_Tip_ID = 1 LEFT JOIN Uyeler U ON B.Borclu_Bilgisi = U.Uye_Sicil_No AND B.Borc_Tip_ID <> 1 WHERE ((B.Borc_Durum = 'Odenmedi') AND (B.Borc_Tip_ID = 1) AND (SA.Abone_Sicil_No = '$uye[Uye_Sicil_No]') AND B.Borc_Son_Odeme_Tarihi>'$date') OR ((B.Borc_Durum = 'Odenmedi') AND (B.Borc_Tip_ID <> 1) AND (U.Uye_Sicil_No = '$uye[Uye_Sicil_No]') AND B.Borc_Son_Odeme_Tarihi>'$date');";
$vadesiGelmemisBorc = mysqli_fetch_assoc(mysqli_query($mysqli, $sql));

$sql = "SELECT SUM(CASE WHEN B.Borc_Tip_ID = 1 THEN B.Borc_Tutari ELSE B.Borc_Tutari END) AS Borc, SUM(CASE WHEN B.Borc_Tip_ID = 1 THEN B.Borc_Ceza ELSE B.Borc_Ceza END) AS Ceza FROM Borclar B LEFT JOIN Su_Abonelikler SA ON B.Borclu_Bilgisi = SA.Abone_ID AND B.Borc_Tip_ID = 1 LEFT JOIN Uyeler U ON B.Borclu_Bilgisi = U.Uye_Sicil_No AND B.Borc_Tip_ID <> 1 WHERE ((B.Borc_Durum = 'Odenmedi') AND (B.Borc_Tip_ID = 1) AND (SA.Abone_Sicil_No = '$uye[Uye_Sicil_No]') AND B.Borc_Son_Odeme_Tarihi<='$date') OR ((B.Borc_Durum = 'Odenmedi') AND (B.Borc_Tip_ID <> 1) AND (U.Uye_Sicil_No = '$uye[Uye_Sicil_No]') AND B.Borc_Son_Odeme_Tarihi<='$date');";
$vadesiGecenBorc = mysqli_fetch_assoc(mysqli_query($mysqli, $sql));

$sql = "SELECT SUM(CASE WHEN B.Borc_Tip_ID = 1 THEN B.Borc_Tutari ELSE B.Borc_Tutari END) AS Borc, SUM(CASE WHEN B.Borc_Tip_ID = 1 THEN B.Borc_Ceza ELSE B.Borc_Ceza END) AS Ceza FROM Borclar B LEFT JOIN Su_Abonelikler SA ON B.Borclu_Bilgisi = SA.Abone_ID AND B.Borc_Tip_ID = 1 LEFT JOIN Uyeler U ON B.Borclu_Bilgisi = U.Uye_Sicil_No AND B.Borc_Tip_ID <> 1 WHERE ((B.Borc_Durum = 'Odendi') AND (B.Borc_Tip_ID = 1) AND (SA.Abone_Sicil_No = '$uye[Uye_Sicil_No]')) OR ((B.Borc_Durum = 'Odendi') AND (B.Borc_Tip_ID <> 1) AND (U.Uye_Sicil_No = '$uye[Uye_Sicil_No]'));";
$odenenBorc = mysqli_fetch_assoc(mysqli_query($mysqli, $sql));

?>

<h1 class="h3 mb-3 text-center"><b><?php echo $word['borclar'];?></b></h1>

<div class="row">

<div class="col-lg-3 col-sm-12 col-12">
<div class="card">
<div class="card-body">
<div class="row p-0">
<div class="col mt-0">
<h5><?php echo $word['toplam_borc'];?></h5>
<h3 class="mt-0 mb-0">₺<?php echo Balance($toplamBorc['Borc']+$toplamBorc['Ceza']);?></h3>
</div>
<div class="col-auto">
<div class="stat bg-primary">
<i class="align-middle" style="color: white !important;" data-feather="credit-card"></i>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="col-lg-3 col-sm-12 col-12">
<div class="card">
<div class="card-body">
<div class="row p-0">
<div class="col mt-0">
<h5><?php echo $word['vadesi_gelmemis_borc'];?></h5>
<h3 class="mt-0 mb-0">₺<?php echo Balance($vadesiGelmemisBorc['Borc']+$vadesiGelmemisBorc['Ceza']);?></h3>
</div>
<div class="col-auto">
<div class="stat bg-warning">
<i class="align-middle" style="color: white !important;" data-feather="credit-card"></i>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="col-lg-3 col-sm-12 col-12">
<div class="card">
<div class="card-body">
<div class="row p-0">
<div class="col mt-0">
<h5><?php echo $word['vadesi_gecmis_borc'];?></h5>
<h3 class="mt-0 mb-0">₺<?php echo Balance($vadesiGecenBorc['Borc']+$vadesiGecenBorc['Ceza']);?></h3>
</div>
<div class="col-auto">
<div class="stat bg-danger">
<i class="align-middle" style="color: white !important;" data-feather="credit-card"></i>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="col-lg-3 col-sm-12 col-12">
<div class="card">
<div class="card-body">
<div class="row p-0">
<div class="col mt-0">
<h5><?php echo $word['odenen_borc'];?></h5>
<h3 class="mt-0 mb-0">₺<?php echo Balance($odenenBorc['Borc']+$odenenBorc['Ceza']);?></h3>
</div>
<div class="col-auto">
<div class="stat bg-success">
<i class="align-middle" style="color: white !important;" data-feather="credit-card"></i>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="col-lg-12 col-sm-12 col-12">
<div class="alert alert-warning" role="alert">
<?php echo $word['borcunuzu_son_odeme_tarihine_kadar_odemelisiniz'].Balance($belediye['Belediye_Borc_Faiz']);?>
</div>
</div>

<div class="col-lg-6 col-sm-12 col-12">

<div class="text-center">
<p class="lead"><?php echo $word['odenmemis_borclar'];?></p>
</div>

<div class="row">

<?php 

$sorgu = "SELECT * FROM Borclar B JOIN Borc_Tipleri BT ON B.Borc_Tip_ID = BT.Tip_ID LEFT JOIN Su_Abonelikler SA ON B.Borclu_Bilgisi = SA.Abone_ID AND B.Borc_Tip_ID = 1 LEFT JOIN Uyeler U ON B.Borclu_Bilgisi = U.Uye_Sicil_No AND B.Borc_Tip_ID <> 1 WHERE ((B.Borc_Durum = 'Odenmedi') AND (B.Borc_Tip_ID = 1) AND (SA.Abone_Sicil_No = '$uye[Uye_Sicil_No]')) OR ((B.Borc_Durum = 'Odenmedi') AND (B.Borc_Tip_ID <> 1) AND (U.Uye_Sicil_No = '$uye[Uye_Sicil_No]')) ORDER BY Borc_Son_Odeme_Tarihi ASC";
$borclar = mysqli_query($mysqli, $sorgu);
while($borc = mysqli_fetch_assoc($borclar)){

    if($borc['Borc_Son_Odeme_Tarihi'] < $date){

        $color = "danger";
        $gecenGun = DateDifference($date, $borc['Borc_Son_Odeme_Tarihi']);
        $ceza = (($borc['Borc_Tutari']/100*$belediye['Belediye_Borc_Faiz'])*$gecenGun);
        $tutar = ("₺".Balance($borc['Borc_Tutari'])." + <b class='text-danger'>₺".Balance($ceza)."</b> = ₺".Balance($borc['Borc_Tutari']+$ceza));
        $textColor = "text-danger";

        $query = "UPDATE Borclar SET Borc_Ceza='$ceza' WHERE Borc_ID='$borc[Borc_ID]' AND Borc_Durum='Odenmedi'";
        mysqli_query($mysqli, $query);

    }else{

        $color = "info";
        $gecenGun = 0;
        $ceza = 0;
        $tutar = ("₺".Balance($borc['Borc_Tutari']));
        $textColor = "";

    }

?>

<div class="col-lg-12 col-sm-12 col-12">
<div class="card p-0">
  <h5 class="card-header bg-<?php echo $color;?> text-white p-2"><b><?php echo $word[$borc['Tip_Kodu']];?></b> (#<?php echo $borc['Borc_ID'];?>)</h5>
  <div class="card-body">
    <div class="row">
        <div class="col-lg-6 col-sm-12 col-12">
        <?php echo $word['borc_tutari'];?><h5 class="m-0 mb-2"><?php echo $tutar;?></h5>
        </div>
        <div class="col-lg-3 col-sm-6 col-6 <?php echo $textColor;?>">
        <?php echo $word['son_odeme_tarihi'];?><br><b><?php echo $borc['Borc_Son_Odeme_Tarihi'];?></b>
        </div>
        <div class="col-lg-3 col-sm-6 col-6 d-flex align-items-center justify-content-center">
        <a href="index.php?page=digital-cash-desk&type=borc_odeme&borc_id=<?php echo $borc['Borc_ID'];?>" class="btn btn-md btn-success"><?php echo $word['ode'];?></a>
        </div>
    </div>
  </div>
</div>
</div>

<?php }?>
                        
</div>
</div>

<div class="col-lg-6 col-sm-12 col-12">

<div class="text-center">
<p class="lead"><?php echo $word['odenmis_borclar'];?></p>
</div>

<div class="row">

<?php 

$sorgu = "SELECT * FROM Borclar B JOIN Borc_Tipleri BT ON B.Borc_Tip_ID = BT.Tip_ID LEFT JOIN Su_Abonelikler SA ON B.Borclu_Bilgisi = SA.Abone_ID AND B.Borc_Tip_ID = 1 LEFT JOIN Uyeler U ON B.Borclu_Bilgisi = U.Uye_Sicil_No AND B.Borc_Tip_ID <> 1 WHERE ((B.Borc_Durum = 'Odendi') AND (B.Borc_Tip_ID = 1) AND (SA.Abone_Sicil_No = '$uye[Uye_Sicil_No]')) OR ((B.Borc_Durum = 'Odendi') AND (B.Borc_Tip_ID <> 1) AND (U.Uye_Sicil_No = '$uye[Uye_Sicil_No]')) ORDER BY Borc_Son_Odeme_Tarihi ASC";
$borclar = mysqli_query($mysqli, $sorgu);
while($borc = mysqli_fetch_assoc($borclar)){

    $color = "success";
    $tutar = ("₺".Balance($borc['Borc_Tutari']+$borc['Borc_Ceza']));
    $textColor = "";

?>

<div class="col-lg-12 col-sm-12 col-12">
<div class="card p-0">
  <h5 class="card-header bg-<?php echo $color;?> text-white p-2"><b><?php echo $word[$borc['Tip_Kodu']];?></b> (#<?php echo $borc['Borc_ID'];?>)</h5>
  <div class="card-body">
    <div class="row">
        <div class="col-lg-6 col-sm-12 col-12">
        <?php echo $word['borc_tutari'];?><h5 class="m-0 mb-2"><?php echo $tutar;?></h5>
        </div>
        <div class="col-lg-3 col-sm-6 col-6 <?php echo $textColor;?>">
        <?php echo $word['son_odeme_tarihi'];?><br><b><?php echo $borc['Borc_Son_Odeme_Tarihi'];?></b>
        </div>
        <div class="col-lg-3 col-sm-6 col-6 d-flex align-items-center justify-content-center">
        <?php echo $word['odendi'];?>
        </div>
    </div>
  </div>
</div>
</div>

<?php }?>
                        
</div>
</div>

</div>

<?php }else{?>

<div class="col-lg-12 col-sm-12 col-12">
<div class="alert alert-warning" role="alert">
    <?php echo $word['bu_modul_icin_giris_yapilmalidir'];?><br><br>
    <a href="index.php?page=login&ref=<?php echo $_GET['page'];?>" class="btn btn-lg btn-danger"><?php echo $word['giris_yap'];?></a>
</div>
</div>

<?php }?>

</div>

