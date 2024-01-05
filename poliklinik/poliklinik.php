<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $keluhan = $_POST['keluhan'];
        $pasienId = $_POST['no_rm'];
        $jadwalId = $_POST['id_jadwal'];
        
        $idPasien = mysqli_query($mysqli, "SELECT * FROM pasien WHERE no_rm = '$pasienId'");
        $pasien = mysqli_fetch_assoc($idPasien);
        
        $jadwal_id = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa WHERE id = '$jadwalId'");
        $jadwal = mysqli_fetch_assoc($jadwal_id);
        
        $jumlah_pasien = "SELECT COUNT(*) from daftar_poli";
        
        $result = $mysqli->query($jumlah_pasien);
        
        if ($result) {
            // Ambil hasil query
            $row = $result->fetch_assoc();
            $jumlah_pasien = $row['COUNT(*)'];
        
            // Gabungkan string untuk mendapatkan nomor RM akhir
            $total_antrian = $jumlah_pasien;
        } else {
            echo "Error executing query: " . $conn->error;
        }
        
        $antrian = $total_antrian + 1;
        
        mysqli_query($mysqli, "INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan, no_antrian) 
                                                        VALUES (
                                                            '" . $pasien['id'] . "',
                                                            '" . $jadwal['id'] . "',
                                                            '" . $keluhan . "',
                                                            '" . $antrian . "'
                                                        )");
    }
?>
<div class="container mt-5" style="Margin-Bottom: 50px">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header text-center" style="font-weight: bold; font-size: 32px;">Daftar</div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=poliklinik">
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
                            <label for="no_rm"  class="form-label fw-bold">No RM</label>
                            <input type="text" name="no_rm" class="form-control" required placeholder="Masukkan nomor Rekam Medis anda">
                        </div>
                        </br>
                        <div class="row">
                            <label for="id_poli" class="form-label fw-bold">Poliklinik:</label>
                            <div class="row ml-1" style="margin-left: 1px;">
                                <select name="id_poli" id="id_poli">
                                    <?php
                                    // Loop untuk mengisi dropdown dengan data dari tabel poli
                                    //$poli = mysqli_query($mysqli, "SELECT * FROM poli");
                                    $poli = mysqli_query($mysqli, "SELECT * FROM poli");                                   
                                    while ($rows = mysqli_fetch_assoc($poli)) {
                                         echo "<option value='{$rows['id']}' >{$rows['nama_poli']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div> 
                        </br>
                        <div class="row">
                            <label for="id_poli" class="form-label fw-bold">Dokter:</label>
                            <div class="row ml-1" style="margin-left: 1px;">
                                <select name="id_jadwal" id="id_jadwal">                                   
                                    <option>Pilih Dokter</option>  
                                </select>
                            </div>
                        </div>
                        </br>
                        <div class="form-group">
                            <label for="keluhan"  class="form-label fw-bold">Keluhan</label>
                            <textarea name="keluhan" class="form-control" rows="5" required placeholder="Keluhan"></textarea>
                        </div>
                        </br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                        </div>                       
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <!-- Table-->
            <table class="table table-hover">
                <!--thead atau baris judul-->
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Poliklinik</th>
                        <th scope="col">Dokter</th>
                        <th scope="col">Jadwal</th>
                        <th scope="col">Antrian</th>
                    </tr>
                </thead>
                <!--tbody berisi isi tabel sesuai dengan judul atau head-->
                <tbody>
                    <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
                    <?php
                    $result = mysqli_query($mysqli, "SELECT daftar_poli.*, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter,
                                                     jadwal_periksa.hari AS hari, jadwal_periksa.jam_mulai AS mulai,
                                                     jadwal_periksa.jam_selesai AS selesai, poli.nama_poli AS nama_poli FROM pasien, 
                                                     jadwal_periksa, dokter, poli INNER JOIN daftar_poli WHERE 
                                                     pasien.id = daftar_poli.id_pasien && jadwal_periksa.id_dokter = dokter.id 
                                                     && jadwal_periksa.id = daftar_poli.id_jadwal && poli.id = dokter.id_poli");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $no++ ?></th>
                            <td><?php echo $data['nama_pasien'] ?></td>
                            <td><?php echo $data['nama_poli'] ?></td>
                            <td><?php echo $data['nama_dokter'] ?></td>
                            <td><?php echo $data['hari'] . ', '. $data['mulai'] . ' - ' . $data['selesai'] ?></td>
                            <td><?php echo $data['no_antrian'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
      document.getElementById('id_poli').addEventListener('change', function() {
         var selectedPoli = this.value;
 
         // Buat objek XMLHttpRequest
         var xhr = new XMLHttpRequest();
 
         // Tentukan metode, URL, dan apakah permintaan bersifat asynchronous
         xhr.open('GET', 'get_jadwal.php?poli_id=' + selectedPoli, true);
         
         console.log(xhr);
 
         //atur header agar respon diharapkan html
         xhr.setRequestHeader('Content-Type', 'text/html');
 
         // Tambahkan fungsi callback untuk menangani respons
         xhr.onload = function() {
             if (xhr.status === 200) {
                 // Perbarui elemen select Dokter dan Jadwal dengan data yang diterima dari server
                 document.getElementById('id_jadwal').innerHTML = xhr.responseText;
             }
         };
 
         // Kirim permintaan
         xhr.send();
     });
</script> 