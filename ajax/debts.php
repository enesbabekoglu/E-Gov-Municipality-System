<?php 

usleep(300000); // 300,000 mikrosaniye (0.3 saniye)

session_start(); // Session bağlantısı başlatılıyor

include "../connect.php";
include "../global-veriables.php";
include "../languages/$language.php";
include "../functions.php";

if(isset($_POST['borc_sorgula']) && $_POST['borc_sorgula'] == "true" && isset($_POST['borc_id'])){

    $borc_id = htmlspecialchars($_POST['borc_id']);

    $sorgu = "SELECT * FROM Borclar B JOIN Borc_Tipleri BT ON B.Borc_Tip_ID = BT.Tip_ID LEFT JOIN Su_Abonelikler SA ON B.Borclu_Bilgisi = SA.Abone_ID LEFT JOIN Uyeler U ON (B.Borclu_Bilgisi = U.Uye_Sicil_No OR SA.Abone_Sicil_No = U.Uye_Sicil_No) WHERE B.Borc_Durum = 'Odenmedi' AND B.Borc_ID = '$borc_id'";
    $borc = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

    if(isset($borc)){
        $tutar = "₺".Balance($borc['Borc_Tutari']+$borc['Borc_Ceza']);
        $json['borc_turu_adi'] = $word[$borc['Tip_Kodu']];
        $json['tutar'] = $tutar;
    
        if($borc['Uye_Sicil_No'] == $uye['Uye_Sicil_No']){
            $json['ad_soyad'] = $borc['Uye_Ad']." ".$borc['Uye_Soyad'];
        }else{
            $json['ad_soyad'] = MaskedText($borc['Uye_Ad'], 2)." ".MaskedText($borc['Uye_Soyad'], 2);
        }
    }else{
        $tutar = $word['borc_bulunamadi'];
        $json['borc_turu_adi'] = "";
        $json['tutar'] = $tutar;
        $json['ad_soyad'] = "";
    }
}

echo json_encode($json);

?>