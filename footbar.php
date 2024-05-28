			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-12 text-start">
							<p class="mb-0">
								<a class="text-muted" href="https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi" target="_blank"><strong>Proje Github Adresi</strong></a> - &copy; <a class="text-muted" href="https://enesbabekoglu.com.tr" target="_blank"><strong>Enes Babekoğlu</strong></a>
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

<div class="modal fade" id="languagesModal" tabindex="-1" aria-labelledby="languagesModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="languagesModalLabel"><?php echo $word['dil_seciniz'];?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo $word['kapat'];?>"></button>
      </div>
      <div class="modal-body d-flex justify-content-center align-items-center">
        <?php foreach($languages AS $lang){?>
			<img src="img/<?php echo $lang;?>.png" style="width: 55px; height: 55px;" role="button" class="m-2" onclick="DilDegistir('<?php echo $lang;?>');" alt="">
		<?php }?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $word['kapat'];?></button>
      </div>
    </div>
  </div>
</div>