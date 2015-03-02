<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "infonil";

$conn = mysql_connect("$hostname","$username","$password");
if (!$conn) die ("Gagal Melakukan Koneksi");
mysql_select_db($database,$conn) or die ("Database Tidak Ditemukan di Server"); 
?>