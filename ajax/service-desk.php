<?php 

usleep(300000); // 300,000 mikrosaniye (0.3 saniye)

session_start(); // Session bağlantısı başlatılıyor

include "../connect.php";
include "../global-veriables.php";
include "../languages/$language.php";
include "../functions.php";

$login = ($userID != "NULL" && isset($userID)) ? true : false;

if(isset($_POST['hizmet_masasi'])){

    if($login){

        $talep_tip_id = htmlspecialchars($_POST['talep_tip_id']);
        $talep_mesaj = mysqli_real_escape_string($mysqli, $_POST['talep_mesaj']);

        $sorgu = "SELECT *, COUNT(Tip_ID) AS say FROM Talep_Tipleri WHERE Tip_Durum='True' AND Tip_ID='$talep_tip_id'";
        $talepTip = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

        if($talepTip['say'] > 0){

            $sozlesme = isset($_POST['sozlesme']) ? $_POST['sozlesme'] : false;

            if($sozlesme){
                
                $basvurabilir = ($inputlar == $girdiler) ? true : false;
                
                if (isset($talep_tip_id) && isset($_POST['talep_mesaj']) && $_POST['talep_mesaj'] != "") {

                    mysqli_autocommit($mysqli, FALSE); // Otomatik işlem tamamlama modunu devre dışı bırakıyoruz

                    // Toplu işlemler veritabanına kaydedilirken hatalar oluşabilir bunların önüne geçmek için transaction kullanıyoruz

                    try {

                        mysqli_begin_transaction($mysqli); // İşlemi başlatıyoruz

                        $query = "INSERT INTO Talepler (Talep_Kategori_ID, Talep_Uye_ID, Talep_Zaman, Talep_Durum, Talep_Departman_ID, Talep_Son_Islem_Zaman) VALUES ('$talep_tip_id', '$userID', '$time', 'Beklemede', NULL, NULL)";
                                                
                        if(mysqli_query($mysqli, $query)){

                            $talepID = mysqli_insert_id($mysqli); // oluşturulan yeni talebin idsini alıyoruz

                            $query = "INSERT INTO Talepler_Mesajlar (Talep_ID, Gonderen_Uye_ID, Gonderen_Tipi, Mesaj_Zaman, Mesaj) VALUES ('$talepID', '$userID', 'Vatandas', '$time', '$talep_mesaj')";

                            if(mysqli_query($mysqli, $query)){

                                $json['title'] = $word['basarili'];
                                $json['text'] = $word['talebiniz_basariyla_iletilmistir'];
                                $json['status'] = "success";
    
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

                    $json['title'] = $word['eksik_bilgi'];
                    $json['text'] = $word['hicbir_alani_bos_birakmayiniz'];
                    $json['status'] = "warning";

                }

            }else{

                $json['title'] = $word['eksik_bilgi'];
                $json['text'] = $word['kayit_sozlesmesini_kabul_etmelisiniz'];
                $json['status'] = "warning";
        
            }

        }else{

            $json['title'] = $word['hata'];
            $json['text'] = $word['talep_tipi_bulunamadi'];
            $json['status'] = "warning";

        }

    }else{

        $json['title'] = $word['hata'];
        $json['text'] = $word['bu_modul_icin_giris_yapilmalidir'];
        $json['status'] = "warning";

    }

}

echo json_encode($json);

?>