<div class="container-fluid p-0">

<?php 

$sorgu = "SELECT * FROM Belediye_Departmanlar WHERE Departman_Durum='True' ORDER BY Departman_ID ASC";
$departmanlar = mysqli_query($mysqli, $sorgu);
while($departman = mysqli_fetch_assoc($departmanlar)){

?>

<div class="row d-flex justify-content-center">

<p class="lead text-center"><b><?php echo $departman['Departman_Ad'];?></b></p>

<?php 

$gerekenler = "Belediye_Personeller.*, Uyeler.Uye_Ad, Uyeler.Uye_Soyad, Uyeler.Uye_Sicil_No, Uyeler.Uye_Profil";
$sorgu = "SELECT $gerekenler FROM Belediye_Personeller JOIN Uyeler WHERE Belediye_Personeller.Personel_Sicil_No=Uyeler.Uye_Sicil_No AND Belediye_Personeller.Personel_Durum='True' AND Belediye_Personeller.Personel_Departman_ID='$departman[Departman_ID]' ORDER BY Personel_ID ASC";
$personeller = mysqli_query($mysqli, $sorgu);
while($personel = mysqli_fetch_assoc($personeller)){

?>

<div class="col-lg-2 col-sm-6 col-6">
<div class="card" style="width: 100%;">
  <img src="<?php echo $personel['Uye_Profil'];?>" class="card-img-top" alt="<?php echo $personel['Uye_Ad'];?> <?php echo $personel['Uye_Soyad'];?>" style="min-height: 15vh;">
  <div class="card-body text-center">
    <h5 class="card-text"><b><?php echo $personel['Uye_Ad'];?> <?php echo $personel['Uye_Soyad'];?></b></h5>
    <span><?php echo $personel['Personel_Gorev'];?></span>
  </div>
</div>
</div>

<?php }?>

</div>

<?php }?>

</div>