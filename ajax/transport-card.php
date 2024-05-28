<?php 

usleep(300000); // 300,000 mikrosaniye (0.3 saniye)

session_start(); // Session bağlantısı başlatılıyor

include "../connect.php";
include "../global-veriables.php";
include "../languages/$language.php";
include "../functions.php";

$login = ($userID != "NULL" && isset($userID)) ? true : false;

if(isset($_POST['bakiye_sorgula']) && $_POST['bakiye_sorgula'] == "true" && isset($_POST['ulasim_kart_no'])){

    $kartNo = htmlspecialchars($_POST['ulasim_kart_no']);

    $sorgu = "SELECT Kart_Bakiye FROM Ulasim_Kartlar WHERE Kart_No='$kartNo'";
    $kart = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));
    $bakiye = isset($kart) ? "₺".Balance($kart['Kart_Bakiye']): $word['kart_bulunamadi'];

    $json['tutar'] = $bakiye;

}

if(isset($_POST['kart_olustur']) && $_POST['kart_olustur'] == true && isset($_POST['kart_tipi'])){

    if($login){

        $kartTipID = htmlspecialchars($_POST['kart_tipi']);

        $sorgu = "SELECT Count(*) AS say FROM Ulasim_Kartlar WHERE Kart_Tip_ID='$kartTipID' AND Kart_Uye_ID='$userID'";
        $kart = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));
    
        if($kart['say'] == 0 && $kartTipID >= 1 && $kartTipID <= 4){
        
        if($kartTipID == 3 && DateMinus(65*365*24*60*60) < $uye['Uye_Dogum_Tarihi']){ // Yaşlı Kart ama henüz 65 yaş üstünde değilse
            $olusturabilir = false;
            $mesaj = $word['bu_islem_icin_65_yasinda_olmalisiniz'];
        }elseif($kartTipID == 2 && $uye['Uye_Ogrencilik'] == "False"){
            $olusturabilir = false;
            $mesaj = $word['bu_islem_icin_ogrenci_olmalisiniz'];
        }elseif($kartTipID == 4 && $uye['Uye_Engel'] == "False"){
            $olusturabilir = false;
            $mesaj = $word['bu_islem_icin_engelli_olmalisiniz'];
        }else{
            $olusturabilir = true;
        }
        }else{
        $olusturabilir = false;
        $mesaj = $word['bu_karta_sahipsiniz'];
        }

        if($olusturabilir){

            $kartNo = mt_rand(1000000000000000, 9999999999999999);

            $query = "INSERT INTO Ulasim_Kartlar (Kart_Tip_ID, Kart_No, Kart_Bakiye, Kart_Uye_ID, Kart_Vize_Bitis, Kart_Durum) VALUES ($kartTipID, '$kartNo', '0', '$userID', NULL, 'True')";
            
            if(mysqli_query($mysqli, $query)){

                $json['title'] = $word['basarili'];
                $json['text'] = $word['kart_basarili_bir_sekilde_olusturuldu'];
                $json['status'] = "success";

            }else{

                $json['title'] = $word['hata'];
                $json['text'] = $word['bir_hata_olustu'];
                $json['status'] = "error";

            }
                
        }else{
            $json['title'] = $word['hata'];
            $json['text'] = $mesaj;
            $json['status'] = "warning";
        }

    }else{

        $json['title'] = $word['hata'];
        $json['text'] = $word['bu_modul_icin_giris_yapilmalidir'];
        $json['status'] = "warning";

    }

}

if(isset($_POST['binis_yap']) && $_POST['binis_yap'] == "true" && isset($_POST['hat']) && isset($_POST['kart'])){

    if($login){

        $hatID = htmlspecialchars($_POST['hat']);
        $kartID = htmlspecialchars($_POST['kart']);

        $gerekenler = "Ulasim_Kartlar.*, Ulasim_Kart_Tipleri.Tip_Kodu";
        $sorgu = "SELECT $gerekenler FROM Ulasim_Kartlar JOIN Ulasim_Kart_Tipleri ON Ulasim_Kartlar.Kart_Tip_ID = Ulasim_Kart_Tipleri.Kart_Tip_ID WHERE Ulasim_Kartlar.Kart_Durum='True' AND Ulasim_Kartlar.Kart_Uye_ID='$userID' AND Ulasim_Kartlar.Kart_ID='$kartID'";
        $kart = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));
        
        $sorgu = "SELECT * FROM Ulasim_Hatlar INNER JOIN Ulasim_Hat_Tipleri WHERE Ulasim_Hatlar.Hat_Durum='True' AND Ulasim_Hat_Tipleri.Hat_Tip_Durum='True' AND Ulasim_Hatlar.Hat_Tip_ID=Ulasim_Hat_Tipleri.Hat_Tip_ID AND Ulasim_Hatlar.Hat_ID='$hatID'";
        $hat = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

        $sorgu = "SELECT * FROM Ulasim_Tarifeler WHERE Tarife_ID='$hat[Hat_Tarife_ID]' AND Tarife_Durum='True'";
        $tarife = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

        if(isset($kart) && isset($hat)){

            $ucret = $tarife['Ucret_'.$kart['Tip_Kodu']];

            if($kart['Kart_Bakiye'] >= $ucret){


                mysqli_autocommit($mysqli, FALSE); // Otomatik işlem tamamlama modunu devre dışı bırakıyoruz
        
                // Toplu işlemler veritabanına kaydedilirken hatalar oluşabilir bunların önüne geçmek için transaction kullanıyoruz
        
                try {
        
                    mysqli_begin_transaction($mysqli); // İşlemi başlatıyoruz
        
                        $query = "UPDATE Ulasim_Kartlar SET Kart_Bakiye=Kart_Bakiye-$ucret WHERE Kart_ID='$kartID' AND Kart_Durum='True'";
        
                        if(mysqli_query($mysqli, $query)){
        
                            $query = "INSERT INTO Ulasim_Kart_Islemler (Islem_Tip, Islem_Yeri, Islem_Kart_ID, Islem_Tutar, Islem_Zaman) VALUES ('Binis', '$hat[Hat_Adi]', '$kartID', '$ucret', '$time')";
            
                            if(mysqli_query($mysqli, $query)){
        
                                $yeniBakiye = $kart['Kart_Bakiye']-$ucret;
        
                                $json['status'] = "odeme_yapildi";
                                $json['kesilen'] = Balance($ucret);
                                $json['bakiye'] = Balance($yeniBakiye);
        
                                mysqli_commit($mysqli); // Tüm sorgular başarılı olduysa işlemi tamamlıyoruz
        
                            }else{
        
                                throw new Exception(mysqli_error($mysqli));
        
                            }
        
                        }else{
        
                            throw new Exception(mysqli_error($mysqli));
        
                        }
        
                } catch(Exception $e){
        
                    mysqli_rollback($mysqli); // Hata oluştu tüm sorguları geri alıyoruz
        
                    $json['title'] = $word['hata'];
                    $json['text'] = $word['bir_hata_olustu']." (".$e->getMessage().")";
                    $json['status'] = "error";
        
                }
        
                mysqli_autocommit($mysqli, TRUE); // Otomatik işlem tamamlama modunu tekrar aktifleştiriyoruz
        
            }else{
        
                $json['status'] = "yetersiz_bakiye";
                $json['bakiye'] = Balance($kart['Kart_Bakiye']);

            }
            
        }else{

            $json['status'] = "hata_olustu";

        }

    }else{

        $json['title'] = $word['hata'];
        $json['text'] = $word['bu_modul_icin_giris_yapilmalidir'];
        $json['status'] = "warning";

    }

}

echo json_encode($json);

?>