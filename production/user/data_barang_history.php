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
  else if($_SESSION['login']['hakakses'] != "Peminjam"){
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

    <title>History Peminjaman Barang</title>

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
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>History Peminjaman Barang </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>NO</th>
                          <th>Kode Pinjam</th>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Tanggal Pinjam</th>
                          <th>Tanggal Kembali</th>
                          <th>PRINT</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          include '../db/koneksi.php';
                          $count      = 1;
                          $querytable = mysqli_query($conn, "SELECT kodepinjam,kodebarangpinjam,tglpinjam,tglkembali FROM tb_peminjaman WHERE namauserpinjam='$username'");
                          
                          while($row = mysqli_fetch_assoc($querytable)){
                        ?>
                            <tr>
                              <td><?php echo $count; ?></td>
                              <td><?php echo $row['kodepinjam']; ?></td>
                              <td><?php echo $row['kodebarangpinjam']; ?></td>
                              <td>
                                <?php
                                  $kodebpinjam = $row['kodebarangpinjam'];
                                  $querynamab = mysqli_query($conn, "SELECT namab FROM tb_barang WHERE kodeb='$kodebpinjam'");
                                  $datan      = mysqli_fetch_array($querynamab);
                                  $namab      = $datan['namab'];
                                  echo "$namab";
                                ?>
                              </td> 
                              <td><?php echo $row['tglpinjam']; ?></td>
                              <td><?php echo $row['tglkembali']; ?></td>
                              <td>
                                <a class="btn btn-default btn-xs" href="printpem.php?kodepinjam=<?php echo $row['kodepinjam']; ?>" > Print</a>
                              </td>
                            </tr>
                        <?php 
                            $count++; 
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
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
    <!-- iCheck -->
    <script src="../../vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="../../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../../vendors/pdfmake/build/vfs_fonts.js"></script>

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