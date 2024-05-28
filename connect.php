<?php 

// Veritabanı Bağlantı Dosyamız

$dbServerName = "localhost"; // Sunucu IP/Sunucu Makine Adı
$dbUserName = "enesbabekoglu_lab"; // MySQL Kullanıcı Adı
$dbPassword = "_M15vx7e3"; // MySQL Kullanıcı Şifresi
$dbName = "enesbabekoglu_lab"; // Veritabanı Adı

$mysqli = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName); // Veritabanı Bağlantısı

if (!$mysqli) { // Bağlantı kurulurken bir hata oluştuysa
    die("Veritabanı bağlantı hatası: " . mysqli_connect_error()); // Ekrana hata bas
}

mysqli_set_charset($mysqli, "utf8");

?>