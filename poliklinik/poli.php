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
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE poli SET 
                                            nama_poli = '" . $_POST['nama_poli'] . "',
                                            keterangan = '" . $_POST['keterangan'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO poli (nama_poli, keterangan) 
                                            VALUES (
                                                '" . $_POST['nama_poli'] . "',
                                                '" . $_POST['keterangan'] . "'
                                            )");
    }
    echo "<script> 
                document.location='index.php?page=poli';
                </script>";
}   
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM poli WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
                document.location='index.php?page=poli';
                </script>";
}
?>
<h2 class="row mt-5" style="margin-left: 5px">Poliklinik</h2>
<br>
<div class="container"  style="Margin-Bottom: 50px">
    <!--Form Input Data-->

    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $nama_poli = '';
        $keterangan = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM poli 
                    WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama_poli = $row['nama_poli'];
                $kemasan = $row['keterangan'];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="row">
            <label for="inputNama" class="form-label fw-bold">
                Poliklinik
            </label>
            <div>
                <input type="text" class="form-control" name="nama_poli" id="inputNama" placeholder="Poliklinik" value="<?php echo $nama_poli ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputKemasan" class="form-label fw-bold">
                Keterangan
            </label>
            <div>
                <input type="text" class="form-control" name="keterangan" id="inputKemasan" placeholder="Keterangan" value="<?php echo $keterangan ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class=col>
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
            </div>
        </div>
    </form>
    <br>
    <br>
    <!-- Table-->
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Poliklinik</th>
                <th scope="col">Keterangan</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT * FROM poli");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama_poli'] ?></td>
                    <td><?php echo $data['keterangan'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=poli&id=<?php echo $data['id'] ?>">Ubah</a>
                    </td>
                    <td>
                        <a class="btn btn-danger rounded-pill px-3" href="index.php?page=poli&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>