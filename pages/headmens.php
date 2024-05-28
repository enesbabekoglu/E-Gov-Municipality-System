<div class="container-fluid p-0">
    <h1 class="h3 mb-3 text-center"><b><?php echo $word['muhtarliklar'];?></b></h1>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th class="d-xl-table-cell"><?php echo $word['mahalle'];?></th>
                            <th class="d-none d-xl-table-cell"><?php echo $word['nufus'];?></th>
                            <th class="d-xl-table-cell"><?php echo $word['muhtar'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $toplamNufus = 0;
                            $sorgu = "SELECT Mahalle_Ad, Mahalle_Muhtar, Mahalle_Muhtar_Tel, Mahalle_Nufus FROM Mahalle ORDER BY Mahalle_Nufus DESC";
                            $muhtarliklar = mysqli_query($mysqli, $sorgu);
                            $i = 1;
                            while($muhtarlik = mysqli_fetch_assoc($muhtarliklar)){
                                $toplamNufus += $muhtarlik['Mahalle_Nufus'];
                        ?>
                        <tr>
                            <td class="d-xl-table-cell"><?php echo $muhtarlik['Mahalle_Ad'];?></td>
                            <td class="d-none d-md-table-cell"><?php echo Number($muhtarlik['Mahalle_Nufus']);?></td>
                            <td class="d-xl-table-cell">
                                <?php echo $muhtarlik['Mahalle_Muhtar'];?><br>
                                <a href="tel://<?php echo $muhtarlik['Mahalle_Muhtar_Tel'];?>" class="btn btn-primary mt-1">
                                    <i class="align-middle" data-feather="phone-call"></i> <?php echo $muhtarlik['Mahalle_Muhtar_Tel'];?>
                                </a>
                            </td>
                        </tr>
                        <?php $i++;}?>
                        <tr>
                            <td colspan="4" class="text-center"><b><?php echo $word['toplam_nufus'].": ".$toplamNufus;?></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
