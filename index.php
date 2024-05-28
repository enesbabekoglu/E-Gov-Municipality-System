<?php 

ob_start();

session_start(); // Session bağlantısı başlatılıyor

include "connect.php"; // Veritabanı bağlantı dosyası
include "global-veriables.php"; // Global değişkenler dosyası
include "languages/$language.php";
include "functions.php"; // Fonksiyonlar dosyası

$login = ($userID != "NULL" && isset($userID)) ? true : false;

include "header.php";
include "sidebar.php";
include "topbar.php";

include (in_array($page, array("login", "register", "recover"))) ? ($login ? "pages/index.php" : "$page.php") : (isset($page) ? "pages/$page.php" : "pages/index.php"); 

include "footbar.php";
include "footer.php";

ob_end_flush();

?>