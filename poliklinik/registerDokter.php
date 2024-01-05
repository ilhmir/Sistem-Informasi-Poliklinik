<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_hp = $_POST['no_hp'];
        $nip = $_POST['nip'];
        $id_poli = $_POST['id_poli'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password === $confirm_password) {
            $query = "SELECT * FROM dokter WHERE nip = '$nip'";
            $result = $mysqli->query($query);

            if ($result === false) {
                die("Query error: " . $mysqli->error);
            }

            if ($result->num_rows == 0) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $insert_query = "INSERT INTO dokter (nama, nip, alamat, no_hp, id_poli,password) VALUES ('$nama', '$nip', '$alamat', '$no_hp', '$id_poli','$hashed_password')";
                if (mysqli_query($mysqli, $insert_query)) {
                    echo "<script>
                    alert('Pendaftaran Berhasil'); 
                    document.location='index.php?page=dokter';
                    </script>";
                } else {
                    $error = "Pendaftaran gagal";
                }
            } else {
                $error = "NIP sudah ada!";
            }
        } else {
            $error = "Password tidak cocok";
        }
    }
?>
<div class="container mt-5" style="Margin-Bottom: 50px">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center" style="font-weight: bold; font-size: 32px;">Daftar</div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=registerDokter">
                        <?php
                        if (isset($error)) {
                            echo '<div class="alert alert-danger">' . $error . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                        }
                        ?>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama anda">
                        </div>
                        </br>
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" name="nip" class="form-control" required placeholder="Masukkan nama anda">
                        </div>
                        </br>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" class="form-control" required placeholder="Masukkan nama anda">
                        </div>
                        </br>
                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input type="text" name="no_hp" class="form-control" required placeholder="Masukkan nama anda">
                        </div>
                        </br>
                        <div class="row mt-1">
                            <label for="id_poli" class="form-label fw-bold">Pilih Poliklinik:</label>
                            <div class="row ml-1" style="margin-left: 1px;">
                                <select name="id_poli" id="id_poli">
                                    <?php
                                    // Loop untuk mengisi dropdown dengan data dari tabel poli
                                    $poli = mysqli_query($mysqli, "SELECT * FROM poli");
                                    while ($rows = mysqli_fetch_assoc($poli)) {
                                         echo "<option value='{$rows['id']}' >{$rows['nama_poli']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>  
                        </br>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
                        </div>
                        </br>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" required placeholder="Masukkan password konfirmasi">
                        </div>
                        </br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>