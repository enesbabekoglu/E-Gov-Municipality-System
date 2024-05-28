<div class="container-fluid p-0">

<h1 class="h3 mb-3 text-center"><b><?php echo $word['binis_simulasyonu'];?></b></h1>

<div class="row">

<?php if($login){?>

<?php if(!$_GET['hat']){?>

    <?php 

        $sorgu = "SELECT * FROM Ulasim_Hatlar INNER JOIN Ulasim_Hat_Tipleri WHERE Ulasim_Hatlar.Hat_Durum='True' AND Ulasim_Hat_Tipleri.Hat_Tip_Durum='True' AND Ulasim_Hatlar.Hat_Tip_ID=Ulasim_Hat_Tipleri.Hat_Tip_ID ORDER BY Ulasim_Hatlar.Hat_Tip_ID ASC, Ulasim_Hatlar.Hat_Adi ASC";
        $hatlar = mysqli_query($mysqli, $sorgu);
        while($hat = mysqli_fetch_assoc($hatlar)){

    ?>

    <div class="col-lg-2 col-sm-6 col-6">
    <a href="index.php?page=transport-simulator&hat=<?php echo $hat['Hat_ID'];?>">
    <div class="card text-bg-<?php echo $hat['Hat_Tip_Renk'];?>" style="width: 100%;">
    <div class="card-body text-center">
        <h4 class="card-text"><b><?php echo $hat['Hat_Adi'];?></b></h4>
    </div>
    </div>
    </a>
    </div>

    <?php }?>
    
<?php }else{?>

    <?php if(!$_GET['kart']){?>

        <?php 

        $gerekenler = "Ulasim_Kartlar.*, Ulasim_Kart_Tipleri.Tip_Kodu, Ulasim_Kart_Tipleri.Kart_Renk";
        $sorgu = "SELECT $gerekenler FROM Ulasim_Kartlar JOIN Ulasim_Kart_Tipleri ON Ulasim_Kartlar.Kart_Tip_ID = Ulasim_Kart_Tipleri.Kart_Tip_ID WHERE Ulasim_Kartlar.Kart_Durum='True' AND Ulasim_Kartlar.Kart_Uye_ID='$userID' ORDER BY Ulasim_Kartlar.Kart_Tip_ID ASC, Ulasim_Kartlar.Kart_Bakiye DESC";
        $kartlar = mysqli_query($mysqli, $sorgu);
        $i = 0;
        while($kart = mysqli_fetch_assoc($kartlar)){

        ?>

        <div class="col-lg-3 col-sm-12 col-12 mb-2">
        <a href="index.php?page=transport-simulator&hat=<?php echo $_GET['hat'];?>&kart=<?php echo $kart['Kart_ID'];?>">
        <div class="card d-flex flex-column bg-<?php echo $kart['Kart_Renk']; ?> p-2 rounded-5">
        <div class="card-body text-center row">
            <div class="col-12 text-start">
                <h4 class="card-text text-white"><b><?php echo $word["kart_".$kart['Tip_Kodu']];?></b></h4>
                <h3 class="card-text text-white">₺<?php echo Balance($kart['Kart_Bakiye']);?></h3>
                <span class="badge rounded-3 bg-white text-dark p-2 pe-3 ps-3"><?php echo TextReText($kart['Kart_No'], 4, ' ');?></span>
            </div>
        </div>
        </div>
        </a>
        </div>

        <?php $i++;} if($i == 0){?>

    <div class="col-lg-12 col-sm-12 col-12">
    <div class="alert alert-warning" role="alert">
        <?php echo $word['hic_ulasim_kartiniz_yoktur'];?><br><br>
        <a onclick="window.history.back();" class="btn btn-lg btn-danger"><?php echo $word['geri_don'];?></a>
    </div>
    </div>

    <?php }}else{
        
        $sorgu = "SELECT * FROM Ulasim_Hatlar INNER JOIN Ulasim_Hat_Tipleri WHERE Ulasim_Hatlar.Hat_Durum='True' AND Ulasim_Hat_Tipleri.Hat_Tip_Durum='True' AND Ulasim_Hatlar.Hat_Tip_ID=Ulasim_Hat_Tipleri.Hat_Tip_ID AND Ulasim_Hatlar.Hat_ID='$_GET[hat]'";
        $hat = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));
    
        $sorgu = "SELECT * FROM Ulasim_Tarifeler WHERE Tarife_ID='$hat[Hat_Tarife_ID]' AND Tarife_Durum='True'";
        $tarife = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

    ?>

        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
			<div class="d-table-cell align-middle">
				<div class="card bg-info p-4 rounded-3">
					<div class="card-body bg-info-subtle rounded-3 p-1">
						<div class="row">
                            <div class="col-12 p-4 pt-0">
                                <div class="bg-primary rounded-3 p-2 pt-1 text-light row">
                                    <div class="col-6 text-start">
                                        <i class="align-middle" data-feather="wifi"></i>
                                        <i class="align-middle" data-feather="bluetooth"></i>
                                        <i class="align-middle" data-feather="map-pin"></i>
                                    </div>
                                    <div class="col-6 text-end">
                                        <i class="align-middle" data-feather="battery-charging"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="lead text-center mb-0"><b><?php echo $hat['Hat_Adi'];?></b></p>
                                <p class="text-center"><?php echo $hat['Hat_Guzergah'];?></p>
                            </div>
                            <div class="col-12 p-3 pt-4 d-flex align-items-center justify-content-center" style="height: 40vh;">
                                <div onclick="BinisKartOkut('<?php echo $_GET['hat'];?>', '<?php echo $_GET['kart'];?>');" class="card bg-body-tertiary rounded-5 p-3 d-flex align-items-center justify-content-center" id="KartOkut">
                                    <img src="img/nfc.png" style="width: 200px;" alt="">
                                    <p class="mt-3 mb-0"><em><?php echo $word['kartinizi_buraya_okutun'];?></em></p>
                                </div>
                                <div class="p-3 text-center" id="KartOkunduOdendi" style="display: none;">
                                    <h3 class="text-danger"><b>Kesilen Tutar: </b> -₺<text id="KesilenTutar">0.00</text></h3>
                                    <h3 class="text-primary"><b>Kalan Bakiye: </b> ₺<text id="KalanBakiye">0.00</text></h3>
                                    <h1><b>İyi yolculuklar dileriz.</b></h1>
                                </div>
                                <div class="p-3 text-center" id="KartOkunduYetersizBakiye" style="display: none;">
                                    <h3 class="text-primary"><b>Bakiyeniz: </b> ₺<text id="Bakiye">0.00</text></h3>
                                    <h1><b>YETERSİZ BAKİYE!</b></h1>
                                </div>
                                <div class="p-3 text-center" id="KartOkunduHata" style="display: none;">
                                    <h1><b>HATA OLUŞTU LÜTFEN KARTINIZI TEKRAR OKUTUN</b></h1>
                                </div>
                            </div>

                            <div class="col-12 text-center p-3">
                                <p><?php echo $word['kart_Tam'];?>: ₺<?php echo Balance($tarife['Ucret_Tam']);?> | <?php echo $word['kart_Ogrenci'];?>: ₺<?php echo Balance($tarife['Ucret_Ogrenci']);?></p>
                            </div>

                            <div class="col-12 text-center mb-3"><img src="img/payment-x.svg" alt="" style="width: 75%;"></div>

						</div>
					</div>
				</div>

			</div>
		</div>

    <?php }?>

<?php }?>

<?php }else{?>

<div class="col-lg-12 col-sm-12 col-12">
<div class="alert alert-warning" role="alert">
    <?php echo $word['bu_modul_icin_giris_yapilmalidir'];?><br><br>
    <a href="index.php?page=login&ref=<?php echo $_GET['page'];?>" class="btn btn-lg btn-danger"><?php echo $word['giris_yap'];?></a>
</div>
</div>

<?php }?>

</div>

</div>

<script>

function BinisKartOkut(hat, kart){

    $.ajax({
            url: 'ajax/transport-card.php',
            type: 'POST',
            data: {"binis_yap": "true", "hat": hat, "kart": kart},
            success: function(response) {

                document.getElementById("KartOkut").style.display = "none";
                document.getElementById("KartOkut").classList.remove("d-flex");

                try {

                    var data = JSON.parse(response);

                    if(data.status == "odeme_yapildi"){

                        document.getElementById("KartOkunduOdendi").style.display = "block";
                        document.getElementById("KesilenTutar").innerHTML = data.kesilen;
                        document.getElementById("KalanBakiye").innerHTML = data.bakiye;

                        var sound = new Audio("sounds/akbil.mp3");
                        sound.play();

                    }else if(data.status == "yetersiz_bakiye"){

                        document.getElementById("KartOkunduYetersizBakiye").style.display = "block";
                        document.getElementById("Bakiye").innerHTML = data.bakiye;

                        var sound = new Audio("sounds/error.mp3");
                        sound.play();

                    }else if(data.status == "hata_olustu"){

                        document.getElementById("KartOkunduHata").style.display = "block";

                        var sound = new Audio("sounds/error.mp3");
                        sound.play();

                    }

                } catch (error) {

                    document.getElementById("KartOkunduHata").style.display = "block";
                    
                    var sound = new Audio("sounds/error.mp3");
                    sound.play();

                }

                setTimeout(function() {
                    
                    document.getElementById("KartOkut").style.display = "block";
                    document.getElementById("KartOkut").classList.add("d-flex");
                    document.getElementById("KartOkunduOdendi").style.display = "none";
                    document.getElementById("KartOkunduYetersizBakiye").style.display = "none";
                    document.getElementById("KartOkunduHata").style.display = "none";

                }, 3000);

            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
            
    });

}

</script>