<!DOCTYPE html>
<?php
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
	  
    <title>Form Registrasi User</title>

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
      $querydatauser = mysqli_query($conn, "SELECT firstname,lastname,nim FROM tb_user Where username='$username'");
      $data = mysqli_fetch_array($querydatauser);
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
            error_reporting(0);
            require('../db/koneksi.php');
            if(isset($_POST['submit'])){
              $firstname  = $conn -> real_escape_string($_POST['first-name']);
              $firstname  = strtolower($firstname);
              $firstname  = ucwords($firstname);
              
              $lastname   = $conn -> real_escape_string($_POST['last-name']);
              $lastname   = strtolower($lastname);
              $lastname   = ucwords($lastname);

              $username   = $conn -> real_escape_string($_POST['username']);

              $password   = $conn -> real_escape_string($_POST['password']);
              $password   = md5($password);

              $nim        = $conn -> real_escape_string($_POST['nim']);
              $notelp     = $conn -> real_escape_string($_POST['notelp']);
              $hakakses   = $conn -> real_escape_string($_POST['hakakses']);
              $konfirmasi = $conn -> real_escape_string("1");

              // get uploaded file name              
              $image = $_FILES['uploadfoto']['name'];

              if( empty( $image ) ) {
                echo "<script> alert('File is empty, please select image to upload.')</script>";
              } else if($_FILES['uploadfoto']['type'] == "application/msword") {
                echo "<script> alert('Invalid image type, use (e.g. png, jpg, gif).')</script>";
              } else if($_FILES['uploadfoto']['size'] > 2048) {
                echo "<script> alert('File lebih dari 2MB')</script>";
              } else if( $_FILES['uploadfoto']['error'] > 0 ) {
                echo "<script> alert('Oops sorry, seems there is an error uploading your image, please try again later.')</script>";
              } else {
            
                // strip file slashes in uploaded file, although it will not happen but just in case 
                $filename = stripslashes( $_FILES['uploadfoto']['name'] );
                $ext = end(explode( ".", $filename ));
                $ext = strtolower( $ext );
                
                if(( $ext != "jpg" ) && ( $ext != "jpeg" ) && ( $ext != "png" ) && ( $ext != "gif" ) ) {
                  echo "<script> alert('Unknown Image extension.')</script>";
                  return false;
                } else {
                  // get uploaded file size
                  $size = filesize( $_FILES['uploadfoto']['tmp_name'] );
            
                  // get php ini settings for max uploaded file size
                  $max_upload = ini_get( 'upload_max_filesize' );
                  
                  // check if we're able to upload lessthan the max size
                  if( $size > $max_upload ){
                    echo "<script> alert('You have exceeded the upload file size.'error)</script>";
                  }

                  // check uploaded file extension if it is jpg or jpeg, otherwise png and if not then it goes to gif image conversion
                  $uploaded_file = $_FILES['uploadfoto']['tmp_name'];
                  if( $ext == "jpg" || $ext == "jpeg" )
                    $source = imagecreatefromjpeg( $uploaded_file );
                  else if( $ext == "png" )
                    $source = imagecreatefrompng( $uploaded_file );
                  else
                    $source = imagecreatefromgif( $uploaded_file );
            
                  // getimagesize() function simply get the size of an image
                  list( $width, $height) = getimagesize($uploaded_file);
                  $ratio = $height / $width;
            
                  // new width 50(this is in pixel format)
                  $nw = 128;
                  $nh = ceil( $ratio * $nw );
                  //$dst = imagecreatetruecolor( $nw, $nh );
                  $dst = imagecreatetruecolor( $nw, $nw );
        
                  //imagecopyresampled( $dst, $source, 0, 0, 0,0, $nw, $nh, $width, $height );
                  imagecopyresampled( $dst, $source, 0, 0, 0,0, $nw, $nw, $width, $height );
            
                  // rename our upload image file name, this to avoid conflict in previous upload images
                  // to easily get our uploaded images name we added image size to the suffix
                  $new_name = $username .".".$ext;
            
                  // move it to uploads dir with full quality
                  imagejpeg( $dst, '../images/'.$new_name, 100 );
            
                  // I think that's it we're good to clear our created images
                  imagedestroy( $source );
                  imagedestroy( $dst );

                  //check username has been taken or not
                  $sql = "SELECT username FROM tb_user WHERE username='$username'";
                  $result = mysqli_query($conn,$sql);
                  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                      
                  if(mysqli_num_rows($result) == 1){
                      echo "<script> alert('Maaf Username telah terpakai, Coba ganti yang lain. Terima Kasih.')</script>";
                  }else{
                    $query = mysqli_query($conn, "INSERT INTO tb_user(id, firstname, lastname, username, password, nim, notelp, hakakses,konfirmasi,foto) VALUES (null,'$firstname','$lastname','$username','$password','$nim','$notelp','$hakakses','$konfirmasi','$new_name')");
                    if($query){
                      echo "<script> alert('Username telah terdaftar. Terima Kasih.')</script>";
                    }
                  }
                }
              }
            } 
          ?>
          <div class="">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Registrasi User</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="form-registuser" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="last-name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="username" class="control-label col-md-3 col-sm-3 col-xs-12">Username <span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="username" class="form-control col-md-7 col-xs-12" type="text" name="username" required="required">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Password <span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="password" class="form-control col-md-7 col-xs-12" type="password" name="password" required="required">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="nim" class="control-label col-md-3 col-sm-3 col-xs-12">NIM <span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="nim" type="text" class="form-control col-md-7 col-xs-12" data-inputmask="'mask':'99999999999'"  name="nim" required="required" >
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="notelp" class="control-label col-md-3 col-sm-3 col-xs-12">No Telp <span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="notelp" type="text" class="form-control col-md-7 col-xs-12" name="notelp" required="required" >
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Hak Akses User</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control col-md-7 col-xs-12" name="hakakses">
                            <option>Administrator</option>
                            <option>Peminjam</option>
                            <option>Kahima</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="uploadfoto" class="control-label col-md-3 col-sm-3 col-xs-12">Foto <span class="required">*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" class="form-control col-md-7 col-xs-12" name="uploadfoto" id="uploadfoto" required="required" >
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
    <!-- jquery.inputmask -->
    <script src="../../vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
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
