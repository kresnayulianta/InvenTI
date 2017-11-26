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
    $username = $_GET['username'];
    $queryu = mysqli_query($conn, "DELETE FROM tb_user WHERE username='$username'");
    if ($queryu) {
        //jika  berhasil langsung diarahkan kembali ke file/
        header('location:data_user_admin.php');
    } else {
        // jika gagal tampil ini
        echo "Gagal Melakukan Konfirmasi User: " . $conn->error;
    }
    $conn->close();
?>