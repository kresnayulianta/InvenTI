<?php
  session_start();
  error_reporting(0);
  if (empty($_SESSION['login']['hakakses'])) {
    echo "
      <script>
        'Anda Belum Login!'
        window.location='../';
      </script>";
  }else if($_SESSION['login']['hakakses'] != "Kahima"){
    header("Location: ../db/auth.php");
  }
?>