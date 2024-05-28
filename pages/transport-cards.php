<div class="container-fluid p-0">

<div class="row">

<?php if($login){?>

<?php if(!isset($_GET['type'])){?>

<div class="col-lg-12 col-sm-12 col-12">
<h1 class="h3 mb-3 text-center"><b><?php echo $word['kartlarim'];?></b></h1>
</div>

<?php

  $gerekenler = "Ulasim_Kartlar.*, Ulasim_Kart_Tipleri.Tip_Kodu, Ulasim_Kart_Tipleri.Kart_Renk";
  $sorgu = "SELECT $gerekenler FROM Ulasim_Kartlar JOIN Ulasim_Kart_Tipleri ON Ulasim_Kartlar.Kart_Tip_ID = Ulasim_Kart_Tipleri.Kart_Tip_ID WHERE Ulasim_Kartlar.Kart_Durum='True' AND Ulasim_Kartlar.Kart_Uye_ID='$userID' ORDER BY Ulasim_Kartlar.Kart_Tip_ID ASC, Ulasim_Kartlar.Kart_Bakiye DESC";
  $kartlar = mysqli_query($mysqli, $sorgu);
  while($kart = mysqli_fetch_assoc($kartlar)){

?>

<div class="col-lg-4 col-sm-12 col-12 mb-2">
<div class="card h-100 d-flex flex-column bg-<?php echo $kart['Kart_Renk']; ?> p-2 rounded-5">
  <div class="card-body text-center row">
    <div class="col-7 text-start">
        <h4 class="card-text text-white"><b><?php echo $word["kart_".$kart['Tip_Kodu']];?></b></h4>
        <h3 class="card-text text-white">₺<?php echo Balance($kart['Kart_Bakiye']);?></h3>
        <span class="badge rounded-3 bg-white text-dark p-2 pe-3 ps-3"><?php echo TextReText($kart['Kart_No'], 4, ' ');?></span>
        <p class="m-0 mt-2">
            <a href="index.php?page=digital-cash-desk&type=ulasim_karti_bakiye&card_no=<?php echo $kart['Kart_No'];?>" class="btn btn-sm btn-light mb-1"><?php echo $word['bakiye_yukle'];?></a>
            <a href="index.php?page=transport-cards&type=boardings&card_id=<?php echo $kart['Kart_ID'];?>" class="btn btn-sm btn-light mb-1"><?php echo $word['binisler'];?></a>
        </p>
    </div>
    <div class="col-5 bg-white p-2 rounded-4 d-flex justify-content-center align-items-center">
        <img src="<?php echo $belediye['Belediye_Logo'];?>" class="card-img-top" alt="<?php echo $belediye['Belediye_Ad'];?>" style="width: 100px;">
    </div>
  </div>
</div>
</div>

<?php }?>

<div class="col-lg-4 col-sm-12 col-12 mb-2">
<div class="card h-100 d-flex flex-column bg-dark-subtle p-2 rounded-5">
  <div class="card-body text-center row">
    <div class="col-7 text-center row d-flex align-items-center">
        <div class="col-12"><i class="align-middle" data-feather="plus-circle" style="width:35px;height:35px;"></i></div>
        <div class="col-12">
            <h4 class="card-text text-dark"><b><?php echo $word['yeni_kart'];?></b></h4>
        </div>
        <div class="col-12">
            <a href="index.php?page=transport-cards&type=new-card" class="btn btn-lg btn-light"><?php echo $word['yeni_kart'];?></a>
        </div>
    </div>
    <div class="col-5 bg-white p-2 rounded-4 d-flex justify-content-center align-items-center">
        <img src="<?php echo $belediye['Belediye_Logo'];?>" class="card-img-top" alt="<?php echo $belediye['Belediye_Ad'];?>" style="width: 100px;">
    </div>
  </div>
</div>
</div>

<?php }elseif($_GET['type'] == "boardings"){
  
  $sorgu = "SELECT Kart_No FROM Ulasim_Kartlar WHERE Kart_ID='$_GET[card_id]'";
  $kart = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

?>

<div class="col-lg-12 col-sm-12 col-12">
<h1 class="h3 mb-3 text-center"><b><?php echo $word['binisler'];?></b></h1>
<p class="lead text-center"><?php echo TextReText($kart['Kart_No'], 4, '-');?></p>
</div>

<div class="col-lg-12 col-sm-12 col-12">
<div class="card p-3" style="width: 100%;">

<table class="table">
    <thead>
        <tr>
            <th scope="col"><?php echo $word['islem_yeri'];?></th>
            <th scope="col"><?php echo $word['tutar'];?></th>
            <th scope="col"><?php echo $word['zaman'];?></th>
        </tr>
    </thead>
    <tbody>

    <?php 

    $sorgu = "SELECT * FROM Ulasim_Kart_Islemler WHERE Islem_Kart_ID='$_GET[card_id]' ORDER BY Islem_ID DESC LIMIT 10";
    $islemler = mysqli_query($mysqli, $sorgu);
    while($islem = mysqli_fetch_assoc($islemler)){

      $islem['Islem_Tutar'] = ($islem['Islem_Tip'] == "Yukleme") ? "+₺".Balance($islem['Islem_Tutar']): "-₺".Balance($islem['Islem_Tutar']);
      $renk = ($islem['Islem_Tip'] == "Yukleme") ? "success" : "danger";

    ?>

        <tr>
            <td><?php echo $islem['Islem_Yeri'];?></td>
            <td><span class="badge fs-5 text-bg-<?php echo $renk;?>"><b><?php echo $islem['Islem_Tutar'];?></b></span></td>
            <td><?php echo DateReplace($islem['Islem_Zaman']);?></td>
        </tr>

    <?php }?>


    </tbody>
</table>

</div>
</div>

<?php }elseif($_GET['type'] == "new-card" && !isset($_GET['card-type'])){?>

  <div class="col-lg-12 col-sm-12 col-12">
  <h1 class="h3 mb-3 text-center"><b><?php echo $word['yeni_kart'];?></b></h1>
  <p class="lead text-center"><?php echo $word['olusturulacak_kart_tipi_seciniz'];?></p>
  </div>

  <?php 

  $gerekenler = "*";
  $sorgu = "SELECT $gerekenler FROM Ulasim_Kart_Tipleri WHERE Tip_Durum='True'";
  $tipler = mysqli_query($mysqli, $sorgu);
  while($tip = mysqli_fetch_assoc($tipler)){

  ?>

  <div class="col-lg-3 col-sm-12 col-12 mb-2">
  <div onclick="KartOlustur('<?php echo $tip['Kart_Tip_ID'];?>');" class="card d-flex flex-column bg-<?php echo $tip['Kart_Renk']; ?> p-2 rounded-5">
  <div class="card-body text-center row">
      <div class="col-12 text-center">
          <h4 class="card-text text-white"><b><?php echo $word["kart_".$tip['Tip_Kodu']];?></b></h4>
      </div>
  </div>
  </div>
  </div>

  <?php }?>

  <script>
    function KartOlustur(tipID){
      
      $.ajax({
        url: 'ajax/transport-card.php', // AJAX isteğinin gideceği adres
        type: "POST",
        data: {"kart_olustur": "true", "kart_tipi": tipID},
        success: function (response){

            try {  // Sunucudan dönen veriyi JSON olarak işler

                var data = JSON.parse(response);

                Swal.fire(data.title, data.text, data.status);

                if(data.status == "success"){
                    setTimeout(function() {window.history.back();}, 3000);
                }

            } catch (error) {

                Swal.fire('<?php echo $word['hata'];?>', '<?php echo $word['bir_hata_olustu'];?>', 'error');

            }

        },
        error: function(xhr, status, error){
            Swal.fire('<?php echo $word['hata'];?>', '<?php echo $word['sunucu_hatasi'];?>' + xhr.status, 'error');
        }
      });

    }
  </script>

<?php }}else{?>

<div class="col-lg-12 col-sm-12 col-12">
<div class="alert alert-warning" role="alert">
    <?php echo $word['bu_modul_icin_giris_yapilmalidir'];?><br><br>
    <a href="index.php?page=login&ref=<?php echo $_GET['page'];?>" class="btn btn-lg btn-danger"><?php echo $word['giris_yap'];?></a>
</div>
</div>

<?php }?>

</div>

</div>