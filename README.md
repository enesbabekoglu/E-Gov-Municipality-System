# (EN) E-Municipality System with PHP-Ajax-MySQL

A project developed using PHP, Ajax, and MySQL for an E-Municipality System.

## Project Demo

**Project:** [https://enesbabekoglu.com.tr/projeler/belediye](https://enesbabekoglu.com.tr/projeler/belediye)

**Demo Members:** [https://enesbabekoglu.com.tr/projeler/belediye/Uyeler.pdf](https://enesbabekoglu.com.tr/projeler/belediye/Uyeler.pdf)

The passwords for the demo members are set as **"demo"**.

## Project Introduction Video

[https://youtu.be/DZ1rTM1RA08](https://youtu.be/DZ1rTM1RA08)

[![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/37441e90-1925-4279-b4fb-13238c1a0fdb)](https://youtu.be/DZ1rTM1RA08)

## Installation 🚀

To set up this project on your local environment, follow these steps:

- Download the installation files.
- Upload the files to your hosting directory.
- Create a new MySQL database and import the **"Database.sql"** file included in the project.
- Open the **"config.php"** file and enter your database information in the corresponding fields.

## Requirements 📋

- **PHP 7.x** or higher
- **MySQL 5.x** or higher
- **Apache** or **Nginx** web server

## Additional Information

- The project currently does not have an admin panel. Modifications can be made directly through the database. It is designed only for end-user use.
- There are 26 tables in the MySQL database.
- The project uses a free Bootstrap theme called **"AdminKit Basic"**.
  - **AdminKit:** [https://demo-basic.adminkit.io](https://demo-basic.adminkit.io)
- The demo data (demo members, employees, neighborhoods, debts, etc.) were simulated using AI **ChatGPT**.
- The demo images (employee images, social aid cover images, module covers, etc.) were created using the following AI tools:
  - **Freepik Image Generator:** [https://www.freepik.com/ai/image-generator](https://www.freepik.com/ai/image-generator)
  - **Ideogram AI:** [https://ideogram.ai](https://ideogram.ai)

## Main Features 🌟

- **Social Aid Application**
  - New application forms can be created in the Sosyal_Yardimlar table in the database. Form data can be entered in the "Yardim_Istenen_Girdiler" column, separated by commas (","). Example input and output are as follows:

    Input: "QUESTION1, QUESTION2 [A, B]"

    Output: QUESTION1 = input / QUESTION2 = select[A, B]
  
- **Module Creation/Editing from Database**
  - Modules can be linked to external or internal links.
  - Modules can be set to be displayed in the menu, on a specific page, or not displayed at all.
  - Modules can be disabled.
  - Modules can be configured for use with or without membership.

  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/4be1ecc9-b689-4e0f-8650-00f9479f8585)
  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/e2947d8d-8081-42cd-8bf0-7fe92378a09c)

- **Digital Cashier**
  - **Transportation Card Balance**
    - Balance can be loaded onto a transportation card with or without membership.
    - Balance can be loaded onto the transportation card with an ID number received via GET.
    - The balance of the transportation card can be queried automatically via AJAX.
      
      ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/d4b9f4ed-5a0e-45e5-9401-2d3f6148fe08)

  - **Debt Payment**
    - Debts defined in the Borclar table in the database can be paid with or without membership.
    - A debt can be defined in the Borclar table using the subscription number of a water subscriber in the Su_Abonelikler table. The subscriber number is automatically detected, and the debt is linked to that person.
    - Debt amount, debt owner, and debt type can be queried using the Debt ID via AJAX.

      ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/1e42c1d9-0584-4ce6-8070-7c7c786407b1)

    - Debt definitions can be made in the database. If the due date of debts is exceeded, daily interest is calculated for the overdue days, and the debt is recalculated. The interest rate can be set in the interest column of the Belediye table.

      ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/761c5ed5-fa15-41e2-9835-2aac24c0e701)

- **Service Desk**
  - A module where citizens can contact the municipality. Requests are stored in the Talepler table in the database. Conversations related to requests are stored in the Talepler_Mesajlar table.

  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/e39d3ce3-6186-47bd-9421-4939c715d68e)
  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/cdbd451b-c11a-4ad3-95bc-513f31c55310)

- **Properties**
  - Properties can be defined in neighborhoods and streets for citizens from the database.

  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/d7c45264-6402-4e92-8082-0e3d259130bd)

- **Municipality Employees**
  - Municipality employees can be shared with citizens. They can be edited from the Belediye_Personeller and Belediye_Departmanlar tables in the database.

  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/6131fac6-622d-414d-81f5-cac58b83f53f)

- **Transportation System**
  - A module that simulates the transportation system within the municipality boundaries. New routes can be created, and their times and routes can be determined. Additionally, fare tariffs for routes can be adjusted based on the card type through the database. New transportation cards can be added. Existing cards include student, full, elderly, and disabled cards.

  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/9a87ec1b-36ab-4c75-8d16-7c69ffe252d0)
  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/829ed9ef-ef56-4b8a-a86b-130ef6bf622c)
  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/d8d5530a-2ad6-4921-a2c1-933a4444d3f6)
  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/456099b8-29ca-4101-962c-0e4463970140)
  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/53ba34f1-3cbb-4fe4-ad69-19751b63098a)

  - **Ride Simulation**
    - A test module where you can simulate riding a bus.

    ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/f961b2d6-51c5-4963-af2e-df571509e2c6)
    ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/8ad48ab0-2964-476f-a72b-76924eaafc4f)
    ![image](https://github.com/enesbabekog

lu/E-Gov-Municipality-System/assets/92182480/a3018bbb-07a8-4994-b4b1-a664650cee83)

## License 📄

This project is licensed under the MIT License. For more details, please refer to the `LICENSE` file.

## Contributing 🤝

If you would like to contribute to this project, please submit a **pull request** or open an **issue**. Your feedback and contributions are welcome!

# (TR) PHP-Ajax-MySQL ile E-Belediye Sistemi

PHP, Ajax ve MySQL kullanılarak geliştirilmiş bir E-Belediye Sistemi projesidir.

## Proje Demosu

**Proje:** [https://enesbabekoglu.com.tr/projeler/belediye](https://enesbabekoglu.com.tr/projeler/belediye)

**Demo Üyeler:** [https://enesbabekoglu.com.tr/projeler/belediye/Uyeler.pdf](https://enesbabekoglu.com.tr/projeler/belediye/Uyeler.pdf)

Demo üyelerin şifreleri **"demo"** olarak belirlenmiştir.

## Proje Tanıtım Videosu

[https://youtu.be/DZ1rTM1RA08](https://youtu.be/DZ1rTM1RA08)

[![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/37441e90-1925-4279-b4fb-13238c1a0fdb)](https://youtu.be/DZ1rTM1RA08)

## Kurulum 🚀

Bu projeyi kendi ortamınıza kurmak için aşağıdaki adımları izleyin:

- Kurulum dosyalarını indirin.
- Dosyaları hosting dizininize yükleyin.
- Yeni bir MySQL veritabanı oluşturun ve proje içinde yer alan **"Database.sql"** dosyasını içe aktarın.
- **"config.php"** dosyasını açın ve veritabanı bilgilerinizi ilgili alanlara girin.

## Gereksinimler 📋

- **PHP 7.x** veya üstü
- **MySQL 5.x** veya üstü
- **Apache** veya **Nginx** web sunucusu

## Ek Bilgiler

- Projenin şu anda bir admin paneli yoktur. Düzenlemeler doğrudan veritabanı üzerinden yapılabilir. Proje sadece son kullanıcı için tasarlanmıştır.
- MySQL veritabanında 26 tablo bulunmaktadır.
- Proje, ücretsiz bir Bootstrap teması olan **"AdminKit Basic"** kullanır.
  - **AdminKit:** [https://demo-basic.adminkit.io](https://demo-basic.adminkit.io)
- Demo verileri (demo üyeler, personeller, mahalleler, borçlar vb.) yapay zeka **ChatGPT** kullanılarak simüle edilmiştir.
- Demo görselleri (personel görselleri, sosyal yardımlar kapak görselleri, modül kapakları vb.) aşağıdaki yapay zekalar kullanılarak hazırlanmıştır:
  - **Freepik Image Generator:** [https://www.freepik.com/ai/image-generator](https://www.freepik.com/ai/image-generator)
  - **Ideogram AI:** [https://ideogram.ai](https://ideogram.ai)

## Ana Özellikler 🌟

- **Sosyal Yardım Başvurusu**
  - Veritabanından Sosyal_Yardimlar tablosu üzerinden yeni başvuru formları oluşturulabilir. Form verileri "Yardim_Istenen_Girdiler" sütununa virgülle (",") ayrılarak girilebilir. Örnek girdi ve çıktı aşağıdaki gibidir:

    Girdi: "SORU1, SORU2 [A, B]"

    Çıktı: SORU1 = input / SORU2 = select[A, B]
  
- **Veritabanından Modül Oluşturma/Düzenleme**
  - Modüllere dış veya iç bağlantılar verilebilir.
  - Modüllerin menüde, belirli bir sayfada gösterilmesi ya da hiç gösterilmemesi gibi ayarlar yapılabilir.
  - Modüller devre dışı bırakılabilir.
  - Modüllerin üyelikli veya üyeliksiz kullanımı ayarlanabilir.

  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/4be1ecc9-b689-4e0f-8650-00f9479f8585)
  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/e2947d8d-8081-42cd-8bf0-7fe92378a09c)

- **Dijital Vezne**
  - **Ulaşım Kartı Bakiyesi**
    - Ulaşım kartına üyelikli veya üyeliksiz bakiye yüklenebilir.
    - GET ile alınan ID numarası ile ulaşım kartına bakiye yüklenebilir.
    - Ulaşım kartı bakiyesi AJAX ile otomatik olarak sorgulanabilir.
      
      ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/d4b9f4ed-5a0e-45e5-9401-2d3f6148fe08)

  - **Borç Ödeme**
    - Veritabanındaki Borclar tablosunda tanımlı borçlar üyelikli veya üyeliksiz olarak ödenebilir.
    - Su_Abonelikler tablosundaki bir su abonesinin abone numarası Borclar tablosunda kullanılarak borç tanımlanabilir. İlgili su abonesinin sicil numarası otomatik olarak tespit edilir ve borç o kişiye bağlanır.
    - Borç ID değeri kullanılarak borç tutarı, borç sahibi ve borç türü AJAX ile sorgulanabilir.

      ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/1e42c1d9-0584-4ce6-8070-7c7c786407b1)

    - Veritabanında borç tanımlaması yapılabilir. Borçların son ödeme tarihi geçerse, geçen gün kadar günlük faiz uygulanır ve borç yeniden hesaplanır. Faiz oranı Belediye tablosundaki faiz sütununda belirlenebilir.

      ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/761c5ed5-fa15-41e2-9835-2aac24c0e701)

- **Hizmet Masası**
  - Belediye ile iletişime geçilebilecek bir modüldür. Talepler, veritabanındaki Talepler tablosunda tutulur. Talepler_Mesajlar tablosunda ise talep konuşmaları yer alır.

  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/e39d3ce3-6186-47bd-9421-4939c715d68e)
  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/cdbd451b-c11a-4ad3-95bc-513f31c55310)

- **Mülkler**
  - Vatandaşlara, veritabanından mahalle ve sokaklarda mülk tanımlaması yapılabilir.

  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/d7c45264-6402-4e92-8082-0e3d259130bd)

- **Belediye Personelleri**
  - Belediye personelleri vatandaşlarla paylaşılabilir. Bu veriler, veritabanındaki Belediye_Personeller ve Belediye_Departmanlar tablolarından düzenlenebilir.

  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/6131fac6-622d-414d-81f5-cac58b83f53f)

- **Ulaşım Sistemi**
  - Belediye sınırları içindeki ulaşım sistemini simüle eden bir modüldür. Yeni hatlar oluşturabilir, saatlerini ve güzergahlarını belirleyebiliriz. Ayrıca, veritabanı üzerinden hatlarda geçerli fiyat tarifelerini basılan kart türüne göre düzenleyebiliriz. Yeni ulaşım kartları eklenebilir. Mevcut kartlar arasında öğrenci, tam, yaşlı ve engelli kartları bulunur.

  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/9a87ec1b-36ab-4c75-8d16-7c69ffe252d0)
  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/829ed9ef-ef56-4b8a-a86b-130ef6bf622c)
  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/d8d5530a-2ad

6-4921-a2c1-933a4444d3f6)
  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/456099b8-29ca-4101-962c-0e4463970140)
  ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/53ba34f1-3cbb-4fe4-ad69-19751b63098a)

  - **Biniş Simülasyonu**
    - Bir otobüse biniyormuş gibi simülasyon yapabileceğimiz bir test modülüdür.

    ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/f961b2d6-51c5-4963-af2e-df571509e2c6)
    ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/8ad48ab0-2964-476f-a72b-76924eaafc4f)
    ![image](https://github.com/enesbabekoglu/E-Gov-Municipality-System/assets/92182480/a3018bbb-07a8-4994-b4b1-a664650cee83)

## Lisans 📄

Bu proje MIT Lisansı ile lisanslanmıştır. Daha fazla bilgi için `LICENSE` dosyasına göz atabilirsiniz.

## Katkıda Bulunma 🤝

Bu projeye katkıda bulunmak isterseniz, lütfen bir **pull request** gönderin veya bir **issue** açın. Geri bildirimleriniz ve katkılarınız memnuniyetle karşılanacaktır!
