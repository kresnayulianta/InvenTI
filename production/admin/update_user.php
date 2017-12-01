<?php
    include '../db/koneksi.php';
    
    //menangkap parameter yang dikirimkan dari form_updateuser.php
    $username = $_POST["username"];
    $result = mysqli_query($conn, "SELECT password,foto FROM tb_user WHERE username='$username'");
    $dataa = mysqli_fetch_array($result);
    $foto = $dataa['foto'];
    $pass = $dataa['password'];

    $ufn      = $_POST['ufn'];
    $ufn      = strtolower($ufn);
    $ufn      = ucwords($ufn);

    $uln      = $_POST['uln'];
    $uln      = strtolower($uln);
    $uln      = ucwords($uln);

    $nim      = $_POST['nim'];
    $notelp   = $_POST['notelp'];
    $hakakses = $_POST['hakakses'];

    if(isset($_POST['ubah_password'])){
        $pass    = md5($_POST['pass']);
    }
    
    if(isset($_POST['ubah_foto'])){
        // get uploaded file name
        if(is_file("../images/".$foto)){ // Jika foto ada
            unlink("../images/".$foto);// Hapus foto yang telah diupload dari folder images
        } 

        $image = $_FILES['uploadfoto']['name'];
        
        if( empty( $image ) ) {
            echo "<script> alert('File is empty, please select image to upload.')</script>";
        } else if($_FILES['uploadfoto']['type'] == "application/msword") {
            echo "<script> alert('Invalid image type, use (e.g. png, jpg, gif).')</script>";
        } else if( $_FILES['uploadfoto']['error'] > 0 ) {
            echo "<script> alert('Oops sorry, seems there is an error uploading your image, please try again later.'.$_FILES[uploadfoto][error])</script>";
        } else {
                    
            // strip file slashes in uploaded file, although it will not happen but just in case 
            $filename = stripslashes( $_FILES['uploadfoto']['name'] );
            $tmp = explode( ".", $filename );
            $ext = end($tmp);
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

                $queryfoto = mysqli_query($conn, "UPDATE tb_user SET firstname ='$ufn', lastname ='$uln', password ='$pass', nim ='$nim', notelp ='$notelp', foto ='$new_name' hakakses='$hakakses' WHERE username='$username'");
                if($queryfoto){
                  echo "<script> alert('Username telah terupdate. Terima Kasih.')
                  window.location='data_user_admin.php';</script>";
                }
            }
        }
    }
    
    $query = mysqli_query($conn, "UPDATE tb_user SET firstname ='$ufn', lastname ='$uln', password ='$pass', nim ='$nim', notelp ='$notelp',  hakakses='$hakakses' WHERE username='$username'");
    if($query){
        echo "<script> alert('Username telah terupdate. Terima Kasih.')
            window.location='data_user_admin.php';</script>";
        }
    $conn->close();
?>