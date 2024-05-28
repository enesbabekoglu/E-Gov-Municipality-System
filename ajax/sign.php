<?php 

usleep(300000); // 300,000 mikrosaniye (0.3 saniye)

session_start(); // Session bağlantısı başlatılıyor

include "../connect.php";
include "../global-veriables.php";
include "../languages/$language.php";
include "../functions.php";

$login = ($userID != "NULL" && isset($userID)) ? true : false;

if(!$login){

    if(isset($_POST['register'])){

        $ad = htmlspecialchars($_POST['ad']);
        $soyad = htmlspecialchars($_POST['soyad']);
        $tck_no = htmlspecialchars($_POST['tck_no']);
        $telefon_no = htmlspecialchars($_POST['telefon_no']);
        $dogum_tarihi = htmlspecialchars($_POST['dogum_tarihi']);
        $cinsiyet = htmlspecialchars($_POST['cinsiyet']);
        $sozlesme = isset($_POST['sozlesme']) ? $_POST['sozlesme'] : false;

        $password = $_POST['password'];
        $password_check = $_POST['password_check'];

        if($sozlesme){

            if($password == $password_check){

                $control = array($ad, $soyad, $tck_no, $telefon_no, $dogum_tarihi, $cinsiyet);
                $bos = false;

                foreach ($control as $x){if(empty($x)){$bos = true; break;}}

                if(!$bos){

                    if((string) strlen($tck_no) == 11){ // TC Kimlik No 11 karakter olmalı

                        if((string) strlen($telefon_no) == 10 && $telefon_no[0] == "5"){ // Telefon 10 karakter olmalı ve 5 ile başlamalı

                            $onSekizYilOnce = DateMinus(18*365*24*60*60);

                            if($dogum_tarihi <= $onSekizYilOnce){

                                $sorgu = "SELECT Uye_TCK_No, Uye_Tel_No FROM Uyeler WHERE Uye_TCK_No='$tck_no' OR Uye_Tel_No='$telefon_no'";
                                $uyeSayisi = mysqli_num_rows(mysqli_query($mysqli, $sorgu));

                                if($uyeSayisi == 0){

                                    while(true){

                                        $sicilNo = time();

                                        $sorgu = "SELECT Uye_Sicil_No FROM Uyeler WHERE Uye_Sicil_No='$sicilNo'";
                                        $sicilKontrol = mysqli_num_rows(mysqli_query($mysqli, $sorgu));

                                        if($sicilKontrol == 0){break;}

                                    }

                                    $hashPass = password_hash($password, PASSWORD_BCRYPT);

                                    $query = "INSERT INTO Uyeler (Uye_Ad, Uye_Soyad, Uye_TCK_No, Uye_Sicil_No, Uye_Tel_No, Uye_Dogum_Tarihi, Uye_Cinsiyet, Uye_Sifre, Uye_Profil, Uye_Ogrencilik, Uye_Engel, Uye_Emekli, Uye_Kayit_Tarihi) VALUES ('$ad', '$soyad', '$tck_no', '$sicilNo', '$telefon_no', '$dogum_tarihi', '$cinsiyet', '$hashPass', NULL, 'False', 'False', 'False', '$time')";
                                    
                                    if(mysqli_query($mysqli, $query)){

                                        $json['title'] = $word['basarili'];
                                        $json['text'] = $word['kayit_basarili'];
                                        $json['status'] = "success";

                                    }else{

                                        $json['title'] = $word['hata'];
                                        $json['text'] = $word['bir_hata_olustu']." (".mysqli_error($mysqli).")";
                                        $json['status'] = "error";

                                    }

                                }else{

                                    $json['title'] = $word['hata'];
                                    $json['text'] = $word['bu_bilgiler_zaten_kullaniliyor'];
                                    $json['status'] = "warning";
        
                                }

                            }else{

                                $json['title'] = $word['hata'];
                                $json['text'] = $word['onsekiz_yasinda_olmalisiniz'];
                                $json['status'] = "warning";

                            }

                        }else{

                            $json['title'] = $word['hata'];
                            $json['text'] = $word['gecersiz_telefon_no'];
                            $json['status'] = "warning";

                        }

                    }else{

                        $json['title'] = $word['hata'];
                        $json['text'] = $word['gecersiz_tc_kimlik_no'];
                        $json['status'] = "warning";

                    }

                }else{

                    $json['title'] = $word['eksik_bilgi'];
                    $json['text'] = $word['hicbir_alani_bos_birakmayiniz'];
                    $json['status'] = "warning";

                }

            }else{

                $json['title'] = $word['hata'];
                $json['text'] = $word['sifreler_uyusmuyor'];
                $json['status'] = "warning";

            }

        }else{

            $json['title'] = $word['eksik_bilgi'];
            $json['text'] = $word['kayit_sozlesmesini_kabul_etmelisiniz'];
            $json['status'] = "warning";

        }

    }

    if(isset($_POST['login'])){

        $user = htmlspecialchars($_POST['user']);
        $password = $_POST['password'];
        $hatirla = isset($_POST['hatirla']) ? $_POST['hatirla'] : false;

        if(!empty($user) && !empty($password)){

            $sorgu = "SELECT Uye_ID, Uye_TCK_No, Uye_Sicil_No, Uye_Tel_No, Uye_Sifre FROM Uyeler WHERE Uye_TCK_No='$user' OR Uye_Sicil_No='$user' OR Uye_Tel_No='$user'";
            $sonuclar = mysqli_query($mysqli, $sorgu);
                            
            if(mysqli_num_rows($sonuclar) == 1) {

                $uye = mysqli_fetch_assoc($sonuclar);

                if(password_verify($password, $uye['Uye_Sifre'])){

                    $_SESSION['user_id'] = $uye['Uye_ID'];

                    if($hatirla){

                        setcookie("User", CookieEncode($user), time() + (365 * 24 * 60 * 60), "/");
                        setcookie("Password", CookieEncode($password), time() + (365 * 24 * 60 * 60), "/");
                        setcookie("Remember", $hatirla, time() + (365 * 24 * 60 * 60), "/");

                    }else{

                        setcookie("User", "", time() - 60, "/");
                        setcookie("Password", "", time() - 60, "/");
                        setcookie("Remember", "", time() - 60, "/");  

                    }

                    $json['title'] = $word['basarili'];
                    $json['text'] = $word['uye_girisi_basarili'];
                    $json['status'] = "success";

                }else{

                    $json['title'] = $word['hata'];
                    $json['text'] = $word['bilgilerinizi_yanlis_girdiniz'];
                    $json['status'] = "warning";

                }

            }else{

                $json['title'] = $word['hata'];
                $json['text'] = $word['uye_bulunamadi'];
                $json['status'] = "warning";

            }

        }else{

            $json['title'] = $word['eksik_bilgi'];
            $json['text'] = $word['hicbir_alani_bos_birakmayiniz'];
            $json['status'] = "warning";

        }

    }

}else{

    $json['title'] = $word['hata'];
    $json['text'] = $word['bir_hata_olustu'];
    $json['status'] = "warning";

}

echo json_encode($json);

?>