<div class="container-fluid p-0">

<h1 class="h3 mb-3 text-center"><b><?php echo $word['hizmet_masasi'];?></b></h1>

<div class="row">

<?php if($login){

    $talepID = $_GET['chat_id'];

    if(!isset($talepID)){

?>

<div class="col-lg-6 col-sm-12 col-12">

<div class="card">
    
    <div class="card-body">

<div class="text-center">
    <p class="lead"><?php echo $word['yeni_talep'];?></p>
</div>

        <div class="m-sm-3">
            <form id="HizmetMasasiForm">
                <input type="hidden" name="hizmet_masasi">

                <div class="mb-3">
                    <label class="form-label"><?php echo $word['basvuru_turu'];?></label>
                    <select class="form-control form-control-lg" name="talep_tip_id">
                        <?php
                        $sorgu = "SELECT * FROM Talep_Tipleri WHERE Tip_Durum='True'";
                        $cikti = mysqli_query($mysqli, $sorgu);
                        if (mysqli_num_rows($cikti) > 0) {
                            while($tip = mysqli_fetch_assoc($cikti)) {
                        ?>
                            <option value="<?php echo $tip['Tip_ID']; ?>"><?php echo $tip['Tip_Ad'];?></option>
                        <?php }}?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label"><?php echo $word['mesajiniz']; ?></label>
                    <textarea class="form-control form-control-lg" style="min-height: 200px;" name="talep_mesaj" placeholder="<?php echo $word['mesajiniz']; ?>"></textarea>
                </div>

                <div>
                    <div class="form-check align-items-center">
                        <input id="customControlInline" type="checkbox" class="form-check-input" value="true" name="sozlesme" checked>
                        <label class="form-check-label text-small" for="customControlInline"><?php echo $word['sozlesmeyi_kabul_ediyorum'];?></label>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button type="button" id="HizmetMasasiButton" class="btn btn-lg btn-primary"><?php echo $word['gonder'];?></button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>


<div class="col-lg-6 col-sm-12 col-12">

<div class="card p-3" style="width: 100%;">

<div class="text-center">
    <p class="lead"><?php echo $word['taleplerim'];?></p>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col"><?php echo $word['talep'];?></th>
            <th scope="col"><?php echo $word['zaman'];?></th>
            <th scope="col"><?php echo $word['durum'];?></th>
        </tr>
    </thead>
    <tbody>

    <?php 

    $sorgu = "SELECT * FROM Talepler JOIN Talep_Tipleri ON Talepler.Talep_Kategori_ID = Talep_Tipleri.Tip_ID WHERE Talepler.Talep_Uye_ID='$userID' ORDER BY Talep_ID DESC";
    $talepler = mysqli_query($mysqli, $sorgu);
    while($talep = mysqli_fetch_assoc($talepler)){

        if($talep['Talep_Durum'] == "Incelemede"){
            $renk = "info";
            $text = $word['inceleniyor'];
        }elseif($talep['Talep_Durum'] == "Cozuldu"){
            $renk = "success";
            $text = $word['cozuldu'];
        }elseif($talep['Talep_Durum'] == "Kapatildi"){
            $renk = "danger";
            $text = $word['kapatildi'];
        }else{
            $renk = "warning";
            $text = $word['beklemede'];
        }

    ?>

        <tr>
            <td><a href="index.php?page=service-desk&chat_id=<?php echo $talep['Talep_ID'];?>"><?php echo $talep['Tip_Ad'];?> (#<?php echo $talep['Talep_ID'];?>)</a></td>
            <td><?php echo DateReplace($talep['Talep_Zaman']);?></td>
            <td><span class="badge text-bg-<?php echo $renk;?>"><b><?php echo $text;?></b></span></td>
        </tr>

    <?php }?>

    </tbody>
</table>

</div>

</div>

<script>

$(document).ready(function(){

$('#HizmetMasasiButton').click(function(e){

    e.preventDefault(); // Butona tıklamada normal submit işlemini engeller
    
    DataSendLoad();

    var formData = $('#HizmetMasasiForm').serialize(); // Form verilerini alır

    $.ajax({
        url: 'ajax/service-desk.php', // AJAX isteğinin gideceği adres
        type: "POST",
        data: formData,
        success: function (response){

            try {  // Sunucudan dönen veriyi JSON olarak işler

                var data = JSON.parse(response);

                Swal.fire(data.title, data.text, data.status);

                if(data.status == "success"){
                    $('#HizmetMasasiForm')[0].reset(); // İşlem başarılı olduğunda formu sıfırla
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

<?php }elseif(isset($_GET['chat_id'])){

    $talepID = $_GET['chat_id'];
    
    $sorgu = "SELECT Talep_Tipleri.*, Talepler.*, COUNT(Talepler.Talep_ID) AS say FROM Talepler JOIN Talep_Tipleri ON Talepler.Talep_Kategori_ID = Talep_Tipleri.Tip_ID WHERE Talepler.Talep_ID='$talepID' AND Talepler.Talep_Uye_ID='$userID'";
    $talep = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

    if($talep['say'] > 0){
    
?>

<div class="text-center">
    <p class="lead"><?php echo $talep['Tip_Ad']." (#".$talep['Talep_ID'].")";?></p>
</div>

<?php 

$sorgu = "SELECT * FROM Talepler_Mesajlar JOIN Uyeler ON Talepler_Mesajlar.Gonderen_Uye_ID = Uyeler.Uye_ID WHERE Talepler_Mesajlar.Talep_ID='$talepID' ORDER BY Mesaj_ID DESC";
$mesajlar = mysqli_query($mysqli, $sorgu);
while($mesaj = mysqli_fetch_assoc($mesajlar)){

    $color = ($mesaj['Gonderen_Tipi'] == "Vatandas") ? "primary":"danger";

?>

<div class="col-lg-12 col-sm-12 col-12">
<div class="card p-0">
  <h5 class="card-header bg-<?php echo $color;?> text-white p-3"><b><?php echo $mesaj['Uye_Ad']." ".$mesaj['Uye_Soyad'];?></b> (<?php echo $word[$mesaj['Gonderen_Tipi']];?>)</h5>
  <div class="card-body">
    <p class="card-text"><?php echo $mesaj['Mesaj'];?></p>
  </div>
  <h5 class="card-footer bg-dark-subtle text-end p-2 m-0"><b><?php echo $mesaj['Mesaj_Zaman'];?></b></h5>
</div>
</div>

<?php }}else{?>

<div class="col-lg-12 col-sm-12 col-12">
<div class="alert alert-warning" role="alert">
    <?php echo $word['bu_talebe_erisiminiz_yok'];?><br><br>
    <a onclick="window.history.back();" class="btn btn-lg btn-danger"><?php echo $word['geri_don'];?></a>
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