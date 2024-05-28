# PHP-Ajax-MySQL-E-Belediye-Sistemi
PHP Ajax ve MySQL Kullanılarak Hazırlanmış E-Belediye Sistemi Projesi

## Proje Demosu

https://enesbabekoglu.com.tr/projeler/belediye

## Proje Kurulumu
- Kurulum dosyalarını indirin
- Dosyaları hosting dizininize yükleyin
- Yeni bir MySQL veritabanı oluşturun ve dosyalar arasındaki **"Database.sql"** isimli dosyayı içe aktarın
- Dosyalar arasındaki **"config.php"** dosyasını açın ve veritabanı bilgilerinizi ilgili alanlara girin

## Ek Bilgiler
- Projenin admin paneli henüz yoktur. Düzenlemeleri veritabanı üzerinden yapabilirsiniz. Sadece son kullanıcı için tasarlanmıştır.

- MySQL Veritabanı üzerinde 26 tablo bulunmaktadır.
  
- Proje ücretsiz hazır bir Bootstrap teması olan **"AdminKit Basic"** kullanır.
  
  - **AdminKit** : https://demo-basic.adminkit.io
    
- Demo verileri (demo üyeler, personeller, mahalleler, borçlar vb.) yapay zeka **ChatGPT** ile simüle edilmiştir.
  
- Demo görselleri (personel görselleri, sosyal yardımlar kapak görselleri, modül kapakları vb.) aşağıdaki yapay zekalar ile hazırlanmıştır.
  
  - **Freepik Image Generator** : https://www.freepik.com/ai/image-generator
  - **Ideogram AI** : https://ideogram.ai

## Proje Ana Özellikleri
- **Sosyal Yardımlar Başvurusu**
  - Veritabanından Sosyal_Yardimlar tablosu üzerinden yeni başvuru formları oluşturulabilir. Yardim_Istenen_Girdiler isimli sütuna virgül ile (",") form verileri girilebilir. Örnek girdi ve çıktı aşağıdaki gibi olacaktır.

    Girdi: "SORU1, SORU2 [A, B]"
    
    Çıktı: SORU1 = input / SORU2 = select[A, B]
    
- **Veritabanından Modül Oluşturma/Düzenleme**
  
  - Modüllere dış veya iç bağlantılar verilebilir.
  - Modüllerin menüde veya belirli bir sayfada gösterilebilmesi veya hiç gösterilmemesi gibi ayarlar yapılabilir.
  - Modüller kullanımdan kaldırılabilir.
  - Modüllerin üyeliksiz/üyelikli kullanımı ayarlanabilir.
    
![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/4be1ecc9-b689-4e0f-8650-00f9479f8585)
![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/e2947d8d-8081-42cd-8bf0-7fe92378a09c)

- **Dijital Vezne**

    ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/5082e0c3-593f-4e8d-99e4-ec3edae582b5)
  
  - Ulaşım Kartı Bakiyesi
    
    - Ulaşım kartına üyelikli/üyeliksiz bakiye yüklenebilir.
    - ID Numarası GET ile gelen ulaşım kartına bakiye yüklenebilir.
    - Ulaşım kartı bakiyesi otomatik olarak AJAX ile sorgulanabilir.
      
      ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/d4b9f4ed-5a0e-45e5-9401-2d3f6148fe08)

   
  - Borç Ödeme
    
    - Veritabanından Borclar isimli tablo üzerinde tanımlı borçlar üyelikli/üyeliksiz ödenebilir.
    - Veritabanından Su_Abonelikler isimli tablodaki bir su abonesinin abone numarası Borclar isimli tabloda kullanılarak borç tanımlanabilir. İlgili su abonesinin sicil numarası otomatik olarak tespit edilip borç o kişiye bağlanır.
    - Borç ID değeri kullanılarak borç tutarı, borç sahibi ve borç türü AJAX ile sorgulanabilir.
   
      ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/1e42c1d9-0584-4ce6-8070-7c7c786407b1)

    - Veritabanından borç tanımlama yapılabilir. Borçların son ödeme tarihi geçerse geçtiği gün kadar günlük faiz işlenir ve borç tekrar hesaplanır. Faiz oranı Belediye isimli tablodaki faiz sütunundan belirlenebilir.
      
      ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/761c5ed5-fa15-41e2-9835-2aac24c0e701)

- **Hizmet Masası**

  Belediye ile iletişime geçilebilecek bir modüldür. Veritabanında Talepler isimli tabloda tutulur. Talepler_Mesajlar isimli tabloda ise talep konuşmaları yer almaktadır.

  ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/e39d3ce3-6186-47bd-9421-4939c715d68e)
  ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/cdbd451b-c11a-4ad3-95bc-513f31c55310)

- **Mülkler**

  Vatandaşlara veritabanından mahalle ve sokaklarda mülk tanımlaması yapılabilir.

  ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/d7c45264-6402-4e92-8082-0e3d259130bd)

- **Belediye Personelleri**

  Belediye personelleri vatandaşlarla paylaşılabilir. Veritabanından Belediye_Personeller ve Belediye_Departmanlar tablosundan düzenlenebilir.

  ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/6131fac6-622d-414d-81f5-cac58b83f53f)

- **Ulaşım Sistemi**

  Belediye sınırları içerisindeki ulaşım sistemini simüle eden modülümüzdür. Yeni hatlar oluşturabilir, saatlerini ve güzergahlarını belirleyebiliriz. Ayrıca veritabanı üzerinden hatlarda geçerli fiyat tarifelerini basılan karta göre düzenleyebiliriz. Yeni ulaşım kartları ekleyebiliriz. Hali hazırda öğrenci, tam, yaşlı ve engelli kartları bulunur.

  ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/9a87ec1b-36ab-4c75-8d16-7c69ffe252d0)
  ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/829ed9ef-ef56-4b8a-a86b-130ef6bf622c)
  ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/d8d5530a-2ad6-4921-a2c1-933a4444d3f6)
  ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/456099b8-29ca-4101-962c-0e4463970140)
  ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/53ba34f1-3cbb-4fe4-ad69-19751b63098a)

  - Biniş Simülasyonu

    Bir otobüse biniyormuş gibi simülasyon yapabileceğimiz bir test modülüdür.

    ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/f961b2d6-51c5-4963-af2e-df571509e2c6)
    ![image](https://github.com/enesbabekoglu/PHP-Ajax-MySQL-E-Belediye-Sistemi/assets/92182480/8ad48ab0-2964-476f-a72b-76924eaafc4f)

    


