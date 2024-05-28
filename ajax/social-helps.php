<?php 

usleep(300000); // 300,000 mikrosaniye (0.3 saniye)

session_start(); // Session bağlantısı başlatılıyor

include "../connect.php";
include "../global-veriables.php";
include "../languages/$language.php";
include "../functions.php";

$login = ($userID != "NULL" && isset($userID)) ? true : false;

if(isset($_POST['sosyal_yardim'])){

    if($login){

        $yardimID = htmlspecialchars($_POST['yardim_id']);

        $sorgu = "SELECT *, COUNT(Yardim_ID) AS say FROM Sosyal_Yardimlar WHERE Yardim_Durum='True' AND ((Yardim_Baslangic<='$time' AND Yardim_Bitis>='$time') OR (Yardim_Baslangic IS NULL AND Yardim_Bitis IS NULL) OR (Yardim_Baslangic IS NULL AND Yardim_Bitis>='$time') OR (Yardim_Baslangic<='$time' AND Yardim_Bitis IS NULL)) AND Yardim_ID='$yardimID'";
        $yardim = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

        if($yardim['say'] > 0){

            $sozlesme = isset($_POST['sozlesme']) ? $_POST['sozlesme'] : false;

            if($sozlesme){

                $girdi = $yardim['Yardim_Istenen_Girdiler'];

                // Parçaları virgülle ayır
                $parcalar = preg_split('/,\s*(?![^\[]*\])/', $girdi);
                
                // Sonuç dizisi
                $sonuc = array();
                
                foreach ($parcalar as $parca) {
                    // Anahtar ve değeri ayır
                    $parca = explode('[', $parca);
                    
                    // Anahtar
                    $anahtar = trim($parca[0]);
                    
                    // Değer varsa işleme al
                    if (isset($parca[1])) {
                        // Değeri temizle ve parçala
                        $deger = str_replace(['[', ']'], '', $parca[1]);
                        $deger = explode(',', $deger);
                        $deger = array_map('trim', $deger);
                    } else {
                        // Değer yoksa boş dizi ata
                        $deger = [];
                    }
                    
                    // Anahtar ve değeri ekle
                    $sonuc[$anahtar] = $deger;
                }
                
                $inputlar = 0;
                $girdiler = 0;
                $veri = "";
                
                $i = 1; 
                foreach ($sonuc as $anahtar => $alt_anahtarlar) {
                    $post_key = $i . "-" . md5($anahtar);
                
                    // POST verisinin mevcut olup olmadığını kontrol edin
                    if (isset($_POST[$post_key])) {
                        $gelenPOST = htmlspecialchars($_POST[$post_key]);
                
                        if (!empty($alt_anahtarlar)) { // Eğer select ise
                            if (in_array($gelenPOST, $alt_anahtarlar)) {
                                $girdiler++;
                            }
                        } else {
                            if (!empty($gelenPOST)) {
                                $girdiler++;
                            }
                        }
                
                        if ($veri == "") {
                            $veri .= $gelenPOST;
                        } else {
                            $veri .= ", " . $gelenPOST;
                        }
                
                        $inputlar++;
                    }
                
                    $i++;
                }
                
                $basvurabilir = ($inputlar == $girdiler) ? true : false;
                
                if ($basvurabilir) {

                    $sorgu = "SELECT COUNT(Basvuru_ID) AS say FROM Sosyal_Yardimlar_Basvurular WHERE Basvuru_Uye_ID='$userID' AND Basvuru_Yardim_ID='$yardimID'";
                    $basvuru = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));
                
                    if($basvuru['say'] == 0){

                        mysqli_autocommit($mysqli, FALSE); // Otomatik işlem tamamlama modunu devre dışı bırakıyoruz

                        // Toplu işlemler veritabanına kaydedilirken hatalar oluşabilir bunların önüne geçmek için transaction kullanıyoruz

                        try {

                            mysqli_begin_transaction($mysqli); // İşlemi başlatıyoruz

                            $query = "INSERT INTO Sosyal_Yardimlar_Basvurular (Basvuru_Yardim_ID, Basvuru_Uye_ID, Basvuru_Girdiler, Basvuru_Durum, Basvuru_Degerlendiren_ID, Basvuru_Degerlendirme_Zaman, Basvuru_Degerlendirme_Not, Basvuru_Zaman) VALUES ('$yardimID', '$userID', '$veri', 'Degerlendiriliyor', NULL, NULL, NULL, '$time')";
                                                
                            if(mysqli_query($mysqli, $query)){

                                $json['title'] = $word['basarili'];
                                $json['text'] = $word['basvurunuz_basariyla_alinmistir'];
                                $json['status'] = "success";

                                mysqli_commit($mysqli); // Tüm sorgular başarılı olduysa işlemi tamamlıyoruz
                            
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
                        $json['text'] = $word['zaten_bir_basvurunuz_bulunmaktadir'];
                        $json['status'] = "warning";

                    }

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
            $json['text'] = $word['yardim_basvurusu_bulunamadi'];
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