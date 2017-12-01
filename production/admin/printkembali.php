<?php
  include '../db/koneksi.php';
  date_default_timezone_set('Asia/Jakarta');
  $kodekembali = $_GET['kodekembali'];
  $res = mysqli_query($conn,"SELECT kodekembali, kodepinjam, kondisibarangk, tglkembali FROM tb_kembali WHERE kodekembali = '$kodekembali'") or die("Error : ".mysqli_error($conn));
  while ($row = mysqli_fetch_assoc($res)){
    $kk   = $row['kodekembali'];    // kodekembali
    $kp   = $row['kodepinjam'];     // kodepinjam
    $kbk  = $row['kondisibarangk']; // kondisi barang kembali
    $tk   = $row['tglkembali'];     // tanggal kembali

    $qtp  = mysqli_query($conn,"SELECT kodebarangpinjam, namauserpinjam, tglpinjam, tglkembali FROM tb_peminjaman WHERE kodepinjam='$kp'") or die("Error : ".mysqli_error($conn)); //query untuk mengambil data di tb_peminjaman
    $dtp  = mysqli_fetch_array($qtp);
    $tp_kbp = $dtp['kodebarangpinjam']; // tabel peminjaman_kodebarangpinjam
    $tp_nup = $dtp['namauserpinjam'];   // tabel peminjaman_namauserpinjam
    $tp_tp  = $dtp['tglpinjam'];        // tabel peminjaman_tglpinjam
    $tp_tk  = $dtp['tglkembali'];       // tabel peminjaman_tglkembali

    $qtu  = mysqli_query($conn,"SELECT firstname, lastname, nim, notelp, foto FROM tb_user WHERE username='$tp_nup'") or die("Error : ".mysqli_error($conn)); //query untuk mengambil data di tb_user
    $dtu  = mysqli_fetch_array($qtu);
    $tu_fn  = $dtu['firstname'];   // tabel user first name
    $tu_ln  = $dtu['lastname'];    // tabel user last name
    $tu_nim = $dtu['nim'];        // tabel user nim
    $tu_nt  = $dtu['notelp'];      // tabel user no telp
    $tu_f   = $dtu['foto'];         // tabel user foto
    
    $qtb  = mysqli_query($conn,"SELECT namab, jenisb FROM tb_barang WHERE kodeb='$tp_kbp'") or die("Error : ".mysqli_error($conn)); //query untuk mengambil data di tb_peminjaman
    $dtb = mysqli_fetch_array($qtb);
    $tb_nb = $dtb['namab'];     // tabel peminjaman_kodebarangpinjam
    $tb_jb = $dtb['jenisb'];    // tabel peminjaman_namauserpinjam

    //$sh = $tk->diff($tp_tk); // selisih hari
    //$sh = ((abs(strtotime ($tk) - strtotime ($tp_tk)))/(60*60*24));
    
    $tp_tkX = explode("-", $tp_tk);
    $tkX    = explode("-", $tk);
    $date1  = mktime(0, 0, 0, $tp_tkX[1],$tp_tkX[2],$tp_tkX[0]);
    $date2  = mktime(0, 0, 0, $tkX[1],$tkX[2],$tkX[0]);
    $sh     = ($date2-$date1) / (3600*24);
    if($sh == 0){
      $denda=0;
    }else {
      $denda = 500*$sh;
    }
    $denda = number_format($denda, 2, ',', '.');
?>
    <head>
      <title>Print Pengembalian InvenTI - <?php echo "".$tu_fn." ".$tu_ln; ?> </title>
    </head>
      <h2 align="center"><strong>Form Pengembalian</strong></h2>
      <h3 align="center"><strong>Himpunan Mahasiswa Jurusan Teknik Informatika<br>Universitas Negeri Surabaya</strong></h3>
      <div align="center">
        <table width="710" border="0"> 
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
        <table width="450" border="0">
        <tr>
          <td width="119">Nama</td>
          <td width="10">:</td>
          <td width="268"><?php echo "".$tu_fn." ".$tu_ln; ?></td>
        </tr>
        <tr>
          <td>No Induk</td>
          <td>:</td>
          <td><?php echo $tu_nim ?></td>
        </tr>
        <tr>
          <td>No Telp</td>
          <td>:</td>
          <td><?php echo $tu_nt ?></td>
        </tr>
        <tr>
          <td>Tanggal Pinjam</td>
          <td>:</td>
          <td><?php echo $tp_tp ?></td>
        </tr>
        <tr>
          <td>Tanggal Kembali</td>
          <td>:</td>
          <td><?php echo $tp_tk ?></td>
        </tr>
        <tr>
          <td>Tanggal Di Kembalikan</td>
          <td>:</td>
          <td><?php echo $tk ?></td>
        </tr>
        <tr>
          <td>Kode Barang</td>
          <td>:</td>
          <td><?php echo $tp_kbp ?></td>
        </tr>
        <tr>
          <td>Nama Barang</td>
          <td>:</td>
          <td><?php echo $tb_nb ?></td>
        </tr>
        <tr>
          <td>Jenis Barang</td>
          <td>:</td>
          <td><?php echo $tb_jb ?></td>
        </tr>
      </table>
        <p>&nbsp;</p>
        <table width="710" border="0">
          <tr>
            <td colspan="2">Mengajukan Permohonan Pengembalian alat dengan kondisi : <?php echo $kbk ?></td>
          </tr>
          <tr>
            <td colspan="2">Denda : Rp <?php echo "".$denda?></td>
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
            <td><div align="center">Surabaya, <?php echo $tk ?> </div></td>
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
            <td><div align="center"><?php echo "".$tu_fn." ".$tu_ln ?></div></td>
          </tr>
          <tr>
            <td><div align="left" style="margin-left:3.5em">NIM :</div></td>
            <td><div align="center">NIM : <?php echo $tu_nim ?></div></td>
          </tr>
        </table>
      </div>
<?php
  } 
?>