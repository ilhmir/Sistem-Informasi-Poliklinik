<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['nip'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginDokter");
    exit;
}
?>

<h2 class="row mt-5" style="margin-left: 5px">Jadwal Periksa</h2>
<br>
<!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
<?php
$dokter_id = mysqli_query($mysqli, "SELECT * FROM dokter WHERE nama = '". $_SESSION['nip'] ."'");
$row = mysqli_fetch_array($dokter_id);

?>
<td>
    <a class="btn btn-success px-3" href="index.php?page=tambahJadwal&id=<?php echo $row['id'] ?>">+ Tambah Jadwal</a>
</td>
<br>
<!-- Table-->
<table class="table table-hover">
    <!--thead atau baris judul-->
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Hari</th>
            <th scope="col">Mulai</th>
            <th scope="col">Selesai</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <!--tbody berisi isi tabel sesuai dengan judul atau head-->
    <tbody>
        <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
        <?php
        $dokter_id = mysqli_query($mysqli, "SELECT * FROM dokter WHERE nama = '". $_SESSION['nip'] ."'");
        $row = mysqli_fetch_array($dokter_id);
        $id_dokter = $row['id'];
        $result = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa WHERE id_dokter = '$id_dokter'");
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <th scope="row"><?php echo $no++ ?></th>
                <td><?php echo $data['hari'] ?></td>
                <td><?php echo $data['jam_mulai'] ?></td>
                <td><?php echo $data['jam_selesai'] ?></td>
                <td><?php echo $data['status'] ?></td>
                <td>
                    <a class="btn btn-success rounded-pill px-3" href="index.php?page=editJadwal&id=<?php echo $data['id'] ?>">Ubah</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>