<div class="wrapper">

    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">

            <a class="sidebar-brand text-center" href="index.php">
                <img src="<?php echo $belediye['Belediye_Logo_2'];?>" class="mb-2 rounded-4" alt="<?php echo $belediye['Belediye_Ad'];?> Logo" width="50%"><br>
                <span class="align-middle"><?php echo $word['e_belediye'];?></span>
            </a>

			<ul class="sidebar-nav">
				
                <li class="sidebar-header"><?php echo $word['uyeliksiz_islemler'];?></li>

				<li class="sidebar-item<?php echo (in_array($page, array("", "intern-apply")) ? " active" : "");?>">
                    <a class="sidebar-link" href="index.php"><i class="align-middle" data-feather="home"></i> <span class="align-middle"><?php echo $word['anasayfa'];?></span></a>
				</li>

                <?php 

                $sorgu = "SELECT Modul_Kodu, Modul_Url, Modul_Tipi, Modul_Icon FROM Moduller WHERE Modul_Uyelik='False' AND Modul_Menu='True' AND Modul_Durumu='True' ORDER BY Modul_Oncelik DESC";
                $moduller = mysqli_query($mysqli, $sorgu);
                while($modul = mysqli_fetch_assoc($moduller)){

                    $modulURL = ($modul['Modul_Tipi'] == "3rd") ? ("target='_blank' href='".$modul['Modul_Url']."'") : ("href='index.php?page=".$modul['Modul_Url']."'");

                ?>

                <li class="sidebar-item<?php echo (in_array($page, array($modul['Modul_Url'])) ? " active" : "");?>">
					<a class="sidebar-link" <?php echo $modulURL;?>><i class="align-middle" data-feather="<?php echo $modul['Modul_Icon'];?>"></i> <span class="align-middle"><?php echo $word[$modul['Modul_Kodu']];?></span></a>
				</li>

                <?php }?>

                <?php if($login){?>

                <li class="sidebar-header"><?php echo $word['ozel_islemler'];?></li>

                <?php 

                $sorgu = "SELECT Modul_Kodu, Modul_Url, Modul_Tipi, Modul_Icon FROM Moduller WHERE Modul_Uyelik='True' AND Modul_Menu='True' AND Modul_Durumu='True' ORDER BY Modul_Oncelik DESC";
                $moduller = mysqli_query($mysqli, $sorgu);
                while($modul = mysqli_fetch_assoc($moduller)){

                    $modulURL = ($modul['Modul_Tipi'] == "3rd") ? ("target='_blank' href='".$modul['Modul_Url']."'") : ("href='index.php?page=".$modul['Modul_Url']."'");

                ?>

                <li class="sidebar-item<?php echo (in_array($page, array($modul['Modul_Url'])) ? " active" : "");?>">
					<a class="sidebar-link" <?php echo $modulURL;?>><i class="align-middle" data-feather="<?php echo $modul['Modul_Icon'];?>"></i> <span class="align-middle"><?php echo $word[$modul['Modul_Kodu']];?></span></a>
				</li>

                <?php }?>

                <li class="sidebar-item<?php echo (in_array($page, array("logout")) ? " active" : "");?>">
					<a class="sidebar-link" href="index.php?page=logout"><i class="align-middle" data-feather="log-out"></i> <span class="align-middle"><?php echo $word['cikis_yap'];?></span></a>
				</li>

                <?php }else{?>

                <li class="sidebar-header"><?php echo $word['uyelik'];?></li>

				<li class="sidebar-item<?php echo (in_array($page, array("login")) ? " active" : "");?>">
					<a class="sidebar-link" href="index.php?page=login"><i class="align-middle" data-feather="log-in"></i> <span class="align-middle"><?php echo $word['giris_yap'];?></span></a>
				</li>

                <li class="sidebar-item<?php echo (in_array($page, array("register")) ? " active" : "");?>">
					<a class="sidebar-link" href="index.php?page=register"><i class="align-middle" data-feather="user-plus"></i> <span class="align-middle"><?php echo $word['kayit_ol'];?></span></a>
				</li>

                <?php }?>

			</ul>

				<div class="sidebar-cta">
					<div class="sidebar-cta-content">
						<strong class="d-inline-block mb-2"><i class="align-middle" data-feather="headphones"></i> <?php echo $word['belediye_iletisim'];?></strong>
						<div class="mb-3 text-sm"><?php echo $word['belediye_iletisim_aciklama'];?></div>
						<div class="d-grid">
							<a href="tel://<?php echo $belediye['Belediye_Telefon'];?>" class="btn btn-success"><i class="align-middle" data-feather="phone-call"></i> <?php echo $belediye['Belediye_Telefon'];?></a>
						</div>
					</div>
				</div>

		</div>
	</nav>

    <div class="main">
