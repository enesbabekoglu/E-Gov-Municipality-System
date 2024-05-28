<?php 

usleep(300000); // 300,000 mikrosaniye (0.3 saniye)

session_start(); // Session bağlantısı başlatılıyor

include "../connect.php";
include "../global-veriables.php";
include "../languages/$language.php";
include "../functions.php";

if(isset($_POST['vezne'])){

    $type = htmlspecialchars($_POST['odeme_tipi']);

    $sorgu = "SELECT Modul_Uyelik FROM Moduller WHERE Modul_Sayfa='digital-cash-desk' AND Modul_Kodu='$type' AND Modul_Durumu='True'";
    $modul = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

    if(isset($modul)){

        $sozlesme = isset($_POST['sozlesme']) ? $_POST['sozlesme'] : false;

        if($sozlesme){

            $kredi_kart_ad_soyad = htmlspecialchars($_POST['kredi_kart_ad_soyad']);
            $kredi_kart_no = htmlspecialchars($_POST['kredi_kart_no']);
            $kredi_kart_ay = htmlspecialchars($_POST['kredi_kart_ay']);
            $kredi_kart_yil = htmlspecialchars($_POST['kredi_kart_yil']);
            $kredi_kart_cvv = htmlspecialchars($_POST['kredi_kart_cvv']);

            $control = array($kredi_kart_ad_soyad, $kredi_kart_no, $kredi_kart_ay, $kredi_kart_yil, $kredi_kart_cvv);
            $bos = false;

            foreach ($control as $x){if(empty($x)){$bos = true; break;}}

            if(!$bos){

                if(strlen($kredi_kart_no) == 16){

                    if(strlen($kredi_kart_cvv) == 3 || strlen($kredi_kart_cvv) == 4){

                        if($kredi_kart_ay <= 12 && $kredi_kart_ay >= 1 && $kredi_kart_yil >= date("Y")){

                            if(($kredi_kart_ay >= date("m") && $kredi_kart_yil == date("Y")) || ($kredi_kart_yil > date("Y"))){

                                /* 
                                    NOT: Gerçek bir ödeme sistemi kullanıldığında kredi kartı bilgilerinin 
                                    bir kısmının veritabanında tutulması güvenlik açığı oluşturabilir bu nedenle
                                    ödeme sisteminin bize geri döndürdüğü ödeme işlem kimliğini tutmak daha güvenli olacaktır
                                    burada örnek olması amacıyla kredi kartı bilgileri tutuluyormuş gibi yapılmıştır
                                */

                                $krediKartNoHash = substr($kredi_kart_no, 0, 4).str_repeat("*", 8).substr($kredi_kart_no, -4);
                                
                                if($type == "ulasim_karti_bakiye"){ // Ulaşım kartına bakiye yükleme modülü

                                    $yuklenecekBakiye = htmlspecialchars($_POST['yuklenecek_bakiye']);

                                    if($yuklenecekBakiye >= 5 && $yuklenecekBakiye <= 200){

                                        $ulasimKartNo = htmlspecialchars($_POST['ulasim_kart_no']);

                                        $sorgu = "SELECT Kart_Bakiye, Kart_ID FROM Ulasim_Kartlar WHERE Kart_No='$ulasimKartNo' AND Kart_Durum='True'";
                                        $kart = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

                                        if(isset($kart)){

                                            mysqli_autocommit($mysqli, FALSE); // Otomatik işlem tamamlama modunu devre dışı bırakıyoruz

                                            // Toplu işlemler veritabanına kaydedilirken hatalar oluşabilir bunların önüne geçmek için transaction kullanıyoruz

                                            try {

                                                mysqli_begin_transaction($mysqli); // İşlemi başlatıyoruz

                                                $query = "INSERT INTO Odemeler (Odeme_Kodu, Odeme_No, Odeme_Uye_ID, Odeme_Kart_Ad_Soyad, Odeme_Kart_No, Odeme_Tutar, Odeme_Zaman) VALUES ('$type', '$ulasimKartNo', $userID, '$kredi_kart_ad_soyad', '$krediKartNoHash', '$yuklenecekBakiye', '$time')";
                                        
                                                if(mysqli_query($mysqli, $query)){

                                                    $query = "UPDATE Ulasim_Kartlar SET Kart_Bakiye=Kart_Bakiye+$yuklenecekBakiye WHERE Kart_No='$ulasimKartNo' AND Kart_Durum='True'";

                                                    if(mysqli_query($mysqli, $query)){

                                                        $query = "INSERT INTO Ulasim_Kart_Islemler (Islem_Tip, Islem_Yeri, Islem_Kart_ID, Islem_Tutar, Islem_Zaman) VALUES ('Yukleme', 'Online', '$kart[Kart_ID]', '$yuklenecekBakiye', '$time')";
                                        
                                                        if(mysqli_query($mysqli, $query)){

                                                            $json['title'] = $word['basarili'];
                                                            $json['text'] = $word['bakiye_basariyla_yuklendi'];
                                                            $json['status'] = "success";

                                                            $json['bakiye'] = "₺".Balance($kart['Kart_Bakiye']+$yuklenecekBakiye);

                                                            mysqli_commit($mysqli); // Tüm sorgular başarılı olduysa işlemi tamamlıyoruz

                                                        }else{

                                                            throw new Exception(mysqli_error($mysqli));

                                                        }

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

                                            $json['title'] = $word['hata'];
                                            $json['text'] = $word['kart_bulunamadi'];
                                            $json['status'] = "warning";

                                        }

                                    }else{
                                        
                                        $json['title'] = $word['yukleme_limiti'];
                                        $json['text'] = $word['en_az_5_en_fazla_200_tl_yuklenebilir'];
                                        $json['status'] = "info";

                                    }

                                }elseif($type == "borc_odeme"){  // Borç ödeme modülü

                                    $borcID = htmlspecialchars($_POST['borc_id']);

                                    $sorgu = "SELECT * FROM Borclar B JOIN Borc_Tipleri BT ON B.Borc_Tip_ID = BT.Tip_ID LEFT JOIN Su_Abonelikler SA ON B.Borclu_Bilgisi = SA.Abone_ID LEFT JOIN Uyeler U ON (B.Borclu_Bilgisi = U.Uye_Sicil_No OR SA.Abone_Sicil_No = U.Uye_Sicil_No) WHERE B.Borc_Durum = 'Odenmedi' AND B.Borc_ID = '$borcID'";
                                    $borc = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

                                    if(isset($borc)){

                                        if($borc['Borc_Son_Odeme_Tarihi'] < $date){
                                            $gecenGun = DateDifference($date, $borc['Borc_Son_Odeme_Tarihi']);
                                            $ceza = (($borc['Borc_Tutari']/100*$belediye['Belediye_Borc_Faiz'])*$gecenGun);
                                        }else{
                                            $ceza = 0;
                                        }

                                        mysqli_autocommit($mysqli, FALSE); // Otomatik işlem tamamlama modunu devre dışı bırakıyoruz

                                        // Toplu işlemler veritabanına kaydedilirken hatalar oluşabilir bunların önüne geçmek için transaction kullanıyoruz

                                        try {

                                            mysqli_begin_transaction($mysqli); // İşlemi başlatıyoruz

                                            $tutar = ($borc['Borc_Tutari']+$ceza);

                                            $query = "INSERT INTO Odemeler (Odeme_Kodu, Odeme_No, Odeme_Uye_ID, Odeme_Kart_Ad_Soyad, Odeme_Kart_No, Odeme_Tutar, Odeme_Zaman) VALUES ('$type', '$borcID', $userID, '$kredi_kart_ad_soyad', '$krediKartNoHash', '$tutar', '$time')";
                                    
                                            if(mysqli_query($mysqli, $query)){

                                                $query = "UPDATE Borclar SET Borc_Durum='Odendi', Borc_Ceza='$ceza' WHERE Borc_ID='$borcID' AND Borc_Durum='Odenmedi'";

                                                if(mysqli_query($mysqli, $query)){

                                                    $json['title'] = $word['basarili'];
                                                    $json['text'] = $word['borc_basariyla_odendi'];
                                                    $json['status'] = "success";

                                                    $json['borc_turu_adi'] = $word[$borc['Tip_Kodu']];
                                                    $json['tutar'] = "₺".Balance(0);
                                                    
                                                    if($borc['Uye_Sicil_No'] == $uye['Uye_Sicil_No']){
                                                        $json['ad_soyad'] = $borc['Uye_Ad']." ".$borc['Uye_Soyad'];
                                                    }else{
                                                        $json['ad_soyad'] = MaskedText($borc['Uye_Ad'], 2)." ".MaskedText($borc['Uye_Soyad'], 2);
                                                    }

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

                                        $json['title'] = $word['hata'];
                                        $json['text'] = $word['borc_bulunamadi_yada_odendi'];
                                        $json['status'] = "warning";

                                    }
                                    
                                }else{

                                    $json['title'] = $word['modul_kurulmadi'];
                                    $json['text'] = $word['modul_kurulumu_tamamlanmadi'];
                                    $json['status'] = "info";

                                }

                            }else{

                                $json['title'] = $word['hata'];
                                $json['text'] = $word['kart_son_kullanma_tarihi_gecmis'];
                                $json['status'] = "warning";

                            }

                        }else{

                            $json['title'] = $word['hata'];
                            $json['text'] = $word['kart_son_kullanma_tarihi_hatali'];
                            $json['status'] = "warning";

                        }

                    }else{

                        $json['title'] = $word['hata'];
                        $json['text'] = $word['cvv_kodunuz_hatali'];
                        $json['status'] = "warning";

                    }

                }else{

                    $json['title'] = $word['hata'];
                    $json['text'] = $word['kredi_kart_numaraniz_hatali'];
                    $json['status'] = "warning";

                }

            }else{

                $json['title'] = $word['hata'];
                $json['text'] = $word['kredi_kart_bilgilerinizi_bos_birakamazsiniz'];
                $json['status'] = "warning";

            }

        }else{

            $json['title'] = $word['eksik_bilgi'];
            $json['text'] = $word['kayit_sozlesmesini_kabul_etmelisiniz'];
            $json['status'] = "warning";
    
        }

    }else{

        $json['title'] = $word['hata'];
        $json['text'] = $word['modul_bulunamadi'];
        $json['status'] = "warning";

    }

}

echo json_encode($json);

?>