<?php 

// Veritabanı Bağlantı Dosyamız

$dbServerName = "localhost"; // Sunucu IP/Sunucu Makine Adı
$dbUserName = "MYSQL KULLANICI ADI BURAYA"; // MySQL Kullanıcı Adı
$dbPassword = "MYSQL KULLANICI ŞİFRE BURAYA"; // MySQL Kullanıcı Şifresi
$dbName = "VERİTABANI ADI BURAYA"; // Veritabanı Adı

$mysqli = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName); // Veritabanı Bağlantısı

if (!$mysqli) { // Bağlantı kurulurken bir hata oluştuysa
    die("Veritabanı bağlantı hatası: " . mysqli_connect_error()); // Ekrana hata bas
}

mysqli_set_charset($mysqli, "utf8");

?>