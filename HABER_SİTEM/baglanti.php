<?php

//VERİ TABANI BAĞLANTISI

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "haber_sitem";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}


?>