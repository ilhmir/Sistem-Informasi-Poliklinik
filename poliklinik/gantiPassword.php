<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    
    if (!isset($_SESSION['username'])) {
        // Jika pengguna sudah login, tampilkan tombol "Logout"
        header("Location: index.php?page=loginUser");
        exit;
    }

    if (isset($_POST['simpan'])) { 
       // $password = $_POST['password'];
       $nama = $_POST['nama'];
       $nip = $_POST['nip'];
       $password = $_POST['password'];
       $confirm_password = $_POST['confirm_password'];

       if ($password === $confirm_password) {
           $hashed_password = password_hash($password, PASSWORD_DEFAULT);
           
           $insert_query = "UPDATE dokter SET 
                                       password = '" . $hashed_password . "'
                                       WHERE
                                       nip = '" . $_POST['nip'] . "'";
           if (mysqli_query($mysqli, $insert_query)) {
               echo "<script>
               alert('Pendaftaran Berhasil'); 
               document.location='index.php?page=dokter';
               </script>";
           } else {
               $error = "Pendaftaran gagal";
           }
       } else {
           $error = "Password tidak cocok";
       }
    }  
?>

<h2 class="row mt-5" style="margin-left: 5px">Dokter</h2>
<br>
<div class="container"  style="Margin-Bottom: 50px">
    <!--Form Input Data-->

    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $nama = '';
        $alamat = '';
        $no_hp = '';
        $nip = '';
        $password = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM dokter 
                    WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama = $row['nama'];
                $alamat = $row['alamat'];
                $no_hp = $row['no_hp'];
                $id_poli = $row['id_poli'];
                $nip = $row['nip'];
                $password = $row['password'];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="row">
            <label for="inputNama" class="form-label fw-bold">
                Nama
            </label>
            <div>
                <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama Dokter" value="<?php echo $nama ?>">
            </div>
        </div>
        <div class="row mt-3">
            <label for="inputNIP" class="form-label fw-bold">
                NIP
            </label>
            <div>
                <input type="text" class="form-control" name="nip" id="inputNIP" placeholder="NIP" value="<?php echo $nip ?>">
            </div>
        </div>  
        </br>
         <div class="row mt-3">
             <label for="password" class="form-label fw-bold">Password</label>
             <div>
                <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
             </div>
         </div>
         </br>
         <div class="row mt-3" class="form-label fw-bold">
             <label for="confirm_password" class="form-label fw-bold">Confirm Password</label>
             <div>
                <input type="password" name="confirm_password" class="form-control" required placeholder="Masukkan password konfirmasi">
             </div>
         </div>
        <div class="row mt-3">
            <div class=col>
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
                <td>
                    <a class="btn btn-danger rounded-pill px-3 mt-auto" href="index.php?page=dokter">Batal</a>
                </td>
            </div>
        </div>
    </form>
</div>