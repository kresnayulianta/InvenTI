<?php
  include '../db/koneksi.php';
  date_default_timezone_set('Asia/Jakarta');
  $kodepinjam = $_GET['kodepinjam'];
  $res = mysqli_query($conn,"SELECT kodepinjam, kodebarangpinjam, namauserpinjam, tglpinjam, tglkembali FROM tb_peminjaman WHERE kodepinjam = $kodepinjam");
  while ($row = mysqli_fetch_assoc($res)){
    $username = $row['namauserpinjam'];
    $datauser = mysqli_query($conn, "SELECT firstname,lastname,nim,notelp,foto FROM tb_user WHERE username='$username'") or die("Error : ".mysqli_error($conn));
    $data     = mysqli_fetch_array($datauser);
    $fn       = $data['firstname'];
    $ln       = $data['lastname'];
    $nim      = $data['nim'];
    $notelp   = $data['notelp'];
    $foto     = $data['foto'];
    $kbp      = $row['kodebarangpinjam'];
    $databarang = mysqli_query($conn, "SELECT namab, jenisb, keadaanb FROM tb_barang WHERE kodeb='$kbp'") or die("Error : ".mysqli_error($conn));
    $databarang = mysqli_fetch_array($databarang);
    $nb         = $databarang['namab'];
    $jb         = $databarang['jenisb'];
    $kb         = $databarang['keadaanb'];
?>
    <head>
      <title>Print Pinjam InvenTI - <?php echo "".$fn." ".$ln; ?> </title>
    </head>
      <h2 align="center"><strong>Form Peminjaman</strong></h2>
      <h3 align="center"><strong>Himpunan Mahasiswa Jurusan Teknik Informatika<br>Universitas Negeri Surabaya</strong></h3>
      <div align="center">
        <table width="710" border="0"> 
          <tr>
            <td width="704">Kepada : Yth. Pengurus HIMTI</td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Di Tempat</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Yang Bertanda Tangan Dibawah Ini :</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <p>
          <input type="hidden" value="<?php echo $kodepinjam ?>" name="id"/>
        </p>
      </div>
      <div align="center">
        <table width="406" border="0">
        <tr>
          <td width="119">Nama</td>
          <td width="10">:</td>
          <td width="268"><?php echo "".$fn." ".$ln; ?></td>
        </tr>
        <tr>
          <td>No Induk</td>
          <td>:</td>
          <td><?php echo $nim ?></td>
        </tr>
        <tr>
          <td>No Telp</td>
          <td>:</td>
          <td><?php echo $notelp ?></td>
        </tr>
        <tr>
          <td>Tanggal Pinjam</td>
          <td>:</td>
          <td><?php echo $row['tglpinjam'] ?></td>
        </tr>
        <tr>
          <td>Tanggal Kembali</td>
          <td>:</td>
          <td><?php echo $row['tglkembali'] ?></td>
        </tr>
        <tr>
          <td>Kode Barang</td>
          <td>:</td>
          <td><?php echo $row['kodebarangpinjam'] ?></td>
        </tr>
        <tr>
          <td>Nama Barang</td>
          <td>:</td>
          <td><?php echo $nb ?></td>
        </tr>
        <tr>
          <td>Jenis Barang</td>
          <td>:</td>
          <td><?php echo $jb ?></td>
        </tr>
        <tr>
          <td>Keadaan Barang</td>
          <td>:</td>
          <td><?php echo $kb ?></td>
        </tr>
      </table>
        <p>&nbsp;</p>
        <table width="710" border="0">
          <tr>
            <td colspan="2">Mengajukan Permohonan Peminjaman alat untuk keperluan . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .</td>
          </tr>
          <tr>
            <td colspan="2"> . . . . . . . . . . . . . . . . Dengan Ini alat yang telah di tuliskan diatas.</td>
          </tr>
          <tr>
            <td colspan="2">Saya Bersedia Memperbaiki atau mengganti alat alat diatas jika terjadi kerusakan maupun kehilangan.</td>
          </tr>
          <tr>
            <td width="704">&nbsp;</td>
            <td width="704">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="right"></div></td>
            <td><div align="center">Surabaya, <?php echo date('Y / M / d H:i:s') ?> </div></td>
          </tr>
          <tr>
            <td><div align="center">Pengurus HIMTI        </div></td>
            <td><div align="center">Pemohon  </div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="center">..................................</div></td>
            <td><div align="center"><?php echo "".$fn." ".$ln ?></div></td>
          </tr>
          <tr>
            <td><div align="left" style="margin-left:3.5em">NIM :</div></td>
            <td><div align="center">NIM : <?php echo $nim ?></div></td>
          </tr>
        </table>
      </div>
<?php
  } 
?>