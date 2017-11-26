<?php
    session_start();
    if(!isset($_SESSION['login']['username'])){
        header("Location: ../");
        exit(); 
    } else if($_SESSION['login']['hakakses']=="administrator" || $_SESSION['login']['hakakses']=="Administrator"){
        header("Location: ../admin/index_admin.php");
        exit();
    } else if($_SESSION['login']['hakakses']=="kahima" || $_SESSION['login']['hakakses']=="Kahima"){
        header("Location: ../kahima/index_kahima.php");
        exit();
    } else if($_SESSION['login']['hakakses']=="peminjam" || $_SESSION['login']['hakakses']=="Peminjam"){
        header("Location: ../user/index_user.php");
        exit();
    }
?>