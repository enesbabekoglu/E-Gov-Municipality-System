<?php

usleep(300000); // 300,000 mikrosaniye (0.3 saniye)

session_start(); // Session bağlantısı başlatılıyor

include "../connect.php";
include "../global-veriables.php";
include "../languages/$language.php";
include "../functions.php";

$login = ($userID != "NULL" && isset($userID)) ? true : false;
$json = array();

if(isset($_POST['changelang'])){

    $lang = htmlspecialchars($_POST['lang']);
    if(in_array($lang, $languages)){
        setcookie("language", $lang, 0, "/");
        $json['status'] = "success";
    }else{
        $json['title'] = $word['hata'];
        $json['text'] = $word['bir_hata_olustu'];
        $json['status'] = "error";
    }

}

if ($login) {

    if (isset($_POST['settings'])) {

        $profil = htmlspecialchars($_POST['profil']);
        $telefon_no = htmlspecialchars($_POST['telefon_no']);

        $password = $_POST['password'];
        $password_check = $_POST['password_check'];

        $guncelleyebilir = true;
        $guncelle = array();

        if (isset($telefon_no) && $telefon_no != $uye['Uye_Tel_No'] && $telefon_no != "") {

            if (strlen($telefon_no) == 10 && $telefon_no[0] == "5" && ctype_digit($telefon_no)) {

                $sorgu = "SELECT Uye_Tel_No FROM Uyeler WHERE Uye_Tel_No='$telefon_no'";
                $uyeSayisi = mysqli_num_rows(mysqli_query($mysqli, $sorgu));

                if($uyeSayisi == 0){

                    $telefon_no = mysqli_real_escape_string($mysqli, $telefon_no);
                    $guncelle[] = "Uye_Tel_No = '$telefon_no'";
                    $guncelleyebilir = true;

                }else{

                    $hataText = $word['bu_telefon_numarasi_kullaniliyor'];
                    $guncelleyebilir = false;

                }

            } else {

                $hataText = $word['gecerli_bir_telefon_giriniz'];
                $guncelleyebilir = false;

            }

        }

        if (isset($profil) && $profil != $uye['Uye_Profil'] && $profil != "" && $guncelleyebilir == true) {

            $profil = mysqli_real_escape_string($mysqli, $profil);
            $guncelle[] = "Uye_Profil = '$profil'";
            $guncelleyebilir = true;

        }

        if (isset($password) && !password_verify($password, $uye['Uye_Sifre']) && isset($password_check) && $password != "" && $password_check != "" && $guncelleyebilir == true) {

            if ($password == $password_check) {

                $yeni_sifre_hash = password_hash($password, PASSWORD_BCRYPT);
                $guncelle[] = "Uye_Sifre = '$yeni_sifre_hash'";
                $guncelleyebilir = true;

            } else {

                $hataText = $word['sifreleriniz_uyusmuyor'];
                $guncelleyebilir = false;

            }

        }

        if (count($guncelle) > 0 && $guncelleyebilir == true) {

            $sorgu = "UPDATE Uyeler SET " . implode(', ', $guncelle) . " WHERE Uye_ID = $userID";

            if (mysqli_query($mysqli, $sorgu)) {

                $json['title'] = $word['basarili'];
                $json['text'] = $word['bilgileriniz_basariyla_guncellendi'];
                $json['status'] = "success";

            } else {

                $json['title'] = $word['hata'];
                $json['text'] = $word['bir_hata_olustu']." (".mysqli_error($mysqli).")";
                $json['status'] = "error";

            }

        } else {

            if(isset($hataText)){

                $json['title'] = $word['hata'];
                $json['text'] = $hataText;
                $json['status'] = "error";

            }else{

                $json['title'] = $word['hata'];
                $json['text'] = $word['degisen_bir_deger_yok'];
                $json['status'] = "warning";

            }

        }

    }

} else {

    $json['title'] = $word['hata'];
    $json['text'] = $word['bir_hata_olustu'];
    $json['status'] = "warning";

}

echo json_encode($json);

?>
