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
    mysqli_query($mysqli, "UPDATE jadwal_periksa SET 
                                   hari = '" . $_POST['hari'] . "',
                                   jam_mulai = '" . $_POST['mulai'] . "',
                                   jam_selesai = '" . $_POST['selesai'] . "',
                                   status = '" . $_POST['status'] . "'
                                   WHERE
                                   id = '" . $_GET['id'] . "'");

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
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $id = '';
        $hari = '';
        $mulai = '';
        $selesai = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa WHERE id = '" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $hari = $row['hari'];
                $mulai = $row['jam_mulai'];
                $selesai = $row['jam_selesai'];
                $status = $row['status'];
            }
        ?>
            <input type="hidden" names="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="row">
            <label for="inputHari" class="form-label fw-bold">
                Hari
            </label>
            <div>
                <select class="form-control" name="hari" id="inputHari">
                    <option value="<?php echo $hari ?>">Hari saat ini: <?php echo $hari ?></option>
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
                <input type="time" class="form-control" name="mulai" id="inputMulai" placeholder="Mulai" value="<?php echo $mulai ?>">
            </div>
        </div>
        </br>
        <div class="row mt-1">
            <label for="inputSelesai" class="form-label fw-bold">
                Selesai
            </label>
            <div>
                <input type="time" class="form-control" name="selesai" id="inputSelesai" placeholder="Selesai" value="<?php echo $selesai ?>">
            </div>
        </div>
        </br>
         <div class="row">
            <label for="inputStatus" class="form-label fw-bold">
                Status
            </label>
            <div>
                <select class="form-control" name="status" id="inputStatus">
                    <option value="<?php echo $status ?>">Status saat ini: <?php echo $status ?></option>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
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