<div class="container d-flex flex-column">

    <div class="row vh-70">
         <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
			<div class="d-table-cell align-middle">

				<div class="text-center mt-4">
                    <h1 class="h2"><img src="<?php echo $belediye['Belediye_Logo'];?>" alt="<?php echo $belediye['Belediye_Ad'];?> Logo" class="mb-3" width="250"></h1>
					<p class="lead"><?php echo $word['e_belediye']." ".$word['giris_yap'];?></p>
                </div>

				<div class="card">
					<div class="card-body">
						<div class="m-sm-3">
							<form id="LoginForm">
                                <input type="hidden" name="login">
								<div class="mb-3">
									<label class="form-label"><?php echo $word['tck_no']."/".$word['sicil_no']."/".$word['telefon_no'];?></label>
									<input class="form-control form-control-lg" type="number" name="user" value="<?php echo CookieDecode($_COOKIE['User']);?>" placeholder="<?php echo $word['tck_no']."/".$word['sicil_no']."/".$word['telefon_no'];?>" />
								</div>
								<div class="mb-3">
									<label class="form-label"><?php echo $word['sifre'];?></label>
									<input class="form-control form-control-lg" type="password" name="password" value="<?php echo CookieDecode($_COOKIE['Password']);?>" placeholder="<?php echo $word['sifre'];?>" />
								</div>
								<div>
									<div class="form-check align-items-center">
										<input id="customControlInline" type="checkbox" class="form-check-input" value="true" name="hatirla" <?php if($_COOKIE['Remember']){echo "checked";}?>>
										<label class="form-check-label text-small" for="customControlInline"><?php echo $word['beni_hatirla'];?></label>
									</div>
								</div>
								<div class="d-grid gap-2 mt-3">
									<button type="button" id="LoginFormButton" class="btn btn-lg btn-primary"><?php echo $word['giris'];?></button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="text-center mb-3"><?php echo $word['hesabiniz_yok_mu'];?> <a href="index.php?page=register"><?php echo $word['kayit_ol'];?></a></div>

			</div>
		</div>
    </div>
                    
</div>

<script>
    
    $(document).ready(function(){

        $('#LoginFormButton').click(function(e){

            e.preventDefault(); // Butona tıklamada normal submit işlemini engeller
            
            DataSendLoad();

            var formData = $('#LoginForm').serialize(); // Form verilerini alır

            $.ajax({
                url: 'ajax/sign.php', // AJAX isteğinin gideceği adres
                type: "POST",
                data: formData,
                success: function (response){

                    try {  // Sunucudan dönen veriyi JSON olarak işler

                        var data = JSON.parse(response);

                        Swal.fire(data.title, data.text, data.status);

                        if(data.status == "success"){
                            $('#LoginForm')[0].reset(); // İşlem başarılı olduğunda formu sıfırla
                            setTimeout(function() {location.href = new URLSearchParams(window.location.search).has('ref') ? 'index.php?page=' + new URLSearchParams(window.location.search).get('ref') : "index.php";}, 2000);
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