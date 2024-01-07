<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_ktp = $_POST['no_ktp'];
        $no_hp = $_POST['no_hp'];
        $no_rm_aknir = "00";

        $currentYear = date('Y');
        $currentMonth = date('m');
        
        $jumlah_pasien = "SELECT COUNT(*) from pasien";
        
        $result = $mysqli->query($jumlah_pasien);
        
        if ($result) {
            // Ambil hasil query
            $row = $result->fetch_assoc();
            $jumlah_pasien = $row['COUNT(*)'];
        
            // Periksa jumlah pasien untuk menentukan nomor RM akhir
            if ($jumlah_pasien < 9) {
                $no_rm_aknir = "00";
            } else if ($jumlah_pasien < 99) {
                $no_rm_aknir = "0";
            } else {
                $no_rm_aknir = "";
            }
        
            // Gabungkan string untuk mendapatkan nomor RM akhir
            $final_rm = $currentYear . $currentMonth . "-" . $no_rm_aknir . $jumlah_pasien + 1;
        } else {
            echo "Error executing query: " . $conn->error;
        }
        
        $no_rm = $final_rm;
        
        $query = "SELECT * FROM pasien WHERE no_ktp = '$no_ktp'";
        $result = $mysqli->query($query);
        
        if ($result->num_rows == 0) {
            $insert_query = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES ('$nama', '$alamat', '$no_ktp','$no_hp', '$no_rm')";
            if (mysqli_query($mysqli, $insert_query)) {
                echo "<script>
                document.location='index.php?page=suksesDaftar&no_ktp=$no_ktp';
                </script>";
            } else {
                $error = "Pendaftaran gagal";
            }
        } else {
            $error = "No KTP ini sudah terdaftar!";
        }
    }
?>
<div class="container mt-5" style="Margin-Bottom: 50px">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center" style="font-weight: bold; font-size: 32px;">Daftar</div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=registerPasien">
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
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" class="form-control" required placeholder="Masukkan alamat anda">
                        </div>
                        </br>
                        <div class="form-group">
                            <label for="no_ktp">No KTP</label>
                            <input type="text" name="no_ktp" class="form-control" required placeholder="Masukkan nomor KTP anda">
                        </div>
                        </br>
                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input type="text" name="no_hp" class="form-control" required placeholder="Masukkan nomor HP anda">
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