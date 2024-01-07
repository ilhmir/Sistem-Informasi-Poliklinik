<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['nip'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginDokter");
    exit;
}

if (isset($_POST['simpan'])) {    
        $dokter_id = mysqli_query($mysqli, "SELECT * FROM dokter WHERE nama = '". $_SESSION['nip'] ."'");
        $row = mysqli_fetch_array($dokter_id);
        $id_dokter = $row['id'];
        mysqli_query($mysqli, "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai, status) 
                                                    VALUES (
                                                        '" . $id_dokter . "',
                                                        '" . $_POST['hari'] . "',
                                                        '" . $_POST['mulai'] . "',
                                                        '" . $_POST['selesai'] . "',
                                                        '". "Tidak Aktif" ."'
                                                    )");

    echo "<script> 
        document.location='index.php?page=jadwal';
    </script>";
}

?>
<h2 class="row mt-5" style="margin-left: 5px">Periksa</h2>
<br>
<div class="container">
    <!--Form Input Data-->

    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <div class="row">
            <label for="inputHari" class="form-label fw-bold">
                Hari
            </label>
            <div>
                <select class="form-control" name="hari" id="inputHari">
                    <option>Pilih Hari: </option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                </select>
            </div>
        </div>
        </br>
        <div class="row mt-1">
            <label for="inputMulai" class="form-label fw-bold">
                Mulai
            </label>
            <div>
                <input type="time" class="form-control" name="mulai" id="inputMulai" placeholder="Mulai">
            </div>
        </div>
        </br>
        <div class="row mt-1">
            <label for="inputSelesai" class="form-label fw-bold">
                Selesai
            </label>
            <div>
                <input type="time" class="form-control" name="selesai" id="inputSelesai" placeholder="Selesai">
            </div>
        </div>
        </br>
        <div class="row mt-3">
            <div class=col>
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
                 <td>
                     <a class="btn btn-danger rounded-pill px-3 mt-auto" href="index.php?page=jadwal">Batal</a>
                 </td>
            </div>
        </div>
    </form>
</div>