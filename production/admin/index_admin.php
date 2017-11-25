<!DOCTYPE html>
<?php
  date_default_timezone_set('Asia/Jakarta');
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
?>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard Admin</title>

    <!-- Bootstrap -->
    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="../../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../../production/css/custom.min.css" rel="stylesheet">

    <script type="text/javascript">        
      function tampilkanwaktu(){         //fungsi ini akan dipanggil di bodyOnLoad dieksekusi tiap 1000ms = 1detik    
        var waktu = new Date();            //membuat object date berdasarkan waktu saat 
        var sh = waktu.getHours() + "";    //memunculkan nilai jam, //tambahan script + "" supaya variable sh bertipe string sehingga bisa dihitung panjangnya : sh.length    //ambil nilai menit
        var sm = waktu.getMinutes() + "";  //memunculkan nilai detik    
        var ss = waktu.getSeconds() + "";  //memunculkan jam:menit:detik dengan menambahkan angka 0 jika angkanya cuma satu digit (0-9)
        document.getElementById("clock").innerHTML = (sh.length==1?"0"+sh:sh) + ":" + (sm.length==1?"0"+sm:sm) + ":" + (ss.length==1?"0"+ss:ss);
      }
    </script>
  </head>

  <body class="nav-md" onload="tampilkanwaktu();setInterval('tampilkanwaktu()', 1000);">
    <?php
      include '../db/koneksi.php';
      $username = $_SESSION['login']['username'];
      $queryindex = mysqli_query($conn, "SELECT firstname,lastname,nim FROM tb_user Where username='$username'");
      $data = mysqli_fetch_array($queryindex);
      $_SESSION['login']['firstname'] = $data['firstname'];
      $_SESSION['login']['lastname']  = $data['lastname'];
      $_SESSION['login']['nim']       = $data['nim'];
      $fname = $_SESSION['login']['firstname'];
      $lname = $_SESSION['login']['lastname'];
      $nim   = $_SESSION['login']['nim'];
      $queryuser = mysqli_query($conn, "SELECT * FROM tb_user ");
      $totaluser = mysqli_num_rows($queryuser);
      $querybarang = mysqli_query($conn, "SELECT * FROM tb_barang ");
      $totalbarang = mysqli_num_rows($querybarang);
      $dateharini  = date("Y-m-d"); //tanggal sesuai tanggal pc
      $qbarangharini = mysqli_query($conn, "SELECT * FROM tb_peminjaman WHERE tglpinjam='$dateharini'"); //query untuk mengambil data peminjaman sesuai hari
      $tbarangharini = mysqli_num_rows($qbarangharini); //query untuk total barang yang diseleksi hari
    ?>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index_admin.php" class="site_title"><span>Inventaris HIMTI</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="../images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>
                  <?php
                    echo "$fname"." "."$lname";
                  ?>
                </h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu</h3>
                <ul class="nav side-menu">
                  <li>
                    <a href="index_admin.php">
                      <i class="fa fa-home"></i>
                      Home
                    </a>
                  </li>
                  <li>
                    <a href="data_barang_admin.php">
                      <i class="fa fa-shopping-basket"></i>
                      Data Barang
                    </a>
                  </li>
                  <li>
                    <a href="data_user_admin.php">
                      <i class="fa fa-user"></i>
                      Data User
                    </a>
                  </li>
                  <li>
                    <a href="form_registrasiuser.php">
                      <i class="fa fa-pencil"></i>
                        Form Registrasi User
                    </a>
                  </li>
                  <li>
                    <a href="form_tambahbarang.php">
                      <i class="fa fa-pencil"></i>
                        Form Tambah Barang
                    </a>
                  </li>
                  <li>
                    <a href="form_pengembalian.php">
                      <i class="fa fa-pencil"></i>
                        Form Pengembalian
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu" >
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="../images/img.jpg" alt="">
                    <?php
                      echo "$fname"." "."$lname";
                    ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><a href="../db/logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
                <li class="middle" style="">
                  <?php
                    $hari = date('l');
                      if ($hari=="Sunday") {
                      echo "Minggu";
                      }elseif ($hari=="Monday") {
                      echo "Senin";
                      }elseif ($hari=="Tuesday") {
                      echo "Selasa";
                      }elseif ($hari=="Wednesday") {
                      echo "Rabu";
                      }elseif ($hari=="Thursday") {
                      echo("Kamis");
                      }elseif ($hari=="Friday") {
                      echo "Jum'at";
                      }elseif ($hari=="Saturday") {
                      echo "Sabtu";
                      }
                  ?>,
                    
                  <?php
                    $tgl =date('d');
                    echo $tgl;
                    $bulan =date('F');
                    if ($bulan=="January") {
                     echo " Januari ";
                    }elseif ($bulan=="February") {
                     echo " Februari ";
                    }elseif ($bulan=="March") {
                     echo " Maret ";
                    }elseif ($bulan=="April") {
                     echo " April ";
                    }elseif ($bulan=="May") {
                     echo " Mei ";
                    }elseif ($bulan=="June") {
                     echo " Juni ";
                    }elseif ($bulan=="July") {
                     echo " Juli ";
                    }elseif ($bulan=="August") {
                     echo " Agustus ";
                    }elseif ($bulan=="September") {
                     echo " September ";
                    }elseif ($bulan=="October") {
                     echo " Oktober ";
                    }elseif ($bulan=="November") {
                     echo " November ";
                    }elseif ($bulan=="December") {
                     echo " Desember ";
                    }
                    $tahun=date('Y');
                    echo $tahun;
                  ?>
                    <span id="clock"></span>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Dashboard User</h3>
              </div>
            </div>
    
            <div class="clearfix"></div>
            
            <!-- top tiles -->
            <div class="row tile_count">
              <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-shopping-basket"></i> Jumlah Barang</span>
                <div class="count"><?php echo "$totalbarang";?></div>
              </div>
              <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Jumlah User</span>
                <div class="count"><?php echo "$totaluser";?></div>
              </div>
              <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-shopping-cart"></i> Total Pinjaman Hari Ini</span>
                <div class="count"><?php echo "$tbarangharini ";?></div>  
              </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Selamat Datang Admin <?php echo "$fname"." "."$lname";?></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    Jangan Lupa Bahagia Ya
                  </div>
                </div>
              </div>
            </div>        
            <!-- /top tiles -->
          </div>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../../vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../../vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../../vendors/Flot/jquery.flot.js"></script>
    <script src="../../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../../vendors/moment/min/moment.min.js"></script>
    <script src="../../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../../production/js/custom.min.js"></script>

    <style>
      li.middle {
        padding-top:20px;
        float:left;
        margin:0;
        width:207px;
      }
    </style>
  </body>
</html>