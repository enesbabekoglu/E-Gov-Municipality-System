<?php 

$userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "NULL"; // Kullanıcı ID
$page = isset($_GET['page']) ? $_GET['page'] : null; // Mevcut Sayfa GET

$languages = array("tr", "en"); // Sistemdeki Mevcut Dil Seçenekleri
$language = isset($_COOKIE['language']) ? (in_array($_COOKIE['language'], $languages) ? $_COOKIE['language'] : "tr"): "tr"; // Mevcut Dil

$sorgu = "SELECT * FROM Belediye WHERE Belediye_ID='1'";
$belediye = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

if(isset($userID)){

    $sorgu = "SELECT * FROM Uyeler WHERE Uye_ID='$userID'";
    $uye = mysqli_fetch_assoc(mysqli_query($mysqli, $sorgu));

}

date_default_timezone_set('Europe/Istanbul');

$time = date("Y-m-d H:i:s");
$date = date("Y-m-d");

?>