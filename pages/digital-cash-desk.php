<div class="container-fluid p-0">

<h1 class="h3 mb-3 text-center"><b><?php echo $word['dijital_vezne'];?></b></h1>

<div class="row">

<?php if(!$_GET['type']){?>

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
    
<?php }else{?>

        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
			<div class="d-table-cell align-middle">

				<div class="text-center">
					<p class="lead"><?php echo $word[$_GET['type']];?></p>
                </div>

				<div class="card">
					<div class="card-body">
						<div class="m-sm-3">
							<form id="VezneForm">
                                <input type="hidden" name="vezne">
                                <input type="hidden" name="odeme_tipi" value="<?php echo $_GET['type'];?>">

                                <?php if($_GET['type'] == "ulasim_karti_bakiye"){
                                    
                                    $sorgu = "SELECT Kart_Bakiye FROM Ulasim_Kartlar WHERE Kart_No='$_GET[card_no]'";
                                    $kart = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

                                    $bakiye = Balance((isset($kart)) ? $kart['Kart_Bakiye']: 0);

                                ?>
                                <div class="mb-3">
                                    <h4 class="text-center"><b><?php echo $word['odeme_bilgileri'];?></b></h4>
                                </div>
								<div class="mb-3">
									<label class="form-label"><?php echo $word['ulasim_kart_no'];?></label>
									<input class="form-control form-control-lg" type="number" name="ulasim_kart_no" value="<?php echo $_GET['card_no'];?>" placeholder="<?php echo $word['ulasim_kart_no'];?>" <?php if(isset($_GET['card_no'])){echo "readonly";}?>/>
								</div>
								<div class="mb-3">
									<label class="form-label"><?php echo $word['mevcut_bakiye'];?></label>
									<input class="form-control form-control-lg" type="text" id="mevcut_data" value="₺<?php echo $bakiye;?>" placeholder="<?php echo $word['mevcut_bakiye'];?>" disabled/>
								</div>
                                <div class="mb-3">
									<label class="form-label"><?php echo $word['yuklenecek_bakiye'];?></label>
									<input class="form-control form-control-lg" type="number" name="yuklenecek_bakiye" placeholder="<?php echo $word['yuklenecek_bakiye'];?>"/>
								</div>
                                <div class="mb-3 mt-4">
                                    <h4 class="text-center"><b><?php echo $word['kredi_banka_kart_bilgileri'];?></b></h4>
                                </div>
                                <div class="row">
                                <div class="mb-3 col-lg-5 col-sm-12 col-12">
									<label class="form-label"><?php echo $word['kart_sahibi_ad_soyad'];?></label>
									<input class="form-control form-control-lg" type="text" name="kredi_kart_ad_soyad" placeholder="<?php echo $word['kart_sahibi_ad_soyad'];?>"/>
								</div>
                                <div class="mb-3 col-lg-7 col-sm-12 col-12">
									<label class="form-label"><?php echo $word['kart_no'];?></label>
									<input class="form-control form-control-lg" type="number" name="kredi_kart_no" placeholder="<?php echo $word['kart_no'];?>"/>
								</div>
                                <div class="mb-3 col-lg-4 col-sm-4 col-4">
									<label class="form-label"><?php echo $word['son_kullanma_tarihi_ay'];?></label>
									<select class="form-control form-control-lg" name="kredi_kart_ay">
                                        <?php for($i = 1; $i <= 12; $i++){?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php }?>
                                    </select>
								</div>
                                <div class="mb-3 col-lg-4 col-sm-4 col-4">
									<label class="form-label"><?php echo $word['son_kullanma_tarihi_yil'];?></label>
									<select class="form-control form-control-lg" name="kredi_kart_yil">
                                        <?php for($i = date("Y"); $i < (date("Y")+100); $i++){?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php }?>
                                    </select>
								</div>
                                <div class="mb-3 col-lg-4 col-sm-4 col-4">
									<label class="form-label"><?php echo $word['cvv_kodu'];?></label>
									<input class="form-control form-control-lg" type="number" name="kredi_kart_cvv" placeholder="<?php echo $word['cvv_kodu'];?>"/>
								</div>
                                </div>
								<div>
									<div class="form-check align-items-center">
										<input id="customControlInline" type="checkbox" class="form-check-input" value="true" name="sozlesme" checked>
										<label class="form-check-label text-small" for="customControlInline"><?php echo $word['satis_sozlesmesini_okudum'];?></label>
									</div>
								</div>

                                <script>

                                $(document).ready(function(){

                                    $('input[name="ulasim_kart_no"]').on('input', function() {

                                    var kartNo = $(this).val();

                                    if(kartNo.length == 16){

                                        $.ajax({
                                            url: 'ajax/transport-card.php',
                                            type: 'POST',
                                            data: { "bakiye_sorgula": "true", "ulasim_kart_no": kartNo },
                                            beforeSend: function() {
                                                $('#mevcut_data').val('<?php echo $word['bakiye_sorgulaniyor'];?>');
                                            },
                                            success: function(response) {
                                                try {
                                                    var data = JSON.parse(response);
                                                    if (data && data.tutar) {
                                                        $('#mevcut_data').val(data.tutar);
                                                    } else {
                                                        throw new Error('<?php echo $word['bakiye_alinamadi'];?>');
                                                    }
                                                } catch (error) {
                                                    console.error('JSON parse error:', error);
                                                    $('#mevcut_data').val('<?php echo $word['bakiye_alinamadi'];?>');
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('AJAX error:', status, error);
                                            }
                                            
                                    });}else{

                                        $('#mevcut_data').val('₺0.00');

                                    }

                                    });

                                });

                                </script>

                                <?php }?>

                                <?php if($_GET['type'] == "borc_odeme"){
                                    
                                    $sorgu = "SELECT * FROM Borclar B JOIN Borc_Tipleri BT ON B.Borc_Tip_ID = BT.Tip_ID LEFT JOIN Su_Abonelikler SA ON B.Borclu_Bilgisi = SA.Abone_ID LEFT JOIN Uyeler U ON (B.Borclu_Bilgisi = U.Uye_Sicil_No OR SA.Abone_Sicil_No = U.Uye_Sicil_No) WHERE B.Borc_Durum = 'Odenmedi' AND B.Borc_ID = '$_GET[borc_id]'";
                                    $borc = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

                                    $tutar = Balance((isset($borc)) ? $borc['Borc_Tutari']+$borc['Borc_Ceza']: 0);

                                ?>
                                <div class="mb-3">
                                    <h4 class="text-center"><b><?php echo $word['odeme_bilgileri'];?></b></h4>
                                </div>
								<div class="mb-3">
									<label class="form-label"><?php echo $word['borc_no'];?></label>
									<input class="form-control form-control-lg" type="number" name="borc_id" value="<?php echo $_GET['borc_id'];?>" placeholder="<?php echo $word['borc_no'];?>" <?php if(isset($_GET['borc_id'])){echo "readonly";}?>/>
								</div>
								<div class="mb-3">
									<label class="form-label"><?php echo $word['borc_tutari'];?></label>
									<input class="form-control form-control-lg" type="text" id="mevcut_data" value="₺<?php echo $tutar;?>" placeholder="<?php echo $word['borc_tutari'];?>" disabled/>
								</div>
                                <div class="mb-3">
									<label class="form-label"><?php echo $word['borclu_bilgisi'];?></label>
									<input class="form-control form-control-lg" type="text" id="ad_soyad" value="<?php if(isset($_GET['borc_id'])){echo ($borc['Uye_Sicil_No'] != $uye['Uye_Sicil_No']) ? (MaskedText($borc['Uye_Ad'], 2)." ".MaskedText($borc['Uye_Soyad'], 2)) : ($borc['Uye_Ad']." ".$borc['Uye_Soyad']);}?>" placeholder="<?php echo $word['borclu_bilgisi'];?>" disabled/>
								</div>
                                <div class="mb-3">
									<label class="form-label"><?php echo $word['borc_turu'];?></label>
									<input class="form-control form-control-lg" type="text" id="borc_turu_adi" value="<?php if(isset($_GET['borc_id'])){echo $word[$borc['Tip_Kodu']];}?>" placeholder="<?php echo $word['borc_turu'];?>" disabled/>
								</div>
                                <div class="mb-3 mt-4">
                                    <h4 class="text-center"><b><?php echo $word['kredi_banka_kart_bilgileri'];?></b></h4>
                                </div>
                                <div class="row">
                                <div class="mb-3 col-lg-5 col-sm-12 col-12">
									<label class="form-label"><?php echo $word['kart_sahibi_ad_soyad'];?></label>
									<input class="form-control form-control-lg" type="text" name="kredi_kart_ad_soyad" placeholder="<?php echo $word['kart_sahibi_ad_soyad'];?>"/>
								</div>
                                <div class="mb-3 col-lg-7 col-sm-12 col-12">
									<label class="form-label"><?php echo $word['kart_no'];?></label>
									<input class="form-control form-control-lg" type="number" name="kredi_kart_no" placeholder="<?php echo $word['kart_no'];?>"/>
								</div>
                                <div class="mb-3 col-lg-4 col-sm-4 col-4">
									<label class="form-label"><?php echo $word['son_kullanma_tarihi_ay'];?></label>
									<select class="form-control form-control-lg" name="kredi_kart_ay">
                                        <?php for($i = 1; $i <= 12; $i++){?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php }?>
                                    </select>
								</div>
                                <div class="mb-3 col-lg-4 col-sm-4 col-4">
									<label class="form-label"><?php echo $word['son_kullanma_tarihi_yil'];?></label>
									<select class="form-control form-control-lg" name="kredi_kart_yil">
                                        <?php for($i = date("Y"); $i < (date("Y")+100); $i++){?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php }?>
                                    </select>
								</div>
                                <div class="mb-3 col-lg-4 col-sm-4 col-4">
									<label class="form-label"><?php echo $word['cvv_kodu'];?></label>
									<input class="form-control form-control-lg" type="number" name="kredi_kart_cvv" placeholder="<?php echo $word['cvv_kodu'];?>"/>
								</div>
                                </div>
								<div>
									<div class="form-check align-items-center">
										<input id="customControlInline" type="checkbox" class="form-check-input" value="true" name="sozlesme" checked>
										<label class="form-check-label text-small" for="customControlInline"><?php echo $word['satis_sozlesmesini_okudum'];?></label>
									</div>
								</div>

                                <script>

                                $(document).ready(function(){

                                    $('input[name="borc_id"]').on('input', function() {

                                    var borc_id = $(this).val();

                                    if(borc_id != ""){

                                        $.ajax({
                                            url: 'ajax/debts.php',
                                            type: 'POST',
                                            data: { "borc_sorgula": "true", "borc_id": borc_id },
                                            beforeSend: function() {
                                                $('#mevcut_data').val('<?php echo $word['borc_sorgulaniyor'];?>');
                                                $('#ad_soyad').val('<?php echo $word['borc_sorgulaniyor'];?>');
                                                $('#borc_turu_adi').val('<?php echo $word['borc_sorgulaniyor'];?>');
                                            },
                                            success: function(response) {
                                                try {
                                                    var data = JSON.parse(response);
                                                    if (data && data.tutar) {
                                                        $('#mevcut_data').val(data.tutar);
                                                        $('#ad_soyad').val(data.ad_soyad);
                                                        $('#borc_turu_adi').val(data.borc_turu_adi);
                                                    } else {
                                                        throw new Error('<?php echo $word['borc_alinamadi'];?>');
                                                    }
                                                } catch (error) {
                                                    console.error('JSON parse error:', error);
                                                    $('#mevcut_data').val('<?php echo $word['borc_alinamadi'];?>');
                                                    $('#ad_soyad').val('<?php echo $word['borc_alinamadi'];?>');
                                                    $('#borc_turu_adi').val('<?php echo $word['borc_alinamadi'];?>');
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('AJAX error:', status, error);
                                            }
                                            
                                    });}else{

                                        $('#mevcut_data').val('₺0.00');
                                        $('#ad_soyad').val('');
                                        $('#borc_turu_adi').val('');

                                    }

                                    });

                                });

                                </script>

                                <?php }?>

								<div class="d-grid gap-2 mt-3">
									<button type="button" id="VezneButton" class="btn btn-lg btn-success"><?php echo $word['odeme_yap'];?></button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="text-center mb-3"><img src="img/payment-x.svg" alt="" style="width: 100%;"></div>

			</div>
		</div>

<?php }?>

</div>

</div>

<script>

$(document).ready(function(){

$('#VezneButton').click(function(e){

    e.preventDefault(); // Butona tıklamada normal submit işlemini engeller
    
    DataSendLoad();

    var formData = $('#VezneForm').serialize(); // Form verilerini alır

    $.ajax({
        url: 'ajax/digital-cash-desk.php', // AJAX isteğinin gideceği adres
        type: "POST",
        data: formData,
        success: function (response){

            try {  // Sunucudan dönen veriyi JSON olarak işler

                var data = JSON.parse(response);

                Swal.fire(data.title, data.text, data.status);

                if(data.status == "success"){
                    $('#VezneForm')[0].reset(); // İşlem başarılı olduğunda formu sıfırla
                    $('#mevcut_data').val('<?php echo $word['tutar_guncelleniyor'];?>');
                    setTimeout(function() {
                        var odeme_tipi = $('input[name="odeme_tipi"]').val(); // Ödeme tipi değerini al
                        if(odeme_tipi == "ulasim_karti_bakiye"){
                            $('#mevcut_data').val(data.tutar);
                        }else if(odeme_tipi == "borc_odeme"){
                            $('#mevcut_data').val(data.tutar);
                            $('#ad_soyad').val(data.ad_soyad);
                            $('#borc_turu_adi').val(data.borc_turu_adi);
                        }
                    }, 2000);
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