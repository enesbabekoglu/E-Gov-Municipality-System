<?php if($login){?>
    
    <div class="container d-flex flex-column">
    
    <div class="row vh-70">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">
                <div class="text-center mt-4">
                    <h1 class="h2"><?php echo $word['ayarlar'];?></h1>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="m-sm-3">
                            <form id="SettingsForm">
                                <input type="hidden" name="settings">
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['ad'];?></label>
                                    <input class="form-control form-control-lg" type="text" value="<?php echo $uye['Uye_Ad'];?>" disabled placeholder="<?php echo $word['ad'];?>" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['soyad'];?></label>
                                    <input class="form-control form-control-lg" type="text" value="<?php echo $uye['Uye_Soyad'];?>" disabled placeholder="<?php echo $word['soyad'];?>" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['profil_fotografi'];?></label>
                                    <input class="form-control form-control-lg" type="url"  value="<?php echo $uye['Uye_Profil'];?>" name="profil" placeholder=""<?php echo $word['profil_fotografi'];?>" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['tck_no'];?></label>
                                    <input class="form-control form-control-lg" type="number"  value="<?php echo $uye['Uye_TCK_No'];?>" disabled placeholder="<?php echo $word['tck_no'];?>" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['sicil_no'];?></label>
                                    <input class="form-control form-control-lg" type="number"  value="<?php echo $uye['Uye_Sicil_No'];?>" disabled placeholder="<?php echo $word['sicil_no'];?>" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['telefon_no'];?></label>
                                    <input class="form-control form-control-lg" type="number"  value="<?php echo $uye['Uye_Tel_No'];?>" name="telefon_no" placeholder="5XXXXXXXXX" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['dogum_tarihi'];?></label>
                                    <input class="form-control form-control-lg" type="date" value="<?php echo $uye['Uye_Dogum_Tarihi'];?>" disabled />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['cinsiyet'];?></label><br>
                                    <input id="erkek" type="radio" class="form-check-input" value="E" disabled <?php echo ($uye['Uye_Cinsiyet'] == "E") ? "checked": "";?>>
                                    <label class="form-check-label text-small" for="erkek"><?php echo $word['erkek'];?></label> &nbsp; 
                                    <input id="kadin" type="radio" class="form-check-input" value="K" disabled <?php echo ($uye['Uye_Cinsiyet'] == "K") ? "checked": "";?>>
                                    <label class="form-check-label text-small" for="kadin"><?php echo $word['kadin'];?></label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['yeni_sifre'];?></label>
                                    <input class="form-control form-control-lg" type="password" name="password" placeholder="<?php echo $word['yeni_sifre'];?>" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['yeni_sifre_dogrula'];?></label>
                                    <input class="form-control form-control-lg" type="password" name="password_check" placeholder="<?php echo $word['yeni_sifre_dogrula'];?>" />
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                    <button type="button" id="SettingsFormButton" class="btn btn-lg btn-success"><?php echo $word['degisiklikleri_kaydet'];?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){

        $('#SettingsFormButton').click(function(e){

            e.preventDefault(); // Butona tıklamada normal submit işlemini engeller
            
            DataSendLoad();

            var formData = $('#SettingsForm').serialize(); // Form verilerini alır

            $.ajax({
                url: 'ajax/settings.php', // AJAX isteğinin gideceği adres
                type: "POST",
                data: formData,
                success: function (response){

                    try {  // Sunucudan dönen veriyi JSON olarak işler

                        var data = JSON.parse(response);

                        Swal.fire(data.title, data.text, data.status);

                        if(data.status == "success"){
                            
                            setTimeout(function() {window.location.reload();}, 3000);
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

<div class="container-fluid p-0">
<div class="row">
<div class="col-lg-12 col-sm-12 col-12">
<div class="alert alert-warning" role="alert">
    <?php echo $word['bu_modul_icin_giris_yapilmalidir'];?><br><br>
    <a href="index.php?page=login&ref=<?php echo $_GET['page'];?>" class="btn btn-lg btn-danger"><?php echo $word['giris_yap'];?></a>
</div>
</div>
</div>
</div>

<?php }?>