<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "laundry_praojk";

$koneksi = mysqli_connect($host, $user, $password, $db);
if (!$koneksi) {
    echo "Koneksi Gagal";
}
