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
	  
    <title>Form Peminjaman</title>

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
    <!-- bootstrap-datetimepicker -->
    <link href="../../vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

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
          <?php
            require('../db/koneksi.php');
            session_start();
            if(isset($_POST['submit'])){
              $kodebarang     = $conn -> real_escape_string($_POST['kodebarang']);
              $usernamepinjam = $username;
              $tanggalkembali2 = $conn -> real_escape_string($_POST['tanggalkembali']);
              
              $tglpinjam      = date('Y-m-d');
              $explodek       = explode('-',$tanggalkembali2);
              $tanggalkembali = date('Y-m-d', strtotime("$explodek[3]-$explodek[2]-$explodek[1]"));
              
              //check kodebarang apakah ada atau tidak
              $queryckb = mysqli_query($conn, "SELECT kodeb FROM  tb_barang WHERE kodeb='$kodebarang'");

              if(mysqli_num_rows($queryckb) == 1){
                $tglkp = date("Ymd");
                //membaca kode anggota terbesar berdasarkan jenis keanggotaan
                $querymax = mysqli_query($conn, "SELECT max(kodepinjam) as maxkodep FROM tb_peminjaman WHERE kodepinjam LIKE '$tglkp%'");
                $datamax = mysqli_fetch_array($querymax);
                $kdpMax = $datamax['maxkodep'];
                
                if($datamax){
                  //mengambil angka atau bilangan dalam kode barang terbesar, dengan cara mengambil substring mulai dari karakter ke-2
                  //diambil 4 karakter, misal 'KS0001', akan diambil '0001' setelah substring bilangan diambil, di casting jadi integer
                  $noUrut = (int) substr($kdpMax, 2, 4);

                  //bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
                  $noUrut++;
    
                  //membentuk kode barang baru
                  //perintah sprintf("%04s", $noUrut); digunakan untuk memformat string sebanyak 5 karakter
                  //misal sprintf("%05s", 12); maka akan dihasilkan '00012'
                  //misal sprintf("%05s", 1); akan dihasilkan string '00001'
                  $kodepinjam = $tglkp . sprintf("%04s", $noUrut);
                }else{
                  $kodepinjam = $tglkp . sprintf("%04s", 0001);
                }
                  
                $query = mysqli_query($conn, "INSERT INTO tb_peminjaman (id,kodepinjam, kodebarangpinjam, namauserpinjam, tglpinjam, tglkembali) VALUES (null,'$kodepinjam','$kodebarang','$usernamepinjam','$tglpinjam','$tanggalkembali')");
                if($query){
                  echo "<script> alert('Barang sudah bisa dipinjam. Terima Kasih.')</script>";
                }
              }else{
                echo "<script> alert('Kode Barang tidak ada. Terima Kasih.')</script>";
              }
              
              $conn->close();
            } 
          ?>
          <div class="">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Peminjaman</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="form-pinjam" data-parsley-validate class="form-horizontal form-label-left" method="POST">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kodebarang">Kode Barang <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="kodebarang" name="kodebarang" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usernamepinjam">Username Peminjam &nbsp</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control" readonly="readonly" value="<?php echo "$username";?>" class="form-control col-md-7 col-xs-12" id="usernamepinjam" name="usernamepinjam" >
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tglpinjam">Tanggal Pinjam &nbsp
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="tglpinjam" name="tglpinjam" required="required" readonly="readonly" class="form-control col-md-7 col-xs-12" Value="<?php echo date("d-m-Y")?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggalkembali">Tanggal Kembali  <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="input-group date" id="tanggalkembali">
                            <input type="text" class="form-control col-md-7 col-xs-12" readonly="readonly" name="tanggalkembali"/>
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                          </div>
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
    <!-- bootstrap-datetimepicker -->    
    <script src="../../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
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

    <!-- Initialize datetimepicker -->
    <script>
      $('#tanggalkembali').datetimepicker({
          ignoreReadonly: true,
          allowInputToggle: true,
          format: 'DD-MM-YYYY'
      });
    </script>

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