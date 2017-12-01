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
	  
    <title>Form Pengembalian</title>

    <!-- Bootstrap -->
    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="../../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="../../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="../../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="../../vendors/starrr/dist/starrr.css" rel="stylesheet">
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
              <a href="index_admin.php" class="site_title"><span>Inventaris HIMTI</span></a>
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
                  <a href="data_pengembalian_admin.php">
                    <i class="fa fa-table"></i>
                    Data Pengembalian
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
          <?php
            require('../db/koneksi.php');
            if(isset($_POST['submit'])){              
              $kodepinjam = $conn -> real_escape_string($_POST['kodepinjam']);
              $tglkembali = date("Y-m-d");
              $keadaan = $conn -> real_escape_string($_POST['keadaan']);
              $konfirmasi = "1";
              
              if($keadaan == "Sangat Baik" || $keadaan == "Baik" || $keadaan == "Cukup"){
                $statusb = "Ada";
              } else if($keadaan == "Rusak" ||$keadaan == "Sangat Rusak"){
                $statusb = "Tidak Ada";
              }
              //check kodepinjam apakah ada atau tidak
              $queryckp = mysqli_query($conn, "SELECT kodepinjam FROM tb_peminjaman WHERE kodepinjam='$kodepinjam'");
              
              if(mysqli_num_rows($queryckp) == 1){
                $tglkk = date("Ymd");
                //membaca kode anggota terbesar berdasarkan jenis keanggotaan
                $querymax = mysqli_query($conn, "SELECT max(kodekembali) as maxkodek FROM tb_kembali WHERE kodekembali LIKE '$tglkk%'");
                $datamax = mysqli_fetch_array($querymax);
                $kdkMax = $datamax['maxkodek'];
                              
                if($datamax){
                  //mengambil angka atau bilangan dalam kode barang terbesar, dengan cara mengambil substring mulai dari karakter ke-2
                  //diambil 4 karakter, misal 'KS0001', akan diambil '0001' setelah substring bilangan diambil, di casting jadi integer
                  $noUrut = (int) substr($kdkMax, 2, 4);
                  
                  //bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
                  $noUrut++;
                  
                  //membentuk kode barang baru
                  //perintah sprintf("%04s", $noUrut); digunakan untuk memformat string sebanyak 5 karakter
                  //misal sprintf("%05s", 12); maka akan dihasilkan '00012'
                  //misal sprintf("%05s", 1); akan dihasilkan string '00001'
                  $kodekembali = $tglkk . sprintf("%04s", $noUrut);
                }else{
                  $kodekembali = $tglkk . sprintf("%04s", 0001);
                }
                                
                $querykembali = mysqli_query($conn, "INSERT INTO tb_kembali (id,kodekembali,kodepinjam,kondisibarangk,tglkembali) VALUES (null,'$kodekembali','$kodepinjam','$keadaan','$tglkembali')");
                $querykonf = mysqli_query($conn,"UPDATE tb_peminjaman SET konfirmasi='$konfirmasi'");
                $querystatus = mysqli_query($conn,"UPDATE tb_barang SET statusb='$statusb'");
                if($querykembali && $querykonf){
                  echo "<script> alert('Data barang kembali sudah masuk sistem. Terima Kasih.')</script>";
                }else{
                  echo "<script> alert('Ada yang salah. Terima Kasih.')</script>";
                }
              }else{
                echo "<script> alert('Kode Pinjam tidak ada. Terima Kasih.')</script>";
              }
            }
          ?>
          <div class="">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Pengembalian Barang</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kodepinjam">Kode Peminjaman <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="kodepinjam" name="kodepinjam" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tglkembali">Tanggal Kembali <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="tglkembali" name="tglkembali" required="required" readonly="readonly" class="form-control col-md-7 col-xs-12" value=<?php echo date("d-m-Y");?>>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Keadaan <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control col-md-7 col-xs-12" required="required" name="keadaan">
                            <option>Sangat Baik</option>
                            <option>Baik</option>
                            <option>Cukup</option>
                            <option>Rusak</option>
                            <option>Sangat Rusak</option>
                          </select>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						              <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success" name="submit">Submit</button>
                        </div>
                      </div>
                    </form>
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
    <!-- bootstrap-progressbar -->
    <script src="../../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../../vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../../vendors/moment/min/moment.min.js"></script>
    <script src="../../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="../../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../../vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="../../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="../../vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="../../vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="../../vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="../../vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="../../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="../../vendors/starrr/dist/starrr.js"></script>
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
