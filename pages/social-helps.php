<div class="container-fluid p-0">

<h1 class="h3 mb-3 text-center"><b><?php echo $word['sosyal_yardimlar'];?></b></h1>

<div class="row">

<?php 

if(!isset($_GET['help_id'])){

$sorgu = "SELECT * FROM Sosyal_Yardimlar WHERE Yardim_Durum='True' AND ((Yardim_Baslangic<='$time' AND Yardim_Bitis>='$time') OR (Yardim_Baslangic IS NULL AND Yardim_Bitis IS NULL) OR (Yardim_Baslangic IS NULL AND Yardim_Bitis>='$time') OR (Yardim_Baslangic<='$time' AND Yardim_Bitis IS NULL)) ORDER BY Yardim_Bitis ASC";
$yardimlar = mysqli_query($mysqli, $sorgu);
while($yardim = mysqli_fetch_assoc($yardimlar)){

    $uyelikGerekiyor = (True) ? $word['uyelik_gerekir'] : $word['uyelik_gerekmez'];
    $uyelikGerekiyorColor = (True) ? "danger" : "warning";

?>

<div class="col-lg-3 col-sm-6 col-6">
<a href="index.php?page=social-helps&help_id=<?php echo $yardim['Yardim_ID'];?>">
<div class="card" style="width: 100%;">
  <img src="<?php echo $yardim['Yardim_Kapak'];?>" class="card-img-top" alt="<?php echo $yardim['Yardim_Baslik'];?>" style="min-height: 15vh;">
  <div class="card-body text-center">
    <h5 class="card-text"><b><?php echo $yardim['Yardim_Baslik'];?></b></h5>
    <?php if(!$login){?><span class="badge rounded-pill text-bg-<?php echo $uyelikGerekiyorColor;?>"><?php echo $uyelikGerekiyor;?></span><?php }?>
  </div>
</div>
</a>
</div>

<?php }?>

<?php if($login){?>

<div class="col-lg-12 col-sm-12 col-12">
<h1 class="h3 mb-3 text-center"><b><?php echo $word['basvurularim'];?></b></h1>
</div>

<div class="col-lg-12 col-sm-12 col-12">
<div class="card p-3" style="width: 100%;">

<table class="table">
    <thead>
        <tr>
            <th scope="col"><?php echo $word['yardim_adi'];?></th>
            <th scope="col"><?php echo $word['zaman'];?></th>
            <th scope="col"><?php echo $word['durum'];?></th>
        </tr>
    </thead>
    <tbody>

    <?php 

    $sorgu = "SELECT * FROM Sosyal_Yardimlar_Basvurular JOIN Sosyal_Yardimlar WHERE Sosyal_Yardimlar_Basvurular.Basvuru_Uye_ID='$userID' AND Sosyal_Yardimlar_Basvurular.Basvuru_Yardim_ID=Sosyal_Yardimlar.Yardim_ID ORDER BY Basvuru_ID DESC";
    $basvurular = mysqli_query($mysqli, $sorgu);
    while($basvuru = mysqli_fetch_assoc($basvurular)){

        if($basvuru['Basvuru_Durum'] == "Onaylandi"){
            $renk = "success";
            $text = $word['onaylandi'];
        }elseif($basvuru['Basvuru_Durum'] == "Reddedildi"){
            $renk = "danger";
            $text = $word['reddedildi'];
        }else{
            $renk = "warning";
            $text = $word['degerlendiriliyor'];
        }

    ?>

        <tr>
            <td><?php echo $basvuru['Yardim_Baslik'];?> (#<?php echo $basvuru['Basvuru_ID'];?>)</td>
            <td><?php echo DateReplace($basvuru['Basvuru_Zaman']);?></td>
            <td><span class="badge text-bg-<?php echo $renk;?>"><b><?php echo $text;?></b></span></td>
        </tr>

    <?php }?>

    </tbody>
</table>

</div>
</div>

<?php }}else{

if($login){

    $yardimID = $_GET['help_id'];
    
    $sorgu = "SELECT *, COUNT(Yardim_ID) AS say FROM Sosyal_Yardimlar WHERE Yardim_Durum='True' AND ((Yardim_Baslangic<='$time' AND Yardim_Bitis>='$time') OR (Yardim_Baslangic IS NULL AND Yardim_Bitis IS NULL) OR (Yardim_Baslangic IS NULL AND Yardim_Bitis>='$time') OR (Yardim_Baslangic<='$time' AND Yardim_Bitis IS NULL)) AND Yardim_ID='$yardimID'";
    $yardim = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

    if($yardim['say'] > 0){

?>

    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
			<div class="d-table-cell align-middle">

				<div class="text-center">
					<p class="lead"><?php echo $yardim['Yardim_Baslik'];?></p>
                </div>

				<div class="card">
					<div class="card-body">
						<div class="m-sm-3">
							<form id="YardimForm">
                                <input type="hidden" name="sosyal_yardim">
                                <input type="hidden" name="yardim_id" value="<?php echo $yardimID;?>">
                                <?php
                                // Girdi
                                $girdi = $yardim['Yardim_Istenen_Girdiler'];

                                // Parçaları virgülle ayır
                                $parcalar = preg_split('/,\s*(?![^\[]*\])/', $girdi);

                                // Sonuç dizisi
                                $sonuc = array();

                                foreach ($parcalar as $parca) {
                                    // Anahtar ve değeri ayır
                                    $parca = explode('[', $parca);
                                
                                    // Anahtar
                                    $anahtar = trim($parca[0]);
                                
                                    // Değer varsa işleme al
                                    if (isset($parca[1])) {
                                        // Değeri temizle ve parçala
                                        $deger = str_replace(['[', ']'], '', $parca[1]);
                                        $deger = explode(',', $deger);
                                        $deger = array_map('trim', $deger);
                                    } else {
                                        // Değer yoksa boş dizi ata
                                        $deger = [];
                                    }
                                
                                    // Anahtar ve değeri ekle
                                    $sonuc[$anahtar] = $deger;
                                }                                

                                ?>

                                <?php $i = 1; foreach ($sonuc as $anahtar => $alt_anahtarlar) { ?>
                                    <div class="mb-3">
                                        <label class="form-label"><?php echo $anahtar; ?></label>

                                        <?php if (!empty($alt_anahtarlar)) { ?>
                                            <select class="form-control form-control-lg" name="<?php echo $i."-".md5($anahtar); ?>">
                                                <?php foreach ($alt_anahtarlar as $alt_anahtar) { ?>
                                                    <option value="<?php echo $alt_anahtar; ?>"><?php echo $alt_anahtar; ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } else { ?>
                                            <input class="form-control form-control-lg" type="text" name="<?php echo $i."-".md5($anahtar); ?>" placeholder="<?php echo $anahtar; ?>"/>
                                        <?php } ?>

                                    </div>
                                <?php $i++;} ?>

								<div>
									<div class="form-check align-items-center">
										<input id="customControlInline" type="checkbox" class="form-check-input" value="true" name="sozlesme" checked>
										<label class="form-check-label text-small" for="customControlInline"><?php echo $word['sozlesmeyi_kabul_ediyorum'];?></label>
									</div>
								</div>

								<div class="d-grid gap-2 mt-3">
									<button type="button" id="YardimButton" class="btn btn-lg btn-info"><?php echo $word['basvuru_yap'];?></button>
								</div>
							</form>
						</div>
					</div>
				</div>

			</div>
		</div>

        <script>

$(document).ready(function(){

$('#YardimButton').click(function(e){

    e.preventDefault(); // Butona tıklamada normal submit işlemini engeller
    
    DataSendLoad();

    var formData = $('#YardimForm').serialize(); // Form verilerini alır

    $.ajax({
        url: 'ajax/social-helps.php', // AJAX isteğinin gideceği adres
        type: "POST",
        data: formData,
        success: function (response){

            try {  // Sunucudan dönen veriyi JSON olarak işler

                var data = JSON.parse(response);

                Swal.fire(data.title, data.text, data.status);

                if(data.status == "success"){
                    $('#YardimForm')[0].reset(); // İşlem başarılı olduğunda formu sıfırla
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

    return false;

});

});

</script>

<?php }else{?>

<div class="col-lg-12 col-sm-12 col-12">
<div class="alert alert-warning" role="alert">
    <?php echo $word['yardim_basvurusu_bulunamadi'];?><br><br>
    <a onclick="window.history.back();" class="btn btn-lg btn-danger"><?php echo $word['geri_don'];?></a>
</div>
</div>

<?php }?>

<?php }else{?>

<div class="col-lg-12 col-sm-12 col-12">
<div class="alert alert-warning" role="alert">
    <?php echo $word['bu_modul_icin_giris_yapilmalidir'];?><br><br>
    <a href="index.php?page=login&ref=<?php echo $_GET['page'];?>" class="btn btn-lg btn-danger"><?php echo $word['giris_yap'];?></a>
</div>
</div>

<?php }}?>

</div>

</div>