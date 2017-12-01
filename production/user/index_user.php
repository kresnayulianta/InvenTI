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
  }else if($_SESSION['login']['hakakses'] != "Peminjam"){
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

    <title>Home</title>

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
  </head>

  <body class="nav-md">
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
      $foto  = $_SESSION['login']['foto'];
      $qbarangada = mysqli_query($conn, "SELECT * FROM tb_barang WHERE statusb='Ada'"); //query untuk barang yang ada di db
      $tbarangada = mysqli_num_rows($qbarangada); //query untuk total barang yang ada di db
      $qbaranguser = $querytable = mysqli_query($conn, "SELECT * FROM tb_peminjaman WHERE namauserpinjam='$username'"); //query untuk mengambil data peminjaman yang dipinjam oleh user
      $tbaranguser = mysqli_num_rows($qbaranguser); //query untuk total barang yang dipinjam oleh user
      $dateharini  = date("Y-m-d"); //tanggal sesuai tanggal pc
      $qbarangharini = mysqli_query($conn, "SELECT * FROM tb_peminjaman WHERE tglpinjam='$dateharini'"); //query untuk mengambil data peminjaman sesuai hari
      $tbarangharini = mysqli_num_rows($qbarangharini); //query untuk total barang yang diseleksi hari
    ?>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index_user.php" class="site_title"><span>Inventaris HIMTI</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src=<?php echo "../images/".$foto ?> alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php
                    echo "$fname"." "."$lname";
                  ?></h2>
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
                    <a href="index_user.php">
                      <i class="fa fa-home"></i>
                      Home
                    </a>
                  </li>
                  <li>
                    <a href="data_barang_user.php">
                      <i class="fa fa-shopping-basket"></i>
                      Data Barang
                    </a>
                  </li>
                  <li>
                    <a href="form_peminjaman.php">
                      <i class="fa fa-pencil"></i>
                      Form Peminjaman
                    </a>
                  </li>
                  <li>
                    <a href="data_barang_history.php">
                      <i class="fa fa-history"></i>
                        History Peminjaman 
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="../db/logout.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen" data-original-title="Fullscreen" onclick="toggleFull()">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src=<?php echo "../images/".$foto ?> alt=""><?php
                    echo "$fname"." "."$lname";
                  ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="../db/logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
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
                <span class="count_top"><i class="fa fa-shopping-basket"></i> Jumlah Barang Yang Bisa <br>Dipinjam</span>
                <div class="count"><?php echo "$tbarangada";?></div>
              </div>
              <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-shopping-basket"></i> Jumlah Barang Yang Sudah <br>Dipinjam</span>
                <div class="count"><?php echo "$tbaranguser";?></div>
              </div>
              <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-shopping-basket"></i> Total Pinjaman Hari Ini <br>&nbsp</span>
                <div class="count"><?php echo "$tbarangharini";?></div>  
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Selamat Datang User <?php
                    echo "$fname"." "."$lname";
                  ?></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      Jangan lupa bahagia yaa
                  </div>
                </div>
              </div>
            </div>
          </div>
         <!-- /top tiles -->
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

    <script>
      function toggleFull() {
        var elem = document.documentElement; // Make the body go full screen.
        var isInFullScreen = (document.fullScreenElement && document.fullScreenElement !== null) ||  (document.mozFullScreen || document.webkitIsFullScreen);

        if (isInFullScreen) {
          exitFullscreen();
        } else {
          launchIntoFullscreen(elem);
        }
        return false;
      }

      function launchIntoFullscreen(element) {
        if(element.requestFullscreen) {
          element.requestFullscreen();
        } else if(element.mozRequestFullScreen) {
          element.mozRequestFullScreen();
        } else if(element.webkitRequestFullscreen) {
          element.webkitRequestFullscreen();
        } else if(element.msRequestFullscreen) {
          element.msRequestFullscreen();
        }
      }
      
      function exitFullscreen() {
        if(document.exitFullscreen) {
          document.exitFullscreen();
        } else if(document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if(document.webkitExitFullscreen) {
          document.webkitExitFullscreen();
        }
      }
    </script>
  </body>
</html>
