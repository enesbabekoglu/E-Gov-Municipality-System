<div class="container-fluid p-0">

<?php if(!isset($_GET['line_id'])){?>

<h1 class="h3 mb-3 text-center"><b><?php echo $word['ulasim_agi'];?></b></h1>

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

<div class="col-lg-12 col-sm-12 col-12">
<div class="card p-3" style="width: 100%;">

<table class="table">
    <thead>
        <tr>
            <th scope="col"><?php echo $word['hat'];?></th>
            <th scope="col"><?php echo $word['guzergah'];?></th>
            <th scope="col"><?php echo $word['hareket_saatleri'];?></th>
        </tr>
    </thead>
    <tbody>

    <?php 

    $sorgu = "SELECT * FROM Ulasim_Hatlar INNER JOIN Ulasim_Hat_Tipleri WHERE Ulasim_Hatlar.Hat_Durum='True' AND Ulasim_Hat_Tipleri.Hat_Tip_Durum='True' AND Ulasim_Hatlar.Hat_Tip_ID=Ulasim_Hat_Tipleri.Hat_Tip_ID ORDER BY Ulasim_Hatlar.Hat_Tip_ID ASC, Ulasim_Hatlar.Hat_Adi ASC";
    $hatlar = mysqli_query($mysqli, $sorgu);
    while($hat = mysqli_fetch_assoc($hatlar)){

    ?>

        <tr>
            <td><span class="badge fs-5 text-bg-<?php echo $hat['Hat_Tip_Renk'];?>"><b><?php echo $hat['Hat_Adi'];?></b></span></td>
            <td><?php echo $hat['Hat_Guzergah'];?></td>
            <td><a href="index.php?page=transport&line_id=<?php echo $hat['Hat_ID'];?>" class="btn btn-lg btn-primary"><i class="align-middle" data-feather="clock"></i></a></td>
        </tr>

    <?php }?>


    </tbody>
</table>

</div>
</div>
</div>

<?php }else{

    $hatID = $_GET['line_id'];
    
    $sorgu = "SELECT * FROM Ulasim_Hatlar INNER JOIN Ulasim_Hat_Tipleri WHERE Ulasim_Hatlar.Hat_Durum='True' AND Ulasim_Hat_Tipleri.Hat_Tip_Durum='True' AND Ulasim_Hatlar.Hat_Tip_ID=Ulasim_Hat_Tipleri.Hat_Tip_ID AND Ulasim_Hatlar.Hat_ID='$hatID'";
    $hat = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));
  
    $gunler = array("Hafta_Ici", "Cumartesi", "Pazar");

?>
  
    <div class="col-lg-12 col-sm-12 col-12">
    <h1 class="h3 mb-3 text-center"><b><?php echo $hat['Hat_Adi'];?> <?php echo $word['hareket_saatleri'];?></b></h1>
    <p class="lead text-center"><?php echo $hat['Hat_Guzergah'];?></p>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
    <div class="d-table-cell align-middle">
    <div class="card p-3" style="width: 100%;">
    <ul class="nav nav-pills d-flex align-items-center justify-content-center" id="myTab" role="tablist">
    <?php 
    $sorgu = "SELECT Hareket_Noktasi FROM Ulasim_Hareket_Saatleri WHERE Hareket_Hat_ID='$hatID' ORDER BY Hareket_ID ASC";
    $hareketler = mysqli_query($mysqli, $sorgu);
    $i = 1;
    while($hareket = mysqli_fetch_assoc($hareketler)){
    ?>
    <li class="nav-item" role="presentation">
        <button class="nav-link <?php echo (($i==1)?"active":"");?>" id="tab-rota<?php echo $i;?>" data-bs-toggle="tab" data-bs-target="#rota<?php echo $i;?>" type="button" role="tab" aria-controls="rota<?php echo $i;?>" aria-selected="true"><?php echo $hareket['Hareket_Noktasi'];?></button>
    </li>
    <?php $i++;}?>
    </ul>

    <div class="tab-content p-4" id="myTabContent">
    <?php 
    $sorgu = "SELECT * FROM Ulasim_Hareket_Saatleri WHERE Hareket_Hat_ID='$hatID' ORDER BY Hareket_ID ASC";
    $hareketler = mysqli_query($mysqli, $sorgu);
    $i = 1;
    while($hareket = mysqli_fetch_assoc($hareketler)){
    ?>
    <div class="tab-pane fade <?php echo (($i==1)?"show active":"");?>" id="rota<?php echo $i;?>" role="tabpanel" aria-labelledby="tab-rota<?php echo $i;?>" tabindex="0">
    <div class="row">
    <?php foreach($gunler as $gun){?>
        <div class="col-lg-4 col-sm-4 col-4 text-center">
        <h5><b><?php echo $word[$gun];?></b></h5>
        <?php echo nl2br($hareket[$gun]);?>
        </div>
    <?php }?>
    </div>
    </div>
    <?php $i++;}?>
    </div>
    </div>
    </div>
    </div>

<?php }?>

</div>