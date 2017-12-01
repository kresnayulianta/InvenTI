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

  include '../db/koneksi.php';
  if($_POST['username']) {
    $username = $_POST['username'];
    // mengambil data berdasarkan username
    $result = mysqli_query($conn, "SELECT firstname,lastname,nim,notelp,hakakses,konfirmasi,foto FROM tb_user WHERE username='$username'");
    $dataa = mysqli_fetch_array($result);
    
    ?>
    <form id="form-registuser" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="update_user.php">
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" id="username" name="username" readonly="readonly" class="form-control col-md-7 col-xs-12" value="<?php echo $username?>">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ufn">First Name</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" id="ufn" name="ufn" class="form-control col-md-7 col-xs-12" value="<?php echo "".$dataa['firstname']?>">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uln">Last Name</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" id="uln" name="uln"class="form-control col-md-7 col-xs-12" value="<?php echo "".$dataa['lastname']?>">
        </div>
      </div>
      <div class="form-group">
        <label for="pass" class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="checkbox" name="ubah_password" value="true">Ceklist jika ingin mengubah password<br/>
          <input id="pass" class="form-control col-md-7 col-xs-12" type="password" name="pass">
        </div>
      </div>           
      <div class="form-group">
        <label for="nim" class="control-label col-md-3 col-sm-3 col-xs-12">NIM</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input id="nim" type="text" class="form-control col-md-7 col-xs-12" data-inputmask="'mask':'99999999999'" name="nim" value="<?php echo "".$dataa['nim']?>">
        </div>
      </div>
      <div class="form-group">
        <label for="notelp" class="control-label col-md-3 col-sm-3 col-xs-12">No Telp</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input id="notelp" type="text" class="form-control col-md-7 col-xs-12" name="notelp" value="<?php echo "".$dataa['notelp']?>">
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
        <label for="uploadfoto" class="control-label col-md-3 col-sm-3 col-xs-12">Foto</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="checkbox" name="ubah_foto" value="true">Ceklist jika ingin mengubah foto<br/>
          <input type="file" class="form-control col-md-7 col-xs-12" name="uploadfoto">
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-success" name="submit">Submit</button>
        </div>
      </div>
    </form>
    <?php            
  }
  $conn->close();
?>