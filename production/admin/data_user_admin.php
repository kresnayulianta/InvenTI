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

    <title>Data User</title>

    <!-- Bootstrap -->
    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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
          <div class="">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List User </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered" method="post">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Username</th>
                          <th>NIM</th>
                          <th>No Telp</th>
                          <th>Hak akses</th>
                          <th>Foto</th>
                          <th>Konfirmasi</th>
                          <th>Ubah Data</th>               
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          include '../db/koneksi.php';
                          $count=1;
                          $querytable = mysqli_query($conn, "SELECT id,firstname,lastname,username,nim,notelp,hakakses,konfirmasi,foto FROM tb_user");
                          while($row = mysqli_fetch_assoc($querytable))
                          { ?>
                        <tr>
                          <td><?php echo $count; ?></td>
                          <td><?php echo $row['firstname']; ?></td>
                          <td><?php echo $row['lastname']; ?></td>
                          <td><?php echo $row['username']; ?></td> 
                          <td><?php echo $row['nim']; ?></td>
                          <td><?php echo $row['notelp']; ?></td>
                          <td><?php echo $row['hakakses']; ?></td>
                          <td><img src=<?php echo "../images/".$row['foto']?> width='100' height='100'></td>
                          <td>
                            <?php
                              if($row['konfirmasi']==0){
                                ?>
                                  <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#bkonfirmasi" data-href="konfirmasi_user.php?username=<?php echo $row['username'] ;?>">Ya</a>
                                  <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" data-href="hapus_user.php?username=<?php echo $row['username'] ;?>">Hapus</a>
                                <?php
                              }else{
                                ?>
                                  <button type="button" class="btn btn-success btn-xs">Terkonfirmasi </button>
                                <?php
                              }
                            ?>
                          </td>
                          <td>
                            <a
                              class= "btn btn-default btn-xs"
                              data-toggle= "modal"
                              data-target = "#ubahuser"
                              data-href= "form_updateuser.php?username=<?php echo $row['username'];?>"
                              data-id="<?php echo $row['username'];?>">
                              Ubah Data User
                              </a>
                            </td>
                        </tr>
                        <?php $count++; } ?>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div id="bkonfirmasi" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Konfirmasi</h4>
                      </div>
                      <div class="modal-body">
                        <p>Anda Yakin untuk mengkonfirmasi akun ?</p>
                          <a type="button" class="btn btn-info">Ya</a>
                          <button type="button" class="btn btn-warning" data-dismiss="modal">Tidak</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div id="ubahuser" class="modal fade" role="dialog">
                  <div class="modal-dialog" role="document">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Ubah Data User</h4>
                      </div>
                      <div class="modal-body">
                        <div class="fetched-data"></div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div id="hapus" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Konfirmasi</h4>
                      </div>
                      <div class="modal-body">
                        <p>Anda Yakin untuk menghapus akun ?</p>
                          <a type="button" class="btn btn-primary">Ya</a>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                      </div>
                    </div>
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
    <!-- jquery.inputmask -->
    <script src="../../vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../../production/js/custom.min.js"></script>
    
    <script type="text/javascript">
      //konfirmasi user
      $(document).ready(function() {
          $('#bkonfirmasi').on('show.bs.modal', function(e) {
              $(this).find('.btn-info').attr('href', $(e.relatedTarget).data('href'));
          });
      });

      //hapus user
      $(document).ready(function() {
          $('#hapus').on('show.bs.modal', function(e) {
              $(this).find('.btn-primary').attr('href', $(e.relatedTarget).data('href'));
          });
      });
      
      //update data user
      $(document).ready(function(){
          $('#ubahuser').on('show.bs.modal', function (e) {
              var un = $(e.relatedTarget).data('id');
              //menggunakan fungsi ajax untuk pengambilan data
              $.ajax({
                  type : 'post',
                  url : 'form_updateuser.php',
                  data :  'username='+ un,
                  success : function(data){
                    $('.fetched-data').html(data);//menampilkan data ke dalam modal
                  }
              });
          });
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

    <script type="text/javascript">
      
    </script>
    
  </body>
</html>