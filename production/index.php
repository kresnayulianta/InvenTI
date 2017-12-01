<?php
  date_default_timezone_set('Asia/Jakarta');
  session_start();
  error_reporting(0);
?>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inventaris HIMTI Unesa</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="css/custom.min.css" rel="stylesheet">
    
  </head>
  <center><img width=70% height=70% src='images/JTIF.jpg' /><center>
                <div>
                  <center><h1>APLIKASI INVENTARIS BARANG HIMTI UNESA</h1></center>
                  <center><h2>Sebuah aplikasi Untuk mempermudah transaksi peminjaman dan pengembalian barang yang menjadi inventaris dari HIMTI UNESA</h2></center>
                  </div>
              </div>
            </form>
  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <?php 
            require('db/koneksi.php');
            if(isset($_POST['login'])){
              $lusername = $_POST['loginusername'];
              $lpassword = $_POST['loginpassword'];
              $lpassword = md5($lpassword);
              $resultlogin = mysqli_query($conn, "SELECT username, hakakses, konfirmasi, foto FROM tb_user Where username='$lusername' AND password='$lpassword'");
              $lrows = mysqli_num_rows($resultlogin);
              if($lrows == 1){
                $data = mysqli_fetch_array($resultlogin);
                $_SESSION['login']['username']  = $data['username'];
                $_SESSION['login']['hakakses']  = $data['hakakses'];
                $_SESSION['login']['konfirmasi']= $data['konfirmasi'];
                if(empty($data['foto'])){
                  $_SESSION['login']['foto'] = "user.png";
                }else{
                  $_SESSION['login']['foto'] = $data['foto'];
                }
                
                if($data['konfirmasi'] == 0){
                  ?>
                    <div class="alert alert-danger fade in">
                      <a href="#signin" class="close" data-dismiss="alert">&times;</a>
                      <strong>Error!</strong> Maaf Akun anda belum terkonfirmasi mohon hubungi administrator. Terima Kasih.
                    </div>
                  <?php
                  session_destroy();
                }else{
                  header("Location:db/auth.php");
                }
              }
              else{
                ?>
                  <div class="alert alert-danger fade in">
                    <a href="#signin" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> Username atau Password salah.
                  </div>
                <?php
              }
              $conn -> close();
            }
          ?>
          <section class="login_content">
            <form action="" method="post">
              <h1>Login</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" name="loginusername" id="loginusername" required="">
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="loginpassword" id="loginpassword" required="">
              </div>
              <div>
                <button button="btn btn-default submit" type="submit" name="login" value="Login" >Log in</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                <center><h2>Aturan Peminjaman Inventaris HIMTI UNESA</h2></center>
                 <p>1. Merupakan Warga Teknik Informatika ditunjukkan dengan kartu Identitas</p>
                    <p>2. Mengisi data-data user untuk bisa mengakses aplikasi Web inventaris barang</p>
                    <p>3. Peminjaman harus dilakukan sesuai jadwal yang ada.</p>
                    <p>4. Peminjam harus datang sendiri dalam proses peminjaman.</p>
                    <p>5. Keterlambatan pengembalian akan dikenakan denda sebesar Rp 1000,00/hari.</p>
                    <p>6. Apabila Barang yang dipinjam rusak atau hilang, wajib mengganti Barang yang sama</p>
                    <br>
                    <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <p>©2017 All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <?php
            if(isset($_POST['submit'])){
              $firstname  = $conn -> real_escape_string($_POST['sfirstname']);
              $lastname   = $conn -> real_escape_string($_POST['slastname']);
              $username   = $conn -> real_escape_string($_POST['susername']);
              $password   = $conn -> real_escape_string($_POST['spassword']);
              $password   = md5($password);
              $nim        = $conn -> real_escape_string($_POST['snim']);
              $notelp     = $conn -> real_escape_string($_POST['snotelp']);
              $hakakses   = $conn -> real_escape_string("Peminjam");
              $konfirmasi = $conn -> real_escape_string("0");
              
              $firstname  = strtolower($firstname);
              $firstname  = ucwords($firstname);
              $lastname   = strtolower($lastname);
              $lastname   = ucwords($lastname);

              // get uploaded file name              
              $image = $_FILES['uploadfoto']['name'];
              
              if( empty( $image ) ) {
                echo "<script> alert('File is empty, please select image to upload.')</script>";
              } else if($_FILES['uploadfoto']['type'] == "application/msword") {
                echo "<script> alert('Invalid image type, use (e.g. png, jpg, gif).')</script>";
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
                  imagejpeg( $dst, 'images/'.$new_name, 100 );
                          
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
              $conn->close();
            }
          ?>
          <section class="login_content">
            <form name="" action="" method="post" enctype="multipart/form-data">
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="First Name" name="sfirstname" required/>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Last Name" name="slastname" required/>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Username" name="susername" required/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="spassword" required/>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="NIM" name="snim" required/>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="No Telp" name="snotelp" required/>
              </div>
              <div>
                <input type="file" class="form-control" name="uploadfoto" id="uploadfoto" require>
              </div>
              <div>
                <button class="btn btn-default submit" type="submit" name="submit" value="Submit">Submit</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>
                <div class="clearfix"></div>
                <br />
                <div>
                <p>1. Merupakan Warga Teknik Informatika ditunjukkan dengan kartu Identitas</p>
                    <p>2. Mengisi data-data user untuk bisa mengakses aplikasi Web inventaris barang</p>
                    <p>3. Peminjaman harus dilakukan sesuai jadwal yang ada.</p>
                    <p>4. Peminjam harus datang sendiri dalam proses peminjaman.</p>
                    <p>5. Keterlambatan pengembalian akan dikenakan denda sebesar Rp 1000,00/hari.</p>
                    <p>6. Apabila Barang yang dipinjam rusak atau hilang, wajib mengganti Barang yang sama</p>
                    <br>
                    <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <p>©2017 All Rights Reserved. </p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
    
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.js"></script>
  </body>
</html>


