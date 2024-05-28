<div class="container d-flex flex-column">
    <div class="row vh-70">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">
                <div class="text-center mt-4">
                    <h1 class="h2"><img src="<?php echo $belediye['Belediye_Logo'];?>" alt="<?php echo $belediye['Belediye_Ad'];?> Logo" class="mb-3" width="250"></h1>
                    <p class="lead"><?php echo $word['e_belediye']." ".$word['kayit_ol'];?></p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="m-sm-3">
                            <form id="RegisterForm">
                                <input type="hidden" name="register">
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['ad'];?></label>
                                    <input class="form-control form-control-lg" type="text" name="ad" placeholder="<?php echo $word['ad'];?>" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['soyad'];?></label>
                                    <input class="form-control form-control-lg" type="text" name="soyad" placeholder="<?php echo $word['soyad'];?>" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['tck_no'];?></label>
                                    <input class="form-control form-control-lg" type="number" name="tck_no" placeholder="<?php echo $word['tck_no'];?>" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['telefon_no'];?></label>
                                    <input class="form-control form-control-lg" type="number" name="telefon_no" placeholder="5XXXXXXXXX" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['dogum_tarihi'];?></label>
                                    <input class="form-control form-control-lg" type="date" name="dogum_tarihi" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['cinsiyet'];?></label><br>
                                    <input id="erkek" type="radio" class="form-check-input" value="E" name="cinsiyet">
                                    <label class="form-check-label text-small" for="erkek"><?php echo $word['erkek'];?></label> &nbsp; 
                                    <input id="kadin" type="radio" class="form-check-input" value="K" name="cinsiyet">
                                    <label class="form-check-label text-small" for="kadin"><?php echo $word['kadin'];?></label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['sifre'];?></label>
                                    <input class="form-control form-control-lg" type="password" name="password" placeholder="<?php echo $word['sifre'];?>" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $word['sifre_dogrula'];?></label>
                                    <input class="form-control form-control-lg" type="password" name="password_check" placeholder="<?php echo $word['sifre'];?>" />
                                </div>
                                <div>
                                    <div class="form-check align-items-center">
                                        <input id="customControlInline" type="checkbox" class="form-check-input" value="true" name="sozlesme">
                                        <label class="form-check-label text-small" for="customControlInline"><?php echo $word['kayit_sozlesmesini_kabul_ediyorum'];?></label>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                    <button type="button" id="RegisterFormButton" class="btn btn-lg btn-primary"><?php echo $word['hesap_olustur'];?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="text-center mb-3"><?php echo $word['hesabiniz_var_mi'];?> <a href="index.php?page=login"><?php echo $word['giris_yap'];?></a></div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){

        $('#RegisterFormButton').click(function(e){

            e.preventDefault(); // Butona tıklamada normal submit işlemini engeller
            
            DataSendLoad();

            var formData = $('#RegisterForm').serialize(); // Form verilerini alır

            $.ajax({
                url: 'ajax/sign.php', // AJAX isteğinin gideceği adres
                type: "POST",
                data: formData,
                success: function (response){

                    try {  // Sunucudan dönen veriyi JSON olarak işler

                        var data = JSON.parse(response);

                        Swal.fire(data.title, data.text, data.status);

                        if(data.status == "success"){
                            $('#RegisterForm')[0].reset(); // İşlem başarılı olduğunda formu sıfırla
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