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
    $id_daftar_polis = $_POST['id'];
    $id_obat = $_POST['id_obat'];
    
    //Ambil biaya
    $biaya = mysqli_query($mysqli, "SELECT * FROM obat WHERE id = '$id_obat'");
    $rows = mysqli_fetch_assoc($biaya);
    
    mysqli_query($mysqli, "INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa) 
                                                VALUES (
                                                    '" . $_POST['id'] . "',
                                                    '" . $_POST['tgl_periksa'] . "',
                                                    '" . $_POST['catatan'] . "',
                                                    '" . $rows['harga'] + 150000 . "'
                                                )");

    echo "<script> 
        document.location='index.php?page=periksa&id_obat=$id_obat&aksi=update&id_dapol=$id_daftar_polis';
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
        $nama_pasien = '';
        $catatan = '';
        $obat = '';
        $tgl_periksa = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT daftar_poli.*, pasien.nama AS nama FROM pasien INNER JOIN daftar_poli
                    WHERE id_pasien = pasien.id && daftar_poli.id = '" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama_pasien = $row['nama'];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="row">
            <label for="inputNama" class="form-label fw-bold">
                Nama Pasien
            </label>
            <div>
                <input readonly type="text" class="form-control" name="nama_pasien" id="inputNama" placeholder="Nama" value="<?php echo $nama_pasien ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputKemasan" class="form-label fw-bold">
                Catatan
            </label>
            <div>
                <input type="text" class="form-control" name="catatan" id="inputCatatan" placeholder="Catatan" value="<?php echo $catatan ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="id_poli" class="form-label fw-bold">Pilih Obat:</label>
            <div class="row ml-1" style="margin-left: 1px;">
                <select name="id_obat" id="id_obat">
                    <?php
                    // Loop untuk mengisi dropdown dengan data dari tabel poli
                    $obat = mysqli_query($mysqli, "SELECT * FROM obat");
                    while ($rows = mysqli_fetch_assoc($obat)) {
                         echo "<option value='{$rows['id']}' >{$rows['nama_obat']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputTanggal" class="form-label fw-bold">
                Tanggal Periksa
            </label>
            <div>
                <input type="datetime-local" class="form-control" name="tgl_periksa" id="inputTanggal" placeholder="Tanggal Periksa" value="<?php echo $tgl_periksa ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class=col>
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
            </div>
        </div>
    </form>
</div>