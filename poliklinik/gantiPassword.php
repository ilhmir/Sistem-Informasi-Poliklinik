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
    $dokterId = $_GET['id'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $query = "SELECT * FROM dokter WHERE id = $dokterId";
        $result = $mysqli->query($query);

        if ($result === false) {
            die("Query error: " . $mysqli->error);
        }

        if ($result->num_rows == 0) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $update_query = "UPDATE dokter SET 
                                         nama = '" . $_POST['nama'] . "',
                                         alamat = '" . $_POST['alamat'] . "',
                                         no_hp = '" . $_POST['no_hp'] . "',
                                         id_poli = '" . $_POST['id_poli'] . "',
                                         nip = '" . $_POST['nip'] . "',
                                         password = '". $hashed_password ."'
                                         WHERE
                                         id = '" . $_GET['id'] . "'";
            if (mysqli_query($mysqli, $update_query)) {
                
            } else {
                $error = "Update gagal";
            }
        }
    } else {
        $error = "Password tidak cocok";
    }
}

?>
<h2 class="row mt-5" style="margin-left: 5px">Ganti Password</h2>
<br>
<div class="container">
    <!--Form Input Data-->
    
    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $id = '';
        $nama = '';
        $alamat = '';
        $no_hp = '';
        $id_poli = '';
        $nip = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM dokter
                    WHERE id = '" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama = $row['nama'];
                $alamat = $row['alamat'];
                $no_hp = $row['no_hp'];
                $id_poli = $row['id_poli'];
                $nip = $row['nip'];
            }
        ?>
            <input type="hidden" names="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="row">
            <label for="inputNama" class="form-label fw-bold">
                Nama
            </label>
            <div>
                <input readonly type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama" value="<?php echo $nama ?>">
            </div>
        </div>
        </br>
        <div class="row mt-3">
            <label for="alamat" class="form-label fw-bold">
                Alamat
            </label>
            <div>
                <input readonly type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat ?>">
            </div>
        </div>
        </br>
        <div class="row mt-3">
            <label for="no_hp" class="form-label fw-bold">
                No HP
            </label>
            <div>
                <input readonly type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No HP" value="<?php echo $no_hp ?>">
            </div>
        </div>
        </br>
        <div class="row mt-3">
            <label for="id_poli" class="form-label fw-bold">
                ID Poli
            </label>
            <div>
                <input readonly type="text" class="form-control" name="id_poli" id="id_poli" placeholder="ID Poli" value="<?php echo $id_poli ?>">
            </div>
        </div>
        </br>
        <div class="row mt-3">
            <label for="inputNIP" class="form-label fw-bold">
                NIP
            </label>
            <div>
                <input readonly type="text" class="form-control" name="nip" id="inputNIP" placeholder="NIP" value="<?php echo $nip ?>">
            </div>
        </div>
        </br>
        <div class="row mt-3">
            <label for="password" class="form-label fw-bold">
                Password
            </label>
            <div>
                <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password baru anda">
            </div>
        </div>
        </br>
        <div class="row mt-3">
            <label for="confirm_password" class="form-label fw-bold">
                Confrim Password
            </label>
            <div>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Masukkan ulang password baru anda">
            </div>
        </div>
        <div class="row mt-3">
            <div class=col>
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
                <button class="btn btn-primary rounded-pill px-3 mt-auto"  href="index.php?page=periksa">Batal</button>
            </div>
        </div>
    </form>
</div>