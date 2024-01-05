<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['nip'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginDokter");
    exit;
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'update') {
         $id_dapol = $_GET['id_dapol'];
         $id_periksa = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id_daftar_poli = '$id_dapol'");
         $row = mysqli_fetch_assoc($id_periksa);
         
          mysqli_query($mysqli, "INSERT INTO detail_periksa (id_periksa, id_obat) 
                                                         VALUES (
                                                             '" . $row['id'] . "',
                                                             '" . $_GET['id_obat'] . "'
                                                         )");
    }
    
     echo "<script> 
        document.location='index.php?page=periksa';
    </script>";
}
?>
<h2 class="row mt-5" style="margin-left: 5px">Daftar Periksa</h2>
<br>
<!-- Table-->
<table class="table table-hover">
    <!--thead atau baris judul-->
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">No Antrian</th>
            <th scope="col">Nama Pasien</th>
            <th scope="col">Keluhan</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <!--tbody berisi isi tabel sesuai dengan judul atau head-->
    <tbody>
        <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
        <?php
        $result = mysqli_query($mysqli, "SELECT daftar_poli.*, pasien.nama AS nama, dokter.nip AS nip, jadwal_periksa.id_dokter AS id_dokter FROM pasien, dokter, jadwal_periksa INNER JOIN daftar_poli WHERE id_pasien = pasien.id && jadwal_periksa.id_dokter = dokter.id && id_jadwal = jadwal_periksa.id && dokter.nama = '". $_SESSION['nip'] ."'");
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <th scope="row"><?php echo $no++ ?></th>
                <td><?php echo $data['no_antrian'] ?></td>
                <td><?php echo $data['nama'] ?></td>
                <td><?php echo $data['keluhan'] ?></td>
                <td>
                    <a class="btn btn-success rounded-pill px-3" href="index.php?page=editPeriksa&id=<?php echo $data['id'] ?>">Ubah</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>