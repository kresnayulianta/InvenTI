<?php
  date_default_timezone_set('Asia/Jakarta');
  session_start();
  error_reporting(0);
  if (empty($_SESSION['login']['hakakses'])) {
    echo "
      <script>
        'Anda Belum Login!'
        window.location='/';
      </script>";
  }else if($_SESSION['login']['hakakses'] || empty($_SESSION['login']['hakakses'])){
    header("Location: db/auth.php");
  }
?>
<script>
function jin_date_sql($date){
	$exp = explode('/',$date);
	if(count($exp) == 3) {
		$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
	}
	return $date;
}

function jin_date_str($date){
	$exp = explode('-',$date);
	if(count($exp) == 3) {
		$date = $exp[2].'/'.$exp[1].'/'.$exp[0];
	}
	return $date;
}
</script>
<?php

//Convert dari tanggal DD/MM/YYYY ke YYYY-MM-DD untuk insert ke database mysql
$data_tanggal_form = "23/02/2009"; // DD/MM/YYYY
$data_tanggal_mysql = jin_date_sql($data_tanggal_form); // hasilnya: 2009-01-01 = YYYY-MM-DD

//Convert dari tanggal YYYY-MM-DD ke DD/MM/YYYY untuk tampil ambil dari database mysql
$data_tanggal_db = "2009-01-01"; // YYYY-MM-DD
$data_tanggal_tampil = jin_date_str($data_tanggal_db); // hasilnya: 23/02/2009 = DD/MM/YYYY
?>