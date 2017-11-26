<?php
    session_start();
    error_reporting(0);
    if (empty($_SESSION['login']['hakakses'])) {
        echo "
            <script>
            'Anda Belum Login!'
            window.location='../';
            </script>";
    }
    else if($_SESSION['login']['hakakses'] != "Administrator"){
        header("Location: ../db/auth.php");
    }

    require('../db/koneksi.php');
    $id = $_GET['id'];
    $sql = "UPDATE tb_user SET konfirmasi=1 WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        //jika  berhasil langsung diarahkan kembali ke file bootstrap.php
        header('location:data_user_admin.php');
    } else {
        // jika gagal tampil ini
        echo "Gagal Melakukan Konfirmasi User: " . $conn->error;
    }
    $conn->close();
?>