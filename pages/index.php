<div class="container-fluid p-0">

<h1 class="h3 mb-3 text-center"><b><?php echo $word['moduller'];?></b></h1>

<div class="row">

<?php 

$sorgu = "SELECT Modul_Kodu, Modul_Url, Modul_Tipi, Modul_Gorsel, Modul_Uyelik FROM Moduller WHERE Modul_Durumu='True' AND Modul_Sayfa='$page' ORDER BY Modul_Oncelik DESC, Modul_Uyelik DESC";
$moduller = mysqli_query($mysqli, $sorgu);
while($modul = mysqli_fetch_assoc($moduller)){

    $modulURL = ($modul['Modul_Tipi'] == "3rd") ? ("target='_blank' href='".$modul['Modul_Url']."'") : ("href='index.php?page=".$modul['Modul_Url']."'");
    $uyelikGerekiyor = ($modul['Modul_Uyelik'] == "True") ? $word['uyelik_gerekir'] : $word['uyelik_gerekmez'];
    $uyelikGerekiyorColor = ($modul['Modul_Uyelik'] == "True") ? "danger" : "warning";

?>

<div class="col-lg-2 col-sm-6 col-6">
<a <?php echo $modulURL;?>>
<div class="card" style="width: 100%;">
  <img src="<?php echo $modul['Modul_Gorsel'];?>" class="card-img-top" alt="<?php echo $word[$modul['Modul_Kodu']];?>" style="min-height: 15vh;">
  <div class="card-body text-center">
    <h5 class="card-text"><b><?php echo $word[$modul['Modul_Kodu']];?></b></h5>
    <?php if(!$login){?><span class="badge rounded-pill text-bg-<?php echo $uyelikGerekiyorColor;?>"><?php echo $uyelikGerekiyor;?></span><?php }?>
  </div>
</div>
</a>
</div>

<?php }?>

</div>

</div>