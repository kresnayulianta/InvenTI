<?php
  date_default_timezone_set('Asia/Jakarta');
  error_reporting(0);
  if (empty($_SESSION['login']['hakakses'])) {
    echo "
      <script>
        'Anda Belum Login!'
        window.location='production/index.php';
      </script>";
  }
?>