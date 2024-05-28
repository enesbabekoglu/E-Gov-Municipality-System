<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
                        <?php if($login){?>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                <img src="<?php echo isset($uye['Uye_Profil']) ? $uye['Uye_Profil'] : "img/personel/Null.webp";?>" class="avatar img-fluid rounded me-1" alt="<?php echo $uye['Uye_Ad']." ".$uye['Uye_Soyad'];?>" /> <span class="text-dark"><?php echo $uye['Uye_Ad']." ".$uye['Uye_Soyad'];?></span>
              </a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#languagesModal"><img class="align-middle" src="img/<?php echo $language;?>.png" style="width: 22px; height: 22px;"> <?php echo $word[$language];?></a>
								<a class="dropdown-item" href="index.php?page=settings"><i class="align-middle me-1" data-feather="settings"></i> <?php echo $word['ayarlar'];?></a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="index.php?page=logout"><?php echo $word['cikis_yap'];?></a>
							</div>
						</li>
                        <?php }?>
					</ul>
				</div>
			</nav>

            <main class="content">