<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inventaris HIMTI Unesa | </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <?php 
      require('db/koneksi.php');
      if(isset($_POST['login'])){
        session_start();
        $lusername = $_POST['loginusername'];
        $lpassword = $_POST['loginpassword'];
        $lpassword = md5($lpassword);
        $resultlogin = mysqli_query($conn, "SELECT username,hakakses FROM tb_user Where username='$lusername' AND password='$lpassword'");
        $lrows = mysqli_num_rows($resultlogin);
        if($lrows == 1){
          $data = mysqli_fetch_array($resultlogin);
          $_SESSION['hakakses']  = $data['hakakses'];
          header("Location:db/auth.php");
        }
        else{
          $error = "Username or Password is Invalid";
        }
      }
      else if(isset($_POST['submit'])){
      $firstname  = $conn -> real_escape_string($_POST['sfirstname']);
      $lastname   = $conn -> real_escape_string($_POST['slastname']);
      $username   = $conn -> real_escape_string($_POST['susername']);
      $password   = $conn -> real_escape_string($_POST['spassword']);
      $password   = md5($password);
      $nim        = $conn -> real_escape_string($_POST['snim']);
      $notelp     = $conn -> real_escape_string($_POST['snotelp']);
      $hakakses   = $conn -> real_escape_string("peminjam");
        
      //check username has been taken or not
      $sql = "SELECT username FROM tb_user WHERE username='$username'";
      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        
      if(mysqli_num_rows($result) == 1){
        echo "Sorry...This username already exist..";
      }
      else{
        $query = mysqli_query($conn, "INSERT INTO tb_user(id, firstname, lastname, username, password, nim, notelp, hakakses) VALUES (null,'$firstname','$lastname','$username','$password','$nim','$notelp','$hakakses')");
        if($query){
          echo "Thank You! you are now registered.";
        }
      }

      $conn->close();
    }
    ?>
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
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
                  <h1><i class="fa fa-paw"></i> HIMTI Unesa</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form name="" action="" method="post">
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
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
