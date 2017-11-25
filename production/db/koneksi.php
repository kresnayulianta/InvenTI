<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbnm = "inventaris";

//create connection
$conn = mysqli_connect($host,$user,$pass,$dbnm);

//check connection
if(mysqli_connect_errno()){
	echo "Koneksi Gagal: " . mysqli_connect_error();
}
?>