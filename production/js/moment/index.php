<?php
  date_default_timezone_set('Asia/Jakarta');
  session_start();
  error_reporting(0);
  if (empty($_SESSION['login']['hakakses'])) {
    echo "
      <script>
        'Anda Belum Login!'
        window.location='../../';
      </script>";
  }else if($_SESSION['login']['hakakses'] || empty($_SESSION['login']['hakakses'])){
    header("Location: ../db/auth.php");
  }
?>